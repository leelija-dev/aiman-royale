@extends('layout.web.main-layout')








@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
  <div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-[55%_40%] gap-6">
      <!-- LEFT IMAGE SECTION -->
      <div class="flex flex-col lg:flex-row gap-2">
        <!-- Thumbnails -->
        <div
          class="flex min-w-24 lg:py-0 py-2 items-center lg:overflow-visible overflow-auto lg:flex-col gap-4 order-2 lg:order-1">
          @forelse($product as $index => $productItem)
            @if($productItem->images)
              <div
                class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 border-transparent cursor-pointer {{ $index == 0 ? 'selected' : '' }}"
                data-display="{{ asset('uploads/products/' . $productItem->images) }}"
                data-large="{{ asset('uploads/products/' . $productItem->images) }}">
                <img
                  src="{{ asset('uploads/products/' . $productItem->images) }}"
                  class="w-full h-full object-cover object-center object-top"
                  alt="{{ $productItem->name }}" />
              </div>
            @endif
          @empty
            <div
              class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 border-transparent cursor-pointer selected"
              data-display="{{ asset('assets/images/placeholder.jpg') }}"
              data-large="{{ asset('assets/images/placeholder.jpg') }}">
              <img
                src="{{ asset('assets/images/placeholder.jpg') }}"
                class="w-full h-full object-cover object-center object-top"
              alt="{{ $product[0]->name ?? 'Product' }}" />
            </div>
          @endforelse
        </div>

        <!-- Main Image with Hover Pan Zoom -->
        <div
          class="zoom-container w-full relative group order-1 lg:order-2 h-full">
          <img
            src="{{ $product->firstWhere('images') ? asset('uploads/products/' . $product->firstWhere('images')->images) : asset('assets/images/placeholder.jpg') }}"
            class="w-full h-full object-cover object-center object-top"
            alt="{{ $product[0]->name ?? 'Product' }}"
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
            {{ $product[0]->name }}
          </h3>
          <p class="text-sm text-gray-500 mt-1">{{ $product[0]->brand ?? 'Brand Name' }}</p>
          <p class="text-sm text-gray-500">Sold By: Store</p>
        </div>
        <div class="flex items-center gap-2">
          <div class="flex text-yellow-400 text-sm">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
          </div>
          <span class="text-sm text-gray-500">4.4 · 36 Reviews</span>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-2xl font-bold text-gray-900">Rs. {{ $product[0]->price_after_discount ?? $product[0]->price }}</span>
          @if($product[0]->price_after_discount && $product[0]->price_after_discount != $product[0]->price)
            <span class="line-through text-gray-400">Rs. {{ $product[0]->price }}</span>
            <span
              class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">({{ round((($product[0]->price - $product[0]->price_after_discount) / $product[0]->price) * 100) }}% off)</span>
          @endif
        </div>

        <!-- Size Selection -->
        <div>
          <h3 class="font-medium mb-3 text-gray-800">Select Size</h3>
          <div class="flex gap-3 flex-wrap">
            @php
              $sizes = $product->pluck('size')->unique()->filter();
              $availableSizes = ['XS', 'S', 'M', 'L', 'XL'];
              $allVariants = $product->groupBy(['size', 'color']);
            @endphp
            @foreach($availableSizes as $size)
              @if($sizes->contains($size))
                <button
                  class="size-btn w-12 h-12 rounded-full border text-sm hover:border-secondary transition {{ $size == ($product[0]->size ?? 'M') ? 'bg-secondary text-white' : '' }}"
                  data-size="{{ $size }}"
                  onclick="updateColorOptions('{{ $size }}')">
                  {{ $size }}
                </button>
              @endif
            @endforeach
          </div>
        </div>

        <!-- Color Selection -->
        <div>
          <h3 class="font-medium mb-3 text-gray-800">Select Color</h3>
          <div class="flex gap-3" id="color-selection">
            @php
              $selectedSize = $product[0]->size ?? 'M';
              $colorsForSize = $product->where('size', $selectedSize)->pluck('color')->unique()->filter();
            @endphp
            @foreach($colorsForSize as $index => $color)
              @php
                $variantForColor = $product->where('size', $selectedSize)->where('color', $color)->first();
              @endphp
              <div
                class="color-option {{ $index == 0 ? 'selected-color' : '' }} w-14 h-20 rounded border-2 cursor-pointer overflow-hidden"
                data-size="{{ $selectedSize }}"
                data-color="{{ $color }}"
                data-variant-id="{{ $variantForColor->variant_id }}"
                data-display="{{ $variantForColor->images ? asset('uploads/products/' . $variantForColor->images) : asset('assets/images/placeholder.jpg') }}"
                data-large="{{ $variantForColor->images ? asset('uploads/products/' . $variantForColor->images) : asset('assets/images/placeholder.jpg') }}"
                onclick="selectVariant(this)">
                @if($variantForColor->images)
                  <img
                    src="{{ asset('uploads/products/' . $variantForColor->images) }}"
                    class="w-full h-full object-cover"
                    alt="{{ $color }}" />
                @else
                  <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">{{ $color }}</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
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

        <div
          class="flex items-center gap-4 pt-4 md:relative fixed md:bottom-auto md:left-auto md:z-0 md:bg-transparent md:backdrop-blur-none lgg:px-0 md:pb-0 bottom-0 left-0 w-full z-[1000] bg-white/32 p-4 backdrop-blur-[23px]"
          data-product-variants="{{ json_encode($product) }}">
          <button
            id="add-to-cart"
            data-variant-id="{{ $product[0]->variant_id }}"
            class="bg-secondary text-white lgg:px-8 px-4 py-4 rounded-lg hover:bg-secondary/80 font-medium flex-1 text-lg transition">
            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
          </button>
          <button
            id="wishlist-btn"
            class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition">
            <i class="far fa-heart"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
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
            {{ $product[0]->description ?? 'No description available.' }}
          </p>
          @if($product[0]->fabric)
            <h3
              class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">
              Material & Care
            </h3>
            <p
              class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
              {{ $product[0]->fabric }}<br />
              Machine Wash
            </p>
          @endif
          @if($product[0]->fit)
            <h3
              class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">
              Size & Fit
            </h3>
            <p
              class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
              {{ $product[0]->fit }}
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
          <div class="item flex items-center justify-center">
            <div
              class="group w-full xxs:max-w-full max-w-[300px] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <!-- Image Wrapper -->
            <div class="relative rounded-xl overflow-hidden">
              <img
                src="{{ $relatedProduct->images->first() ? asset('uploads/products/' . $relatedProduct->images->first()->image) : asset('assets/images/placeholder.jpg') }}"
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
                @if($relatedProduct->discount_price)
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                    -{{ round((($relatedProduct->price - $relatedProduct->discount_price) / $relatedProduct->price) * 100) }}%
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
                class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                <button data-variant-id="{{ $relatedProduct->variant_id ?? $relatedProduct->id }}" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                  Add To Cart
                </button>
              </div>
            </div>

            <!-- Content -->
            <div class="p-4 space-y-1">
              <h3 class="text-[15px] font-semibold text-gray-900">
                {{ $relatedProduct->name }}
              </h3>

              <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>{{ $relatedProduct->brand ?? 'Brand Name' }}</span>
                <span class="flex items-center gap-1 text-gray-700">
                  <span class="text-sm font-medium">{{ $relatedProduct->rating ?? '4.4' }}</span>
                </span>
              </div>

              <div class="flex items-center gap-2 mt-2 flex-wrap">
                <span class="text-lg font-bold text-gray-900">Rs. {{ $relatedProduct->discount_price ?? $relatedProduct->price }}</span>
                @if($relatedProduct->discount_price)
                  <span class="text-sm text-gray-400 line-through">Rs. {{ $relatedProduct->price }}</span>
                @endif
              </div>
            </div>
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
      <div class="item flex justify-center items-center">
        <div
          class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
          <!-- Image Wrapper -->
          <div class="relative rounded-xl overflow-hidden">
            <img
              src="./assets/images/Home-image/pic-19.avif"
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
      <div class="item flex justify-center items-center">
        <div
          class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
          <!-- Image Wrapper -->
          <div class="relative rounded-xl overflow-hidden">
            <img
              src="./assets/images/Home-image/pic-20.avif"
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
      <div class="item flex justify-center items-center">
        <div
          class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
          <!-- Image Wrapper -->
          <div class="relative rounded-xl overflow-hidden">
            <img
              src="./assets/images/Home-image/pic-21.avif"
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
</section>

