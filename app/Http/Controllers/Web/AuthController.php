<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function showLogin(Request $request)
    {
        // Store redirect URL in session if present (for registration flow)
        if ($request->has('redirect') && $request->redirect) {
            session(['redirect_after_registration' => $request->redirect]);
        }
        
        return view('web.login');
    }

    public function register(Request $request)
    {
       
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = Str::random(60);

        // Store user data temporarily in session
        $userData = [
            'name' => $request->firstName . ' ' . $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'token' => $token
        ];

        // Save to session
        session(['registration_data' => $userData]);

        // Send OTP email
        try {
            Mail::raw("Your OTP for email verification is: {$otp}", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Email Verification OTP - Aiman Royale');
            });
            // dd($otp);

            // Store OTP in database for verification
            EmailVerification::updateOrCreate(
                ['email' => $request->email],
                [
                    'otp' => $otp,
                    'token' => $token,
                    'expires_at' => now()->addMinutes(10)
                ]
            );

            return redirect()->route('page.verify-email')->with('success', 'OTP sent to your email. Please verify to complete registration.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send OTP. Please try again.');
        }
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('page.register')->with('error', 'Registration session expired. Please try again.');
        }

        // Verify OTP
        $verification = EmailVerification::where('email', $registrationData['email'])
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->with('error', 'Invalid or expired OTP. Please try again.');
        }

        // Create user account
        try {
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'password' => $registrationData['password'],
                'email_verified_at' => now()
            ]);

            // Delete verification record
            $verification->delete();

            // Clear session
            session()->forget('registration_data');

            // Generate JWT token
            $token = JWTAuth::fromUser($user);

            // Auto login with Laravel Auth
            Auth::login($user);

            // Store JWT token in session for frontend
            session(['jwt_token' => $token]);

            return redirect()->route('page.index')->with('success', 'Account created and verified successfully!')->with('jwt_token', $token);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create account. Please try again.');
        }
    }

    public function sendOTP(Request $request)
    {

        $request->validate([
            'email' => 'nullable|required_without:phone|email|unique:users',
            'phone' => 'nullable|required_without:email|string|unique:users'
        ]);

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = Str::random(60);

        // Store registration data in session
        $registrationData = [
            'email' => $request->email,
            'phone' => $request->phone,
            'otp' => $otp,
            'token' => $token
        ];

        session(['registration_data' => $registrationData]);

        try {
            if ($request->email) {
                // Send OTP email
                Mail::raw("Your OTP for email verification is: {$otp}", function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Email Verification OTP - Aiman Royale');
                });

                // Store OTP in database
                EmailVerification::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'otp' => $otp,
                        'token' => $token,
                        'expires_at' => now()->addMinutes(10)
                    ]
                );
            } else {
                // For phone OTP, you would integrate with SMS service here
                // For now, we'll store it in session
                session(['phone_otp' => $otp]);
            }

            return redirect()->route('web.register.verify-otp')->with('success', 'OTP sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send OTP. Please try again.')->withInput();
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Registration session expired. Please try again.');
        }

        // Verify OTP
        if ($registrationData['email']) {
            $verification = EmailVerification::where('email', $registrationData['email'])
                ->where('otp', $request->otp)
                ->where('expires_at', '>', now())
                ->first();

            if (!$verification) {
                return back()->with('error', 'Invalid or expired OTP. Please try again.');
            }
        } else {
            // For phone verification
            $phoneOtp = session('phone_otp');
            if ($phoneOtp != $request->otp) {
                return back()->with('error', 'Invalid OTP. Please try again.');
            }
        }

        // Update session to mark as verified
        session(['registration_data.verified' => true]);

        return redirect()->route('web.register.set-password')->with('success', 'Identity verified successfully!');
    }

    public function setPassword(Request $request)
    {

        $registrationData = session('registration_data');
        //  dd($registrationData);
        if (!$registrationData || !isset($registrationData['verified'])) {
            return redirect()->route('register')->with('error', 'Please complete verification first.');
        }

        $request->validate([
            'password' => 'required|min:8',
            'terms' => 'required'
        ]);

        try {
            // Create user account
            $user = User::create([
                'name' => 'User', // Default name, can be updated later
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'password' => Hash::make($request->password),
                'email_verified_at' => $registrationData['email'] ? now() : null
            ]);

            // Clean up verification records
            if ($registrationData['email']) {
                EmailVerification::where('email', $registrationData['email'])->delete();
            }

            // Clear session
            session()->forget(['registration_data', 'phone_otp']);

            // Generate JWT token
            $token = JWTAuth::fromUser($user);

            // Auto login with Laravel Auth
            Auth::login($user);

            // Store JWT token in session for frontend
            session(['jwt_token' => $token]);

            // Check for redirect URL from registration session
            $redirectUrl = session('redirect_after_registration');
            
            // Clean up redirect session
            session()->forget('redirect_after_registration');

            // Redirect to stored URL or default to profile
            if ($redirectUrl) {
                return redirect()->to($redirectUrl)->with('success', 'Account created successfully! Welcome to Aiman Royale!')->with('jwt_token', $token);
            }

            return redirect()->route('web.profile')->with('success', 'Account created successfully! Welcome to Aiman Royale!')->with('jwt_token', $token);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create account. Please try again.');
        }
    }

    public function resendOTP(Request $request)
    {
        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Registration session expired. Please try again.');
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            if ($registrationData['email']) {
                // Send OTP email
                Mail::raw("Your OTP for email verification is: {$otp}", function ($message) use ($registrationData) {
                    $message->to($registrationData['email'])
                        ->subject('Email Verification OTP - Aiman Royale');
                });

                // Update OTP in database
                EmailVerification::updateOrCreate(
                    ['email' => $registrationData['email']],
                    [
                        'otp' => $otp,
                        'expires_at' => now()->addMinutes(10)
                    ]
                );
            } else {
                // Update phone OTP in session
                session(['phone_otp' => $otp]);
            }

            // Update session
            session(['registration_data.otp' => $otp]);

            return redirect()->route('web.register.verify-otp')->with('success', 'OTP resent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend OTP. Please try again.');
        }
    }

    public function sendForgotPasswordOTP(Request $request)
    {
        $request->validate([
            'email' => 'nullable|required_without:phone|email|exists:users,email',
            'phone' => 'nullable|required_without:email|string|exists:users,phone'
        ]);

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = Str::random(60);

        // Store forgot password data in session
        $forgotPasswordData = [
            'email' => $request->email,
            'phone' => $request->phone,
            'otp' => $otp,
            'token' => $token
        ];

        session(['forgot_password_data' => $forgotPasswordData]);

        // Store email/phone for display
        if ($request->email) {
            session(['forgot_email' => $request->email]);
        } else {
            session(['forgot_phone' => $request->phone]);
        }

        try {
            if ($request->email) {
                // Send OTP email
                Mail::raw("Your OTP for password reset is: {$otp}", function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Password Reset OTP - Aiman Royale');
                });

                // Store OTP in database
                EmailVerification::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'otp' => $otp,
                        'token' => $token,
                        'expires_at' => now()->addMinutes(10)
                    ]
                );
            } else {
                // For phone OTP, store in session
                session(['forgot_phone_otp' => $otp]);
            }

            return redirect()->route('web.forgot-password.verify-otp')->with('success', 'Password reset code sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reset code. Please try again.')->withInput();
        }
    }

    public function verifyForgotPasswordOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $forgotPasswordData = session('forgot_password_data');

        if (!$forgotPasswordData) {
            return redirect()->route('page.forgot-password')->with('error', 'Password reset session expired. Please try again.');
        }

        // Verify OTP
        if ($forgotPasswordData['email']) {
            $verification = EmailVerification::where('email', $forgotPasswordData['email'])
                ->where('otp', $request->otp)
                ->where('expires_at', '>', now())
                ->first();

            if (!$verification) {
                return back()->with('error', 'Invalid or expired reset code. Please try again.');
            }
        } else {
            // For phone verification
            $phoneOtp = session('forgot_phone_otp');
            if ($phoneOtp != $request->otp) {
                return back()->with('error', 'Invalid reset code. Please try again.');
            }
        }

        // Update session to mark as verified
        session(['forgot_password_data.verified' => true]);

        return redirect()->route('web.forgot-password.reset')->with('success', 'Identity verified successfully! Please set your new password.');
    }

    public function resendForgotPasswordOTP(Request $request)
    {
        $forgotPasswordData = session('forgot_password_data');

        if (!$forgotPasswordData) {
            return redirect()->route('page.forgot-password')->with('error', 'Password reset session expired. Please try again.');
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            if ($forgotPasswordData['email']) {
                // Send OTP email
                Mail::raw("Your OTP for password reset is: {$otp}", function ($message) use ($forgotPasswordData) {
                    $message->to($forgotPasswordData['email'])
                        ->subject('Password Reset OTP - Aiman Royale');
                });

                // Update OTP in database
                EmailVerification::updateOrCreate(
                    ['email' => $forgotPasswordData['email']],
                    [
                        'otp' => $otp,
                        'expires_at' => now()->addMinutes(10)
                    ]
                );
            } else {
                // Update phone OTP in session
                session(['forgot_phone_otp' => $otp]);
            }

            // Update session
            session(['forgot_password_data.otp' => $otp]);

            return redirect()->route('web.forgot-password.verify-otp')->with('success', 'Reset code resent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend reset code. Please try again.');
        }
    }

    public function resetPassword(Request $request)
    {
        $forgotPasswordData = session('forgot_password_data');

        if (!$forgotPasswordData || !isset($forgotPasswordData['verified'])) {
            return redirect()->route('page.forgot-password')->with('error', 'Please complete verification first.');
        }

        $request->validate([
            'password' => 'required|min:8',
        ]);

        try {
            // Find user and update password
            if ($forgotPasswordData['email']) {
                $user = User::where('email', $forgotPasswordData['email'])->first();
            } else {
                $user = User::where('phone', $forgotPasswordData['phone'])->first();
            }

            if (!$user) {
                return back()->with('error', 'User not found. Please try again.');
            }

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();

            // Clean up verification records
            if ($forgotPasswordData['email']) {
                EmailVerification::where('email', $forgotPasswordData['email'])->delete();
            }

            // Clear session
            session()->forget(['forgot_password_data', 'forgot_phone_otp', 'forgot_email', 'forgot_phone']);

            return redirect()->route('page.login')->with('success', 'Password reset successfully! Please login with your new password.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login with JWT
        if (!$token = JWTAuth::attempt($credentials)) {
            dd($credentials);
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Get authenticated user from JWT
        $user = JWTAuth::user();
        // dd($user);
        // Also login with Laravel's Auth for web routes
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Check if there's a redirect URL
        if ($request->has('redirect') && $request->redirect) {
            return redirect()->to($request->redirect)->with('jwt_token', $token);
        }

        // Default redirect if no redirect URL provided
        return redirect()->intended(route('page.index'))->with('jwt_token', $token);
    }

    public function logout(Request $request)
    {
        // Invalidate JWT token if it exists
        try {
            if ($token = JWTAuth::getToken()) {
                JWTAuth::invalidate($token);
            }
        } catch (\Exception $e) {
            // Token might be invalid or expired, continue with logout
        }

        // Use web guard specifically
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully!');
    }

    /**
     * Get authenticated user with JWT token
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
