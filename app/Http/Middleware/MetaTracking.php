<?php

namespace App\Http\Middleware;

use App\Services\MetaConversionsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
class MetaTracking
{
    public function handle(
        Request $request,
        Closure $next,
        MetaConversionsService $meta
    ): Response {
        $response = $next($request);

        // Only track normal web page requests
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            $response->getStatusCode() === 200
        ) {
            try {
                $meta->sendEvent(
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
            } catch (\Throwable $e) {
                Log::error('Meta automatic tracking failed', [
                    'url' => $request->fullUrl(),
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $response;
    }
}