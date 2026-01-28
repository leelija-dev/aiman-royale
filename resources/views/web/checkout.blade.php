@extends('layout.web.main-layout')








@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50">
      <div class="container mx-auto">
        <div class="flex flex-col lgg:flex-row gap-8">
          <!-- Left Column: Shipping Form -->
          <div class="flex-1 bg-white rounded-lg shadow-sm p-8">
            <nav class="text-sm text-gray-500 mb-6">
              Cart > Shipping > Payment
            </nav>
            <h1 class="text-2xl font-semibold mb-8">Shipping Address</h1>

            <form id="checkout-form" action="{{ route('checkout.place') }}" method="post" class="space-y-6">
              @csrf
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >First Name</label
                  >
                  <input
                    type="text"
                    name="firstName"
                    value="{{ auth()->user()->name ?? '' }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Last Name</label
                  >
                  <input
                    type="text"
                    name="lastName"
                    value="{{ auth()->user()->name ?? '' }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Email</label
                  >
                  <input
                    type="email"
                    name="email"
                    value="{{ auth()->user()->email ?? '' }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Phone No</label
                  >
                  <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Address 1</label
                >
                <input
                  type="text"
                  name="address1"
                  value="{{ old('address1') }}"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Street address"
                  required
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Address 2 (optional)</label
                >
                <input
                  type="text"
                  name="address2"
                  value="{{ old('address2') }}"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Apartment, suite, etc."
                />
              </div>

              <div class="grid grid-cols-3 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >City</label
                  >
                  <input
                    type="text"
                    name="city"
                    value="{{ old('city') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >State</label
                  >
                  <input
                    type="text"
                    name="state"
                    value="{{ old('state') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Pin Code</label
                  >
                  <input
                    type="text"
                    name="pinCode"
                    value="{{ old('pinCode') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                    required
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Description (optional)</label
                >
                <textarea
                  name="description"
                  rows="3"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Enter a description..."
                >{{ old('description') }}</textarea>
              </div>
            </form>
          </div>

          <!-- Right Column: Order Summary -->
          <div class="xl:w-102 w-96">
            <div class="bg-white rounded-lg shadow-sm p-6">
              <h2 class="text-xl font-semibold mb-6">Your Cart</h2>

              <div class="space-y-6 mb-6">
                @if($carts->count() > 0)
                
                  @foreach($carts as $cart)
                  <div class="flex gap-4">
                    <div class="w-20 h-20 bg-gray-200 rounded-md flex-shrink-0 border border-gray-300 overflow-hidden">
                      @if($cart->image)
                        <img src="{{ asset('uploads/products/' . $cart->image) }}" alt="{{ $cart->name }}" class="w-full h-full object-cover">
                      @endif
                    </div>
                    <div class="flex-1">
                      <p class="font-medium">{{ $cart->name }}</p>
                      <p class="text-sm text-gray-500">{{ $cart->size ?? 'One Size' }}, {{ $cart->color ?? 'Default' }}</p>
                      <p class="text-sm text-gray-500">Qty: {{ $cart->count }}</p>
                    </div>
                    <p class="font-medium">${{ number_format($cart->discount_price * $cart->count, 2) }}</p>
                  </div>
                  @endforeach
                @else
                  <p class="text-gray-500 text-center py-4">Your cart is empty</p>
                @endif
              </div>

              <div class="border-t pt-4 space-y-3">
                <div class="flex items-center gap-3">
                  <input
                    type="text"
                    placeholder="Discount code"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none w-full"
                  />
                  <button
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                  >
                    Apply
                  </button>
                </div>

                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>${{ number_format($carts->sum(function($cart) { return $cart->discount_price * $cart->count; }), 2) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span>${{ number_format($carts->count() > 0 ? 7.00 : 0, 2) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Estimated taxes</span>
                    <span>${{ number_format($carts->sum(function($cart) { return $cart->discount_price * $cart->count; }) * 0.05, 2) }}</span>
                  </div>
                  <div
                    class="flex justify-between font-semibold text-base pt-2 border-t"
                  >
                    <span>Total</span>
                    <span>${{ number_format($carts->sum(function($cart) { return $cart->discount_price * $cart->count; }) + ($carts->count() > 0 ? 7.00 : 0) + ($carts->sum(function($cart) { return $cart->discount_price * $cart->count; }) * 0.05), 2) }}</span>
                  </div>
                </div>

                <button
                  type="button"
                  onclick="document.getElementById('checkout-form').submit()"
                  class="w-full mt-6 py-4 bg-black text-white font-medium rounded-md hover:bg-gray-900 transition"
                  @if($carts->count() == 0) disabled
                  @endif
                >
                  @if($carts->count() > 0)
                    Place Order
                  @else
                    Cart is Empty
                  @endif
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


@endsection