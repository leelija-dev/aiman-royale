<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomDimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        return view('admin.custom-dimensions.index', compact('customRequests'));
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
            
            // Generate payment link (you can customize this based on your payment system)
            $paymentLink = url("/pay-custom-order/{$dimension->id}");
            
            // Get product image URL
            $productImage = $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg');

            $message = "🎉 *Custom Request Accepted!*\n\n";
            $message .= "Hello {$user->name},\n\n";
            $message .= "Your custom measurement request for *{$product->name}* has been accepted!\n\n";
            $message .= "📏 *Measurements:*\n";
            if ($dimension->bust) $message .= "• Bust: {$dimension->bust}cm\n";
            if ($dimension->waist) $message .= "• Waist: {$dimension->waist}cm\n";
            if ($dimension->hip) $message .= "• Hip: {$dimension->hip}cm\n";
            if ($dimension->armhole) $message .= "• Armhole: {$dimension->armhole}cm\n";
            if ($dimension->color_code) $message .= "• Color: {$dimension->color_code}\n";
            $message .= "\n💰 *Price:* " . ($product->price ? '₹' . number_format($product->price, 2) : 'Contact for pricing');
            $message .= "\n\n� *Payment Link:*\n{$paymentLink}";
            $message .= "\n\n� *Next Steps:* Click the payment link to complete your order. Our team will contact you for confirmation.\n\n";
            $message .= "Thank you for choosing us! 🛍️";

            // Send WhatsApp message with image
            $this->sendWhatsAppMessageWithImage($user->phone, $message, $productImage);

            \Log::info('WhatsApp notification sent for accepted custom request to user: ' . $user->id);
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp notification: ' . $e->getMessage());
        }
    }

    /**
     * Send WhatsApp message with image (implement your WhatsApp API here)
     */
    private function sendWhatsAppMessageWithImage($phone, $message, $imageUrl = null)
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

            // Option 1: Twilio WhatsApp API with Media URL
            if (env('TWILIO_SID') && env('TWILIO_TOKEN') && env('TWILIO_WHATSAPP_NUMBER')) {
                $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
                
                $messageParams = [
                    "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
                    "body" => $message
                ];
                
                // Add image if provided
                if ($imageUrl) {
                    $messageParams["mediaUrl"] = [$imageUrl];
                }
                
                $result = $twilio->messages->create(
                    "whatsapp:+{$formattedPhone}",
                    $messageParams
                );

                \Log::info('WhatsApp message with image sent via Twilio', [
                    'phone' => $formattedPhone,
                    'message_sid' => $result->sid ?? 'N/A',
                    'image_url' => $imageUrl ?? 'N/A'
                ]);
                
                return true;
            }

            // Option 2: WhatsApp Business API with Media
            // This would require your own WhatsApp Business API setup
            
            // Option 3: Third-party WhatsApp services with Media support
            // Examples: WATI, MessageBird, Vonage, etc.
            
            // Fallback: Log for now
            \Log::info('WhatsApp message with image would be sent (no API configured):', [
                'phone' => $formattedPhone,
                'message_length' => strlen($message),
                'image_url' => $imageUrl ?? 'N/A'
            ]);
            
            return false;
            
        } catch (\Exception $e) {
            \Log::error('Error sending WhatsApp message with image: ' . $e->getMessage());
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

            // Option 1: Twilio WhatsApp API
            if (env('TWILIO_SID') && env('TWILIO_TOKEN') && env('TWILIO_WHATSAPP_NUMBER')) {
                $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

                $result = $twilio->messages->create(
                    "whatsapp:+{$formattedPhone}",
                    [
                        "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
                        "body" => $message
                    ]
                );

                \Log::info('WhatsApp message sent via Twilio', [
                    'phone' => $formattedPhone,
                    'message_sid' => $result->sid ?? 'N/A'
                ]);

                return true;
            }

            // Option 2: WhatsApp Business API (if you have direct API access)
            // This would require your own WhatsApp Business API setup

            // Option 3: Third-party WhatsApp services
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
}
