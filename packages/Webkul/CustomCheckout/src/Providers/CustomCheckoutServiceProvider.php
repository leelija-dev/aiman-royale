<?php

namespace Webkul\CustomCheckout\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CustomCheckoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register view namespace
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'checkout');
        
        // Also register the namespace for direct includes
        View::addNamespace('checkout', __DIR__ . '/../Resources/views');
        
        // Publish views if needed
        $this->publishes([
            __DIR__ . '/../Resources/views' => resource_path('views/vendor/checkout'),
        ], 'checkout-views');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register any package services here
    }
}