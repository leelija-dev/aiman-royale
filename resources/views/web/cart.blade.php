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
          Spend ₹{{ number_format(400 - $subtotal, 2) }} more and get free shipping!
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
                <th class="px-6 py-4 text-center">After Discount</th>
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
                   <a href="{{route("page.single-product", $item->product->slug)}}">
                  <div class="flex items-center gap-4">
                    <div
                      class="w-24 h-32 bg-gray-200 border-2 border-dashed rounded-lg flex-shrink-0 flex items-center justify-center text-gray-400 text-xs overflow-hidden">
                      @if($item->product && $item->product->images->first())
                      <img
                        class="object-cover object-top object-center w-full h-full"
                        src="{{ asset($item->product->images->first()->image) }}"
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
                  </a>
                </td>
                 
                <td class="px-6 py-6 text-center">{{config('app.currency')}}{{ number_format($item->variant->price, 2) }}</td>
                <td class="px-6 py-6 text-center">{{config('app.currency')}}{{ number_format($item->variant->price - (($item->variant->price * $item->variant->discount) / 100) , 2) }}</td>

                <td class="px-6 py-6 text-center">
                  <div
                    class="flex items-center justify-center border border-gray-300 rounded-md inline-flex">
                    {{-- <button
                      onclick="decreaseQuantity({{ $item->id }}, {{ $item->count - 1 }})"
                      class="px-3 py-1 hover:bg-gray-100"
                      {{ $item->count <= 1 ? 'disabled' : '' }}>
                      -
                    </button> --}}
                    <button
                      onclick="decreaseQuantity({{ $item->id }})"
                      class="px-3 py-1 hover:bg-gray-100"
                     >
                      -
                    </button>
                    <input
                      type="text"
                      value="{{ $item->count }}"
                      name="quantity"
                      data-stock="{{ $item->variant->stock }}"
                      id="quantity-{{ $item->id }}"
                      class="w-12 text-center border-x border-gray-300 py-1" readonly
                       /> {{--onchange="updateQuantity({{ $item->id }}, parseInt(this.value))" --}}
                    <button
                      onclick="increaseQuantity({{ $item->id }})"
                      class="px-3 py-1 hover:bg-gray-100">
                      +
                    </button>
                  </div>
                </td>
                

                <td class="px-6 py-6 text-center font-medium" id="subtotal-{{ $item->id }}" data-price="{{$item->variant->discount_price}}">
                  {{config('app.currency')}}{{ number_format(($item->variant->price - (($item->variant->price * $item->variant->discount) / 100)) * $item->count, 2) }}
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
                    <a href="{{ route('page.multi-product') }}" class="inline-flex items-center px-6 py-3 bg-black text-white rounded-md hover:bg-gray-800 transition-colors">
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
        {{-- <div class="mt-3 flex flex-wrap gap-4 px-6 py-6">
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
            <a href="{{ route('page.multi-product') }}">
            <button
              class="px-6 py-3 smx:w-fit w-full border border-gray-300 lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-100">
              Continue shopping
            </button>
            </a>
          </div>
        </div> --}}
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
              <span id="total_subtotal">{{config('app.currency')}}{{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="flex justify-between text-gray-700">
              <span>Shipping</span>
              <div class="text-right">
                @if($shipping == 0 )
                <span class="block text-sm text-green-600">Free shipping!</span>
                @else
                @if($subtotal == 0)
                <span class="block text-sm text-green-600">{{config('app.currency')}}0</span>
                @else
                <span class="block text-sm">{{config('app.currency')}}{{ number_format($shipping, 2) }}</span>
                
                <span class="block text-xs text-gray-500">Free shipping over {{config('app.currency')}}400</span>
                @endif
                @endif
                <!-- <a href="#" class="text-sm text-blue-600 hover:underline">Change address</a> -->
              </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
              <div
                class="flex justify-between text-lg font-medium text-gray-900">
                <span>Total</span>
                @if($subtotal == 0)
                <span >{{config('app.currency')}}0</span>
                @else
                <span id="total_price" data-shipping="{{$shipping}}">{{config('app.currency')}}{{ number_format($total, 2) }}</span>
              @endif
              </div>
            </div>

            @if(auth()->check())
            <form action="{{ route('cart.update') }}" method="POST" id="cartUpdateForm" enctype="multipart/form-data">
             @csrf
                
                <button type="submit"
                  class="px-6 py-3 w-full bg-black text-white lgg:text-[1rem] text-[0.875rem] rounded-md hover:bg-gray-800" {{ $subtotal == 0 ? 'disabled' : '' }}>
                  Proceed to checkout
                </button>
              
            </form>
            @else
              <a href="{{ route('page.login', ['redirect' => url()->current()]) }}">
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



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>

  // function updateQuantity(cartId, newQuantity) {
  //   if (newQuantity < 1) {
  //     removeFromCart(cartId);
  //     return;
  //   }

  //   let quantityInput = document.getElementById('quantity-' + cartId);
  //   console.log('quantityInput', quantityInput.value);

  //   quantityInput.value = parseInt(newQuantity);
  //   console.log('newquantityInput', quantityInput.value);
    // const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // fetch(`/cart/update/${cartId}`, {
    //     method: 'POST',
    //     headers: {
    //       'X-CSRF-TOKEN': token,
    //       'Accept': 'application/json',
    //       'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify({
    //       count: newQuantity,
    //       _token: token
    //     })
    //   })
    //   .then(response => response.json())
    //   .then(data => {
    //     if (data.success) {
    //       location.reload(); // Reload to show updated totals
    //     } else {
    //       showNotification(data.message, 'error');
    //     }
    //   })
    //   .catch(error => {
    //     console.error('Error:', error);
    //     showNotification('Error updating quantity', 'error');
    //   });

  // }
 

function increaseQuantity(cartId) {

   
    let qtyInput = document.getElementById('quantity-' + cartId);
     let stock = parseFloat(qtyInput.getAttribute('data-stock') || 0);
    let subTotal = document.getElementById('subtotal-' + cartId);
    console.log('stock', stock);
    
    let price = parseFloat(subTotal.getAttribute('data-price'));
    let currentQty = parseInt(qtyInput.value);

    let newQty = currentQty + 1;
    if (newQty > stock) {
        Swal.fire({
            title: 'Sorry!',
            text: `Out of stock`,
            icon: 'info',
            timer: 5000,
            showConfirmButton: false
        });
        return;
    }
    qtyInput.value = newQty;

    let newSubtotal = newQty * price;
    subTotal.textContent = "{{config('app.currency')}}" + newSubtotal.toFixed(2);

    updateCartTotal(); // recalculate everything
    updateCheckoutButton(); // check stock and update button
}

function decreaseQuantity(cartId) {

    let qtyInput = document.getElementById('quantity-' + cartId);
    let subTotal = document.getElementById('subtotal-' + cartId);

    let price = parseFloat(subTotal.getAttribute('data-price'));
    let currentQty = parseInt(qtyInput.value);

    let newQty = currentQty - 1;

    if (newQty < 1) {
        removeFromCart(cartId);
        return;
    }

    qtyInput.value = newQty;

    let newSubtotal = newQty * price;
    subTotal.textContent = "{{config('app.currency')}}" + newSubtotal.toFixed(2);

    updateCartTotal(); //  recalculate everything
    updateCheckoutButton(); // check stock and update button
}

function updateCartTotal() {

    let currency = "{{config('app.currency')}}";
    let totalSubtotal = 0;
    let totalItems = 0;

    document.querySelectorAll('[id^="subtotal-"]').forEach(function (item) {

        let price = parseFloat(item.getAttribute('data-price'));
        let cartId = item.id.replace('subtotal-', '');
        let qty = parseInt(document.getElementById('quantity-' + cartId).value);

        let rowTotal = price * qty;

        item.textContent = currency + rowTotal.toFixed(2);

        totalSubtotal += rowTotal;
        totalItems += qty;
    });

    let totalSubtotalElement = document.getElementById('total_subtotal');
    let totalPriceElement = document.getElementById('total_price');

    let shippingCost = parseFloat(totalPriceElement?.getAttribute('data-shipping')) || 0;

    totalSubtotalElement.textContent = currency + totalSubtotal.toFixed(2);

    if (totalPriceElement) {
        totalPriceElement.textContent = currency + (totalSubtotal + shippingCost).toFixed(2);
    }
    
    // Update navbar cart count
    updateNavbarCartCount(totalItems);
}

// Function to update navbar cart count
function updateNavbarCartCount(count) {
    // Find all cart count elements in navbar
    const cartCountElements = document.querySelectorAll('.cart-count');
    const cartBadges = document.querySelectorAll('.absolute.-top-1.-right-1.w-5.h-5');
    
    // Update cart count elements
    cartCountElements.forEach(element => {
        element.textContent = count;
    });
    
    // Update cart badges
    cartBadges.forEach(badge => {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    });
    
    // Update cart tooltip text
    const cartTooltips = document.querySelectorAll('.absolute.-bottom-8');
    cartTooltips.forEach(tooltip => {
        tooltip.textContent = 'Cart' + (count > 0 ? ' (' + count + ')' : '');
    });
}


  function removeFromCart(cartId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This item will be removed from your cart!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#000',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

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
           Swal.fire({
            title: 'Removed!',
            text: 'Item removed successfully.',
            icon: 'success',
            timer: 4000,
            showConfirmButton: false
        });
       

    
        } else {
          showNotification(data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Error removing item', 'error');
      });
    }
  });
  }

  function showNotification(message, type) {
    const notification = document.createElement('div');
    let bgColor = 'bg-gray-500'; // default
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            break;
        case 'warning':
            bgColor = 'bg-orange-500';
            break;
        case 'info':
            bgColor = 'bg-blue-500';
            break;
        default:
            bgColor = 'bg-gray-500';
    }
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-transform duration-300 translate-x-full ${bgColor}`;
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
<script>
document.getElementById('cartUpdateForm')?.addEventListener('submit', function () {

    // remove old dynamic inputs
    document.querySelectorAll('.dynamic-qty').forEach(el => el.remove());

    document.querySelectorAll('[id^="quantity-"]').forEach(input => {

        let cartId = input.id.replace('quantity-', '');
        let quantity = input.value;

        let cartInput = document.createElement('input');
        cartInput.type = 'hidden';
        cartInput.name = 'cart_id[]';
        cartInput.value = cartId;
        cartInput.classList.add('dynamic-qty');

        let qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = 'quantity[]';
        qtyInput.value = quantity;
        qtyInput.classList.add('dynamic-qty');

        this.appendChild(cartInput);
        this.appendChild(qtyInput);
    });

});
document.addEventListener("DOMContentLoaded", function () {
    updateCartTotal();
   
});

// window.addEventListener("pageshow", function () {
//     updateCartTotal();
//     // window.location.reload()
// });

// window.addEventListener("pageshow", function (event) {

//     // If page is loaded from browser cache
//     if (event.persisted) {
//         window.location.reload();
//     }

// });

window.addEventListener("pageshow", function (event) {

    updateCartTotal();

    // Reload only if page came from browser cache (back button)
    const navigationEntries = performance.getEntriesByType("navigation");

    if (navigationEntries.length > 0 && navigationEntries[0].type === "back_forward") {
        window.location.reload();
    }


});

// Stock validation functions
function checkAllItemsStock() {
    let hasOutOfStock = false;
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    
    quantityInputs.forEach(input => {
        const cartId = input.id.replace('quantity-', '');
        const stock = parseInt(input.getAttribute('data-stock') || 0);
        const quantity = parseInt(input.value);
        const row = input.closest('tr');
        
        // Remove existing stock status
        const existingStatus = row.querySelector('.stock-status');
        if (existingStatus) {
            existingStatus.remove();
        }
        
        // Add stock status indicator
        const stockStatus = document.createElement('div');
        stockStatus.className = 'stock-status text-xs mt-1';
        
        if (quantity > stock) {
            hasOutOfStock = true;
            stockStatus.innerHTML = `<span class="text-red-600 font-medium">⚠️ Out of Stock (Available: ${stock})</span>`;
            row.classList.add('bg-red-50');
        } else if (stock <= 0) {
            hasOutOfStock = true;
            stockStatus.innerHTML = `<span class="text-red-600 font-medium">❌ Out of Stock</span>`;
            row.classList.add('bg-red-50');
        } else if (stock <= 5) {
            stockStatus.innerHTML = `<span class="text-orange-600">Only ${stock} left</span>`;
            row.classList.add('bg-orange-50');
        } else {
            stockStatus.innerHTML = `<span class="text-green-600">✓ In Stock (${stock})</span>`;
            row.classList.remove('bg-red-50', 'bg-orange-50');
        }
        
        // Insert stock status after quantity cell
        const quantityCell = input.closest('td');
        quantityCell.appendChild(stockStatus);
    });
    
    return hasOutOfStock;
}

function updateCheckoutButton() {
    const checkoutBtn = document.querySelector('button[type="submit"]');
    const hasOutOfStock = checkAllItemsStock();
    
    if (checkoutBtn) {
        if (hasOutOfStock) {
            checkoutBtn.disabled = true;
            checkoutBtn.textContent = 'Remove out-of-stock items to checkout';
            checkoutBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            checkoutBtn.classList.remove('bg-black', 'hover:bg-gray-800');
        } else {
            checkoutBtn.disabled = false;
            checkoutBtn.textContent = 'Proceed to checkout';
            checkoutBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            checkoutBtn.classList.add('bg-black', 'hover:bg-gray-800');
        }
    }
}

// Check stock on page load
document.addEventListener('DOMContentLoaded', function() {
    adjustQuantitiesToStock();
    updateCheckoutButton();
});

// Function to adjust quantities to match available stock
function adjustQuantitiesToStock() {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    let hasZeroStockItems = false;
    let itemsUpdated = false;
    
    quantityInputs.forEach(input => {
        const cartId = input.id.replace('quantity-', '');
        const stock = parseInt(input.getAttribute('data-stock') || 0);
        const currentQty = parseInt(input.value);
        const subTotal = document.getElementById('subtotal-' + cartId);
        const price = parseFloat(subTotal.getAttribute('data-price'));
        
        // If stock is 0, remove the item from cart
        if (stock <= 0) {
            hasZeroStockItems = true;
            // Show notification for removal
            showNotification(`Item removed from cart: ${input.closest('tr').querySelector('.font-medium').textContent} (Out of stock)`, 'error');
            // Remove the item
            setTimeout(() => removeFromCart(cartId), 1000);
            return;
        }
        
        // If current quantity exceeds available stock, reduce it
        if (currentQty > stock) {
            input.value = stock;
            const newSubtotal = stock * price;
            subTotal.textContent = "{{config('app.currency')}}" + newSubtotal.toFixed(2);
            itemsUpdated = true;
            
            // Show notification for quantity adjustment
            showNotification(`Quantity adjusted for ${input.closest('tr').querySelector('.font-medium').textContent}: ${currentQty} → ${stock} (Stock limit)`, 'info');
        }
    });
    
    // Recalculate totals if items were updated
    if (itemsUpdated) {
        updateCartTotal();
    }
    
    // If there are zero stock items, show warning and prevent checkout
    if (hasZeroStockItems) {
        setTimeout(() => {
            showNotification('Some items were removed from cart due to zero stock. Please review your cart before checkout.', 'warning');
        }, 1500);
    }
}

</script>



@endsection
