<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPart;
use Illuminate\Http\Request;

class ProductPartController extends Controller
{
    /**
     * Store a new product part
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'fabric' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'embroidery' => 'nullable|string|max:255',
            'lining' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0'
        ]);

        $product = Product::findOrFail($productId);
        
        // Get the highest current order and add 1
        $maxOrder = $product->parts()->max('order') ?? 0;
        
        $part = $product->parts()->create([
            'part_name' => $request->part_name,
            'fabric' => $request->fabric,
            'color' => $request->color,
            'pattern' => $request->pattern,
            'embroidery' => $request->embroidery,
            'lining' => $request->lining,
            'description' => $request->description,
            'order' => $request->order ?? ($maxOrder + 1)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product part added successfully',
            'part' => $part
        ]);
    }

    /**
     * Update a product part
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'fabric' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'embroidery' => 'nullable|string|max:255',
            'lining' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0'
        ]);

        $part = ProductPart::findOrFail($id);
        $part->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product part updated successfully',
            'part' => $part
        ]);
    }

    /**
     * Delete a product part
     */
    public function destroy($id)
    {
        $part = ProductPart::findOrFail($id);
        $part->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product part deleted successfully'
        ]);
    }

    /**
     * Get all parts for a product
     */
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $parts = $product->parts()->ordered()->get();

        return response()->json([
            'success' => true,
            'parts' => $parts
        ]);
    }
}
