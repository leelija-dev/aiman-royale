<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\StockIn;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductVariant::with(['product', 'colorModel', 'sizeModel']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                    ->orWhere('size', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        if ($request->filled('color')) {
            $query->where('color', $request->input('color'));
        }

        if ($request->filled('size')) {
            $query->where('size', $request->input('size'));
        }

        $data = $query->orderBy('product_id')->orderBy('color')->orderBy('size')->paginate(15);

        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.index', compact('data', 'products', 'colors', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.create', compact('products', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50',
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
        ], [
            'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
        ]);

        // Custom validation for unique combination of product_id, size, and color
        $existingVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'] ?? '')
            ->where('color', $data['color'] ?? '')
            ->first();

        if ($existingVariant) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
        }

        $variant = ProductVariant::create($data);

        // Create stock entry for the new variant
        StockIn::create([
            'product_variant_id' => $variant->id,
            'stock' => $data['stock'],
        ]);

        return redirect()->route('admin.product-variants')->with('success', 'Product variant created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.edit', compact('productVariant', 'products', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50',
            'sku' => 'required|string|max:100|unique:product_variants,sku,' . $productVariant->id,
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            // 'stock' => 'required|integer|min:0',
        ], [
            'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
        ]);

        // Custom validation for unique combination of product_id, size, and color (excluding current variant)
        $existingVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'] ?? '')
            ->where('color', $data['color'] ?? '')
            ->where('id', '!=', $productVariant->id)
            ->first();

        if ($existingVariant) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
        }

        // $productVariant->update($data);
        $productVariant->update([
            'product_id'      => $request->product_id,
            'sku'             => $request->sku,
            'price'           => $request->price,
            'discount_price'  => $request->discount_price,
            'color'           => $request->color,
            'size'            => $request->size,
        ]);


        // Note: Stock is managed separately through Stock Management
        // Stock entry is not updated here since stock field is readonly in edit form

        return redirect()->route('admin.product-variants')->with('success', 'Product variant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        // Delete the associated stock entry
        StockIn::where('product_variant_id', $productVariant->id)->delete();

        $productVariant->delete();

        return redirect()->route('admin.product-variants')->with('success', 'Product variant deleted successfully!');
    }

    /**
     * Get variants for a specific product (AJAX endpoint).
     */
    public function getByProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $variants = ProductVariant::with(['colorModel', 'sizeModel'])
            ->where('product_id', $productId)
            ->orderBy('color')
            ->orderBy('size')
            ->get();

        return response()->json($variants);
    }
}
