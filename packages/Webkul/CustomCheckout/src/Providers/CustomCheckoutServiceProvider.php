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
        // Register view namespace for checkout
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'checkout');
        
        // Register shop namespace for overriding shop views with higher priority
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'shop');
        
        // Register admin namespace for overriding admin views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'admin');
        
        // Override specific views by extending the view factory
        $this->app->booted(function () {
            $view = $this->app['view'];
            
            // Override shop customer address create form
            $view->composer('shop::customers.account.addresses.create', function ($view) {
                $view->setPath(__DIR__ . '/../Resources/views/shop/customers/account/addresses/create.blade.php');
            });
            
            // Override shop customer address edit form
            $view->composer('shop::customers.account.addresses.edit', function ($view) {
                $view->setPath(__DIR__ . '/../Resources/views/shop/customers/account/addresses/edit.blade.php');
            });
            
            // Override admin customer address create form
            $view->composer('admin::customers.customers.view.address.create', function ($view) {
                $view->setPath(__DIR__ . '/../Resources/views/admin/customers/customers/view/address/create.blade.php');
            });
            
            // Override admin customer address edit form
            $view->composer('admin::customers.customers.view.address.edit', function ($view) {
                $view->setPath(__DIR__ . '/../Resources/views/admin/customers/customers/view/address/edit.blade.php');
            });
        });
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