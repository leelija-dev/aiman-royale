<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\Size;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

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
            $categories = Category::where('is_active', 1)->with('products')->orderBy('name')->get();
            $wedding = Occasion::where('slug', 'wedding')->first();
            $wedding_id = $wedding->id ?? 0;
            $bridal = Occasion::where('slug', 'bridal')->first();
            $bridal_id = $bridal->id ?? 0;
            $categoriesWithWedding = 
            // $weddingProducts = DB::table('products')
            //     ->where('ocassion_id', $wedding_id)
            //     ->get();
            $weddingProducts = Product::where('ocassion_id', $wedding_id)->get();
            $bridalProducts = Product::where('ocassion_id', $bridal_id)->get();
            // dd($weddingProducts);
            $productCategory = ProductVariant::with(['product.category', 'product.images', 'images'])
                ->get()
                ->unique(function ($variant) {
                    return optional($variant->product)->category_id;
                })
                ->values();
            $sizes = Size::OrderBy('sort_order')->get();


            // Only get wishlists if user is authenticated
            $wishlists = [];
            if (auth()->check()) {
                $wishlists = Wishlist::where('user_id', auth()->user()->id)->with(['product.images', 'variant'])
                    ->get();
            }

            $view->with('notifications', $notifications)->with('categories', $categories)->with('sizes', $sizes)
                ->with('wishlists', $wishlists)->with('productCategory', $productCategory);
        });
    }
}
