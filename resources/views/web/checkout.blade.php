@extends('layout.web.main-layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('web/css/checkout.css') }}">
@endsection
@section('content')
<section class="checkout-page px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
    <div class="container mx-auto">
        <nav class="checkout-steps" aria-label="Checkout progress">
            <a href="{{ route('cart.index') }}" class="checkout-step is-done">
                <span class="checkout-step-dot" aria-hidden="true">✓</span>
                <span class="checkout-step-label">Cart</span>
            </a>
            <span class="checkout-step-line is-done" aria-hidden="true"></span>
            <span class="checkout-step is-current">
                <span class="checkout-step-dot" aria-hidden="true">2</span>
                <span class="checkout-step-label">Shipping</span>
            </span>
            <span class="checkout-step-line" aria-hidden="true"></span>
            <span class="checkout-step">
                <span class="checkout-step-dot" aria-hidden="true">3</span>
                <span class="checkout-step-label">Payment</span>
            </span>
        </nav>
        <div class="checkout-layout flex flex-col lgg:flex-row gap-8">
            <!-- Left Column: Shipping Form -->
            <div class="checkout-form-card flex-1">
               @php
    $isBuyNow = session()->has('checkout_source') && 
                session()->get('checkout_source') === 'buy_now';
@endphp

@if($isBuyNow)
    <button type="button" class="checkout-back-btn" 
        onclick="clearBuyNowAndRedirect()"
        id="back-to-product-btn">
        <i class="fas fa-arrow-left"></i> Back to product
    </button>
@endif
                @php
                $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
                $fullName = optional($defaultAddress)->full_name ?? (auth()->user()->name ?? '');
                $nameParts = preg_split('/\s+/', trim($fullName), 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                if ($lastName === '' && $firstName !== '') {
                    $lastName = $firstName;
                }
                $previewPhone = optional($defaultAddress)->phone ?? old('phone');
                $previewEmail = auth()->user()->email ?? '';
                $previewAddress1 = optional($defaultAddress)->address_1 ?? old('address1');
                $previewAddress2 = optional($defaultAddress)->address_2 ?? old('address2');
                $previewCity = optional($defaultAddress)->city ?? old('city');
                $previewState = optional($defaultAddress)->state ?? old('state');
                $previewPin = optional($defaultAddress)->pincode ?? old('pinCode');
                $hasPreviewAddress = filled($previewAddress1);
                @endphp
                <div class="checkout-address-head">
                    <div>
                        <h1 class="checkout-title">Shipping Address</h1>
                        <p class="checkout-subtitle">Enter your delivery details to place the order.</p>
                    </div>
                    <button type="button" class="checkout-address-change-btn" id="checkout-address-change-btn">Change</button>
                </div>
                <div class="checkout-address-preview" id="checkout-address-preview">
                    <div id="checkout-preview-details" class="{{ $hasPreviewAddress ? '' : 'hidden' }}">
                        <p class="checkout-address-name" id="checkout-preview-name">{{ trim($firstName . ' ' . $lastName) }}</p>
                        <p class="checkout-address-meta" id="checkout-preview-phone">{{ $previewPhone }}</p>
                        <p class="checkout-address-line" id="checkout-preview-street">{{ $previewAddress1 }}{{ $previewAddress2 ? ', ' . $previewAddress2 : '' }}</p>
                        <p class="checkout-address-line" id="checkout-preview-city">{{ collect([$previewCity, $previewState])->filter()->implode(', ') }}{{ $previewPin ? ' ' . $previewPin : '' }}</p>
                        <p class="checkout-address-meta" id="checkout-preview-email">{{ $previewEmail }}</p>
                    </div>
                    <p class="checkout-address-empty{{ $hasPreviewAddress ? ' hidden' : '' }}" id="checkout-preview-empty">Add your delivery address</p>
                </div>
                {{-- @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif --}}

            <form id="checkout-form" action="{{ route('checkout.place') }}" method="post"
                enctype="multipart/form-data" class="space-y-6" novalidate>
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name<sup
                                class="text-danger" style="color: red">*</sup></label>
                        <input type="text" name="firstName" id="firstName" value="{{ $firstName }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            required minlength="2" maxlength="50" />
                        <p id="firstName-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid first
                            name (minimum 2 characters)</p>
                        <p id="firstName-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid first name</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name<sup
                                class="text-danger" style="color: red">*</sup></label>
                        <input type="text" name="lastName" id="lastName" value="{{ $lastName }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            required minlength="2" maxlength="50" />
                        <p id="lastName-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid last
                            name (minimum 2 characters)</p>
                        <p id="lastName-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid last name</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email<sup class="text-danger"
                                style="color: red">*</sup></label>
                        <input type="email" name="email" id="email"
                            value="{{ auth()->user()->email ?? '' }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            required />
                        <p id="email-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid email
                            address</p>
                        <p id="email-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid email</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone No<sup class="text-danger"
                                style="color: red">*</sup></label>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <select name="country_code_dummy"
                                    class="h-full px-3 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-black bg-gray-50 cursor-not-allowed"
                                    disabled aria-disabled="true">
                                    <option value="+91" selected>🇮🇳 +91</option>
                                </select>
                                <input type="hidden" name="country_code_dummy" value="+91" disabled>
                            </div>
                            <input type="tel" name="phone" id="phone"
                                value="{{ optional($defaultAddress)->phone ?? old('phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-black"
                                placeholder="Enter 10 digit phone number" required maxlength="10"
                                inputmode="numeric" />
                        </div>
                        <p id="phone-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid 10-digit
                            phone number</p>
                        <p id="phone-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid phone number</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address 1<sup class="text-danger"
                            style="color: red">*</sup></label>
                    <input type="text" name="address1" id="address1"
                        value="{{ optional($defaultAddress)->address_1 ?? old('address1') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                        placeholder="Street address" required minlength="5" />
                    <p id="address1-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid address
                        (minimum 5 characters)</p>
                    <p id="address1-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid address</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address 2 (optional)</label>
                    <input type="text" name="address2" id="address2"
                        value="{{ optional($defaultAddress)->address_2 ?? old('address2') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                        placeholder="Apartment, suite, etc." />
                </div>

                <div class="checkout-city-grid grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City<sup class="text-danger"
                                style="color: red">*</sup></label>
                        <input type="text" name="city" id="city"
                            value="{{ optional($defaultAddress)->city ?? old('city') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            required minlength="2" />
                        <p id="city-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid city name
                        </p>
                        <p id="city-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid city</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State<sup class="text-danger"
                                style="color: red">*</sup></label>
                        <input type="text" name="state" id="state"
                            value="{{ optional($defaultAddress)->state ?? old('state') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            required minlength="2" />
                        <p id="state-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid state
                            name</p>
                        <p id="state-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid state</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pin Code<sup
                                class="text-danger" style="color: red">*</sup></label>
                        <input type="text" name="pinCode" id="pinCode"
                            value="{{ optional($defaultAddress)->pincode ?? old('pinCode') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Enter 6 digit pincode" required maxlength="6" inputmode="numeric" />
                        <p id="pincode-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid
                            6-digit pincode</p>
                        <p id="pincode-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid pincode</p>
                        @error('pinCode')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                        placeholder="Enter a description...">{{ old('description') }}</textarea>
                </div>
                <input type="hidden" name="applied_coupons" id="applied-coupons">
            </form>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="xl:w-102 lgg:w-96 w-full">
            <div class="checkout-summary-card">
                <h2 class="checkout-summary-title">Order Summary</h2>

                <div class="space-y-6 mb-6">

                    @if ($carts->count() > 0)
                    @php
                    $total = 0;
                    // dd($carts);
                    @endphp

                    @foreach ($carts as $cart)
                    @php
                        $appliedCoupons = session('applied_coupons', []);
                        // Get coupon for THIS variant only
                        $appliedCoupon = $appliedCoupons[$cart->variant_id] ?? null;
                        $couponForThisVariant = $appliedCoupon !== null;
                        $currentPrice = $cart->price - (($cart->price * $cart->discount) / 100);
                        // dd($appliedCoupons);
                    @endphp
                  
                    @php
                            $productTotal = ($cart->price - ($cart->price * $cart->discount) / 100) * $cart->count;
                    @endphp
                    <div class="checkout-item-row">
                        <div class="checkout-cell-product">
                            <div class="checkout-product-img">
                                @if ($cart->image)
                                <img src="{{ url('img/' . $cart->image) }}" alt="{{ $cart->name }}">
                                @endif
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $cart->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Size: {{ $cart->size ?? 'One Size' }}, Color: {{ $cart->color ?? 'Default' }}
                                </p>
                            </div>
                        </div>

                        <div class="checkout-cell-qty">
                            Qty: {{ $cart->count }}
                        </div>

                        <div class="checkout-cell-amount">
                            <span id="product-original-{{ $cart->cart_id }}"
                                class="text-gray-400 line-through mr-1 hidden">
                                {{ config('app.currency') }}{{ number_format($productTotal, 2) }}
                            </span>
                            <span id="product-total-{{ $cart->cart_id }}" class="font-semibold">
                                {{ config('app.currency') }}{{ number_format($productTotal, 2) }}
                            </span>
                            <span id="product-savings-{{ $cart->cart_id }}" class="text-green-600 text-xs ml-1 hidden"></span>
                        </div>

                        <div class="checkout-coupon">
                                    <input type="text"
                                        id="coupon-{{ $cart->cart_id }}"
                                        value="{{ $appliedCoupon['code'] ?? '' }}"
                                        data-variant-id="{{ $cart->variant_id }}"
                                        data-product-total="{{ $productTotal }}"
                                        class="w-28 border border-gray-300 rounded-md px-2 py-1 text-xs"
                                        placeholder="Coupon">

                                <button id="apply-btn-{{ $cart->cart_id }}" type="button"
                                    onclick="applyCoupon({{ $cart->cart_id }}, {{ $productTotal }},{{ $cart->variant_id }})"
                                    class="px-3 py-1 bg-black text-white rounded-md text-xs">
                                    Apply
                                </button>
                        </div>
                            {{-- @if($appliedCoupon && !empty($appliedCoupon['code']))
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Automatically call backend only if session coupon exists
    applyCoupon(
        {{ $cart->cart_id }},
        {{ $productTotal }},
        {{ $cart->variant_id }}
    );

});
</script>
@endif --}}
                            <p id="coupon-message-{{ $cart->cart_id }}" class="text-sm mt-2 checkout-coupon-msg"></p>
                    </div>



                    @php
                    $total +=
                    ($cart->price - ($cart->price * $cart->discount) / 100) * $cart->count;
                    $shippingCost = 0;
                    if ($total <= 400) {
                        $shippingCost=0;
                        }
                        @endphp
                        @endforeach
                        @else
                        <p class="text-gray-500 text-center py-4">Your cart is empty</p>
                        @endif
                </div>
            </div>

            @php
                $savingCoupons = \App\Models\Coupon::where('is_active', true)
                    ->where(function ($query) {
                        $query->whereNull('expiry_date')
                            ->orWhere('expiry_date', '>=', now());
                    })
                    ->orderByRaw("CASE WHEN code_type = 'special-discount' THEN 0 ELSE 1 END")
                    ->orderByDesc('discount')
                    ->get();
                $sessionAppliedCodes = collect(session('applied_coupons', []))
                    ->pluck('code')
                    ->filter()
                    ->map(function ($code) {
                        return strtoupper(trim($code));
                    })
                    ->unique();
                $specialIsApplied = $coupon
                    && ($coupon->minimum_amount ?? 0) <= ($total ?? 0);
                $appliedSavingCoupons = $savingCoupons->filter(function ($savingCoupon) use ($sessionAppliedCodes, $specialIsApplied) {
                    if ($savingCoupon->code_type === 'special-discount') {
                        return $specialIsApplied;
                    }
                    return $sessionAppliedCodes->contains(strtoupper(trim($savingCoupon->code)));
                });
                $otherSavingCoupons = $savingCoupons->reject(function ($savingCoupon) use ($appliedSavingCoupons) {
                    return $appliedSavingCoupons->contains('id', $savingCoupon->id);
                });
            @endphp
            <div class="checkout-saving-card">
                <h2 class="checkout-saving-title">
                    <img src="{{ asset('web/images/icons/saving-zone-wow.png') }}" alt="" class="checkout-saving-icon">
                    Saving zone
                </h2>
                <div class="checkout-saving-list">
                    @forelse($appliedSavingCoupons as $savingCoupon)
                    <div class="checkout-saving-item is-applied">
                        <div class="checkout-saving-info">
                            <p class="checkout-saving-code">{{ $savingCoupon->code }}</p>
                            <p class="checkout-saving-desc">
                                {{ rtrim(rtrim(number_format((float) $savingCoupon->discount, 2), '0'), '.') }}% off
                                @if($savingCoupon->code_for)
                                    · {{ $savingCoupon->code_for }}
                                @elseif($savingCoupon->name)
                                    · {{ $savingCoupon->name }}
                                @endif
                            </p>
                            @if($savingCoupon->code_type !== 'special-discount')
                            <p class="checkout-saving-note">Applied on item</p>
                            @endif
                        </div>
                        @if($savingCoupon->code_type === 'special-discount')
                        <span class="checkout-saving-applied">Applied</span>
                        @else
                        <button type="button" class="checkout-saving-unapply" data-code="{{ $savingCoupon->code }}">Remove</button>
                        @endif
                    </div>
                    @empty
                    @if($otherSavingCoupons->isEmpty())
                    <p class="checkout-saving-empty">No coupon available right now</p>
                    @endif
                    @endforelse

                    @if($otherSavingCoupons->isNotEmpty())
                    <details class="checkout-saving-more">
                        <summary class="checkout-saving-more-toggle">
                            <span>View all coupons and offers</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </summary>
                        <div class="checkout-saving-more-list">
                            @foreach($otherSavingCoupons as $savingCoupon)
                            <div class="checkout-saving-item">
                                <div class="checkout-saving-info">
                                    <p class="checkout-saving-code">{{ $savingCoupon->code }}</p>
                                    <p class="checkout-saving-desc">
                                        {{ rtrim(rtrim(number_format((float) $savingCoupon->discount, 2), '0'), '.') }}% off
                                        @if($savingCoupon->code_for)
                                            · {{ $savingCoupon->code_for }}
                                        @elseif($savingCoupon->name)
                                            · {{ $savingCoupon->name }}
                                        @endif
                                    </p>
                                    @if($savingCoupon->code_type === 'special-discount')
                                    <p class="checkout-saving-note">
                                        Auto applied on orders above {{ config('app.currency') }}{{ number_format($savingCoupon->minimum_amount, 2) }}
                                    </p>
                                    @else
                                    <p class="checkout-saving-note">Use this code in the item coupon box</p>
                                    @endif
                                </div>
                                @if($savingCoupon->code_type !== 'special-discount')
                                <button type="button" class="checkout-saving-apply" data-code="{{ $savingCoupon->code }}">Apply</button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </details>
                    @endif
                </div>
            </div>

            <div class="checkout-price-card">
                <h2 class="checkout-price-title">Price details</h2>
                <div class="checkout-totals space-y-3">
                    {{-- <div class="flex items-center gap-3">
                                <input type="text" placeholder="Discount code"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none w-full" />
                                <button class="px-6 py-3 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                    Apply
                                </button>
                            </div> --}}

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            
                            <span class="text-gray-600">Subtotal</span>
                            {{-- <span>{{config('app.currency')}}{{ number_format($total, 2) }}</span> --}}
                            <span id="subtotal-original" class="text-gray-800 " style="font-weight: bold;">
                                    {{ config('app.currency') }}<span id="subtotal-original-amount">{{ number_format($total, 2, '.', '') }}</span>
                                </span>
                            <span class="hidden">
                                {{ config('app.currency') }}
                                <span id="subtotal" data-original="{{ $total }}">
                                    {{ number_format($total, 2, '.', '') }}
                                </span>
                            </span>
                        </div>
                        <div id="coupon-savings-row" class="flex justify-between hidden">
                            <span class="text-green-600 text-sm">Coupon savings</span>
                            <span class="text-green-600 text-sm font-medium">
                                - {{ config('app.currency') }}<span id="coupon-savings-amount">0.00</span>
                            </span>
                        </div>
                        <div class="flex justify-between items-start">
                            @if ($coupon)
                            @if ($coupon->minimum_amount <= $total)

                                <div class="flex justify-between w-full">

                                <div class="relative">

                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600 font-medium">
                                            Special Discount ({{ $coupon->discount }}%)
                                        </span>

                                        <button
                                            type="button"
                                            onclick="toggleSpecialTerms()"
                                            class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                            <i class="fa fa-circle-info"></i>
                                        </button>
                                    </div>

                                    @if(optional($coupon)->code_for)
                                    <div class="text-xs text-pink-500">
                                        {{ $coupon->code_for }}
                                    </div>
                                    @endif

                                    <!-- Popup -->
                                    <div id="special-terms"
                                        class="absolute left-0 top-full mt-2 w-72 bg-white border border-gray-200 shadow-lg rounded-lg p-3 text-xs text-gray-600 opacity-0 invisible transition-all duration-300 z-50">



                                        <p class="mt-2">
                                            You have got
                                            <strong>{{ $coupon->discount }}%</strong>
                                            discount on orders above
                                            <strong>{{ config('app.currency') }}{{ number_format($coupon->minimum_amount,2) }}</strong>.
                                        </p>

                                    </div>

                                </div>

                                <span class="font-medium whitespace-nowrap">
                                    - {{ config('app.currency') }}
                                    <span id="special-discount">0</span>
                                </span>

                        </div>

                        @endif
                        @endif
                    </div>


                    <div class="flex justify-between">
                        @php
                        if ($store) {
                        $gst_percentage = $store->gst_percentage ? $store->gst_percentage : 0;
                        } else {
                        $gst_percentage = 0;
                        }
                        @endphp

                        <span class="text-gray-600">GST({{ $gst_percentage ? $gst_percentage : 0 }}%)</span>


                        <span>
                            {{ config('app.currency') }}
                            <span id="gst">
                                {{ number_format(($total * ($gst_percentage ?? 0)) / 100, 2, '.', '') }}
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        {{-- <span>{{config('app.currency')}}{{$shippingCost}}</span> --}}
                        <span>
                            {{ config('app.currency') }}
                            <span id="shipping">{{ $shippingCost }}</span>
                        </span>
                    </div>

                    <div class="flex justify-between font-semibold text-base pt-2 border-t">
                        <span>Total <span style="font-size: 12px;">(round off)</span></span>
                        {{-- <span>{{config('app.currency')}}{{ number_format($total+$shippingCost, 2) }}</span> --}}
                        <span>
                            {{ config('app.currency') }}
                            <span
                                id="grand-total">{{ number_format($total + $shippingCost + ($total * ($gst_percentage ? $gst_percentage : 0)) / 100, 2) }}</span>
                        </span>
                        {{-- <input type="hidden" id="grand-total-hidden" name="grand_total" value="{{ $total + $shippingCost }}"> --}}
                        <input type="hidden" id="grand-total-hidden" name="grand_total"
                            value="{{ $total + ($total * ($gst_percentage ? $gst_percentage : 0)) / 100, 2 }}"
                            form="checkout-form">

                        <input type="hidden" id="gst-percentage" name="gst_percentage"
                            value="{{ $gst_percentage ?? 0 }}" form="checkout-form">

                        <input type="hidden" id="gst-amount" name="gst_amount"
                            value="{{ ($total * ($gst_percentage ?? 0)) / 100 ?? 0 }}" form="checkout-form">
                        <!-- special discount-->
                        <input type="hidden" id="special-discount-hidden" name="special_discount"
                            value="0" form="checkout-form">

                        <input type="hidden"
                            id="special-discount-hidden"
                            name="special_discount"
                            value="0"
                            form="checkout-form">

                        <input type="hidden"
                            id="special-discount-id"
                            name="special_discount_id"
                            value="{{ $coupon->id ?? '' }}"
                            form="checkout-form">

                        <input type="hidden"
                            id="special-discount-percentage"
                            name="special_discount_percentage"
                            value="{{ $coupon->discount ?? 0 }}"
                            form="checkout-form">

                        <input type="hidden"
                            id="special-discount-name"
                            name="special_discount_name"
                            value="{{ $coupon->code ?? '' }}"
                            form="checkout-form">

                        <input type="hidden"
                            id="special-discount-amount"
                            name="special_discount_amount"
                            value="{{ $coupon->code ?? '' }}"
                            form="checkout-form">

                    </div>
                </div>

                <button type="button" onclick="submitForm()"
                    class="checkout-place-btn w-full mt-6 py-4 bg-black text-white font-medium rounded-md hover:bg-gray-900 transition"
                    @if ($carts->count() == 0) disabled @endif>
                    @if ($carts->count() > 0)
                    Place Order
                    @else
                    Cart is Empty
                    @endif
                </button>
                <p class="checkout-secure">Secure checkout · GST invoice available</p>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="checkout-address-sheet" id="checkout-address-sheet" aria-hidden="true">
        <div class="checkout-address-sheet-backdrop" id="checkout-address-sheet-backdrop"></div>
        <div class="checkout-address-sheet-panel" role="dialog" aria-modal="true" aria-labelledby="checkout-address-sheet-title">
            <div class="checkout-address-sheet-handle"></div>
            <div class="checkout-address-sheet-head">
                <h2 id="checkout-address-sheet-title">Select address</h2>
                <button type="button" class="checkout-address-sheet-close" id="checkout-address-sheet-close" aria-label="Close">&times;</button>
            </div>

            <div id="checkout-address-sheet-list">
                @forelse($addresses as $address)
                <div class="checkout-address-option{{ $address->is_default ? ' is-selected' : '' }}"
                    data-id="{{ $address->id }}"
                    data-full-name="{{ $address->full_name }}"
                    data-phone="{{ $address->phone }}"
                    data-address-1="{{ $address->address_1 }}"
                    data-address-2="{{ $address->address_2 }}"
                    data-city="{{ $address->city }}"
                    data-state="{{ $address->state }}"
                    data-pincode="{{ $address->pincode }}">
                    <input type="radio"
                        name="checkout_shipping_address"
                        class="checkout-address-radio"
                        value="{{ $address->id }}"
                        {{ $address->is_default ? 'checked' : '' }}>
                    <div class="checkout-address-option-body">
                        <span class="checkout-address-option-name">
                            <span>{{ $address->full_name }}</span>
                            @if($address->is_default)
                            <span class="checkout-address-option-badge">Default</span>
                            @elseif($address->address_type)
                            <span class="checkout-address-option-badge">{{ ucfirst($address->address_type) }}</span>
                            @endif
                        </span>
                        @if($address->phone)
                        <span>{{ $address->phone }}</span><br>
                        @endif
                        <span>{{ $address->address_1 }}{{ $address->address_2 ? ', ' . $address->address_2 : '' }}</span><br>
                        <span>{{ collect([$address->city, $address->state])->filter()->implode(', ') }}{{ $address->pincode ? ' ' . $address->pincode : '' }}</span>
                    </div>
                    <button type="button" class="checkout-address-edit-btn" aria-label="Edit address">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                </div>
                @empty
                <p class="checkout-address-empty-list">No saved addresses yet.</p>
                @endforelse
                <button type="button" class="checkout-address-add-btn" id="checkout-address-add-btn">+ Add new address</button>
            </div>

            <div id="checkout-address-sheet-form" class="checkout-address-new-form hidden">
                <input type="hidden" id="checkout-new-address-id" value="">
                <p id="checkout-address-form-error" class="checkout-address-form-error hidden"></p>
                <label for="checkout-new-firstName">First Name</label>
                <input type="text" id="checkout-new-firstName" maxlength="50" autocomplete="given-name">
                <label for="checkout-new-lastName">Last Name</label>
                <input type="text" id="checkout-new-lastName" maxlength="50" autocomplete="family-name">
                <label for="checkout-new-phone">Phone No</label>
                <input type="tel" id="checkout-new-phone" maxlength="10" inputmode="numeric" autocomplete="tel">
                <label for="checkout-new-address1">Address 1</label>
                <input type="text" id="checkout-new-address1" autocomplete="address-line1">
                <label for="checkout-new-address2">Address 2 (optional)</label>
                <input type="text" id="checkout-new-address2" autocomplete="address-line2">
                <label for="checkout-new-city">City</label>
                <input type="text" id="checkout-new-city" autocomplete="address-level2">
                <label for="checkout-new-state">State</label>
                <input type="text" id="checkout-new-state" autocomplete="address-level1">
                <label for="checkout-new-pinCode">Pin Code</label>
                <input type="text" id="checkout-new-pinCode" maxlength="6" inputmode="numeric" autocomplete="postal-code">
                <div class="checkout-address-new-actions">
                    <button type="button" class="checkout-address-form-back" id="checkout-address-form-back">Back</button>
                    <button type="button" class="checkout-address-form-save" id="checkout-address-form-save">Use this address</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function() {
        'use strict'

        // Get all form fields
        const form = document.getElementById('checkout-form');
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const address1 = document.getElementById('address1');
        const city = document.getElementById('city');
        const state = document.getElementById('state');
        const pincode = document.getElementById('pinCode');

        // Get error and success elements
        const firstNameError = document.getElementById('firstName-error');
        const firstNameSuccess = document.getElementById('firstName-success');
        const lastNameError = document.getElementById('lastName-error');
        const lastNameSuccess = document.getElementById('lastName-success');
        const emailError = document.getElementById('email-error');
        const emailSuccess = document.getElementById('email-success');
        const phoneError = document.getElementById('phone-error');
        const phoneSuccess = document.getElementById('phone-success');
        const address1Error = document.getElementById('address1-error');
        const address1Success = document.getElementById('address1-success');
        const cityError = document.getElementById('city-error');
        const citySuccess = document.getElementById('city-success');
        const stateError = document.getElementById('state-error');
        const stateSuccess = document.getElementById('state-success');
        const pincodeError = document.getElementById('pincode-error');
        const pincodeSuccess = document.getElementById('pincode-success');

        // Validation functions
        function validateName(value) {
            const trimmed = value.trim();
            return trimmed.length >= 2 && /^[a-zA-Z\s]+$/.test(trimmed);
        }

        function validateEmail(value) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }

        function validatePhone(value) {
            const numericValue = value.replace(/\D/g, '');
            return /^[0-9]{10}$/.test(numericValue);
        }

        function validateAddress(value) {
            return value.trim().length >= 5;
        }

        function validateCityState(value) {
            const trimmed = value.trim();
            return trimmed.length >= 2 && /^[a-zA-Z\s]+$/.test(trimmed);
        }

        function validatePincode(value) {
            const numericValue = value.replace(/\D/g, '');
            return /^[0-9]{6}$/.test(numericValue);
        }

        // Generic validation function for input fields
        function validateField(input, errorEl, successEl, validationFn, errorMessage) {
            const value = input.value;

            if (value.trim().length === 0) {
                errorEl.classList.add('hidden');
                successEl.classList.add('hidden');
                input.classList.remove('border-red-500', 'border-green-500');
                return false;
            }

            const isValid = validationFn(value);

            if (isValid) {
                errorEl.classList.add('hidden');
                successEl.classList.remove('hidden');
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
                return true;
            } else {
                errorEl.classList.remove('hidden');
                successEl.classList.add('hidden');
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
                return false;
            }
        }

        // Real-time validation for all fields
        firstName.addEventListener('input', function() {
            validateField(this, firstNameError, firstNameSuccess, validateName);
        });

        lastName.addEventListener('input', function() {
            validateField(this, lastNameError, lastNameSuccess, validateName);
        });

        email.addEventListener('input', function() {
            validateField(this, emailError, emailSuccess, validateEmail);
        });

        phone.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
            validateField(this, phoneError, phoneSuccess, validatePhone);
        });

        address1.addEventListener('input', function() {
            validateField(this, address1Error, address1Success, validateAddress);
        });

        city.addEventListener('input', function() {
            validateField(this, cityError, citySuccess, validateCityState);
        });

        state.addEventListener('input', function() {
            validateField(this, stateError, stateSuccess, validateCityState);
        });

        pincode.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
            validateField(this, pincodeError, pincodeSuccess, validatePincode);
        });

        // Prevent paste of non-numeric for phone and pincode
        phone.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericOnly = pastedText.replace(/\D/g, '');
            if (numericOnly.length > 0) {
                this.value = numericOnly.slice(0, 10);
                this.dispatchEvent(new Event('input'));
            }
        });

        pincode.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericOnly = pastedText.replace(/\D/g, '');
            if (numericOnly.length > 0) {
                this.value = numericOnly.slice(0, 6);
                this.dispatchEvent(new Event('input'));
            }
        });

        // Blur validation
        firstName.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, firstNameError, firstNameSuccess, validateName);
            }
        });

        lastName.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, lastNameError, lastNameSuccess, validateName);
            }
        });

        email.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, emailError, emailSuccess, validateEmail);
            }
        });

        phone.addEventListener('blur', function() {
            if (this.value.length > 0) {
                validateField(this, phoneError, phoneSuccess, validatePhone);
            }
        });

        address1.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, address1Error, address1Success, validateAddress);
            }
        });

        city.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, cityError, citySuccess, validateCityState);
            }
        });

        state.addEventListener('blur', function() {
            if (this.value.trim().length > 0) {
                validateField(this, stateError, stateSuccess, validateCityState);
            }
        });

        pincode.addEventListener('blur', function() {
            if (this.value.length > 0) {
                validateField(this, pincodeError, pincodeSuccess, validatePincode);
            }
        });

        function isMobileCheckoutForm() {
            return form && window.getComputedStyle(form).display === 'none';
        }

        function hasChosenShippingAddress() {
            return address1 && address1.value.trim().length > 0;
        }

        function submitCheckoutForm() {
            const couponsField = document.getElementById('applied-coupons');
            if (couponsField) {
                couponsField.value = JSON.stringify(window.appliedCoupons || {});
            }
            console.log('appliedCoupons:', window.appliedCoupons);
            form.submit();
        }

        // Form submission
        window.submitForm = function() {
            const form = document.getElementById('checkout-form');

            if (lastName && firstName && lastName.value.trim().length === 0 && firstName.value.trim().length > 0) {
                lastName.value = firstName.value;
            }

            if (isMobileCheckoutForm() && !hasChosenShippingAddress()) {
                if (typeof window.openCheckoutAddressSheet === 'function') {
                    window.openCheckoutAddressSheet();
                }
                return;
            }

            // Validate all fields
            const isFirstNameValid = validateField(firstName, firstNameError, firstNameSuccess, validateName);
            const isLastNameValid = validateField(lastName, lastNameError, lastNameSuccess, validateName);
            const isEmailValid = validateField(email, emailError, emailSuccess, validateEmail);
            const isPhoneValid = validateField(phone, phoneError, phoneSuccess, validatePhone);
            const isAddress1Valid = validateField(address1, address1Error, address1Success, validateAddress);
            const isCityValid = validateField(city, cityError, citySuccess, validateCityState);
            const isStateValid = validateField(state, stateError, stateSuccess, validateCityState);
            const isPincodeValid = validateField(pincode, pincodeError, pincodeSuccess, validatePincode);

            // Check if all fields are valid
            if (isFirstNameValid && isLastNameValid && isEmailValid && isPhoneValid &&
                isAddress1Valid && isCityValid && isStateValid && isPincodeValid) {
                submitCheckoutForm();
                return;
            }

            // Mobile hides the shipping form; if a complete address is chosen, go to payment.
            if (isMobileCheckoutForm() && hasChosenShippingAddress()) {
                const pinDigits = pincode ? String(pincode.value || '').replace(/\D/g, '') : '';
                const hasRequiredValues = firstName.value.trim().length > 0 &&
                    lastName.value.trim().length > 0 &&
                    email.value.trim().length > 0 &&
                    phone.value.trim().length > 0 &&
                    city.value.trim().length > 0 &&
                    state.value.trim().length > 0 &&
                    pinDigits.length === 6;
                if (hasRequiredValues) {
                    pincode.value = pinDigits;
                    submitCheckoutForm();
                    return;
                }
                if (typeof window.openCheckoutAddressSheet === 'function') {
                    window.openCheckoutAddressSheet();
                    return;
                }
            }

            if (isMobileCheckoutForm() && typeof window.openCheckoutAddressSheet === 'function') {
                window.openCheckoutAddressSheet();
                return;
            }

            // Scroll to the first invalid field
            const firstInvalid = document.querySelector('#checkout-form .border-red-500');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // Show all error messages for empty fields
            if (firstName.value.trim().length === 0) {
                firstNameError.classList.remove('hidden');
                firstName.classList.add('border-red-500');
            }
            if (lastName.value.trim().length === 0) {
                lastNameError.classList.remove('hidden');
                lastName.classList.add('border-red-500');
            }
            if (email.value.trim().length === 0) {
                emailError.classList.remove('hidden');
                email.classList.add('border-red-500');
            }
            if (phone.value.length === 0) {
                phoneError.classList.remove('hidden');
                phone.classList.add('border-red-500');
            }
            if (address1.value.trim().length === 0) {
                address1Error.classList.remove('hidden');
                address1.classList.add('border-red-500');
            }
            if (city.value.trim().length === 0) {
                cityError.classList.remove('hidden');
                city.classList.add('border-red-500');
            }
            if (state.value.trim().length === 0) {
                stateError.classList.remove('hidden');
                state.classList.add('border-red-500');
            }
            if (pincode.value.length === 0) {
                pincodeError.classList.remove('hidden');
                pincode.classList.add('border-red-500');
            }
        };

        // Enter key support for form submission
        form.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                window.submitForm();
            }
        });

    })();
