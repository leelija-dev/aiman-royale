<?php

// namespace App\Services;

// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

// class WhatsAppService
// {
//     protected $accessToken;
//     protected $phoneNumberId;
//     protected $apiVersion;

//     public function __construct()
//     {
//         $this->accessToken = env('WHATSAPP_ACCESS_TOKEN');
//         $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
//         $this->apiVersion = env('WHATSAPP_API_VERSION', 'v18.0');
//     }

//     public function checkMessageDelivery(string $messageId): void
//     {
//         $url = "https://graph.facebook.com/{$this->apiVersion}/{$messageId}";

//         $response = Http::withToken($this->accessToken)->get($url);

//         if ($response->successful()) {
//             $data = $response->json();

//             // Check delivery status
//             if (isset($data['status'])) {
//                 Log::info('Message status check', [
//                     'message_id' => $messageId,
//                     'status' => $data['status'],
//                     'conversation' => $data['conversation'] ?? null,
//                     'pricing' => $data['pricing'] ?? null
//                 ]);
//             }
//         }
//     }

//     public function sendTextMessage(string $phone, string $message): bool
//     {
//         try {
//             if (!$this->accessToken || !$this->phoneNumberId) {
//                 Log::warning('WhatsAppService not configured: missing access token or phone number id');
//                 return false;
//             }

//             $formattedPhone = $this->formatPhoneNumber($phone);
//             if (!$formattedPhone) {
//                 Log::warning('WhatsAppService could not format phone number', ['phone' => $phone]);
//                 return false;
//             }

//             $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages";
//             $payload = [
//                 'messaging_product' => 'whatsapp',
//                 'to' => $formattedPhone,
//                 'type' => 'text',
//                 'text' => [
//                     'body' => $message,
//                 ],
//             ];

//             $response = Http::withToken($this->accessToken)
//                 ->withHeaders(['Content-Type' => 'application/json'])
//                 ->post($url, $payload);
//             $response = Http::withToken($this->accessToken)
//                 ->withHeaders(['Content-Type' => 'application/json'])
//                 ->post($url, $payload);

//             if ($response->successful()) {
//                 $data = $response->json();

//                 if (isset($data['messages'][0]['id'])) {
//                     $messageId = $data['messages'][0]['id'];

//                     // Wait 2-3 seconds for processing
//                     sleep(2);

//                     // Check actual delivery status
//                     $this->checkMessageDelivery($messageId);

//                     Log::info('WhatsApp message queued', [
//                         'message_id' => $messageId,
//                         'phone' => $formattedPhone
//                     ]);
//                     return true;
//                 }
//             }

//             if ($response->successful()) {
//                 Log::info('WhatsApp message sent successfully', [
//                     'phone' => $formattedPhone,
//                     'order_message' => substr($message, 0, 120),
//                     'response' => $response->json(),
//                 ]);
//                 return true;
//             }

//             Log::error('WhatsApp message failed', [
//                 'phone' => $formattedPhone,
//                 'status' => $response->status(),
//                 'body' => $response->body(),
//             ]);
//             return false;
//         } catch (\Exception $e) {
//             Log::error('WhatsAppService exception: ' . $e->getMessage(), [
//                 'phone' => $phone,
//                 'trace' => $e->getTraceAsString(),
//             ]);
//             return false;
//         }
//     }

//     private function formatPhoneNumber(string $phone): ?string
//     {
//         $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

//         if (!$cleanPhone) {
//             return null;
//         }

//         if (strlen($cleanPhone) === 10) {
//             return '91' . $cleanPhone;
//         }

//         if (strlen($cleanPhone) === 12 && strpos($cleanPhone, '91') === 0) {
//             return $cleanPhone;
//         }

