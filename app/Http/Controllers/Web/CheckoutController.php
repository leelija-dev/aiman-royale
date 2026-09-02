<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\CashfreeService;
use App\Services\DelhiveryService;
use App\Services\WhatsAppService;
use App\Services\MetaConversionsService;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Store;

class CheckoutController extends Controller
{
    protected $delhiveryService;
    protected $whatsAppService;
    protected $metaService;

    public function __construct(DelhiveryService $delhiveryService, WhatsAppService $whatsAppService, MetaConversionsService $metaService)
    {
        $this->delhiveryService = $delhiveryService;
        $this->whatsAppService = $whatsAppService;
        $this->metaService = $metaService;
    }


    public function index()
    {
        $user_id = auth()->id();
        $checkoutSource = session('checkout_source', 'cart');

        if ($checkoutSource === 'buy_now') {
            $carts = $this->getBuyNowItems();
            // dd($carts);
        } else {
            $carts = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
                ->leftJoin('product_images', function ($join) {
                    $join->on('carts.product_id', '=', 'product_images.product_id')
                        ->whereRaw('product_images.id = (SELECT MIN(id) FROM product_images WHERE product_id = carts.product_id)');
                })
                ->where('user_id', $user_id)
                ->select(
                    'carts.id as cart_id',
                    'carts.*',
                    'products.name',
                    'product_variants.*',
                    'product_images.image'
                )
                ->get();
        }


        $occasions = \App\Models\Occasion::active()->get();


        $addresses = Address::where('user_id', $user_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();


        if (count($carts) == 0) {
            session()->flash('force_cart_refresh', true);
            return redirect()->route('cart.index');
        }
        $store = Store::where('is_active', true)->first();
        $coupon = Coupon::where('code_type', 'special-discount')->where('is_active', true)->first();
        return view('web.checkout', compact('carts', 'occasions', 'addresses', 'store', 'coupon'));
    }


    /**
     * Check pincode serviceability via AJAX
     */
    public function checkPincode(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6'
        ]);


        $result = $this->delhiveryService->isPincodeServiceable($request->pincode);