</script>
 <!-- <script>
        let appliedDiscounts = {};
        let appliedCoupons = {};
        const specialCoupon = @json($coupon);

        function applyCoupon(cartId, productTotal) {

            let code = document.getElementById('coupon-' + cartId).value.trim();
            let msg = document.getElementById('coupon-message-' + cartId);

            //     document.getElementById("coupon-" + cartId).disabled = true;
            // document.getElementById("apply-btn-" + cartId).disabled = true;
            // document.getElementById("apply-btn-" + cartId).innerHTML = "Applied";

            msg.innerHTML = "";

            if (code === "") {
                msg.className = "text-red-500 text-xs mt-1";
                msg.innerHTML = "Please enter coupon code.";
                return;
            }

            fetch("{{ route('apply.coupon') }}", {
method: "POST",
headers: {
"Content-Type": "application/json",
"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
},
body: JSON.stringify({
coupon_code: code,
total: productTotal
})
})
.then(res => res.json())
.then(res => {

if (!res.status) {
msg.className = "text-red-500 text-xs mt-1";
msg.innerHTML = res.message;
return;
}
let discount = parseFloat(res.coupon.discount);
let discountAmount = (productTotal * discount) / 100;
let newProductTotal = productTotal - discountAmount;
// appliedCoupons[cartId] = {
// coupon_id: res.coupon.id,
// coupon_code: res.coupon.code,
// coupon_discount: res.coupon.discount,
// coupon_discount_amount: discountAmount

// };
console.log('coupon code', res.coupon);
console.log('cart id', cartId);
appliedCoupons[cartId] = {
coupon_id: res.coupon.id,
coupon_code: res.coupon.code,
coupon_discount: res.coupon.discount,
coupon_discount_amount: discountAmount
};
console.log('appliedCoupons', appliedCoupons);
msg.className = "text-green-600 text-xs mt-1";
msg.innerHTML = res.message;



document.getElementById("product-total-" + cartId).innerHTML =
newProductTotal.toFixed(2);

if (appliedDiscounts[cartId]) {
return;
}

appliedDiscounts[cartId] = discountAmount;

let totalDiscount = Object.values(appliedDiscounts)
.reduce((sum, value) => sum + value, 0);

let originalSubtotal = parseFloat(
document.getElementById("subtotal").dataset.original
);

let subtotal = originalSubtotal - totalDiscount;
//special discoumt

document.getElementById("subtotal").innerHTML = subtotal.toFixed(2);

let gstPercentage = parseFloat(document.getElementById("gst-percentage").value);

let gst = subtotal * gstPercentage / 100;

document.getElementById("gst").innerHTML =
gst.toFixed(2);

let shipping = parseFloat(document.getElementById("shipping").innerHTML);

let grandTotal = subtotal + gst + shipping;

document.getElementById("grand-total").innerHTML =
grandTotal.toFixed(2);

document.getElementById("grand-total-hidden").value =
grandTotal.toFixed(2);
document.getElementById("gst-amount").value = gst.toFixed(2);

// Disable coupon after success
document.getElementById("coupon-" + cartId).disabled = true;

let btn = document.getElementById("apply-btn-" + cartId);
btn.disabled = true;
btn.innerHTML = "Applied";
btn.classList.replace("bg-black", "bg-green-600");

})
.catch((err) => {
console.error(err);
msg.className = "text-red-500 text-xs mt-1";
msg.innerHTML = "Something went wrong.";
});

}
</script>  -->
<script>
    // Make all functions globally accessible
    window.appliedDiscounts = {};
    window.appliedCoupons = {};

    window.calculateTotals = function() {
        let originalSubtotal = parseFloat(
            document.getElementById("subtotal").dataset.original
        );

        // Product coupon discount
        let totalProductDiscount = Object.values(window.appliedDiscounts)
            .reduce((sum, value) => sum + value, 0);

        let subtotal = originalSubtotal - totalProductDiscount;
               let currency = "{{ config('app.currency') }}";
        const subtotalOriginalEl = document.getElementById("subtotal-original");
        const subtotalOriginalAmt = document.getElementById("subtotal-original-amount");
        const couponSavingsRow = document.getElementById("coupon-savings-row");
        const couponSavingsAmt = document.getElementById("coupon-savings-amount");

        if (subtotalOriginalAmt) subtotalOriginalAmt.innerHTML = originalSubtotal.toFixed(2);
        if (totalProductDiscount > 0) {
            // if (subtotalOriginalEl) subtotalOriginalEl.classList.remove("hidden");
            if (couponSavingsAmt) couponSavingsAmt.innerHTML = totalProductDiscount.toFixed(2);
            if (couponSavingsRow) couponSavingsRow.classList.remove("hidden");
        } else {
            // if (subtotalOriginalEl) subtotalOriginalEl.classList.add("hidden");
            if (couponSavingsRow) couponSavingsRow.classList.add("hidden");
        }
        // -----------------------------
        // Auto Special Discount
        // -----------------------------
        let specialDiscount = 0;

        @if($coupon)
        if (subtotal >= {{ $coupon->minimum_amount }}) {
            specialDiscount = subtotal * {{ $coupon->discount }} / 100;
        }
        @endif

        @if($coupon)
        if (specialDiscount > 0) {
            document.getElementById("special-discount-id").value = "{{ $coupon->id }}";
            document.getElementById("special-discount-percentage").value = "{{ $coupon->discount }}";
            document.getElementById("special-discount-name").value = "{{ $coupon->code }}";
        } else {
            document.getElementById("special-discount-id").value = "";
            document.getElementById("special-discount-percentage").value = "";
            document.getElementById("special-discount-name").value = "";
        }
        @endif

        const specialDiscountEl = document.getElementById("special-discount");
        const specialDiscountAmt = document.getElementById("special-discount-amount");
        const specialDiscountHidden = document.getElementById("special-discount-hidden");

        if (specialDiscountEl) {
            specialDiscountEl.innerHTML = specialDiscount.toFixed(2);
        }
        if (specialDiscountAmt) {
            specialDiscountAmt.value = specialDiscount.toFixed(2);
        }
        if (specialDiscountHidden) {
            specialDiscountHidden.value = specialDiscount.toFixed(2);
        }

        document.getElementById("subtotal").innerHTML = subtotal.toFixed(2);

        // GST
        let gstPercentage = parseFloat(
            document.getElementById("gst-percentage").value
        );

        let gst = (subtotal - specialDiscount) * gstPercentage / 100;

        document.getElementById("gst").innerHTML = gst.toFixed(2);
        document.getElementById("gst-amount").value = gst.toFixed(2);

        // Shipping
        let shipping = parseFloat(
            document.getElementById("shipping").innerHTML
        );

        // Grand Total
        let grandTotal = (subtotal - specialDiscount) + gst + shipping;
        let roundedGrandTotal = window.customRound(grandTotal);
        
        document.getElementById("grand-total").innerHTML = roundedGrandTotal.toFixed(
            Number.isInteger(roundedGrandTotal) ? 0 : 1
        );
        document.getElementById("grand-total-hidden").value = roundedGrandTotal;
    };

    window.applyCoupon = function(cartId, productTotal, variantId) {
        let code = document.getElementById('coupon-' + cartId).value.trim();
        let msg = document.getElementById('coupon-message-' + cartId);

        msg.innerHTML = "";

        if (code == "") {
            msg.className = "text-red-500 text-xs mt-1";
            msg.innerHTML = "Please enter coupon code.";
            return;
        }

        fetch("{{ route('apply.coupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                coupon_code: code,
                total: productTotal,
                variant_id: variantId
            })
        })
        .then(res => res.json())
        .then(res => {
            if (!res.status) {
                msg.className = "text-red-500 text-xs mt-1";
                msg.innerHTML = res.message;
                return;
            }

            let discount = parseFloat(res.coupon.discount);
            let discountAmount = productTotal * discount / 100;
            let newProductTotal = productTotal - discountAmount;

            // document.getElementById("product-total-" + cartId).innerHTML =
            //     newProductTotal.toFixed(2);
                        let currency = "{{ config('app.currency') }}";

            let originalEl = document.getElementById("product-original-" + cartId);
            if (originalEl) {
                originalEl.innerHTML = currency + productTotal.toFixed(2);
                originalEl.classList.remove("hidden");
            }

             document.getElementById("product-total-" + cartId).innerHTML =
                newProductTotal.toFixed(2);
                currency + newProductTotal.toFixed(2);

            let productSavingsEl = document.getElementById("product-savings-" + cartId);
            if (productSavingsEl) {
                productSavingsEl.innerHTML = "(" + discount + "% off, you saved " + currency + discountAmount.toFixed(2) + ")";
                productSavingsEl.classList.remove("hidden");
            }

            window.appliedCoupons[cartId] = {
                coupon_id: res.coupon.id,
                coupon_code: res.coupon.code,
                coupon_discount: res.coupon.discount,
                coupon_discount_amount: discountAmount
            };

            window.appliedDiscounts[cartId] = discountAmount;

            msg.className = "text-green-600 text-xs mt-1";
            msg.innerHTML = res.message;

            // Recalculate all totals
            window.calculateTotals();

            // Disable coupon
            document.getElementById("coupon-" + cartId).disabled = true;

            let btn = document.getElementById("apply-btn-" + cartId);
            btn.disabled = true;
            btn.innerHTML = "Applied";
            btn.classList.remove("bg-black");
            btn.classList.add("bg-green-600");
        })
        .catch(err => {
            console.error(err);
            msg.className = "text-red-500 text-xs mt-1";
            msg.innerHTML = "Something went wrong.";
        });
    };

    window.customRound = function(value) {
        // const decimal = value - Math.floor(value);
         return Math.floor(value);
        // if (decimal >= 0.5) {
        //     return Math.ceil(value);
        // }

        // return Math.round(value * 10) / 10;
    };

    // Auto calculate on page load
    window.addEventListener("load", function() {
        window.calculateTotals();
    });

    console.log('Checkout script loaded successfully with global functions');
    console.log('typeof applyCoupon:', typeof window.applyCoupon);
   document.addEventListener("DOMContentLoaded", function () {
        // Track InitiateCheckout event with Facebook Pixel
        /* @if(isset($carts) && count($carts) > 0)
        // if (typeof fbq !== 'undefined') {
        //     const totalValue = {{ $total ?? 0 }};
        //     const contentIds = @js($carts->pluck('product_id')->toArray());
        //     const numItems = {{ $carts->sum('count') ?? 0 }};

        //     fbq('track', 'InitiateCheckout', {
        //         content_ids: contentIds,
        //         content_type: 'product',
        //         value: totalValue,
        //         currency: 'INR',
        //         num_items: numItems
        //     }, {
        //         eventID: @json($initiateCheckoutEventId ?? '')
        //     });
        // }
        // @endif */
        @if(!empty($initiateCheckoutEventId) && !empty($initiateCheckoutData))
            if (typeof fbq !== 'undefined') {
                fbq('track', 'InitiateCheckout', @json($initiateCheckoutData), {
                    eventID: @json($initiateCheckoutEventId)
                });
            }
        @endif

    document.querySelectorAll('input[id^="coupon-"]').forEach(function (input) {

        // Only auto-apply when coupon came from session
        if (input.value.trim() === '') {
            return;
        }

        const cartId = input.id.replace('coupon-', '');

        // Get variant ID directly from input
        const variantId = parseInt(input.dataset.variantId);

        // Get ORIGINAL product total from Blade
        const productTotal = parseFloat(input.dataset.productTotal) || 0;

        if (!variantId || !productTotal) {
            console.error(
                'Missing variantId or productTotal',
                {
                    cartId: cartId,
                    variantId: variantId,
                    productTotal: productTotal
                }
            );
            return;
        }

        console.log('Auto applying session coupon:', {
            cartId: cartId,
            variantId: variantId,
            coupon: input.value,
            productTotal: productTotal
        });

        // Call backend automatically
        window.applyCoupon(
            cartId,
            productTotal,
            variantId
        );

    });

});
</script>
<script>
    function toggleSpecialTerms() {
        const box = document.getElementById("special-terms");
        if (!box) return;

        if (box.classList.contains("opacity-0")) {
            box.classList.remove("opacity-0", "invisible");
            box.classList.add("opacity-100", "visible");
        } else {
            box.classList.remove("opacity-100", "visible");
            box.classList.add("opacity-0", "invisible");
        }
    }
