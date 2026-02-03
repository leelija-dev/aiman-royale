<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticatedAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('admin')->check()) {
            return redirect()->route('Admin.dashboard');
        }

        return $next($request);
    }
}


