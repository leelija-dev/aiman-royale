<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
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
        Log::info('META CAPI COVERAGE', [
            'event' => $eventName,
            'event_id' => $event['event_id'],

            'has_em' => !empty($userData['em']),
            'has_ph' => !empty($userData['ph']),
            'has_fn' => !empty($userData['fn']),
            'has_ln' => !empty($userData['ln']),

            'has_fbc' => !empty($userData['fbc']),
            'has_fbp' => !empty($userData['fbp']),

            'has_external_id' => !empty($userData['external_id']),
            'has_ip' => !empty($userData['client_ip_address']),
            'has_user_agent' => !empty($userData['client_user_agent']),
        ]);
        // Clean empty values
        $event = array_filter($event, fn($v) => $v !== null && $v !== []);

        try {
            // $response = Http::asJson()->post($url, [
            //     'data'         => [$event],
            //     'access_token' => $this->accessToken,
            //     // 'test_event_code' => 'TEST12345', // Uncomment while testing
            // ]);
            $response = Http::asJson()
                ->timeout(4)
                ->retry(1, 100)
                ->post($url, [
                    'data'         => [$event],
                    'access_token' => $this->accessToken,
                    // 'test_event_code' => 'TEST12345', // uncomment only for testing
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

            // return $result;
            return $result ?? ['success' => false];
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

        /*
        |--------------------------------------------------------------------------
        | Meta browser identifiers
        |--------------------------------------------------------------------------
        */
        if ($fbc = $this->resolveFbc()) {
            $userData['fbc'] = $fbc;
        }

        if ($fbp = $this->resolveFbp()) {
            $userData['fbp'] = $fbp;
        }

        /*
        |--------------------------------------------------------------------------
        | Logged-in customer
        |--------------------------------------------------------------------------
        */
        if (Auth::check()) {

            $user = Auth::user();

            if (!empty($user->email)) {
                $userData['em'] = [
                    $this->hashData($user->email)
                ];
            }

            if (!empty($user->phone)) {
                $userData['ph'] = [
                    $this->hashPhone($user->phone)
                ];
            }

            if (!empty($user->name)) {

                $parts = preg_split(
                    '/\s+/',
                    trim($user->name),
                    2
                );

                if (!empty($parts[0])) {
                    $userData['fn'] = [
                        $this->hashData($parts[0])
                    ];
                }

                if (!empty($parts[1])) {
                    $userData['ln'] = [
                        $this->hashData($parts[1])
                    ];
                }
            }

            if (!empty($user->id)) {
                $userData['external_id'] = [
                    $this->hashData((string) $user->id)
                ];
            }
            // Date of birth - send only when available
            if (!empty($user->date_of_birth)) {
                $dob = date('Ymd', strtotime($user->date_of_birth));

                $userData['db'] = [
                    $this->hashData($dob)
                ];
            }

        /*
        |--------------------------------------------------------------------------
        | Guest customer
        |--------------------------------------------------------------------------
        */
        } else {

            $userData['external_id'] = [
                $this->hashData($this->guestId())
            ];

            if ($guestEmail = request()->cookie('_meta_guest_em')) {
                $userData['em'] = [
                    $this->hashData($guestEmail)
                ];
            }

            if ($guestPhone = request()->cookie('_meta_guest_ph')) {
                $userData['ph'] = [
                    $this->hashPhone($guestPhone)
                ];
            }

            if ($guestName = request()->cookie('_meta_guest_name')) {

                $parts = preg_split(
                    '/\s+/',
                    trim($guestName),
                    2
                );

                if (!empty($parts[0])) {
                    $userData['fn'] = [
                        $this->hashData($parts[0])
                    ];
                }

                if (!empty($parts[1])) {
                    $userData['ln'] = [
                        $this->hashData($parts[1])
                    ];
                }
            }

            if ($guestCity = request()->cookie('_meta_guest_ct')) {
                $userData['ct'] = [
                    $this->hashData($guestCity)
                ];
            }

            if ($guestState = request()->cookie('_meta_guest_st')) {
                $userData['st'] = [
                    $this->hashData($guestState)
                ];
            }

            if ($guestZip = request()->cookie('_meta_guest_zp')) {
                $userData['zp'] = [
                    $this->hashData($guestZip)
                ];
            }
            if ($guestDb = request()->cookie('_meta_guest_db')) {
                $userData['db'] = [
                    $this->hashData($guestDb)
                ];
            }
            if ($guestFbc = request()->cookie('_meta_guest_fbc')) {
                $userData['fbc'] = $guestFbc;
            }
            if ($guestFbp = request()->cookie('_meta_guest_fbp')) {
                $userData['fbp'] = $guestFbp;
            }
          
        }

        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */
        $userData['country'] = [
            $this->hashData('in')
        ];

        /*
        |--------------------------------------------------------------------------
        | Additional RAW customer data
        |
        | Callers should pass RAW values.
        | This method hashes them exactly once.
        |--------------------------------------------------------------------------
        */
        foreach ($additionalData as $key => $value) {

            if ($value === null || $value === '') {
                continue;
            }

            $value = is_array($value) ? ($value[0] ?? null) : $value;

            if ($value === null || $value === '') {
                continue;
            }

            switch ($key) {

                case 'em':
                    $hashed = $this->hashData($value);

                    if ($hashed) {
                        $userData['em'] = [$hashed];
                    }
                    break;

                case 'ph':
                    $hashed = $this->hashPhone($value);

                    if ($hashed) {
                        $userData['ph'] = [$hashed];
                    }
                    break;

                case 'fn':
                case 'ln':
                case 'ct':
                case 'st':
                case 'db':
                case 'zp':
                case 'country':
                case 'external_id':
                    $hashed = $this->hashData($value);

                    if ($hashed) {
                        $userData[$key] = [$hashed];
                    }
                    break;

                default:
                    $userData[$key] = $value;
                    break;
            }
        }

        return array_filter(
            $userData,
            fn ($v) => $v !== null && $v !== [] && $v !== ''
        );
    }
    /** Store guest-provided contact info the moment we get it — checkout form, popup, OTP attempt, etc. */
public function rememberGuestContact(
    ?string $email = null,
    ?string $phone = null,
    ?string $name = null,
    ?string $city = null,
    ?string $state = null,
    ?string $zip = null,
    ?string $db = null,

): void
{
    if ($email) {
        Cookie::queue('_meta_guest_em', $email, 60 * 24 * 90);
    }
    if ($phone) {
        Cookie::queue('_meta_guest_ph', $phone, 60 * 24 * 90);
    }
    if ($name) {
        Cookie::queue('_meta_guest_name', $name, 60 * 24 * 90);
    }
    if ($city) {
        Cookie::queue('_meta_guest_ct', $city, 60 * 24 * 90);
    }
    if ($state) {
        Cookie::queue('_meta_guest_st', $state, 60 * 24 * 90);
    }
    if ($zip) {
        Cookie::queue('_meta_guest_zp', $zip, 60 * 24 * 90);
    }
    if ($db) {
        Cookie::queue('_meta_guest_db', $db, 60 * 24 * 90);
    }
   
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
        /** fbc from cookie, else rebuilt from ?fbclid= */
    protected function resolveFbc(): ?string
    {
        if ($fbc = request()->cookie('_fbc')) {
            return $fbc;
        }

        if ($fbclid = request()->query('fbclid')) {
            $fbc = 'fb.1.' . (time() * 1000) . '.' . $fbclid;
            Cookie::queue('_fbc', $fbc, 60 * 24 * 90); // 90 days
            return $fbc;
        }

        return null;
    }

    /** fbp from Pixel cookie, else generated server-side */
    // protected function resolveFbp(): ?string
    // {
    //     if ($fbp = request()->cookie('_fbp')) {
    //         return $fbp;
    //     }

    //     $fbp = 'fb.1.' . (time() * 1000) . '.' . random_int(1000000000, 9999999999);
    //     Cookie::queue('_fbp', $fbp, 60 * 24 * 90);

    //     return $fbp;
    // }
    protected function resolveFbp(): ?string
{
    return request()->cookie('_fbp') ?: null;
}

    /** Stable guest identifier stored in a first-party cookie */
    protected function guestId(): string
    {
        if ($id = request()->cookie('_meta_gid')) {
            return $id;
        }

        $id = (string) Str::uuid();
        Cookie::queue('_meta_gid', $id, 60 * 24 * 365);

        return $id;
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
    // public function trackPurchase(array $orderData, array $customUserData = [], ?string $eventId = null): array
    // {
    //     $customData = array_filter([
    //         'content_ids'  => $orderData['content_ids'] ?? null,
    //         'content_type' => 'product',
    //         'value'        => (float)($orderData['value'] ?? 0),
    //         'currency'     => $orderData['currency'] ?? 'INR',
    //         'num_items'    => (int)($orderData['num_items'] ?? 1),
    //         'order_id'     => $orderData['order_id'] ?? $orderData['transaction_id'] ?? null,
    //     ]);

    //     // Best practice: use order_id as event_id
    //     $eventId = $eventId ?? ($orderData['order_id'] ?? $orderData['transaction_id'] ?? null);

    //     return $this->sendEvent('Purchase', $this->createUserData($customUserData), $customData, $eventId);
    // }
    public function trackPurchase(
    array $orderData,
    array $customerData = [],
    ?string $eventId = null
): array {

    $customData = array_filter([
        'content_ids' => $orderData['content_ids'] ?? null,
        'content_type' => $orderData['content_type'] ?? 'product',
        'value' => (float) ($orderData['value'] ?? 0),
        'currency' => $orderData['currency'] ?? 'INR',
        'num_items' => (int) ($orderData['num_items'] ?? 1),
        'order_id' => $orderData['order_id']
            ?? $orderData['transaction_id']
            ?? null,
    ]);

    $eventId = $eventId
        ?? ($orderData['order_id']
        ?? $orderData['transaction_id']
        ?? null);

    return $this->sendEvent(
        'Purchase',
        $this->createUserData($customerData),
        $customData,
        $eventId
    );
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