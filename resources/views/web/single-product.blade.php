@extends('layout.web.main-layout')

@section('page-type', 'single-product')
{{-- @dd($product); --}}
@php
    // Pass product category data to navbar for breadcrumbs
    $productCategory = null;
    if (isset($product) && $product->category) {
        $productCategory = [
            'name' => $product->category->name,
            'slug' => $product->category->slug
        ];
    }
    // Debug: Log the product data to check if category is loaded
    error_log('Product Data: ' . json_encode([
        'product_id' => $product->id ?? 'null',
        'product_name' => $product->name ?? 'null',
        'category_id' => $product->category_id ?? 'null',
        'category_exists' => isset($product->category),
        'category_name' => $product->category->name ?? 'null'
    ]));
@endphp

@section('content')
  @if($product == true)
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">

   @if($product->variants->first() == true)

  <div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-[55%_40%] gap-6">
      <!-- LEFT IMAGE SECTION -->
      <div class="flex flex-col lg:flex-row gap-2">
        <!-- Thumbnails -->
        <div
          class="flex min-w-24 lg:py-0 py-2 items-center lg:overflow-visible overflow-auto lg:flex-col gap-4 order-2 lg:order-1">
          @forelse($product->images as $index => $image)
          <div
            class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 border-transparent cursor-pointer {{ $index == 0 ? 'selected' : '' }}"
            data-display="{{ asset($image->image) }}"
            data-large="{{ asset($image->image) }}">
            <img
              src="{{ asset($image->image) }}"
              class="w-full h-full object-cover object-center object-top"
              alt="{{ $product->name }}" />
          </div>
          @empty
          <div
            class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 border-transparent cursor-pointer selected"
            data-display="{{ asset('assets/images/placeholder.jpg') }}"
            data-large="{{ asset('assets/images/placeholder.jpg') }}">
            <img
              src="{{ asset('assets/images/placeholder.jpg') }}"
              class="w-full h-full object-cover object-center object-top"
              alt="{{ $product->name ?? 'Product' }}" />
          </div>
          @endforelse
        </div>

        <!-- Main Image with Hover Pan Zoom -->
        <div
          class="zoom-container w-full relative group order-1 lg:order-2 h-full">
          <img
            src="{{ $product->images->first() ? asset($product->images->first()->image) : asset('assets/images/placeholder.jpg') }}"
            class="w-full h-full object-cover object-center object-top"
            alt="{{ $product->name ?? 'Product' }}"
            id="main-image" />
          <div
            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur rounded-full p-3 shadow-lg opacity-0 transition-opacity fullscreen-btn">
            <button
              id="fullscreen-btn"
              class="text-gray-800 hover:text-blue-700">
              <i class="fas fa-expand text-xl"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- RIGHT CONTENT -->
      <div class="space-y-6">
        <div>
          <!-- Title -->
          <h3
            class="text-h3-xs sm:text-h3-sm md:text-h3-md lg:text-h3-lg lgg:text-h3-lgg xl:text-h3-xl 2xl:text-h3-2xl font-semibold">
            {{ $product->name }}
          </h3>
          <p class="text-sm text-gray-500 mt-1">{{ $product->brand ?? 'Brand Name' }}</p>
          <p class="text-sm text-gray-500">Sold By: Store</p>
        </div>
        <div class="flex items-center gap-2">
          <div class="flex text-yellow-400 text-sm">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
          </div>
          <span class="text-sm text-gray-500">4.4 · 36 Reviews</span>
        </div>
        <div class="flex items-center gap-3" id="price-container">
          <span class="text-2xl font-bold text-gray-900">Rs. {{ $product->variants->first()->discount_price ?? $product->variants->first()->price }}</span>
          @if($product->variants->first()->price  )
          <span class="line-through text-gray-400">Rs. {{ $product->variants->first()->price }}</span>
           @endif
           @if($product->variants->first()->discount)
          <span
            class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">({{  $product->variants->first()->discount }}% off)</span>
          @else
         <span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">
                  Trending
                </span>
          @endif
        </div>

        <div>
  <h3 class="font-medium mb-3 text-gray-800">Select Type</h3>
  <div class="flex gap-3 xxs:flex-row flex-col">
    <button
      class="type-btn px-6 py-3 rounded-lg border-2 border-gray-300 text-gray-700 hover:border-secondary transition-all"
      data-type="stitched">
      Stitched
    </button>

    <button
      id="custom-dimension-btn"
      class="px-6 py-3 rounded-lg border-2 border-dashed border-gray-400 text-gray-600 hover:border-secondary hover:text-secondary transition-all flex items-center gap-2">
      <i class="fas fa-ruler-combined"></i>
      Custom Dimension
    </button>
  </div>
</div>

<!-- Custom Dimension Input Section (Hidden by Default) -->
<div id="custom-dimension-section" class="hidden space-y-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
  <h3 class="font-medium text-gray-800">Enter Custom Dimensions</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Bust (in cm)</label>
      <input
        type="number"
        id="custom-bust"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
        placeholder="Enter bust"
        min="1"
        step="0.1">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Waist (in cm)</label>
      <input
        type="number"
        id="custom-waist"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
        placeholder="Enter waist"
        min="1"
        step="0.1">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Hip (in cm)</label>
      <input
        type="number"
        id="custom-hip"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
        placeholder="Enter hip"
        min="1"
        step="0.1">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Armhole (in cm)</label>
      <input
        type="number"
        id="custom-armhole"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
        placeholder="Enter Armhole"
        min="1"
        step="0.1">
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Select Color</label>
    <div class="flex gap-3" id="custom-color-selection">
      <!-- Colors will be populated dynamically -->
      <div class="flex flex-wrap gap-2">
        @foreach($colors as $color)
        <button class="custom-color-btn w-8 h-8 rounded-full border-2 border-gray-300 hover:scale-110 transition-all" 
                style="background-color: {{ $color->code }};" 
                data-color="{{ $color->code }}"></button>
        @endforeach
      </div>
    </div>
  </div>
  <div class="flex gap-3">
    <button
      id="save-dimension-btn"
      class="px-6 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/80 transition-colors">
      Save Dimensions
    </button>
    <button
      id="cancel-custom-btn"
      class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
      Cancel
    </button>
  </div>
