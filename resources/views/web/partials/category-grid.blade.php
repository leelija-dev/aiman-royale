@if($products->count() > 0)
@foreach($products as $product)
<div class="product-card group w-full bg-white rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200" data-product-slug="{{ $product->slug }}">
    <!-- Image Wrapper -->
    <div class="image-wrapper relative overflow-hidden bg-gray-100">
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
            src="{{ $product->featured_image }}"
            alt="{{ $product->name }}"
            class="product-img w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105" />
        @else
        <!-- Placeholder -->
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
        <div class="badge-container absolute top-[6px] left-[5px] flex flex-col gap-2">
            @if($product->variants->isNotEmpty() && $product->variants->first()->discount_price && $product->variants->first()->discount_price < $product->variants->first()->price)
                @php
                $originalPrice = $product->variants->first()->price;
                $discountPrice = $product->variants->first()->discount_price;
                $discountPercentage = round((($originalPrice - $discountPrice) / $originalPrice) * 100);
                @endphp
                <span class="discount-badge bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                    -{{ $discountPercentage }}% OFF
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
            class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center z-10">
            @if($isInWishlist == false)
            <i class="far fa-heart text-gray-400 hover:text-red-500 text-lg"></i>
            @else
            <i class="fas fa-heart text-red-500 text-lg"></i>
            @endif
        </button>
        @else
        <a class="wishlist-link" href="{{ route('page.login') }}" onclick="event.stopPropagation()">
            <button class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center z-10">
                <i class="far fa-heart text-gray-400 hover:text-red-500 text-lg"></i>
            </button>
        </a>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4 space-y-2">
        <div class="flex items-start justify-between">
            <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                {{ $product->name }}
            </h3>
            <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $product->brand ?? 'Brand' }}</span>
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
            <span class="text-xs font-sans text-gray-400">({{ $product->rating ?? '4.4' }})</span>
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

        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-lg font-semibold text-gray-900 font-sans">{{ config('app.currency') }} {{ number_format($displayPrice, 2) }}</span>
            @if($displayPrice < $originalPrice)
                <span class="text-xs text-gray-400 line-through font-sans">{{ config('app.currency') }} {{ number_format($originalPrice, 2) }}</span>
                @endif
        </div>
    </div>
</div>
@endforeach
@else


@foreach($latestProducts as $product)
<div class="product-card group w-full bg-white rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200" data-product-slug="{{ $product->slug }}">
    <!-- Image Wrapper -->
    <div class="image-wrapper relative overflow-hidden bg-gray-100">
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
            src="{{ $product->featured_image }}"
            alt="{{ $product->name }}"
            class="product-img w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105" />
        @else
        <!-- Placeholder -->
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
        <div class="badge-container absolute top-[6px] left-[5px] flex flex-col gap-2">
            @if($product->variants->isNotEmpty() && $product->variants->first()->discount_price && $product->variants->first()->discount_price < $product->variants->first()->price)
                @php
                $originalPrice = $product->variants->first()->price;
                $discountPrice = $product->variants->first()->discount_price;
                $discountPercentage = round((($originalPrice - $discountPrice) / $originalPrice) * 100);
                @endphp
                <span class="discount-badge bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                    -{{ $discountPercentage }}% OFF
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
            class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center z-10">
            @if($isInWishlist == false)
            <i class="far fa-heart text-gray-400 hover:text-red-500 text-lg"></i>
            @else
            <i class="fas fa-heart text-red-500 text-lg"></i>
            @endif
        </button>
        @else
        <a class="wishlist-link" href="{{ route('page.login') }}" onclick="event.stopPropagation()">
            <button class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center z-10">
                <i class="far fa-heart text-gray-400 hover:text-red-500 text-lg"></i>
            </button>
        </a>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4 space-y-2">
        <div class="flex items-start justify-between">
            <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                {{ $product->name }}
            </h3>
            <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $product->brand ?? 'Brand' }}</span>
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
            <span class="text-xs font-sans text-gray-400">({{ $product->rating ?? '4.4' }})</span>
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

        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-lg font-semibold text-gray-900 font-sans">{{ config('app.currency') }} {{ number_format($displayPrice, 2) }}</span>
            @if($displayPrice < $originalPrice)
                <span class="text-xs text-gray-400 line-through font-sans">{{ config('app.currency') }} {{ number_format($originalPrice, 2) }}</span>
                @endif
        </div>
    </div>
</div>
@endforeach
@endif