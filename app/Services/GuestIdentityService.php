<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class GuestIdentityService
{
    public const COOKIE_NAME = 'ecommerce_guest_uuid';

    /**
     * Get existing guest UUID from browser cookie.
     */
    public function get(): ?string
    {
        return request()->cookie(self::COOKIE_NAME);
    }

    /**
     * Get existing guest UUID or create a new one.
     */
    public function getOrCreate(): string
    {
        $guestUuid = $this->get();

        if (!$guestUuid) {

            $guestUuid = (string) Str::uuid();

            Cookie::queue(
                self::COOKIE_NAME,
                $guestUuid,
                525600, // 1 year in minutes
                '/',
                null,
                request()->isSecure(),
                true,
                false,
                'lax'
            );
        }

        return $guestUuid;
    }

    /**
     * Remove guest UUID cookie.
     */
    public function forget(): void
    {
        Cookie::queue(
            Cookie::forget(self::COOKIE_NAME)
        );
    }
}
