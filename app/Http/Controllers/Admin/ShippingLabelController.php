<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingLabelController extends Controller
{
    public function index()
    {
        return view('Admin.shipping-label.index');
    }

    public function generateLabel(Request $request)
    {
        try {
            $request->validate([
                'waybill' => 'required|string',
                'format' => 'sometimes|in:pdf,json'
            ]);

            $waybill = $request->waybill;
            $format = $request->format ?? 'pdf';

            $apiToken = config('delhivery.api_token');
            $apiUrl = config('delhivery.packing_slip_api_url', 'https://staging-express.delhivery.com/api/p/packing_slip');

            // Request PDF directly from Delhivery
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->get($apiUrl, [
                'wbns' => $waybill,
                'pdf' => 'true' // Request PDF directly
            ]);

            Log::info('Delhivery PDF Response', [
                'waybill' => $waybill,
                'status' => $response->status(),
                'content_type' => $response->header('Content-Type')
            ]);

            if ($response->successful()) {
                // Check if response is PDF
                $contentType = $response->header('Content-Type');
                
                if (str_contains($contentType, 'application/pdf')) {
                    // It's a PDF - return it
                    if ($format === 'pdf') {
                        return response($response->body())
                            ->header('Content-Type', 'application/pdf')
                            ->header('Content-Disposition', 'inline; filename="shipping-label-' . $waybill . '.pdf"');
                    } else {
                        // For JSON format, return the PDF as base64
                        return response()->json([
                            'success' => true,
                            'waybill' => $waybill,
                            'pdf_base64' => base64_encode($response->body()),
                            'content_type' => $contentType
                        ]);
                    }
                } else {
                    // Not a PDF - try to parse as JSON
                    $data = $response->json();
                    
                    // Try to extract PDF link if available
                    $pdfLink = null;
                    if (isset($data['packages'][0]['pdf_download_link'])) {
                        $pdfLink = $data['packages'][0]['pdf_download_link'];
                    }
                    
                    if ($pdfLink) {
                        if ($format === 'pdf') {
                            return redirect()->away($pdfLink);
                        } else {
                            return response()->json([
                                'success' => true,
                                'data' => $data,
                                'waybill' => $waybill,
                                'pdf_link' => $pdfLink
                            ]);
                        }
                    }
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Unexpected response format',
                        'debug' => $data
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate shipping label',
                    'status_code' => $response->status()
                ], $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Shipping label generation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Alternative: Get PDF via direct download
    public function downloadPdf(Request $request)
    {
        try {
            $request->validate([
                'waybill' => 'required|string'
            ]);

            $waybill = $request->waybill;
            
            $apiToken = config('delhivery.api_token');
            $apiUrl = config('delhivery.packing_slip_api_url');

            // Request PDF directly
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->get($apiUrl, [
                'wbns' => $waybill,
                'pdf' => 'true'
            ]);

            if ($response->successful()) {
                $contentType = $response->header('Content-Type');
                
                if (str_contains($contentType, 'application/pdf')) {
                    return response($response->body())
                        ->header('Content-Type', 'application/pdf')
                        ->header('Content-Disposition', 'attachment; filename="shipping-label-' . $waybill . '.pdf"')
                        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
                }
                
                // Try to parse as JSON
                $data = $response->json();
                if (isset($data['packages'][0]['pdf_download_link'])) {
                    $pdfLink = $data['packages'][0]['pdf_download_link'];
                    return redirect()->away($pdfLink);
                }
                
                return back()->with('error', 'Could not retrieve PDF for waybill: ' . $waybill);
            }

            return back()->with('error', 'Failed to get PDF from Delhivery');

        } catch (\Exception $e) {
            Log::error('PDF download error: ' . $e->getMessage());
            return back()->with('error', 'Error downloading PDF: ' . $e->getMessage());
        }
    }

    public function generateBulkLabels(Request $request)
    {
        try {
            $request->validate([
                'waybills' => 'required|string',
                'format' => 'sometimes|in:pdf,json'
            ]);

            $waybills = $request->waybills;
            $format = $request->format ?? 'pdf';

            $waybillArray = array_map('trim', explode(',', $waybills));
            $waybillString = implode(',', $waybillArray);

            $apiToken = config('delhivery.api_token');
            $apiUrl = config('delhivery.packing_slip_api_url');

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->get($apiUrl, [
                'wbns' => $waybillString,
                'pdf' => 'true'
            ]);

            if ($response->successful()) {
                $contentType = $response->header('Content-Type');
                
                if (str_contains($contentType, 'application/pdf')) {
                    if ($format === 'pdf') {
                        return response($response->body())
                            ->header('Content-Type', 'application/pdf')
                            ->header('Content-Disposition', 'inline; filename="shipping-labels-bulk.pdf"');
                    } else {
                        return response()->json([
                            'success' => true,
                            'waybills' => $waybillArray,
                            'pdf_base64' => base64_encode($response->body())
                        ]);
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Expected PDF response',
                    'content_type' => $contentType
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate bulk labels'
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Bulk label generation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function previewLabel(Request $request)
    {
        try {
            $request->validate([
                'waybill' => 'required|string'
            ]);

            $waybill = $request->waybill;
            
            $apiToken = config('delhivery.api_token');
            $apiUrl = config('delhivery.packing_slip_api_url');

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->get($apiUrl, [
                'wbns' => $waybill,
                'pdf' => 'false'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return view('Admin.shipping-label.preview', [
                    'waybill' => $waybill,
                    'data' => $data,
                    'pdf_link' => null
                ]);
            }

            return back()->with('error', 'Failed to fetch shipping label data');

        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Debug endpoint
    public function debugApi(Request $request)
    {
        try {
            $waybill = $request->waybill ?? '85529910000416';
            
            $apiToken = config('delhivery.api_token');
            $apiUrl = config('delhivery.packing_slip_api_url');

            // Test with pdf=true
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->get($apiUrl, [
                'wbns' => $waybill,
                'pdf' => 'true'
            ]);

            return response()->json([
                'status' => $response->status(),
                'success' => $response->successful(),
                'content_type' => $response->header('Content-Type'),
                'is_pdf' => str_contains($response->header('Content-Type'), 'application/pdf'),
                'body_length' => strlen($response->body()),
                'first_100_chars' => substr($response->body(), 0, 100),
                'waybill' => $waybill,
                'api_url' => $apiUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}