//         return $cleanPhone;
//     }
// }


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $accessToken;
    private $phoneNumberId;
    private $apiVersion;
    private $lastMessageId;
    private $isConfigured;

    const TEMPLATE_CONFIRM_ORDER = 'confirm_order';

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->apiVersion = config('services.whatsapp.api_version', 'v18.0');
        
        $this->isConfigured = !empty($this->accessToken) && !empty($this->phoneNumberId);
        
        if (!$this->isConfigured) {
            Log::warning('WhatsAppService not properly configured');
        }
    }

    /**
     * Send order confirmation template
     */
    public function sendOrderConfirmation(string $phone, string $customerName, string $orderId): bool
    {
        if (!$this->isConfigured) {
            Log::error('WhatsApp not configured');
            return false;
        }

        $components = [
            [
                'type' => 'body',
                'parameters' => [
                    ['type' => 'text', 'text' => $customerName], // {{1}}
                    ['type' => 'text', 'text' => $orderId]      // {{2}}
                ]
            ]
        ];

        // Pass 'en_US' as the language code (most common for WhatsApp templates)
        return $this->sendTemplateMessage(
            $phone,
            self::TEMPLATE_CONFIRM_ORDER,
            $components,
            ['customer' => $customerName, 'order_id' => $orderId],
            'en_US'  // <-- Language code added here
        );
    }

    /**
     * Core method to send template messages
     */
    private function sendTemplateMessage(
        string $phone, 
        string $templateName, 
        array $components, 
        array $context = [],
        string $languageCode = 'en_US'  // <-- Added language parameter
    ): bool
    {
        try {
            // Validate configuration
            if (!$this->accessToken) {
                Log::error('WhatsApp access token not configured');
                return false;
            }

            if (!$this->phoneNumberId) {
                Log::error('WhatsApp phone number ID not configured');
                return false;
            }

            $formattedPhone = $this->formatPhoneNumber($phone);
            if (!$formattedPhone) {
                Log::warning('Invalid phone number', ['phone' => $phone]);
                return false;
            }

            $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages";
            
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $formattedPhone,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $languageCode], // <-- Using the language parameter
                    'components' => $components
                ]
            ];

            Log::info('Sending WhatsApp template', array_merge([
                'phone' => $formattedPhone,
                'template' => $templateName,
                'language' => $languageCode,
                'url' => $url
            ], $context));

            $response = Http::withToken($this->accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(30)
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['messages'][0]['id'])) {
                    $this->lastMessageId = $data['messages'][0]['id'];
                    Log::info('WhatsApp template sent successfully', [
                        'message_id' => $this->lastMessageId,
                        'phone' => $formattedPhone,
                        'template' => $templateName,
                        'language' => $languageCode
                    ]);
                    return true;
                }
            }

            // Handle error
            $errorBody = $response->json();
            if (isset($errorBody['error'])) {
                $error = $errorBody['error'];
                Log::error('WhatsApp API Error', [
                    'message' => $error['message'] ?? 'Unknown',
                    'code' => $error['code'] ?? 'Unknown',
                    'error_data' => $error['error_data'] ?? null,
                    'fbtrace_id' => $error['fbtrace_id'] ?? 'Unknown'
                ]);

                // Specific error handling
                if (isset($error['error_data']['details'])) {
                    Log::error('Template error details: ' . $error['error_data']['details']);
                }
            }

            Log::error('WhatsApp template failed', [
                'phone' => $formattedPhone,
                'template' => $templateName,
                'language' => $languageCode,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp template error: ' . $e->getMessage(), [
                'phone' => $phone,
                'template' => $templateName,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber(string $phone): ?string
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Remove leading zero if exists
        if (str_starts_with($cleaned, '0')) {
            $cleaned = substr($cleaned, 1);
        }
        
        // Add country code if not present (India: 91)
        if (!str_starts_with($cleaned, '91')) {
            $cleaned = '91' . $cleaned;
        }
        
        return $cleaned;
    }

    /**
     * Get last message ID
     */
    public function getLastMessageId(): ?string
    {
        return $this->lastMessageId;
    }

    /**
     * Check if service is configured
     */
    public function isConfigured(): bool
    {
        return $this->isConfigured;
    }
}