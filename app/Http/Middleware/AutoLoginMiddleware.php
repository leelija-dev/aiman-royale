<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AutoLoginMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ✅ If user is already logged in, just proceed
        if (auth()->check()) {
            return $next($request);
        }

        // ✅ Check for remember cookie
        $rememberToken = Cookie::get('remember_token');
        $userId = Cookie::get('user_id');

        if ($rememberToken && $userId) {
            // ✅ Find user with matching remember token
            $user = \App\Models\User::where('id', $userId)
                ->where('remember_token', hash('sha256', $rememberToken))
                ->first();

            if ($user) {
                // ✅ Check if session is still valid (within 15 days of last login)
                if ($user->last_login_at && $user->last_login_at->diffInDays(now()) <= 15) {
                    // ✅ Auto-login the user
                    Auth::login($user, true);
                    
                    // ✅ Restore session expiry
                    $expiry = $user->last_login_at->addDays(15);
                    session()->put('session_expiry', $expiry);
                    session()->put('last_login_update', now());

                    Log::info('User auto-logged in via remember token', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'last_login_at' => $user->last_login_at
                    ]);

                    return $next($request);
                } else {
                    // ✅ Session expired - clear cookies
                    $this->clearRememberCookies();
                    
                    Log::info('Auto-login failed - session expired', [
                        'user_id' => $user->id,
                        'last_login_at' => $user->last_login_at,
                        'days_since' => $user->last_login_at ? $user->last_login_at->diffInDays(now()) : null
                    ]);
                }
            } else {
                // ✅ Invalid token - clear cookies
                $this->clearRememberCookies();
            }
        }

        return $next($request);
    }

    /**
     * Clear remember me cookies
     */
    protected function clearRememberCookies()
    {
        Cookie::queue(Cookie::forget('remember_token'));
        Cookie::queue(Cookie::forget('user_id'));
    }
}