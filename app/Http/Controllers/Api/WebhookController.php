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
        // Store complete payload
        Log::info('Delhivery Webhook Received', [
            'payload' => $request->all()
        ]);

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
            $instructions= $shipment['Status']['Instructions'] ?? null;

            Log::info('Shipment Details', [
                'awb'        => $awb,
                'status'     => $status,
                'statusType' => $statusType,
                'location'   => $location
            ]);

            /**
             * Save tracking history
             */
            ShipmentTracking::create([
                'awb'          => $awb,
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
            $order = Order::where('awb', $awb)->first();

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