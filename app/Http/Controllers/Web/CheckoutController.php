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
    ->join('product_images', 'carts.product_id', '=', 'product_images.product_id')
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
            return $cart->discount_price * $cart->quantity; 
        });
        $shipping = 7.00;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Create order
        $order_id = DB::table('orders')->insertGetId([
            'user_id' => $user_id,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pinCode,
            'description' => $request->description,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create order items
        foreach($carts as $cart) {
            DB::table('order_items')->insert([
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->quantity,
                'price' => $cart->discount_price,
                'total' => $cart->discount_price * $cart->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Clear cart
        DB::table('carts')->where('user_id', $user_id)->delete();

        return redirect()->route('page.index')->with('success', 'Order placed successfully!');
    }
}
