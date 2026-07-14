<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CashfreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Address;

class CheckoutController extends Controller
{
    //
    public function index()
    {

        $user_id = auth()->id();

        $carts = DB::table('carts')
            ->join('products', 'carts.product_id',  '=', 'products.id')
            ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
            ->leftJoin('product_images', function ($join) {
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

        $occasions = \App\Models\Occasion::active()->get();

        // Load user addresses
        $addresses = Address::where('user_id', $user_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($addresses);

        if (count($carts) == 0) {
            session()->flash('force_cart_refresh', true);
            return redirect()->route('cart.index');
        }

        return view('web.checkout', compact('carts', 'occasions', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
       

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


        $checkItsAddress = Address::where('user_id', $user_id)->exists();
        if (!$checkItsAddress) {
            DB::table('addresses')->insert([
                'user_id' => $user_id,
                'full_name' => $request->firstName . " " . $request->lastName,
                'phone' => $request->phone,
                'address_1' => $request->address1,
                'address_2' => $request->address2 ?? '',
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?? '',
                'pincode' => $request->pinCode,
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // Get cart items
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
            ->where('user_id', $user_id)
            ->select('carts.*', 'products.name', 'product_variants.price as variant_price', 'product_variants.discount as discount', 'product_variants.discount_price')
            ->get();

             dd($carts);
        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }
        // print_r($carts->variant_price);die;
        // Calculate total
        $subtotal = $carts->sum(function ($cart) {
            // dd($cart->variant_price - $cart->discount_price);
            return (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count);
        });
        // $shipping = 7.00;
        // $tax = $subtotal * 0.05;
        if($subtotal <= 400) {
            $shipping = 0;
        } else {
            $shipping = 0;
        }
        $total = $subtotal + $shipping; //+ $shipping + $tax;

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
        foreach ($carts as $cart) {
            DB::table('ordered_products')->insert([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->count,
                'price' => $cart->discount_price,
                'total' => (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Store order details in session for Cashfree
        session([
            'cashfree_order_id' => $order_id,
            'cashfree_total' => $total,
            'cashfree_currency' => 'INR'
        ]);

        // Redirect to Cashfree payment page
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        if (!session('cashfree_order_id')) {
            return redirect()->route('checkout.index')->with('error', 'No order found');
        }

        $orderId = session('cashfree_order_id');
        $total = session('cashfree_total');
        $currency = session('cashfree_currency');

        return view('web.payment', compact('orderId', 'total', 'currency'));
    }

    public function createPaymentSession(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|string',
                'total' => 'required|numeric|min:1',
                'currency' => 'required|string|max:3'
            ]);

            $orderId = $request->order_id;
            $total = $request->total;
            $currency = $request->currency;

            // Generate unique Cashfree order ID
            $cashfreeOrderId = 'CF_' . $orderId . '_' . time();

            $cashfreeService = new CashfreeService();

            // Get customer details
            $user = Auth::user();
            $customerDetails = [
                'customer_id' => (string) $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email ?? 'customer@example.com',
                'customer_phone' => '9999999999', // You should get this from user profile or form
            ];

            // Create Cashfree order
            $orderResponse = $cashfreeService->createOrder($cashfreeOrderId, $total, $customerDetails);

            if (!$orderResponse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create payment order. Please try again.'
                ], 500);
            }

            // Get payment session ID from order creation response
            $paymentSessionId = $orderResponse['payment_session_id'] ?? null;

            if (!$paymentSessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to initiate payment. Please try again.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'payment_session_id' => $paymentSessionId,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            Log::error('Payment session creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initiation failed. Please try again.'
            ], 500);
        }
    }

    public function processCOD(Request $request)
    {
        // dd($request);
        try {
            $request->validate([
                'order_id' => 'required|string',
                'total' => 'required|numeric|min:1',
                'currency' => 'required|string|max:3'
            ]);

            $orderId = $request->order_id;
            $total = $request->total;
            $currency = $request->currency;

            // Debug logging
            Log::info('COD Processing - Order ID: ' . $orderId . ', Total: ' . $total . ', Currency: ' . $currency);

            // Update order status for COD
            $updateData = [
                'order_status' => 'confirmed',
                'payment_status' => 'cod',
                'payment_method' => 'cash_on_delivery',
                'updated_at' => now()
            ];

            $affected = DB::table('orders')->where('id', $orderId)->update($updateData);
            
            Log::info('COD order processed: ' . $orderId . ', Affected rows: ' . $affected);

            // Get order details to reduce stock
            $order = DB::table('orders')->where('id', $orderId)->first();
            if ($order) {
                // Get ordered products to reduce stock
                $orderedProducts = DB::table('ordered_products')->where('order_id', $orderId)->get();
                
                foreach ($orderedProducts as $orderedProduct) {
                    if ($orderedProduct->variant_id) {
                        // Reduce stock from product_variants table
                        $stockReduced = DB::table('product_variants')
                            ->where('id', $orderedProduct->variant_id)
                            ->where('stock', '>=', $orderedProduct->quantity)
                            ->decrement('stock', $orderedProduct->quantity);
                            
                        Log::info('Stock reduced - Variant ID: ' . $orderedProduct->variant_id . 
                                  ', Quantity: ' . $orderedProduct->quantity . 
                                  ', Stock Reduced: ' . $stockReduced);
                    }
                }
            }

            // Clear cart
            DB::table('carts')->where('user_id', auth()->id())->delete();

            // Clear session
            session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency']);

            return redirect()->route('page.index')->with('success', 'Order placed successfully! You will pay cash on delivery.');
        } catch (\Exception $e) {
            Log::error('COD processing error: ' . $e->getMessage());
            return redirect()->route('checkout.payment')->with('error', 'Failed to process COD order. Please try again.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        // Log all request data for debugging
        Log::info('Payment success request received:', [
            'all_query_params' => $request->query->all(),
            'all_request_data' => $request->all(),
            'transaction_id' => $request->input('transaction_id'),
            'cf_transaction_id' => $request->input('cf_transaction_id'),
            'payment_transaction_id' => $request->input('payment_transaction_id'),
            'session_order_id' => session('cashfree_order_id')
        ]);

        $orderId = session('cashfree_order_id');
        $cashfreeOrderId = session('cashfree_order_id'); // This is the Cashfree order ID

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found');
        }

        // Update order status to paid
        $updateData = [
            'order_status' => 'paid',
            'payment_status' => 'paid',
            'payment_method' => 'cashfree',
            'paid_at' => now(),
            'updated_at' => now()
        ];

        // Add transaction_id if available from request parameters
        if ($request->has('transaction_id')) {
            $updateData['transaction_id'] = $request->input('transaction_id');
        } elseif ($request->has('cf_transaction_id')) {
            $updateData['transaction_id'] = $request->input('cf_transaction_id');
        } elseif ($request->has('payment_transaction_id')) {
            $updateData['transaction_id'] = $request->input('payment_transaction_id');
        }

        // Also check for other possible transaction ID fields in request
        $possibleTransactionFields = [
            'tx_id',
            'txn_id',
            'payment_id',
            'cf_payment_id',
            'gateway_transaction_id',
            'bank_transaction_id'
        ];

        foreach ($possibleTransactionFields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $updateData['transaction_id'] = $request->input($field);
                break;
            }
        }

        // If no transaction_id from request, try to get it from Cashfree API
        if (!isset($updateData['transaction_id']) && $cashfreeOrderId) {
            try {
                $cashfreeService = new CashfreeService();
                $orderDetails = $cashfreeService->getOrderDetails($cashfreeOrderId);

                Log::info('Cashfree order details retrieved:', ['order_details' => $orderDetails]);

                // Look for transaction ID in order details
                if (isset($orderDetails['transaction_id'])) {
                    $updateData['transaction_id'] = $orderDetails['transaction_id'];
                } elseif (isset($orderDetails['cf_transaction_id'])) {
                    $updateData['transaction_id'] = $orderDetails['cf_transaction_id'];
                } elseif (isset($orderDetails['payment_transaction_id'])) {
                    $updateData['transaction_id'] = $orderDetails['payment_transaction_id'];
                }

                // Also check for other possible fields in order details
                if (!isset($updateData['transaction_id'])) {
                    $possibleFields = ['tx_id', 'txn_id', 'payment_id', 'cf_payment_id'];
                    foreach ($possibleFields as $field) {
                        if (isset($orderDetails[$field]) && !empty($orderDetails[$field])) {
                            $updateData['transaction_id'] = $orderDetails[$field];
                            break;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to get Cashfree order details: ' . $e->getMessage());
            }
        }

        DB::table('orders')->where('id', $orderId)->update($updateData);

        Log::info('Order updated in paymentSuccess: ' . $orderId . ' with transaction_id: ' . ($updateData['transaction_id'] ?? 'N/A'));

        // Update stock for ordered items
        try {
            $orderItems = DB::table('ordered_products')->where('order_id', $orderId)->get();
            
            foreach ($orderItems as $item) {
                if ($item->variant_id) {
                    // Decrease stock for the variant
                    $updated = DB::table('product_variants')
                        ->where('id', $item->variant_id)
                        ->where('stock', '>', 0) // Ensure we don't go below 0
                        ->decrement('stock', $item->quantity);
                    
                    if ($updated) {
                        Log::info('Stock updated for variant ' . $item->variant_id . ', decreased by ' . $item->quantity);
                    } else {
                        Log::warning('Failed to update stock for variant ' . $item->variant_id . ' - insufficient stock or variant not found');
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to update stock after payment: ' . $e->getMessage());
            // Continue with payment success even if stock update fails
        }

        // Clear cart
        DB::table('carts')->where('user_id', auth()->id())->delete();

        // Clear Cashfree session
        session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency']); 

        // return redirect()->route('page.index')->with('success', 'Payment successful! Order placed.');
        return redirect()->route('user.order-history', base64_encode(Auth::user()->id))->with('success', 'Payment successful! Order placed.');

    }

    public function paymentCancel()
    {
        // Clear Cashfree session
        session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency']);

        session()->flash('force_cart_refresh', true);
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled. Please try again.');
    }

    public function orderSuccess()
    {
        return view('web.order-success');
    }

    /**
     * Handle Cashfree webhook notifications
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        // Log all webhook data for debugging
        Log::info('Cashfree webhook received:', [
            'all_data' => $data,
            'headers' => $request->headers->all(),
            'order_id' => $data['order_id'] ?? 'not_found',
            'transaction_id' => $data['transaction_id'] ?? 'not_found',
            'cf_transaction_id' => $data['cf_transaction_id'] ?? 'not_found',
            'payment_transaction_id' => $data['payment_transaction_id'] ?? 'not_found',
            'order_status' => $data['order_status'] ?? 'not_found'
        ]);

        $orderId = $data['order_id'] ?? null;
        $signature = $request->header('x-webhook-signature');

        if (!$orderId || !$signature) {
            return response()->json(['error' => 'Missing required data'], 400);
        }

        $cashfreeService = new CashfreeService();

        // Verify signature
        if (!$cashfreeService->verifySignature($orderId, $signature, $data)) {
            Log::error('Cashfree webhook signature verification failed for order: ' . $orderId);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // Process payment based on status
        $orderStatus = $data['order_status'] ?? null;

        if ($orderStatus === 'PAID') {
            // Update order status
            $updateData = [
                'order_status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now(),
                'updated_at' => now()
            ];

            // Add transaction_id if available in webhook data
            if (isset($data['transaction_id'])) {
                $updateData['transaction_id'] = $data['transaction_id'];
            } elseif (isset($data['cf_transaction_id'])) {
                $updateData['transaction_id'] = $data['cf_transaction_id'];
            } elseif (isset($data['payment_transaction_id'])) {
                $updateData['transaction_id'] = $data['payment_transaction_id'];
            }

            // Also check for other possible transaction ID fields
            $possibleTransactionFields = [
                'tx_id',
                'txn_id',
                'payment_id',
                'cf_payment_id',
                'gateway_transaction_id',
                'bank_transaction_id'
            ];

            foreach ($possibleTransactionFields as $field) {
                if (isset($data[$field]) && !empty($data[$field])) {
                    $updateData['transaction_id'] = $data[$field];
                    break;
                }
            }

            DB::table('orders')->where('id', $orderId)->update($updateData);

            Log::info('Order marked as paid: ' . $orderId . ' with transaction_id: ' . ($updateData['transaction_id'] ?? 'N/A'));
        } elseif ($orderStatus === 'FAILED') {
            // Update order status to failed
            DB::table('orders')->where('id', $orderId)->update([
                'order_status' => 'failed',
                'payment_status' => 'failed',
                'updated_at' => now()
            ]);

            Log::info('Order marked as failed: ' . $orderId);
        }

        return response()->json(['status' => 'success']);
    }
}