<script src="{{asset('web/js/single-product.js')}}"></script>

<script>
// Store all product variants data
const productVariants = JSON.parse(document.querySelector('[data-product-variants]').getAttribute('data-product-variants'));

function updateColorOptions(selectedSize) {
    const colorSelection = document.getElementById('color-selection');
    const colorsForSize = productVariants.filter(variant => variant.size === selectedSize);
    
    // Clear existing color options
    colorSelection.innerHTML = '';
    
    if (colorsForSize.length === 0) {
        colorSelection.innerHTML = '<p class="text-gray-500">No colors available for this size.</p>';
        return;
    }
    
    // Generate color options for selected size
    colorsForSize.forEach((variant, index) => {
        const colorDiv = document.createElement('div');
        colorDiv.className = `color-option ${index === 0 ? 'selected-color' : ''} w-14 h-20 rounded border-2 cursor-pointer overflow-hidden`;
        colorDiv.setAttribute('data-size', selectedSize);
        colorDiv.setAttribute('data-color', variant.color);
        colorDiv.setAttribute('data-variant-id', variant.variant_id);
        colorDiv.setAttribute('data-display', variant.images ? `{{ asset('uploads/products/') }}${variant.images}` : '{{ asset("assets/images/placeholder.jpg") }}');
        colorDiv.setAttribute('data-large', variant.images ? `{{ asset('uploads/products/') }}${variant.images}` : '{{ asset("assets/images/placeholder.jpg") }}');
        colorDiv.setAttribute('onclick', 'selectVariant(this)');
        
        if (variant.images) {
            colorDiv.innerHTML = `<img src="{{ asset('uploads/products/') }}${variant.images}" class="w-full h-full object-cover" alt="${variant.color}" />`;
        } else {
            colorDiv.innerHTML = `<div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">${variant.color}</div>`;
        }
        
        colorSelection.appendChild(colorDiv);
    });
    
    // Update size button styles
    document.querySelectorAll('.size-btn').forEach(btn => {
        if (btn.getAttribute('data-size') === selectedSize) {
            btn.classList.add('bg-secondary', 'text-white');
        } else {
            btn.classList.remove('bg-secondary', 'text-white');
        }
    });
    
    // Auto-select first color and update variant
    if (colorsForSize.length > 0) {
        const firstColorOption = colorSelection.querySelector('.color-option');
        if (firstColorOption) {
            selectVariant(firstColorOption);
        }
    }
}