</div>

        <!-- Size Selection -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-expand-alt text-secondary"></i>
                Select Size
              </h3>
              <p class="text-sm text-gray-500 mt-1">Choose your perfect fit</p>
            </div>
            <button
              type="button"
              data-size-guide-trigger
              class="px-4 py-2.5 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-xl hover:from-gray-800 hover:to-gray-700 transition-all shadow hover:shadow-md flex items-center gap-2 w-fit">
              <i class="fas fa-ruler-combined"></i>
              View Size Guide
            </button>
          </div>

          <div class="flex gap-3 flex-wrap">
            @php
            $sizes = $product->variants->pluck('size')->unique()->filter();
            $availableSizes = ['XS', 'S', 'M', 'L', 'XL'];
            @endphp
            @foreach($sizes as $size)
            @if($sizes->contains($size))
            <button
              class="size-btn relative w-14 h-14 rounded-full border-2 border-gray-200 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 group"
              data-size="{{ $size }}"
              onclick="selectSize('{{ $size }}')">
              <span class="text-lg font-semibold text-gray-800 group-hover:text-secondary">{{ $size }}</span>
              <div class="absolute -top-1 -right-1 w-5 h-5 bg-secondary rounded-full items-center justify-center hidden">
                <i class="fas fa-check text-white text-xs"></i>
              </div>
            </button>
            @endif
            @endforeach
          </div>
        </div>

        <!-- Color Selection -->
        <div id="color-selection-section">
          <h3 class="font-medium mb-3 text-gray-800">Select Color</h3>
          <div class="flex gap-3 " id="color-selection">
            @php
            $selectedSize = $product->variants->first()->size ?? 'M';
            $colorsForSize = $product->variants->where('size', $selectedSize)->pluck('color')->unique()->filter();
            @endphp
            @foreach($colorsForSize as $index => $color)
            @php
            $variantForColor = $product->variants->where('size', $selectedSize)->where('color', $color)->first();
            $variantId = $variantForColor ? $variantForColor->id : null;
            $isSelected = ($index == 0);
            $productImages = $product->images->toArray();
            $imageIndex = $index % count($productImages);
            $variantImage = $productImages[$imageIndex]['image'] ?? ($product->images->first()->image ?? null);
            @endphp
            <button
              class="color-btn w-10 h-10 rounded-full border-2 {{ $isSelected ? 'border-secondary' : 'border-gray-300' }} transition-all hover:scale-110"
              style="background-color: {{ $color }};"
              data-color="{{ $color }}"
              data-size="{{ $selectedSize }}"
              data-variant-id="{{ $variantId }}"
              data-variant-image="{{ $variantImage ? asset('uploads/products/' . $variantImage) : asset('assets/images/placeholder.jpg') }}"
              onclick="selectColor('{{ $color }}', '{{ $selectedSize }}', {{ $variantId }}, this)">
            </button>
            @endforeach
          </div>
        </div>

        <!-- Best Offers Section -->
        <div>
          <h3 class="font-medium mb-2">Best Offers</h3>
          <ul class="text-sm text-gray-600 space-y-1">
            <li>
              • Special offer get 25% off
              <span class="text-secondary cursor-pointer">T&C</span>
            </li>
            <li>
              • Bank offer get 30% off on Axis Bank Credit Card
              <span class="text-secondary cursor-pointer">T&C</span>
            </li>
            <li>
              • Wallet offer get 40% cashback via Paytm
              <span class="text-secondary cursor-pointer">T&C</span>
            </li>
          </ul>
        </div>

        <!-- Action Buttons -->
        <div
           class="flex items-center gap-4 pt-4 md:relative fixed md:bottom-auto md:left-auto md:z-0 md:bg-transparent md:backdrop-blur-none lgg:px-0 md:pb-0 bottom-0 left-0 w-full z-[1000] bg-white/32 p-4 backdrop-blur-[23px]"
           data-product-variants="{{ json_encode($product->variants) }}">
          {{-- @if(Auth::check()) --}}
           <button
             id="add-to-cart"
             data-variant-id="{{ $product->variants->first()->id }}"
             class="bg-secondary text-white lgg:px-8 px-4 py-4 rounded-lg hover:bg-secondary/80 font-medium flex-1 text-lg transition">
             <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
           </button>
           <button
             id="wishlist-btn"
             class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition"
             onclick="toggleWishlist({{ $product->id }},this, event);">
             <i class="far fa-heart"></i>
           </button>
          {{-- @else
          <a href="{{ route('page.login', ['redirect' => url()->current()]) }}" class="flex-1">
            <button
              class="bg-secondary text-white lgg:px-8 px-4 py-4 rounded-lg hover:bg-secondary/80 font-medium flex-1 text-lg transition">
              <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
            </button>
          </a>
            <a href="{{ route('page.login', ['redirect' => url()->current()]) }}">
            <button
              class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition">
              <i class="far fa-heart"></i>
            </button>
            </a>
          @endif --}}
        </div>
      </div>
    </div>
  </div>
    @else
    <div class="container mx-auto">
      <div class="w-full text-center mb-6">
        <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
      </div>
    </div>
    @endif
 
</section>

<!-- Fullscreen Modal -->
<div
  class="fixed inset-0 bg-black/95 hidden items-center justify-center z-50 flex"
  id="zoom-modal">
  <button
    class="absolute top-8 right-8 text-white text-4xl hover:text-gray-300 z-10"
    id="close-zoom">
    <i class="fas fa-times"></i>
  </button>
  <div class="max-w-6xl max-h-full p-8">
    <img
      src=""
      id="zoom-modal-image"
      alt="Zoomed Image"
      class="max-w-full max-h-full object-contain" />
  </div>
</div>

