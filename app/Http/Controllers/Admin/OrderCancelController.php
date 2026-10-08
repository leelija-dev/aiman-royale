<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\CashfreeRefundService;
use Illuminate\Support\Facades\Log;

class OrderCancelController extends Controller
{

    protected CashfreeRefundService $refundService;

    public function __construct(CashfreeRefundService $refundService)
    {
        $this->refundService = $refundService;
    }
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $orders = Order::with('user')
            ->where('order_status', 'cancelled')
            ->where('payment_method', 'cashfree')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)                              // exact order ID
                        ->orWhere('transaction_id', 'like', "%{$search}%")  // transaction ID
                        ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('Admin.cancel-order.index', compact('orders'));
    }

    public function details(Request $request)
    {
        $orderId = $request->get('order_id');

        $cancelOrder = Order::where('id', $orderId)->first();

        if (!$cancelOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Cancel order not found.',
            ], 404);
        }

        $order = $cancelOrder;

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order?->id,
                'order_id' => $order?->id,
                'waybill_number' => $order->waybill_number,
                'customer_name' => $order->customer_name,
                'total_amount' => $order?->total_amount,
                'refund_status' => $order?->refund_status,
                'refunds' => $order?->refunds()->latest()->get(),
            ]
        ]);
    }

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

            $result = $this->refundService->processPartialRefund(
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
}
