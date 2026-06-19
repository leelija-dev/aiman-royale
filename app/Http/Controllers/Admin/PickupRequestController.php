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

        // ✅ CORRECT ENDPOINT FOR PICKUP REQUEST
        $url = config('delhivery.sandbox_url') . '/fm/request/new/';
        
        // ✅ CORRECT PAYLOAD STRUCTURE based on the curl example
        $pickupData = [
            'pickup_time' => now()->format('H:i:s'), // Current time in 24-hour format
            'pickup_date' => now()->format('Y-m-d'), // Current date
            'pickup_location' => config('delhivery.pickup_location'), // Your warehouse name
            'expected_package_count' => count($waybills), // Number of packages
        ];

        // Optional: Add waybill numbers if the API supports it
        // Some versions of the API accept waybills in the payload
        // If not, you might need to add them after pickup is created
        // $pickupData['waybills'] = implode(',', $waybills);

        Log::info('Sending pickup request to Delhivery', [
            'url' => $url,
            'payload' => $pickupData,
            'waybills' => $waybills
        ]);

        // Make the API call with proper authentication
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . config('delhivery.api_token'), // Note: 'Token' not 'Bearer'
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $pickupData);

        Log::info('Delhivery Pickup API Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            
            // Check if pickup was created successfully
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                // Update orders as pickup requested
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
                // API returned error response
                return response()->json([
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Pickup request failed',
                    'data' => $responseData
                ], 400);
            }
        }

        // Handle specific HTTP status codes
        if ($response->status() === 401) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed. Please check your API token.'
            ], 401);
        }

        if ($response->status() === 422) {
            $errors = $response->json();
            $errorMessage = 'Validation error: ';
            if (isset($errors['errors'])) {
                foreach ($errors['errors'] as $field => $messages) {
                    $errorMessage .= $field . ': ' . implode(', ', $messages) . '; ';
                }
            } else {
                $errorMessage .= $response->body();
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create pickup request: ' . $response->body()
        ], $response->status());

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

    }