<!-- Rest of your sections remain the same -->
<section class="px-4 lgg:py-12 py-6">
  <div class="container mx-auto">
    <!-- DESKTOP TABS -->
    <div class="hidden md:block">
      <div
        class="flex gap-10 border-b text-p-lg xl:text-p-xl 2xl:text-p-2xl">
        <button
          class="tab-btn border-b-2 border-black pb-2 text-black"
          data-tab="details">
          Product Details
        </button>
        <button
          class="tab-btn border-b-2 border-transparent pb-2 text-gray-500"
          data-tab="specification">
          Specification
        </button>
        <button
          class="tab-btn border-b-2 border-transparent pb-2 text-gray-500"
          data-tab="reviews">
          Ratings & Reviews
        </button>
      </div>
      <div class="mt-6 relative">
        <div class="tab-content active" id="details">
          <h3
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-2">
            Product Details
          </h3>
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
            {{ $product->description ?? 'No description available.' }}
          </p>
          @if($product->fabric)
          <h3
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">
            Material & Care
          </h3>
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
            {{ $product->fabric }}<br />
            Machine Wash
          </p>
          @endif
          @if($product->fit)
          <h3
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">
            Size & Fit
          </h3>
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
            {{ $product->fit }}
          </p>
          @endif
        </div>
        <div class="tab-content absolute inset-0" id="specification">
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
            Specification content here
          </p>
        </div>
        <div class="tab-content absolute inset-0" id="reviews">
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
            Ratings & Reviews content here
          </p>
        </div>
      </div>
    </div>

    <!-- MOBILE ACCORDION -->
    <div class="md:hidden border-t border-b divide-y">
      <!-- First Accordion Item (Product Details) - Open by default -->
      <div class="accordion-wrapper active">
        <div class="flex justify-between items-center py-4 cursor-pointer">
          <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Product Details</span>
          <img
            class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300"
            src="./assets/images/arrow-down 1.svg"
            alt="Toggle" />
        </div>
        <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
        <div class="accordion-content-block overflow-hidden">
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl pt-4 pb-4">
            Blue washed jacket, has a spread collar, 4 pockets, button
            closure, long sleeves, straight hem
          </p>
        </div>
      </div>

      <!-- Second Accordion Item (Specification) -->
      <div class="accordion-wrapper">
        <div class="flex justify-between items-center py-4 cursor-pointer">
          <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Specification</span>
          <img
            class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300"
            src="./assets/images/arrow-down 1.svg"
            alt="Toggle" />
        </div>
        <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
        <div class="accordion-content-block overflow-hidden">
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl pt-0 pb-0">
            Specification content here
          </p>
        </div>
      </div>

      <!-- Third Accordion Item (Ratings & Reviews) -->
      <div class="accordion-wrapper">
        <div class="flex justify-between items-center py-4 cursor-pointer">
          <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Ratings & Reviews</span>
          <img
            class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300"
            src="./assets/images/arrow-down 1.svg"
            alt="Toggle" />
        </div>
        <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
        <div class="accordion-content-block overflow-hidden">
          <p
            class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl pt-0 pb-0">
            Reviews content here
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Related Products Section -->
<section class="px-4 lgg:py-12 py-6">
  <div class="container mx-auto">
    <div
      class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
      <!-- Left Title -->
      <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
        Trending Best Selling Products
      </h2>
    </div>

    <div class="main-owl owl-carousel owl-theme">
      @if(isset($relatedProducts))
      @forelse($relatedProducts as $relatedProduct)
      @php
          $variant = $relatedProduct->variants->first();
      @endphp

      <div class="item flex items-center justify-center">
        <div
          class="group w-full xxs:max-w-full max-w-[300px] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
          <!-- Image Wrapper -->
         
          <div class="relative rounded-xl overflow-hidden">
            <img
              src="{{ $relatedProduct->images->first() ? asset($relatedProduct->images->first()->image) : asset('assets/images/placeholder.jpg') }}"
              alt="{{ $relatedProduct->name }}"
              class="w-full h-[340px] object-cover object-top object-center" />

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
              @if($relatedProduct->is_trending ?? false)
              <span
                class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                Trending
              </span>
              @endif
                @if($variant && $variant->discount)
                    <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                      @if($variant->discount == 0)
                      Trending
                      @else
                        OFF {{ $variant->discount }}%
                      @endif
                    </span>
                @endif

            </div>

            <!-- Wishlist Heart Icon (Top Right) -->
            <button
             
              class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
               onclick="toggleWishlist({{ $variant->product_id }}, this,event);">
               <i class="far fa-heart"></i>
              {{-- <svg
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
              </svg> --}}
            </button>
            {{-- <button
            id="wishlist-btn"
            class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition"
            onclick="toggleWishlist({{ $variant->product_id }}, event);">
            <i class="far fa-heart"></i>
          </button> --}}

            <!-- Add To Cart (Hidden → Hover Show) -->
            {{-- <div
              class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
              <button data-variant-id="{{ $relatedProduct->variant_id ?? $relatedProduct->id }}" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                Add To Cart
              </button>
            </div> --}}
          </div>

          <!-- Content -->
           <a href="{{route('page.single-product', $relatedProduct->slug)}}">
          <div class="p-4 space-y-1">
            <h3 class="text-[15px] font-semibold text-gray-900">
              {{ $relatedProduct->name }}
            </h3>

            <div class="flex items-center gap-2 text-sm text-gray-600">
              <span>{{ $relatedProduct->brand ?? '' }}</span>
              <span class="flex items-center gap-1 text-gray-700">
                <span class="text-sm font-medium">{{ $relatedProduct->rating ?? '4.4' }}</span>
              </span>
            </div>

            <div class="flex items-center gap-2 mt-2 flex-wrap">
              <span class="text-lg font-bold text-gray-900">Rs. {{ $variant->discount_price ?? $variant->price }}</span>
              @if($variant->discount_price)
              <span class="text-sm text-gray-400 line-through">Rs. {{ $variant->price }}</span>
              @endif
            </div>
          </div>
          </a>
        </div>
      </div>
      @empty
      <div class="item flex items-center justify-center">
        <p class="text-gray-500">No related products found.</p>
      </div>
      @endforelse
      @else
      <div class="item flex items-center justify-center">
        <p class="text-gray-500">Related products not available.</p>
      </div>
      @endif
    </div>
  </div>
