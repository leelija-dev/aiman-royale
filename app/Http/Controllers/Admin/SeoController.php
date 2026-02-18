<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeoController extends Controller
{
    /**
     * Show SEO management dashboard
     */
    public function index()
    {
        return view('admin.seo.index');
    }

    /**
     * Get categories with SEO data
     */
    public function categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keyword', 'meta_tags')
            ->orderBy('name')
            ->paginate(20);

        return response()->json($categories);
    }

    /**
     * Update category SEO data
     */
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keyword' => 'nullable|string|max:500',
            'meta_tags' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::findOrFail($id);
        $category->update($request->only(['meta_title', 'meta_description', 'meta_keyword', 'meta_tags']));

        return response()->json(['success' => true, 'message' => 'SEO data updated successfully']);
    }

    /**
     * Get products with SEO data
     */
    public function products()
    {
        $products = Product::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keyword', 'meta_tags')
            ->with('images')
            ->orderBy('name')
            ->paginate(20);

        return response()->json($products);
    }

    /**
     * Update product SEO data
     */
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keyword' => 'nullable|string|max:500',
            'meta_tags' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($id);
        $product->update($request->only(['meta_title', 'meta_description', 'meta_keyword', 'meta_tags']));

        return response()->json(['success' => true, 'message' => 'SEO data updated successfully']);
    }

    /**
     * Generate SEO suggestions based on content
     */
    public function generateSuggestions(Request $request)
    {
        $type = $request->input('type'); // 'category' or 'product'
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');

        $suggestions = [];

        if ($type === 'category') {
            $suggestions = [
                'meta_title' => $name . ' Collection - Aiman Royale',
                'meta_description' => 'Explore our ' . $name . ' collection at Aiman Royale. Discover premium ' . strtolower($name) . ' designs and styles.',
                'meta_keyword' => $name . ', collection, aiman royale, premium fashion, ' . strtolower($name),
                'meta_tags' => $name . ', fashion, collection, premium, designer'
            ];
        } elseif ($type === 'product') {
            $suggestions = [
                'meta_title' => $name . ' - Aiman Royale',
                'meta_description' => 'Shop ' . $name . ' at Aiman Royale. ' . ($description ? substr(strip_tags($description), 0, 150) . '...' : 'Premium quality product with exceptional design.'),
                'meta_keyword' => $name . ', aiman royale, premium fashion, designer wear',
                'meta_tags' => $name . ', fashion, premium, designer, product'
            ];
        }

        return response()->json($suggestions);
    }
}
