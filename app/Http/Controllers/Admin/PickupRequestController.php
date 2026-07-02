<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;  // ← ADD THIS LINE
use Illuminate\Support\Facades\Log;

class PickupRequestController extends Controller
{

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

    public function requestedPickup()
    {
        $orders = Order::where('pick_up_request_added', true)
            ->whereNotIn('order_status', ['cancelled', 'delivered'])
            ->whereNotNull('waybill_number')
            ->paginate(10);

        return view('Admin.pick-up-request.requested-pickup', compact('orders'));

    }


    public function createPickupRequest(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'waybills' => 'required|array|min:1',
                'waybills.*' => 'string',
                'order_ids' => 'required|array|min:1',
                'order_ids.*' => 'integer|exists:orders,id',
                'pickup_date' => 'required|date',
                'pickup_time' => 'required|date_format:H:i:s',
            ]);

            $waybills = $request->waybills;
            $orderIds = $request->order_ids;

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

            // Log order details for debugging
            Log::info('Preparing pickup request', [
                'order_count' => $orders->count(),
                'first_order' => $firstOrder->toArray(),
                'pickup_datetime' => $request->pickup_date . ' ' . $request->pickup_time
            ]);

            $url = config('delhivery.sandbox_url') . '/fm/request/new/';

            // Use the date and time from the request
            $pickupDateTime = \Carbon\Carbon::parse($request->pickup_date . ' ' . $request->pickup_time);
            $pickupDate = $pickupDateTime->format('Y-m-d');
            $pickupTime = $pickupDateTime->format('H:i:s');

            // Prepare pickup data
            $pickupData = [
                'pickup_location' => config('delhivery.pickup_location', 'c3a7c4-RJFASHIONS-do'),
                'pickup_date' => $pickupDate,
                'pickup_time' => $pickupTime,
                'expected_package_count' => count($waybills),
                'client_name' => $firstOrder->name ?? 'Customer',
                'client_address' => $firstOrder->address_1 ?? 'Address',
                'client_city' => $firstOrder->city ?? 'hooghly',
                'client_pincode' => $firstOrder->pincode ?? '712134',
                'client_phone' => $firstOrder->phone_no ?? '6295351230',
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

            $responseBody = $response->body();

            Log::info('Delhivery Pickup API Response', [
                'status' => $response->status(),
                'body' => $responseBody,
                'headers' => $response->headers()
            ]);

            // Handle successful response
            if ($response->successful()) {
                $responseData = $response->json();

                // Check if pickup was created successfully
                if (isset($responseData['pickup_id'])) {
                    // Get the actual pickup time from Delhivery's response
                    $actualPickupTime = $responseData['pickup_time'] ?? $pickupTime;
                    $actualPickupDate = $responseData['pickup_date'] ?? $pickupDate;

                    // Check if Delhivery changed the pickup time
                    if ($actualPickupTime != $pickupTime || $actualPickupDate != $pickupDate) {
                        Log::warning('Pickup time adjusted by Delhivery', [
                            'requested_time' => $pickupTime,
                            'actual_time' => $actualPickupTime,
                            'requested_date' => $pickupDate,
                            'actual_date' => $actualPickupDate,
                            'pickup_id' => $responseData['pickup_id']
                        ]);
                    }

                    // UPDATE ORDERS WITH PICKUP DETAILS
                    $updated = Order::whereIn('id', $orderIds)
                        ->update([
                            'pick_up_request_added' => 1, // Changed to 1 (integer)
                            'pickup_id' => $responseData['pickup_id'],
                            'pickup_scheduled_date' => $actualPickupDate,
                            'pickup_scheduled_time' => $actualPickupTime
                        ]);

                    // Log the update result
                    Log::info('Orders updated with pickup details', [
                        'updated_count' => $updated,
                        'order_ids' => $orderIds,
                        'pickup_id' => $responseData['pickup_id']
                    ]);

                    // Verify the update
                    $updatedOrders = Order::whereIn('id', $orderIds)->get();
                    Log::info('Verification of updated orders', [
                        'orders' => $updatedOrders->toArray()
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Pickup request created successfully',
                        'count' => count($waybills),
                        'pickup_id' => $responseData['pickup_id'],
                        'pickup_location_name' => $responseData['pickup_location_name'] ?? null,
                        'incoming_center_name' => $responseData['incoming_center_name'] ?? null,
                        'requested_pickup_time' => $pickupTime,
                        'actual_pickup_time' => $actualPickupTime,
                        'requested_pickup_date' => $pickupDate,
                        'actual_pickup_date' => $actualPickupDate,
                        'data' => $responseData
                    ]);
                }
                // Handle success response with 'status' field
                elseif (isset($responseData['status']) && $responseData['status'] === 'success') {
                    Order::whereIn('id', $orderIds)
                        ->update([
                            'pick_up_request_added' => 1,
                            'pickup_id' => $responseData['pickup_id'] ?? null,
                        ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Pickup request created successfully',
                        'count' => count($waybills),
                        'pickup_id' => $responseData['pickup_id'] ?? null,
                        'data' => $responseData
                    ]);
                }
                // Handle unexpected success response
                else {
                    Log::warning('Unexpected success response format', [
                        'response' => $responseData
                    ]);

                    // Still consider it successful if status is 201 (Created)
                    Order::whereIn('id', $orderIds)
                        ->update([
                            'pick_up_request_added' => 1,
                            'pickup_id' => $responseData['pickup_id'] ?? null,
                        ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Pickup request created (unexpected response format)',
                        'count' => count($waybills),
                        'data' => $responseData
                    ]);
                }
            }

            // Handle error responses
            $status = $response->status();
            $errorMessage = $this->handleErrorResponse($response, $status);

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'status_code' => $status,
                'response_body' => $response->body()
            ], $status);
        } catch (\Exception $e) {
            Log::error('Pickup Request Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating pickup request: ' . $e->getMessage()
            ], 500);
        }
    }

    // Add this helper method to your controller
    private function handleErrorResponse($response, $status)
    {
        $errorMessage = 'Pickup request failed';
        $responseBody = $response->body();

        try {
            $errorData = json_decode($responseBody, true);

            if ($errorData) {
                if (isset($errorData['message'])) {
                    $errorMessage = $errorData['message'];
                } elseif (isset($errorData['error'])) {
                    $errorMessage = $errorData['error'];
                } elseif (isset($errorData['errors'])) {
                    if (is_array($errorData['errors'])) {
                        $errorMessage = implode(', ', $errorData['errors']);
                    } else {
                        $errorMessage = $errorData['errors'];
                    }
                }

                if (isset($errorData['status'])) {
                    $errorMessage .= ' (Status: ' . $errorData['status'] . ')';
                }
            } else {
                $errorMessage = $responseBody ?: 'Unknown error occurred';
            }
        } catch (\Exception $e) {
            Log::error('Error parsing Delhivery error response', [
                'error' => $e->getMessage(),
                'response_body' => $responseBody
            ]);
        }

        switch ($status) {
            case 400:
                $errorMessage = 'Bad Request: ' . $errorMessage;
                break;
            case 401:
                $errorMessage = 'Authentication failed. Please check API token.';
                break;
            case 403:
                $errorMessage = 'Access forbidden. Please check your permissions.';
                break;
            case 404:
                $errorMessage = 'Endpoint not found. Please check the URL.';
                break;
            case 422:
                $errorMessage = 'Validation error: ' . $errorMessage;
                break;
            case 429:
                $errorMessage = 'Rate limit exceeded. Please try again later.';
                break;
            case 500:
                $errorMessage = 'Delhivery server error. Please try again later.';
                break;
        }

        return $errorMessage;
    }

    
}
