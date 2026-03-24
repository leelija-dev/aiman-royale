<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderProducts.product'])
            ->where('is_fake_order', false)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->get();
        $variants = ProductVariant::all();
        return view('admin.orders.create', compact('products', 'variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'order_status' => 'required|in:pending,confirmed,paid,shipped,delivered,cancelled,returned',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'phone_no' => 'nullable|string|max:20',
            'is_fake_order' => 'boolean'
        ]);

        // Create the order
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

        // Attach products to order
        if ($request->has('products')) {
            foreach ($request->products as $productId) {
                // Get product details
                $product = Product::find($productId);

                if ($product) {
                    // Create order product entry
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'quantity' => 1, // Default quantity
                        'price' => $product->price,
                        'total' => $product->price,
                        'status' => 'pending',
                        'payment_status' => 'pending',
                        'order_date' => now(),
                        'user_id' => $request->user_id
                    ]);
                }
            }
        }

        return redirect()->route('admin.sales.index')
            ->with('success', 'Fake order created successfully!');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderProducts.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,paid,shipped,delivered,cancelled,returned'
        ]);

        $order->update([
            'order_status' => $request->status
        ]);

        return redirect()->back()
            ->with('success', 'Order status updated successfully!');
    }

    public function updateTracking(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number
        ]);

        return redirect()->back()
            ->with('success', 'Tracking number updated successfully!');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,confirmed,paid,shipped,delivered,cancelled,returned'
        ]);

        Order::whereIn('id', $request->order_ids)
            ->update(['order_status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Orders status updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('search');

        $orders = Order::with(['user', 'orderProducts.product'])
            ->where(function ($q) use ($query) {
                $q->where('id', 'like', "%{$query}%")
                    ->orWhereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%");
                    })
                    ->orWhereHas('orderProducts.product', function ($productQuery) use ($query) {
                        $productQuery->where('name', 'like', "%{$query}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'confirmed_orders' => Order::where('order_status', 'confirmed')->count(),
            'paid_orders' => Order::where('order_status', 'paid')->count(),
            'shipped_orders' => Order::where('order_status', 'shipped')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),
            'cancelled_orders' => Order::where('order_status', 'cancelled')->count(),
            'returned_orders' => Order::where('order_status', 'returned')->count(),
            'total_revenue' => Order::where('order_status', 'delivered')->sum('total_amount'),
            'this_month_orders' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'this_month_revenue' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('order_status', 'delivered')
                ->sum('total_amount'),
        ];

        return response()->json($stats);
    }
}
