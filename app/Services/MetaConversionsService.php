<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MetaConversionsService
{
    protected string $pixelId;
    protected string $accessToken;
    protected string $apiVersion = 'v21.0';

    public function __construct()
    {
        $this->pixelId     = config('services.meta.pixel_id');
        $this->accessToken = config('services.meta.access_token');
    }

    /**
     * Core method to send any event
     */
    public function sendEvent(
        string $eventName,
        array $userData = [],
        array $customData = [],
        ?string $eventId = null,
        ?string $eventSourceUrl = null
    ): array {
        if (!$this->pixelId || !$this->accessToken) {
            Log::warning('Meta CAPI disabled: Missing credentials');
            return ['success' => false, 'message' => 'Meta credentials not configured'];
        }

        $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->pixelId}/events";

        $event = [
            'event_name'       => $eventName,
            'event_time'       => time(),
            'action_source'    => 'website',
            'event_id'         => $eventId ?? (string) Str::uuid(),
            'event_source_url' => $eventSourceUrl ?? request()->fullUrl(),
            'user_data'        => $userData,
            'custom_data'      => empty($customData) ? (object)[] : $customData,
        ];

        // Clean empty values
        $event = array_filter($event, fn($v) => $v !== null && $v !== []);

        try {
            $response = Http::asJson()->post($url, [
                'data'         => [$event],
                'access_token' => $this->accessToken,
                // 'test_event_code' => 'TEST12345', // Uncomment while testing
            ]);

            $result = $response->json();

            if ($response->successful()) {
                Log::info('Meta CAPI → ' . $eventName, [
                    'event_id' => $event['event_id'],
                    'response' => $result
                ]);
            } else {
                Log::error('Meta CAPI Error → ' . $eventName, [
                    'status'   => $response->status(),
                    'response' => $result
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Meta CAPI Exception → ' . $eventName, [
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Build user_data properly
     */
    public function createUserData(array $additionalData = []): array
    {
        $userData = [
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent(),
        ];

        // Very important for match quality
        if ($fbc = request()->cookie('_fbc')) {
            $userData['fbc'] = $fbc;
        }
        if ($fbp = request()->cookie('_fbp')) {
            $userData['fbp'] = $fbp;
        }

        // Logged-in user
        if (Auth::check()) {
            $user = Auth::user();

            if (!empty($user->email)) {
                $userData['em'] = [$this->hashData($user->email)];
            }

            if (!empty($user->phone)) {
                $userData['ph'] = [$this->hashPhone($user->phone)];
            }

            if (!empty($user->name)) {
                $parts = explode(' ', trim($user->name), 2);
                $userData['fn'] = [$this->hashData($parts[0] ?? '')];
                if (isset($parts[1])) {
                    $userData['ln'] = [$this->hashData($parts[1])];
                }
            }

            $userData['external_id'] = [$this->hashData((string) $user->id)];
        }

        // Merge extra data (guest users etc.)
        foreach ($additionalData as $key => $value) {
            if (in_array($key, ['em', 'ph', 'fn', 'ln', 'ct', 'st', 'zp', 'country', 'external_id'])) {
                $userData[$key] = is_array($value) ? $value : [$value];
            } else {
                $userData[$key] = $value;
            }
        }

        return array_filter($userData, fn($v) => $v !== null && $v !== [] && $v !== '');
    }

    protected function hashData(?string $data): ?string
    {
        if (empty($data)) return null;
        return hash('sha256', strtolower(trim($data)));
    }

    public function hashPhone(?string $phone, string $countryCode = '91'): ?string
    {
        if (empty($phone)) return null;

        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Add country code if 10 digit number (India)
        if (strlen($phone) === 10) {
            $phone = $countryCode . $phone;
        }

        return hash('sha256', $phone);
    }

    // =====================================================
    // ALL STANDARD EVENTS
    // =====================================================

    /** PageView */
    public function trackPageView(array $customUserData = [], ?string $eventId = null): array
    {
        return $this->sendEvent(
            'PageView',
            $this->createUserData($customUserData),
            [],
            $eventId
        );
    }

    /** ViewContent */
    public function trackViewContent(array $productData, array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_name' => $productData['name'] ?? null,
            'content_ids'  => isset($productData['id']) ? [(string)$productData['id']] : null,
            'content_type' => 'product',
            'value'        => (float)($productData['price'] ?? 0),
            'currency'     => $productData['currency'] ?? 'INR',
            'content_category' => $productData['category'] ?? null,
        ]);

        return $this->sendEvent('ViewContent', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** AddToCart */
    public function trackAddToCart(array $productData, array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_name' => $productData['name'] ?? null,
            'content_ids'  => isset($productData['id']) ? [(string)$productData['id']] : null,
            'content_type' => 'product',
            'value'        => (float)($productData['price'] ?? 0),
            'currency'     => $productData['currency'] ?? 'INR',
            'num_items'    => (int)($productData['quantity'] ?? 1),
        ]);

        return $this->sendEvent('AddToCart', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** AddToWishlist */
    public function trackAddToWishlist(array $productData, array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_name' => $productData['name'] ?? null,
            'content_ids'  => isset($productData['id']) ? [(string)$productData['id']] : null,
            'content_type' => 'product',
            'value'        => (float)($productData['price'] ?? 0),
            'currency'     => $productData['currency'] ?? 'INR',
        ]);

        return $this->sendEvent('AddToWishlist', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** InitiateCheckout */
    public function trackInitiateCheckout(array $data, array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_ids'  => $data['content_ids'] ?? null,
            'content_type' => 'product',
            'value'        => (float)($data['value'] ?? 0),
            'currency'     => $data['currency'] ?? 'INR',
            'num_items'    => (int)($data['num_items'] ?? 1),
        ]);

        return $this->sendEvent('InitiateCheckout', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** AddPaymentInfo */
    public function trackAddPaymentInfo(array $data = [], array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_ids'  => $data['content_ids'] ?? null,
            'content_type' => 'product',
            'value'        => (float)($data['value'] ?? 0),
            'currency'     => $data['currency'] ?? 'INR',
        ]);

        return $this->sendEvent('AddPaymentInfo', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** Purchase */
    public function trackPurchase(array $orderData, array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_ids'  => $orderData['content_ids'] ?? null,
            'content_type' => 'product',
            'value'        => (float)($orderData['value'] ?? 0),
            'currency'     => $orderData['currency'] ?? 'INR',
            'num_items'    => (int)($orderData['num_items'] ?? 1),
            'order_id'     => $orderData['order_id'] ?? $orderData['transaction_id'] ?? null,
        ]);

        // Best practice: use order_id as event_id
        $eventId = $eventId ?? ($orderData['order_id'] ?? $orderData['transaction_id'] ?? null);

        return $this->sendEvent('Purchase', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** CompleteRegistration */
    public function trackCompleteRegistration(array $customUserData = [], ?string $eventId = null): array
    {
        return $this->sendEvent(
            'CompleteRegistration',
            $this->createUserData($customUserData),
            ['status' => 'completed'],
            $eventId
        );
    }

    /** Lead */
    public function trackLead(array $leadData = [], array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'content_name' => $leadData['form_name'] ?? 'Lead Form',
            'currency'     => 'INR',
            'value'        => (float)($leadData['value'] ?? 0),
        ]);

        return $this->sendEvent('Lead', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** Search */
    public function trackSearch(string $searchString, array $customUserData = [], ?string $eventId = null): array
    {
        return $this->sendEvent(
            'Search',
            $this->createUserData($customUserData),
            ['search_string' => $searchString],
            $eventId
        );
    }

    /** Contact */
    public function trackContact(array $customUserData = [], ?string $eventId = null): array
    {
        return $this->sendEvent('Contact', $this->createUserData($customUserData), [], $eventId);
    }

    /** Subscribe */
    public function trackSubscribe(array $data = [], array $customUserData = [], ?string $eventId = null): array
    {
        $customData = array_filter([
            'value'    => (float)($data['value'] ?? 0),
            'currency' => $data['currency'] ?? 'INR',
            'predicted_ltv' => $data['predicted_ltv'] ?? null,
        ]);

        return $this->sendEvent('Subscribe', $this->createUserData($customUserData), $customData, $eventId);
    }

    /** Custom Event (any event you want) */
    public function trackCustom(string $eventName, array $customData = [], array $customUserData = [], ?string $eventId = null): array
    {
        return $this->sendEvent($eventName, $this->createUserData($customUserData), $customData, $eventId);
    }
}