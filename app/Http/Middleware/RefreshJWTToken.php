<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RefreshJWTToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Try to get the token from the request
            $token = JWTAuth::getToken();
            
            if ($token) {
                // Check if token is valid and refresh it
                $newToken = JWTAuth::refresh($token);
                
                // Process the request first
                $response = $next($request);
                
                // Add new token to response headers
                $response->headers->set('Authorization', 'Bearer ' . $newToken);
                
                // Also store in session for web access
                session(['jwt_token' => $newToken]);
                
                return $response;
            }
        } catch (TokenExpiredException $e) {
            // Token expired, try to refresh it
            try {
                $newToken = JWTAuth::refresh(JWTAuth::getToken());
                $response = $next($request);
                $response->headers->set('Authorization', 'Bearer ' . $newToken);
                session(['jwt_token' => $newToken]);
                return $response;
            } catch (JWTException $e) {
                // Can't refresh token, user needs to login again
                return redirect()->route('login')->with('message', 'Session expired. Please login again.');
            }
        } catch (TokenInvalidException $e) {
            // Invalid token
            return redirect()->route('login')->with('message', 'Invalid session. Please login again.');
        } catch (JWTException $e) {
            // Other JWT errors
            return redirect()->route('login')->with('message', 'Authentication error. Please login again.');
        }

        return $next($request);
    }
}