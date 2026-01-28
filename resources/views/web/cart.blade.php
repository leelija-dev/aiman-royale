@extends('layout.web.main-layout')








@section('content')


<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50 ">
  <div class="container mx-auto">
    <!-- Progress Bar and Banner -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center mb-4">
        <div class="flex-1 bg-gray-200 rounded-full h-4 relative">
          <div class="bg-black h-4 rounded-full w-1/5"></div>
        </div>
      </div>
      <p class="text-sm text-gray-600">
        @if($subtotal < 400)
          Spend ${{ number_format(400 - $subtotal, 2) }} more and get free shipping!
          @else
          🎉 You've qualified for free shipping!
          @endif
          </p>
          <div class="mt-2 text-sm font-medium text-gray-700">
            Cart ({{ $cartCount }} {{ $cartCount == 1 ? 'item' : 'items' }})
          </div>
    </div>

    <div class="flex flex-col lgg:flex-row gap-8">
      <!-- Cart Items - Now using a table -->
      <div class="flex-1 bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead
              class="text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="px-6 py-4">Product</th>
                <th class="px-6 py-4 text-center">Price</th>
                <th class="px-6 py-4 text-center">Quantity</th>
                <th class="px-6 py-4 text-center">Subtotal</th>
                <th class="px-6 py-4 text-center"></th>
                <!-- Remove -->
              </tr>
            </thead>
            <tbody>
              @forelse ($cartItems as $item)
              <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-6">
                  <div class="flex items-center gap-4">
                    <div
                      class="w-24 h-32 bg-gray-200 border-2 border-dashed rounded-lg flex-shrink-0 flex items-center justify-center text-gray-400 text-xs overflow-hidden">
                      @if($item->product && $item->product->images->first())
                      <img
                        class="object-cover object-top object-center w-full h-full"
                        src="{{ asset($item->product->images->first()->image_path) }}"
                        alt="{{ $item->product->name }}" />
                      @else
                      <span>No Image</span>
                      @endif
                    </div>
                    <div>
                      <h3 class="font-medium text-gray-900">
                        {{ $item->product ? $item->product->name : 'Product Not Found' }}
                      </h3>
                      @if($item->variant)
                      <p class="text-sm text-gray-500">
                        Size: {{ $item->variant->size ?? 'N/A' }}, Color: {{ $item->variant->color ?? 'N/A' }}
                      </p>
                      @endif
                    </div>
                  </div>
                </td>

                <td class="px-6 py-6 text-center">${{ number_format($item->price, 2) }}</td>

                <td class="px-6 py-6 text-center">
                  <div
                    class="flex items-center justify-center border border-gray-300 rounded-md inline-flex">
                    <button
                      onclick="updateQuantity({{ $item->id }}, {{ $item->count - 1 }})"
                      class="px-3 py-1 hover:bg-gray-100"
                      {{ $item->count <= 1 ? 'disabled' : '' }}>
                      -
                    </button>
                    <input
                      type="text"
                      value="{{ $item->count }}"
                      id="quantity-{{ $item->id }}"
                      class="w-12 text-center border-x border-gray-300 py-1"
                      onchange="updateQuantity({{ $item->id }}, parseInt(this.value))" />
                    <button
                      onclick="updateQuantity({{ $item->id }}, {{ $item->count + 1 }})"
                      class="px-3 py-1 hover:bg-gray-100">
                      +
                    </button>
                  </div>
                </td>

                <td class="px-6 py-6 text-center font-medium">
                  ${{ number_format($item->price * $item->count, 2) }}
                </td>

                <td class="px-6 py-6 text-center">
                  <button
                    onclick="removeFromCart({{ $item->id }})"
                    class="text-gray-400 hover:text-red-600 transition-colors">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center gap-4">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">Your cart is empty</p>
                    <p class="text-sm">Add some products to get started!</p>
                    <a href="{{ route('page.index') }}" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-md hover:bg-gray-800 transition-colors">
                      Continue Shopping
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Coupon Section -->
        <div class="mt-3 flex flex-wrap gap-4 px-6 py-6">
          <input
            type="text"
            placeholder="Coupon code"
            class="flex-1 w-full smx:min-w-[300px] px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />
          <div
            class="flex gap-4 smx:w-fit w-full smx:flex-row flex-col lgg:justify-start justify-end">
            <button
              class="px-6 py-3 smx:w-fit w-full bg-black text-white lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-800">
              Apply coupon
            </button>
            <button
              class="px-6 py-3 smx:w-fit w-full border border-gray-300 lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-100">
              Continue shopping
            </button>
          </div>
        </div>
      </div>

      <!-- Cart Totals Sidebar -->
      <div class="lg:w-80">
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h2 class="text-lg font-medium text-gray-900 mb-6">
            Cart Totals
          </h2>

          <div class="space-y-4">
            <div class="flex justify-between text-gray-700">
              <span>Subtotal</span>
              <span>${{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="flex justify-between text-gray-700">
              <span>Shipping</span>
              <div class="text-right">
                @if($shipping == 0)
                <span class="block text-sm text-green-600">Free shipping!</span>
                @else
                <span class="block text-sm">${{ number_format($shipping, 2) }}</span>
                <span class="block text-xs text-gray-500">Free shipping over $400</span>
                @endif
                <a href="#" class="text-sm text-blue-600 hover:underline">Change address</a>
              </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
              <div
                class="flex justify-between text-lg font-medium text-gray-900">
                <span>Total</span>
                <span>${{ number_format($total, 2) }}</span>
              </div>
            </div>

            @if(auth()->check())
              <a href="{{ route('checkout.index') }}">
                <button
                  class="px-6 py-3 w-full bg-black text-white lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-800">
                  Proceed to checkout
                </button>
              </a>
            @else
              <a href="{{ route('page.login') }}">
                <button
                  class="px-6 py-3 w-full bg-black text-white lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-800">
                  Login to checkout
                </button>
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection

<script>
  function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
      removeFromCart(cartId);
      return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(`/cart/update/${cartId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          count: newQuantity,
          _token: token
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload(); // Reload to show updated totals
        } else {
          showNotification(data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating quantity', 'error');
      });
  }

  function removeFromCart(cartId) {
    if (!confirm('Are you sure you want to remove this item?')) {
      return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(`/cart/remove/${cartId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `_method=DELETE&_token=${encodeURIComponent(token)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload(); // Reload to show updated cart
        } else {
          showNotification(data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Error removing item', 'error');
      });
  }

  function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-transform duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
      notification.classList.remove('translate-x-full');
    }, 100);

    setTimeout(() => {
      notification.classList.add('translate-x-full');
      setTimeout(() => {
        if (document.body.contains(notification)) {
          document.body.removeChild(notification);
        }
      }, 300);
    }, 3000);
  }
</script>