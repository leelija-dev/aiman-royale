<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;

class DynamicSeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $pageMeta = (object) [
            'meta_title' => 'Aiman Royale - Premium Fashion Collection',
            'meta_description' => 'Discover premium fashion collections at Aiman Royale. Shop our exclusive range of designer wear, traditional outfits, and contemporary styles.',
            'meta_keyword' => 'fashion, designer wear, traditional clothing, premium fashion, aiman royale',
            'meta_tags' => 'fashion, clothing, designer, premium, traditional, contemporary'
        ];

        $routeName = $request->route()->getName();
        $currentUrl = $request->url();

        // Handle different page types
        switch ($routeName) {
            case 'page.index':
                // Home page SEO
                $pageMeta->meta_title = 'Aiman Royale - Premium Fashion Collection | Home';
                $pageMeta->meta_description = 'Welcome to Aiman Royale - Your destination for premium fashion. Explore our exclusive collections of designer wear, traditional outfits, and contemporary styles.';
                $pageMeta->meta_keyword = 'aiman royale, premium fashion, designer wear, traditional clothing, home page, fashion collection';
                $pageMeta->meta_tags = 'fashion, designer, premium, traditional, contemporary, home';
                break;

            case 'category.show':
            case 'category.collection':
                // Category/Collection page SEO
                $slug = $request->route('slug');
                $category = Category::where('slug', $slug)->first();
                
                if ($category) {
                    $pageMeta->meta_title = $category->meta_title 
                        ?? $category->name . ' Collection - Aiman Royale'
                        ?? 'Collection - Aiman Royale';
                    
                    $pageMeta->meta_description = $category->meta_description 
                        ?? 'Explore our ' . $category->name . ' collection at Aiman Royale. Discover premium ' . strtolower($category->name) . ' designs and styles.'
                        ?? 'Browse our exclusive collections at Aiman Royale.';
                    
                    $pageMeta->meta_keyword = $category->meta_keyword 
                        ?? $category->name . ', collection, aiman royale, premium fashion, ' . strtolower($category->name)
                        ?? 'collection, aiman royale, premium fashion';
                    
                    $pageMeta->meta_tags = $category->meta_tags 
                        ?? $category->name . ', fashion, collection, premium, designer'
                        ?? 'fashion, collection, premium, designer';
                }
                break;

            case 'page.single-product':
                // Product page SEO
                $slug = $request->route('slug');
                $product = Product::where('slug', $slug)->first();
                
                if ($product) {
                    $pageMeta->meta_title = $product->meta_title 
                        ?? $product->name . ' - Aiman Royale'
                        ?? 'Product - Aiman Royale';
                    
                    $pageMeta->meta_description = $product->meta_description 
                        ?? 'Shop ' . $product->name . ' at Aiman Royale. ' . ($product->description ? substr(strip_tags($product->description), 0, 150) . '...' : 'Premium quality product with exceptional design.')
                        ?? 'Discover premium products at Aiman Royale.';
                    
                    $pageMeta->meta_keyword = $product->meta_keyword 
                        ?? $product->name . ', aiman royale, premium fashion, designer wear, ' . ($product->brand ?? 'fashion')
                        ?? 'product, aiman royale, premium fashion';
                    
                    $pageMeta->meta_tags = $product->meta_tags 
                        ?? $product->name . ', fashion, premium, designer, ' . ($product->brand ?? 'brand')
                        ?? 'fashion, premium, designer, product';
                }
                break;

            case 'occasion.show':
                // Occasion page SEO
                $slug = $request->route('slug');
                $occasion = \App\Models\Occasion::where('slug', $slug)->first();
                
                if ($occasion) {
                    $pageMeta->meta_title = $occasion->name . ' Collection - Aiman Royale';
                    $pageMeta->meta_description = 'Explore our ' . $occasion->name . ' collection at Aiman Royale. Perfect outfits for ' . strtolower($occasion->name) . ' occasions.';
                    $pageMeta->meta_keyword = $occasion->name . ', occasion, aiman royale, premium fashion, ' . strtolower($occasion->name) . ' wear';
                    $pageMeta->meta_tags = $occasion->name . ', occasion, fashion, premium, designer';
                }
                break;

            case 'page.login':
                $pageMeta->meta_title = 'Login - Aiman Royale';
                $pageMeta->meta_description = 'Login to your Aiman Royale account to access your orders, wishlist, and personalized shopping experience.';
                $pageMeta->meta_keyword = 'login, aiman royale account, customer login, fashion login';
                $pageMeta->meta_tags = 'login, account, customer, fashion';
                break;

            case 'page.register':
                $pageMeta->meta_title = 'Register - Aiman Royale';
                $pageMeta->meta_description = 'Create your Aiman Royale account to enjoy exclusive benefits, personalized recommendations, and seamless shopping.';
                $pageMeta->meta_keyword = 'register, aiman royale account, customer registration, fashion signup';
                $pageMeta->meta_tags = 'register, account, customer, signup, fashion';
                break;

            case 'cart.index':
                $pageMeta->meta_title = 'Shopping Cart - Aiman Royale';
                $pageMeta->meta_description = 'Review your shopping cart at Aiman Royale. Complete your purchase of premium fashion items.';
                $pageMeta->meta_keyword = 'shopping cart, aiman royale cart, checkout, fashion cart';
                $pageMeta->meta_tags = 'cart, shopping, checkout, fashion';
                break;
        }

        // Share SEO data with all views
        View::share('pageMeta', $pageMeta);
        
        // Share OG meta data for specific pages
        $ogMeta = [];
        
        switch ($routeName) {
            case 'page.single-product':
                $slug = $request->route('slug');
                $product = Product::where('slug', $slug)->first();
                
                if ($product) {
                    $ogMeta = [
                        'title' => $product->meta_title ?? $product->name . ' - Aiman Royale',
                        'description' => $product->meta_description ?? 'Shop ' . $product->name . ' at Aiman Royale. ' . ($product->description ? substr(strip_tags($product->description), 0, 150) . '...' : 'Premium quality product with exceptional design.'),
                        'image' => $product->images->first() ? asset($product->images->first()->image) : asset('web/images/company-logo/aiman-royal-logo.png'),
                        'url' => $currentUrl,
                        'type' => 'product',
                        'site_name' => 'Aiman Royale',
                        'locale' => 'en_US',
                        'publisher' => 'Aiman Royale',
                        'keywords' => $product->meta_keyword ?? $product->name . ', aiman royale, premium fashion, designer wear',
                        'tags' => $product->meta_tags ?? $product->name . ', fashion, premium, designer'
                    ];
                }
                break;
                
            case 'category.show':
            case 'category.collection':
                $slug = $request->route('slug');
                $category = Category::where('slug', $slug)->first();
                
                if ($category) {
                    $ogMeta = [
                        'title' => $category->meta_title ?? $category->name . ' Collection - Aiman Royale',
                        'description' => $category->meta_description ?? 'Explore our ' . $category->name . ' collection at Aiman Royale. Discover premium ' . strtolower($category->name) . ' designs and styles.',
                        'image' => $category->image ? asset($category->image) : asset('web/images/company-logo/aiman-royal-logo.png'),
                        'url' => $currentUrl,
                        'type' => 'website',
                        'site_name' => 'Aiman Royale',
                        'locale' => 'en_US',
                        'publisher' => 'Aiman Royale',
                        'section' => 'Collection',
                        'keywords' => $category->meta_keyword ?? $category->name . ', collection, aiman royale, premium fashion',
                        'tags' => $category->meta_tags ?? $category->name . ', fashion, collection, premium'
                    ];
                }
                break;
                
            default:
                $ogMeta = [
                    'title' => $pageMeta->meta_title,
                    'description' => $pageMeta->meta_description,
                    'image' => asset('web/images/company-logo/aiman-royal-logo.png'),
                    'url' => $currentUrl,
                    'type' => 'website',
                    'site_name' => 'Aiman Royale',
                    'locale' => 'en_US',
                    'publisher' => 'Aiman Royale'
                ];
                break;
        }
        
        View::share('ogMeta', $ogMeta);

        return $next($request);
    }
}
