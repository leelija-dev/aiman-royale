<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CodRefundDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CodRefundController extends Controller
{
    /**
     * Return the latest CodRefundDetail for a given order.
     * Used by the admin return-orders page to fetch bank details.
     */
    public function details(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        Log::info('COD Refund: details lookup requested', [
            'order_id' => $validated['order_id'],
            'admin_id' => auth()->id(),
        ]);

        $detail = CodRefundDetail::where('order_id', $validated['order_id'])
            ->latest()
            ->first();

        if (!$detail) {
            Log::info('COD Refund: no bank details found', [
                'order_id' => $validated['order_id'],
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No COD refund details found for this order.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'cod_refund_detail' => [
                'id'                    => $detail->id,
                'order_id'              => $detail->order_id,
                'user_id'               => $detail->user_id,
                'account_holder_name'   => $detail->account_holder_name,
                'bank_name'             => $detail->bank_name,
                'masked_account_number' => $detail->masked_account_number, // from model accessor
                'ifsc_code'             => $detail->ifsc_code,
                'refund_amount'         => $detail->refund_amount
                                            ?? $detail->order->total_amount
                                            ?? 0,
                'status'                => $detail->status ?? 'pending',
                'utr_number'            => $detail->utr_number,
                'created_at'            => $detail->created_at,
            ],
        ]);
    }
}