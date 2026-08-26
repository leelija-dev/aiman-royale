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
    protected $returnAddress;

    public function __construct()
    {
        $this->apiKey = config('services.delhivery.api_key');
        $this->isSandbox = config('services.delhivery.sandbox', true);
        $this->pickupPincode = config('services.delhivery.pickup_pincode', '110001');
        $this->pickupLocation = config('services.delhivery.pickup_location', 'Default Warehouse');

        $this->returnAddress = [
            'name' => config('services.delhivery.return_name'),
            'add' => config('services.delhivery.return_add'),
            'city' => config('services.delhivery.return_city'),
            'state' => config('services.delhivery.return_state'),
            'country' => config('services.delhivery.return_country', 'India'),
            'pin' => config('services.delhivery.return_pincode'),
            'phone' => config('services.delhivery.return_phone'),
        ];

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
        try {
            $cacheKey = "pincode_serviceable_{$deliveryPincode}";
            if (Cache::has($cacheKey)) {
                $cached = Cache::get($cacheKey);
                return $cached;
            }

            $url = $this->baseUrl . '/c/api/pin-codes/json/?filter_codes=' . urlencode($deliveryPincode);

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['delivery_codes']) && is_array($data['delivery_codes']) && count($data['delivery_codes']) > 0) {
                    $deliveryItem = $data['delivery_codes'][0];
                    $postalData = $deliveryItem['postal_code'] ?? $deliveryItem;

                    if (isset($postalData['pin']) || isset($postalData['postal_code'])) {
                        // IMPORTANT: Check COD specifically
                        $isServiceable = (
                            ($postalData['cod'] ?? 'N') === 'Y' &&
                            ($postalData['pickup'] ?? 'N') === 'Y'
                        );

                        // Also check if COD is actually available
                        $codAvailable = ($postalData['cod'] ?? 'N') === 'Y';
                        $pickupAvailable = ($postalData['pickup'] ?? 'N') === 'Y';

                        $result = [
                            'serviceable' => $isServiceable,
                            'cod_available' => $codAvailable,
                            'pickup_available' => $pickupAvailable,
                            'message' => $isServiceable ? 'Delivery available to this pincode' : 'Delivery not available for this pincode',
                            'courier_name' => 'Delhivery',
                            'cod' => $postalData['cod'] ?? 'N',
                            'pre_paid' => $postalData['pre_paid'] ?? 'N',
                            'pickup' => $postalData['pickup'] ?? 'N',
                            'city' => $postalData['city'] ?? 'N/A',
                            'state' => $postalData['state_code'] ?? $postalData['state'] ?? 'N/A'
                        ];

                        Cache::put($cacheKey, $result, 86400);
                        return $result;
                    }
                }

                return [
                    'serviceable' => false,
                    'cod_available' => false,
                    'pickup_available' => false,
                    'message' => 'Delivery information not found for this pincode',
                    'courier_name' => 'Delhivery'
                ];
            }

            return [
                'serviceable' => false,
                'cod_available' => false,
                'pickup_available' => false,
                'message' => 'Unable to verify delivery availability',
                'courier_name' => null
            ];
        } catch (\Exception $e) {
            Log::error('Delhivery Exception: ' . $e->getMessage());
            return [
                'serviceable' => false,
                'cod_available' => false,
                'pickup_available' => false,
                'message' => 'Service temporarily unavailable',
                'courier_name' => null
            ];
        }
    }

    /**
     * Generate waybill number - REMOVED dd()
     */
    // public function generateWaybill($count = 1)
    // {
    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . $this->apiKey,
    //         ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
    //             'count' => $count,
    //             'format' => 'json'
    //         ]);

    //         if ($response->successful()) {
    //             $waybills = $response->json();

    //             // Handle different response formats
    //             if (is_array($waybills)) {
    //                 if (isset($waybills['waybills'])) {
    //                     return $waybills['waybills'][0] ?? null;
    //                 } elseif (isset($waybills[0])) {
    //                     return $waybills[0];
    //                 } elseif (isset($waybills['waybill'])) {
    //                     return $waybills['waybill'];
    //                 }
    //             }

    //             return $waybills;
    //         }

    //         Log::error('Delhivery waybill generation failed', [
    //             'response' => $response->body(),
    //             'status' => $response->status()
    //         ]);
    //         return null;
    //     } catch (\Exception $e) {
    //         Log::error('Waybill generation exception: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Generate waybill number
     * Correct endpoint: GET /waybill/api/bulk/json/?count=1
     */
    public function generateWaybill($count = 1)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/waybill/api/bulk/json/', [
                'count' => (int)$count
            ]);

            Log::info('Delhivery waybill generation response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $waybills = $response->json();

                // Handle different response formats
                if (is_array($waybills)) {
                    // Check for waybills array
                    if (isset($waybills['waybills']) && is_array($waybills['waybills'])) {
                        return $waybills['waybills'][0] ?? null;
                    }

                    // Check for bulk response format
                    if (isset($waybills['bulk_waybill']) && is_array($waybills['bulk_waybill'])) {
                        return $waybills['bulk_waybill'][0] ?? null;
                    }

                    // Check for direct waybill
                    if (isset($waybills['waybill'])) {
                        return $waybills['waybill'];
                    }

                    // If response is a simple array of waybills
                    if (isset($waybills[0])) {
                        return $waybills[0];
                    }
                }

                // If response is a string that looks like a waybill number
                if (is_string($waybills) && preg_match('/^\d+$/', $waybills)) {
                    return $waybills;
                }

                Log::warning('Unexpected waybill response format', ['response' => $waybills]);
                return null;
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
     * Create shipment in Delhivery - CORRECTED for Delhivery's API requirements
     */
    // public function createShipment($orderData, $orderItems)
    // {

    //     try {
    //         // Format products
    //         $products = [];
    //         foreach ($orderItems as $item) {
    //             $products[] = [
    //                 'name' => $item->name ?? 'Product',
    //                 'sku' => (string) ($item->variant_id ?? $item->product_id ?? 'SKU_' . uniqid()),
    //                 'quantity' => (int) $item->quantity,
    //                 'price' => (float) $item->price,
    //             ];
    //         }

    //         // Prepare shipment data as per Delhivery format
    //         // $shipmentData = [
    //         //     'shipments' => [
    //         //         [
    //         //             'name' => $orderData['customer_name'],
    //         //             'add' => $orderData['address'],
    //         //             'city' => $orderData['city'],
    //         //             'state' => $orderData['state'],
    //         //             'country' => 'India',
    //         //             'pin' => $orderData['pincode'],
    //         //             'phone' => $orderData['phone'],
    //         //             'order' => (string) $orderData['order_id'],
    //         //             'payment_mode' => $orderData['payment_method'] === 'cod' ? 'COD' : 'Prepaid',
    //         //             'total_amount' => (float) $orderData['total_amount'],
    //         //             'pickup_location' => $this->pickupLocation,
    //         //             'declared_value' => (float) $orderData['total_amount'],
    //         //             'cod_amount' => $orderData['payment_method'] === 'cod' ? (float) $orderData['total_amount'] : 0,
    //         //             'products' => $products
    //         //         ]
    //         //     ]
    //         // ];

    //         $shipmentData = [
    //             'shipments' => [
    //                 [
    //                     'name' => $orderData['customer_name'],
    //                     'add' => $orderData['address'],
    //                     'city' => $orderData['city'],
    //                     'state' => $orderData['state'],
    //                     'country' => 'India',
    //                     'pin' => $orderData['pincode'],
    //                     'phone' => $orderData['phone'],
    //                     'order' => (string) $orderData['order_id'],
    //                     'payment_mode' => $orderData['payment_method'] === 'cod' ? 'COD' : 'Prepaid',
    //                     'total_amount' => (float) $orderData['total_amount'],
    //                     'pickup_location' => $this->pickupLocation,
    //                     'declared_value' => (float) $orderData['total_amount'],
    //                     'cod_amount' => $orderData['payment_method'] === 'cod' ? (float) $orderData['total_amount'] : 0,
    //                     'products' => $products
    //                 ]
    //             ]
    //         ];
    //         // Log::info('Shipment Data', $shipmentData);
    //         // ✅ CRITICAL FIX: Send as multipart/form-data, NOT as JSON
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . $this->apiKey,
    //         ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
    //             'format' => 'json',
    //             'data' => json_encode($shipmentData)  // Must be JSON string, not array
    //         ]);
    //         // dd($response->json());
    //         $result = $response->json();

    //         // Log::info('Delhivery Shipment Response:', [
    //         //     'status' => $response->status(),
    //         //     'success' => $response->successful(),
    //         //     'result' => $result
    //         // ]);

    //         // Check if shipment was created successfully
    //         if ($response->successful() && isset($result['success']) && $result['success'] === true) {
    //             // Extract waybill from response
    //             $waybill = null;
    //             $shipmentId = null;

    //             if (isset($result['packages']) && is_array($result['packages']) && count($result['packages']) > 0) {
    //                 $waybill = $result['packages'][0]['waybill'] ?? null;
    //                 $shipmentId = $result['packages'][0]['shipment_id'] ?? null;
    //             } elseif (isset($result['shipments']) && is_array($result['shipments']) && count($result['shipments']) > 0) {
    //                 $waybill = $result['shipments'][0]['waybill'] ?? null;
    //                 $shipmentId = $result['shipments'][0]['shipment_id'] ?? null;
    //             }

    //             if ($waybill) {
    //                 return [
    //                     'success' => true,
    //                     'waybill' => $waybill,
    //                     'shipment_id' => $shipmentId,
    //                     'message' => 'Shipment created successfully'
    //                 ];
    //             }
    //         }

    //         // Handle error messages
    //         $errorMessage = 'Failed to create shipment';
    //         if (isset($result['message'])) {
    //             $errorMessage = $result['message'];
    //         } elseif (isset($result['error'])) {
    //             $errorMessage = is_string($result['error']) ? $result['error'] : 'API Error';
    //         } elseif (isset($result['rmk'])) {
    //             $errorMessage = $result['rmk'];
    //         }

    //         Log::error('Delhivery shipment creation failed', [
    //             'response' => $response->body(),
    //             'payload' => $shipmentData
    //         ]);

    //         return [
    //             'success' => false,
    //             'message' => $errorMessage,
    //             'waybill' => null
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Shipment creation exception: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //             'waybill' => null
    //         ];
    //     }
    // }

    /**
     * Create shipment in Delhivery - With better error handling
     */
    public function createShipment($orderData, $orderItems)
    {
        try {
            // Format products
            $products = [];
            $totalQuantity = 0;
            foreach ($orderItems as $item) {
                $products[] = [
                    'name' => $item->name ?? 'Product',
                    'sku' => (string) ($item->variant_id ?? $item->product_id ?? 'SKU_' . uniqid()),
                    'quantity' => (int) $item->quantity,
                    'price' => (float) $item->price,
                ];
            }

            $productNames = array_column($products, 'name');
            $products_desc = implode(', ', $productNames);

            // Prepare shipment data
            $shipmentData = ['shipments' => [['name' => $orderData['customer_name'], 'add' => $orderData['address'], 'city' => $orderData['city'], 'state' => $orderData['state'], 'country' => 'India', 'pin' => $orderData['pincode'], 'phone' => $orderData['phone'], 'order' => (string) $orderData['order_id'], 'payment_mode' => $orderData['payment_method'] === 'cod' ? 'COD' : 'Prepaid', 'total_amount' => (float) $orderData['total_amount'], 'declared_value' => (float) $orderData['total_amount'], 'cod_amount' => $orderData['payment_method'] === 'cod' ? (float) $orderData['total_amount'] : 0, 'products' => $products, 'products_desc' => $products_desc,],], 'pickup_location' => ['name' => $this->pickupLocation,],];



            Log::info('Delhivery shipment payload', [
                'payload' => $shipmentData
            ]);

            // Send as form data
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
            ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
                'format' => 'json',
                'data' => json_encode($shipmentData)
            ]);

            $result = $response->json();

            Log::info('Delhivery Shipment Response:', [
                'status' => $response->status(),
                'result' => $result
            ]);

            // Check if shipment was created successfully
            if ($response->successful()) {
                // Check for error messages in the response
                if (isset($result['rmk']) && $result['success'] === false) {
                    // Get detailed error from packages
                    $errorMessage = $result['rmk'];
                    if (isset($result['packages']) && is_array($result['packages'])) {
                        foreach ($result['packages'] as $package) {
                            if (isset($package['remarks']) && is_array($package['remarks'])) {
                                foreach ($package['remarks'] as $remark) {
                                    if (isset($remark['message'])) {
                                        $errorMessage .= ' - ' . $remark['message'];
                                    }
                                }
                            }
                        }
                    }

                    return [
                        'success' => false,
                        'message' => $errorMessage,
                        'waybill' => null
                    ];
                }

                // Check if we have packages with waybills
                if (isset($result['packages']) && is_array($result['packages']) && count($result['packages']) > 0) {
                    $package = $result['packages'][0];

                    // Check if package status is success
                    if (isset($package['status']) && $package['status'] === 'Success') {
                        $waybill = $package['waybill'] ?? null;
                        $shipmentId = $package['shipment_id'] ?? null;

                        if ($waybill) {
                            return [
                                'success' => true,
                                'waybill' => $waybill,
                                'shipment_id' => $shipmentId,
                                'message' => 'Shipment created successfully'
                            ];
                        }
                    } else {
                        // Package failed - get the error message
                        $errorMessage = 'Shipment creation failed';
                        if (isset($package['remarks']) && is_array($package['remarks'])) {
                            foreach ($package['remarks'] as $remark) {
                                if (isset($remark['message'])) {
                                    $errorMessage = $remark['message'];
                                    break;
                                }
                            }
                        }

                        return [
                            'success' => false,
                            'message' => $errorMessage,
                            'waybill' => null
                        ];
                    }
                }

                // Check for success flag
                if (isset($result['success']) && $result['success'] === true) {
                    return [
                        'success' => true,
                        'waybill' => $result['waybill'] ?? null,
                        'shipment_id' => $result['shipment_id'] ?? null,
                        'message' => 'Shipment created successfully'
                    ];
                }
            }

            // Handle error messages
            $errorMessage = 'Failed to create shipment';
            if (isset($result['rmk'])) {
                $errorMessage = $result['rmk'];
            } elseif (isset($result['message'])) {
                $errorMessage = $result['message'];
            } elseif (isset($result['error'])) {
                $errorMessage = is_string($result['error']) ? $result['error'] : 'API Error';
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
     * Create reverse pickup shipment in Delhivery
     */
    // public function createReverseShipment(array $reverseOrderData, $orderItems)
    // {
        
    //     $products = [];
    //     foreach ($orderItems as $item) {
    //         $products[] = [
    //             'name' => $item->sku_name ?? $item->name ?? 'Product',
    //             'sku' => (string) ($item->sku_code ?? $item->variant_id ?? $item->product_id ?? 'SKU_' . uniqid()),
    //             'quantity' => (int) ($item->quantity ?? 1),
    //             'price' => (float) ($item->price ?? 0),
    //         ];
    //     }

    //     $shipmentData = [
    //         'shipments' => [
    //             [
    //                 // PICKUP LOCATION: Where Delhivery picks up from (Customer's address)
    //                 'name' => $reverseOrderData['return_contact_name'] ?? 'Customer',
    //                 'add' => trim(($reverseOrderData['return_address_1'] ?? '') . ' ' . ($reverseOrderData['return_address_2'] ?? '')),
    //                 'city' => $reverseOrderData['return_city'] ?? '',
    //                 'state' => $reverseOrderData['return_state'] ?? '',
    //                 'country' => 'India',
    //                 'pin' => $reverseOrderData['return_pincode'] ?? '',
    //                 'phone' => $reverseOrderData['return_phone_no'] ?? '',
    //                 'order' => (string) ($reverseOrderData['reverse_order_number'] ?? $reverseOrderData['order_id'] ?? ''),
    //                 'payment_mode' => 'Prepaid',
    //                 'shipping_mode' => config('services.delhivery.shipping_mode', 'Express'),
    //                 'total_amount' => (float) ($reverseOrderData['total_amount'] ?? 0),
    //                 'declared_value' => (float) ($reverseOrderData['declared_value'] ?? $reverseOrderData['total_amount'] ?? 0),
    //                 'cod_amount' => 0,
    //                 // PICKUP LOCATION: Customer's address as object for reverse shipment
    //                 'pickup_location' => [
    //                     'name' => $reverseOrderData['return_contact_name'] ?? 'Customer',
    //                     'add' => trim(($reverseOrderData['return_address_1'] ?? '') . ' ' . ($reverseOrderData['return_address_2'] ?? '')),
    //                     'city' => $reverseOrderData['return_city'] ?? '',
    //                     'state' => $reverseOrderData['return_state'] ?? '',
    //                     'country' => 'India',
    //                     'pin' => $reverseOrderData['return_pincode'] ?? '',
    //                     'phone' => $reverseOrderData['return_phone_no'] ?? '',
    //                 ],
    //                 // RETURN/WAREHOUSE ADDRESS: Where Delhivery delivers to (Your warehouse)
    //                 'return_name' => config('services.delhivery.return_name'),
    //                 'return_add' => config('services.delhivery.return_add'),
    //                 'return_city' => config('services.delhivery.return_city'),
    //                 'return_state' => config('services.delhivery.return_state'),
    //                 'return_pin' => config('services.delhivery.return_pin'),
    //                 'return_phone' => config('services.delhivery.return_phone'),
    //                 'products' => $products,
    //             ]
    //         ]
    //     ];

    //     try {
    //         Log::info('Delhivery reverse shipment payload', [
    //             'payload' => $shipmentData
    //         ]);

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . $this->apiKey,
    //         ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
    //             'format' => 'json',
    //             'data' => json_encode($shipmentData)
    //         ]);

    //         $result = $response->json();

    //         Log::info('Delhivery reverse shipment response', [
    //             'status' => $response->status(),
    //             'result' => $result
    //         ]);

    //         if ($response->successful()) {
    //             if (isset($result['packages']) && is_array($result['packages']) && count($result['packages']) > 0) {
    //                 $package = $result['packages'][0];

    //                 if (isset($package['status']) && $package['status'] === 'Success') {
    //                     return [
    //                         'success' => true,
    //                         'waybill' => $package['waybill'] ?? null,
    //                         'shipment_id' => $package['shipment_id'] ?? null,
    //                         'message' => 'Reverse pickup created successfully'
    //                     ];
    //                 }

    //                 $errorMessage = 'Reverse shipment creation failed';
    //                 if (isset($package['remarks']) && is_array($package['remarks'])) {
    //                     foreach ($package['remarks'] as $remark) {
    //                         if (isset($remark['message'])) {
    //                             $errorMessage = $remark['message'];
    //                             break;
    //                         }
    //                     }
    //                 }

    //                 return [
    //                     'success' => false,
    //                     'message' => $errorMessage,
    //                     'waybill' => null
    //                 ];
    //             }

    //             if (isset($result['success']) && $result['success'] === true) {
    //                 return [
    //                     'success' => true,
    //                     'waybill' => $result['waybill'] ?? null,
    //                     'shipment_id' => $result['shipment_id'] ?? null,
    //                     'message' => 'Reverse pickup created successfully'
    //                 ];
    //             }
    //         }

    //         $errorMessage = 'Failed to create reverse shipment';
    //         if (isset($result['rmk'])) {
    //             $errorMessage = $result['rmk'];
    //         } elseif (isset($result['message'])) {
    //             $errorMessage = $result['message'];
    //         } elseif (isset($result['error'])) {
    //             $errorMessage = is_string($result['error']) ? $result['error'] : 'API Error';
    //         }

    //         Log::error('Delhivery reverse shipment creation failed', [
    //             'response' => $response->body(),
    //             'payload' => $shipmentData
    //         ]);

    //         return [
    //             'success' => false,
    //             'message' => $errorMessage,
    //             'waybill' => null
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Delhivery reverse shipment creation exception: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //             'waybill' => null
    //         ];
    //     }
    // }

public function createReverseShipment(array $reverseOrderData, $orderItems)
{
    $products = [];
    foreach ($orderItems as $item) {
        $products[] = [
            'name' => $item->sku_name ?? $item->name ?? 'Product',
            'sku' => (string) ($item->sku_code ?? $item->variant_id ?? $item->product_id ?? 'SKU_' . uniqid()),
            'quantity' => (int) ($item->quantity ?? 1),
            'price' => (float) ($item->price ?? 0),
        ];
    }

    // Get warehouse/return address from config using the correct keys
    $warehouseAddress = [
        'name' => config('services.delhivery.return_name', 'Aiman Royale'),
        'add' => config('services.delhivery.return_add', '0, ISLAMPUR, KADAMBAGACHI, BARASAT, North 24 Parganas, West Bengal, 700125'),
        'city' => config('services.delhivery.return_city', 'Barasat'),
        'state' => config('services.delhivery.return_state', 'West Bengal'),
        'country' => config('services.delhivery.return_country', 'India'),
        'pin' => config('services.delhivery.return_pincode', '700125'),
        'phone' => config('services.delhivery.return_phone', '8240525716'),
    ];

    // Get customer address (this is where the package will be picked up from)
    $customerAddress = [
        'name' => $reverseOrderData['return_contact_name'] ?? 'Customer',
        'add' => trim(($reverseOrderData['return_address_1'] ?? '') . ' ' . ($reverseOrderData['return_address_2'] ?? '')),
        'city' => $reverseOrderData['return_city'] ?? '',
        'state' => $reverseOrderData['return_state'] ?? '',
        'country' => 'India',
        'pin' => $reverseOrderData['return_pincode'] ?? '',
        'phone' => $reverseOrderData['return_phone_no'] ?? '',
    ];

    // Build the correct payload for reverse flow
    // $shipmentData = [
    //     // This is where the pickup will happen (customer's address)
    //     'pickup_location' => [
    //         'name' => $customerAddress['name'],
    //         'add' => $customerAddress['add'],
    //         'city' => $customerAddress['city'],
    //         'country' => $customerAddress['country'],
    //         'phone' => $customerAddress['phone'],
    //         'pin' => $customerAddress['pin']
    //     ],
    //     'shipments' => [
    //         [
    //             // These are the customer details (same as pickup location for reverse)
    //             'name' => $customerAddress['name'],
    //             'add' => $customerAddress['add'],
    //             'city' => $customerAddress['city'],
    //             'state' => $customerAddress['state'],
    //             'country' => $customerAddress['country'],
    //             'pin' => $customerAddress['pin'],
    //             'phone' => $customerAddress['phone'],
                
    //             // Order details
    //             'order' => (string) ($reverseOrderData['reverse_order_number'] ?? $reverseOrderData['order_id'] ?? ''),
    //             'order_date' => date('Y-m-d H:i:s'),
                
    //             // CRITICAL: Must be 'Pickup' for reverse flow
    //             'payment_mode' => 'Pickup',
                
    //             // Shipping details
    //             'shipping_mode' => config('services.delhivery.shipping_mode', 'Express'),
    //             'weight' => isset($reverseOrderData['weight']) ? $reverseOrderData['weight'] . ' gm' : '500.0 gm',
    //             'quantity' => (int) ($reverseOrderData['total_quantity'] ?? 1),
    //             'products_desc' => $reverseOrderData['products_desc'] ?? 'Return products',
                
    //             // Financial details
    //             'total_amount' => (float) ($reverseOrderData['total_amount'] ?? 0),
    //             'cod_amount' => 0, // Always 0 for reverse pickup
                
    //             // DESTINATION: This is where the package will be delivered (your warehouse)
    //             // All these are MANDATORY for reverse flow
    //             'return_name' => 'Aiman Royale',
    //             'return_add' => $warehouseAddress['add'],
    //             'return_city' => $warehouseAddress['city'],
    //             'return_state' => $warehouseAddress['state'],
    //             'return_country' => $warehouseAddress['country'],
    //             'return_pin' => $warehouseAddress['pin'],
    //             'return_phone' => $warehouseAddress['phone'],
                
    //             // GST details (if applicable)
    //             'seller_gst_tin' => config('services.delhivery.seller_gst_tin', null),
    //             'consignee_gst_tin' => $reverseOrderData['consignee_gst_tin'] ?? null,
                
    //             // Optional fields
    //             'category_of_goods' => $reverseOrderData['category_of_goods'] ?? 'General',
    //             'invoice_reference' => $reverseOrderData['invoice_reference'] ?? '1',
    //             'extra_parameters' => [
    //                 'return_reason' => $reverseOrderData['return_reason'] ?? 'Customer Return'
    //             ]
    //         ]
    //     ]
    // ];

        $shipmentData = [
        // Root level pickup_location - just the warehouse name
        'pickup_location' => [
            'name' => 'Aiman Royale' // Your registered warehouse name
        ],
        'shipments' => [
            [
                // Customer details (where pickup happens)
                'name' => $customerAddress['name'],
                'add' => $customerAddress['add'],
                'city' => $customerAddress['city'],
                'state' => $customerAddress['state'],
                'country' => $customerAddress['country'],
                'pin' => $customerAddress['pin'],
                'phone' => $customerAddress['phone'],
                
                // Order details
                'order' => (string) ($reverseOrderData['reverse_order_number'] ?? $reverseOrderData['order_id'] ?? ''),
                'order_date' => date('Y-m-d H:i:s'),
                
                // CRITICAL: Must be 'Pickup' for reverse flow
                'payment_mode' => 'Pickup',
                
                // Shipping details
                'shipping_mode' => config('services.delhivery.shipping_mode', 'Express'),
                'weight' => isset($reverseOrderData['weight']) ? $reverseOrderData['weight'] : 500,
                'quantity' => (int) ($reverseOrderData['total_quantity'] ?? 1),
                'products_desc' => $reverseOrderData['products_desc'] ?? 'Return products',
                
                // Financial details
                'total_amount' => (float) ($reverseOrderData['total_amount'] ?? 0),
                'cod_amount' => 0,
                
                // DESTINATION: Where the package will be delivered (your warehouse)
                'return_name' => 'Aiman Royale', // Your registered warehouse name
                'return_add' => $warehouseAddress['add'],
                'return_pin' => $warehouseAddress['pin'],
                'return_phone' => $warehouseAddress['phone'],
                
                // Note: In the payload example, these fields are NOT in the shipment
                // They are only in the root pickup_location
                
                // GST details (if applicable)
                'seller_gst_tin' => config('services.delhivery.seller_gst_tin', null),
                'consignee_gst_tin' => $reverseOrderData['consignee_gst_tin'] ?? null,
                
                // Optional fields
                'category_of_goods' => $reverseOrderData['category_of_goods'] ?? 'General',
                'invoice_reference' => $reverseOrderData['invoice_reference'] ?? '1',
                'extra_parameters' => [
                    'return_reason' => $reverseOrderData['return_reason'] ?? 'Customer Return'
                ]
            ]
        ]
    ];



    // Debugging line to inspect the payload
    try {
        Log::info('Delhivery reverse shipment payload', [
            'payload' => $shipmentData
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->apiKey,
        ])->asForm()->post($this->baseUrl . '/api/cmu/create.json', [
            'format' => 'json',
            'data' => json_encode($shipmentData)
        ]);

        $result = $response->json();

        Log::info('Delhivery reverse shipment response', [
            'status' => $response->status(),
            'result' => $result
        ]);

        if ($response->successful()) {
            if (isset($result['packages']) && is_array($result['packages']) && count($result['packages']) > 0) {
                $package = $result['packages'][0];

                if (isset($package['status']) && $package['status'] === 'Success') {
                    return [
                        'success' => true,
                        'waybill' => $package['waybill'] ?? null,
                        'shipment_id' => $package['shipment_id'] ?? null,
                        'message' => 'Reverse pickup created successfully'
                    ];
                }

                $errorMessage = 'Reverse shipment creation failed';
                if (isset($package['remarks']) && is_array($package['remarks'])) {
                    foreach ($package['remarks'] as $remark) {
                        if (isset($remark['message'])) {
                            $errorMessage = $remark['message'];
                            break;
                        }
                    }
                }

                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'waybill' => null
                ];
            }

            if (isset($result['success']) && $result['success'] === true) {
                return [
                    'success' => true,
                    'waybill' => $result['waybill'] ?? null,
                    'shipment_id' => $result['shipment_id'] ?? null,
                    'message' => 'Reverse pickup created successfully'
                ];
            }
        }

        $errorMessage = 'Failed to create reverse shipment';
        if (isset($result['rmk'])) {
            $errorMessage = $result['rmk'];
        } elseif (isset($result['message'])) {
            $errorMessage = $result['message'];
        } elseif (isset($result['error'])) {
            $errorMessage = is_string($result['error']) ? $result['error'] : 'API Error';
        }

        Log::error('Delhivery reverse shipment creation failed', [
            'response' => $response->body(),
            'payload' => $shipmentData
        ]);

        return [
            'success' => false,
            'message' => $errorMessage,
            'waybill' => null
        ];
    } catch (\Exception $e) {
        Log::error('Delhivery reverse shipment creation exception: ' . $e->getMessage(), [
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


    // In app/Services/DelhiveryService.php

    // In app/Services/DelhiveryService.php

    public function getShippingCost($originPincode, $destinationPincode, $items, $paymentMethod = 'prepaid')
    {
        try {
            // Calculate total chargeable weight
            $totalWeight = $this->calculateChargeableWeight($items);

            // Determine mode (Express/Surface based on payment method)
            $mode = $paymentMethod === 'cod' ? 'S' : 'E'; // S = Surface, E = Express

            // Determine payment type
            $pt = $paymentMethod === 'cod' ? 'COD' : 'Pre-paid';

            // Prepare API request - Using the correct endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get('https://staging-express.delhivery.com/api/kinko/v1/invoice/charges/.json', [
                'md' => $mode,              // Mode: E (Express) or S (Surface)
                'ss' => 'Delivered',        // Shipment status
                'd_pin' => $destinationPincode,
                'o_pin' => $originPincode,
                'cgm' => $totalWeight,      // Chargeable weight in grams
                'pt' => $pt                 // Payment type: Pre-paid or COD
            ]);

            Log::info('Delhivery Shipping Cost Request', [
                'url' => 'https://staging-express.delhivery.com/api/kinko/v1/invoice/charges/.json',
                'params' => [
                    'md' => $mode,
                    'ss' => 'Delivered',
                    'd_pin' => $destinationPincode,
                    'o_pin' => $originPincode,
                    'cgm' => $totalWeight,
                    'pt' => $pt
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('Delhivery Shipping Cost Response', [
                    'status' => $response->status(),
                    'data' => $data
                ]);

                // Parse the response - format may vary
                if (isset($data['total_amount'])) {
                    return [
                        'success' => true,
                        'shipping_charge' => (float) $data['total_amount'],
                        'data' => $data
                    ];
                }

                // Alternative response format
                if (isset($data['data']['total_amount'])) {
                    return [
                        'success' => true,
                        'shipping_charge' => (float) $data['data']['total_amount'],
                        'data' => $data
                    ];
                }

                // Sometimes the response might have a different structure
                if (isset($data['charges'])) {
                    return [
                        'success' => true,
                        'shipping_charge' => (float) $data['charges'],
                        'data' => $data
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Could not parse shipping charges from response',
                    'data' => $data
                ];
            }

            Log::error('Delhivery Shipping Cost Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to get shipping charges: ' . $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('Delhivery Shipping Cost Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function calculateChargeableWeight($items)
    {
        $deadWeight = 0;
        $volumetricWeight = 0;

        foreach ($items as $item) {
            // Get product/variant dimensions
            $product = \DB::table('product_variants')
                ->where('id', $item->variant_id)
                ->first();

            // Dead weight in grams (convert kg to grams)
            // Use default 0.5kg if weight is missing
            $itemWeight = $product->weight ?? 0.5;
            $itemDeadWeight = $itemWeight * 1000; // Convert to grams
            $deadWeight += $itemDeadWeight * $item->quantity;

            // Volumetric weight - skip if dimensions missing
            if (isset($product->length) && isset($product->breadth) && isset($product->height)) {
                $length = (float) $product->length;
                $breadth = (float) $product->breadth;
                $height = (float) $product->height;

                // Only calculate if all dimensions are > 0
                if ($length > 0 && $breadth > 0 && $height > 0) {
                    $dimensionWeight = ($length * $breadth * $height) / 5000;
                    $volumetricWeight += $dimensionWeight * 1000 * $item->quantity; // Convert to grams
                }
            }
        }

        // If volumetric weight is 0 (no dimensions), use dead weight only
        $chargeableWeight = $volumetricWeight > 0
            ? max($deadWeight, $volumetricWeight)
            : $deadWeight;

        // Ensure minimum weight is 10g (as per Delhivery API)
        return max(10, $chargeableWeight);
    }
}
