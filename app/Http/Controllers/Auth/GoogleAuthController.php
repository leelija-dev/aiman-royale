<?php
// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Str;
// use Laravel\Socialite\Facades\Socialite;

// class GoogleAuthController extends Controller
// {


//     public function redirect()
//     {
//         try {
//             Log::info('Google OAuth Redirect Started', [
//                 'redirect_uri' => config('services.google.redirect'),
//                 'client_id' => config('services.google.client_id'),
//             ]);

//             return Socialite::driver('google')->redirect();
//         } catch (\Exception $e) {
//             Log::error('Google OAuth Redirect Error: ' . $e->getMessage());

//             // Use the correct route name
//             return redirect()->route('page.register')
//                 ->with('error', 'Unable to connect to Google. Please try again.');
//         }
//     }

//     /**
//      * Obtain the user information from Google.
//      */
//     public function callback(Request $request)
//     {
//         try {
//             Log::info('Google OAuth Callback Received', [
//                 'has_code' => $request->has('code'),
//                 'has_error' => $request->has('error'),
//                 'all_params' => $request->all(),
//             ]);

//             // Check for Google error
//             if ($request->has('error')) {
//                 $errorMessage = $request->error_description ?? $request->error;
//                 Log::error('Google OAuth Error', [
//                     'error' => $request->error,
//                     'error_description' => $errorMessage,
//                 ]);

//                 return redirect()->route('page.register')
//                     ->with('error', 'Google authentication failed: ' . $errorMessage);
//             }

//             // Check if code is present
//             if (!$request->has('code')) {
//                 Log::error('No authorization code received from Google');
//                 return redirect()->route('page.register')
//                     ->with('error', 'No authorization code received from Google.');
//             }

//             try {
//                 // Get user from Google
//                 $googleUser = Socialite::driver('google')->user();

//                 Log::info('Google User Retrieved', [
//                     'id' => $googleUser->id,
//                     'email' => $googleUser->email,
//                     'name' => $googleUser->name,
//                 ]);
//             } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
//                 Log::error('Invalid State Exception: ' . $e->getMessage());
//                 return redirect()->route('page.register')
//                     ->with('error', 'Invalid authentication state. Please try again.');
//             }

//             // Check if user exists by google_id
//             $user = User::where('google_id', $googleUser->id)->first();

//             if ($user) {
//                 Log::info('Existing user found by google_id', ['user_id' => $user->id]);
//                 Auth::login($user);
//                 return redirect()->intended('/')->with('success', 'Welcome back!');
//             }

//             // Check if user exists by email
//             $existingUser = User::where('email', $googleUser->email)->first();

//             if ($existingUser) {
//                 Log::info('Existing user found by email', ['user_id' => $existingUser->id]);

//                 $existingUser->update([
//                     'google_id' => $googleUser->id,
//                     'email_verified_at' => now(),
//                 ]);

//                 Auth::login($existingUser);
//                 return redirect()->intended('/')->with('success', 'Welcome back! Google account linked.');
//             }

//             // Create new user
//             Log::info('Creating new user from Google', ['email' => $googleUser->email]);

//             $user = User::create([
//                 'name' => $googleUser->name,
//                 'email' => $googleUser->email,
//                 'google_id' => $googleUser->id,
//                 'password' => Hash::make(Str::random(24)),
//                 'email_verified_at' => now(),
//             ]);

//             Auth::login($user);

//             Log::info('New user created successfully', ['user_id' => $user->id]);

//             return redirect()->route('home')->with('success', 'Account created successfully with Google!');
//         } catch (\Exception $e) {
//             Log::error('Google authentication error: ' . $e->getMessage());
//             Log::error('Stack trace: ' . $e->getTraceAsString());

//             return redirect()->route('page.register')
//                 ->with('error', 'Google authentication failed. Please try again.');
//         }
//     }

//     /**
//      * Helper method to safely redirect to registration page
//      */
//     private function redirectToRegister($errorMessage)
//     {
//         try {
//             if (route()->has('page.register')) {
//                 return redirect()->route('page.register')->with('error', $errorMessage);
//             }
//         } catch (\Exception $e) {
//             // Fallback to URL helper
//         }

