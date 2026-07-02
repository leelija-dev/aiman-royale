<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DelhiveryController extends Controller
{
    /**
     * Generate packing slip for a waybill
     */
    public function generatePackingSlip($waybill, Request $request)
    {
        try {
            // Check if order exists
            $order = Order::where('waybill_number', $waybill)->first();
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found with this waybill number'
                ], 404);
            }

            // Get PDF parameter (default: false for JSON)
            $pdf = $request->input('pdf', false);
            
            // Prepare the API URL
            $url = config('delhivery.sandbox_url') . '/api/p/packing_slip';
            
            // Prepare query parameters
            $queryParams = [
                'wbns' => $waybill,
                'pdf' => $pdf ? 'true' : 'false'
            ];

            Log::info('Generating Delhivery packing slip', [
                'url' => $url,
                'waybill' => $waybill,
                'params' => $queryParams
            ]);

            // Make the API call
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($url, $queryParams);

            Log::info('Delhivery Packing Slip Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            // Handle the response
            if ($response->successful()) {
                $responseData = $response->json();
                
                // If pdf=false, return JSON data
                if (!$pdf) {
                    return response()->json([
                        'success' => true,
                        'data' => $responseData,
                        'message' => 'Packing slip data retrieved successfully'
                    ]);
                }
                
                // If pdf=true, return the PDF
                return $response;
            }

            // Handle error response
            $errorMessage = $this->handleErrorResponse($response);
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'status_code' => $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Packing slip generation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk generate packing slips for multiple waybills
     */
    public function generateBulkPackingSlips(Request $request)
    {
        try {
            $request->validate([
                'waybills' => 'required|array|min:1',
                'waybills.*' => 'string'
            ]);

            $waybills = $request->waybills;
            $results = [];

            foreach ($waybills as $waybill) {
                $result = $this->generatePackingSlip($waybill, $request);
                $results[] = [
                    'waybill' => $waybill,
                    'success' => $result->getData()->success ?? false,
                    'data' => $result->getData()->data ?? null
                ];
            }

            return response()->json([
                'success' => true,
                'results' => $results,
                'total' => count($results)
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk packing slip generation error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error generating bulk packing slips: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download packing slip as PDF
     */
    public function downloadPackingSlip($waybill)
    {
        try {
            $order = Order::where('waybill_number', $waybill)->first();
            
            if (!$order) {
                return back()->with('error', 'Order not found');
            }

            // Get PDF
            $url = config('delhivery.sandbox_url') . '/api/p/packing_slip';
            
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($url, [
                'wbns' => $waybill,
                'pdf' => 'true'
            ]);

            if ($response->successful()) {
                // Get the PDF content
                $pdfContent = $response->body();
                
                // Return as download
                return response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="packing-slip-' . $waybill . '.pdf"',
                ]);
            }

            return back()->with('error', 'Failed to download packing slip');

        } catch (\Exception $e) {
            Log::error('Packing slip download error', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error downloading packing slip: ' . $e->getMessage());
        }
    }

    /**
     * Handle error response from Delhivery API
     */
    private function handleErrorResponse($response)
    {
        $errorMessage = 'Failed to generate packing slip';
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
            }
        } catch (\Exception $e) {
            Log::error('Error parsing Delhivery error response', [
                'error' => $e->getMessage(),
                'response_body' => $responseBody
            ]);
        }

        return $errorMessage;
    }

    /**
     * View packing slip in browser (for admin panel)
     */
    public function viewPackingSlip($waybill)
    {
        try {
            $order = Order::where('waybill_number', $waybill)->first();
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Get the packing slip data
            $url = config('delhivery.sandbox_url') . '/api/p/packing_slip';
            
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($url, [
                'wbns' => $waybill,
                'pdf' => 'false' // Get JSON data
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return view('admin.delhivery.packing-slip-view', [
                    'order' => $order,
                    'packing_slip' => $data
                ]);
            }

            return back()->with('error', 'Failed to retrieve packing slip');

        } catch (\Exception $e) {
            Log::error('View packing slip error', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error viewing packing slip');
        }
    }

    /**
     * Print packing slip
     */
    public function printPackingSlip($waybill)
    {
        try {
            $order = Order::where('waybill_number', $waybill)->first();
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Get the packing slip data
            $url = config('delhivery.sandbox_url') . '/api/p/packing_slip';
            
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('delhivery.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($url, [
                'wbns' => $waybill,
                'pdf' => 'false'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return view('admin.delhivery.print-packing-slip', [
                    'order' => $order,
                    'packing_slip' => $data
                ]);
            }

            return back()->with('error', 'Failed to retrieve packing slip');

        } catch (\Exception $e) {
            Log::error('Print packing slip error', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Error printing packing slip');
        }
    }
}