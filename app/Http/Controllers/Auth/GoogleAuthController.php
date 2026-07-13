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
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        try {
            // Log the redirect attempt
            Log::info('Google OAuth Redirect Started', [
                'redirect_uri' => env('GOOGLE_REDIRECT'),
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'url' => url('/'),
                'full_url' => url()->full(),
            ]);

            // Get the Socialite driver with explicit redirect URL
            $driver = Socialite::driver('google');
            
            // Force set the redirect URL
            $redirectUrl = env('GOOGLE_REDIRECT');
            Log::info('Using redirect URL: ' . $redirectUrl);
            
            return $driver->redirect();
            
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('register')->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            // Log the callback request
            Log::info('Google OAuth Callback Received', [
                'all_params' => $request->all(),
                'url' => url()->full(),
                'current_url' => url()->current(),
            ]);

            // Check for Google error
            if ($request->has('error')) {
                Log::error('Google OAuth Error in Callback', [
                    'error' => $request->error,
                    'error_description' => $request->error_description,
                ]);
                
                return redirect()->route('register')
                    ->with('error', 'Google authentication failed: ' . ($request->error_description ?? $request->error));
            }

            // Try to get the user from Google
            try {
                $googleUser = Socialite::driver('google')->user();
                
                Log::info('Google User Data Retrieved', [
                    'id' => $googleUser->id,
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                ]);
            } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
                Log::error('Invalid State Exception: ' . $e->getMessage());
                return redirect()->route('register')
                    ->with('error', 'Invalid authentication state. Please try again.');
            } catch (\Exception $e) {
                Log::error('Failed to get Google user: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

            // Check if user already exists by google_id
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                Log::info('Existing user found by google_id', ['user_id' => $user->id, 'email' => $user->email]);
                Auth::login($user);
                return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
            }
            
            // Check if user exists by email
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                Log::info('Existing user found by email, updating google_id', [
                    'user_id' => $existingUser->id, 
                    'email' => $existingUser->email
                ]);
                
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                ]);
                
                Auth::login($existingUser);
                return redirect()->intended('/dashboard')->with('success', 'Welcome back! Google account linked.');
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
            
            return redirect()->route('register')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }
}