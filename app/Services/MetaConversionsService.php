<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MetaConversionsService
{
    protected string $pixelId;
    protected string $accessToken;

    public function __construct()
    {
        $this->pixelId = config('services.meta.pixel_id');
        $this->accessToken = config('services.meta.access_token');
    }

    /**
     * Send an event to Meta Conversions API.
     */
    public function sendEvent(
        string $eventName,
        array $userData = [],
        array $customData = []
    ): array {

        if (!$this->pixelId || !$this->accessToken) {
            Log::warning('Meta tracking disabled: Missing credentials');
            return ['success' => false, 'message' => 'Meta credentials not configured'];
        }

        $url = "https://graph.facebook.com/v23.0/{$this->pixelId}/events";

        $event = [
            'event_name' => $eventName,
            'event_time' => time(),
            'action_source' => 'website',
            'user_data' => $userData,
            'custom_data' => $customData,
        ];

        try {
            $response = Http::post($url, [
                'data' => [$event],
                'access_token' => $this->accessToken,
            ]);

            $result = $response->json();
            
            Log::info('Meta event sent', [
                'event' => $eventName,
                'response' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Meta event failed', [
                'event' => $eventName,
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create user data with advanced matching
     */
    public function createUserData(array $additionalData = []): array
    {
        $userData = [
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent(),
        ];

        // Add logged-in user data for better matching
        if (Auth::check()) {
            $user = Auth::user();
            
            if (!empty($user->email)) {
                $userData['em'] = $this->hashData($user->email);
            }
            
            if (!empty($user->phone)) {
                $userData['ph'] = $this->hashData($user->phone);
            }
            
            if (!empty($user->name)) {
                $userData['fn'] = $this->hashData(explode(' ', $user->name)[0] ?? ''); // First name
                $userData['ln'] = $this->hashData(explode(' ', $user->name)[1] ?? ''); // Last name
            }
            
            $userData['external_id'] = $this->hashData($user->id);
        }

        return array_merge($userData, $additionalData);
    }

    /**
     * Hash data for Meta's privacy requirements
     */
    protected function hashData(string $data): string
    {
        // Normalize and hash data according to Meta's requirements
        $normalized = strtolower(trim($data));
        return hash('sha256', $normalized);
    }

    /**
     * Track ViewContent event
     */
    public function trackViewContent(array $productData, array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'content_name' => $productData['name'] ?? '',
            'content_ids' => [$productData['id'] ?? ''],
            'content_type' => 'product',
            'value' => $productData['price'] ?? 0,
            'currency' => 'INR',
        ];

        return $this->sendEvent('ViewContent', $userData, $customData);
    }

    /**
     * Track AddToCart event
     */
    public function trackAddToCart(array $productData, array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'content_name' => $productData['name'] ?? '',
            'content_ids' => [$productData['id'] ?? ''],
            'content_type' => 'product',
            'value' => $productData['price'] ?? 0,
            'currency' => 'INR',
            'num_items' => $productData['quantity'] ?? 1,
        ];

        return $this->sendEvent('AddToCart', $userData, $customData);
    }

    /**
     * Track InitiateCheckout event
     */
    public function trackInitiateCheckout(array $checkoutData, array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'content_ids' => $checkoutData['content_ids'] ?? [],
            'content_type' => 'product',
            'value' => $checkoutData['value'] ?? 0,
            'currency' => 'INR',
            'num_items' => $checkoutData['num_items'] ?? 1,
        ];

        return $this->sendEvent('InitiateCheckout', $userData, $customData);
    }

    /**
     * Track Purchase event
     */
    public function trackPurchase(array $orderData, array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'content_ids' => $orderData['content_ids'] ?? [],
            'content_type' => 'product',
            'value' => $orderData['value'] ?? 0,
            'currency' => 'INR',
            'num_items' => $orderData['num_items'] ?? 1,
            'transaction_id' => $orderData['transaction_id'] ?? '',
        ];

        return $this->sendEvent('Purchase', $userData, $customData);
    }

    /**
     * Track CompleteRegistration event
     */
    public function trackCompleteRegistration(array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'status' => 'completed',
            'currency' => 'INR',
            'value' => 0,
        ];

        return $this->sendEvent('CompleteRegistration', $userData, $customData);
    }

    /**
     * Track Lead event
     */
    public function trackLead(array $leadData, array $customUserData = []): array
    {
        $userData = $this->createUserData($customUserData);
        
        $customData = [
            'content_name' => $leadData['form_name'] ?? 'Contact Form',
            'currency' => 'INR',
            'value' => 0,
        ];

        return $this->sendEvent('Lead', $userData, $customData);
    }
}