</section>

<!-- Editor's Pick Section -->
<section class="px-4 lgg:py-12 py-6">
  <div class="container mx-auto">
    <div class="w-full text-center mb-6">
      <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
        Editor's Pick
      </h2>
    </div>
    <div class="grid-container">
      <!-- Owl Carousel for mobile/tablet -->
      <div class="owl-carousel banner-carousel lgg:hidden">
        <!-- Slide 1 -->
        <div
          class="relative bg-[#b8a89a] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
          <img
            src="./assets/images/Home-image/pic-8.avif"
            alt="Traditional Blouse"
            class="absolute inset-0 w-full h-full object-cover object-center object-top" />
          <div
            class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
            <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">
              Trendy To<br />Traditional Blouses
            </h2>
            <p class="text-sm text-black mb-6">
              Get <span class="font-semibold">7% OFF</span> | Use Code:
              <span class="text-[#c28b54] font-medium">GLAM7</span>
            </p>
            <button
              class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
              SHOP NOW
            </button>
          </div>
        </div>

        <!-- Slide 2 -->
        <div
          class="relative bg-[#e8dcd6] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
          <img
            src="./assets/images/Home-image/pic-9.avif"
            alt="Jewellery Edit"
            class="absolute inset-0 w-full h-full object-cover object-center object-top" />
          <div
            class="relative z-10 flex flex-col justify-center h-full p-10">
            <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">
              Jewellery Edit
            </h2>
            <p class="text-sm text-black mb-6">
              Get <span class="font-semibold">7% OFF</span> | Use Code:
              <span class="text-[#c28b54] font-medium">GLAM7</span>
            </p>
            <button
              class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
              SHOP NOW
            </button>
          </div>
        </div>
      </div>

      <!-- Original grid layout for desktop -->
      <div
        class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[600px] min-h-[500px] h-[50vh]">
        <!-- Left Banner -->
        <div class="relative bg-[#b8a89a] overflow-hidden">
          <img
            src="./assets/images/Home-image/pic-10.avif"
            alt="Traditional Blouse"
            class="absolute inset-0 w-full h-full object-cover object-center object-top" />
          <div
            class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
            <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">
              Trendy To<br />Traditional Blouses
            </h2>
            <p class="text-sm text-black mb-6">
              Get <span class="font-semibold">7% OFF</span> | Use Code:
              <span class="text-[#c28b54] font-medium">GLAM7</span>
            </p>
            <button
              class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
              SHOP NOW
            </button>
          </div>
        </div>

        <!-- Right Banner -->
        <div class="relative bg-[#e8dcd6] overflow-hidden">
          <img
            src="./assets/images/Home-image/pic-11.avif"
            alt="Jewellery Edit"
            class="absolute inset-0 w-full h-full object-cover object-center object-top" />
          <div
            class="relative z-10 flex flex-col justify-center h-full p-10">
            <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">
              Jewellery Edit
            </h2>
            <p class="text-sm text-black mb-6">
              Get <span class="font-semibold">7% OFF</span> | Use Code:
              <span class="text-[#c28b54] font-medium">GLAM7</span>
            </p>
            <button
              class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
              SHOP NOW
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 @else
  <div class="container mx-auto ">
    <div class="w-full text-center mb-6 mt-5">
      <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
    </div>
  </div>
  @endif
<!-- Trending Products Section -->
{{-- <section class="px-4 lgg:py-12 py-6">
  <div class="container mx-auto">
    <div
      class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
      <!-- Left Title -->
      <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
        Trending Best Selling Products
      </h2>
    </div>

    <div class="main-owl owl-carousel owl-theme">
      <div class="item flex justify-center items-center">
        <div
          class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
          <!-- Image Wrapper -->
          <div class="relative rounded-xl overflow-hidden">
            <img
              src="./assets/images/Home-image/pic-18.avif"
              alt="Silver Lehenga"
              class="w-full h-[340px] object-cover object-top object-center" />

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
              <span
                class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                Trending
              </span>
              <span
                class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                -17%
              </span>
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
              class="absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
              <button
                class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                Add To Cart
              </button>
            </div>
          </div>

          <!-- Content -->
          <div class="p-4 space-y-1">
            <h3 class="text-[15px] font-semibold text-gray-900">
              Womens Denim Jacket
            </h3>

            <div class="flex items-center gap-2 text-sm text-gray-600">
              <span>Brand Name</span>
              <span class="flex items-center gap-1 text-gray-700">
                <span class="text-sm font-medium">4.4</span>
              </span>
            </div>

            <div class="flex items-center gap-2 mt-2 flex-wrap">
              <span class="text-lg font-bold text-gray-900">Rs. 700</span>
              <span class="text-sm text-gray-400 line-through">Rs. 1000</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Add more product items as needed -->
    </div>
  </div>
</section> --}}
@php
    $variant = $product?->variants?->first();
    $basePrice = $variant?->discount_price 
                ?? $variant?->price 
                ?? 0;
@endphp
<script src="{{asset('web/js/single-product.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const loginUrl="{{route('page.login')}}";
  </script>
