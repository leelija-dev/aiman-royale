@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
  <div class="container mx-auto">
    <!-- Category Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">
        {{ $category->name ?? 'Products' }}
      </h1>
      @if(isset($category->description))
        <p class="text-gray-600">{{ $category->description }}</p>
      @endif
    </div>

    <!-- Products Grid -->
    <div class="w-full grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-6">
      @forelse($products as $product)

        <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card" data-product-id="{{ $product->id }}">
          <!-- Image Wrapper -->
          <div class="relative rounded-xl overflow-hidden">
            <img 
              src="{{ asset('uploads/products/' . $product->product_image) }}"
              alt="{{ $product->name }}"
              class="w-full h-[340px] object-cover object-top object-center"
            />

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
              @if($product->is_trending ?? false)
                <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                  Trending
                </span>
              @endif
              @if($product->discount_percentage ?? false)
                <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                  -{{ $product->discount_percentage }}%
                </span>
              @endif
            </div>

            <!-- Wishlist Heart Icon (Top Right) -->
            <button
              class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                class="w-5 h-5 text-red-500">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>

            <!-- Add To Cart (Hidden → Hover Show) -->
            <div
              class="hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
              <button
                class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                Add To Cart
              </button>
            </div>
          </div>

          <!-- Content -->
          <div class="p-4 space-y-1">
            <h3 class="text-[15px] font-semibold text-gray-900">
              {{ $product->name }}
            </h3>

            <div class="flex items-center gap-2 text-sm text-gray-600">
              <span>{{ $product->brand ?? 'Brand Name' }}</span>
              <span class="flex items-center gap-1 text-gray-700">
                <span class="text-sm font-medium">{{ $product->rating ?? '4.4' }}</span>
              </span>
            </div>

            <div class="flex items-center gap-2 mt-2 flex-wrap">
              <span class="text-lg font-bold text-gray-900">Rs. {{ $product->discount_price ?? $product->price }}</span>
              @if($product->price_after_discount && $product->price)
                <span class="text-sm text-gray-400 line-through">Rs. {{ $product->price }}</span>
              @endif
            </div>
            <div class="md:hidden block">
              <button
                class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">
                Add
              </button>
            </div>
          </div>
        </div>
      @empty
        <div class="text-center py-12">
          <p class="text-gray-500 text-lg">No products found in this category.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all product cards
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Prevent navigation if clicking on buttons or links inside the card
            if (e.target.closest('button') || e.target.closest('a')) {
                return;
            }
            
            const productId = this.getAttribute('data-product-id');
            if (productId) {
                window.location.href = `/single-product/${productId}`;
            }
        });
    });
});
</script>

@endsection