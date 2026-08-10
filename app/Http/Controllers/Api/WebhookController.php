<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\ShipmentTracking;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Delhivery Webhook Received', [
            'payload' => $request->all()
        ]);

        $token = $request->header('Authorization');
        // print_r($token); // Debugging line to check the token value

        // Remove "Bearer " prefix if present
        $token = str_replace('Bearer ', '', $token);
        // print_r($token);
        $expectedToken = env('DELHIVERY_API_TOKEN');
        // print_r($expectedToken);
        if (empty($token) || $token !== $expectedToken) {
            Log::warning('Invalid API Token', [
                'provided' => $token,
                'expected' => $expectedToken
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        try {

            $shipment = $request->input('Shipment');

            if (!$shipment) {
                Log::warning('Shipment object missing');

                return response()->json([
                    'message' => 'Invalid Payload'
                ], 400);
            }

            $awb         = $shipment['AWB'] ?? null;

            $referenceNo = $shipment['ReferenceNo'] ?? null;

            $status      = $shipment['Status']['Status'] ?? null;
            $statusType  = $shipment['Status']['StatusType'] ?? null;
            $statusDate  = $shipment['Status']['StatusDateTime'] ?? null;
            $location    = $shipment['Status']['StatusLocation'] ?? null;
            $instructions = $shipment['Status']['Instructions'] ?? null;

            Log::info('Shipment Details', [
                'awb'        => $awb,
                'status'     => $status,
                'statusType' => $statusType,
                'location'   => $location
            ]);
            $order = Order::where('waybill_number', $awb)->first();
            
            /**
             * Save tracking history
             */
            ShipmentTracking::updateOrCreate([
                ['awb' => $awb],
                'awb'          => $awb,
                'order_id'     => $order ? $order->id : null,
                'reference_no' => $referenceNo,
                'status'       => $status,
                'status_type'  => $statusType,
                'location'     => $location,
                'remarks'      => $instructions,
                'status_date'  => $statusDate,
                'payload'      => json_encode($request->all()),
            ]);

            /**
             * Update order
             */

            // Debugging line to check the order object
            if ($order) {

                $order->shipment_status = $status;
                $order->tracking_status = $statusType;
                $order->tracking_location = $location;
                $order->save();

                Log::info("Order Updated", [
                    'order_id' => $order->id,
                    'status' => $status
                ]);
            } else {
                Log::warning("Order not found for AWB {$awb}");
            }

            return response()->json([
                'success' => true
            ], 200);
        } catch (\Throwable $e) {

            Log::error('Webhook Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            // Always return 200 so Delhivery doesn't keep retrying
            return response()->json([
                'success' => true
            ], 200);
        }
    }
}
