<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function index(){

    $user_id = auth()->id();

    $carts = DB::table('carts')
    ->join('products', 'carts.product_id',  '=', 'products.id')
    ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
    ->leftJoin('product_images', function($join) {
        $join->on('carts.product_id', '=', 'product_images.product_id')
             ->whereRaw('product_images.id = (SELECT MIN(id) FROM product_images WHERE product_id = carts.product_id)');
    })
    ->where('user_id', $user_id)
    ->select(
        'carts.*',
        'products.name',
        'product_variants.*',
        'product_images.image'
    )
    ->get();


        return view('web.checkout', compact('carts'));
    }

    public function placeOrder(Request $request){
        
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pinCode' => 'required|string|max:10',
        ]);

        $user_id = auth()->id();
        
        // Get cart items
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
            ->where('user_id', $user_id)
            ->select('carts.*', 'products.name', 'product_variants.discount_price')
            ->get();

        if($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        // Calculate total
        $subtotal = $carts->sum(function($cart) { 
            return $cart->discount_price * $cart->count; 
        });
        $shipping = 7.00;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Create order
        $order_id = DB::table('orders')->insertGetId([
            'user_id' => $user_id,
            // 'first_name' => $request->firstName,
            // 'last_name' => $request->lastName,
            // 'email' => $request->email,
            'phone_no' => $request->phone,
            'address_1' => $request->address1,
            'address_2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pinCode,
            'payment_status' => 'pending',
            // 'subtotal' => $subtotal,
            // 'shipping' => $shipping,
            // 'tax' => $tax,
            'total_amount' => $total,
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create order items
        foreach($carts as $cart) {
            DB::table('ordered_products')->insert([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->count,
                'price' => $cart->discount_price,
                'total' => $cart->discount_price * $cart->count,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Store order details in session for PayPal
        session([
            'paypal_order_id' => $order_id,
            'paypal_total' => $total,
            'paypal_currency' => 'USD'
        ]);

        // Redirect to PayPal payment page
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        if (!session('paypal_order_id')) {
            return redirect()->route('checkout.index')->with('error', 'No order found');
        }

        $orderId = session('paypal_order_id');
        $total = session('paypal_total');
        $currency = session('paypal_currency');

        return view('web.payment', compact('orderId', 'total', 'currency'));
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = session('paypal_order_id');
        
        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found');
        }

        // Update order status to paid
        DB::table('orders')->where('id', $orderId)->update([
            'order_status' => 'paid',
            'payment_status' => 'paid',
            'paid_at' => now(),
            'updated_at' => now()
        ]);

        // Clear cart
        DB::table('carts')->where('user_id', auth()->id())->delete();

        // Clear PayPal session
        session()->forget(['paypal_order_id', 'paypal_total', 'paypal_currency']);

        return redirect()->route('page.index')->with('success', 'Payment successful! Order placed.');
    }

    public function paymentCancel()
    {
        // Clear PayPal session
        session()->forget(['paypal_order_id', 'paypal_total', 'paypal_currency']);
        
        return redirect()->route('checkout.index')->with('error', 'Payment was cancelled. Please try again.');
    }

    public function orderSuccess()
    {
        return view('web.order-success');
    }
}
