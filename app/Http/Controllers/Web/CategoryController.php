<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display products for a specific category.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        $products = $category->products()
            ->where('is_active', 1)
            ->with(['images' => function($query) {
                $query->select('product_id', 'image');
            }])
            ->select('products.*')
            ->latest()
            ->paginate(12);
        // dd($products);


        return view('web.category_product', compact('category', 'products'));
    }
}
