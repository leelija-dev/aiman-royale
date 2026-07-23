@extends('layout.web.main-layout')

@section('title', 'Payment - Complete Your Order')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold mb-2">Complete Your Payment</h1>
                <p class="text-gray-600">Order ID: #{{ $orderId }}</p>
                <p class="text-xl font-semibold text-black mt-2">Total Amount: {{config('app.currency')}}{{ number_format($total, 2) }}</p>
            </div>

            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold mb-4">Select Payment Method</h2>
                
                <!-- Cash on Delivery Option -->
                <div class="mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-md flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Cash on Delivery (COD)</h3>
                                <p class="text-sm text-gray-600">Pay when you receive your order. Available for all orders.</p>
                            </div>
                        </div>
                        
                        <form id="cod-payment-form" method="POST" action="{{ route('checkout.cod.process') }}">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderId }}">
                            <input type="hidden" name="total" value="{{ $total }}">
                            <input type="hidden" name="currency" value="{{ $currency }}">
                            
                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition-colors font-medium">
                                    Place Order with COD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Cashfree Payment Option -->
                <div class="mb-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-600 rounded-md flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1.81.45 1.61 1.67 1.61 1.16 0 1.6-.64 1.6-1.46 0-.84-.68-1.22-2.05-1.71-1.61-.58-3.27-1.33-3.27-3.36 0-1.78 1.26-3.02 3.06-3.39V5h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.63-1.63-1.63-1.01 0-1.46.54-1.46 1.34 0 .74.54 1.1 1.93 1.58 1.68.58 3.39 1.32 3.39 3.5 0 1.84-1.31 3.11-3.12 3.46z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Cashfree Payment</h3>
                                <p class="text-sm text-gray-600">Pay securely using Credit Card, Debit Card, UPI, Net Banking & more</p>
                            </div>
                        </div>
                        
                        <form id="cashfree-payment-form" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderId }}">
                            <input type="hidden" name="total" value="{{ $total }}">
                            <input type="hidden" name="currency" value="{{ $currency }}">
                            
                            <div class="mt-4">
                                <button type="button" id="cashfree-pay-button" class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 transition-colors font-medium">
                                    Pay with Cashfree
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Payment Security Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Secure Payment</p>
                            <p>Your payment information is encrypted and secure. We never store your card details.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alternative Payment Methods -->
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-4">Or</p>
                <a href="{{ route('checkout.cancel') }}" class="text-blue-600 hover:text-blue-700 underline">
                    Cancel and return to checkout
                </a>
            </div>

            <!-- Order Summary -->
            <div class="border-t mt-6 pt-6">
                <h3 class="font-semibold mb-3">Order Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>{{config('app.currency')}}{{$total}}
                        {{-- <span>${{ number_format($total * 0.88, 2) }}</span> --}}
                    </div>
                    {{-- <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span>{{ $total > 0 ? '$7.00' : '$0.00' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax (5%)</span>
                        <span>${{ number_format($total * 0.05, 2) }}</span>
                    </div> --}}
                    <div class="flex justify-between font-semibold text-base pt-2 border-t">
                        <span>Total</span>
                        <span>{{config('app.currency')}}{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Load Cashfree SDK dynamically
    function loadCashfreeSDK() {
        return new Promise((resolve, reject) => {
            if (typeof Cashfree !== 'undefined') {
                resolve();
                return;
            }
            
            const script = document.createElement('script');
            // Try different SDK URLs
            const sdkUrls = [
                'https://sdk.cashfree.com/js/ui/2.0.0/cashfree.js',
                'https://sdk.cashfree.com/js/v3/cashfree.js',
                'https://cdn.cashfree.com/js/ui/2.0.0/cashfree.js'
            ];
            
            let urlIndex = 0;
            
            function tryLoadSDK() {
                if (urlIndex >= sdkUrls.length) {
                    reject(new Error('Failed to load Cashfree SDK from all URLs'));
                    return;
                }
                
                const script = document.createElement('script');
                script.src = sdkUrls[urlIndex];
                script.onload = () => {
                    console.log('Cashfree SDK loaded successfully from:', sdkUrls[urlIndex]);
                    resolve();
                };
                script.onerror = () => {
                    console.error('Failed to load Cashfree SDK from:', sdkUrls[urlIndex]);
                    urlIndex++;
                    tryLoadSDK();
                };
                document.head.appendChild(script);
            }
            
            tryLoadSDK();
        });
    }

    // Cashfree Payment Integration
    document.getElementById('cashfree-pay-button').addEventListener('click', async function() {
        const button = this;
        const originalText = button.textContent;
        
        // Show loading state
        button.disabled = true;
        button.textContent = 'Processing...';
        
        try {
            // Load Cashfree SDK first
            await loadCashfreeSDK();
            
            // Double-check if SDK is loaded
            if (typeof Cashfree === 'undefined') {
                throw new Error('Cashfree SDK failed to load. Please check your internet connection and try again.');
            }
            
            console.log('Cashfree SDK loaded successfully:', typeof Cashfree);
            
            // Get payment session from server
            const response = await fetch('{{ route("checkout.payment.session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    order_id: '{{ $orderId }}',
                    total: '{{ $total }}',
                    currency: '{{ $currency }}'
                })
            });
            
            const data = await response.json();
            
            if (data.success && data.payment_session_id) {
                console.log('Payment session created:', data.payment_session_id);
                
                // Initialize Cashfree payment - v3 API
                const cashfree = new Cashfree({
                    mode: 'sandbox',
                });
                
                console.log('Cashfree initialized, available methods:', Object.getOwnPropertyNames(cashfree));
                console.log('Cashfree initialized, opening payment modal...');
                
                // Try different payment methods for v3 SDK
                try {
                    // Method 1: Try checkout method (preferred for v3)
                    if (typeof cashfree.checkout === 'function') {
                        console.log('Using checkout method...');
                        cashfree.checkout({
                            paymentSessionId: data.payment_session_id,
                            onComplete: function(response) {
                                console.log('Payment completed:', response);
                                window.location.href = '{{ route("checkout.success") }}';
                            },
                            onError: function(error) {
                                console.error('Payment error:', error);
                                alert('Payment failed. Please try again.');
                                button.disabled = false;
                                button.textContent = originalText;
                            },
                            onClose: function() {
                                console.log('Payment modal closed');
                                button.disabled = false;
                                button.textContent = originalText;
                            }
                        });
                    }
                    // Method 2: Try pay method
                    else if (typeof cashfree.pay === 'function') {
                        console.log('Using pay method...');
                        cashfree.pay({
                            paymentSessionId: data.payment_session_id,
                            onComplete: function(response) {
                                console.log('Payment completed:', response);
                                window.location.href = '{{ route("checkout.success") }}';
                            },
                            onError: function(error) {
                                console.error('Payment error:', error);
                                alert('Payment failed. Please try again.');
                                button.disabled = false;
                                button.textContent = originalText;
                            },
                            onClose: function() {
                                console.log('Payment modal closed');
                                button.disabled = false;
                                button.textContent = originalText;
                            }
                        });
                    }
                    // Method 3: Try flowWisePay method
                    else if (typeof cashfree.flowWisePay === 'function') {
                        console.log('Using flowWisePay method...');
                        cashfree.flowWisePay({
                            paymentSessionId: data.payment_session_id,
                            onComplete: function(response) {
                                console.log('Payment completed:', response);
                                window.location.href = '{{ route("checkout.success") }}';
                            },
                            onError: function(error) {
                                console.error('Payment error:', error);
                                alert('Payment failed. Please try again.');
                                button.disabled = false;
                                button.textContent = originalText;
                            },
                            onClose: function() {
                                console.log('Payment modal closed');
                                button.disabled = false;
                                button.textContent = originalText;
                            }
                        });
                    }
                    // Method 4: Try redirect method
                    else if (typeof cashfree.redirect === 'function') {
                        console.log('Using redirect method...');
                        cashfree.redirect({
                            paymentSessionId: data.payment_session_id,
                            redirectTarget: "_self"
                        });
                    }
                    else {
                        throw new Error('No valid payment method found in Cashfree SDK');
                    }
                } catch (paymentError) {
                    console.error('Payment method error:', paymentError);
                    alert('Payment method error: ' + paymentError.message);
                    button.disabled = false;
                    button.textContent = originalText;
                }
            } else {
                throw new Error(data.message || 'Failed to initiate payment');
            }
        } catch (error) {
            console.error('Payment initiation error:', error);
            
            // Provide more specific error messages
            if (error.message.includes('SDK')) {
                alert('Unable to load payment gateway. Please refresh the page and try again.');
            } else if (error.message.includes('Failed to fetch')) {
                alert('Network error. Please check your internet connection and try again.');
            } else {
                alert('Payment initiation failed: ' + error.message);
            }
            
            button.disabled = false;
            button.textContent = originalText;
        }
    });
</script>
@endsection
