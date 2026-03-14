<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderProducts.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.orders.index', compact('orders'));
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
            ->where(function($q) use ($query) {
                $q->where('id', 'like', "%{$query}%")
                  ->orWhereHas('user', function($userQuery) use ($query) {
                      $userQuery->where('name', 'like', "%{$query}%")
                                ->orWhere('email', 'like', "%{$query}%");
                  })
                  ->orWhereHas('orderProducts.product', function($productQuery) use ($query) {
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
