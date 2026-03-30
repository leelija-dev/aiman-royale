@if($products->count() > 0)
  @foreach($products as $product)
  <div class="item ">
    <a href="/products/{{ $product['slug'] }}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card">
      <!-- Image Wrapper -->
      <div class="relative rounded-xl overflow-hidden bg-gray-100">
        @php
          // Handle different image structures
          $imageUrl = null;
          $hasImage = false;
          
          if (!empty($product['images'])) {
              if (is_array($product['images'])) {
                  // If it's an array of objects
                  $firstImage = $product['images'][0] ?? null;
                  if ($firstImage && is_object($firstImage) && !empty($firstImage->image)) {
                      $imageUrl = asset($firstImage->image);
                      $hasImage = true;
                  } elseif ($firstImage && is_array($firstImage) && !empty($firstImage['image'])) {
                      $imageUrl = asset($firstImage['image']);
                      $hasImage = true;
                  }
              } elseif (is_string($product['images'])) {
                  // If it's a JSON string
                  $images = json_decode($product['images'], true);
                  if (is_array($images) && !empty($images)) {
                      $firstImage = $images[0];
                      if (is_array($firstImage) && !empty($firstImage['image'])) {
                          $imageUrl = asset($firstImage['image']);
                          $hasImage = true;
                      } elseif (is_string($firstImage)) {
                          $imageUrl = asset($firstImage);
                          $hasImage = true;
                      }
                  }
              }
          }
          
          // If no image found, try product image field
          if (!$hasImage && !empty($product['image'])) {
              $imageUrl = asset($product['image']);
              $hasImage = true;
          }
        @endphp
        
        @if($hasImage && $imageUrl)
          <img
            src="{{ $imageUrl }}"
            alt="{{ $product['name'] ?? 'Product' }}"
            class="aspect-[4/5] object-contain max-h-[500px] w-full h-auto object-top object-center "
            onerror="this.parentElement.innerHTML = this.parentElement.innerHTML.replace(this.outerHTML, '<div class=\'w-full h-[340px] flex items-center justify-center bg-gray-200\'><svg class=\'w-16 h-16 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\' /></svg><span class=\'text-gray-500 text-sm mt-2\'>No image</span></div>')"
          />
        @else
          <!-- SVG Placeholder -->
          <div class="w-full h-[340px] flex flex-col items-center justify-center bg-gray-100">
            <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-gray-500 text-sm">No image</span>
          </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
          @if(!empty($product['is_featured']) && $product['is_featured'])
          <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
            Featured
          </span>
          @endif
          
          @if(isset($product['discount_price']) && $product['discount_price'] < $product['price'])
          @php
            $discountPercentage = round((($product['price'] - $product['discount_price']) / $product['price']) * 100);
          @endphp
          <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
            -{{ $discountPercentage }}%
          </span>
          @endif
        </div>

        <!-- Wishlist Heart Icon -->
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
      </div>

      <!-- Content -->
      <div class="p-4 space-y-1">
        <h3 class="text-[15px] font-semibold text-gray-900">
          {{ $product['name'] ?? 'Product Name' }}
        </h3>

        <div class="flex items-center gap-2 text-sm text-gray-600">
          <span>{{ $product['brand'] ?? 'Brand' }}</span>
          <span class="flex items-center gap-1 text-gray-700">
            <span class="text-sm font-medium">4.4</span>
          </span>
        </div>

        <div class="flex items-center gap-2 mt-2 flex-wrap">
          @php
            $displayPrice = $product['discount_price'] ?? $product['price'] ?? 0;
            $originalPrice = $product['price'] ?? 0;
            
            // Check variants if available
            if (!empty($product['variants']) && is_array($product['variants'])) {
                $firstVariant = $product['variants'][0] ?? null;
                if ($firstVariant) {
                    $displayPrice = $firstVariant['discount_price'] ?? $firstVariant['price'] ?? $displayPrice;
                    $originalPrice = $firstVariant['price'] ?? $originalPrice;
                }
            }
          @endphp
          <span class="text-lg font-bold text-gray-900">Rs. {{ number_format($displayPrice, 2) }}</span>
          @if($displayPrice < $originalPrice)
          <span class="text-sm text-gray-400 line-through">Rs. {{ number_format($originalPrice, 2) }}</span>
          @endif
        </div>
        
        <div class="lgg:hidden block">
          <button
            class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">
            Add
          </button>
        </div>
      </div>
    </a>
  </div>
  @endforeach
@else
<!-- No Products Found Message -->
<div class="col-span-full flex flex-col items-center justify-center py-16">
  <div class="text-center">
    <div class="mb-4">
      <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">No product found</h3>
    <p class="text-gray-600 mb-6">
      @if(request('search'))
        We couldn't find any products matching "{{ request('search') }}".
      @else
        We couldn't find any products matching your criteria.
      @endif
    </p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="{{ route('page.multi-product') }}" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
        View All Products
      </a>
      <button onclick="window.clearAllFilters ? clearAllFilters() : window.location.href='{{ route('page.multi-product') }}'" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
        Clear Filters
      </button>
    </div>
  </div>
</div>
@endif