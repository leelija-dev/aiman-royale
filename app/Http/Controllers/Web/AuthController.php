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
                    ->subject('Email Verification OTP - Your App Name');
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

            // Auto login with both JWT and Laravel Auth
            Auth::login($user);

            return redirect()->route('page.index')->with('success', 'Account created and verified successfully!')->with('jwt_token', $token);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create account. Please try again.');
        }
    }

    public function resendOTP(Request $request)
    {
        $registrationData = session('registration_data');
        
        if (!$registrationData) {
            return response()->json(['error' => 'Registration session expired'], 400);
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            // Send OTP email
            Mail::raw("Your OTP for email verification is: {$otp}", function ($message) use ($registrationData) {
                $message->to($registrationData['email'])
                    ->subject('Email Verification OTP - Your App Name');
            });

            // Update OTP in database
            EmailVerification::updateOrCreate(
                ['email' => $registrationData['email']],
                [
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(10)
                ]
            );

            // Update session
            session(['registration_data.otp' => $otp]);

            return response()->json(['success' => 'OTP resent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to resend OTP'], 500);
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
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Get authenticated user from JWT
        $user = JWTAuth::user();

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
