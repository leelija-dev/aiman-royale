@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold mb-2">Complete Your Payment</h1>
                <p class="text-gray-600">Order ID: #{{ $orderId }}</p>
                <p class="text-xl font-semibold text-black mt-2">Total Amount: ${{ number_format($total, 2) }}</p>
            </div>

            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold mb-4">Select Payment Method</h2>
                
                <!-- PayPal Payment Option -->
                <div class="mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-md flex items-center justify-center mr-4">
                                <i class="fab fa-paypal text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">PayPal</h3>
                                <p class="text-sm text-gray-600">Pay securely with your PayPal account</p>
                            </div>
                        </div>
                        
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                            <!-- PayPal Business Information -->
                            <input type="hidden" name="business" value="your-business-email@example.com">
                            
                            <!-- Order Information -->
                            <input type="hidden" name="item_name" value="Order #{{ $orderId }}">
                            <input type="hidden" name="item_number" value="{{ $orderId }}">
                            <input type="hidden" name="amount" value="{{ number_format($total, 2) }}">
                            <input type="hidden" name="currency_code" value="{{ $currency }}">
                            
                            <!-- Payment Details -->
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="lc" value="US">
                            <input type="hidden" name="bn" value="PP_BuyNow_BN">
                            
                            <!-- Return URLs -->
                            <input type="hidden" name="return" value="{{ route('checkout.success') }}">
                            <input type="hidden" name="cancel_return" value="{{ route('checkout.cancel') }}">
                            <input type="hidden" name="notify_url" value="{{ route('checkout.success') }}">
                            
                            <!-- Custom Data -->
                            <input type="hidden" name="custom" value="{{ auth()->id() }}:{{ $orderId }}">
                            
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fab fa-paypal mr-2"></i>
                                Pay with PayPal
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Alternative Payment Methods -->
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-4">Or</p>
                    <a href="{{ route('checkout.cancel') }}" class="text-blue-600 hover:text-blue-700 underline">
                        Cancel and return to checkout
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t mt-6 pt-6">
                <h3 class="font-semibold mb-3">Order Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>${{ number_format($total * 0.88, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span>$7.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span>${{ number_format($total * 0.05, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-base pt-2 border-t">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Auto-redirect to success page after PayPal payment simulation
    // In production, this would be handled by PayPal IPN
    setTimeout(function() {
        // This is just for demo - remove in production
        console.log('Payment page loaded');
    }, 1000);
</script>
@endsection
