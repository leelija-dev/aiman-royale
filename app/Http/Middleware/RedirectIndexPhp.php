<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIndexPhp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getRequestUri();

        // Normalize and check for explicit index.php occurrence at the start of the path
        // Examples to catch:
        // /index.php
        // /index.php/
        // /index.php/some/route
        if (preg_match('#^/index\.php(?:/|$)#i', $path)) {
            $cleanPath = preg_replace('#^/index\.php#i', '/', $path);
            // Ensure single leading slash
            if ($cleanPath === '') {
                $cleanPath = '/';
            }
            // Build absolute URL preserving scheme/host
            $url = $request->getSchemeAndHttpHost().$cleanPath;
            return redirect()->to($url, 301);
        }

        return $next($request);
    }
}
