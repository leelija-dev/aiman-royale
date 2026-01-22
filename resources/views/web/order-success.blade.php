@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-green-600 text-3xl"></i>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-semibold mb-4">Payment Successful!</h1>
            <p class="text-gray-600 mb-8">Thank you for your order. We've received your payment and will process your order shortly.</p>

            <!-- Order Information -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="font-semibold mb-4">Order Details</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Status:</span>
                        <span class="font-medium text-green-600">Paid</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium">PayPal</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium">{{ now()->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mb-8">
                <h2 class="font-semibold mb-3">What's Next?</h2>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-blue-600 mt-1 mr-3"></i>
                        <p>You'll receive an order confirmation email shortly</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-box text-blue-600 mt-1 mr-3"></i>
                        <p>We'll process your order within 1-2 business days</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-truck text-blue-600 mt-1 mr-3"></i>
                        <p>You'll receive tracking information once shipped</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('page.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition-colors font-medium">
                    Continue Shopping
                </a>
                <div class="text-sm">
                    <a href="#" class="text-blue-600 hover:text-blue-700 underline">
                        View Order History
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
