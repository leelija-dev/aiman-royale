@if($products->count() > 0)
  @foreach($products as $product)
  <div class="item ">
    <a href="/products/{{ $product->slug ?? $product['slug'] ?? '' }}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card">
      <!-- Image Wrapper -->
      <div class="relative rounded-xl overflow-hidden bg-gray-100">
        @php
          // Handle different image structures for both object and array
          $imageUrl = null;
          $hasImage = false;
          
          // Get product name (works for both object and array)
          $productName = is_object($product) ? ($product->name ?? 'Product') : ($product['name'] ?? 'Product');
          
          // Get images - handle different formats
          $images = null;
          if (is_object($product)) {
              $images = $product->images ?? null;
          } else {
              $images = $product['images'] ?? null;
          }
          
          if (!empty($images)) {
              if (is_array($images)) {
                  // If it's an array of objects/arrays
                  $firstImage = $images[0] ?? null;
                  if ($firstImage && is_object($firstImage) && !empty($firstImage->image)) {
                      $imageUrl = asset($firstImage->image);
                      $hasImage = true;
                  } elseif ($firstImage && is_array($firstImage) && !empty($firstImage['image'])) {
                      $imageUrl = asset($firstImage['image']);
                      $hasImage = true;
                  } elseif (is_string($firstImage)) {
                      $imageUrl = asset($firstImage);
                      $hasImage = true;
                  }
              } elseif (is_string($images)) {
                  // If it's a JSON string
                  $decodedImages = json_decode($images, true);
                  if (is_array($decodedImages) && !empty($decodedImages)) {
                      $firstImage = $decodedImages[0];
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
          if (!$hasImage) {
              $productImage = is_object($product) ? ($product->image ?? null) : ($product['image'] ?? null);
              if (!empty($productImage)) {
                  $imageUrl = $productImage;
                  $hasImage = true;
              }
          }
          
          // Get product data (works for both object and array)
          $isFeatured = is_object($product) ? ($product->is_featured ?? false) : ($product['is_featured'] ?? false);
          $price = is_object($product) ? ($product->price ?? 0) : ($product['price'] ?? 0);
          $discountPrice = is_object($product) ? ($product->discount_price ?? null) : ($product['discount_price'] ?? null);
          $brand = is_object($product) ? ($product->brand ?? 'Brand') : ($product['brand'] ?? 'Brand');
          $rating = is_object($product) ? ($product->rating ?? '4.4') : ($product['rating'] ?? '4.4');
          
          // Handle variants
          $variants = is_object($product) ? ($product->variants ?? null) : ($product['variants'] ?? null);
          
          $displayPrice = $discountPrice ?? $price;
          $originalPrice = $price;
          
          if (!empty($variants) && is_array($variants)) {
              $firstVariant = $variants[0] ?? null;
              if ($firstVariant) {
                  if (is_object($firstVariant)) {
                      $displayPrice = $firstVariant->discount_price ?? $firstVariant->price ?? $displayPrice;
                      $originalPrice = $firstVariant->price ?? $originalPrice;
                  } else {
                      $displayPrice = $firstVariant['discount_price'] ?? $firstVariant['price'] ?? $displayPrice;
                      $originalPrice = $firstVariant['price'] ?? $originalPrice;
                  }
              }
          }
          
          $discountPercentage = 0;
          if ($displayPrice < $originalPrice && $originalPrice > 0) {
              $discountPercentage = round((($originalPrice - $displayPrice) / $originalPrice) * 100);
          }
        @endphp
        
        @if($hasImage && $imageUrl)
          <img
            src="{{ $imageUrl }}"
            alt="{{ $productName }}"
            class="aspect-[4/6] object-contain max-h-[500px] w-full h-auto object-top object-center "
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
          @if($isFeatured)
          <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
            Featured
          </span>
          @endif
          
          @if($discountPercentage > 0)
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
        <h3 class="text-[15px] font-semibold text-gray-900 truncate">
          {{ $productName }}
        </h3>

        <div class="flex items-center gap-2 text-sm text-gray-600">
          <span>{{ $brand }}</span>
          <span class="flex items-center gap-1 text-gray-700">
            <span class="text-sm font-medium">{{ $rating }}</span>
          </span>
        </div>

        <div class="flex items-center gap-2 mt-2 flex-wrap">
          <span class="text-lg font-bold text-gray-900">{{ config('app.currency') }} {{ number_format($displayPrice, 2) }}</span>
          @if($displayPrice < $originalPrice)
          <span class="text-sm text-gray-400 line-through">{{ config('app.currency') }} {{ number_format($originalPrice, 2) }}</span>
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