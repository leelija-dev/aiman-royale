<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;  // ← ADD THIS LINE
use Illuminate\Support\Facades\Log;

class PickupRequestController extends Controller
{
    //
    public function index()
    {
        // $orders = Order::where('pick_up_request_added', false)
        //     ->where('order_status', '!=', 'cancelled')
        //     ->where('order_status', '!=', 'delivered')
        //     ->whereNotNull('waybill_number') // Custom scope to filter orders with non-null waybill_number
        //     ->paginate(10);

        // return view('Admin.pick-up-request.index', compact('orders'));

        $query = Order::where('pick_up_request_added', false)
            ->whereNotIn('order_status', ['cancelled', 'delivered'])
            ->whereNotNull('waybill_number');

        // Search functionality
        // if ($request->has('search') && !empty($request->search)) {
        //     $search = $request->search;
        //     $query->where(function($q) use ($search) {
        //         $q->where('waybill_number', 'LIKE', "%{$search}%")
        //           ->orWhere('order_id', 'LIKE', "%{$search}%");
        //     });
        // }

        $orders = $query->paginate(10);

        return view('Admin.pick-up-request.index', compact('orders'));
    }


    // public function createPickupRequest(Request $request)
    // {
    //     try {
    //         $waybills = $request->waybills;
    //         $orderIds = $request->order_ids;

    //         if (empty($waybills)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'No waybills provided'
    //             ], 400);
    //         }

    //         // ✅ CORRECT ENDPOINT FOR PICKUP REQUEST
    //         $url = config('delhivery.sandbox_url') . '/fm/request/new/';

    //         // ✅ CORRECT PAYLOAD STRUCTURE based on the curl example
    //         $pickupData = [
    //             'pickup_time' => "11:00:00",//now()->format('H:i:s'), // Current time in 24-hour format
    //             'pickup_date' => "2026-06-29",//now()->format('Y-m-d'), // Current date
    //             'pickup_location' => config('delhivery.pickup_location'), // Your warehouse name
    //             'expected_package_count' => count($waybills), // Number of packages
    //         ];

    //         // Optional: Add waybill numbers if the API supports it
    //         // Some versions of the API accept waybills in the payload
    //         // If not, you might need to add them after pickup is created
    //         // $pickupData['waybills'] = implode(',', $waybills);

    //         Log::info('Sending pickup request to Delhivery', [
    //             'url' => $url,
    //             'payload' => $pickupData,
    //             'waybills' => $waybills
    //         ]);

    //         // Make the API call with proper authentication
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . config('delhivery.api_token'), // Note: 'Token' not 'Bearer'
    //             'Content-Type' => 'application/json',
    //             'Accept' => 'application/json',
    //         ])->post($url, $pickupData);

    //         Log::info('Delhivery Pickup API Response', [
    //             'status' => $response->status(),
    //             'body' => $response->body()
    //         ]);

    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             // Check if pickup was created successfully
    //             if (isset($responseData['status']) && $responseData['status'] === 'success') {
    //                 // Update orders as pickup requested
    //                 Order::whereIn('id', $orderIds)
    //                     ->update(['pick_up_request_added' => true]);

    //                 return response()->json([
    //                     'success' => true,
    //                     'message' => 'Pickup request created successfully',
    //                     'count' => count($waybills),
    //                     'pickup_id' => $responseData['pickup_id'] ?? null,
    //                     'data' => $responseData
    //                 ]);
    //             } else {
    //                 // API returned error response
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => $responseData['message'] ?? 'Pickup request failed',
    //                     'data' => $responseData
    //                 ], 400);
    //             }
    //         }

    //         // Handle specific HTTP status codes
    //         if ($response->status() === 401) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Authentication failed. Please check your API token.'
    //             ], 401);
    //         }

    //         if ($response->status() === 422) {
    //             $errors = $response->json();
    //             $errorMessage = 'Validation error: ';
    //             if (isset($errors['errors'])) {
    //                 foreach ($errors['errors'] as $field => $messages) {
    //                     $errorMessage .= $field . ': ' . implode(', ', $messages) . '; ';
    //                 }
    //             } else {
    //                 $errorMessage .= $response->body();
    //             }

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $errorMessage
    //             ], 422);
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to create pickup request: ' . $response->body()
    //         ], $response->status());

    //     } catch (\Exception $e) {
    //         Log::error('Pickup Request Error', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function createPickupRequest(Request $request)
    // {
    //     try {
    //         $waybills = $request->waybills;
    //         $orderIds = $request->order_ids;

    //         if (empty($waybills)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'No waybills provided'
    //             ], 400);
    //         }

    //         // ✅ FIXED: GET ORDER DETAILS FOR REQUIRED FIELDS
    //         $orders = Order::whereIn('id', $orderIds)->get();

    //         if ($orders->isEmpty()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Orders not found'
    //             ], 404);
    //         }

    //         // Get the first order for client details
    //         $firstOrder = $orders->first();

    //         // ✅ CORRECT ENDPOINT
    //         $url = config('delhivery.sandbox_url') . '/fm/request/new/';

    //         // ✅ CORRECT PAYLOAD WITH ALL REQUIRED FIELDS
    //         $pickupData = [
    //             'pickup_location' => config('delhivery.pickup_location', 'Your Warehouse'),
    //             'pickup_date' => now()->format('Y-m-d'), // ✅ FIXED: Proper date format
    //             'pickup_time' => now()->format('H:i:s'), // ✅ FIXED: Use current time
    //             'expected_package_count' => count($waybills),
    //             // ✅ ADD REQUIRED CLIENT DETAILS
    //             'client_name' => $firstOrder->customer_name ?? 'Customer',
    //             'client_address' => $firstOrder->customer_address ?? 'Address',
    //             'client_city' => $firstOrder->customer_city ?? 'City',
    //             'client_pincode' => $firstOrder->customer_pincode ?? '123456',
    //             'client_phone' => $firstOrder->customer_phone ?? '0000000000',
    //             // ✅ ADD WAYBILLS AS COMMA-SEPARATED STRING
    //             'waybills' => implode(',', $waybills),
    //         ];

