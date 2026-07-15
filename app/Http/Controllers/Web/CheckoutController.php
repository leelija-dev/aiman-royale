<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\CashfreeService;
use App\Services\DelhiveryService;
use App\Services\WhatsAppService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Address;


class CheckoutController extends Controller
{
    protected $delhiveryService;
    protected $whatsAppService;

    public function __construct(DelhiveryService $delhiveryService, WhatsAppService $whatsAppService)
    {
        $this->delhiveryService = $delhiveryService;
        $this->whatsAppService = $whatsAppService;
    }


    public function index()
    {
        $user_id = auth()->id();


        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
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


        $addresses = Address::where('user_id', $user_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();


        if (count($carts) == 0) {
            session()->flash('force_cart_refresh', true);
            return redirect()->route('cart.index');
        }


        return view('web.checkout', compact('carts', 'occasions', 'addresses'));
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
        ]);

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
                ->with('error', $serviceability['message'] . ' (Pincode: ' . $request->pinCode . ')');
        }

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

        // Get cart items
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


        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty');
        }

        // Calculate total
        $subtotal = $carts->sum(function ($cart) {
            return (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count);
        });
        // $shipping = 7.00;
        // $tax = $subtotal * 0.05;
        if ($subtotal <= 400) {
            $shipping = 0;
        } else {
            $shipping = 0;
        }
        $total = $subtotal + $shipping; //+ $shipping + $tax;

        // Create order
        $order_id = DB::table('orders')->insertGetId([
            'user_id' => $user_id,
            'phone_no' => $request->phone,
            'address_1' => $request->address1,
            'address_2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pinCode,
            'payment_status' => 'pending',
            'payment_method' => $paymentMethod === 'cod' ? 'cod' : null,
            'total_amount' => $total,
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);



        // Create order items and prepare for shipment
        $orderItems = [];
        foreach ($carts as $cart) {
            $itemTotal = (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count);
            DB::table('ordered_products')->insert([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->count,
                'price' => $cart->discount_price,
                'total' => $itemTotal,
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

        // Clear cart after order placement
        DB::table('carts')->where('user_id', $user_id)->delete();

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

        // 🔔 SEND WHATSAPP CONFIRMATION
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

    // public function placeOrder(Request $request)
    // {
    //     try {
    //         // Log the start of the process
    //         \Log::info('PlaceOrder started for user: ' . auth()->id());

    //         $request->validate([
    //             'firstName' => 'required|string|max:255',
    //             'lastName' => 'required|string|max:255',
    //             'email' => 'required|email',
    //             'phone' => 'required|string|max:20',
    //             'address1' => 'required|string|max:255',
    //             'city' => 'required|string|max:255',
    //             'state' => 'required|string|max:255',
    //             'pinCode' => 'required|string|max:10',
    //         ]);

    //         $user_id = auth()->id();
    //         \Log::info('User ID: ' . $user_id);

    //         // Check if user exists
    //         if (!$user_id) {
    //             \Log::error('User not authenticated');
    //             return back()->with('error', 'User not authenticated');
    //         }

    //         // Address handling
    //         try {
    //             $checkItsAddress = Address::where('user_id', $user_id)->exists();
    //             \Log::info('Address exists: ' . ($checkItsAddress ? 'Yes' : 'No'));

    //             if (!$checkItsAddress) {
    //                 $addressData = [
    //                     'user_id' => $user_id,
    //                     'full_name' => $request->firstName . " " . $request->lastName,
    //                     'phone' => $request->phone,
    //                     'address_1' => $request->address1,
    //                     'address_2' => $request->address2 ?? '',
    //                     'city' => $request->city,
    //                     'state' => $request->state,
    //                     'country' => $request->country ?? '',
    //                     'pincode' => $request->pinCode,
    //                     'is_default' => 1,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ];
    //                 \Log::info('Address data to insert: ', $addressData);

    //                 DB::table('addresses')->insert($addressData);
    //                 \Log::info('Address inserted successfully');
    //             }
    //         } catch (\Exception $e) {
    //             \Log::error('Address insertion failed: ' . $e->getMessage());
    //             \Log::error('Address insertion trace: ' . $e->getTraceAsString());
    //             throw $e; // Re-throw to be caught by outer try-catch
    //         }

    //         // Get cart items
    //         try {
    //             \Log::info('Fetching cart items for user: ' . $user_id);

    //             $carts = DB::table('carts')
    //                 ->join('products', 'carts.product_id', '=', 'products.id')
    //                 ->join('product_variants', 'carts.variant_id', '=', 'product_variants.id')
    //                 ->where('user_id', $user_id)
    //                 ->select('carts.*', 'products.name', 'product_variants.price as variant_price', 'product_variants.discount as discount', 'product_variants.discount_price')
    //                 ->get();

    //             \Log::info('Cart items found: ' . $carts->count());

    //             if ($carts->isEmpty()) {
    //                 \Log::warning('Cart is empty for user: ' . $user_id);
    //                 return back()->with('error', 'Your cart is empty');
    //             }
    //         } catch (\Exception $e) {
    //             \Log::error('Failed to fetch cart: ' . $e->getMessage());
    //             \Log::error('Cart fetch trace: ' . $e->getTraceAsString());
    //             throw $e;
    //         }

    //         // Calculate total
    //         try {
    //             $subtotal = $carts->sum(function ($cart) {
    //                 // Log each cart item for debugging
    //                 \Log::debug('Cart item: ', [
    //                     'product_id' => $cart->product_id,
    //                     'variant_id' => $cart->variant_id,
    //                     'variant_price' => $cart->variant_price,
    //                     'discount' => $cart->discount,
    //                     'discount_price' => $cart->discount_price,
    //                     'count' => $cart->count
    //                 ]);

    //                 $priceAfterDiscount = $cart->variant_price - (($cart->variant_price * $cart->discount) / 100);
    //                 return $priceAfterDiscount * $cart->count;
    //             });

    //             \Log::info('Subtotal calculated: ' . $subtotal);

    //             $shipping = 0; // Your shipping logic
    //             $total = $subtotal + $shipping;
    //             \Log::info('Total calculated: ' . $total);
    //         } catch (\Exception $e) {
    //             \Log::error('Total calculation failed: ' . $e->getMessage());
    //             \Log::error('Total calc trace: ' . $e->getTraceAsString());
    //             throw $e;
    //         }

    //         // Create order
    //         try {
    //             \Log::info('Creating order for user: ' . $user_id);

    //             $orderData = [
    //                 'user_id' => $user_id,
    //                 'phone_no' => $request->phone,
    //                 'address_1' => $request->address1,
    //                 'address_2' => $request->address2 ?? '',
    //                 'city' => $request->city,
    //                 'state' => $request->state,
    //                 'pincode' => $request->pinCode,
    //                 'payment_status' => 'pending',
    //                 'total_amount' => $total,
    //                 'order_status' => 'pending',
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];

    //             \Log::info('Order data: ', $orderData);

    //             $order_id = DB::table('orders')->insertGetId($orderData);
    //             \Log::info('Order created with ID: ' . $order_id);
    //         } catch (\Exception $e) {
    //             \Log::error('Order creation failed: ' . $e->getMessage());
    //             \Log::error('Order creation trace: ' . $e->getTraceAsString());
    //             throw $e;
    //         }

    //         // Create order items
    //         try {
    //             \Log::info('Creating order items for order: ' . $order_id);

    //             foreach ($carts as $index => $cart) {
    //                 $orderItemData = [
    //                     'user_id' => $user_id,
    //                     'order_id' => $order_id,
    //                     'product_id' => $cart->product_id,
    //                     'variant_id' => $cart->variant_id,
    //                     'quantity' => $cart->count,
    //                     'price' => $cart->discount_price,
    //                     'total' => (($cart->variant_price - (($cart->variant_price * $cart->discount) / 100)) * $cart->count),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ];

    //                 \Log::info('Order item ' . $index . ': ', $orderItemData);
    //                 DB::table('ordered_products')->insert($orderItemData);
    //             }

    //             \Log::info('All order items created successfully');
    //         } catch (\Exception $e) {
    //             \Log::error('Order items creation failed: ' . $e->getMessage());
    //             \Log::error('Order items trace: ' . $e->getTraceAsString());
    //             throw $e;
    //         }

    //         // Store in session
    //         try {
    //             session([
    //                 'cashfree_order_id' => $order_id,
    //                 'cashfree_total' => $total,
    //                 'cashfree_currency' => 'INR'
    //             ]);
    //             \Log::info('Session data stored successfully');
    //         } catch (\Exception $e) {
    //             \Log::error('Session storage failed: ' . $e->getMessage());
    //             throw $e;
    //         }

    //         \Log::info('PlaceOrder completed successfully for user: ' . $user_id);
    //         return redirect()->route('checkout.payment');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         \Log::error('Validation failed: ' . json_encode($e->errors()));
    //         return back()->withErrors($e->errors())->withInput();
    //     } catch (\Exception $e) {
    //         \Log::error('PlaceOrder failed with error: ' . $e->getMessage());
    //         \Log::error('Error trace: ' . $e->getTraceAsString());

    //         // Log the request data for debugging (excluding sensitive info)
    //         \Log::error('Request data: ', [
    //             'user_id' => auth()->id(),
    //             'request_data' => $request->except(['_token', 'password'])
    //         ]);

    //         // Return a more informative error message
    //         return back()->with('error', 'Failed to place order: ' . $e->getMessage());
    //     }
    // }

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


            // Create Delhivery shipment if not already created
            if (!$order->waybill_number) {
                // Get order details from request (stored in order table)
                $orderData = [
                    'customer_name' => $order->full_name ?? 'Customer',
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
            session()->forget(['cashfree_order_id', 'cashfree_total', 'cashfree_currency', 'payment_method']);


            return redirect()->route('page.index')->with('success', 'Order placed successfully! You will pay cash on delivery.');
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
            'customer_name' => $customerName,
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
}
