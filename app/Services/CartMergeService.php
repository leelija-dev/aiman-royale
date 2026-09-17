<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartMergeService
{
    public function merge(string $guestUuid, int $userId): void
    {
        DB::transaction(function () use ($guestUuid, $userId) {

            /*
            |--------------------------------------------------------------------------
            | ONLY REAL GUEST CART ROWS
            |--------------------------------------------------------------------------
            |
            | Rows having user_id already belong to a user.
            | Do NOT merge them again.
            |
            */

            $guestCarts = Cart::where('guest_uuid', $guestUuid)
                ->whereNull('user_id')
                ->get();

            if ($guestCarts->isEmpty()) {

                Log::info('No guest-only cart items to merge', [
                    'guest_uuid' => $guestUuid,
                    'user_id'    => $userId,
                ]);

                return;
            }

            foreach ($guestCarts as $guestCart) {

                /*
                |--------------------------------------------------------------------------
                | Find the SAME variant in the logged-in user's cart
                |--------------------------------------------------------------------------
                */

                $userCart = Cart::where('user_id', $userId)
                    ->where('variant_id', $guestCart->variant_id)
                    ->first();

                if ($userCart) {

                    /*
                    |--------------------------------------------------------------------------
                    | Same variant exists in both carts.
                    |
                    | Combine the quantities into the user's row.
                    | Keep BOTH user_id and guest_uuid.
                    |
                    */

                    $userCart->update([
                        'count'             => $userCart->count + $guestCart->count,
                        'price'             => $guestCart->price,
                        'guest_uuid'        => $guestUuid,
                        'session_id'        => null,
                        // 'last_activity_at'  => now(),
                        // 'expires_at'        => null,
                    ]);

                    /*
                    | Delete ONLY the guest-only duplicate row.
                    */
                    $guestCart->delete();

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Variant does not exist in user's cart.
                    |
                    | Convert this guest row into the user's cart row.
                    | Keep BOTH user_id and guest_uuid.
                    |--------------------------------------------------------------------------
                    */

                    $guestCart->update([
                        'user_id'           => $userId,
                        'guest_uuid'        => $guestUuid,
                        'session_id'        => null,
                        // 'last_activity_at' => now(),
                        // 'expires_at'        => null,
                    ]);
                }
            }

            Log::info('Guest cart merged successfully', [
                'guest_uuid' => $guestUuid,
                'user_id'    => $userId,
            ]);
        });
    }
}

