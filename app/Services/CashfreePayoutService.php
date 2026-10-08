<?php

namespace App\Services;

use App\Models\CodRefundDetail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CashfreePayoutService
{
    protected string $baseUrl;
    protected string $apiVersion;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $cfg = config('services.cashfree.payout');
        $this->baseUrl      = $cfg['base_url'];
        $this->apiVersion   = $cfg['api_version'];
        $this->clientId     = $cfg['client_id'];
        $this->clientSecret = $cfg['client_secret'];
    }

    /**
     * v2 headers — client ID + secret sent directly on every request.
     * No more Bearer token exchange for v2.
     */
    protected function headers(): array
    {
        return [
            'x-client-id'     => $this->clientId,
            'x-client-secret' => $this->clientSecret,
            'x-api-version'   => $this->apiVersion,
            'Content-Type'    => 'application/json',
            'Accept'          => 'application/json',
        ];
    }

    /* ---------------------------------------------------------------------
     | 1. Add Beneficiary
     |    POST {base}/payout/beneficiary
     * ------------------------------------------------------------------ */

    // public function addBeneficiary(CodRefundDetail $detail): string
    // {
    //     $beneId = $detail->bene_id
    //         ?: 'BENE_' . $detail->user_id . '_' . $detail->order_id;

    //     $payload = [
    //         'beneficiary_id'   => $beneId,
    //         'beneficiary_name' => $detail->account_holder_name,
    //         'beneficiary_instrument_details' => [
    //             'bank_account_number' => $detail->account_number,   // decrypted
    //             'bank_ifsc'           => strtoupper($detail->ifsc_code),
    //         ],
    //         'beneficiary_contact_details' => [
    //             'beneficiary_email'        => $detail->user->email    ?? 'no-reply@example.com',
    //             'beneficiary_phone'        => $detail->user->phone_no ?? '9999999999',
    //             'beneficiary_country_code' => '+91',
    //             'beneficiary_address'      => 'N/A',
    //             'beneficiary_city'         => 'N/A',
    //             'beneficiary_state'        => 'N/A',
    //             'beneficiary_postal_code'  => '000000',
    //         ],
    //     ];

    //     $url = "{$this->baseUrl}/payout/beneficiary";
    //     Log::info('Cashfree Payout: OUTGOING REQUEST', [
    //         'url'     => $url,
    //         'headers' => [
    //             'x-client-id'     => substr($this->clientId, 0, 6) . '...' . substr($this->clientId, -4),
    //             'x-client-secret' => substr($this->clientSecret, 0, 6) . '...' . substr($this->clientSecret, -4),
    //             'x-api-version'   => $this->apiVersion,
    //         ],
    //     ]);

    //     Log::info('Cashfree Payout: addBeneficiary request', [
    //         'cod_refund_id' => $detail->id,
    //         'url'           => $url,
    //         'payload'       => array_merge($payload, [
    //             'beneficiary_instrument_details' => [
    //                 'bank_account_number' => '***',
    //                 'bank_ifsc'           => $payload['beneficiary_instrument_details']['bank_ifsc'],
    //             ],
    //         ]),
    //     ]);

    //     $response = Http::withHeaders($this->headers())
    //         ->post($url, $payload);

    //     $body = $response->json() ?? [];

    //     Log::info('Cashfree Payout: addBeneficiary response', [
    //         'cod_refund_id' => $detail->id,
    //         'http_status'   => $response->status(),
    //         'body'          => $body,
    //     ]);

    //     // v2 returns 200 with status=ERROR on failures
    //     if ($response->failed() || ($body['status'] ?? '') === 'ERROR') {
    //         throw new \RuntimeException(
    //             $body['message'] ?? 'Failed to register beneficiary with Cashfree.'
    //         );
    //     }

    //     return $beneId;
    // }

    public function addBeneficiary(CodRefundDetail $detail): string
{
    $beneId = $detail->bene_id
        ?: 'BENE_' . $detail->user_id . '_' . $detail->order_id;

    $payload = [
        'beneficiary_id'   => $beneId,
        'beneficiary_name' => $detail->account_holder_name,
        'beneficiary_instrument_details' => [
            'bank_account_number' => $detail->account_number,
            'bank_ifsc'           => strtoupper($detail->ifsc_code),
        ],
        'beneficiary_contact_details' => [
            'beneficiary_email'        => $detail->user->email    ?? 'no-reply@example.com',
            'beneficiary_phone'        => $detail->user->phone_no ?? '9999999999',
            'beneficiary_country_code' => '+91',
            'beneficiary_address'      => 'N/A',
            'beneficiary_city'         => 'N/A',
            'beneficiary_state'        => 'N/A',
            'beneficiary_postal_code'  => '000000',
        ],
    ];

    $url = "{$this->baseUrl}/payout/beneficiary";

    $response = Http::withHeaders($this->headers())
        ->post($url, $payload);

    $body = $response->json() ?? [];

    Log::info('Cashfree Payout: addBeneficiary response', [
        'cod_refund_id' => $detail->id,
        'http_status'   => $response->status(),
        'body'          => $body,
    ]);

    // 👇 NEW: Treat "already exists" as success (idempotent retry)
    if ($response->failed() || ($body['status'] ?? '') === 'ERROR') {
        $message = strtolower($body['message'] ?? '');

        if (str_contains($message, 'already exist')) {
            Log::info('Cashfree Payout: beneficiary already exists — reusing', [
                'cod_refund_id' => $detail->id,
                'bene_id'       => $beneId,
            ]);

            return $beneId;  // ✅ continue to transfer
        }

        throw new \RuntimeException(
            $body['message'] ?? 'Failed to register beneficiary with Cashfree.'
        );
    }

    return $beneId;
}

    /* ---------------------------------------------------------------------
     | 2. Direct Transfer
     |    POST {base}/payout/transfers   ← note the plural
     * ------------------------------------------------------------------ */

    public function directTransfer(
        string $beneId,
        float $amount,
        string $transferId
    ): array {
        $payload = [
            'transfer_id'     => $transferId,
            'transfer_amount' => round($amount, 2),
            'beneficiary_details' => [
                'beneficiary_id' => $beneId,
            ],
        ];

        $url = "{$this->baseUrl}/payout/transfers";

        Log::info('Cashfree Payout: directTransfer request', [
            'url'         => $url,
            'transfer_id' => $transferId,
            'amount'      => $amount,
            'bene_id'     => $beneId,
        ]);

        $response = Http::withHeaders($this->headers())
            ->post($url, $payload);

        $body = $response->json() ?? [];

        Log::info('Cashfree Payout: directTransfer response', [
            'transfer_id' => $transferId,
            'http_status' => $response->status(),
            'body'        => $body,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                $body['message'] ?? 'Cashfree payout transfer failed.'
            );
        }

        $status = strtoupper($body['status'] ?? 'PENDING');

        if (in_array($status, ['ERROR', 'FAILED'], true)) {
            throw new \RuntimeException(
                $body['message']
                    ?? $body['status_description']
                    ?? 'Transfer failed.'
            );
        }

        // v2 response shape may include utr / cf_transfer_id / reference_id at top level
        return [
            'status' => $status,
            'utr'    => $body['utr']
                ?? $body['cf_transfer_id']
                ?? $body['reference_id']
                ?? null,
            'raw'    => $body,
        ];
    }

    /* ---------------------------------------------------------------------
     | 3. Orchestration
     * ------------------------------------------------------------------ */

    public function refundCodOrder(CodRefundDetail $detail): array
    {
        if ($detail->status === 'completed') {
            throw new \RuntimeException('This refund has already been completed.');
        }

        $amount = (float) ($detail->refund_amount ?? $detail->order->total_amount);

        if ($amount <= 0) {
            throw new \RuntimeException('Refund amount must be greater than zero.');
        }

        $transferId = $detail->transfer_id
            ?: 'CODRF_' . $detail->id . '_' . Str::random(8);

        // Save intent BEFORE calling Cashfree
        $detail->update([
            'status'         => 'processing',
            'transfer_id'    => $transferId,
            'refund_amount'  => $amount,
            'failure_reason' => null,
        ]);

        try {
            // 1. Add beneficiary (idempotent on Cashfree's side if bene_id exists)
            $beneId = $this->addBeneficiary($detail);
            $detail->update(['bene_id' => $beneId]);

            // 2. Transfer
            $result = $this->directTransfer($beneId, $amount, $transferId);

            $detail->update([
                'status'            => $result['status'] === 'SUCCESS' ? 'completed' : 'processing',
                'utr_number'        => $result['utr'],
                'cashfree_response' => $result['raw'],
                'processed_at'      => now(),
            ]);

            return [
                'success' => true,
                'status'  => $detail->fresh()->status,
                'utr'     => $result['utr'],
                'amount'  => $amount,
            ];
        } catch (\Throwable $e) {
            $detail->update([
                'status'         => 'failed',
                'failure_reason' => $e->getMessage(),
            ]);

            Log::error('COD payout refund failed', [
                'cod_refund_id' => $detail->id,
                'order_id'      => $detail->order_id,
                'error'         => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
