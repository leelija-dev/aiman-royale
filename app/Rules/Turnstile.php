<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Please complete the CAPTCHA verification.');
            return;
        }

        try {
            $response = Http::asForm()->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret'   => config('services.turnstile.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]
            );

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                $fail('CAPTCHA verification failed. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Turnstile verification error: ' . $e->getMessage());
            $fail('CAPTCHA verification service unavailable. Please try again.');
        }
    }
}