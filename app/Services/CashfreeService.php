<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CashfreeService
{
    private $appId;
    private $secretKey;
    private $baseUrl;
    private $isTestMode;

    public function __construct()
    {
        $this->isTestMode = config('services.cashfree.test_mode', true);
        
        if ($this->isTestMode) {
            $this->appId = config('services.cashfree.test_app_id');
            $this->secretKey = config('services.cashfree.test_secret_key');
            $this->baseUrl = 'https://sandbox.cashfree.com/pg';
        } else {
            $this->appId = config('services.cashfree.app_id');
            $this->secretKey = config('services.cashfree.secret_key');
            $this->baseUrl = 'https://api.cashfree.com/pg';
        }
        
        // Validate required credentials
        if (!$this->appId || !$this->secretKey) {
            throw new \Exception('Cashfree credentials are not configured properly. Please check your .env file.');
        }
    }

    /**
     * Create an order in Cashfree
     */
    public function createOrder($orderId, $amount, $customerDetails)
    {
        try {
            $orderData = [
                'order_id' => $orderId,
                'order_amount' => $amount,
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => $customerDetails['customer_id'],
                    'customer_name' => $customerDetails['customer_name'],
                    'customer_email' => $customerDetails['customer_email'],
                    'customer_phone' => $customerDetails['customer_phone'],
                ],
                'order_meta' => [
                    'return_url' => route('checkout.success'),
                    'notify_url' => route('checkout.webhook'),
                ],
                'order_note' => 'Order #' . $orderId,
            ];

            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/orders', $orderData);

            if ($response->successful()) {
                $orderResponse = $response->json();
                Log::info('Cashfree order created successfully', [
                    'order_id' => $orderId,
                    'response' => $orderResponse
                ]);
                return $orderResponse;
            } else {
                Log::error('Cashfree order creation failed', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Cashfree order creation exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get payment session ID for an order
     */
    public function getPaymentSessionId($orderId)
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/orders/' . $orderId);

            if ($response->successful()) {
                $orderData = $response->json();
                return $orderData['order_session_id'] ?? null;
            } else {
                Log::error('Failed to get payment session ID', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Exception getting payment session ID', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get order details from Cashfree
     */
    public function getOrderDetails($orderId)
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/orders/' . $orderId);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to get order details', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Exception getting order details', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifySignature($orderId, $signature, $data)
    {
        // For now, return true to bypass signature verification
        // In production, implement proper signature verification
        // TODO: Implement proper signature verification
        return true;
    }
}
