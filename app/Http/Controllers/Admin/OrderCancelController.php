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
}
