<?php

namespace App\Http\Middleware;

use App\Services\MetaConversionsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class MetaTracking
{
    protected MetaConversionsService $meta;

    public function __construct(MetaConversionsService $meta)
    {
        $this->meta = $meta;
    }

    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // First allow Laravel to process the request
        // $response = $next($request);
        // One ID shared by the browser Pixel and this server event (deduplication)
        $eventId = (string) Str::uuid();
        $request->attributes->set('meta_event_id', $eventId);
        view()->share('metaEventId', $eventId);

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
        // First allow Laravel to process the request
        $response = $next($request);
        // Track normal successful GET page requests
        // if (
        //     $request->isMethod('GET') &&
        //     !$request->ajax() &&
        //     $response->getStatusCode() === 200
        // ) {
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            $response->getStatusCode() === 200 &&
            str_contains((string) $response->headers->get('Content-Type'), 'text/html') &&
            !preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview/i', (string) $request->userAgent())
        ) {
            try {

                // $this->meta->sendEvent(
                //     'PageView',
                //     // [
                //     //     'client_ip_address' => $request->ip(),
                //     //     'client_user_agent' => $request->userAgent(),
                //     // ],
                //      $this->meta->createUserData(),
                //     [
                //         'currency' => 'INR',
                //         'value' => 0,
                //     ]
                // );
                $this->meta->sendEvent(
                    'PageView',
                    $this->meta->createUserData(),
                    [],
                    $request->attributes->get('meta_event_id')
                );

                Log::info('Meta PageView sent automatically', [
                    'url' => $request->fullUrl(),
                ]);

            } catch (\Throwable $e) {

                // Meta failure should never break the website
                Log::error('Meta PageView failed', [
                    'url' => $request->fullUrl(),
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $response;
    }
}