<script>
  // Store all product variants data
  const productVariants = JSON.parse(document.querySelector('[data-product-variants]').getAttribute('data-product-variants'));
  // if({{$product == true }}){
    
  
  let selectedSize = '{{ $product?->variants?->first()->size ?? "M" }}' ?? '' ;
  let selectedColor = '{{ $product?->variants?->first()->color ?? "" }}' ?? '';
  // }

  let selectedType = 'stitched'; // Default type
  let customDimensions = null;
  let selectedCustomColor = null;
  
  // Custom dimensions and color functionality
  document.addEventListener('DOMContentLoaded', function() {
    const saveDimensionBtn = document.getElementById('save-dimension-btn');
    const cancelCustomBtn = document.getElementById('cancel-custom-btn');
    const customBustInput = document.getElementById('custom-bust');
    const customWaistInput = document.getElementById('custom-waist');
    const customHipInput = document.getElementById('custom-hip');
    const customArmholeInput = document.getElementById('custom-armhole');
    
    // Custom color selection
    const customColorBtns = document.querySelectorAll('.custom-color-btn');
    let selectedCustomColor = null;
    
    // Handle color button clicks
    if (customColorBtns) {
      console.log('Found color buttons:', customColorBtns.length);
      
      customColorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          console.log('Color button clicked:', this.getAttribute('data-color'));
          
          // Remove active state from all buttons
          customColorBtns.forEach(b => b.classList.remove('ring-2', 'ring-offset-2', 'bg-blue-500'));
          
          // Add active state to clicked button
          this.classList.add('ring-2', 'ring-offset-2', 'bg-blue-500');
          selectedCustomColor = this.getAttribute('data-color');
          
          console.log('Selected custom color updated to:', selectedCustomColor);
        });
      });
    } else {
      console.log('No color buttons found');
    }
    
    // Handle save dimensions
    if (saveDimensionBtn) {
      saveDimensionBtn.addEventListener('click', function() {
        console.log('Save button clicked!');
        
        // Get fresh references to inputs
        const bustInput = document.getElementById('custom-bust');
        const waistInput = document.getElementById('custom-waist');
        const hipInput = document.getElementById('custom-hip');
        const armholeInput = document.getElementById('custom-armhole');
        
        console.log('Input elements found:', {
          bustInput: !!bustInput,
          waistInput: !!waistInput,
          hipInput: !!hipInput,
          armholeInput: !!armholeInput
        });
        
        // Check if inputs exist before accessing their values
        const dimensions = {
          product_id: {{ $product->id }},
          bust: bustInput ? (bustInput.value || null) : null,
          waist: waistInput ? (waistInput.value || null) : null,
          hip: hipInput ? (hipInput.value || null) : null,
          armhole: armholeInput ? (armholeInput.value || null) : null,
          color_code: selectedCustomColor
        };
        
        console.log('Saving custom dimensions:', dimensions);
        console.log('Selected color:', selectedCustomColor);
        
        // Disable button and show loading
        const originalText = saveDimensionBtn.innerHTML;
        saveDimensionBtn.disabled = true;
        saveDimensionBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        
        // Send to backend
        fetch('/custom-dimensions', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
          },
          body: JSON.stringify(dimensions)
        })
        .then(response => {
          if (response.status === 401) {
            // User not authenticated, redirect to login
            return response.json().then(data => {
              window.location.href = data.redirect;
              throw new Error('Authentication required');
            });
          }
          return response.json();
        })
        .then(data => {
          console.log('Response received:', data);
          
          if (data.success) {
            console.log('Success! Showing notification...');
            
            // Show SweetAlert2 success message
            Swal.fire({
              icon: 'success',
              title: 'Request Sent!',
              text: 'Your custom dimension request has been sent! Our team will contact you within 24 hours.',
              confirmButtonColor: '#10b981',
              timer: 5000,
              timerProgressBar: true
            });
            
            // Try to show notification
            try {
              showNotification('Your custom dimension request has been sent! Our team will contact you within 24 hours.', 'success');
              console.log('Notification function called successfully');
            } catch (error) {
              console.error('Error calling showNotification:', error);
            }
            
            // Clear inputs
            if (bustInput) bustInput.value = '';
            if (waistInput) waistInput.value = '';
            if (hipInput) hipInput.value = '';
            if (armholeInput) armholeInput.value = '';
            
            // Remove color selection
            if (customColorBtns) {
              customColorBtns.forEach(btn => btn.classList.remove('ring-2', 'ring-offset-2', 'bg-blue-500'));
              selectedCustomColor = null;
            }
          } else {
            console.log('Error in response:', data.message);
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message || 'Failed to save custom dimensions',
              confirmButtonColor: '#ef4444'
            });
            showNotification(data.message || 'Failed to save custom dimensions', 'error');
          }
        })
        .catch(error => {
          if (error.message !== 'Authentication required') {
            console.error('Error:', error);
            showNotification('An error occurred while saving custom dimensions', 'error');
          }
        })
        .finally(() => {
          // Re-enable button
          saveDimensionBtn.disabled = false;
          saveDimensionBtn.innerHTML = originalText;
        });
      });
    } else {
      console.log('Save dimension button not found!');
    }
    
    // Handle cancel custom dimensions
    if (cancelCustomBtn) {
      cancelCustomBtn.addEventListener('click', function() {
        // Clear all inputs
        if (customBustInput) customBustInput.value = '';
        if (customWaistInput) customWaistInput.value = '';
        if (customHipInput) customHipInput.value = '';
        if (customArmholeInput) customArmholeInput.value = '';
        
        // Remove color selection
        if (customColorBtns) {
          customColorBtns.forEach(btn => btn.classList.remove('ring-2', 'ring-offset-2', 'bg-blue-500'));
          selectedCustomColor = null;
        }
        
        console.log('Custom dimensions cancelled');
      });
    }
  });
  
  // Type selection
  function selectType(type) {
    selectedType = type;

    // Update type button styles
    document.querySelectorAll('.type-btn').forEach(btn => {
      if (btn.getAttribute('data-type') === type) {
        btn.classList.add('border-secondary', 'bg-secondary/10', 'text-secondary');
        btn.classList.remove('border-gray-300', 'text-gray-700');
      } else {
        btn.classList.remove('border-secondary', 'bg-secondary/10', 'text-secondary');
        btn.classList.add('border-gray-300', 'text-gray-700');
      }
    });

    // Update custom dimension button style
    const customBtn = document.getElementById('custom-dimension-btn');
    if (customDimensions) {
      customBtn.classList.add('border-secondary', 'text-secondary', 'bg-secondary/10');
    } else {
      customBtn.classList.remove('border-secondary', 'text-secondary', 'bg-secondary/10');
      customBtn.classList.add('border-dashed', 'border-gray-400', 'text-gray-600');
    }

    // Update price based on type
    updatePriceForType();
  }

  // Toggle custom dimension section
  function toggleCustomDimension() {
    const section = document.getElementById('custom-dimension-section');
    const customBtn = document.getElementById('custom-dimension-btn');

    if (section.classList.contains('hidden')) {
      section.classList.remove('hidden');
      customBtn.classList.add('border-secondary', 'text-secondary', 'bg-secondary/10');
      customBtn.classList.remove('border-dashed', 'border-gray-400', 'text-gray-600');

      // Hide size and color selection when custom dimension is open
      document.getElementById('size-selection-section').classList.add('hidden');
      document.getElementById('color-selection-section').classList.add('hidden');
    } else {
      section.classList.add('hidden');
      customBtn.classList.remove('border-secondary', 'text-secondary', 'bg-secondary/10');
      customBtn.classList.add('border-dashed', 'border-gray-400', 'text-gray-600');

      // Show size and color selection when custom dimension is closed
      document.getElementById('size-selection-section').classList.remove('hidden');
      document.getElementById('color-selection-section').classList.remove('hidden');
    }
  }

  // Save custom dimensions
  function saveCustomDimension() {
    const height = document.getElementById('custom-height').value;
    const width = document.getElementById('custom-width').value;

    if (!height || !width) {
      showNotification('Please enter both height and width', 'error');
      return;
    }

    if (height <= 0 || width <= 0) {
      showNotification('Height and width must be positive numbers', 'error');
      return;
    }

    // Get selected color from custom color buttons
    const selectedColorBtn = document.querySelector('#custom-color-selection .border-secondary');
    const selectedColor = selectedColorBtn ? selectedColorBtn.getAttribute('data-color') : null;

    if (!selectedColor) {
      showNotification('Please select a color', 'error');
      return;
    }

    customDimensions = {
      height: parseFloat(height),
      width: parseFloat(width),
      color: selectedColor,
      type: selectedType
    };

    selectedCustomColor = selectedColor;

    showNotification('Custom dimensions saved successfully!', 'success');

    // Close the custom dimension section
    toggleCustomDimension();

    // Update add to cart button for custom dimension
    const addToCartBtn = document.getElementById('add-to-cart');
    addToCartBtn.setAttribute('data-custom-dimensions', JSON.stringify(customDimensions));
    addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add Custom Item to Cart';

    // Calculate custom price (you can adjust this based on your pricing logic)
    updateCustomPrice();
  }

  // Update price for custom dimension
  function updateCustomPrice() {
    
    if (!customDimensions) return;
    
    // Calculate custom price (example: base price + (area * price per sq cm))
    const basePrice = {{ $basePrice ?? 0 }};
  
    const area = customDimensions.height * customDimensions.width;
    const pricePerSqCm = basePrice / 1000; // Example calculation
    const customPrice = Math.round(basePrice + (area * pricePerSqCm));

    const priceContainer = document.getElementById('price-container');
    priceContainer.innerHTML = `
        <span class="text-2xl font-bold text-gray-900">Rs. ${customPrice}</span>
        <span class="text-sm text-gray-500">(Custom: ${customDimensions.height}cm × ${customDimensions.width}cm)</span>
    `;
  
  }

  // Update price based on type
  function updatePriceForType() {
    const selectedVariant = getSelectedVariant();
    if (selectedVariant) {
      updatePrice(selectedVariant);
    }
  }

  function selectSize(size) {
    selectedSize = size;

    // Update size button styles
    document.querySelectorAll('.size-btn').forEach(btn => {
      if (btn.getAttribute('data-size') === size) {
        btn.classList.add('bg-secondary', 'text-white');
      } else {
        btn.classList.remove('bg-secondary', 'text-white');
      }
    });

    // Update color options for selected size
    updateColorOptions(size);

    // Clear custom dimensions when selecting a standard size
    if (customDimensions) {
      customDimensions = null;
      selectedCustomColor = null;
      const addToCartBtn = document.getElementById('add-to-cart');
      addToCartBtn.removeAttribute('data-custom-dimensions');
      addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';

      // Reset custom dimension button
      const customBtn = document.getElementById('custom-dimension-btn');
      customBtn.classList.remove('border-secondary', 'text-secondary', 'bg-secondary/10');
      customBtn.classList.add('border-dashed', 'border-gray-400', 'text-gray-600');
    }
  }

  function updateColorOptions(size) {
    const colorSelection = document.getElementById('color-selection');
    const colorsForSize = productVariants.filter(variant => variant.size === size);

    // Clear existing color options
    colorSelection.innerHTML = '';

    if (colorsForSize.length === 0) {
      colorSelection.innerHTML = '<p class="text-gray-500">No colors available for this size.</p>';
      return;
    }

    // Generate color options for selected size
    colorsForSize.forEach((variant, index) => {
      const colorBtn = document.createElement('button');
      colorBtn.className = `color-btn w-10 h-10 rounded-full border-2 ${index === 0 ? 'border-secondary' : 'border-gray-300'} transition-all hover:scale-110`;
      colorBtn.style.backgroundColor = variant.color;
      colorBtn.setAttribute('data-color', variant.color);
      colorBtn.setAttribute('data-size', size);
      colorBtn.setAttribute('data-variant-id', variant.id);
      
      // Add event listener instead of onclick
      colorBtn.addEventListener('click', function() {
        selectColor(variant.color, size, variant.id, this);
      });

      colorSelection.appendChild(colorBtn);
    });

    // Auto-select first color
    if (colorsForSize.length > 0) {
      const firstColor = colorsForSize[0].color;
      const firstColorBtn = colorSelection.querySelector('.color-btn');
      if (firstColorBtn) {
        selectColor(firstColor, size, colorsForSize[0].id, firstColorBtn);
      }
    }
  }

  function selectColor(color, size, variantId, element) {
    selectedColor = color;

    // Update color button styles
    document.querySelectorAll('.color-btn').forEach(btn => {
      if (btn.getAttribute('data-color') === color && btn.getAttribute('data-size') === size) {
        btn.classList.add('border-secondary');
        btn.classList.remove('border-gray-300');
      } else {
        btn.classList.remove('border-secondary');
        btn.classList.add('border-gray-300');
      }
    });

    // Update add to cart button with selected variant ID
    const addToCartBtn = document.getElementById('add-to-cart');
    addToCartBtn.setAttribute('data-variant-id', variantId);

    // Clear custom dimensions when selecting a standard color
    if (customDimensions) {
      customDimensions = null;
      selectedCustomColor = null;
      addToCartBtn.removeAttribute('data-custom-dimensions');
      addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
    }

    // Update main image for selected variant
    const variantImage = element.getAttribute('data-variant-image');
    if (variantImage) {
      const mainImage = document.getElementById('main-image');
      if (mainImage) {
        mainImage.src = variantImage;
        mainImage.alt = `${color} ${size} - {{ $product?->name }}`;
      }
    }

    // Update price for selected variant
    const selectedVariant = productVariants.find(v => v.size === size && v.color === color);
    if (selectedVariant) {
      updatePrice(selectedVariant);
    }

    // Check if this variant is already in cart
    checkVariantInCart(variantId);
  }

  function getSelectedVariant() {
    if (customDimensions) {
      return null; // Custom dimension selected
    }
    return productVariants.find(v => v.size === selectedSize && v.color === selectedColor);
  }

  function updatePrice(variant) {
    console.log('Updating price for variant:', variant);
    const priceContainer = document.getElementById('price-container');
    if (priceContainer && variant) {
      const currentPrice = variant.discount_price || variant.price;
      const originalPrice = variant.price;
      const discount = variant.discount;
      console.log('Current price:', currentPrice, 'Original price:', originalPrice);

      priceContainer.innerHTML = `
            <span class="text-2xl font-bold text-gray-900">Rs. ${currentPrice}</span>
           
                <span class="line-through text-gray-400">Rs. ${originalPrice}</span>
                ${discount > 0 ? `
                 <span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">
                     (${discount}% off)
                 </span>` : `<span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">
                    Trending
                </span>`}
        `;
    }
  }

  // Initialize on page load
  document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for type buttons
    document.querySelectorAll('.type-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const type = this.getAttribute('data-type');
        selectType(type);
      });
    });

    // Add event listener for custom dimension button
    const customDimensionBtn = document.getElementById('custom-dimension-btn');
    if (customDimensionBtn) {
      customDimensionBtn.addEventListener('click', toggleCustomDimension);
    }

    // Add event listener for save dimension button
    const saveDimensionBtn = document.getElementById('save-dimension-btn');
    if (saveDimensionBtn) {
      saveDimensionBtn.addEventListener('click', saveCustomDimension);
    }

    // Add event listener for cancel custom dimension button
    const cancelCustomBtn = document.getElementById('cancel-custom-btn');
    if (cancelCustomBtn) {
      cancelCustomBtn.addEventListener('click', toggleCustomDimension);
    }

    // Add event listeners for custom color buttons
    document.querySelectorAll('.custom-color-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        // Remove border-secondary from all custom color buttons
        document.querySelectorAll('.custom-color-btn').forEach(b => {
          b.classList.remove('border-secondary');
          b.classList.add('border-gray-300');
        });
        
        // Add border-secondary to clicked button
        this.classList.add('border-secondary');
        this.classList.remove('border-gray-300');
      });
    });

    // Add event listeners for size buttons (if they exist in HTML)
    document.querySelectorAll('.size-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const size = this.getAttribute('data-size');
        selectSize(size);
      });
    });

    // Set initial type
    selectType('stitched');

    // Set initial size
    selectSize(selectedSize);

    // Add event listener for add to cart button
    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
      addToCartBtn.addEventListener('click', function(event) {
        addToCart(null, event);
      });

      // Check if initial variant is already in cart
      const initialVariantId = addToCartBtn.getAttribute('data-variant-id');
      if (initialVariantId) {
        checkVariantInCart(initialVariantId);
      }
    }

    // Check if product is already in wishlist
    checkProductInWishlist({{$product?->id}});
  });

  // Check if variant is in cart and update button
  function checkVariantInCart(variantId) {
    if (!variantId) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/cart/check', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          variant_id: variantId
        })
      })
      .then(response => response.json())
      .then(data => {
        updateAddToCartButton(data.in_cart, data.quantity);
      })
      .catch(error => {
        console.error('Error checking cart:', error);
      });
  }

  // Check if product is in wishlist and update button
  function checkProductInWishlist(productId) {
    if (!productId) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/wishlist/check', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          product_id: productId
        })
      })
      .then(response => response.json())
      .then(data => {
        updateWishlistButton(data.in_wishlist);
      })
      .catch(error => {
        console.error('Error checking wishlist:', error);
      });
  }

  // Update wishlist button based on wishlist status
  function updateWishlistButton(inWishlist) {
    const wishlistBtn = document.getElementById('wishlist-btn');
    if (!wishlistBtn) return;

    if (inWishlist) {
      wishlistBtn.innerHTML = '<i class="fas fa-heart"></i>';
      wishlistBtn.classList.add('border-red-500', 'text-red-500');
      wishlistBtn.classList.remove('border-gray-300');
    } else {
      wishlistBtn.innerHTML = '<i class="far fa-heart"></i>';
      wishlistBtn.classList.remove('border-red-500', 'text-red-500');
      wishlistBtn.classList.add('border-gray-300');
    }
  }

  // Toggle wishlist
  // function toggleWishlist(productId, event) {
  //   if (event) {
  //     event.preventDefault();
  //     event.stopPropagation();
  //   }

  //   if (!productId) {
  //     alert('Product ID not found');
  //     return;
  //   }

  //   const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  //   const wishlistBtn = document.getElementById('wishlist-btn');
  //   const isInWishlist = wishlistBtn.classList.contains('text-red-500');

  //   const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';

  //   // Show loading state
  //   const originalContent = wishlistBtn.innerHTML;
  //   wishlistBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
  //   wishlistBtn.disabled = true;

  //   fetch(url, {
  //       method: 'POST',
  //       headers: {
  //         'Content-Type': 'application/json',
  //         'X-CSRF-TOKEN': csrfToken
  //       },
  //       body: JSON.stringify({
  //         product_id: productId
  //       })
  //     })
  //     .then(response => response.json())
  //     .then(data => {
  //       if (data.success) {
  //         showNotification(data.message, 'success');
  //         updateWishlistButton(!isInWishlist);

  //         // Update wishlist count if you have a counter
  //         if (data.wishlist_count !== undefined) {
  //           updateWishlistCount(data.wishlist_count);
  //         }
  //       } else {
  //         showNotification(data.message || 'Failed to update wishlist', 'error');
  //       }
  //     })
  //     .catch(error => {
  //       console.error('Error:', error);
  //       showNotification('An error occurred while updating wishlist', 'error');
  //     })
  //     .finally(() => {
  //       wishlistBtn.disabled = false;
  //     });
  // }
  function toggleWishlist(productId, button, event) {

    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    if (!productId) {
        alert('Product ID not found');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const isInWishlist = button.classList.contains('text-red-500');
    const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';

    // Show loading
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => {
      if(response.status === 401) {
          const currentUrl = window.location.href;
          window.location.href = loginUrl + '?redirect=' + encodeURIComponent(currentUrl);
          return;
        }
    
    return response.json();
  })
    .then(data => {

        if (data.success) {

            // Toggle UI
            if (isInWishlist) {
                button.classList.remove('text-red-500');
                button.innerHTML = '<i class="far fa-heart"></i>';
            } else {
                button.classList.add('text-red-500');
                button.innerHTML = '<i class="fas fa-heart"></i>';
            }

        } else {

    

        Swal.fire({
            icon: 'info',
            title: 'Already Added',
            text: data.message,
            // showConfirmButton: false,
            ConfirmButtonText: 'Ok',
            timer: 1800
        });

        // Keep heart filled
        button.classList.add('text-red-500');
        button.innerHTML = '<i class="fas fa-heart"></i>';

    
}


    })
    .catch(error => {
        console.error(error);
    })
    .finally(() => {
        button.disabled = false;
    });
}


  // Update wishlist count (if you have a counter)
  function updateWishlistCount(count) {
    // Update your wishlist counter element here
    const wishlistCounter = document.getElementById('wishlist-counter');
    if (wishlistCounter) {
      wishlistCounter.textContent = count;
    }
  }

  // Update add to cart button based on cart status
  function updateAddToCartButton(inCart, quantity = 0) {
    const addToCartBtn = document.getElementById('add-to-cart');
    if (!addToCartBtn) return;

    if (inCart) {
      addToCartBtn.innerHTML = `<i class="fas fa-check mr-2"></i> Added (${quantity})`;
      addToCartBtn.classList.remove('bg-secondary');
      addToCartBtn.classList.add('bg-green-600');
      addToCartBtn.disabled = true;
    } else {
      if (customDimensions) {
        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add Custom Item to Cart';
      } else {
        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
      }
      addToCartBtn.classList.remove('bg-green-600');
      addToCartBtn.classList.add('bg-secondary');
      addToCartBtn.disabled = false;
    }
  }

  // Add to Cart function
  function addToCart(variantId, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
      alert('Security token not found. Please refresh the page.');
      return;
    }

    const addToCartBtn = document.getElementById('add-to-cart');

    // Check if custom dimension is selected
    const customDimensionsAttr = addToCartBtn.getAttribute('data-custom-dimensions');
    let requestData = {};

    if (customDimensionsAttr) {
      // Add custom dimension to cart
      requestData = {
        product_id: {{ $product?->id }},
        custom_dimensions: JSON.parse(customDimensionsAttr),
        type: selectedType,
        count: 1
      };
    } else {
      // Add standard variant to cart
      if (!variantId) {
        variantId = addToCartBtn.getAttribute('data-variant-id');
      }

      if (!variantId) {
        alert('Please select a size and color');
        return;
      }

      requestData = {
        variant_id: variantId,
        type: selectedType,
        count: 1
      };
    }

    // Disable button and show loading
    const originalText = addToCartBtn.innerHTML;
    addToCartBtn.disabled = true;
    addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';

    // Send AJAX request to add to cart
    fetch('/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
        },
        body: JSON.stringify(requestData)
      })
      .then(response => {
        if(response.status === 401) {
           const currentUrl = window.location.href;
           window.location.href = loginUrl + '?redirect=' + encodeURIComponent(currentUrl);
          return;
        }
       return response.json();
      })
      .then(data => {
        if (data.success) {
          // Show success message
          showNotification('Product added to cart successfully!', 'success');

          // Update cart count if you have a cart counter
          if (data.cart_count !== undefined) {
            updateCartCount(data.cart_count);
          }

          // Update button state
          if (customDimensionsAttr) {
            // For custom dimensions, we don't check cart status
            addToCartBtn.innerHTML = `<i class="fas fa-check mr-2"></i> Added`;
            addToCartBtn.classList.remove('bg-secondary');
            addToCartBtn.classList.add('bg-green-600');
            addToCartBtn.disabled = true;
          } else {
            // For standard variants, check cart status
            checkVariantInCart(variantId);
          }
        } else {
          showNotification(data.message || 'Failed to add product to cart', 'error');
          // Re-enable button on error
          addToCartBtn.disabled = false;
          addToCartBtn.innerHTML = originalText;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding to cart', 'error');
        // Re-enable button on error
        addToCartBtn.disabled = false;
        addToCartBtn.innerHTML = originalText;
      });
  }

  // Show notification function
  function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;

    // Add to body
    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
      notification.style.opacity = '0';
      setTimeout(() => {
        document.body.removeChild(notification);
      }, 300);
    }, 3000);
  }

  // Update cart count function
  function updateCartCount(count) {
    // Find all cart count elements in navbar
    const cartCountElements = document.querySelectorAll('.cart-count');
    // Target only the navbar cart badge (span with bg-primary class)
    const cartBadges = document.querySelectorAll('.absolute.-top-1.-right-1.w-5.h-5.bg-primary');
    console.log('Cart badges found:', cartBadges.length);

    // Update cart count elements
    cartCountElements.forEach(element => {
      element.textContent = count;
    });
    
    // Update only the navbar cart badges
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
</script>

@endsection