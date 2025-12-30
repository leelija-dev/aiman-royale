<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Checkout\Facades\Cart;

class CheckoutEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen('checkout.order.save.before', function ($order) {
            $cart = Cart::getCart();

            if (! $cart) {
                return;
            }

            // Remove shipping charges
            $cart->shipping_amount = 0;
            $cart->base_shipping_amount = 0;

            // Remove shipping method
            $cart->shipping_method = null;
            $cart->save();
        });
    }
}