//         return redirect()->to('/register')->with('error', $errorMessage);
//     }
// }

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthController extends Controller
{
    /**
     * Google OAuth Redirect
     */
    public function redirect(Request $request)
    {
        try {
            // dd($request);
            // ✅ Preserve buy_now / redirect params across OAuth flow
            if ($request->filled('buy_now') || $request->filled('redirect') || $request->filled('variant_id')) {
                session()->put('oauth_intended_params', $request->only([
                    'buy_now',
                    'redirect',
                    'variant_id',
                    'product_id',
                    'count',
                    'quantity',
                    'type',
                    'custom_dimensions',
                    'event_id',
                ]));
            }

            Log::info('Google OAuth Redirect Started', [
                'redirect_uri' => config('services.google.redirect'),
                'client_id'    => config('services.google.client_id'),
            ]);

            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage());

            return redirect()->route('page.register')
                ->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    /**
     * Google OAuth Callback
     */
    public function callback(Request $request)
    {
        try {
            Log::info('Google OAuth Callback Received', [
                'has_code'   => $request->has('code'),
                'has_error'  => $request->has('error'),
                'all_params' => $request->all(),
            ]);

            if ($request->has('error')) {
                $errorMessage = $request->error_description ?? $request->error;
                Log::error('Google OAuth Error', [
                    'error'             => $request->error,
                    'error_description' => $errorMessage,
                ]);

                return redirect()->route('page.register')
                    ->with('error', 'Google authentication failed: ' . $errorMessage);
            }

            if (!$request->has('code')) {
                Log::error('No authorization code received from Google');
                return redirect()->route('page.register')
                    ->with('error', 'No authorization code received from Google.');
            }

            try {
                $googleUser = Socialite::driver('google')->user();

                Log::info('Google User Retrieved', [
                    'id'    => $googleUser->id,
                    'email' => $googleUser->email,
                    'name'  => $googleUser->name,
                ]);
            } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
                Log::error('Invalid State Exception: ' . $e->getMessage());
                return redirect()->route('page.register')
                    ->with('error', 'Invalid authentication state. Please try again.');
            }

            // ─── Find or Create User ─────────────────────────────────────
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    Log::info('Existing user found by email', ['user_id' => $existingUser->id]);

                    $existingUser->update([
                        'google_id'         => $googleUser->id,
                        'email_verified_at' => now(),
                    ]);

                    $user = $existingUser;
                } else {
                    Log::info('Creating new user from Google', ['email' => $googleUser->email]);

                    $user = User::create([
                        'name'              => $googleUser->name,
                        'email'             => $googleUser->email,
                        'google_id'         => $googleUser->id,
                        'password'          => Hash::make(Str::random(24)),
                        'email_verified_at' => now(),
                    ]);

                    Log::info('New user created successfully', ['user_id' => $user->id]);
                }
            }

            // ─── Login like login() method ───────────────────────────────
            Auth::login($user, true);

            // Update last login
            $user->last_login_at = now();
            $user->save();

            // Generate JWT token (like login())
            $token = JWTAuth::fromUser($user);

            $request->session()->regenerate();

            // Set session expiry
            session()->put('session_expiry', now()->addDays(15));
            session()->put('last_login_update', now());

            Log::info('User logged in via Google', [
                'user_id'        => $user->id,
                'email'          => $user->email,
                'last_login_at'  => $user->last_login_at,
            ]);

            // ─── Merge guest cart ────────────────────────────────────────
            $guestUuid = $this->guestIdentity->get();

            if ($guestUuid) {
                $this->cartMergeService->merge($guestUuid, $user->id);
            }

            // ─── Merge guest wishlist ────────────────────────────────────
            if ($variantId = session('guest_variant_id_for_wishlist')) {
                session()->forget('guest_variant_id_for_wishlist');

                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    app(\App\Http\Controllers\Web\WishlistController::class)
                        ->addVariantToUserWishlist($variant, $user->id);
                }
            }

            // ─── Restore intended params saved during redirect() ─────────
            $intendedParams = session()->pull('oauth_intended_params', []);
            $intendedRequest = new Request($intendedParams);

            // ─── Buy Now flow ────────────────────────────────────────────
            if ($intendedRequest->boolean('buy_now') && $intendedRequest->filled('variant_id')) {

                $variant = ProductVariant::with('product')
                    ->find($intendedRequest->variant_id);

                if (!$variant) {
                    Log::warning('Buy Now variant not found after Google login', [
                        'variant_id' => $intendedRequest->variant_id,
                        'user_id'    => $user->id,
                    ]);

                    return redirect()->route('page.index')
                        ->withErrors(['product' => 'The selected product variant is no longer available.'])
                        ->with('jwt_token', $token);
                }

                $count = (int) ($intendedRequest->count ?? 1);

                if ($variant->stock < $count) {
                    Log::warning('Buy Now insufficient stock after Google login', [
                        'variant_id' => $variant->id,
                        'stock'      => $variant->stock,
                        'count'      => $count,
                        'user_id'    => $user->id,
                    ]);

                    return redirect()->route('page.index')
                        ->withErrors(['product' => 'Not enough stock available.'])
                        ->with('jwt_token', $token);
                }

                $customDimensions = null;
                if ($intendedRequest->filled('custom_dimensions')) {
                    $decoded = json_decode($intendedRequest->custom_dimensions, true);
                    if (is_array($decoded)) {
                        $customDimensions = $decoded;
                    }
                }

                session()->put('checkout_source', 'buy_now');
                session()->put('meta_initiate_checkout_event_id', $intendedRequest->input('event_id'));

                session()->put('checkout_payload', [
                    'items' => [[
                        'cart_id'           => 0,
                        'product_id'        => $variant->product_id,
                        'variant_id'        => $variant->id,
                        'name'              => $variant->product->name,
                        'size'              => $variant->size,
                        'color'             => $variant->color,
                        'price'             => $variant->price,
                        'discount'          => $variant->discount ?? 0,
                        'discount_price'    => $variant->discount_price ?? $variant->price,
                        'count'             => $count,
                        'type'              => $intendedRequest->input('type', 'stitched'),
                        'custom_dimensions' => $customDimensions,
                        'image'             => optional($variant->product)->featured_image,
                    ]],
                ]);

                $userId    = Auth::id();
                $sessionId = session()->getId();

                $existingCart = Cart::where('variant_id', $variant->id)
                    ->when($userId, function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    }, function ($q) use ($sessionId) {
                        $q->whereNull('user_id')->where('session_id', $sessionId);
                    })
                    ->first();

                if (!$existingCart) {
                    Cart::create([
                        'user_id'    => $userId,
                        'session_id' => $userId ? null : $sessionId,
                        'product_id' => $variant->product_id ?? $intendedRequest->product_id,
                        'variant_id' => $variant->id,
                        'quantity'   => $intendedRequest->input('quantity', 1),
                        'price'      => $variant->discount_price ?? $variant->price,
                        'count'      => 1,
                    ]);

                    Log::info('Buy Now cart entry created after Google login', [
                        'user_id'    => $userId,
                        'variant_id' => $variant->id,
                        'product_id' => $variant->product_id,
                        'session_id' => $sessionId,
                    ]);
                }

                Log::info('Buy Now checkout restored after Google login', [
                    'user_id'         => $user->id,
                    'variant_id'      => $variant->id,
                    'product_id'      => $variant->product_id,
                    'count'           => $count,
                    'type'            => $intendedRequest->input('type', 'stitched'),
                    'checkout_source' => session('checkout_source'),
                ]);

                return redirect()
                    ->route('checkout.index')
                    ->with('jwt_token', $token);
            }

            // ─── Custom redirect param ───────────────────────────────────
            if ($intendedRequest->filled('redirect')) {
                return redirect()
                    ->to($intendedRequest->redirect)
                    ->with('jwt_token', $token);
            }

            // ─── Default: intended page ──────────────────────────────────
            return redirect()->intended(route('page.index'))
                ->with('jwt_token', $token)
                ->with('success', 'Logged in successfully with Google!');

        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->route('page.register')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }
}