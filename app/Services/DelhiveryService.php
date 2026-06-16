<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DelhiveryService
{
    protected $apiKey;
    protected $baseUrl;
    protected $isSandbox;
    protected $pickupPincode;
    protected $pickupLocation;

    public function __construct()
    {
        $this->apiKey = config('services.delhivery.api_key');
        $this->isSandbox = config('services.delhivery.sandbox', true);
        $this->pickupPincode = config('services.delhivery.pickup_pincode', '110001');
        $this->pickupLocation = config('services.delhivery.pickup_location', 'Default Warehouse');

        // Correct API endpoints
        // Sandbox: https://staging-express.delhivery.com
        // Production: https://api.delhivery.com
        $this->baseUrl = $this->isSandbox
            ? 'https://staging-express.delhivery.com'
            : 'https://api.delhivery.com';
    }

    /**
     * Check if pincode is serviceable
     * Corrected to match Delhivery's actual API response
     */
    // public function isPincodeServiceable($deliveryPincode)
    // {
    //     try {
    //         $cacheKey = "pincode_serviceable_{$deliveryPincode}";
    //         if (Cache::has($cacheKey)) {
    //             return Cache::get($cacheKey);
    //         }

    //         // Correct API endpoint for pincode serviceability
    //         $url = $this->baseUrl . '/api/cmu/pincode-serviceability/json/';

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . $this->apiKey,
    //         ])->get($url, [
    //             'pickup_pincode' => $this->pickupPincode,
    //             'delivery_pincode' => $deliveryPincode
    //         ]);

    //         Log::info('Delhivery Pincode Check:', [
    //             'url' => $url,
    //             'pincode' => $deliveryPincode,
    //             'status' => $response->status()
    //         ]);

    //         if ($response->successful()) {
    //             $data = $response->json();

    //             // Parse Delhivery's response structure
    //             // Typical response: [{"pincode":"110001","cash":"Y","cod":"Y","pickup":"Y"}]
    //             if (is_array($data) && count($data) > 0) {
    //                 foreach ($data as $pincodeData) {
    //                     if (isset($pincodeData['pincode']) && $pincodeData['pincode'] == $deliveryPincode) {
    //                         $isServiceable = ($pincodeData['cash'] === 'Y' || $pincodeData['cod'] === 'Y');

    //                         $result = [
    //                             'serviceable' => $isServiceable,
    //                             'message' => $isServiceable ? 'Delivery available to this pincode' : 'Delivery not available for this pincode',
    //                             'courier_name' => 'Delhivery',
    //                             'cash' => $pincodeData['cash'] ?? 'N',
    //                             'cod' => $pincodeData['cod'] ?? 'N',
    //                             'pickup' => $pincodeData['pickup'] ?? 'N'
    //                         ];

    //                         Cache::put($cacheKey, $result, 86400);
    //                         return $result;
    //                     }
    //                 }
    //             }

    //             // Alternative response format
    //             if (isset($data['delivery_cities'])) {
    //                 foreach ($data['delivery_cities'] as $city) {
    //                     if (isset($city['pincode']) && $city['pincode'] == $deliveryPincode) {
    //                         $result = [
    //                             'serviceable' => true,
    //                             'message' => 'Delivery available to this pincode',
    //                             'courier_name' => 'Delhivery'
    //                         ];
    //                         Cache::put($cacheKey, $result, 86400);
    //                         return $result;
    //                     }
    //                 }
    //             }
    //         }

    //         // Fallback for failed API call
    //         return [
    //             'serviceable' => false,
    //             'message' => 'Unable to verify delivery availability',
    //             'courier_name' => null
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Delhivery Exception: ' . $e->getMessage());
    //         return [
    //             'serviceable' => false,
    //             'message' => 'Service temporarily unavailable',
    //             'courier_name' => null
    //         ];
    //     }
    // }

    public function isPincodeServiceable($deliveryPincode)
    {
       
        // Log::info('Delhivery Pincode Check request', [
        //     'base_url' => $this->baseUrl,
        //     'endpoint' => '/c/api/pin-codes/json/',
        //     'pickup_pincode' => $this->pickupPincode,
        //     'delivery_pincode' => $deliveryPincode,
        //     'sandbox' => $this->isSandbox,
        // ]);

        try {
            $cacheKey = "pincode_serviceable_{$deliveryPincode}";
            if (Cache::has($cacheKey)) {
                $cached = Cache::get($cacheKey);
                Log::info('Delhivery pincode cache hit', [
                    'pincode' => $deliveryPincode,
                    'cached_result' => $cached,
                ]);
                return $cached;
            }

            $url = $this->baseUrl . '/c/api/pin-codes/json/?filter_codes=' . urlencode($deliveryPincode);
            
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->get($url);

            // Log::info('Delhivery pincode check response', [
            //     'url' => $url,
            //     'status' => $response->status(),
            //     'body' => $response->body(),
            // ]);

            if ($response->successful()) {
                $data = $response->json();
               

                if (isset($data['delivery_codes']) && is_array($data['delivery_codes']) && count($data['delivery_codes']) > 0) {
                    
                    $deliveryItem = $data['delivery_codes'][0];
                    $postalData = $deliveryItem['postal_code'] ?? $deliveryItem;

                    if (isset($postalData['pin']) || isset($postalData['postal_code'])) {
                        
                        $isServiceable = (
                            ($postalData['cod'] ?? 'N') === 'Y' ||
                            ($postalData['pre_paid'] ?? 'N') === 'Y'
                        );
// dd($isServiceable);
                        $result = [
                            'serviceable' => $isServiceable,
                            'message' => $isServiceable ? 'Delivery available to this pincode' : 'Delivery not available for this pincode',
                            'courier_name' => 'Delhivery',
                            'cod' => $postalData['cod'] ?? 'N',
                            'pre_paid' => $postalData['pre_paid'] ?? 'N',
                            'pickup' => $postalData['pickup'] ?? 'N',
                            'city' => $postalData['city'] ?? 'N/A',
                            'state' => $postalData['state_code'] ?? $postalData['state'] ?? 'N/A'
                        ];
// dd($result);
                        Cache::put($cacheKey, $result, 86400);
                        Log::info('Delhivery pincode check result', $result);
                        return $result;
                    }

                    Log::error('Delhivery pincode payload missing nested postal_code properties', [
                        'delivery_codes' => $deliveryItem,
                        'pincode' => $deliveryPincode,
                    ]);
                } else {
                    // Log::warning('Delhivery pincode not found in response', [
                    //     'response' => $data,
                    //     'pincode' => $deliveryPincode,
                    // ]);

                    return [
                        'serviceable' => false,
                        'message' => 'Delivery information not found for this pincode',
                        'courier_name' => 'Delhivery'
                    ];
                }
            }

            return [
                'serviceable' => false,
                'message' => 'Unable to verify delivery availability',
                'courier_name' => null
            ];
        } catch (\Exception $e) {
            Log::error('Delhivery Exception: ' . $e->getMessage(), [
                'pincode' => $deliveryPincode,
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'serviceable' => false,
                'message' => 'Service temporarily unavailable',
                'courier_name' => null
            ];
        }
    }

    /**
     * Generate waybill number - REMOVED dd()
     */
    public function generateWaybill($count = 1)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
                'count' => $count,
                'format' => 'json'
            ]);

            if ($response->successful()) {
                $waybills = $response->json();

                // Handle different response formats
                if (is_array($waybills)) {
                    if (isset($waybills['waybills'])) {
                        return $waybills['waybills'][0] ?? null;
                    } elseif (isset($waybills[0])) {
                        return $waybills[0];
                    } elseif (isset($waybills['waybill'])) {
                        return $waybills['waybill'];
                    }
                }

                return $waybills;
            }

            Log::error('Delhivery waybill generation failed', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Waybill generation exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create shipment in Delhivery - CORRECTED payload format
     */
    /**
     * Create shipment in Delhivery - CORRECTED for Delhivery's API requirements
     */
    public function createShipment($orderData, $orderItems)
    {

        try {
            // Format products
            $products = [];
            foreach ($orderItems as $item) {
                $products[] = [
                    'name' => $item->name ?? 'Product',
                    'sku' => (string) ($item->variant_id ?? $item->product_id ?? 'SKU_' . uniqid()),
                    'quantity' => (int) $item->quantity,
                    'price' => (float) $item->price,
                ];
            }

            // Prepare shipment data as per Delhivery format
            $shipmentData = [
                'shipments' => [
                    [
                        'name' => $orderData['customer_name'],
                        'add' => $orderData['address'],
                        'city' => $orderData['city'],
                        'state' => $orderData['state'],
                        'country' => 'India',
                        'pin' => $orderData['pincode'],
                        'phone' => $orderData['phone'],
                        'order' => (string) $orderData['order_id'],
                        'payment_mode' => $orderData['payment_method'] === 'cod' ? 'COD' : 'Prepaid',
                        'total_amount' => (float) $orderData['total_amount'],
                        'pickup_location' => $this->pickupLocation,
                        'declared_value' => (float) $orderData['total_amount'],
                        'cod_amount' => $orderData['payment_method'] === 'cod' ? (float) $orderData['total_amount'] : 0,
                        'products' => $products
                    ]
                ]
            ];
            // Log::info('Shipment Data', $shipmentData);
            // ✅ CRITICAL FIX: Send as multipart/form-data, NOT as JSON
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
                'format' => 'json',
                'data' => json_encode($shipmentData)  // Must be JSON string, not array
            ]);
            // dd($response->json());
            $result = $response->json();

            // Log::info('Delhivery Shipment Response:', [
            //     'status' => $response->status(),
            //     'success' => $response->successful(),
            //     'result' => $result
            // ]);

            // Check if shipment was created successfully
            if ($response->successful() && isset($result['success']) && $result['success'] === true) {
                // Extract waybill from response
                $waybill = null;
                $shipmentId = null;

                if (isset($result['packages']) && is_array($result['packages']) && count($result['packages']) > 0) {
                    $waybill = $result['packages'][0]['waybill'] ?? null;
                    $shipmentId = $result['packages'][0]['shipment_id'] ?? null;
                } elseif (isset($result['shipments']) && is_array($result['shipments']) && count($result['shipments']) > 0) {
                    $waybill = $result['shipments'][0]['waybill'] ?? null;
                    $shipmentId = $result['shipments'][0]['shipment_id'] ?? null;
                }

                if ($waybill) {
                    return [
                        'success' => true,
                        'waybill' => $waybill,
                        'shipment_id' => $shipmentId,
                        'message' => 'Shipment created successfully'
                    ];
                }
            }

            // Handle error messages
            $errorMessage = 'Failed to create shipment';
            if (isset($result['message'])) {
                $errorMessage = $result['message'];
            } elseif (isset($result['error'])) {
                $errorMessage = is_string($result['error']) ? $result['error'] : 'API Error';
            } elseif (isset($result['rmk'])) {
                $errorMessage = $result['rmk'];
            }

            Log::error('Delhivery shipment creation failed', [
                'response' => $response->body(),
                'payload' => $shipmentData
            ]);

            return [
                'success' => false,
                'message' => $errorMessage,
                'waybill' => null
            ];
        } catch (\Exception $e) {
            Log::error('Shipment creation exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'waybill' => null
            ];
        }
    }

    /**
     * Track shipment
     */
    public function trackShipment($waybillNumber)
    {
        $endpoints = [
            '/api/v1/packages/json/',
            '/api/packages/json/',
            '/c/api/packages/json/'
        ];

        $queryKeys = [
            'waybill',
            'ref_ids',
            'ref_nos',
            'waybill_number'
        ];

        foreach ($endpoints as $endpoint) {
            foreach ($queryKeys as $queryKey) {
                try {
                    $url = $this->baseUrl . $endpoint;
                    $response = Http::withHeaders([
                        'Authorization' => 'Token ' . $this->apiKey,
                    ])->get($url, [
                        $queryKey => $waybillNumber
                    ]);

                    // Log::info('Delhivery trackShipment attempt', [
                    //     'waybill' => $waybillNumber,
                    //     'endpoint' => $endpoint,
                    //     'param' => $queryKey,
                    //     'status' => $response->status(),
                    //     'body' => $response->body()
                    // ]);

                    if ($response->successful()) {
                        $body = $response->body();

                        if (stripos($body, '<html') !== false) {
                            Log::warning('Delhivery tracking response was HTML, skipping', [
                                'waybill' => $waybillNumber,
                                'endpoint' => $endpoint,
                                'param' => $queryKey,
                            ]);
                            continue;
                        }

                        $data = $response->json();

                        if (!empty($data['Error']) || !empty($data['error'])) {
                            Log::warning('Delhivery tracking response returned error payload', [
                                'waybill' => $waybillNumber,
                                'endpoint' => $endpoint,
                                'param' => $queryKey,
                                'response' => $data,
                            ]);
                            continue;
                        }

                        if (isset($data['ShipmentData']) || isset($data['packages']) || isset($data['shipments'])) {
                            return $data;
                        }

                        if (is_array($data) && isset($data[0]['Status'])) {
                            return $data;
                        }

                        Log::warning('Delhivery tracking response did not contain expected payload', [
                            'waybill' => $waybillNumber,
                            'endpoint' => $endpoint,
                            'param' => $queryKey,
                            'response' => $data,
                        ]);
                        continue;
                    }

                    if ($response->status() === 405 && stripos($endpoint, '/api/v1/') !== false) {
                        $response = Http::withHeaders([
                            'Authorization' => 'Token ' . $this->apiKey,
                        ])->asForm()->post($url, [
                            $queryKey => $waybillNumber
                        ]);

                        Log::info('Delhivery trackShipment POST fallback attempt', [
                            'waybill' => $waybillNumber,
                            'endpoint' => $endpoint,
                            'param' => $queryKey,
                            'status' => $response->status(),
                            'body' => $response->body()
                        ]);

                        if ($response->successful()) {
                            $body = $response->body();
                            if (stripos($body, '<html') !== false) {
                                continue;
                            }

                            $data = $response->json();
                            if (!empty($data['Error']) || !empty($data['error'])) {
                                continue;
                            }

                            if (isset($data['ShipmentData']) || isset($data['packages']) || isset($data['shipments']) || (is_array($data) && isset($data[0]['Status']))) {
                                return $data;
                            }
                        }
                    }

                    if ($response->status() !== 404) {
                        Log::error('Tracking failed for waybill: ' . $waybillNumber, [
                            'endpoint' => $endpoint,
                            'param' => $queryKey,
                            'status' => $response->status(),
                            'response' => $response->body()
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Tracking exception for waybill: ' . $waybillNumber, [
                        'endpoint' => $endpoint,
                        'param' => $queryKey,
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        }

        return null;
    }

    /**
     * Cancel shipment
     */
    public function cancelShipment($waybillNumber)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->get($this->baseUrl . '/api/packages/cancel/', [
                'waybill' => $waybillNumber
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Shipment cancellation exception: ' . $e->getMessage());
            return false;
        }
    }

    public function getWaybillDetails(string $waybillNumber): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->get($this->baseUrl . '/api/packages/json/', [
                'waybill' => $waybillNumber
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Waybill details fetched successfully', ['waybill' => $waybillNumber, 'data' => $data]);
                return $data;
            }

            Log::error('Failed to fetch waybill details', [
                'waybill' => $waybillNumber,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception fetching waybill details: ' . $e->getMessage());
            return null;
        }
    }

}
