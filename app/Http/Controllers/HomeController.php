<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;
    
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * Display the home page with cached products
     */
    public function index(Request $request)
    {
        // Get cached homepage products using ProductService
        $products = $this->productService->homepageProducts();
        
        // Get other required data
        $categories = Category::withCount('products')->whereNull('parent_id')->get();
        $mainBanners = Banner::where('type', 'main')->where('status', 'active')->get();
        $secondaryBanners = Banner::where('type', 'secondary')->where('status', 'active')->get();
        $editorBanners = Banner::where('type', 'editor')->where('status', 'active')->get();
        
        // Get cache statistics
        $cacheStats = $this->productService->getCacheStats();
        
        return view('web.home', compact(
            'products', 
            'categories', 
            'mainBanners', 
            'secondaryBanners', 
            'editorBanners',
            'cacheStats'
        ));
    }
}
