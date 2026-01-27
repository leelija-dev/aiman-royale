<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
// use App\Models\Service;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    // public function boot()
    // {
    //     // View::composer('components.web.navbar', function ($view) {
    //     //     $view->with('services', Service::with('children')->whereNull('parent_id')->orderBy('name')->get());
    //     // });
    //     $services = Service::with('children')
    //         ->whereNull('parent_id')
    //         ->orderBy('name')
    //         ->get();

    //     View::share('services', $services); // This will make it globally available
    // }

    public function boot()
    {
        // Using View Composer to only load services when the navbar is rendered
        View::composer('components.web.navbar', function ($view) {
            $services = \App\Models\Service::with('children')
                ->whereNull('parent_id')
                ->orderBy('name')
                ->get();
            $view->with('services', $services);
        });
    }
}
