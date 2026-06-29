<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CashfreeRefundService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    protected $refundService;

    public function __construct(CashfreeRefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    public function refund(Request $request, string $orderId)
    {
        try {
            // Get refund data from request
            $amount = $request->input('amount', 0);
            $refundNote = $request->input('refund_note', 'Refund for order #' . $orderId);
            $refundSpeed = $request->input('refund_speed', 'STANDARD');

            // Process refund
            $result = $this->refundService->processRefund(
                $orderId,
                $amount,
                null, // Auto-generate refund ID
                $refundNote,
                $refundSpeed
            );

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Refund processing failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Refund process failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function refundStatus(Request $request, string $orderId, string $refundId)
    {
        try {
            $status = $this->refundService->getRefundStatus($orderId, $refundId);

            return response()->json([
                'success' => true,
                'data' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get refund status: ' . $e->getMessage()
            ], 500);
        }
    }
}