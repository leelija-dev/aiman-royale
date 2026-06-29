<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
     * @param string $orderId - The Cashfree Order ID
     * @param float $amount - Refund amount
     * @param string $refundId - Unique refund ID (optional)
     * @param string $refundNote - Refund note (optional)
     * @param string $refundSpeed - STANDARD or INSTANT (default: STANDARD)
     * @return array
     * @throws \Exception
     */
    public function processRefund(
        string $orderId, 
        float $amount, 
        ?string $refundId = null, 
        ?string $refundNote = null,
        string $refundSpeed = 'STANDARD'
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
                'endpoint' => $endpoint
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
            if (!isset($responseData['refund_id']) && !isset($responseData['refund']['refund_id'])) {
                Log::error('Unexpected refund response structure', ['response' => $responseData]);
                throw new \Exception('Refund response format unexpected');
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

            return $response->json();

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
}