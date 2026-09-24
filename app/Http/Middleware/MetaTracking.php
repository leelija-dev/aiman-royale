<?php

namespace App\Http\Middleware;

use App\Services\MetaConversionsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MetaTracking
{
    public function __construct(protected MetaConversionsService $meta) {}

    public function handle(Request $request, Closure $next): Response
    {
        // One ID per page load, shared by browser Pixel and server event
        $eventId = (string) Str::uuid();
        $request->attributes->set('meta_event_id', $eventId);
        view()->share('metaEventId', $eventId);

        // Guests: create the ID BEFORE the page renders so the browser can send it too
        if (!Auth::check() && !$request->cookie('_meta_gid')) {
            $gid = (string) Str::uuid();
            Cookie::queue('_meta_gid', $gid, 60 * 24 * 365);
            $request->cookies->set('_meta_gid', $gid);
        }

        $advancedMatching = [];
        if (Auth::check()) {
            $user = Auth::user();
            if (!empty($user->email)) $advancedMatching['em'] = $user->email;
            if (!empty($user->phone)) $advancedMatching['ph'] = $user->phone;
            if (!empty($user->name)) {
                $parts = preg_split('/\s+/', trim($user->name), 2);
                if (!empty($parts[0])) $advancedMatching['fn'] = $parts[0];
                if (!empty($parts[1])) $advancedMatching['ln'] = $parts[1];
            }
            $advancedMatching['external_id'] = (string) $user->id;
        } elseif ($guestId = $request->cookie('_meta_gid')) {
            $advancedMatching['external_id'] = $guestId;
        }
        view()->share('metaAdvancedMatching', $advancedMatching);

        return $next($request);
    }

    /** Runs after the response has been sent, so Meta latency never slows the page. */
    public function terminate(Request $request, Response $response): void
    {
        if (!$this->shouldTrack($request, $response)) {
            return;
        }

        try {
            $this->meta->sendEvent(
                'PageView',
                $this->meta->createUserData(),
                [],
                $request->attributes->get('meta_event_id')
            );
        } catch (\Throwable $e) {
            Log::error('Meta PageView failed', ['url' => $request->fullUrl(), 'error' => $e->getMessage()]);
        }
    }

    protected function shouldTrack(Request $request, Response $response): bool
    {
        $ua = (string) $request->userAgent();

        return $request->isMethod('GET')
            && !$request->ajax()
            && !$request->expectsJson()
            && $response->getStatusCode() === 200
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html')
            && $ua !== ''
            && !preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|lighthouse|headless|pingdom|uptime|monitor|curl|wget|python|go-http|axios|pagespeed|gtmetrix/i', $ua)
            && !in_array($request->headers->get('Purpose'), ['prefetch', 'preview'], true)
            && $request->headers->get('Sec-Purpose') === null;
    }
}