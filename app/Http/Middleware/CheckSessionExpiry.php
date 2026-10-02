<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckSessionExpiry
{
    /**
     * Routes that should not check session expiry
     */
    protected $except = [
        'login',
        'register',
        'verify-otp',
        'set-password',
        'forgot-password',
        'auth/google/*',
        'webhook/*',
        'api/*',
        'test-*',
        'checkout/webhook/*',
        'delhivery-webhook',
    ];
    
    public function handle(Request $request, Closure $next)
    {
        // Skip session check for certain routes
        foreach ($this->except as $except) {
            if ($request->routeIs($except) || $request->is($except)) {
                return $next($request);
            }
        }
        
        // Only check for authenticated users
        if (!auth()->check()) {
            return $next($request);
        }
        
        $expiry = session()->get('session_expiry');
        
        // Check if session has expired
        if ($expiry && now()->gt($expiry)) {
            $user = auth()->user();
            
            Log::info('Session expired for user', [
                'user_id' => $user->id,
                'email' => $user->email,
                'expiry' => $expiry
            ]);
            
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            
            // Store intended URL
            session()->put('url.intended', $request->fullUrl());
            
            return redirect()->route('page.login')->withErrors([
                'email' => 'Your session has expired. Please login again.'
            ]);
        }
        
        // Extend session if user is active
        if ($expiry) {
            $user = auth()->user();
            $lastUpdate = session()->get('last_login_update', now()->subHour());
            
            // Update only once per hour to reduce database writes
            if ($lastUpdate->diffInHours(now()) >= 1) {
                $user->last_login_at = now();
                $user->save();
                
                $newExpiry = now()->addDays(15);
                session()->put('session_expiry', $newExpiry);
                session()->put('last_login_update', now());
                
                Log::info('Session extended for user', [
                    'user_id' => $user->id,
                    'new_expiry' => $newExpiry
                ]);
            }
        }
        
        return $next($request);
    }
}