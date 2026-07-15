<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Services\CashfreeRefundService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    protected $refundService;

    public function __construct(CashfreeRefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    /**
     * Process a refund for an order
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function refund(Request $request, int $orderId)
    {
        // dd($orderId);
        try {
            // Validate request
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
                'refund_note' => 'nullable|string|max:500',
                'refund_speed' => 'nullable|in:STANDARD,INSTANT',
                'is_full' => 'nullable|boolean',
            ]);

            // Find the order
            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if order is already refunded
            if ($order->order_status === 'refunded') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been refunded'
                ], 400);
            }

            // Check if order is paid
            if (!in_array($order->payment_status, ['paid', 'cod'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order is not in a refundable state'
                ], 400);
            }

            // Get refund data
            $amount = $request->input('amount');
            $isFull = $request->input('is_full', false);
            
            // If full refund, use order total
            if ($isFull) {
                $amount = $order->total_amount;
            }

            // Validate amount against order total
            if ($amount > $order->total_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Refund amount cannot exceed order total'
                ], 400);
            }

            // Check if already refunded amount exceeds order total
            $totalRefunded = Refund::where('order_id', $orderId)
                ->where('status', Refund::STATUS_SUCCESS)
                ->sum('amount');

            if (($totalRefunded + $amount) > $order->total_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total refund amount cannot exceed order total. Already refunded: ₹' . number_format($totalRefunded, 2)
                ], 400);
            }

            // Get Cashfree order reference
            $cashfreeOrderRef = $order->cashfree_order_ref ?? 'CF_' . $order->id . '_' . strtotime($order->created_at);

            // Refund note
            $refundNote = $request->input('refund_note', 'Refund for order #' . $order->id);
            $refundSpeed = $request->input('refund_speed', 'STANDARD');

            // Process refund
            $result = $this->refundService->processRefund(
                $cashfreeOrderRef,
                $amount,
                null, // Auto-generate refund ID
                $refundNote,
                $refundSpeed,
                $order->id
            );

            // Get the created refund record
            $refund = Refund::where('order_id', $order->id)
                ->latest()
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'data' => [
                    'refund' => $refund,
                    'cashfree_response' => $result
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Refund processing failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Refund process failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get refund status
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @param string $refundId - Refund ID (internal or Cashfree)
     * @return \Illuminate\Http\JsonResponse
     */
    public function refundStatus(Request $request, int $orderId, string $refundId)
    {
        try {
            // Find the order
            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Find the refund record
            $refund = Refund::where('order_id', $orderId)
                ->where(function ($query) use ($refundId) {
                    $query->where('refund_id', $refundId)
                        ->orWhere('cf_refund_id', $refundId);
                })
                ->first();

            if (!$refund) {
                return response()->json([
                    'success' => false,
                    'message' => 'Refund not found for this order'
                ], 404);
            }

            // Get Cashfree order reference
            $cashfreeOrderRef = $order->cashfree_order_ref ?? 'CF_' . $order->id . '_' . strtotime($order->created_at);

            // Get status from Cashfree
            $status = $this->refundService->getRefundStatus(
                $cashfreeOrderRef,
                $refund->cf_refund_id ?? $refund->refund_id
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'refund' => $refund,
                    'cashfree_status' => $status
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get refund status', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get refund status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all refunds for an order
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderRefunds(Request $request, int $orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $refunds = Refund::where('order_id', $orderId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'order' => $order,
                    'refunds' => $refunds,
                    'total_refunded' => $order->total_refunded,
                    'remaining_balance' => $order->total_amount - $order->total_refunded
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get order refunds', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get order refunds: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process a full refund
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function fullRefund(Request $request, int $orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if order is already refunded
            if ($order->order_status === 'refunded') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been refunded'
                ], 400);
            }

            // Process full refund
            $result = $this->refundService->processFullRefund(
                $order,
                $request->input('refund_note', 'Full refund for order #' . $order->id),
                $request->input('refund_speed', 'STANDARD')
            );

            // Get the created refund record
            $refund = Refund::where('order_id', $order->id)
                ->latest()
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Full refund processed successfully',
                'data' => [
                    'refund' => $refund,
                    'cashfree_response' => $result
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Full refund failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Full refund failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process a partial refund
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function partialRefund(Request $request, int $orderId)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
                'refund_note' => 'nullable|string|max:500',
                'refund_speed' => 'nullable|in:STANDARD,INSTANT',
            ]);

            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if order is already fully refunded
            if ($order->order_status === 'refunded' && $order->total_refunded >= $order->total_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been fully refunded'
                ], 400);
            }

            $amount = $request->input('amount');

            // Process partial refund
            $result = $this->refundService->processPartialRefund(
                $order,
                $amount,
                $request->input('refund_note', 'Partial refund for order #' . $order->id),
                $request->input('refund_speed', 'STANDARD')
            );

            // Get the created refund record
            $refund = Refund::where('order_id', $order->id)
                ->latest()
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Partial refund processed successfully',
                'data' => [
                    'refund' => $refund,
                    'cashfree_response' => $result,
                    'total_refunded' => $order->total_refunded,
                    'remaining_balance' => $order->total_amount - $order->total_refunded
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Partial refund failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Partial refund failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel a pending refund
     * 
     * @param Request $request
     * @param int $orderId - Internal order ID
     * @param string $refundId - Refund ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelRefund(Request $request, int $orderId, string $refundId)
    {
        try {
            $order = Order::find($orderId);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $refund = Refund::where('order_id', $orderId)
                ->where(function ($query) use ($refundId) {
                    $query->where('refund_id', $refundId)
                        ->orWhere('cf_refund_id', $refundId);
                })
                ->first();

            if (!$refund) {
                return response()->json([
                    'success' => false,
                    'message' => 'Refund not found'
                ], 404);
            }

            // Only allow cancellation if refund is pending or processing
            if (!in_array($refund->status, [Refund::STATUS_PENDING, Refund::STATUS_PROCESSING])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or processing refunds can be cancelled'
                ], 400);
            }

            // Update refund status
            $refund->markAsCancelled($request->input('reason', 'Cancelled by admin'));

            return response()->json([
                'success' => true,
                'message' => 'Refund cancelled successfully',
                'data' => $refund
            ]);

        } catch (\Exception $e) {
            Log::error('Refund cancellation failed', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Refund cancellation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get refund statistics
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics(Request $request)
    {
        try {
            $stats = [
                'total_refunds' => Refund::count(),
                'pending_refunds' => Refund::where('status', Refund::STATUS_PENDING)->count(),
                'processing_refunds' => Refund::where('status', Refund::STATUS_PROCESSING)->count(),
                'successful_refunds' => Refund::where('status', Refund::STATUS_SUCCESS)->count(),
                'failed_refunds' => Refund::where('status', Refund::STATUS_FAILED)->count(),
                'total_amount_refunded' => Refund::where('status', Refund::STATUS_SUCCESS)->sum('amount'),
                'recent_refunds' => Refund::with('order')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get refund statistics', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get refund statistics: ' . $e->getMessage()
            ], 500);
        }
    }
}