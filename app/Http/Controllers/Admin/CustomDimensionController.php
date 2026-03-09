<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomDimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomDimensionController extends Controller
{
    /**
     * Display all custom dimension requests for admin.
     */
    public function index()
    {
        // Get all custom dimension requests with user, product, and product image relationships
        $customRequests = CustomDimension::with(['user', 'product', 'product.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        // dd($customRequests);

        return view('Admin.custom-dimensions.index', compact('customRequests'));
    }

    /**
     * Store a new custom dimension request.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Log incoming request data
            Log::info('Custom dimension store request:', [
                'user_authenticated' => Auth::check(),
                'request_data' => $request->all()
            ]);

            // Get the authenticated user first
            $user = Auth::user();
            
            if (!$user) {
                Log::warning('Custom dimension request - User not authenticated');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated. Please login first.'
                ], 401);
            }

            // Validate the request data
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'bust' => 'required|numeric|min:1|max:200',
                'waist' => 'required|numeric|min:1|max:200',
                'hip' => 'required|numeric|min:1|max:200',
                'armhole' => 'required|numeric|min:1|max:100',
                'color_code' => 'required|string|max:20',
            ]);

            // Check if product exists and is active
            $product = \App\Models\Product::find($validated['product_id']);
            if (!$product || $product->is_active != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available'
                ], 404);
            }

            // Create the custom dimension request
            $customDimension = CustomDimension::create([
                'user_id' => $user->id,
                'product_id' => $validated['product_id'],
                'bust' => $validated['bust'],
                'waist' => $validated['waist'],
                'hip' => $validated['hip'],
                'armhole' => $validated['armhole'],
                'color_code' => $validated['color_code'],
                'status' => 'requested',
            ]);

            Log::info('Custom dimension request created successfully:', [
                'request_id' => $customDimension->id,
                'user_id' => $user->id,
                'product_id' => $validated['product_id'],
                'measurements' => [
                    'bust' => $validated['bust'],
                    'waist' => $validated['waist'],
                    'hip' => $validated['hip'],
                    'armhole' => $validated['armhole'],
                    'color' => $validated['color_code']
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Custom dimension request submitted successfully! We will contact you soon.',
                'data' => $customDimension
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Custom dimension validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Please check all measurements and try again.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error creating custom dimension request: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Show custom dimension requests for a specific product.
     */
    public function show($productId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get custom dimensions for this product and user
            $customDimensions = CustomDimension::with(['product', 'product.images'])
                ->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $customDimensions
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching custom dimensions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch custom dimensions'
            ], 500);
        }
    }

    /**
     * Cancel a custom dimension request.
     */
    public function cancel($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $customDimension = CustomDimension::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$customDimension) {
                return response()->json([
                    'success' => false,
                    'message' => 'Custom dimension request not found'
                ], 404);
            }

            // Only allow cancellation if status is 'requested' or 'viewed'
            if (!in_array($customDimension->status, ['requested', 'viewed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel request that is already being processed'
                ], 400);
            }

            $customDimension->update(['status' => 'canceled']);

            Log::info('Custom dimension request cancelled:', [
                'request_id' => $customDimension->id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Custom dimension request cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error cancelling custom dimension: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel custom dimension request'
            ], 500);
        }
    }

    /**
     * Update custom dimension request status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:requested,viewed,processing,accepted,canceled'
        ]);

        $dimension = CustomDimension::find($id);

        if (!$dimension) {
            return response()->json([
                'success' => false,
                'message' => 'Custom dimension request not found'
            ], 404);
        }

        $dimension->update([
            'status' => $request->status
        ]);

        // If status is updated to 'accepted', create order and send WhatsApp
        if ($request->status === 'accepted') {
            // dd($request->status);
            $this->createOrderFromCustomRequest($dimension);
            $this->sendWhatsAppNotification($dimension);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $dimension
        ]);
    }

    /**
     * Create order from custom dimension request
     */
    private function createOrderFromCustomRequest($dimension)
    {
        try {
            // First create main order record
            // Get user's default address from addresses table
            $userAddress = $dimension->user->addresses()->where('is_default', true)->first()
                ?? $dimension->user->addresses()->first();

            $mainOrder = \App\Models\Order::create([
                'user_id' => $dimension->user_id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $dimension->product->price ?? 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'order_date' => now(),
                'notes' => 'Custom dimension request #' . $dimension->id,
                'address_1' => $userAddress->address_1 ?? 'N/A',
                'address_2' => $userAddress->address_2 ?? null,
                'city' => $userAddress->city ?? 'N/A',
                'state' => $userAddress->state ?? 'N/A',
                'pincode' => $userAddress->pincode ?? '000000', // Handle NOT NULL constraint
                'country' => $userAddress->country ?? 'India',
                'phone_no' => $dimension->user->phone ?? 'N/A'
            ]);

            // Then create ordered_products record linked to the main order
            $orderProduct = \App\Models\OrderProduct::create([
                'user_id' => $dimension->user_id,
                'order_id' => $mainOrder->id, // Link to main order
                'product_id' => $dimension->product_id,
                'variant_id' => null, // Custom dimensions don't use variants
                'request_id' => $dimension->id, // Link to custom dimension request
                'quantity' => 1,
                'price' => $dimension->product->price ?? 0,
                'total' => $dimension->product->price ?? 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'order_date' => now(),
                'custom_measurements' => json_encode([
                    'bust' => $dimension->bust,
                    'waist' => $dimension->waist,
                    'hip' => $dimension->hip,
                    'armhole' => $dimension->armhole,
                    'color_code' => $dimension->color_code
                ])
            ]);

            \Log::info('Order created from custom dimension request:', [
                'main_order_id' => $mainOrder->id,
                'order_product_id' => $orderProduct->id,
                'request_id' => $dimension->id,
                'user_id' => $dimension->user_id
            ]);

            return $orderProduct;
        } catch (\Exception $e) {
            \Log::error('Error creating order from custom request: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send WhatsApp notification for accepted custom request
     */
    private function sendWhatsAppNotification($dimension)
    {
        try {
            $user = $dimension->user;
            $product = $dimension->product;

            // Generate order number
            $orderNumber = 'CO' . str_pad($dimension->id, 5, '0', STR_PAD_LEFT);
            $paymentLink = url("/pay-custom-order/{$dimension->id}");

            // Update message to match confirm_order template format and include payment link
            $message = "Hi {$user->name},\n\n";
            $message .= "Your custom order has been successfully placed and is being processed. ";
            $message .= "Your order number is #{$orderNumber}. ";
            $message .= "Payment link: {$paymentLink}";

            // Send WhatsApp message with image
            $this->sendWhatsAppMessageWithImage($user->phone, $message, null, $dimension);

            \Log::info('WhatsApp notification sent for accepted custom request to user: ' . $user->id);
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp notification: ' . $e->getMessage());
        }
    }

    /**
     * Send WhatsApp message with image using Facebook Graph API
     */
    private function sendWhatsAppMessageWithImage($phone, $message, $imageUrl = null, $dimension = null)
    {
        try {
            // Clean phone number (remove any non-digit characters)
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

            // Format phone number for WhatsApp (include country code if not present)
            if (strlen($cleanPhone) === 10) {
                // Assume India if 10 digits
                $formattedPhone = '91' . $cleanPhone;
            } elseif (strlen($cleanPhone) === 12 && strpos($cleanPhone, '91') === 0) {
                // Already has India country code
                $formattedPhone = $cleanPhone;
            } else {
                // Use as-is or add default country code
                $formattedPhone = $cleanPhone;
            }

            // Facebook Graph API WhatsApp Business API
            $accessToken = env('WHATSAPP_ACCESS_TOKEN');
            $phoneNumberId = env('PHONE_NUMBER_ID');
            $version = env('FACEBOOK_GRAPH_API_VERSION', 'v18.0');

            // Use existing confirm_order template
            if ($accessToken && $phoneNumberId && $dimension) {
                // Generate order number (you can customize this)
                $orderNumber = 'CO' . str_pad($dimension->id, 5, '0', STR_PAD_LEFT);
                
                // Prepare message payload for confirm_order template
                $messageData = [
                    'messaging_product' => 'whatsapp',
                    'to' => $formattedPhone,
                    'type' => 'template',
                    'template' => [
                        'name' => 'confirm_order',
                        'language' => [
                            'code' => 'en_US'
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => $dimension->user->name ?? 'Customer'
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => $orderNumber
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];

                // Send message via Facebook Graph API
                $response = $this->sendFacebookWhatsAppMessage($messageData, $accessToken, $phoneNumberId, $version);

                if ($response) {
                    \Log::info('WhatsApp message sent via confirm_order template', [
                        'phone' => $formattedPhone,
                        'message_id' => $response['message_id'] ?? 'N/A',
                        'order_number' => $orderNumber
                    ]);
                    return true;
                }
            }

            // Fallback: Send simple text message if template fails
            if ($accessToken && $phoneNumberId) {
                $simpleMessageData = [
                    'messaging_product' => 'whatsapp',
                    'to' => $formattedPhone,
                    'type' => 'text',
                    'text' => [
                        'body' => $message
                    ]
                ];

                if ($imageUrl) {
                    // Send image separately
                    $imageData = [
                        'messaging_product' => 'whatsapp',
                        'to' => $formattedPhone,
                        'type' => 'image',
                        'image' => [
                            'link' => $imageUrl
                        ]
                    ];

                    $this->sendFacebookWhatsAppMessage($imageData, $accessToken, $phoneNumberId, $version);
                }

                $response = $this->sendFacebookWhatsAppMessage($simpleMessageData, $accessToken, $phoneNumberId, $version);

                if ($response) {
                    \Log::info('WhatsApp message sent via Facebook Graph API (simple)', [
                        'phone' => $formattedPhone,
                        'message_id' => $response['message_id'] ?? 'N/A'
                    ]);
                    return true;
                }
            }

            // Fallback: Log for now
            \Log::info('WhatsApp message would be sent (no API configured):', [
                'phone' => $formattedPhone,
                'message_length' => strlen($message),
                'image_url' => $imageUrl ?? 'N/A'
            ]);

            return false;
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send message via Facebook Graph API
     */
    private function sendFacebookWhatsAppMessage($messageData, $accessToken, $phoneNumberId, $version = 'v18.0')
    {
        try {
            $url = "https://graph.facebook.com/{$version}/{$phoneNumberId}/messages";
            
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $responseData = json_decode($response, true);
                return $responseData;
            } else {
                \Log::error('Facebook Graph API error:', [
                    'http_code' => $httpCode,
                    'response' => $response
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Facebook Graph API exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send WhatsApp message (implement your WhatsApp API here)
     */
    private function sendWhatsAppMessage($phone, $message)
    {
        try {
            // Clean phone number (remove any non-digit characters)
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

            // Format phone number for WhatsApp (include country code if not present)
            if (strlen($cleanPhone) === 10) {
                // Assume India if 10 digits
                $formattedPhone = '91' . $cleanPhone;
            } elseif (strlen($cleanPhone) === 12 && strpos($cleanPhone, '91') === 0) {
                // Already has India country code
                $formattedPhone = $cleanPhone;
            } else {
                // Use as-is or add default country code
                $formattedPhone = $cleanPhone;
            }

            // Option 1: WhatsApp Business API (if you have direct API access)
            // This would require your own WhatsApp Business API setup

            // Option 2: Third-party WhatsApp services
            // Examples: WATI, MessageBird, Vonage, etc.

            // Fallback: Log for now
            \Log::info('WhatsApp message would be sent (no API configured):', [
                'phone' => $formattedPhone,
                'message_length' => strlen($message)
            ]);

            return false;
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Show payment page for custom order.
     */
    public function payment($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('web.login')->with('error', 'Please login to access payment page');
            }

            $customDimension = CustomDimension::with(['user', 'product', 'product.images'])
                ->where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$customDimension) {
                return redirect()->route('page.index')->with('error', 'Custom dimension request not found');
            }

            // Check if there's already an order for this custom dimension
            $existingOrder = \App\Models\OrderProduct::where('request_id', $id)->first();

            if ($existingOrder) {
                // Redirect to existing order payment
                return redirect()->route('checkout.show', $existingOrder->order_id);
            }

            // If no order exists yet, create one
            $orderProduct = $this->createOrderFromCustomRequest($customDimension);

            if (!$orderProduct) {
                return redirect()->route('page.index')->with('error', 'Failed to create order for payment');
            }

            // Redirect to checkout with the created order
            return redirect()->route('checkout.show', $orderProduct->order_id);

        } catch (\Exception $e) {
            Log::error('Error accessing custom order payment: ' . $e->getMessage());
            
            return redirect()->route('page.index')->with('error', 'Unable to access payment page');
        }
    }

    /**
     * Delete a custom dimension request.
     */
    public function destroy($productId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Find and delete custom dimensions for this product and user
            $deleted = CustomDimension::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->where('status', 'requested') // Only allow deletion of requested requests
                ->delete();

            if ($deleted > 0) {
                Log::info('Custom dimension requests deleted:', [
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'deleted_count' => $deleted
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Custom dimension requests deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No deletable custom dimension requests found'
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error deleting custom dimensions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete custom dimension requests'
            ], 500);
        }
    }
}
