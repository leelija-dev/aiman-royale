<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @return RedirectResponse $request
     */

     public function showRegistrationForm()
     {
         return view('Admin.register');
     }
    public function register(Request $request)
    {
        // dd('Register method hit!', $request->all());
        $request->validate([
            'username' => 'required|string|max:32|unique:admin_users,username',
            'email' => 'required|email|max:64|unique:admin_users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // dd($request);
        // Set default values for required fields
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_logon' => now(),
            'no_logon' => 0,
            'fname' => '',
            'lname' => '',
            'address' => '',
            'usertype' => 0,
            'image' => '',
            'added_on' => now(),
            'modified_on' => now()
        ];

        try {
            Admin::create($data);
            return redirect()->route('Admin.login')->with('success', 'Admin registered!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    // public function login(AuthRequest $request)
    // {
    //         // dd($request);
    //     if ( Auth::guard('admin')->attempt( $request->validated() ) ) {
    //         // return redirect()->route('admin.dashboard');

    //         $request->session()->regenerate();
    //         // dd(session()->all());
    //         return redirect()->intended(route('Admin.dashboard'));
    //     }

    //     return Redirect::back()->withErrors(['error' => 'Invalid Credentials!']);
    // }

    

    public function login(AuthRequest $request)
    {
        $credentials = $request->validated();
        
        // Rate limiting configuration
        $throttleKey = 'login_attempts_' . Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
        $maxAttempts = 5;
        $decaySeconds = 300; // 5 minute
        
        // Check if rate limit is exceeded
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'error' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'
            ])->withInput($request->only('error', 'remember'));
        }

        // Attempt login
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            // Clear login attempts on success
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            
            // Log the login activity
            // activity('auth')
            //     ->causedBy(Auth::guard('admin')->user())
            //     ->log('Admin logged in');
            
            return redirect()->intended(route('Admin.dashboard'));
        }
        
        // Increment login attempts on failure
        RateLimiter::hit($throttleKey, $decaySeconds);
        
        return back()->withErrors([
            'error' => "Invalid Credentials!",
        ])->withInput($request->only('error', 'remember'));
    }
    

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('status', 'Successfully logged out.');

    }
//     public function showLoginForm()   //change lakshman
// {
//     if (Auth::guard('admin')->check()) {
//         return redirect()->route('Admin.dashboard');
//     }
//     return view('admin.auth.login');
// }

   
}
