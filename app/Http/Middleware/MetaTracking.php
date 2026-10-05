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
use App\Models\Address;
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
                // Make sure _fbp exists before the page renders, so the server event has it too
        $fbp = $request->cookie('_fbp') ?: ($_COOKIE['_fbp'] ?? null);
        if (!is_string($fbp) || !preg_match('/^fb\.[0-2]\.\d{10,13}\.\d+$/', $fbp)) {
            $fbp = 'fb.1.' . (int) (microtime(true) * 1000) . '.' . random_int(1000000000, 9999999999);
            $domain = str_ends_with($request->getHost(), 'aimanroyale.com') ? '.aimanroyale.com' : null;
            Cookie::queue('_fbp', $fbp, 60 * 24 * 90, '/', $domain, null, false);
            $request->cookies->set('_fbp', $fbp);
        }
        $norm = fn($v) => preg_replace('/[^\p{L}\p{N}]/u', '', mb_strtolower(trim((string) $v)));
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

            $address = Address::where('user_id', $user->id)->where('is_default', 1)->first();
           
            if ($address) {
                if (!empty($address->city))    $advancedMatching['ct'] = $norm($address->city);
                if (!empty($address->state))   $advancedMatching['st'] = $norm($address->state);
                if (!empty($address->pincode)) $advancedMatching['zp'] = $norm($address->pincode);
            }
            if (!empty($user->date_of_birth)) {
                $advancedMatching['db'] = \Carbon\Carbon::parse($user->date_of_birth)->format('Ymd');
            }
            $advancedMatching['country'] = 'in';
        } elseif ($guestId = $request->cookie('_meta_gid')) {
            $advancedMatching['external_id'] = $guestId;
            if ($v = $request->cookie('_meta_guest_ct')) $advancedMatching['ct'] = $norm($v);
            if ($v = $request->cookie('_meta_guest_st')) $advancedMatching['st'] = $norm($v);
            if ($v = $request->cookie('_meta_guest_zp')) $advancedMatching['zp'] = $norm($v);
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
                // Skip em/ph on PageView - see MetaConversionsService::trackPageView()
                $this->meta->createUserData([], includeContactInfo: false),
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
            && !$request->is('admin/*')
            && $response->getStatusCode() === 200
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html')
            && $ua !== ''
            && !preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|lighthouse|headless|pingdom|uptime|monitor|curl|wget|python|go-http|axios|pagespeed|gtmetrix/i', $ua)
            && !in_array($request->headers->get('Purpose'), ['prefetch', 'preview'], true)
            && $request->headers->get('Sec-Purpose') === null;
    }
}