    //         Log::info('Sending pickup request to Delhivery', [
    //             'url' => $url,
    //             'payload' => $pickupData,
    //             'waybills' => $waybills
    //         ]);

    //         // ✅ FIXED: USE 'Bearer' OR 'Token' BASED ON YOUR DELHIVERY VERSION
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Token ' . config('delhivery.api_token'),
    //             'Content-Type' => 'application/json',
    //             'Accept' => 'application/json',
    //         ])->post($url, $pickupData);

    //         Log::info('Delhivery Pickup API Response', [
    //             'status' => $response->status(),
    //             'body' => $response->body()
    //         ]);

    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             // ✅ CHECK FOR SUCCESS IN DELHIVERY RESPONSE
    //             if (isset($responseData['status']) && $responseData['status'] === 'success') {
    //                 // Update orders as pickup requested
    //                 Order::whereIn('id', $orderIds)
    //                     ->update(['pick_up_request_added' => true]);

    //                 return response()->json([
    //                     'success' => true,
    //                     'message' => 'Pickup request created successfully',
    //                     'count' => count($waybills),
    //                     'pickup_id' => $responseData['pickup_id'] ?? null,
    //                     'data' => $responseData
    //                 ]);
    //             } else {
    //                 // ✅ BETTER ERROR HANDLING
    //                 $errorMsg = $responseData['message'] ?? 'Pickup request failed';
    //                 if (isset($responseData['errors'])) {
    //                     $errorMsg .= ': ' . json_encode($responseData['errors']);
    //                 }

    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => $errorMsg,
    //                     'data' => $responseData
    //                 ], 400);
    //             }
    //         }

    //         // ✅ HANDLE SPECIFIC HTTP CODES
    //         $status = $response->status();
    //         $errorMessage = $this->handleErrorResponse($response, $status);

    //         return response()->json([
    //             'success' => false,
    //             'message' => $errorMessage,
    //             'status_code' => $status
    //         ], $status);
    //     } catch (\Exception $e) {
    //         Log::error('Pickup Request Error', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function createPickupRequest(Request $request)
    {
        try {
            $waybills = $request->waybills;
            $orderIds = $request->order_ids;

            if (empty($waybills)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No waybills provided'
                ], 400);
            }

            // GET ORDER DETAILS FOR REQUIRED FIELDS
            $orders = Order::whereIn('id', $orderIds)->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orders not found'
                ], 404);
            }

            // Get the first order for client details
            $firstOrder = $orders->first();

            $url = config('delhivery.sandbox_url') . '/fm/request/new/';

            
            $pickupDateTime = now()->addMinutes(30); // Add 30 minutes buffer
            $pickupDate = $pickupDateTime->format('Y-m-d');
            $pickupTime = $pickupDateTime->format('H:i:s');

            $pickupData = [
                'pickup_location' => config('delhivery.pickup_location', 'Your Warehouse'),
                'pickup_date' => $pickupDate, // Date with buffer
                'pickup_time' => $pickupTime, // Time with buffer
                'expected_package_count' => count($waybills),
                'client_name' => $firstOrder->name ?? 'Customer',
                'client_address' => $firstOrder->address ?? 'Address',
                'client_city' => $firstOrder->city ?? 'City',
                'client_pincode' => $firstOrder->pincode ?? '123456',
                'client_phone' => $firstOrder->customer_phone ?? '6295351230',
                'waybills' => implode(',', $waybills),
            ];

            Log::info('Sending pickup request to Delhivery', [
                'url' => $url,
                'payload' => $pickupData,
                'waybills' => $waybills,
                'server_time' => now()->format('Y-m-d H:i:s'),
                'pickup_time_sent' => $pickupDateTime->format('Y-m-d H:i:s')
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, $pickupData);

            Log::info('Delhivery Pickup API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    Order::whereIn('id', $orderIds)
                        ->update(['pick_up_request_added' => true]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Pickup request created successfully',
                        'count' => count($waybills),
                        'pickup_id' => $responseData['pickup_id'] ?? null,
                        'data' => $responseData
                    ]);
                } else {
                    $errorMsg = $responseData['message'] ?? 'Pickup request failed';
                    if (isset($responseData['errors'])) {
                        $errorMsg .= ': ' . json_encode($responseData['errors']);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                        'data' => $responseData
                    ], 400);
                }
            }

            $status = $response->status();
            $errorMessage = $this->handleErrorResponse($response, $status);

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'status_code' => $status
            ], $status);
        } catch (\Exception $e) {
            Log::error('Pickup Request Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ ADD HELPER METHOD FOR ERROR HANDLING
    private function handleErrorResponse($response, $status)
    {
        $body = $response->body();
        $json = json_decode($body, true);

        if ($json && isset($json['message'])) {
            return $json['message'];
        }

        switch ($status) {
            case 400:
                return 'Bad request: ' . $body;
            case 401:
                return 'Authentication failed. Please check your API token.';
            case 422:
                $errors = json_decode($body, true);
                if (isset($errors['errors'])) {
                    $messages = [];
                    foreach ($errors['errors'] as $field => $fieldErrors) {
                        $messages[] = $field . ': ' . implode(', ', $fieldErrors);
                    }
                    return 'Validation errors: ' . implode('; ', $messages);
                }
                return 'Validation error: ' . $body;
            default:
                return 'Failed to create pickup request: ' . $body;
        }
    }
}
