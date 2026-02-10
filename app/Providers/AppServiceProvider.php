<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;
use App\Models\Category;
use App\Models\Size;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
        View::composer('*', function ($view) {
        $notifications = Notification::where('viewed', 0)->latest()->get();
        $categories = Category::where('is_active', 1)->orderBy('name')->get();
        $sizes=Size::OrderBy('sort_order')->get();
        $view->with('notifications', $notifications)->with('categories', $categories)->with('sizes', $sizes);
    });
   }
}
