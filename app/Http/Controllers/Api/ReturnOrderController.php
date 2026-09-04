<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReverseOrder;
use App\Services\DelhiveryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReturnOrderController extends Controller
{
    // public function store(Request $request, ?int $orderId = null): JsonResponse
    // {

    //     $validated = $request->validate([
    //         'order_id' => 'nullable|integer|exists:orders,id',
    //         'return_reason' => 'nullable|string|max:500',
    //         'reason' => 'nullable|string|max:500',
    //         'return_address' => 'nullable|array',
    //         'return_address.contact_name' => 'sometimes|required_with:return_address|string|max:100',
    //         'return_address.phone_no' => 'sometimes|required_with:return_address|string|max:20',
    //         'return_address.address_1' => 'sometimes|required_with:return_address|string|max:150',
    //         'return_address.address_2' => 'nullable|string|max:150',
    //         'return_address.city' => 'sometimes|required_with:return_address|string|max:75',
    //         'return_address.state' => 'sometimes|required_with:return_address|string|max:75',
    //         'return_address.pincode' => 'sometimes|required_with:return_address|string|max:10',
    //         'items' => 'nullable|array|min:1',
    //         'items.*.sku_code' => 'required_with:items|string|max:100',
    //         'items.*.sku_name' => 'required_with:items|string|max:191',
    //         'items.*.quantity' => 'required_with:items|integer|min:1',
    //         'items.*.order_product_id' => 'nullable|integer|exists:ordered_products,id',
    //         'items.*.product_id' => 'nullable|integer|exists:products,id',
    //         'items.*.variant_id' => 'nullable|integer|exists:product_variants,id'
    //     ]);

    //     $orderId = $orderId ?? $validated['order_id'] ?? null;

    //     if (!$orderId) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Order ID is required.'
    //         ], 422);
    //     }

    //     $order = Order::with(['orderProducts', 'user'])->find($orderId);

    //     if (!$order) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Order not found.'
    //         ], 404);
    //     }

    //     if ($order->order_status !== 'delivered') {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Return can only be requested for delivered orders.'
    //         ], 422);
    //     }

    //     $returnAddress = $validated['return_address'] ?? [
    //         'contact_name' => optional($order->user)->name ?? 'Customer',
    //         'phone_no' => $order->phone_no ?? '',
    //         'address_1' => $order->address_1 ?? '',
    //         'address_2' => $order->address_2 ?? null,
    //         'city' => $order->city ?? '',
    //         'state' => $order->state ?? '',
    //         'pincode' => $order->pincode ?? '',
    //     ];

    //     if (empty($returnAddress['contact_name']) || empty($returnAddress['phone_no']) || empty($returnAddress['address_1']) || empty($returnAddress['city']) || empty($returnAddress['state']) || empty($returnAddress['pincode'])) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Return pickup address is incomplete. Please provide a valid return address or ensure the order address is complete.'
    //         ], 422);
    //     }

    //     $delhiveryService = new DelhiveryService();
    //     $serviceability = $delhiveryService->isPincodeServiceable($returnAddress['pincode']);
    //     $pickupAvailable = $serviceability['pickup_available'] ?? $serviceability['serviceable'] ?? false;

    //     if (!$pickupAvailable) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $serviceability['message'] ?? 'Reverse pickup is not available for this pincode.',
    //             'data' => $serviceability
    //         ], 422);
    //     }

    //     $existingReverseOrder = ReverseOrder::where('order_id', $order->id)
    //         ->whereIn('status', ['ready_for_pickup', 'in_transit', 'out_for_delivery'])
    //         ->first();

    //     if ($existingReverseOrder) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'A return order is already active for this order.',
    //             'data' => $existingReverseOrder
    //         ], 409);
    //     }

    //     $items = $validated['items'] ?? null;
    //     if (empty($items)) {
    //         $items = $order->orderProducts->map(function ($item) {
    //             return [
    //                 'order_product_id' => $item->id,
    //                 'product_id' => $item->product_id,
    //                 'variant_id' => $item->variant_id,
    //                 'sku_code' => $item->product->sku ?? $item->product_id ?? 'SKU_' . uniqid(),
    //                 'sku_name' => $item->product->name ?? 'Product',
    //                 'quantity' => $item->quantity,
    //             ];
    //         })->toArray();
    //     }

    //     if (empty($items)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Return order must include at least one item.'
    //         ], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $reverseOrder = ReverseOrder::create([
    //             'order_id' => $order->id,
    //             'requested_by_user_id' => $order->user_id,
    //             'reverse_order_number' => $this->generateReverseOrderNumber(),
    //             'status' => 'ready_for_pickup',
    //             'return_contact_name' => $returnAddress['contact_name'],
    //             'return_phone_no' => $returnAddress['phone_no'],
    //             'return_address_1' => $returnAddress['address_1'],
    //             'return_address_2' => $returnAddress['address_2'] ?? null,
    //             'return_city' => $returnAddress['city'],
    //             'return_state' => $returnAddress['state'],
    //             'return_pincode' => $returnAddress['pincode'],
    //             'return_reason' => $validated['return_reason'] ?? $validated['reason'] ?? null,
    //             'order_date' => $order->created_at,
    //         ]);

    //         foreach ($items as $item) {
    //             $reverseOrder->items()->create([
    //                 'order_product_id' => $item['order_product_id'] ?? null,
    //                 'product_id' => $item['product_id'] ?? null,
    //                 'variant_id' => $item['variant_id'] ?? null,
    //                 'sku_code' => $item['sku_code'],
    //                 'sku_name' => $item['sku_name'],
    //                 'quantity' => $item['quantity'],
    //             ]);
    //         }

    //         $reverseOrder->load('items');

    //         $shipmentResult = $delhiveryService->createReverseShipment([
    //             'reverse_order_number' => $reverseOrder->reverse_order_number,
    //             'return_contact_name' => $reverseOrder->return_contact_name,
    //             'return_phone_no' => $reverseOrder->return_phone_no,
    //             'return_address_1' => $reverseOrder->return_address_1,
    //             'return_address_2' => $reverseOrder->return_address_2,
    //             'return_city' => $reverseOrder->return_city,
    //             'return_state' => $reverseOrder->return_state,
    //             'return_pincode' => $reverseOrder->return_pincode,
    //             'total_amount' => $order->total_amount,
    //             'declared_value' => $order->total_amount,
    //         ], $reverseOrder->items);

    //         if (!$shipmentResult['success']) {
    //             throw new \Exception($shipmentResult['message'] ?? 'Delhivery reverse shipment creation failed');
    //         }

    //         $reverseOrder->update([
    //             'waybill' => $shipmentResult['waybill'] ?? null,
    //             'delhivery_response' => $shipmentResult['result'] ?? null,
    //             'awb_status' => 'generated',
    //         ]);

    //         $order->update([
    //             'return_request_added' => 1
    //         ]);
    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Return order request created successfully.',
    //             'shipment' => $shipmentResult,
    //             'data' => $reverseOrder
    //         ], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error('ReturnOrder store error', [
    //             'order_id' => $order->id,
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unable to create return order at this time: ' . $e->getMessage(),
    //             'shipment' => $shipmentResult['result'] ?? null
    //         ], 500);
    //     }
    // }

    public function store(Request $request, ?int $orderId = null): JsonResponse
    {
        Log::info('RETURN ORDER: Store method started', [
            'order_id_param' => $orderId,
            'request_data' => $request->except(['password', 'token']),
        ]);

        try {
            Log::info('RETURN ORDER: Starting validation');

            $validated = $request->validate([
                'order_id' => 'nullable|integer|exists:orders,id',
                'return_reason' => 'nullable|string|max:500',
                'reason' => 'nullable|string|max:500',
                'return_address' => 'nullable|array',
                'return_address.contact_name' => 'sometimes|required_with:return_address|string|max:100',
                'return_address.phone_no' => 'sometimes|required_with:return_address|string|max:20',
                'return_address.address_1' => 'sometimes|required_with:return_address|string|max:150',
                'return_address.address_2' => 'nullable|string|max:150',
                'return_address.city' => 'sometimes|required_with:return_address|string|max:75',
                'return_address.state' => 'sometimes|required_with:return_address|string|max:75',
                'return_address.pincode' => 'sometimes|required_with:return_address|string|max:10',
                'items' => 'nullable|array|min:1',
                'items.*.sku_code' => 'required_with:items|string|max:100',
                'items.*.sku_name' => 'required_with:items|string|max:191',
                'items.*.quantity' => 'required_with:items|integer|min:1',
                'items.*.order_product_id' => 'nullable|integer|exists:ordered_products,id',
                'items.*.product_id' => 'nullable|integer|exists:products,id',
                'items.*.variant_id' => 'nullable|integer|exists:product_variants,id'
            ]);

            Log::info('RETURN ORDER: Validation successful', [
                'validated_data' => $validated,
            ]);

            $orderId = $orderId ?? $validated['order_id'] ?? null;

            Log::info('RETURN ORDER: Resolved order ID', [
                'order_id' => $orderId,
            ]);

            if (!$orderId) {
                Log::warning('RETURN ORDER: Order ID missing');

                return response()->json([
                    'success' => false,
                    'message' => 'Order ID is required.'
                ], 422);
            }

            Log::info('RETURN ORDER: Fetching order', [
                'order_id' => $orderId,
            ]);

            $order = Order::with(['orderProducts', 'user'])->find($orderId);

            if (!$order) {
                Log::warning('RETURN ORDER: Order not found', [
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.'
                ], 404);
            }

            Log::info('RETURN ORDER: Order found', [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'user_id' => $order->user_id,
                'total_amount' => $order->total_amount,
                'order_products_count' => $order->orderProducts->count(),
            ]);

            if ($order->order_status !== 'delivered') {
                Log::warning('RETURN ORDER: Order is not delivered', [
                    'order_id' => $order->id,
                    'current_status' => $order->order_status,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Return can only be requested for delivered orders.'
                ], 422);
            }

            Log::info('RETURN ORDER: Order status is delivered');

            /*
        |--------------------------------------------------------------------------
        | Return Address
        |--------------------------------------------------------------------------
        */

            $returnAddress = $validated['return_address'] ?? [
                'contact_name' => optional($order->user)->name ?? 'Customer',
                'phone_no' => $order->phone_no ?? '',
                'address_1' => $order->address_1 ?? '',
                'address_2' => $order->address_2 ?? null,
                'city' => $order->city ?? '',
                'state' => $order->state ?? '',
                'pincode' => $order->pincode ?? '',
            ];

            Log::info('RETURN ORDER: Return address prepared', [
                'order_id' => $order->id,
                'contact_name' => $returnAddress['contact_name'] ?? null,
                'phone_no' => $returnAddress['phone_no'] ?? null,
                'address_1' => $returnAddress['address_1'] ?? null,
                'address_2' => $returnAddress['address_2'] ?? null,
                'city' => $returnAddress['city'] ?? null,
                'state' => $returnAddress['state'] ?? null,
                'pincode' => $returnAddress['pincode'] ?? null,
            ]);

            if (
                empty($returnAddress['contact_name']) ||
                empty($returnAddress['phone_no']) ||
                empty($returnAddress['address_1']) ||
                empty($returnAddress['city']) ||
                empty($returnAddress['state']) ||
                empty($returnAddress['pincode'])
            ) {
                Log::warning('RETURN ORDER: Return address incomplete', [
                    'order_id' => $order->id,
                    'return_address' => $returnAddress,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Return pickup address is incomplete. Please provide a valid return address or ensure the order address is complete.'
                ], 422);
            }

            /*
        |--------------------------------------------------------------------------
        | Delhivery Serviceability
        |--------------------------------------------------------------------------
        */

            Log::info('RETURN ORDER: Checking Delhivery pincode serviceability', [
                'order_id' => $order->id,
                'pincode' => $returnAddress['pincode'],
            ]);

            $delhiveryService = new DelhiveryService();

            $serviceability = $delhiveryService->isPincodeServiceable(
                $returnAddress['pincode']
            );

            Log::info('RETURN ORDER: Delhivery serviceability response', [
                'order_id' => $order->id,
                'pincode' => $returnAddress['pincode'],
                'serviceability' => $serviceability,
            ]);

            $pickupAvailable =
                $serviceability['pickup_available']
                ?? $serviceability['serviceable']
                ?? false;

            Log::info('RETURN ORDER: Pickup availability determined', [
                'order_id' => $order->id,
                'pickup_available' => $pickupAvailable,
            ]);

            if (!$pickupAvailable) {
                Log::warning('RETURN ORDER: Reverse pickup not available', [
                    'order_id' => $order->id,
                    'pincode' => $returnAddress['pincode'],
                    'serviceability' => $serviceability,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $serviceability['message']
                        ?? 'Reverse pickup is not available for this pincode.',
                    'data' => $serviceability
                ], 422);
            }

            /*
        |--------------------------------------------------------------------------
        | Check Existing Reverse Order
        |--------------------------------------------------------------------------
        */

            Log::info('RETURN ORDER: Checking existing active reverse order', [
                'order_id' => $order->id,
            ]);

            $existingReverseOrder = ReverseOrder::where('order_id', $order->id)
                ->whereIn('status', [
                    'ready_for_pickup',
                    'in_transit',
                    'out_for_delivery'
                ])
                ->first();

            if ($existingReverseOrder) {
                Log::warning('RETURN ORDER: Existing active reverse order found', [
                    'order_id' => $order->id,
                    'reverse_order_id' => $existingReverseOrder->id,
                    'reverse_order_number' => $existingReverseOrder->reverse_order_number,
                    'status' => $existingReverseOrder->status,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'A return order is already active for this order.',
                    'data' => $existingReverseOrder
                ], 409);
            }

            Log::info('RETURN ORDER: No active reverse order found');

            /*
        |--------------------------------------------------------------------------
        | Prepare Items
        |--------------------------------------------------------------------------
        */

            $items = $validated['items'] ?? null;

            Log::info('RETURN ORDER: Items received from request', [
                'items' => $items,
            ]);

            if (empty($items)) {

                Log::info('RETURN ORDER: No items supplied, loading items from order');

                $items = $order->orderProducts->map(function ($item) {

                    Log::info('RETURN ORDER: Preparing order product item', [
                        'order_product_id' => $item->id,
                        'product_id' => $item->product_id,
                        'variant_id' => $item->variant_id,
                        'quantity' => $item->quantity,
                    ]);

                    return [
                        'order_product_id' => $item->id,
                        'product_id' => $item->product_id,
                        'variant_id' => $item->variant_id,
                        'sku_code' => $item->product->sku
                            ?? $item->product_id
                            ?? 'SKU_' . uniqid(),
                        'sku_name' => $item->product->name ?? 'Product',
                        'quantity' => $item->quantity,
                    ];
                })->toArray();
            }

            Log::info('RETURN ORDER: Final return items prepared', [
                'order_id' => $order->id,
                'items' => $items,
                'item_count' => count($items),
            ]);

            if (empty($items)) {

                Log::warning('RETURN ORDER: No return items available', [
                    'order_id' => $order->id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Return order must include at least one item.'
                ], 422);
            }

            /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */

            $shipmentResult = null;

            Log::info('RETURN ORDER: Starting database transaction', [
                'order_id' => $order->id,
            ]);

            DB::beginTransaction();

            try {

                /*
            |--------------------------------------------------------------------------
            | Create Reverse Order
            |--------------------------------------------------------------------------
            */

                $reverseOrderNumber = $this->generateReverseOrderNumber();

                Log::info('RETURN ORDER: Creating ReverseOrder', [
                    'order_id' => $order->id,
                    'reverse_order_number' => $reverseOrderNumber,
                ]);

                $reverseOrder = ReverseOrder::create([
                    'order_id' => $order->id,
                    'requested_by_user_id' => $order->user_id,
                    'reverse_order_number' => $reverseOrderNumber,
                    'status' => 'ready_for_pickup',
                    'return_contact_name' => $returnAddress['contact_name'],
                    'return_phone_no' => $returnAddress['phone_no'],
                    'return_address_1' => $returnAddress['address_1'],
                    'return_address_2' => $returnAddress['address_2'] ?? null,
                    'return_city' => $returnAddress['city'],
                    'return_state' => $returnAddress['state'],
                    'return_pincode' => $returnAddress['pincode'],
                    'return_reason' => $validated['return_reason']
                        ?? $validated['reason']
                        ?? null,
                    'order_date' => $order->created_at,
                ]);

                Log::info('RETURN ORDER: ReverseOrder created successfully', [
                    'reverse_order_id' => $reverseOrder->id,
                    'reverse_order_number' => $reverseOrder->reverse_order_number,
                ]);

                /*
            |--------------------------------------------------------------------------
            | Create Reverse Order Items
            |--------------------------------------------------------------------------
            */

                foreach ($items as $index => $item) {

                    Log::info('RETURN ORDER: Creating reverse order item', [
                        'reverse_order_id' => $reverseOrder->id,
                        'item_index' => $index,
                        'item' => $item,
                    ]);

                    $reverseItem = $reverseOrder->items()->create([
                        'order_product_id' => $item['order_product_id'] ?? null,
                        'product_id' => $item['product_id'] ?? null,
                        'variant_id' => $item['variant_id'] ?? null,
                        'sku_code' => $item['sku_code'],
                        'sku_name' => $item['sku_name'],
                        'quantity' => $item['quantity'],
                    ]);

                    Log::info('RETURN ORDER: Reverse order item created', [
                        'reverse_item_id' => $reverseItem->id,
                        'reverse_order_id' => $reverseOrder->id,
                    ]);
                }

                $reverseOrder->load('items');

                Log::info('RETURN ORDER: ReverseOrder items loaded', [
                    'reverse_order_id' => $reverseOrder->id,
                    'items_count' => $reverseOrder->items->count(),
                ]);

                /*
            |--------------------------------------------------------------------------
            | Create Delhivery Reverse Shipment
            |--------------------------------------------------------------------------
            */

                $shipmentPayload = [
                    'reverse_order_number' => $reverseOrder->reverse_order_number,
                    'return_contact_name' => $reverseOrder->return_contact_name,
                    'return_phone_no' => $reverseOrder->return_phone_no,
                    'return_address_1' => $reverseOrder->return_address_1,
                    'return_address_2' => $reverseOrder->return_address_2,
                    'return_city' => $reverseOrder->return_city,
                    'return_state' => $reverseOrder->return_state,
                    'return_pincode' => $reverseOrder->return_pincode,
                    'total_amount' => $order->total_amount,
                    'declared_value' => $order->total_amount,
                ];

                Log::info('RETURN ORDER: Calling Delhivery createReverseShipment', [
                    'reverse_order_id' => $reverseOrder->id,
                    'payload' => $shipmentPayload,
                    'items' => $reverseOrder->items->toArray(),
                ]);

                $shipmentResult = $delhiveryService->createReverseShipment(
                    $shipmentPayload,
                    $reverseOrder->items
                );

                Log::info('RETURN ORDER: Delhivery createReverseShipment response', [
                    'reverse_order_id' => $reverseOrder->id,
                    'shipment_result' => $shipmentResult,
                ]);

                if (!$shipmentResult['success']) {

                    Log::error('RETURN ORDER: Delhivery reverse shipment failed', [
                        'reverse_order_id' => $reverseOrder->id,
                        'shipment_result' => $shipmentResult,
                    ]);

                    throw new \Exception(
                        $shipmentResult['message']
                            ?? 'Delhivery reverse shipment creation failed'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | Update Reverse Order With AWB
            |--------------------------------------------------------------------------
            */

                Log::info('RETURN ORDER: Updating reverse order with Delhivery response', [
                    'reverse_order_id' => $reverseOrder->id,
                    'waybill' => $shipmentResult['waybill'] ?? null,
                    'awb_status' => 'generated',
                ]);

                $reverseOrder->update([
                    'waybill' => $shipmentResult['waybill'] ?? null,
                    'delhivery_response' => $shipmentResult['result'] ?? null,
                    'awb_status' => 'generated',
                ]);

                /*
            |--------------------------------------------------------------------------
            | Update Original Order
            |--------------------------------------------------------------------------
            */

                Log::info('RETURN ORDER: Updating original order return_request_added', [
                    'order_id' => $order->id,
                ]);

                $order->update([
                    'return_request_added' => 1
                ]);

                Log::info('RETURN ORDER: Committing transaction', [
                    'order_id' => $order->id,
                    'reverse_order_id' => $reverseOrder->id,
                ]);

                DB::commit();

                Log::info('RETURN ORDER: Transaction committed successfully', [
                    'order_id' => $order->id,
                    'reverse_order_id' => $reverseOrder->id,
                    'waybill' => $shipmentResult['waybill'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Return order request created successfully.',
                    'shipment' => $shipmentResult,
                    'data' => $reverseOrder
                ], 201);
            } catch (\Exception $e) {

                DB::rollBack();

                Log::error('RETURN ORDER: Transaction failed', [
                    'order_id' => $order->id ?? null,
                    'reverse_order_id' => $reverseOrder->id ?? null,
                    'exception_class' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'shipment_result' => $shipmentResult,
                ]);

                throw $e;
            }
        } catch (\Exception $e) {

            Log::error('RETURN ORDER: Store method failed', [
                'order_id' => $orderId,
                'exception_class' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'shipment_result' => $shipmentResult ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create return order at this time: ' . $e->getMessage(),
                'shipment' => $shipmentResult['result'] ?? null
            ], 500);
        }
    }
    public function show(ReverseOrder $reverseOrder): JsonResponse
    {
        $reverseOrder->load('items');

        return response()->json([
            'success' => true,
            'data' => $reverseOrder
        ]);
    }

    private function generateReverseOrderNumber(): string
    {
        do {
            $number = 'RRO-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (ReverseOrder::where('reverse_order_number', $number)->exists());

        return $number;
    }

    public function getDetails(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            // dd($orderId);
            if (!$orderId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID is required'
                ], 400);
            }

            // Find the reverse order - NO 'reverseOrder' relationship here
            // Just load the related order and refunds
            $returnOrder = ReverseOrder::with(['order'])->find($orderId);
            // dd($returnOrder);

            if (!$returnOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Return order not found'
                ], 404);
            }

            // Get the associated order
            $order = $returnOrder->order;

            // Prepare response data
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $returnOrder->id,
                    'order_id' => $returnOrder->order_id ?? $order->order_id ?? $returnOrder->id,
                    'waybill_number' => $returnOrder->waybill ?? 'N/A',
                    'customer_name' => $order->user->name ?? 'N/A',
                    'total_amount' => $returnOrder->total_amount ?? $order->total_amount ?? 0,
                    'refund_status' => $returnOrder->refund_status ?? 'pending',
                    'status' => $returnOrder->status,
                    'created_at' => $returnOrder->created_at,
                ],
                'reverse_order' => [
                    'id' => $returnOrder->id,
                    'reverse_order_id' => $returnOrder->reverse_order_id ?? $returnOrder->id,
                    'status' => $returnOrder->status,
                    'status_color' => $this->getStatusColor($returnOrder->status),
                    'waybill' => $returnOrder->waybill,
                    'return_reason' => $returnOrder->return_reason,
                    'created_at' => $returnOrder->created_at,
                    'payload' => $returnOrder->payload,
                    'delivered_at' => $returnOrder->delivered_at,
                    'pickup_date' => $returnOrder->pickup_date,
                ],
                'refunds' => $returnOrder->refunds ? $returnOrder->refunds->map(function ($refund) {
                    return [
                        'id' => $refund->id,
                        'amount' => $refund->amount,
                        'reason' => $refund->reason,
                        'status' => $refund->status,
                        'transaction_id' => $refund->transaction_id,
                        'created_at' => $refund->created_at,
                    ];
                }) : [],
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching return order details: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get status color for badge
     */
    private function getStatusColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'delivered' => 'success',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'return_initiated' => 'primary',
            'pickup_scheduled' => 'info',
            'picked_up' => 'info',
            'return_in_transit' => 'warning',
            'return_delivered' => 'success',
            'initiated' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
            'pickup_assigned' => 'info',
            'picked' => 'info',
            'in_transit' => 'warning',
        ];

        return $colors[$status] ?? 'secondary';
    }
}
