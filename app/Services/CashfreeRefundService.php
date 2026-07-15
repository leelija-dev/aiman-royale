<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Refund;
use App\Models\ReverseOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CashfreeRefundService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $environment;

    public function __construct()
    {
        $this->environment = env('CASHFREE_MODE', 'sandbox');
        $isSandbox = $this->environment === 'sandbox';

        // Correct Base URL for PG API
        $this->baseUrl = $isSandbox
            ? 'https://sandbox.cashfree.com'
            : 'https://api.cashfree.com';

        // Use credentials based on environment
        if ($isSandbox) {
            $this->clientId = env('CASHFREE_TEST_APP_ID');
            $this->clientSecret = env('CASHFREE_TEST_SECRET_KEY');
        } else {
            $this->clientId = env('CASHFREE_APP_ID');
            $this->clientSecret = env('CASHFREE_SECRET_KEY');
        }

        Log::info('Cashfree Refund Service Initialized', [
            'environment' => $this->environment,
            'api_url' => $this->baseUrl,
            'client_id' => $this->clientId ? 'Set' : 'Not Set',
            'client_secret' => $this->clientSecret ? 'Set' : 'Not Set'
        ]);
    }

    /**
     * Process a refund for an order using Cashfree PG Refund API
     *
     * @param string $orderId - The Cashfree Order ID (e.g., CF_195_1782729631)
     * @param float $amount - Refund amount
     * @param string|null $refundId - Unique refund ID (optional)
     * @param string|null $refundNote - Refund note (optional)
     * @param string $refundSpeed - STANDARD or INSTANT (default: STANDARD)
     * @param int|null $internalOrderId - Your internal order ID (optional)
     * @return array
     * @throws \Exception
     */
    public function processRefund(
        string $orderId, 
        float $amount, 
        ?string $refundId = null, 
        ?string $refundNote = null,
        string $refundSpeed = 'STANDARD',
        ?int $internalOrderId = null
    ): array {

        
        try {
            // Validate credentials
            if (!$this->clientId || !$this->clientSecret) {
                Log::error('Cashfree credentials missing');
                throw new \Exception('Cashfree API credentials are not configured. Please check your .env file.');
            }

            // Generate refund ID if not provided
            if (!$refundId) {
                $refundId = 'REF-' . date('Ymd') . '-' . Str::random(8);
            }

            // Prepare payload
            $payload = [
                'refund_amount' => (float) number_format($amount, 2, '.', ''),
                'refund_id' => $refundId,
                'refund_speed' => $refundSpeed,
            ];

            // Add refund note if provided
            if ($refundNote) {
                $payload['refund_note'] = $refundNote;
            }

            // API endpoint
            $endpoint = $this->baseUrl . '/pg/orders/' . $orderId . '/refunds';

            Log::info('Processing Cashfree refund', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'amount' => $amount,
                'refund_speed' => $refundSpeed,
                'endpoint' => $endpoint,
                'internal_order_id' => $internalOrderId
            ]);

            // Make the API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-version' => '2025-01-01',
                'x-client-id' => $this->clientId,
                'x-client-secret' => $this->clientSecret,
            ])->post($endpoint, $payload);

            // Log response
            Log::info('Cashfree refund response', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            // Handle error response
            if ($response->failed()) {
                $errorData = $response->json();
                
                // Extract error message from different response formats
                $errorMessage = 'Unknown error occurred';
                if (isset($errorData['message'])) {
                    $errorMessage = $errorData['message'];
                } elseif (isset($errorData['error'])) {
                    $errorMessage = $errorData['error'];
                } elseif (isset($errorData['errors']) && is_array($errorData['errors'])) {
                    $errorMessage = implode(', ', $errorData['errors']);
                }

                // Handle specific error codes
                if ($response->status() === 404) {
                    throw new \Exception('Order not found. Please check the order ID.');
                } elseif ($response->status() === 401) {
                    throw new \Exception('Authentication failed. Please check your API credentials.');
                } elseif ($response->status() === 400) {
                    throw new \Exception('Invalid request: ' . $errorMessage);
                }

                throw new \Exception('Refund failed: ' . $errorMessage);
            }

            $responseData = $response->json();

            // Check if refund was successful
            if (!isset($responseData['refund_id']) && !isset($responseData['cf_refund_id'])) {
                Log::error('Unexpected refund response structure', ['response' => $responseData]);
                throw new \Exception('Refund response format unexpected');
            }

            // ✅ Save refund record to database
            if ($internalOrderId) {
                $this->saveRefundRecord($internalOrderId, $responseData, $orderId, $refundNote);
            } else {
                // Try to find order by Cashfree order reference
                $this->saveRefundRecordByOrderRef($orderId, $responseData, $refundNote);
            }

            return $responseData;

        } catch (\Exception $e) {
            Log::error('Cashfree refund error', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Save refund record to database using internal order ID
     */
    protected function saveRefundRecord(int $orderId, array $responseData, string $cashfreeOrderRef, ?string $refundNote): void
    {
        try {
            // Extract refund data
            $refundId = $responseData['refund_id'] ?? null;
            $cfRefundId = $responseData['cf_refund_id'] ?? null;
            $cfPaymentId = $responseData['cf_payment_id'] ?? null;
            $amount = $responseData['refund_amount'] ?? 0;
            $status = strtolower($responseData['refund_status'] ?? Refund::STATUS_PENDING);

            // Check if refund already exists
            $existingRefund = Refund::where('refund_id', $refundId)
                ->orWhere('cf_refund_id', $cfRefundId)
                ->first();

            if ($existingRefund) {
                Log::info('Refund record already exists, updating instead', [
                    'refund_id' => $refundId,
                    'order_id' => $orderId
                ]);
                
                $existingRefund->update([
                    'status' => $status,
                    'refund_data' => $responseData,
                    'processed_at' => $status === Refund::STATUS_SUCCESS ? now() : null,
                ]);
                
                return;
            }

            // Create new refund record
            Refund::create([
                'order_id' => $orderId,
                'refund_id' => $refundId ?? 'REF-' . uniqid(),
                'cf_refund_id' => $cfRefundId,
                'cf_payment_id' => $cfPaymentId,
                'amount' => $amount,
                'status' => $status,
                'reason' => $refundNote,
                'refund_data' => $responseData,
                'processed_at' => $status === Refund::STATUS_SUCCESS ? now() : null,
            ]);

            ReverseOrder::where('order_id', $orderId)->update(['refund_request_added' => true]);

            // Update order status
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'order_status' => 'returned',
                    // 'refund_status' => $status === Refund::STATUS_SUCCESS ? 'completed' : 'processing',
                ]);
            }

            Log::info('Refund record saved successfully', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'cf_refund_id' => $cfRefundId,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save refund record', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            // Don't throw exception, just log the error
        }
    }

    /**
     * Save refund record by finding order from Cashfree order reference
     */
    protected function saveRefundRecordByOrderRef(string $cashfreeOrderRef, array $responseData, ?string $refundNote): void
    {
        try {
            // Try to find order by cashfree_order_ref or parse from the reference
            $order = Order::where('cashfree_order_ref', $cashfreeOrderRef)->first();
            
            if (!$order) {
                // Try to parse internal ID from CF_xxx_yyyy format
                if (preg_match('/CF_(\d+)_/', $cashfreeOrderRef, $matches)) {
                    $internalOrderId = $matches[1];
                    $order = Order::find($internalOrderId);
                }
            }

            if ($order) {
                $this->saveRefundRecord($order->id, $responseData, $cashfreeOrderRef, $refundNote);
            } else {
                Log::warning('Could not find order for refund record', [
                    'cashfree_order_ref' => $cashfreeOrderRef,
                    'response' => $responseData
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to save refund record by order ref', [
                'cashfree_order_ref' => $cashfreeOrderRef,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get refund status for a specific refund
     *
     * @param string $orderId
     * @param string $refundId
     * @return array
     * @throws \Exception
     */
    public function getRefundStatus(string $orderId, string $refundId): array
    {
        try {
            $endpoint = $this->baseUrl . '/pg/orders/' . $orderId . '/refunds/' . $refundId;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-version' => '2025-01-01',
                'x-client-id' => $this->clientId,
                'x-client-secret' => $this->clientSecret,
            ])->get($endpoint);

            if ($response->failed()) {
                throw new \Exception('Failed to get refund status: ' . $response->body());
            }

            $responseData = $response->json();

            // ✅ Update refund status in database if exists
            $this->updateRefundStatusFromApi($refundId, $responseData);

            return $responseData;

        } catch (\Exception $e) {
            Log::error('Cashfree refund status error', [
                'order_id' => $orderId,
                'refund_id' => $refundId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update refund status from API response
     */
    protected function updateRefundStatusFromApi(string $refundId, array $apiResponse): void
    {
        try {
            $refund = Refund::where('refund_id', $refundId)
                ->orWhere('cf_refund_id', $refundId)
                ->first();

            if (!$refund) {
                Log::warning('Refund not found for status update', ['refund_id' => $refundId]);
                return;
            }

            $newStatus = strtolower($apiResponse['refund_status'] ?? $refund->status);
            
            // Update refund record
            $refund->update([
                'status' => $newStatus,
                'refund_data' => array_merge($refund->refund_data ?? [], $apiResponse),
                'processed_at' => $newStatus === Refund::STATUS_SUCCESS ? now() : $refund->processed_at,
            ]);

            // Update order if refund is completed
            if ($newStatus === Refund::STATUS_SUCCESS) {
                $order = $refund->order;
                if ($order) {
                    $order->update([
                        'order_status' => 'refunded',
                        'refund_status' => 'completed',
                    ]);
                }
            }

            Log::info('Refund status updated from API', [
                'refund_id' => $refundId,
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update refund status from API', [
                'refund_id' => $refundId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get all refunds for an order
     *
     * @param string $orderId
     * @return array
     * @throws \Exception
     */
    public function getOrderRefunds(string $orderId): array
    {
        try {
            $endpoint = $this->baseUrl . '/pg/orders/' . $orderId . '/refunds';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-version' => '2025-01-01',
                'x-client-id' => $this->clientId,
                'x-client-secret' => $this->clientSecret,
            ])->get($endpoint);

            if ($response->failed()) {
                throw new \Exception('Failed to get order refunds: ' . $response->body());
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Cashfree order refunds error', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Process a full refund for an order
     *
     * @param Order $order
     * @param string|null $reason
     * @param string $refundSpeed
     * @return array
     * @throws \Exception
     */
    public function processFullRefund(Order $order, ?string $reason = null, string $refundSpeed = 'STANDARD'): array
    {
        // Get Cashfree order reference
        $cashfreeOrderRef = $order->cashfree_order_ref ?? 'CF_' . $order->id . '_' . strtotime($order->created_at);
        
        return $this->processRefund(
            $cashfreeOrderRef,
            $order->total_amount,
            null,
            $reason ?? 'Full refund for order #' . $order->id,
            $refundSpeed,
            $order->id
        );
    }

    /**
     * Process a partial refund for an order
     *
     * @param Order $order
     * @param float $amount
     * @param string|null $reason
     * @param string $refundSpeed
     * @return array
     * @throws \Exception
     */
    public function processPartialRefund(Order $order, float $amount, ?string $reason = null, string $refundSpeed = 'STANDARD'): array
    {
        // Validate amount
        if ($amount <= 0) {
            throw new \Exception('Refund amount must be greater than 0');
        }

        if ($amount > $order->total_amount) {
            throw new \Exception('Refund amount cannot exceed order total');
        }

        // Check if already refunded
        $totalRefunded = $order->refunds()
            ->where('status', Refund::STATUS_SUCCESS)
            ->sum('amount');

        if (($totalRefunded + $amount) > $order->total_amount) {
            throw new \Exception('Total refund amount cannot exceed order total');
        }

        // Get Cashfree order reference
        $cashfreeOrderRef = $order->cashfree_order_ref ?? 'CF_' . $order->id . '_' . strtotime($order->created_at);
        
        return $this->processRefund(
            $cashfreeOrderRef,
            $amount,
            null,
            $reason ?? 'Partial refund for order #' . $order->id,
            $refundSpeed,
            $order->id
        );
    }
}