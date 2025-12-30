<?php

namespace Webkul\Custom\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     // Load views from our custom directory
    //     $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'custom');

    //     // Prepend our views to the shop namespace
    //     View::prependNamespace('shop', __DIR__.'/../Resources/views/shop');

    //     // Register view composer to hide shipping method
    //     View::composer(
    //         ['shop::checkout.onepage.index', 'shop::checkout.onepage.shipping'],
    //         \Webkul\Custom\View\Composers\CheckoutComposer::class
    //     );

    //     // Add our custom JavaScript to the checkout page
    //     $this->app->booted(function () {
    //         // Publish the JS file to the public directory
    //         $this->publishes([
    //             __DIR__.'/../Resources/assets/js' => public_path('vendor/webkul/custom/js'),
    //         ], 'public');

    //         // Add the script to the checkout page
    //         $this->app['events']->listen('bagisto.shop.checkout.onepage.index.after', function($view) {
    //             return '<script src="' . asset('vendor/webkul/custom/js/checkout-override.js') . '"></script>';
    //         });
    //     });
    // }
    public function boot()
    {
        // Load views from our custom directory with higher priority
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'custom');

        // Add our views path to the beginning of the view paths array
        $this->app['view']->prependNamespace('shop', __DIR__ . '/../Resources/views/shop');

        // Register view composer
        View::composer(
            ['shop::checkout.onepage.index', 'shop::checkout.onepage.shipping'],
            \Webkul\Custom\View\Composers\CheckoutComposer::class
        );
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
