<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReverseOrder;

class ReturnOrder extends Controller
{
    //
    public function index()
    {
        $orders = ReverseOrder::with('order', 'items', 'requestedBy')->get();
        // dd($orders);
        return view('admin.return-order.index', compact('orders'));
    }
}