        return response()->json($result);
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
            'pinCode' => 'required|string|size:6',
            // 'grand_total' => 'required|numeric|min:1',
        ]);

        // Track InitiateCheckout event when user starts checkout
        try {
            $user_id = auth()->id();
            $checkoutSource = session('checkout_source', 'cart');

            if ($checkoutSource === 'buy_now') {
                $carts = $this->getBuyNowItems();
            } else {
                $carts = DB::table('carts')
                    ->where('user_id', $user_id)
                    ->get();
            }

            $contentIds = [];
            $numItems = 0;
            $totalValue = 0;

            foreach ($carts as $cart) {
                $contentIds[] = $cart->product_id;
                $numItems += $cart->count;
                $totalValue += ($cart->discount_price ?? $cart->price) * $cart->count;
            }

            $checkoutData = [
                'content_ids' => $contentIds,
                'value' => $totalValue,
                'num_items' => $numItems,
            ];

            $this->metaService->trackInitiateCheckout($checkoutData);

            Log::info('Meta InitiateCheckout event tracked on placeOrder');
        } catch (\Exception $e) {
            Log::error('Failed to track Meta InitiateCheckout on placeOrder: ' . $e->getMessage());
        }

        // Check pincode serviceability
        // $serviceability = $this->delhiveryService->isPincodeServiceable($request->pinCode);

        // if (!$serviceability['serviceable']) {
        //     return back()
        //         ->withInput()
        //         ->with('error', $serviceability['message'] . ' (Pincode: ' . $request->pinCode . ')');
        // }

        // Check pincode serviceability
        $serviceability = $this->delhiveryService->isPincodeServiceable($request->pinCode);

        if (!$serviceability['serviceable']) {
            return back()
                ->withInput()
                ->withErrors([
                    'pinCode' => $serviceability['message'] . ' (' . $request->pinCode . ')'
                ]);
        }
        Log::info("serviceability", $serviceability);
        // For COD orders, specifically check COD availability
        $paymentMethod = $request->input('payment_method', 'cashfree');
        if ($paymentMethod === 'cod' && isset($serviceability['cod_available']) && !$serviceability['cod_available']) {
            return back()
                ->withInput()
                ->with('error', 'Cash on Delivery is not available for this pincode. Please choose online payment.');
        }

        $user_id = auth()->id();
        $fullName = $request->firstName . " " . $request->lastName;

        // Save address if not exists
        $checkItsAddress = Address::where('user_id', $user_id)->exists();
        if (!$checkItsAddress) {
            DB::table('addresses')->insert([
                'user_id' => $user_id,
                'full_name' => $fullName,
                'phone' => $request->phone,
                'address_1' => $request->address1,
                'address_2' => $request->address2 ?? '',
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?? 'India',
                'pincode' => $request->pinCode,
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        //Remove session 
        session()->forget('applied_coupons');
        
        $checkoutSource = session('checkout_source', 'cart');

        if ($checkoutSource === 'buy_now') {
            $carts = $this->getBuyNowItems();
        } else {
            $carts = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
                ->where('user_id', $user_id)
                ->select(
                    'carts.*',
                    'products.name',
                    'product_variants.price as variant_price',
                    'product_variants.discount as discount',
                    'product_variants.discount_price'
                )
                ->get();
        }

        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        // Calculate total
        // $subtotal = $carts->sum(function ($cart) {
        //     return (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count);
        // });

        $shipping = 0;
        // $total = $request->grand_total;//$subtotal + $shipping;
        $total = (float) $request->input('grand_total');
        $gst_percentage = $request->input('gst_percentage');
        $gst_amount = $request->input('gst_amount');
        $special_discount = $request->input('special_discount_percentage');
        $special_discount_id = $request->input('special_discount_id');
        $special_discount_code = $request->input('special_discount_name');
        $special_discount_amount = $request->input('special_discount_amount');
        // Get payment method
        $paymentMethod = $request->input('payment_method', 'cashfree');
        $customerName = $request->firstName . " " . $request->lastName;
        // Create order
        $order_id = DB::table('orders')->insertGetId([
            'user_id' => $user_id,
            'customer_name' => $customerName,
            'phone_no' => $request->phone,
            'address_1' => $request->address1,
            'address_2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pinCode,
            'payment_status' => 'pending',
            'payment_method' => $paymentMethod === 'cod' ? 'cod' : null,
            'total_amount' => $total,
            'gst_percentage' => $gst_percentage ?? 0,
            'gst_amount' => $gst_amount,    #$total * ($gst_percentage ?? 0) / 100,
            'special_discount' => $special_discount ?? 0,
            'special_discount_amount' =>  $special_discount_amount ?? 0,
            'special_discount_id' => $special_discount_id ?? null,
            'special_discount_name' => $special_discount_code  ?? null,
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create order items and prepare for shipment
        $orderItems = [];
        $appliedCoupons = json_decode($request->applied_coupons, true) ?? $request->applied_coupons ?? [];
        foreach ($carts as $cart) {
            $itemTotal = (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count);
            // Log::info("cart id " . $cart->id);
            $couponId = null;
            $couponCode = null;
            $couponDiscount = null;
            $couponDiscountAmount = null;
            if (isset($appliedCoupons[$cart->id])) {

                // Log::info("Coupon Found");

                $couponId = $appliedCoupons[$cart->id]['coupon_id'] ?? '';
                $couponCode = $appliedCoupons[$cart->id]['coupon_code'] ?? '';
                $couponDiscount = $appliedCoupons[$cart->id]['coupon_discount'] ?? 0;
                $couponDiscountAmount = $appliedCoupons[$cart->id]['coupon_discount_amount'] ?? 0;

                // Log::info([
                //     'couponId' => $couponId,
                //     'couponCode' => $couponCode,
                // ]);
            }
            DB::table('ordered_products')->insert([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->count,
                'price' => $cart->discount_price,

                'coupon_id'    => $couponId,
                'coupon_code'  => $couponCode,
                'coupon_discount' => $couponDiscount,
                'coupon_discount_amount' => $couponDiscountAmount,

                'total' => (float)$itemTotal - (float)$couponDiscountAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $orderItems[] = (object)[
                'variant_id' => $cart->variant_id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->count,
                'price' => $cart->discount_price,
                'name' => $cart->name
            ];
        }

        if ($checkoutSource === 'buy_now') {
            session()->forget(['checkout_payload', 'checkout_source']);
        } else {
            session()->forget('applied_coupons');
            DB::table('carts')->where('user_id', $user_id)->delete();
        }

        // For COD orders, create Delhivery shipment immediately
        if ($paymentMethod === 'cod') {
            $shipmentResult = $this->createDelhiveryShipment($order_id, $request, $orderItems, $total, 'cod');

            if (!$shipmentResult['success']) {
                // Delete order if shipment creation fails
                DB::table('orders')->where('id', $order_id)->delete();
                DB::table('ordered_products')->where('order_id', $order_id)->delete();
                return back()->with('error', 'Unable to create shipment: ' . $shipmentResult['message']);
            }

            // Update order with waybill number if available
            if (isset($shipmentResult['waybill'])) {
                DB::table('orders')
                    ->where('id', $order_id)
                    ->update(['waybill_number' => $shipmentResult['waybill']]);
            }
        }

        //  SEND WHATSAPP CONFIRMATION
        //         try {
        //             $whatsappService = new \App\Services\WhatsAppService();

        //             // Format phone number (remove any non-numeric characters)
        //             $phone = preg_replace('/[^0-9]/', '', $request->phone);

        //             // Send order confirmation
        //             $whatsappSent = $whatsappService->sendOrderConfirmation(
        //                 $phone,
        //                 $fullName,
        //                 $order_id
        //             );
        // // dd($whatsappSent);
        //             if ($whatsappSent) {
        //                 Log::info('WhatsApp order confirmation sent', [
        //                     'order_id' => $order_id,
        //                     'phone' => $phone,
        //                     'message_id' => $whatsappService->getLastMessageId()
        //                 ]);
        //             } else {
        //                 Log::warning('WhatsApp order confirmation failed', [
        //                     'order_id' => $order_id,
        //                     'phone' => $phone
        //                 ]);
        //             }
        //         } catch (\Exception $e) {
        //             // Don't fail the order if WhatsApp fails
        //             Log::error('WhatsApp send error: ' . $e->getMessage(), [
        //                 'order_id' => $order_id
        //             ]);
        //         }
//         Log::info([
//     'grand_total' => $total,
// ]);
        // Store order details in session
        session([
            'cashfree_order_id' => $order_id,
            'cashfree_total' => $total,
            'cashfree_currency' => 'INR',
            'payment_method' => $paymentMethod
        ]);

        // For COD, process immediately
        if ($paymentMethod === 'cod') {
            return $this->processCOD(new Request([
                'order_id' => $order_id,
                'total' => $total,
                'currency' => 'INR'
            ]));
        }
        // $this->sendOrderWhatsAppConfirmation($order_id, $request->phone, $fullName);
        // For online payment, redirect to payment
        return redirect()->route('checkout.payment');
    }
    private function getBuyNowItems()
    {
        $payload = session('checkout_payload');
        $items = $payload['items'] ?? [];

        if (empty($items)) {
            return collect();
        }

        return collect($items)->map(function ($item) {
            return (object) [
                'cart_id' => $item['cart_id'] ?? 0,
                'id' => $item['cart_id'] ?? 0,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'count' => $item['count'] ?? 1,
                'price' => $item['price'] ?? 0,
                'variant_price' => $item['price'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'discount_price' => $item['discount_price'] ?? ($item['price'] ?? 0),
                'name' => $item['name'],
                'size' => $item['size'] ?? null,
                'color' => $item['color'] ?? null,
                'image' => $item['image'] ?? null,
                'type' => $item['type'] ?? null,
                'custom_dimensions' => $item['custom_dimensions'] ?? null,
            ];
        });
    }

    /**
     * Create Delhivery shipment helper method
     */
    private function createDelhiveryShipment($orderId, $request, $orderItems, $total, $paymentMethod)
    {
        Log::info('Creating Delhivery shipment for order:', [
            'order_id' => $orderId,
            'payment_method' => $paymentMethod,
            'total' => $total,
            'items_count' => count($orderItems)
        ]);
        $customerName = $request->firstName . " " . $request->lastName;
        $fullAddress = $request->address1 . " " . ($request->address2 ?? '');

        // Generate waybill
        $waybill = $this->delhiveryService->generateWaybill();

        if (!$waybill) {
            return ['success' => false, 'message' => 'Failed to generate waybill'];
        }

        $orderData = [
            'order_id' => $orderId,
            'customer_name' => $customerName,
            'address' => $fullAddress,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pinCode,
            'phone' => $request->phone,
            'email' => $request->email,
            'total_amount' => $total,
            'payment_method' => $paymentMethod,
        ];

        $shipment = $this->delhiveryService->createShipment($orderData, $orderItems);

        if ($shipment['success'] && $shipment['waybill']) {
            DB::table('orders')->where('id', $orderId)->update([
                'waybill_number' => $shipment['waybill'],
                'shipment_id' => $shipment['shipment_id'],
                'tracking_status' => 'Shipment Created',
                'courier_name' => 'Delhivery'
            ]);
            return ['success' => true, 'message' => 'Shipment created'];
        }

        return ['success' => false, 'message' => $shipment['message'] ?? 'Shipment creation failed'];
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


    // public function createPaymentSession(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'order_id' => 'required|string',
    //             'total' => 'required|numeric|min:1',
    //             'currency' => 'required|string|max:3'
    //         ]);


    //         $orderId = $request->order_id;
    //         $total = $request->total;
    //         $currency = $request->currency;


    //         $cashfreeOrderId = 'CF_' . $orderId . '_' . time();
    //         $cashfreeService = new CashfreeService();


    //         $user = Auth::user();
    //         $customerDetails = [
    //             'customer_id' => (string) $user->id,
    //             'customer_name' => $user->name,
    //             'customer_email' => $user->email ?? 'customer@example.com',
    //             'customer_phone' => $user->phone ?? '9999999999',
    //         ];


    //         $orderResponse = $cashfreeService->createOrder($cashfreeOrderId, $total, $customerDetails);


    //         if (!$orderResponse) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to create payment order. Please try again.'
    //             ], 500);
    //         }


    //         $paymentSessionId = $orderResponse['payment_session_id'] ?? null;
    //         $transactionId = $orderResponse['order_id'] ?? $orderResponse['cf_order_id'] ?? null;
    //         if ($transactionId) {
    //             session(['transaction_id' => $transactionId]);
    //         }


    //         if (!$paymentSessionId) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to initiate payment. Please try again.'
    //             ], 500);
    //         }


    //         return response()->json([
    //             'success' => true,
    //             'payment_session_id' => $paymentSessionId,
    //             'order_id' => $orderId,
    //             'transaction_id' => $transactionId
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Payment session creation error: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Payment initiation failed. Please try again.'
    //         ], 500);
    //     }
    // }

    public function createPaymentSession(Request $request)
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

            $cashfreeOrderId = 'CF_' . $orderId . '_' . time();
            $cashfreeService = new CashfreeService();

            $user = Auth::user();
            $customerDetails = [
                'customer_id' => (string) $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email ?? 'customer@example.com',
                'customer_phone' => $user->phone ?? '9999999999',
            ];

            $orderResponse = $cashfreeService->createOrder($cashfreeOrderId, $total, $customerDetails);
            // Debugging line to check the response
            if (!$orderResponse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create payment order. Please try again.'
                ], 500);
            }

            // ✅ Store the actual Cashfree transaction ID
            $cfTransactionId = $orderResponse['cf_order_id'] ?? null;
            $paymentSessionId = $orderResponse['payment_session_id'] ?? null;

            // ✅ Store both IDs in session
            if ($cfTransactionId) {
                session([
                    'cashfree_transaction_id' => $cfTransactionId,
                    'cashfree_order_id' => $orderId,
                    'cf_order_id' => $cashfreeOrderId // Store the CF_ order ID too
                ]);
            }

            if (!$paymentSessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to initiate payment. Please try again.'
                ], 500);
            }
            Order::class::where('id', $orderId)->update(['cashfree_order_ref' => $cashfreeOrderId]);

            return response()->json([
                'success' => true,
                'payment_session_id' => $paymentSessionId,
                'order_id' => $orderId,
                'cf_order_id' => $cfTransactionId,
                'cf_transaction_id' => $cfTransactionId // Both are the same
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
        try {
            $request->validate([
                'order_id' => 'required|string',
                'total' => 'required|numeric|min:1',
                'currency' => 'required|string|max:3'
            ]);


            $orderId = $request->order_id;


            Log::info('COD Processing - Order ID: ' . $orderId);


            // Get order details
            $order = DB::table('orders')->where('id', $orderId)->first();

            if (!$order) {
                return redirect()->route('checkout.index')->with('error', 'Order not found');
            }


            // Get ordered products for stock update
            $orderedProducts = DB::table('ordered_products')->where('order_id', $orderId)->get();

            $user = Auth::user();
            // Create Delhivery shipment if not already created
            if (!$order->waybill_number) {
                // Get order details from request (stored in order table)
                $orderData = [
                    'customer_name' => $order->customer_name ?? $user->name ?? 'Customer',
                    'address' => $order->address_1 . " " . ($order->address_2 ?? ''),
                    'city' => $order->city,
                    'state' => $order->state,
                    'pincode' => $order->pincode,
                    'phone' => $order->phone_no,
                ];

                // Get products with names
                $productsWithNames = DB::table('ordered_products')
                    ->join('products', 'ordered_products.product_id', '=', 'products.id')
                    ->where('ordered_products.order_id', $orderId)
                    ->select('ordered_products.*', 'products.name')
                    ->get();

                $waybill = $this->delhiveryService->generateWaybill();

                if ($waybill) {
                    $shipmentData = [
                        'order_id' => $orderId,
                        'customer_name' => $orderData['customer_name'],
                        'address' => $orderData['address'],
                        'city' => $orderData['city'],
                        'state' => $orderData['state'],
                        'pincode' => $orderData['pincode'],
                        'phone' => $orderData['phone'],
                        'email' => $request->input('email', 'customer@example.com'),
                        'total_amount' => $order->total_amount,
                        'payment_method' => 'cod',
                    ];

                    $shipment = $this->delhiveryService->createShipment($shipmentData, $productsWithNames);

                    if ($shipment['success'] && $shipment['waybill']) {
                        DB::table('orders')->where('id', $orderId)->update([
                            'waybill_number' => $shipment['waybill'],
                            'shipment_id' => $shipment['shipment_id'],
                            'tracking_status' => 'Shipment Created',
                            'courier_name' => 'Delhivery'
                        ]);
                    }
                }
            }


            // Update order status for COD
            $updateData = [
                'order_status' => 'confirmed',
                'payment_status' => 'cod',
                'payment_method' => 'cash_on_delivery',
                'updated_at' => now()
            ];


            DB::table('orders')->where('id', $orderId)->update($updateData);


            // Reduce stock
            foreach ($orderedProducts as $orderedProduct) {
                if ($orderedProduct->variant_id) {
                    DB::table('product_variants')
                        ->where('id', $orderedProduct->variant_id)
                        ->where('stock', '>=', $orderedProduct->quantity)
                        ->decrement('stock', $orderedProduct->quantity);
                }
            }


            // Clear cart
            DB::table('carts')->where('user_id', auth()->id())->delete();
            session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency', 'payment_method']);

            // Track Purchase event for COD orders
            try {
                $contentIds = [];
                $numItems = 0;

                foreach ($orderedProducts as $item) {
                    $contentIds[] = $item->product_id;
                    $numItems += $item->quantity;
                }

                $purchaseData = [
                    'content_ids' => $contentIds,
                    'value' => $order->total_amount,
                    'num_items' => $numItems,
                    'transaction_id' => $orderId,
                ];

                $this->metaService->trackPurchase($purchaseData);

                // Store purchase data for frontend Pixel tracking
                session(['purchase_event_data' => json_encode([
                    'content_ids' => $contentIds,
                    'content_type' => 'product',
                    'value' => $order->total_amount,
                    'currency' => 'INR',
                    'num_items' => $numItems,
                    'transaction_id' => $orderId,
                ])]);

                Log::info('Meta Purchase event tracked for COD order: ' . $orderId);
            } catch (\Exception $e) {
                Log::error('Failed to track Meta Purchase event for COD: ' . $e->getMessage());
            }

            return redirect()->route('user.order-history',base64_encode(Auth::user()->id))->with('success', 'Order placed successfully! You will pay cash on delivery.');
        } catch (\Exception $e) {
            Log::error('COD processing error: ' . $e->getMessage());
            return redirect()->route('checkout.payment')->with('error', 'Failed to process COD order. Please try again.');
        }
    }



    // public function paymentSuccess(Request $request)
    // {
    //     Log::info('Payment success request received:', $request->all());

    //     $orderId = session('cashfree_order_id');

    //     if (!$orderId) {
    //         return redirect()->route('checkout.index')->with('error', 'No order found');
    //     }

    //     // Get order details
    //     $order = DB::table('orders')->where('id', $orderId)->first();

    //     if (!$order) {
    //         return redirect()->route('checkout.index')->with('error', 'Order not found');
    //     }

    //     // ✅ Create Delhivery shipment for prepaid order if not already created
    //     if (!$order->waybill_number) {
    //         Log::info('Creating Delhivery shipment for prepaid order: ' . $orderId);

    //         // Get ordered products with names
    //         $orderedProducts = DB::table('ordered_products')
    //             ->join('products', 'ordered_products.product_id', '=', 'products.id')
    //             ->where('ordered_products.order_id', $orderId)
    //             ->select('ordered_products.*', 'products.name')
    //             ->get();

    //         if ($orderedProducts->isEmpty()) {
    //             Log::error('No products found for order: ' . $orderId);
    //             return redirect()->route('checkout.index')->with('error', 'Order products not found');
    //         }

    //         // Get customer name from address
    //         $customerName = DB::table('addresses')
    //             ->where('user_id', $order->user_id)
    //             ->where('is_default', 1)
    //             ->value('full_name');

    //         if (!$customerName) {
    //             $customerName = 'Customer';
    //         }

    //         // ✅ DON'T call generateWaybill() separately
    //         // The createShipment method will automatically get a waybill

    //         $orderData = [
    //             'order_id' => $orderId,
    //             'customer_name' => $customerName,
    //             'address' => $order->address_1 . " " . ($order->address_2 ?? ''),
    //             'city' => $order->city,
    //             'state' => $order->state,
    //             'pincode' => $order->pincode,
    //             'phone' => $order->phone_no,
    //             'email' => $request->input('email', 'customer@example.com'),
    //             'total_amount' => $order->total_amount,
    //             'payment_method' => 'prepaid',
    //         ];

    //         // This will automatically generate and return a waybill
    //         $shipment = $this->delhiveryService->createShipment($orderData, $orderedProducts);

    //         if ($shipment['success'] && $shipment['waybill']) {
    //             DB::table('orders')->where('id', $orderId)->update([
    //                 'waybill_number' => $shipment['waybill'],
    //                 'shipment_id' => $shipment['shipment_id'],
    //                 'tracking_status' => 'Shipment Created',
    //                 'courier_name' => 'Delhivery'
    //             ]);
    //             Log::info('Delhivery shipment created for prepaid order: ' . $orderId . ', Waybill: ' . $shipment['waybill']);
    //         } else {
    //             Log::error('Failed to create Delhivery shipment for prepaid order: ' . $orderId, [
    //                 'shipment_response' => $shipment
    //             ]);
    //         }
    //     } else {
    //         Log::info('Shipment already exists for order: ' . $orderId . ', Waybill: ' . $order->waybill_number);
    //     }

    //     // Update order status
    //     $updateData = [
    //         'order_status' => 'paid',
    //         'payment_status' => 'paid',
    //         'payment_method' => 'cashfree',
    //         'paid_at' => now(),
    //         'updated_at' => now()
    //     ];
    //     // $serviceability = $this->whatsAppService->sendOrderConfirmation(
    //     //     '+916295351230',
    //     //     'Susmita',
    //     //     'ORD-12345'
    //     // );
    //     try {
    //         $whatsappService = new \App\Services\WhatsAppService();

    //         // Format phone number (remove any non-numeric characters)
    //         $phone = preg_replace('/[^0-9]/', '', $request->phone);

    //         // Send order confirmation
    //         $whatsappSent = $whatsappService->sendOrderConfirmation(
    //             $phone,
    //             $customerName,
    //             $orderId
    //         );
    //         // dd($whatsappSent);
    //         if ($whatsappSent) {
    //             Log::info('WhatsApp order confirmation sent', [
    //                 'order_id' => $orderId,
    //                 'phone' => $phone,
    //                 'message_id' => $whatsappService->getLastMessageId()
    //             ]);
    //         } else {
    //             Log::warning('WhatsApp order confirmation failed', [
    //                 'order_id' => $orderId,
    //                 'phone' => $phone
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         // Don't fail the order if WhatsApp fails
    //         Log::error('WhatsApp send error: ' . $e->getMessage(), [
    //             'order_id' => $orderId
    //         ]);
    //     }
    //     // dd($serviceability);
    //     // $serviceability = $this->whatsAppService->sendTextMessage($order->phone_no, "Your order #{$orderId} has been placed successfully! We will notify you once it's shipped. Thank you for shopping with us!");
    //     if ($request->has('transaction_id')) {
    //         $updateData['transaction_id'] = $request->input('transaction_id');
    //     }

    //     DB::table('orders')->where('id', $orderId)->update($updateData);

    //     // Update stock
    //     $orderItems = DB::table('ordered_products')->where('order_id', $orderId)->get();
    //     foreach ($orderItems as $item) {
    //         if ($item->variant_id) {
    //             DB::table('product_variants')
    //                 ->where('id', $item->variant_id)
    //                 ->where('stock', '>', 0)
    //                 ->decrement('stock', $item->quantity);
    //         }
    //     }

    //     // Clear cart and session
    //     DB::table('carts')->where('user_id', auth()->id())->delete();
    //     session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency', 'payment_method']);

    //     return redirect()->route('user.order-history', base64_encode(Auth::user()->id))->with('success', 'Payment successful! Order placed.');
    // }

    public function paymentSuccess(Request $request)
    {
        $cashfreeService = new CashfreeService();
        Log::info('Payment success request received:', $request->all());

        $orderId = session('cashfree_order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'No order found');
        }

        // Get order details
        $order = DB::table('orders')->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found');
        }
        //cashfree cancel
        $cashfreeOrderRef = $order->cashfree_order_ref;

        $response = $cashfreeService->getOrderDetails($cashfreeOrderRef);

        if (!$response) {
            return redirect()->route('user.order-history', base64_encode(Auth::user()->id))
                ->with('error', 'Unable to verify payment.');
        }

        if ($response['order_status'] != 'PAID') {

            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'payment_status' => 'failed'
                ]);

            return redirect()->route('user.order-history', base64_encode(Auth::user()->id))
                ->with('error', 'Payment Cancelled');
        } //end cashfree cancel
        

        // ✅ Get the actual transaction ID from session
        $transactionId = session('cashfree_transaction_id');

        // If not in session, try to get it from the request
        if (!$transactionId) {
            if ($request->has('transaction_id')) {
                $transactionId = $request->input('transaction_id');
            } elseif ($request->has('cf_transaction_id')) {
                $transactionId = $request->input('cf_transaction_id');
            }
        }

        // ✅ Create Delhivery shipment for prepaid order if not already created
        if (!$order->waybill_number) {
            Log::info('Creating Delhivery shipment for prepaid order: ' . $orderId);

            // Get ordered products with names
            $orderedProducts = DB::table('ordered_products')
                ->join('products', 'ordered_products.product_id', '=', 'products.id')
                ->where('ordered_products.order_id', $orderId)
                ->select('ordered_products.*', 'products.name')
                ->get();

            if ($orderedProducts->isEmpty()) {
                Log::error('No products found for order: ' . $orderId);
                return redirect()->route('checkout.index')->with('error', 'Order products not found');
            }

            // Get customer name from address
            $customerName = DB::table('addresses')
                ->where('user_id', $order->user_id)
                ->where('is_default', 1)
                ->value('full_name');

            if (!$customerName) {
                $customerName = 'Customer';
            }

            $orderData = [
                'order_id' => $orderId,
                'customer_name' => $order->customer_name ?? $customerName,
                'address' => $order->address_1 . " " . ($order->address_2 ?? ''),
                'city' => $order->city,
                'state' => $order->state,
                'pincode' => $order->pincode,
                'phone' => $order->phone_no,
                'email' => $request->input('email', 'customer@example.com'),
                'total_amount' => $order->total_amount,
                'payment_method' => 'prepaid',
            ];

            $shipment = $this->delhiveryService->createShipment($orderData, $orderedProducts);

            if ($shipment['success'] && $shipment['waybill']) {
                DB::table('orders')->where('id', $orderId)->update([
                    'waybill_number' => $shipment['waybill'],
                    'shipment_id' => $shipment['shipment_id'],
                    'tracking_status' => 'Shipment Created',
                    'courier_name' => 'Delhivery'
                ]);
                Log::info('Delhivery shipment created for prepaid order: ' . $orderId . ', Waybill: ' . $shipment['waybill']);
            } else {
                Log::error('Failed to create Delhivery shipment for prepaid order: ' . $orderId);
            }
        }

        // Update order status with the correct transaction ID
        $updateData = [
            'order_status' => 'paid',
            'payment_status' => 'paid',
            'payment_method' => 'cashfree',
            'paid_at' => now(),
            'updated_at' => now()
        ];

        // ✅ Save the actual Cashfree transaction ID (cf_order_id)
        if ($transactionId) {
            $updateData['transaction_id'] = $transactionId;
            Log::info('Transaction ID saved: ' . $transactionId . ' for order: ' . $orderId);
        } else {
            Log::warning('No transaction ID found for order: ' . $orderId);
        }

        DB::table('orders')->where('id', $orderId)->update($updateData);

        // Update stock
        $orderItems = DB::table('ordered_products')->where('order_id', $orderId)->get();
        foreach ($orderItems as $item) {
            if ($item->variant_id) {
                DB::table('product_variants')
                    ->where('id', $item->variant_id)
                    ->where('stock', '>', 0)
                    ->decrement('stock', $item->quantity);
            }
        }

        // Get customer name for WhatsApp
        $customerName = DB::table('addresses')
            ->where('user_id', $order->user_id)
            ->where('is_default', 1)
            ->value('full_name') ?? 'Customer';

        // ✅ Send WhatsApp confirmation with proper phone number
        $this->sendOrderWhatsAppConfirmation($orderId, $order->phone_no, $customerName);
        $this->sendOrderEmailConfirmation($orderId, $request->email ?? 'N/A', $customerName);

        // Clear cart and session
        DB::table('carts')->where('user_id', auth()->id())->delete();
        session()->forget([
            'cashfree_order_id',
            'cashfree_total',
            'cashfree_currency',
            'payment_method',
            'cashfree_transaction_id',
            'cf_order_id'
        ]);

        // Track Purchase event with Meta Conversions API
        try {
            $orderItems = DB::table('ordered_products')
                ->where('order_id', $orderId)
                ->get();

            $contentIds = [];
            $numItems = 0;

            foreach ($orderItems as $item) {
                $contentIds[] = $item->product_id;
                $numItems += $item->quantity;
            }

            $purchaseData = [
                'content_ids' => $contentIds,
                'value' => $order->total_amount,
                'num_items' => $numItems,
                'transaction_id' => $order->id,
            ];

            $this->metaService->trackPurchase($purchaseData);

            // Store purchase data for frontend Pixel tracking
            session(['purchase_event_data' => json_encode([
                'content_ids' => $contentIds,
                'content_type' => 'product',
                'value' => $order->total_amount,
                'currency' => 'INR',
                'num_items' => $numItems,
                'transaction_id' => $order->id,
            ])]);

            Log::info('Meta Purchase event tracked for order: ' . $orderId);
        } catch (\Exception $e) {
            Log::error('Failed to track Meta Purchase event: ' . $e->getMessage());
        }

        return redirect()->route('user.order-history', base64_encode(Auth::user()->id))
            ->with('success', 'Payment successful! Order placed.');
    }

    /**
     * Track order via API
     */
    public function trackOrder($orderId)
    {
        $order = DB::table('orders')->where('id', $orderId)->where('user_id', auth()->id())->first();

        if (!$order || !$order->waybill_number) {
            return response()->json(['error' => 'Tracking information not available'], 404);
        }

        $tracking = $this->delhiveryService->trackShipment($order->waybill_number);

        if ($tracking) {
            // Parse tracking status from response
            $status = $tracking['ShipmentData'][0]['Status']['Status'] ?? 'In Transit';

            DB::table('orders')->where('id', $orderId)->update([
                'tracking_status' => $status,
                'tracking_data' => json_encode($tracking)
            ]);

            return response()->json(['success' => true, 'tracking' => $tracking]);
        }

        return response()->json(['error' => 'Tracking information unavailable'], 404);
    }

    /**
     * Track Delhivery shipment directly by waybill
     */
    public function trackWaybill($waybill)
    {
        $tracking = $this->delhiveryService->trackShipment($waybill);

        if ($tracking) {
            return response()->json(['success' => true, 'waybill' => $waybill, 'tracking' => $tracking]);
        }

        return response()->json(['error' => 'Tracking information unavailable for waybill ' . $waybill], 404);
    }


    public function paymentCancel()
    {
        session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency', 'payment_method']);
        session()->flash('force_cart_refresh', true);
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled. Please try again.');
    }


    public function orderSuccess()
    {
        return view('web.order-success');
    }


    /**
     * Handle Delhivery webhook for status updates
     */
    public function delhiveryWebhook(Request $request)
    {
        $data = $request->all();

        Log::info('Delhivery webhook received', $data);

        $waybill = $data['waybill'] ?? null;
        $status = $data['status'] ?? null;
        $location = $data['location'] ?? null;

        if ($waybill && $status) {
            $updateData = [
                'tracking_status' => $status,
                'tracking_data' => json_encode($data),
                'updated_at' => now()
            ];

            // Update specific status milestones
            if ($status === 'Delivered') {
                $updateData['delivered_at'] = now();
                $updateData['order_status'] = 'delivered';
            } elseif ($status === 'Out for Delivery') {
                $updateData['out_for_delivery_at'] = now();
            } elseif ($status === 'In Transit') {
                $updateData['shipped_at'] = now();
            }

            if ($location) {
                $updateData['last_tracking_location'] = $location;
            }

            DB::table('orders')
                ->where('waybill_number', $waybill)
                ->update($updateData);

            Log::info('Order tracking updated for waybill: ' . $waybill . ', status: ' . $status);
        }

        return response()->json(['status' => 'success']);
    }


    /**
     * Handle Cashfree webhook notifications
     */
    public function webhook(Request $request)
    {
        $data = $request->all();


        Log::info('Cashfree webhook received:', [
            'all_data' => $data,
            'headers' => $request->headers->all(),
            'order_id' => $data['order_id'] ?? 'not_found',
            'transaction_id' => $data['transaction_id'] ?? 'not_found',
            'order_status' => $data['order_status'] ?? 'not_found'
        ]);


        $orderId = $data['order_id'] ?? null;
        $signature = $request->header('x-webhook-signature');


        if (!$orderId || !$signature) {
            return response()->json(['error' => 'Missing required data'], 400);
        }


        $cashfreeService = new CashfreeService();


        if (!$cashfreeService->verifySignature($orderId, $signature, $data)) {
            Log::error('Cashfree webhook signature verification failed for order: ' . $orderId);
            return response()->json(['error' => 'Invalid signature'], 401);
        }


        $orderStatus = $data['order_status'] ?? null;


        if ($orderStatus === 'PAID') {
            $updateData = [
                'order_status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now(),
                'updated_at' => now()
            ];


            // if (isset($data['transaction_id'])) {
            //     $updateData['transaction_id'] = $data['transaction_id'];
            // } elseif (isset($data['cf_transaction_id'])) {
            //     $updateData['transaction_id'] = $data['cf_transaction_id'];
            // }

            if (isset($data['transaction_id'])) {
                $transactionId = $data['transaction_id'];
            } elseif (isset($data['cf_transaction_id'])) {
                $transactionId = $data['cf_transaction_id'];
            } elseif (isset($data['order_id'])) {
                $transactionId = $data['order_id'];
            }

            if ($transactionId) {
                $updateData['transaction_id'] = $transactionId;
            }

            if (isset($data['cf_transaction_id']) && !$transactionId) {
                $updateData['transaction_id'] = $data['cf_transaction_id'];
            }

            DB::table('orders')->where('id', $orderId)->update($updateData);
            Log::info('Order marked as paid via webhook: ' . $orderId);
        } elseif ($orderStatus === 'FAILED') {
            DB::table('orders')->where('id', $orderId)->update([
                'order_status' => 'failed',
                'payment_status' => 'failed',
                'updated_at' => now()
            ]);
            Log::info('Order marked as failed via webhook: ' . $orderId);
        }


        return response()->json(['status' => 'success']);
    }

    /**
     * Send order confirmation WhatsApp message
     */
    private function sendOrderWhatsAppConfirmation($orderId, $phone, $customerName)
    {
        try {
            $whatsappService = new \App\Services\WhatsAppService();

            // Format phone number
            $phone = preg_replace('/[^0-9]/', '', $phone);

            // Send confirmation
            return $whatsappService->sendOrderConfirmation(
                $phone,
                $customerName,
                $orderId
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'phone' => $phone
            ]);
            return false;
        }
    }

    private function sendOrderEmailConfirmation($orderId, $customerEmail, $customerName)
{
    try {
        // Fetch order details
        $order = \App\Models\Order::with(['items', 'user'])->find($orderId);
        
        if (!$order) {
            Log::error('Order not found for email confirmation', ['order_id' => $orderId]);
            return false;
        }

        // Get admin email from configuration
        $adminEmail = config('mail.admin_email') ?? 'aimanroyale9@gmail.com';

        // Send email to customer
        \Illuminate\Support\Facades\Mail::to($customerEmail)->send(new \App\Mail\OrderConfirmation($order, $customerName));

        // Send email to admin
        \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminOrderNotification($order, $customerName));

        Log::info('Order email confirmation sent', [
            'order_id' => $orderId,
            'customer_email' => $customerEmail,
            'admin_email' => $adminEmail
        ]);

        return true;

    } catch (\Exception $e) {
        Log::error('Email send error: ' . $e->getMessage(), [
            'order_id' => $orderId,
            'customer_email' => $customerEmail ?? 'unknown'
        ]);
        return false;
    }
}

    public function clearBuyNowSession(Request $request)
{
    try {
        // Clear all buy now related session data
        session()->forget([
            'checkout_source',
            'checkout_payload',
            'buy_now_active',
            'buy_now_product_id'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Buy now session cleared'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function checkBuyNowSession(Request $request)
{
    return response()->json([
        'is_buy_now' => session()->has('checkout_source') && 
                       session()->get('checkout_source') === 'buy_now',
        'has_payload' => session()->has('checkout_payload')
    ]);
}
}
