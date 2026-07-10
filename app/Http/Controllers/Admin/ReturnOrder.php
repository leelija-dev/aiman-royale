<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Models\ReverseOrder;
use App\Services\CashfreeRefundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReturnOrder extends Controller
{
    protected CashfreeRefundService $refundService;

    public function __construct(CashfreeRefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    public function index()
    {
        $orders = ReverseOrder::with('order', 'items', 'requestedBy')->where('refund_request_added', false)->get();
        // dd($orders);
        return view('admin.return-order.index', compact('orders'));
    }

    // public function refund(Request $request): JsonResponse
    // {
    //     Log::info('Refund request received', $request->all());

    //     // Find the order
    //     $order = Order::find($request->order_id);

    //     if (!$order) {
    //         return response()->json(['error' => 'Order not found'], 404);
    //     }

    //     // ✅ Log the order details
    //     Log::info('Order details for refund', [
    //         'order_id' => $order->id,
    //         'total' => $order->total,
    //         'total_formatted' => number_format($order->total, 2),
    //         'total_type' => gettype($order->total),
    //         'amount_requested' => $request->amount,
    //         'amount_requested_type' => gettype($request->amount),
    //         'difference' => (float) $request->amount - (float) $order->total
    //     ]);

    //     // Check if amount exceeds order total
    //     if ((float) $request->amount > (float) $order->total) {
    //         return response()->json([
    //             'error' => 'Refund amount exceeds order total',
    //             'details' => [
    //                 'order_total' => number_format($order->total, 2),
    //                 'requested_amount' => number_format($request->amount, 2),
    //                 'difference' => number_format((float) $request->amount - (float) $order->total, 2)
    //             ]
    //         ], 400);
    //     }
    //     try {
    //         $validated = $request->validate([
    //             'order_id' => 'required|integer|exists:orders,id',
    //             'amount' => 'required|numeric|min:0.01',
    //             'reason' => 'nullable|string|max:255',
    //             'comments' => 'nullable|string|max:1000',
    //         ]);

    //         $order = Order::findOrFail($validated['order_id']);

    //         if ($request->amount > $order->total) {
    //             return response()->json([
    //                 'error' => 'Refund amount cannot exceed order total',
    //                 'details' => [
    //                     'order_total' => $order->total,
    //                     'requested_amount' => $request->amount,
    //                     'max_allowed' => $order->total
    //                 ]
    //             ], 400);
    //         }

    //         if ($order->order_status === 'refunded') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Order has already been refunded.',
    //             ], 400);
    //         }

    //         $amount = (float) $validated['amount'];
    //         $reason = $validated['reason'] ?? 'Refund requested from return order';
    //         $comments = $validated['comments'] ?? null;
    //         $cashfreeOrderRef = $order->cashfree_order_ref ?? 'CF_' . $order->id . '_' . strtotime($order->created_at);

    //         $refundResult = $this->refundService->processPartialRefund(
    //             $order,
    //             $amount,
    //             $reason,
    //             'STANDARD'
    //         );

    //         $refund = Refund::where('order_id', $order->id)->latest()->first();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Refund processed successfully.',
    //             'amount' => $amount,
    //             'refund' => $refund,
    //             'cashfree' => $refundResult,
    //             'comments' => $comments,
    //         ]);
    //     } catch (\Throwable $e) {
    //         Log::error('Admin return-order refund failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'request' => $request->all(),
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function refund(Request $request)
    {
        // dd($request->all());
        try {
            Log::info('Refund request received', $request->all());

            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric|min:0.01',
                'reason' => 'required|string|max:255',
            ]);

            $order = Order::findOrFail($request->order_id);

            // ✅ Use correct column name: total_amount
            if (is_null($order->total_amount) || $order->total_amount == 0) {
                Log::info('Order total_amount is null, calculating from items', ['order_id' => $order->id]);

                $calculatedTotal = $this->calculateOrderTotal($order);

                if ($calculatedTotal > 0) {
                    $order->total_amount = $calculatedTotal;
                    $order->save();
                    Log::info('Order total_amount calculated and saved', [
                        'order_id' => $order->id,
                        'new_total' => $calculatedTotal
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Order total is missing and could not be calculated',
                        'order_id' => $order->id
                    ], 400);
                }
            }

            $amount = (float) $request->amount;
            $orderTotal = (float) $order->total_amount; // ✅ Use total_amount

            Log::info('Refund validation', [
                'order_id' => $order->id,
                'order_total' => $orderTotal,
                'requested_amount' => $amount
            ]);

            if ($amount > $orderTotal) {
                return response()->json([
                    'error' => 'Refund amount exceeds order total',
                    'details' => [
                        'order_total' => number_format($orderTotal, 2),
                        'requested_amount' => number_format($amount, 2)
                    ]
                ], 400);
            }

            $refundService = new CashfreeRefundService();
            $result = $refundService->processPartialRefund(
                $order,
                $amount,
                $request->reason,
                'STANDARD'
            );

            return response()->json([
                'success' => true,
                'message' => "Refund of ₹" . number_format($amount, 2) . " processed successfully",
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Refund failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    private function calculateOrderTotal($order)
    {
        $total = 0;

        if (method_exists($order, 'items')) {
            $total = $order->items->sum(function ($item) {
                return ($item->price ?? 0) * ($item->quantity ?? 1);
            });
        }

        // ✅ Add any other charges
        if (isset($order->tax) && $order->tax > 0) {
            $total += (float) $order->tax;
        }
        if (isset($order->shipping) && $order->shipping > 0) {
            $total += (float) $order->shipping;
        }
        if (isset($order->discount) && $order->discount > 0) {
            $total -= (float) $order->discount;
        }

        return $total;
    }

    public function bulkRefund(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_ids' => 'required|array|min:1',
            'reason' => 'nullable|string|max:255',
            'comments' => 'nullable|string|max:1000',
        ]);

        $processed = 0;
        $failed = 0;
        $failedOrders = [];
        $totalAmount = 0.0;

        foreach ($validated['order_ids'] as $orderId) {
            $order = Order::find($orderId);
            if (!$order) {
                $failed++;
                $failedOrders[] = $orderId;
                continue;
            }

            try {
                $amount = (float) $order->total_amount;
                $this->refundService->processPartialRefund($order, $amount, $validated['reason'] ?? 'Bulk refund', 'STANDARD');
                $processed++;
                $totalAmount += $amount;
            } catch (\Throwable $e) {
                $failed++;
                $failedOrders[] = $orderId;
            }
        }

        return response()->json([
            'success' => true,
            'count' => $processed,
            'failed_count' => $failed,
            'failed_orders' => $failedOrders,
            'total_amount' => number_format($totalAmount, 2),
        ]);
    }

    public function details(Request $request)
    {
        $orderId = $request->get('order_id');

        $returnOrder = ReverseOrder::where('order_id', $orderId)->first();

        if (!$returnOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Return order not found.',
            ], 404);
        }

        $order = $returnOrder->order;

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order?->id,
                'order_id' => $order?->id,
                'waybill_number' => $returnOrder->waybill,
                'customer_name' => $order?->user?->name,
                'total_amount' => $order?->total_amount,
                'refund_status' => $order?->refund_status,
                'refunds' => $order?->refunds()->latest()->get(),
            ],
            'reverse_order' => [
                'reverse_order_id' => $returnOrder->reverse_order_number,
                'status' => $returnOrder->status,
                'status_color' => $returnOrder->status_color,
                'waybill' => $returnOrder->waybill,
                'created_at' => $returnOrder->created_at,
                'return_reason' => $returnOrder->return_reason,
                'payload' => $returnOrder->delhivery_response,
            ],
        ]);
    }
}
