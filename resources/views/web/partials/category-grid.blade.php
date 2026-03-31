@if($products->count() > 0)
@foreach($products as $product)
<div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card" data-product-slug="{{ $product->slug }}">
    <!-- Image Wrapper -->
    <div class="relative rounded-xl overflow-hidden bg-gray-100">
        @php
        $imageUrl = null;
        $hasImage = false;

        if ($product->images && $product->images->isNotEmpty()) {
        $firstImage = $product->images->first();
        if ($firstImage && !empty($firstImage->image)) {
        $imageUrl = asset($firstImage->image);
        $hasImage = true;
        }
        }
        @endphp

        @if($hasImage && $imageUrl)
        <img
            src="{{ asset($product->featured_image) }}"
            alt="{{ $product->name }}"
            class="aspect-[4/6] object-contain max-h-[500px] w-full h-auto object-top object-center" />
        @else
        <!-- Placeholder -->
        <div class="w-full h-[340px] flex items-center justify-center bg-gray-200">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        @endif

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($product->variants->isNotEmpty() && $product->variants->first()->discount_price && $product->variants->first()->discount_price < $product->variants->first()->price)
                @php
                $originalPrice = $product->variants->first()->price;
                $discountPrice = $product->variants->first()->discount_price;
                $discountPercentage = round((($originalPrice - $discountPrice) / $originalPrice) * 100);
                @endphp
                <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                    -{{ $discountPercentage }}%
                </span>
                @endif
        </div>

        <!-- Wishlist Icon -->
        @php
        // Check if product is in user's wishlist
        $isInWishlist = false;
        if (auth()->check()) {
        $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->exists();

        }
        @endphp
        @if(Auth::check())
        <button
            onclick="toggleWishlist({{ $product->id }}, this, event)"
            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center">
            @if($isInWishlist == false)
            <i class="far fa-heart"></i>
            @else
             <i class="fas fa-heart" style="color:red;"></i>
            @endif
        </button>
        @else
        <a href="{{ route('login') }}" onclick="event.stopPropagation()">
            <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center">
                <i class="far fa-heart"></i>
            </button>
        </a>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4">
        <h3 class="text-[15px] font-semibold text-gray-900 mb-1">
            {{ $product->name }}
        </h3>

        <div class="text-sm text-gray-600 mb-2">
            {{ $product->brand ?? 'Brand' }}
        </div>

        @php
        $displayPrice = 0;
        $originalPrice = 0;

        if ($product->variants && $product->variants->isNotEmpty()) {
        $firstVariant = $product->variants->first();
        $displayPrice = $firstVariant->discount_price ?? $firstVariant->price ?? 0;
        $originalPrice = $firstVariant->price ?? 0;
        }
        @endphp

        <div class="flex items-center gap-2">
            <span class="text-lg font-bold text-gray-900">Rs. {{ number_format($displayPrice) }}</span>
            @if($displayPrice < $originalPrice)
                <span class="text-sm text-gray-400 line-through">Rs. {{ number_format($originalPrice) }}</span>
                @endif
        </div>
    </div>
</div>
@endforeach
@else
<div class="col-span-full text-center py-12">
    <p class="text-gray-500">No products found.</p>
</div>
@endif