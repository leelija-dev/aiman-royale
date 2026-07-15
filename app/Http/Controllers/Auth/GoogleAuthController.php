<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{


    public function redirect()
    {
        try {
            Log::info('Google OAuth Redirect Started', [
                'redirect_uri' => config('services.google.redirect'),
                'client_id' => config('services.google.client_id'),
            ]);

            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage());

            // Use the correct route name
            return redirect()->route('page.register')
                ->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback(Request $request)
    {
        try {
            Log::info('Google OAuth Callback Received', [
                'has_code' => $request->has('code'),
                'has_error' => $request->has('error'),
                'all_params' => $request->all(),
            ]);

            // Check for Google error
            if ($request->has('error')) {
                $errorMessage = $request->error_description ?? $request->error;
                Log::error('Google OAuth Error', [
                    'error' => $request->error,
                    'error_description' => $errorMessage,
                ]);

                return redirect()->route('page.register')
                    ->with('error', 'Google authentication failed: ' . $errorMessage);
            }

            // Check if code is present
            if (!$request->has('code')) {
                Log::error('No authorization code received from Google');
                return redirect()->route('page.register')
                    ->with('error', 'No authorization code received from Google.');
            }

            try {
                // Get user from Google
                $googleUser = Socialite::driver('google')->user();

                Log::info('Google User Retrieved', [
                    'id' => $googleUser->id,
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                ]);
            } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
                Log::error('Invalid State Exception: ' . $e->getMessage());
                return redirect()->route('page.register')
                    ->with('error', 'Invalid authentication state. Please try again.');
            }

            // Check if user exists by google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Log::info('Existing user found by google_id', ['user_id' => $user->id]);
                Auth::login($user);
                return redirect()->intended('/')->with('success', 'Welcome back!');
            }

            // Check if user exists by email
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                Log::info('Existing user found by email', ['user_id' => $existingUser->id]);

                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                ]);

                Auth::login($existingUser);
                return redirect()->intended('/')->with('success', 'Welcome back! Google account linked.');
            }

            // Create new user
            Log::info('Creating new user from Google', ['email' => $googleUser->email]);

            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);

            Auth::login($user);

            Log::info('New user created successfully', ['user_id' => $user->id]);

            return redirect()->route('home')->with('success', 'Account created successfully with Google!');
        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->route('page.register')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }

    /**
     * Helper method to safely redirect to registration page
     */
    private function redirectToRegister($errorMessage)
    {
        try {
            if (route()->has('page.register')) {
                return redirect()->route('page.register')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            // Fallback to URL helper
        }

        return redirect()->to('/register')->with('error', $errorMessage);
    }
}
