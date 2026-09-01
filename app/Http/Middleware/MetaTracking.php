<?php

namespace App\Http\Middleware;

use App\Services\MetaConversionsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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
        $response = $next($request);

        // Track normal successful GET page requests
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            $response->getStatusCode() === 200
        ) {
            try {

                $this->meta->sendEvent(
                    'PageView',
                    [
                        'client_ip_address' => $request->ip(),
                        'client_user_agent' => $request->userAgent(),
                    ],
                    [
                        'currency' => 'INR',
                        'value' => 0,
                    ]
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