@if($products->count() > 0)
@foreach($products as $product)
<div class="item flex justify-center items-center">
    <a href="/products/{{ $product->slug ?? $product['slug'] ?? '' }}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200 product-card">
        <!-- Image Wrapper -->
        <div class="relative overflow-hidden bg-gray-100">
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

            // Add Cloudinary optimization if applicable
            if ($hasImage && $imageUrl && strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                $parts = explode('upload/', $imageUrl);
                $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
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
                class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                loading="lazy"
                decoding="async"
                width="600"
                height="900"
                onerror="this.parentElement.innerHTML = this.parentElement.innerHTML.replace(this.outerHTML, '<div class=\'w-full aspect-[9/13] flex flex-col items-center justify-center bg-gray-100\'><svg class=\'w-16 h-16 text-gray-400 mb-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\' /></svg><span class=\'text-gray-500 text-sm\'>No image</span></div>')" />
            @else
            <!-- SVG Placeholder -->
            <div class="w-full aspect-[9/13] flex flex-col items-center justify-center bg-gray-100">
                <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-gray-500 text-sm">No image</span>
            </div>
            @endif

            <!-- Quick View Overlay -->
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                    Quick View
                </span>
            </div>

            <!-- Badges -->
            <div class="absolute top-[6px] left-[5px] flex flex-col gap-2">
                @if($isFeatured)
                <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                    Featured
                </span>
                @endif

                @if($discountPercentage > 0)
                <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                    {{ $discountPercentage }}% OFF
                </span>
                @endif
            </div>

            <!-- Wishlist Heart Icon -->
            <button
                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex items-center justify-center text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-4 space-y-2">
            <div class="flex items-start justify-between">
                <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                    {{ $productName }}
                </h3>
                <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $brand }}</span>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-0.5">
                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                </div>
                <span class="text-xs font-sans text-gray-400">({{ $rating }})</span>
            </div>

            <!-- Price -->
            <div class="flex items-center justify-between mt-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-lg font-semibold text-gray-900 font-sans">{{ config('app.currency') }} {{ number_format($displayPrice, 2) }}</span>
                    @if($displayPrice < $originalPrice)
                    <span class="text-xs text-gray-400 line-through font-sans">{{ config('app.currency') }} {{ number_format($originalPrice, 2) }}</span>
                    @endif
                </div>

               
            </div>

          
        </div>
    </a>
</div>
@endforeach
@else
{{-- @dd("this is test") --}}
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
            <a href="{{ route('page.multi-product') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-secondary text-white rounded-full hover:from-secondary hover:to-primary transition-all duration-300 hover:shadow-lg">
                View All Products
            </a>
            <button onclick="window.clearAllFilters ? clearAllFilters() : window.location.href='{{ route('page.multi-product') }}'" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-full hover:bg-gray-50 transition-colors">
                Clear Filters
            </button>
        </div>
    </div>
</div>
@endif
<div>
      {{-- {{ $products->links('pagination::bootstrap-4') }} --}}
</div>