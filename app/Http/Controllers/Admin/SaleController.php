<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Order::withCount('orderProducts')
            ->with(['orderProducts.product'])
            ->where('is_fake_order', true)
            ->latest()
            ->paginate(10);
        return view('Admin.sales.index', compact('sales'));
    }

    // public function create()
    // {
    //     $products = Product::where('status', 'active')->get();
    //     $variants = ProductVariant::all();
    //     return view('Admin.sales.create', compact('products', 'variants'));
    // }

    public function create()
    {
        try {
            $products = Product::where('status', 'active')->get();
            return view('Admin.sales.create', compact('products'));
        } catch (\Exception $e) {
            \Log::error('Error in create method: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            dd($e->getMessage()); // This will show the actual error
        }
    }

    public function getProductVariants($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['variants' => []]);
        }

        // Get actual variants from the database
        $variants = ProductVariant::where('product_id', $productId)
            ->where('stock', '>', 0) // Only show variants in stock
            ->get(['id', 'size', 'color', 'sku', 'price', 'discount_price'])
            ->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'name' => $variant->display_name ?? ($variant->color ? $variant->color : $variant->size),
                    'price' => $variant->effective_price,
                    'sku' => $variant->sku,
                    'size' => $variant->size,
                    'color' => $variant->color
                ];
            });

        return response()->json([
            'variants' => $variants
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'order_status' => 'required|in:pending,confirmed,paid,shipped,delivered,cancelled,returned',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'address_1' => 'required|string|max:100',
            'address_2' => 'nullable|string|max:100',
            'state' => 'required|string|max:50',
            'city' => 'required|string|max:25',
            'pincode' => 'required|string|max:6',
            'phone_no' => 'required|string|max:12',
            'is_fake_order' => 'boolean'
        ]);

        // Create the fake order
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'phone_no' => $request->phone_no,
            'is_fake_order' => $request->boolean('is_fake_order', true),
            'order_date' => now(),
            'cod_fee' => '0.00'
        ]);

        // Get product details
        $product = Product::find($request->product);

        // Log the request data for debugging
        \Log::info('Sale Store Request Data:', [
            'request_data' => $request->all(),
            'product_id' => $request->product,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'product_found' => $product ? true : false
        ]);

        if ($product) {
            // Create order product entry
            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $request->product,
                'variant_id' => '1',
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total' => $request->total_amount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'order_date' => now(),
                'user_id' => $request->user_id
            ]);

            // Log the created order product
            \Log::info('OrderProduct Created:', [
                'order_product_id' => $orderProduct->id,
                'order_id' => $order->id,
                'product_id' => $request->product,
                'quantity' => $request->quantity,
                'total' => $request->total_amount
            ]);
        } else {
            \Log::error('Product not found for ID: ' . $request->product);
        }

        // Clear any previous session data to avoid conflicts
        session()->forget(['success', 'error']);

        return redirect()->to('/admin/sales/create')
            ->with('success', 'Fake order created successfully!');
    }

    public function edit(Sale $sale)
    {
        $products = Product::where('status', 'active')->get();
        $selectedProducts = $sale->products()->pluck('products.id')->toArray();
        return view('Admin.sales.edit', compact('sale', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $sale->update([
            'name' => $request->name,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'is_active' => $request->boolean('is_active'),
            'starts_at' => $request->starts_at ? $request->starts_at : null,
            'ends_at' => $request->ends_at ? $request->ends_at : null,
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($sale->banner_image) {
                Storage::delete('public/uploads/sales/' . $sale->banner_image);
            }

            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sales'), $imageName);
            $sale->banner_image = $imageName;
        }

        // Sync selected products
        if ($request->has('products')) {
            $sale->products()->sync($request->products);
        } else {
            $sale->products()->detach();
        }

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        // Delete banner image
        if ($sale->banner_image) {
            Storage::delete('public/uploads/sales/' . $sale->banner_image);
        }

        $sale->delete();
        return redirect()->route('Admin.sales.index')
            ->with('success', 'Sale deleted successfully!');
    }

    public function toggleStatus(Sale $sale)
    {
        $sale->update(['is_active' => !$sale->is_active]);

        $status = $sale->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Sale {$status} successfully!");
    }
}
