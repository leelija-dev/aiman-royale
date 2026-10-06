<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\CodRefundDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CashfreeWebhookController extends Controller
{
    /**
     * Cashfree Payouts webhook.
     * Public endpoint — no auth, no CSRF.
     */
    public function payout(Request $request)
    {
        $rawBody = $request->getContent();
        $signature = $request->header('x-webhook-signature');
        $timestamp = $request->header('x-webhook-timestamp');

        Log::info('Cashfree Payout webhook received', [
            'ip'        => $request->ip(),
            'event'     => $request->input('event'),
            'signature' => $signature ? 'present' : 'missing',
        ]);

        // ─── Optional but recommended: verify signature ───
        if (!$this->verifySignature($rawBody, $timestamp, $signature)) {
            Log::warning('Cashfree Payout webhook: invalid signature');
            return response()->json(['ok' => false, 'message' => 'Invalid signature'], 401);
        }

        $event = $request->input('event');
        $data  = $request->input('data', []);
        $tid   = $data['transferId'] ?? null;

        if (!$tid) {
            Log::warning('Cashfree Payout webhook: no transferId in payload');
            return response()->json(['ok' => true]); // accept & ignore
        }

        $detail = CodRefundDetail::where('transfer_id', $tid)->first();

        if (!$detail) {
            Log::info('Cashfree Payout webhook: no matching CodRefundDetail', ['transfer_id' => $tid]);
            return response()->json(['ok' => true]); // accept & ignore
        }

        match ($event) {
            'TRANSFER_SUCCESS' => $detail->update([
                'status'            => 'completed',
                'utr_number'        => $data['utr'] ?? $detail->utr_number,
                'cashfree_response' => $data,
                'processed_at'      => now(),
            ]),
            'TRANSFER_FAILED', 'TRANSFER_REVERSED' => $detail->update([
                'status'            => 'failed',
                'failure_reason'    => $data['reason'] ?? 'Transfer failed',
                'cashfree_response' => $data,
            ]),
            default => null,
        };

        Log::info('Cashfree Payout webhook processed', [
            'event'       => $event,
            'transfer_id' => $tid,
            'status'      => $detail->fresh()->status,
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Verify Cashfree webhook signature.
     * Cashfree signs with HMAC-SHA256 of timestamp + raw body using your client secret.
     */
    protected function verifySignature(string $rawBody, ?string $timestamp, ?string $signature): bool
    {
        $secret = config('services.cashfree.payout.client_secret');

        if (!$secret || !$timestamp || !$signature) {
            // In sandbox you can skip verification. In production, fail closed.
            return config('services.cashfree.payout.mode') === 'sandbox';
        }

        $expected = base64_encode(hash_hmac('sha256', $timestamp . $rawBody, $secret, true));

        return hash_equals($expected, $signature);
    }
}