function selectVariant(element) {
    // Update color selection styles
    document.querySelectorAll('.color-option').forEach(option => {
        option.classList.remove('selected-color');
    });
    element.classList.add('selected-color');
    
    // Update add to cart button with selected variant ID
    const addToCartBtn = document.getElementById('add-to-cart');
    const variantId = element.getAttribute('data-variant-id');
    addToCartBtn.setAttribute('data-variant-id', variantId);
    
    // Update main image if available
    const displayImage = element.getAttribute('data-display');
    if (displayImage) {
        const mainImage = document.getElementById('main-image');
        if (mainImage) {
            mainImage.src = displayImage;
        }
    }
    
    // Update price for selected variant
    const size = element.getAttribute('data-size');
    const color = element.getAttribute('data-color');
    const selectedVariant = productVariants.find(v => v.size === size && v.color === color);
    
    if (selectedVariant) {
        updatePrice(selectedVariant);
    }
}

function updatePrice(variant) {
    const priceContainer = document.querySelector('.flex.items-center.gap-3');
    if (priceContainer && variant) {
        const currentPrice = variant.price_after_discount || variant.price;
        const originalPrice = variant.price;
        
        priceContainer.innerHTML = `
            <span class="text-2xl font-bold text-gray-900">Rs. ${currentPrice}</span>
            ${variant.price_after_discount && variant.price_after_discount != originalPrice ? 
                `<span class="line-through text-gray-400">Rs. ${originalPrice}</span>
                 <span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">
                     (${Math.round(((originalPrice - currentPrice) / originalPrice) * 100)}% off)
                 </span>` : ''}
        `;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial size based on first product variant
    const initialSize = '{{ $product[0]->size ?? "M" }}';
    updateColorOptions(initialSize);
});

// Add to Cart function
function addToCart(variantId, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Get the variant ID from the button if not provided
    if (!variantId) {
        const addToCartBtn = document.getElementById('add-to-cart');
        variantId = addToCartBtn.getAttribute('data-variant-id');
    }
    
    if (!variantId) {
        alert('Please select a size and color');
        return;
    }
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
   
    // Send AJAX request to add to cart
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            variant_id: variantId,
            count: 1
        })
    })
    .then(response => response.json())
    .then(data => {
      console.log(data)
        if (data.success) {
            // Show success message
            showNotification('Product added to cart successfully!', 'success');
            
            // Update cart count if you have a cart counter
            updateCartCount(data.cart_count);
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding to cart', 'error');
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

// Update cart count function (optional)
function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}

// Add click event listener to add to cart button
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('add-to-cart');
    console.log('Add to cart button found:', addToCartBtn);
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Disable button to prevent multiple clicks
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
            
            const variantId = this.getAttribute('data-variant-id');
            console.log('Add to cart clicked, variant ID:', variantId);
            
            addToCart(variantId, e).finally(() => {
                // Re-enable button after request completes
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
            });
        });
    } else {
        console.error('Add to cart button not found in the DOM');
    }
});
</script>

@endsection