</script>

<script>
function clearBuyNowAndRedirect() {
    const btn = document.getElementById('back-to-product-btn');
    if (btn) {
        // Show loading state
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;
    }
    
    // Clear session and redirect
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    fetch('{{ route("clear.buynow.session") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Session cleared:', data);
        // Redirect to product page
        window.location.href = '{{ route("page.multi-product") }}';
        goToPreviousPage();
    })
    .catch(error => {
        console.error('Error:', error);
        // Redirect anyway
        window.location.href = '{{ route("page.multi-product") }}';
        goToPreviousPage();
    });
}
function goToPreviousPage() {
        // Prefer the page the user actually came from (same-origin only, for safety)
        if (document.referrer && document.referrer.indexOf(window.location.origin) === 0) {
            window.location.href = document.referrer;
        } else {
            window.location.href = '{{ route("page.multi-product") }}';
        }
    }
</script>
<script>
(function () {
    var sheet = document.getElementById('checkout-address-sheet');
    var btn = document.getElementById('checkout-address-change-btn');
    var details = document.getElementById('checkout-preview-details');
    var emptyEl = document.getElementById('checkout-preview-empty');
    var listView = document.getElementById('checkout-address-sheet-list');
    var formView = document.getElementById('checkout-address-sheet-form');
    var titleEl = document.getElementById('checkout-address-sheet-title');
    if (!sheet || !btn) {
        return;
    }

    function setText(id, value) {
        var el = document.getElementById(id);
        if (el) {
            el.textContent = value || '';
        }
    }

    function setValue(id, value) {
        var el = document.getElementById(id);
        if (el) {
            el.value = value || '';
        }
    }

    function fillPreview() {
        var firstName = (document.getElementById('firstName') || {}).value || '';
        var lastName = (document.getElementById('lastName') || {}).value || '';
        var phone = (document.getElementById('phone') || {}).value || '';
        var email = (document.getElementById('email') || {}).value || '';
        var address1 = (document.getElementById('address1') || {}).value || '';
        var address2 = (document.getElementById('address2') || {}).value || '';
        var city = (document.getElementById('city') || {}).value || '';
        var state = (document.getElementById('state') || {}).value || '';
        var pin = (document.getElementById('pinCode') || {}).value || '';
        var street = [address1.trim(), address2.trim()].filter(Boolean).join(', ');
        var cityLine = [city.trim(), state.trim()].filter(Boolean).join(', ');
        if (pin.trim()) {
            cityLine = (cityLine ? cityLine + ' ' : '') + pin.trim();
        }

        setText('checkout-preview-name', [firstName.trim(), lastName.trim()].filter(Boolean).join(' '));
        setText('checkout-preview-phone', phone.trim());
        setText('checkout-preview-street', street);
        setText('checkout-preview-city', cityLine);
        setText('checkout-preview-email', email.trim());

        if (details) {
            details.classList.toggle('hidden', !address1.trim());
        }
        if (emptyEl) {
            emptyEl.classList.toggle('hidden', !!address1.trim());
        }
    }

    function applyToCheckout(data) {
        var parts = String(data.full_name || '').trim().split(/\s+/).filter(Boolean);
        var firstName = data.firstName || parts[0] || '';
        var lastName = data.lastName || parts.slice(1).join(' ') || firstName;
        setValue('firstName', firstName);
        setValue('lastName', lastName);
        setValue('phone', data.phone || '');
        setValue('address1', data.address_1 || '');
        setValue('address2', data.address_2 || '');
        setValue('city', data.city || '');
        setValue('state', data.state || '');
        setValue('pinCode', data.pincode || '');
        fillPreview();
    }

    function showList() {
        if (titleEl) {
            titleEl.textContent = 'Select address';
        }
        if (listView) {
            listView.classList.remove('hidden');
        }
        if (formView) {
            formView.classList.add('hidden');
        }
    }

    var isEditingAddress = false;

    function showForm(option) {
        var optionEl = (option && option.getAttribute) ? option : null;
        isEditingAddress = !!optionEl;
        if (titleEl) {
            titleEl.textContent = optionEl ? 'Edit address' : 'Add new address';
        }
        if (listView) {
            listView.classList.add('hidden');
        }
        if (formView) {
            formView.classList.remove('hidden');
        }
        var formError = document.getElementById('checkout-address-form-error');
        if (formError) {
            formError.textContent = '';
            formError.classList.add('hidden');
        }
        if (optionEl) {
            setValue('checkout-new-address-id', optionEl.getAttribute('data-id') || '');
            var parts = String(optionEl.getAttribute('data-full-name') || '').trim().split(/\s+/).filter(Boolean);
            setValue('checkout-new-firstName', parts[0] || '');
            setValue('checkout-new-lastName', parts.slice(1).join(' ') || parts[0] || '');
            setValue('checkout-new-phone', optionEl.getAttribute('data-phone') || '');
            setValue('checkout-new-address1', optionEl.getAttribute('data-address-1') || '');
            setValue('checkout-new-address2', optionEl.getAttribute('data-address-2') || '');
            setValue('checkout-new-city', optionEl.getAttribute('data-city') || '');
            setValue('checkout-new-state', optionEl.getAttribute('data-state') || '');
            setValue('checkout-new-pinCode', optionEl.getAttribute('data-pincode') || '');
            return;
        }
        setValue('checkout-new-address-id', '');
        setValue('checkout-new-firstName', '');
        setValue('checkout-new-lastName', '');
        setValue('checkout-new-phone', '');
        setValue('checkout-new-address1', '');
        setValue('checkout-new-address2', '');
        setValue('checkout-new-city', '');
        setValue('checkout-new-state', '');
        setValue('checkout-new-pinCode', '');
    }

    function markDefaultBadge(option) {
        if (!sheet || !option) {
            return;
        }
        sheet.querySelectorAll('.checkout-address-option').forEach(function (item) {
            var badge = item.querySelector('.checkout-address-option-badge');
            if (badge && badge.textContent.trim() === 'Default') {
                badge.remove();
            }
        });
        var nameEl = option.querySelector('.checkout-address-option-name');
        if (nameEl && !nameEl.querySelector('.checkout-address-option-badge')) {
            var badge = document.createElement('span');
            badge.className = 'checkout-address-option-badge';
            badge.textContent = 'Default';
            nameEl.appendChild(badge);
        }
    }

    function setCheckoutDefaultAddress(addressId) {
        if (!addressId) {
            return;
        }
        fetch("{{ url('/addresses') }}/" + addressId + "/checkout-default", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).catch(function (err) {
            console.error(err);
        });
    }

    function selectAddressOption(option) {
        if (!option) {
            return;
        }
        var radio = option.querySelector('.checkout-address-radio');
        if (radio) {
            radio.checked = true;
        }
        applyToCheckout({
            full_name: option.getAttribute('data-full-name') || '',
            phone: option.getAttribute('data-phone') || '',
            address_1: option.getAttribute('data-address-1') || '',
            address_2: option.getAttribute('data-address-2') || '',
            city: option.getAttribute('data-city') || '',
            state: option.getAttribute('data-state') || '',
            pincode: option.getAttribute('data-pincode') || ''
        });
        sheet.querySelectorAll('.checkout-address-option').forEach(function (item) {
            item.classList.toggle('is-selected', item === option);
        });
        markDefaultBadge(option);
        setCheckoutDefaultAddress(option.getAttribute('data-id'));
    }

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, function (char) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char];
        });
    }

    function upsertAddressOption(address) {
        if (!listView || !address || !address.id) {
            return;
        }
        var emptyEl = listView.querySelector('.checkout-address-empty-list');
        if (emptyEl) {
            emptyEl.remove();
        }
        var option = listView.querySelector('.checkout-address-option[data-id="' + address.id + '"]');
        var street = [address.address_1, address.address_2].filter(Boolean).join(', ');
        var cityLine = [address.city, address.state].filter(Boolean).join(', ');
        if (address.pincode) {
            cityLine = (cityLine ? cityLine + ' ' : '') + address.pincode;
        }
        if (!option) {
            option = document.createElement('div');
            option.className = 'checkout-address-option';
            option.innerHTML =
                '<input type="radio" name="checkout_shipping_address" class="checkout-address-radio" value="">' +
                '<div class="checkout-address-option-body">' +
                    '<span class="checkout-address-option-name"><span></span></span>' +
                    '<span class="checkout-address-option-phone"></span><br>' +
                    '<span class="checkout-address-option-street"></span><br>' +
                    '<span class="checkout-address-option-city"></span>' +
                '</div>' +
                '<button type="button" class="checkout-address-edit-btn" aria-label="Edit address"><i class="fa-solid fa-pen"></i></button>';
            var addBtnEl = document.getElementById('checkout-address-add-btn');
            if (addBtnEl) {
                listView.insertBefore(option, addBtnEl);
            } else {
                listView.appendChild(option);
            }
        }
        option.setAttribute('data-id', address.id);
        option.setAttribute('data-full-name', address.full_name || '');
        option.setAttribute('data-phone', address.phone || '');
        option.setAttribute('data-address-1', address.address_1 || '');
        option.setAttribute('data-address-2', address.address_2 || '');
        option.setAttribute('data-city', address.city || '');
        option.setAttribute('data-state', address.state || '');
        option.setAttribute('data-pincode', address.pincode || '');
        var radio = option.querySelector('.checkout-address-radio');
        if (radio) {
            radio.value = address.id;
        }
        var body = option.querySelector('.checkout-address-option-body');
        if (body) {
            var badge = body.querySelector('.checkout-address-option-badge');
            var badgeHtml = badge ? badge.outerHTML : '';
            body.innerHTML =
                '<span class="checkout-address-option-name"><span>' + escapeHtml(address.full_name || '') + '</span>' + badgeHtml + '</span>' +
                (address.phone ? (escapeHtml(address.phone) + '<br>') : '') +
                escapeHtml(street) + '<br>' +
                escapeHtml(cityLine);
        }
        selectAddressOption(option);
    }

    function openSheet() {
        showList();
        sheet.classList.add('is-open');
        sheet.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    window.openCheckoutAddressSheet = openSheet;

    function closeSheet() {
        sheet.classList.remove('is-open');
        sheet.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        showList();
    }

    btn.addEventListener('click', openSheet);

    var closeBtn = document.getElementById('checkout-address-sheet-close');
    var backdrop = document.getElementById('checkout-address-sheet-backdrop');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSheet);
    }
    if (backdrop) {
        backdrop.addEventListener('click', closeSheet);
    }

    sheet.addEventListener('click', function (e) {
        if (e.target.closest('.checkout-address-add-btn') || e.target.closest('#checkout-address-sheet-form')) {
            return;
        }
        var editBtn = e.target.closest('.checkout-address-edit-btn');
        if (editBtn) {
            e.preventDefault();
            e.stopPropagation();
            showForm(editBtn.closest('.checkout-address-option'));
            return;
        }
        var option = e.target.closest('.checkout-address-option');
        if (!option) {
            return;
        }
        selectAddressOption(option);
    });

    var addBtn = document.getElementById('checkout-address-add-btn');
    if (addBtn) {
        addBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            showForm(null);
        });
    }

    var backBtn = document.getElementById('checkout-address-form-back');
    if (backBtn) {
        backBtn.addEventListener('click', showList);
    }

    var saveBtn = document.getElementById('checkout-address-form-save');
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            var firstName = (document.getElementById('checkout-new-firstName') || {}).value || '';
            var lastName = (document.getElementById('checkout-new-lastName') || {}).value || '';
            var phone = (document.getElementById('checkout-new-phone') || {}).value || '';
            var address1 = (document.getElementById('checkout-new-address1') || {}).value || '';
            var address2 = (document.getElementById('checkout-new-address2') || {}).value || '';
            var city = (document.getElementById('checkout-new-city') || {}).value || '';
            var state = (document.getElementById('checkout-new-state') || {}).value || '';
            var pin = (document.getElementById('checkout-new-pinCode') || {}).value || '';
            var addressId = (document.getElementById('checkout-new-address-id') || {}).value || '';
            var formError = document.getElementById('checkout-address-form-error');
            var fullName = [firstName.trim(), lastName.trim()].filter(Boolean).join(' ');

            if (formError) {
                formError.textContent = '';
                formError.classList.add('hidden');
            }

            fetch("{{ route('addresses.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: isEditingAddress ? (addressId || null) : null,
                    create_new: !isEditingAddress,
                    full_name: fullName,
                    phone: phone.trim(),
                    address_1: address1.trim(),
                    address_2: address2.trim(),
                    city: city.trim(),
                    state: state.trim(),
                    pincode: pin.trim()
                })
            })
            .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
            .then(function (result) {
                if (!result.ok || !result.data.status) {
                    var message = (result.data && result.data.message) ? result.data.message : 'Please fill a valid address.';
                    if (result.data && result.data.errors) {
                        var firstError = Object.values(result.data.errors)[0];
                        if (firstError && firstError[0]) {
                            message = firstError[0];
                        }
                    }
                    if (formError) {
                        formError.textContent = message;
                        formError.classList.remove('hidden');
                    }
                    return;
                }
                applyToCheckout({
                    firstName: firstName,
                    lastName: lastName,
                    phone: phone,
                    address_1: address1,
                    address_2: address2,
                    city: city,
                    state: state,
                    pincode: pin
                });
                upsertAddressOption(result.data.address);
                closeSheet();
            })
            .catch(function (err) {
                console.error(err);
                if (formError) {
                    formError.textContent = 'Could not save address. Please try again.';
                    formError.classList.remove('hidden');
                }
            });
        });
    }
})();
</script>
<script>
(function () {
    var card = document.querySelector('.checkout-saving-card');
    if (!card) {
        return;
    }
    var currency = "{{ config('app.currency') }}";

    function isManualCouponApplied() {
        if (document.querySelector('.checkout-saving-unapply')) {
            return true;
        }
        var locked = false;
        document.querySelectorAll('input[id^="coupon-"]').forEach(function (input) {
            if (input.disabled && input.value.trim() !== '') {
                locked = true;
            }
        });
        return locked;
    }

    function syncOtherApplyButtons() {
        var locked = isManualCouponApplied();
        document.querySelectorAll('.checkout-saving-apply').forEach(function (btn) {
            btn.disabled = locked;
        });
    }

    function setSavingButton(btn, mode, code) {
        btn.classList.remove('checkout-saving-apply', 'checkout-saving-unapply');
        btn.classList.add(mode === 'apply' ? 'checkout-saving-apply' : 'checkout-saving-unapply');
        btn.setAttribute('data-code', code);
        btn.textContent = mode === 'apply' ? 'Apply' : 'Remove';
        btn.disabled = false;
    }

    function revertItemCoupon(input) {
        var cartId = input.id.replace('coupon-', '');
        var productTotal = parseFloat(input.getAttribute('data-product-total')) || 0;
        input.disabled = false;
        input.value = '';

        var applyBtn = document.getElementById('apply-btn-' + cartId);
        if (applyBtn) {
            applyBtn.disabled = false;
            applyBtn.innerHTML = 'Apply';
            applyBtn.classList.remove('bg-green-600');
            applyBtn.classList.add('bg-black');
        }

        var originalEl = document.getElementById('product-original-' + cartId);
        var totalEl = document.getElementById('product-total-' + cartId);
        var savingsEl = document.getElementById('product-savings-' + cartId);
        var msg = document.getElementById('coupon-message-' + cartId);
        if (originalEl) {
            originalEl.classList.add('hidden');
        }
        if (totalEl) {
            totalEl.innerHTML = currency + productTotal.toFixed(2);
        }
        if (savingsEl) {
            savingsEl.innerHTML = '';
            savingsEl.classList.add('hidden');
        }
        if (msg) {
            msg.innerHTML = '';
        }

        if (window.appliedCoupons) {
            delete window.appliedCoupons[cartId];
        }
        if (window.appliedDiscounts) {
            delete window.appliedDiscounts[cartId];
        }
    }

    card.addEventListener('click', function (e) {
        var applyBtn = e.target.closest('.checkout-saving-apply');
        var unapplyBtn = e.target.closest('.checkout-saving-unapply');

        if (applyBtn) {
            if (applyBtn.disabled) {
                return;
            }
            var code = applyBtn.getAttribute('data-code') || '';
            if (!code || typeof window.applyCoupon !== 'function') {
                return;
            }
            var appliedAny = false;
            document.querySelectorAll('input[id^="coupon-"]').forEach(function (input) {
                if (input.disabled) {
                    return;
                }
                var cartId = input.id.replace('coupon-', '');
                var variantId = input.getAttribute('data-variant-id');
                var productTotal = input.getAttribute('data-product-total');
                input.value = code;
                window.applyCoupon(cartId, parseFloat(productTotal), parseInt(variantId, 10));
                appliedAny = true;
            });
            if (appliedAny) {
                var item = applyBtn.closest('.checkout-saving-item');
                if (item) {
                    item.classList.add('is-applied');
                }
                setSavingButton(applyBtn, 'unapply', code);
                syncOtherApplyButtons();
            }
            return;
        }

        if (unapplyBtn) {
            var removeCode = unapplyBtn.getAttribute('data-code') || '';
            if (!removeCode) {
                return;
            }
            fetch("{{ route('remove.coupon') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ coupon_code: removeCode })
            })
            .then(function (res) { return res.json(); })
            .then(function (res) {
                if (!res.status) {
                    return;
                }
                document.querySelectorAll('input[id^="coupon-"]').forEach(function (input) {
                    if (input.value.trim().toUpperCase() === removeCode.toUpperCase()) {
                        revertItemCoupon(input);
                    }
                });
                if (typeof window.calculateTotals === 'function') {
                    window.calculateTotals();
                }
                var item = unapplyBtn.closest('.checkout-saving-item');
                if (item) {
                    item.classList.remove('is-applied');
                    var note = item.querySelector('.checkout-saving-note');
                    if (note) {
                        note.textContent = 'Use this code in the item coupon box';
                    }
                }
                setSavingButton(unapplyBtn, 'apply', removeCode);
                syncOtherApplyButtons();
            })
            .catch(function (err) {
                console.error(err);
            });
        }
    });

    syncOtherApplyButtons();
    setTimeout(syncOtherApplyButtons, 800);
    document.querySelectorAll('[id^="apply-btn-"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            setTimeout(syncOtherApplyButtons, 800);
        });
    });
})();
</script>

@endsection