<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class OrderCancelController extends Controller
{
    public function index(Request $request)
{
    $search = trim($request->input('search', ''));

    $orders = Order::with('user')
        ->where('order_status', 'cancelled')
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)                              // exact order ID
                  ->orWhere('transaction_id', 'like', "%{$search}%")  // transaction ID
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();
    return view('Admin.cancel-order.index', compact('orders'));
}

    public function details(Request $request)
    {
        $orderId = $request->get('order_id');

        $cancelOrder = Order::where('id', $orderId)->first();

        if (!$cancelOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Cancel order not found.',
            ], 404);
        }

        $order = $cancelOrder;

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order?->id,
                'order_id' => $order?->id,
                'waybill_number' => $order->waybill_number,
                'customer_name' => $order->customer_name,
                'total_amount' => $order?->total_amount,
                'refund_status' => $order?->refund_status,
                'refunds' => $order?->refunds()->latest()->get(),
            ]
        ]);
    }
}
