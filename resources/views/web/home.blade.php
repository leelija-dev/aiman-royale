@extends('layout.web.main-layout')

@section('content')

<div class="w-full bg-gradient-to-b from-pink-50/30 via-white to-white px-0 pt-[10px] md:pt-[10px] lgg:hidden block">

    <!-- Animated Gradient Background Decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-purple-200/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-10 w-32 h-32 bg-pink-200/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Enhanced Header with Animation -->
    <div class="relative text-center mb-0 px-2">
        <div class="inline-block mb-3">
            <div class="h-1 w-16 bg-gradient-to-r from-pink-400 to-purple-400 mx-auto rounded-full mb-[2px]"></div>
        </div>
    </div>
    <!-- Horizontal Scroll with Enhanced Styling -->
    <div class="relative overflow-x-auto scrollbar-hide snap-x snap-mandatory px-2">
        <div class="flex gap-6 md:gap-8 pb-4 min-w-max px-4 pt-[10px]">
            @if ($productCategory)
            @foreach ($productCategory->whereNull('parent_id') as $category)

            @php
            @endphp


            <a href="{{ route('category.show', $category->product->category->slug) }}"
                class="group flex flex-col items-center snap-center">
                <div class="relative mb-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
                    </div>
                    {{-- <div
                        class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-pink-100 transition-all duration-300">
                        @php
                        $variantImage = $category->images->sortByDesc('id')->first()?->image;

                        $productImage = $category->product->images->sortByDesc('id')->first()?->image;
                        $catagoryImage = $category->product->category->image;
                        $catImage = $productImage ?: $catagoryImage;

                        // Optional: placeholder if neither exists
                        // if (!$catImage) {
                        // $catImage = asset('assets/images/placeholder-category.jpg');
                        // }

                        if (strpos($catImage, 'cloudinary.com') !== false && strpos($catImage, 'upload/') !== false) {
                        $parts = explode('upload/', $catImage);
                        $catImage = $parts[0] . 'upload/w_550,h_800,c_fill,f_auto,q_auto/' . $parts[1];
                        } 
                       // else{
                       //     $catImage = 'img/' . $catImage . '?w=600&q=80';
                      //   }
                        @endphp
                        <img src="{{ $catImage }}"
                            srcset="{{ $catImage }}?w=200&q=80 200w,
             {{ $catImage }}?w=400&q=80 400w,
             {{ $catImage }}?w=600&q=80 600w"
                            sizes="(max-width: 640px) 200px,
            (max-width: 1024px) 300px,
            400px"
                            alt="{{ $category->product->category->name }}"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                            decoding="async"
                            width="200"
                            height="200">
                    </div> --}}
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl bg-gray-100 group-hover:border-pink-100 transition-all duration-300">
    @php
        $productImage  = $category->product->images->sortByDesc('id')->first()?->image;
        $categoryImage = $category->product->category->image;
        $catImage      = $productImage ?: $categoryImage;

        $catImageUrl    = null;
        $catImageSrcset = null;

        if ($catImage) {
            $isCloudinary = str_contains($catImage, 'cloudinary.com') && str_contains($catImage, 'upload/');

            if ($isCloudinary) {
                $parts = explode('upload/', $catImage, 2);

                // Optimized Cloudinary transformations
                $cld = fn($w, $h) => $parts[0] . "upload/w_{$w},h_{$h},c_fill,f_auto,q_auto,dpr_auto/" . $parts[1];

                $catImageUrl    = $cld(260, 380);          // Default size (smaller = faster)
                $catImageSrcset = $cld(130, 190) . ' 130w, '
                                . $cld(260, 380) . ' 260w, '
                                . $cld(390, 570) . ' 390w';
            } else {
                $catImageUrl = $catImage ?: asset('storage/' . $catImage);
            }
        }
    @endphp

    @if($catImageUrl)
        <img
            src="{{ $catImageUrl }}"
            @if($catImageSrcset)
                srcset="{{ $catImageSrcset }}"
                sizes="(max-width: 640px) 130px, (max-width: 1024px) 180px, 220px"
            @endif
            alt="{{ $category->product->category->name }}"
            class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-110"
            width="200"
            height="200"
            loading="{{ $loop->index < 6 ? 'eager' : 'lazy' }}"
            decoding="async"
        >
    @endif
</div>
                </div>
                <span
                    class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-pink-700 transition-colors duration-300">{{ $category->product->category->name }}</span>
                <span class="text-xs text-gray-500 mt-1">Most Loved</span>
            </a>
            @endforeach
            @endif
        </div>
    </div>
</div>

<!-- updated HTML block – slide structure with Font Awesome icons -->
 @push('head-preload')
    @if(isset($bannerHeroSection[0]))
        @php $first = $bannerHeroSection[0]; @endphp

        {{-- Mobile preload --}}
        <link rel="preload"
              as="image"
              href="{{ asset('storage/uploads/banners/' . $first->mobile_screen_image) }}?w=828&q=75"
              imagesrcset="
                  {{ asset('storage/uploads/banners/' . $first->mobile_screen_image) }}?w=400&q=75 400w,
                  {{ asset('storage/uploads/banners/' . $first->mobile_screen_image) }}?w=600&q=75 600w,
                  {{ asset('storage/uploads/banners/' . $first->mobile_screen_image) }}?w=750&q=75 750w,
                  {{ asset('storage/uploads/banners/' . $first->mobile_screen_image) }}?w=828&q=75 828w
              "
              imagesizes="(max-width: 767px) 750px"
              media="(max-width: 767px)"
              fetchpriority="high">

        {{-- Desktop preload --}}
        <link rel="preload"
              as="image"
              href="{{ asset('storage/uploads/banners/' . $first->image) }}?w=1280&q=75"
              imagesrcset="
                  {{ asset('storage/uploads/banners/' . $first->image) }}?w=960&q=75 960w,
                  {{ asset('storage/uploads/banners/' . $first->image) }}?w=1280&q=75 1280w,
                  {{ asset('storage/uploads/banners/' . $first->image) }}?w=1600&q=75 1600w
              "
              imagesizes="(min-width: 768px) 1280px"
              media="(min-width: 768px)"
              fetchpriority="high">
    @endif
@endpush
<section class="px-4 lgg:py-4 py-3 ">
    <div class="container mx-auto">
        <div class="hero-carousel owl-carousel owl-theme ">
            <!-- Slide 1 -->
            @foreach($bannerHeroSection as $key=>$banner)
            {{--don't remove this comment code need for later check -}}
            {{-- <div class="slide-item relative">

                <a href="{{$banner->redirect_link}}"><img class="hero-carousel-desktop" src="{{ asset('storage/uploads/banners/' . $banner->image) }}" class="w-full h-full object-cover md:hidden  " alt=""
                @if($key==0)
                fetchpriority=""
                @else
                loading="lazy"
                @endif
                decoding="async"> </a>
            <a href="{{$banner->redirect_link}}"> <img class="hero-carousel-mobile" src="{{ asset('storage/uploads/banners/' . $banner->mobile_screen_image) }}" class="w-full h-full object-cover md:block  hidden" alt="" loading="lazy" decoading="async"></a>

        </div> --}}
        {{--
        <div class="slide-item relative">

            <a href="{{ $banner->redirect_link }}" class="block w-full h-full">
                <picture>
                    <source media="(min-width: 768px)"
                        srcset="{{ asset('storage/uploads/banners/' . $banner->image) }}">
                    <img
                       src="{{ asset('storage/uploads/banners/' . $banner->mobile_screen_image) }}?w=400&q=80"
                        srcset="{{ asset('storage/uploads/banners/' . $banner->mobile_screen_image) }}?w=400&q=80 400w, {{ asset('storage/uploads/banners/' . $banner->mobile_screen_image) }}?w=600&q=80 600w"
                        alt="{{ $banner->title ?? '' }}"
                        class="w-full h-full object-cover aspect-[2/3] md:aspect-[16/6]"
                       width="400"
                        height="600"
                        sizes="(max-width: 768px) 400px, 750px"
                        @if($key==0)fetchpriority="high" loading="eager" @else loading="lazy" @endif
                        decoding="async">
                </picture>
            </a>

            <!-- <div class="slide-content">
                    <h2 class="brand-name"><span>Seema Gujral</span></h2>
                    <p class="tagline">An ode to timeless elegance</p>
                    <a href="#" class="shop-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div> -->
        </div>
        --}}

         @php
        $desktopImg = asset('storage/uploads/banners/' . $banner->image);
        $mobileImg  = asset('storage/uploads/banners/' . $banner->mobile_screen_image);
        $isFirst    = $key === 0;
    @endphp

    <div class="slide-item relative">
        <a href="{{ $banner->redirect_link }}" class="block w-full h-full">
            <picture>
                {{-- Desktop --}}
                <source
                    media="(min-width: 768px)"
                    type="image/webp"
                    srcset="
                        {{ $desktopImg }}?w=960&q=75 960w,
                        {{ $desktopImg }}?w=1280&q=75 1280w,
                        {{ $desktopImg }}?w=1600&q=75 1600w
                    "
                    sizes="(min-width: 768px) 1280px"
                    width="1280"
                    height="480">

                {{-- Mobile --}}
                <source
                    media="(max-width: 767px)"
                    type="image/webp"
                    srcset="
                        {{ $mobileImg }}?w=400&q=75 400w,
                        {{ $mobileImg }}?w=600&q=75 600w,
                        {{ $mobileImg }}?w=750&q=75 750w,
                        {{ $mobileImg }}?w=828&q=75 828w
                    "
                    sizes="(max-width: 767px) 750px"
                    width="750"
                    height="1125">

                {{-- Fallback --}}
                <img
                    src="{{ $mobileImg }}?w=750&q=75"
                    alt="{{ $banner->title ?? 'Hero banner' }}"
                    class="w-full h-full object-cover aspect-[2/3] md:aspect-[16/6]"
                    width="750"
                    height="1125"
                    sizes="(max-width: 767px) 750px"
                    @if($isFirst)
                        fetchpriority="high"
                        loading="eager"
                    @else
                        fetchpriority="low"
                        loading="lazy"
                    @endif
                    decoding="async">
            </picture>
        </a>
    </div>
        @endforeach

        <!-- Slide 2 -->
        {{-- <div class="slide-item relative">
                
                     <img class="hero-carousel-desktop" src="{{ asset('web/images/custom_design/1784293240602women-the-celebration-closet.webp') }}" class="w-full h-full object-cover md:hidden block" alt="">
        <img class="hero-carousel-mobile" src="{{ asset('web/images/custom_design/portrait-image.jpg') }}" class="w-full h-full object-cover md:block  hidden" alt="">

        <!-- <div class="slide-content">
                        <h2 class="brand-name"><span>Seema Gujral</span></h2>
                        <p class="tagline">An ode to timeless elegance</p>
                        <a href="#" class="shop-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
                    </div> -->
    </div> --}}

    <!-- Slide 3 -->
    {{-- <div class="slide-item relative">
               
                     <img class="hero-carousel-desktop" src="{{ asset('web/images/custom_design/1784293240602women-the-celebration-closet.webp') }}" class="w-full h-full object-cover md:hidden block" alt="">
    <img class="hero-carousel-mobile" src="{{ asset('web/images/custom_design/portrait-image.jpg') }}" class="w-full h-full object-cover md:block  hidden" alt="">

    <!-- <div class="slide-content">
                    <h2 class="brand-name"><span>Seema Gujral</span></h2>
                    <p class="tagline">An ode to timeless elegance</p>
                    <a href="#" class="shop-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div> -->
    </div> --}}
    </div>
    </div>
</section>


<section class="px-4 lgg:py-8 py-6 bg-gradient-to-b from-white to-gray-50/50">
    <div class="container mx-auto">




        <div class="py-3 lg:py-4 text-center">

            <!-- Small Label -->
            <!-- <span class="inline-block mb-4 text-[11px] uppercase tracking-[0.35em] text-gray-500 font-medium">
        Discover Our Collection
    </span> -->

            <!-- Heading -->
            <h2
                class="heading-font text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl bg-gradient-to-r from-primary via-secondary to-black bg-clip-text text-transparent leading-[1.15] font-medium">

                Be the Showstopper
                <br class="hidden lg:block">
                on Every Occasion

            </h2>

            <!-- Description -->
            <p
                class="mt-5 mx-auto max-w-3xl text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-500 leading-relaxed">

                Navigate our elite collections for gowns, salwar kameez, and suits.

            </p>

        </div>


        <!-- Owl Carousel Container -->
        <div class="relative ">
            <div id="categories-carousel" class="owl-carousel owl-theme">
                @if (!isset($categoriesWithProduct))
                <div class="item p-2 text-center py-8">
                    <p class="text-gray-500 font-sans">No categories available at the moment.</p>
                </div>
                @else
                <!-- Dynamic Categories -->
                @foreach ($categoriesWithProduct as $category)
                <div class="item p-2">

                    @php
                    $catImg = $category->latestProductWithImage->featured_image
                    ? url('/img/' . $category->latestProductWithImage->featured_image . '?w=600&q=80')
                    : $category->image;

                    if (strpos($catImg, 'cloudinary.com') !== false && strpos($catImg, 'upload/') !== false) {
                    $parts = explode('upload/', $catImg);
                    $catImg = $parts[0].'upload/w_700,h_1011,c_fill,f_auto,q_auto/'.$parts[1];
                    }
                    @endphp

                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group relative block overflow-hidden">

                        <!-- Image -->

                        <img
                            src="{{ $catImg }}"
                            srcset="{{ $catImg }}?w=300&q=80 300w,
                            {{ $catImg }}?w=450&q=80 450w,
                            {{ $catImg }}?w=600&q=80 600w,
                            {{ $catImg }}?w=800&q=80 800w"
                            sizes="(max-width: 640px) 150px, (max-width: 1024px) 300px, 450px"
                            alt="{{ $category->name }}"
                            class="w-full aspect-[9/13] object-cover object-top transition duration-700 group-hover:scale-105"
                            width="450"
                            height="650"
                            loading="lazy"
                            decoding="async"
                            style="aspect-ratio: 450/650;">

                        <!-- Overlay -->

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">

                        </div>

                        <!-- Vertical Label -->

                        <div
                            class="absolute top-10 left-5">

                            <span
                                class="text-[11px] uppercase tracking-[0.45em] text-white/80 [writing-mode:vertical-rl] rotate-180">

                                COLLECTION

                            </span>

                        </div>

                        <!-- Top Content -->

                        <div
                            class="absolute bottom-8 left-12 right-6">

                            <h3
                                class="heading-font text-3xl text-white leading-tight truncate">

                                {{ $category->name }}

                            </h3>

                            <p
                                class="mt-3 text-sm text-white/80">

                                Discover timeless fashion.

                            </p>

                        </div>

                        <!-- Arrow -->



                        <!-- Bottom CTA -->



                    </a>

                </div>
                @endforeach
                @endif
            </div>

            <!-- Simple Navigation Arrows -->
            <div
                class="custom-nav hidden lg:flex absolute top-1/2 -translate-y-1/2 left-0 right-0 justify-between px-2 pointer-events-none z-[1]">
                <button
                    class="owl-prev bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="owl-next bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Simple View All Button -->
        <div class="text-center mt-0">
            <a href="{{route('category.collection')}}"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary rounded-full text-white font-semibold text-lg shadow-md hover:shadow-lg transition-all duration-300">
                <span>View All Categories</span>
                <svg class="w-5 h-5 transform hover:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<section id="unique-scroll" class="px-4 lgg:py-12 py-8 bg-gradient-to-b from-white via-gray-50/30 to-white">
    <div class="container mx-auto ">
        <!-- Header -->
        <div class="text-center mb-10">
            <!-- <span class="inline-block text-xs font-medium uppercase tracking-[0.2em] text-secondary mb-3">Collections</span> -->
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-800 mb-3 tracking-wide heading-font">
                Elegance at Every Wear
            </h2>
            <div class="w-16 h-0.5 bg-gradient-to-r from-primary to-secondary mx-auto mb-4"></div>
            <p class="text-gray-500 text-sm md:text-base font-light tracking-wide max-w-2xl mx-auto font-sans">
                Experience class and sophistication for life's most memorable moments
            </p>
        </div>

        <!-- Owl Carousel Container -->
        <div class="relative px-2">

            <div id="categories-tag-carousel" class="owl-carousel owl-theme">

                @foreach ($categoriesWithProduct as $category)

                @php
                $tagImage = $category->latestProductWithImage->featured_image
                ? $category->latestProductWithImage->featured_image
                : $category->image;

                if (strpos($tagImage, 'cloudinary.com') !== false && strpos($tagImage, 'upload/') !== false) {
                $parts = explode('upload/', $tagImage);
                $tagImage = $parts[0] . 'upload/w_600,h_850,c_fill,f_auto,q_auto/' . $parts[1];
                }
                else {
                // Local image - use proxy with specific folder
                $tagImage = url('/img/' . $tagImage . '?w=600&q=80');
                }
                @endphp

                <div class="item ">

                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group block">

                        <!-- Image -->

                        <div class="overflow-hidden bg-[#fafafa]">

                            <div class="aspect-[3/4] overflow-hidden rounded-[10px]">

                                <img
                                    src="{{ $tagImage }}"
                                    srcset="{{ $tagImage }}?w=300&q=80 300w,
                                            {{ $tagImage }}?w=400&q=80 400w,
                                            {{ $tagImage }}?w=600&q=80 600w"
                                    sizes="(max-width: 640px) 150px, (max-width: 1024px) 200px, 300px"
                                    alt="{{ $category->name }}"
                                    loading="lazy"
                                    decoding="async"
                                    width="400"
                                    height="520"
                                    class="w-full h-full object-cover object-top transition duration-700 group-hover:scale-105"
                                    style="aspect-ratio: 400/520;">

                            </div>

                        </div>

                        <!-- Content -->

                        <div class="pt-5 text-center">

                            <h3
                                class="heading-font text-lg lg:text-xl text-gray-900 font-medium truncate">

                                {{ $category->name }}

                            </h3>

                            <span
                                class="mt-2 inline-flex items-center gap-2 text-xs uppercase tracking-[0.25em] text-gray-500 group-hover:text-secondary transition">

                                Explore

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 transition group-hover:translate-x-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14m-5-5 5 5-5 5" />

                                </svg>

                            </span>

                        </div>

                    </a>

                </div>

                @endforeach

            </div>

            <!-- Navigation -->



        </div>
    </div>
</section>

<!-- 🔥 OPTIMIZED: Trending Best Selling Products Section -->
<section class="px-4 lgg:py-8 py-6 bg-gray-50">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-6">
            <div>
                <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-light text-gray-800 heading-font tracking-wide">
                    Trending Best Selling Products
                </h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-secondary to-primary mt-2"></div>
            </div>
            <a href="{{ route('page.multi-product') }}"
                class="group flex items-center gap-2 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-medium text-secondary hover:text-primary transition-all font-sans">
                All Products
                <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if ($products && $products->count() > 0)

            @foreach ($products as $product)
            <div class="item flex justify-center items-center ">
                <div class="group w-full bg-white xxs:max-w-full max-w-[320px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200"
                    onclick="window.location.href='{{ route('page.single-product', $product->slug) }}';">
                    <!-- Image Wrapper -->
                    <div class="relative overflow-hidden bg-gray-100">
                        @php
                        $imagePath = $product->featured_image;
                        $imageUrl = '';

                        // Check if it's a Cloudinary URL or path
                        $isCloudinary = str_contains($imagePath, 'cloudinary.com') ||
                        str_contains($imagePath, 'res.cloudinary.com') ||
                        str_contains($imagePath, 'aiman/');

                        if ($isCloudinary) {
                        // Cloudinary handling
                        if (filter_var($imagePath, FILTER_VALIDATE_URL) && str_contains($imagePath, 'cloudinary.com') && str_contains($imagePath, 'upload/')) {
                        $parts = explode('upload/', $imagePath);
                        $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . ($parts[1] ?? '');
                        } elseif (str_contains($imagePath, 'aiman/')) {
                        $imageUrl = 'https://res.cloudinary.com/dwbseti83/image/upload/w_600,h_900,c_fill,f_auto,q_auto/' . $imagePath;
                        } else {
                        $imageUrl = 'https://res.cloudinary.com/dwbseti83/image/upload/w_600,h_900,c_fill,f_auto,q_auto/' . $imagePath;
                        }
                        } else {
                        // Local image - use image-proxy
                        if ($imagePath) {
                        // Check if file exists in both locations
                        $publicPath = public_path($imagePath);
                        $storagePath = storage_path('app/public/' . $imagePath);

                        if (file_exists($publicPath) || file_exists($storagePath)) {
                        // Use the proxy URL with the full path
                        $imageUrl = url('/img/' . $imagePath . '?w=600&q=80');
                        } else {
                        // Fallback to placeholder
                        $imageUrl = asset('assets/images/placeholder.jpg');
                        }
                        } else {
                        // Fallback to placeholder
                        $imageUrl = asset('assets/images/placeholder.jpg');
                        }
                        }
                        @endphp
                        <img src="{{ $imageUrl }}"
                            srcset="{{ $imageUrl }}?w=300&q=80 300w,
                                    {{ $imageUrl }}?w=450&q=80 450w,
                                    {{ $imageUrl }}?w=600&q=80 600w"
                            sizes="(max-width: 640px) 150px, (max-width: 1024px) 300px, 450px"
                            alt="{{ $product->name }}"
                            class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="900"
                            style="aspect-ratio: 600/900;" />

                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                                Quick View
                            </button>
                        </div>

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if ($product->discount == 0)
                            <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                                Trending
                            </span>
                            @else
                            <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                                {{ round($product->discount,2) }}% OFF
                            </span>
                            @endif
                        </div>
                        @php
                        $isWishlisted = Auth::check()
                        ? \App\Models\Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->exists()
                        : false;
                        @endphp
                        <!-- Wishlist Heart Icon -->
                        @if (Auth::check())
                        <button
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center {{ $isWishlisted ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}"
                            onclick="toggleWishlist({{ $product->id }}, this, event);">

                            <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart text-sm"></i>

                        </button>
                        @else
                        <a href="{{ route('page.login') }}">
                            <button
                                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center text-gray-400 hover:text-red-500">
                                <i class="far fa-heart text-sm"></i>
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
                            <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $product->brand }}</span>
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
                            <span class="text-xs font-sans text-gray-400">({{ rand(10, 200) }})</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center gap-2 flex-wrap mt-1">
                            <span class="text-lg font-semibold text-gray-900 font-sans">Rs.
                                {{ $product->price_after_discount }}</span>
                            @if ($product->price_after_discount != $product->price)
                            <span class="text-xs text-gray-400 line-through font-sans">Rs.
                                {{ $product->price }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="text-center py-8">
                <p class="text-gray-500 font-sans">No products available at the moment.</p>
            </div>
            @endif
        </div>
    </div>
</section>
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto lgg:py-12 lgg:px-12 py-12 px-4 relative rounded-[10px] overflow-hidden">
        <span class="absolute z-[1] top-[8px] right-[30px] text-secondary/30 text-[100px] digital-font">%</span>
        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 via-white to-pink-100 z-[-1]"></div>
        <div class="grid lgg:grid-cols-3 lgg:gap-4 gap-8 xl:gap-16 items-center">

            <!-- Left - Guarantee Info -->
            <div class="">
                <div class="lgg:text-left text-center">
                    <div class="mb-6">
                        <h3 class="text-2xl md:text-5xl font-bold text-gray-900 heading-font">Shop With Complete Confidence</h3>
                    </div>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-8 max-w-lg lgg:mx-0 mx-auto">
                        From designer craftsmanship to our affordable luxury, every purchase is backed by our commitment to you.
                    </p>
                </div>
                <ul class="text-gray-700 flex flex-col gap-3 lgg:items-start items-center justify-center">
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Easy return and exchanges
                    </li>
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Dedicated customer supporter
                    </li>
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Affordable luxury at your fingertips
                    </li>
                </ul>
            </div>

            <!-- Center - Geometric Product Mosaic -->
            <div class="relative">
                <div class="relative w-full max-w-md mx-auto">
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <div class="w-64 h-64 border-2 border-secondary/30 rotate-45 rounded-3xl"></div>
                    </div>

                    <div
                        class="absolute top-0 right-8 w-36 h-36 transform rotate-12 hover:-rotate-6 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary/10 to-pink-500/10 rounded-xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}?w=400&q=80"
                            srcset="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}?w=300&q=80 300w,
                                    {{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}?w=400&q=80 400w,
                                    {{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}?w=600&q=80 600w"
                            sizes="(max-width: 640px) 150px, (max-width: 1024px) 200px, 300px"
                            alt="Saree Collection"
                            class="w-full h-full object-cover object-top rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300"
                            loading="lazy"
                            decoding="async"
                            width="400"
                            height="400"
                            style="aspect-ratio: 400/400;">
                        <div
                            class="absolute -bottom-2 -left-2 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 border border-gray-200 shadow-sm">
                            <p class="text-gray-900 text-xs font-bold digital-font">₹74.99</p>
                        </div>
                    </div>

                    <div
                        class="relative w-56 h-56 mx-auto transform -rotate-3 hover:rotate-0 transition-transform duration-500 cursor-pointer group z-[10]">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-pink-400/10 rounded-2xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}?w=600&q=80"
                            srcset="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}?w=400&q=80 400w,
                                    {{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}?w=600&q=80 600w,
                                    {{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}?w=800&q=80 800w"
                            sizes="(max-width: 640px) 225px, (max-width: 1024px) 300px, 400px"
                            alt="Premium Lehenga"
                            class="w-full h-full object-cover object-top rounded-2xl shadow-xl border-4 border-white group-hover:border-secondary transition-all duration-300"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="600"
                            style="aspect-ratio: 600/600;">
                        <div
                            class="absolute -top-3 -right-3 bg-secondary text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-6 digital-font">
                            -25%
                        </div>
                    </div>

                    <div
                        class="absolute bottom-8 left-4 w-40 h-40 transform -rotate-12 hover:rotate-3 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tl from-secondary/10 to-pink-600/10 rounded-xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}?w=400&q=80"
                            srcset="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}?w=300&q=80 300w,
                                    {{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}?w=400&q=80 400w,
                                    {{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}?w=600&q=80 600w"
                            sizes="(max-width: 640px) 150px, (max-width: 1024px) 200px, 300px"
                            alt="Party Wear"
                            class="w-full h-full object-cover object-top rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300"
                            loading="lazy"
                            decoding="async"
                            width="400"
                            height="400"
                            style="aspect-ratio: 400/400;">
                        <div
                            class="absolute -top-2 -right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg font-sans">
                            New
                        </div>
                    </div>

                    <div
                        class="absolute bottom-4 right-0 w-32 h-32 rounded-full overflow-hidden border-4 border-white hover:border-secondary transition-all duration-300 cursor-pointer group z-10 shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary/10 to-pink-600/10"></div>
                        <img src="{{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}?w=300&q=80"
                            srcset="{{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}?w=200&q=80 200w,
                                    {{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}?w=300&q=80 300w,
                                    {{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}?w=400&q=80 400w"
                            sizes="(max-width: 640px) 125px, (max-width: 1024px) 150px, 200px"
                            alt="Kurta Set"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                            decoding="async"
                            width="300"
                            height="300"
                            style="aspect-ratio: 300/300;">
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-secondary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-sm font-bold font-sans">View</span>
                        </div>
                    </div>

                    <div class="absolute inset-0 pointer-events-none">
                        <div
                            class="absolute top-1/2 left-1/2 w-20 h-0.5 bg-gradient-to-r from-secondary/20 to-transparent transform -translate-x-20">
                        </div>
                        <div
                            class="absolute top-1/2 left-1/2 w-20 h-0.5 bg-gradient-to-l from-secondary/20 to-transparent transform translate-x-20">
                        </div>
                    </div>
                </div>

                <!-- Collection Badge -->
                <a href="https://aimanroyale.com/products/" class="mt-10 text-center block">
                    <div
                        class="inline-flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-6 py-3 shadow-sm hover:border-secondary-light transition-all duration-300 cursor-pointer group">
                        <div class="flex -space-x-3">
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    srcset="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80 50w,
                                            https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80 100w"
                                    sizes="32px"
                                    alt="" class="w-full h-full object-cover" loading="lazy" decoding="async" width="32" height="32">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    srcset="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80 50w,
                                            https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80 100w"
                                    sizes="32px"
                                    alt="" class="w-full h-full object-cover" loading="lazy" decoding="async" width="32" height="32">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    srcset="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80 50w,
                                            https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80 100w"
                                    sizes="32px"
                                    alt="" class="w-full h-full object-cover" loading="lazy" decoding="async" width="32" height="32">
                            </div>
                        </div>
                        <div class="text-left">
                            <p
                                class="text-gray-900 text-sm font-semibold group-hover:text-secondary transition-colors font-sans">
                                Premium Collection</p>
                            <p class="text-gray-500 text-xs font-sans">4+ stunning designs</p>
                        </div>
                        <div
                            class="w-10 min-w-10 h-10 min-h-10 rounded-full bg-gradient-to-r from-secondary to-pink-500 flex items-center justify-center group-hover:bg-secondary-light transition-all duration-300">
                            <i class="fas fa-arrow-right text-white text-sm"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Right - CTA + Trust -->
            <div class="text-center flex flex-col gap-3">
                <h3
                    class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient break-all font-serif ">
                    Make Every Entrance Unforgettable
                </h3>
                <a href="https://aimanroyale.com/products/"
                    class="w-full sm:w-auto  relative p-[16px_34px] bg-gradient-to-r from-secondary to-pink-500 hover:from-secondary hover:to-primary text-white font-bold text-xl rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-secondary/20 font-sans">
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i>
                    Grab now
                </a>
            </div>
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-8 bg-[#fdfaf7]">
    <div class="container mx-auto">
        <!-- Section Title -->
        <div class="lgg:text-left text-center mb-5">
            <h2 class="font-thin font-[initial] text-2xl sm:text-3xl md:text-4xl lg:text-[49px] leading-tight text-[#2c1810] mb-2">The Wedding Edit</h2>
            <div class="w-24 h-0.5 bg-[#d4a88b] lgg:ml-0 lgg:me-auto me-auto ml-auto "></div>
            <p class="text-gray-600 mt-3 font-serif text-sm md:text-base">Curated collections for your special day</p>
        </div>

        <div id="uniq-ads-slider" class="owl-carousel owl-theme">
            @foreach ($mainBanners as $banner)
            @php
            // Get the image path from database
            $imagePath = $banner->image;

            // Check if it's a Cloudinary URL or path
            $isCloudinary = str_contains($imagePath, 'cloudinary.com') ||
            str_contains($imagePath, 'res.cloudinary.com') ||
            str_contains($imagePath, 'aiman/banners/');

            // Default banner image
            $bannerImg = '';

            if ($isCloudinary) {
            // Cloudinary image handling
            if (filter_var($imagePath, FILTER_VALIDATE_URL) && str_contains($imagePath, 'cloudinary.com')) {
            if (str_contains($imagePath, 'upload/')) {
            $parts = explode('upload/', $imagePath);
            $cloudinaryPath = $parts[1] ?? '';
            $bannerImg = $parts[0] . 'upload/w_600,h_1000,c_fill,f_auto,q_auto/' . $cloudinaryPath;
            } else {
            $bannerImg = $imagePath;
            }
            } elseif (str_contains($imagePath, 'aiman/banners/')) {
            $bannerImg = 'https://res.cloudinary.com/dwbseti83/image/upload/w_600,h_1000,c_fill,f_auto,q_auto/' . $imagePath;
            } else {
            $bannerImg = 'https://res.cloudinary.com/dwbseti83/image/upload/w_600,h_1000,c_fill,f_auto,q_auto/' . $imagePath;
            }
            } else {
            // LOCAL IMAGE - Use the proxy URL
            // Check if file exists in storage
            $storagePath = 'uploads/banners/' . $imagePath;
            $publicPath = public_path('uploads/banners/' . $imagePath);
            $storageFullPath = storage_path('app/public/' . $storagePath);

            if (file_exists($storageFullPath) || file_exists($publicPath)) {
            // Use the image-proxy URL for optimization
            $bannerImg = url('/img/uploads/banners/' . $imagePath . '?w=600&q=80');
            } else {
            // Fallback to default image
            $bannerImg = asset('uploads/banners/default.jpg');
            \Log::warning('Banner image not found:', [
            'image' => $imagePath,
            'storage_path' => $storageFullPath,
            'public_path' => $publicPath
            ]);
            }
            }

            // Build the filter URL based on banner data
            $filterUrl = '#';
            if ($banner->filter) {
            if ($banner->filter_type === 'multiple' && $banner->filters) {
            $filterUrl = '/products?' . $banner->filters;
            } elseif ($banner->filter) {
            $filterUrl = '/products?' . ($banner->filter ?? ($banner->discount ?? ''));
            }
            }
            @endphp
            <div class="px-2">
                <a href="{{ $filterUrl }}" class="block w-full">
                    <div class="relative overflow-hidden group bg-[#f8f6f4] rounded-[18px]"
                        style="aspect-ratio: 9/15; "
                        @if ($banner->filter_type === 'multiple' && $banner->filters)
                        data-filter="{{ $banner->filters }}"
                        @else
                        data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}"
                        @endif>

                        <!-- Image -->
                        <div class="absolute inset-0">
                            <img class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                src="{{ $bannerImg }}"
                                srcset="{{ $bannerImg }}?w=400&q=80 400w,
                                        {{ $bannerImg }}?w=600&q=80 600w,
                                        {{ $bannerImg }}?w=800&q=80 800w"
                                sizes="(max-width: 640px) 200px, (max-width: 1024px) 300px, 400px"
                                alt="{{ $banner->title }}"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="1000"
                                style="aspect-ratio: 600/1000;" />
                        </div>

                        <!-- Subtle Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-40 transition-opacity duration-500"></div>

                        <!-- Content - Clean Layout -->
                        <div class="absolute bottom-[5px] left-0 right-0 py-5 md:py-6 px-[14px]">
                            <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 ease-out flex flex-col items-center justify-center">
                                <!-- Category -->
                                @if ($banner->subtitle)
                                <span class="inline-block text-white/80 text-[9px] md:text-[10px] font-medium tracking-[0.2em] uppercase mb-1.5">
                                    {{ $banner->subtitle }}
                                </span>
                                @endif

                                <!-- Title -->
                                <h3 class="text-white text-lg md:text-xl lg:text-2xl font-light tracking-wide leading-tight mb-1">
                                    {{ $banner->title }}
                                </h3>

                                <!-- Description -->
                                @if ($banner->description)
                                <p class="text-white/60 text-[10px] md:text-xs font-light mb-3 line-clamp-1">
                                    {{ $banner->description }}
                                </p>
                                @endif

                                <!-- Shop Now Button -->
                                <span class="inline-block rounded-[11px] bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-5 md:px-6 py-1.5 md:py-2 text-[10px] md:text-xs font-medium tracking-wide transition-all duration-300 ease-in-out cursor-pointer">
                                    Shop Now
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Owl Carousel Initialization Script -->
<script>
    function initUniqAdsSlider() {
        if (typeof $ !== 'undefined' && typeof $.fn.owlCarousel !== 'undefined') {
            $('#uniq-ads-slider').owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5500,
                autoplayHoverPause: true,
                stopOnHover: true,
                smartSpeed: 900,
                navText: ['', ''], // Empty strings since we use Font Awesome
                responsive: {
                    0: {
                        items: 1,
                        margin: 10,
                        nav: true,
                        dots: true
                    },
                    480: {
                        items: 2,
                        margin: 10,
                        nav: true,
                        dots: true
                    },
                    640: {
                        items: 2,
                        margin: 10,
                        nav: true,
                        dots: true
                    },
                    768: {
                        items: 3,
                        margin: 15,
                        nav: true,
                        dots: true
                    },
                    1024: {
                        items: 3,
                        margin: 15,
                        nav: true,
                        dots: true
                    },
                    1280: {
                        items: 3,
                        margin: 20,
                        nav: true,
                        dots: true
                    },
                    1366: {
                        items: 4,
                        margin: 20,
                        nav: true,
                        dots: true
                    }
                }
            });
        } else {
            console.warn('Owl Carousel not loaded, retrying...');
            setTimeout(initUniqAdsSlider, 500);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initUniqAdsSlider);
    } else {
        initUniqAdsSlider();
    }
</script>


<section class="px-4 lgg:py-8 py-6 bg-white">
    <div class="container mx-auto ">
        <div class="flex flex-col lgg:flex-row gap-10 lgg:gap-14 lgg:items-center items-start ">

            <!-- Left Content -->
            <div class="w-full lgg:w-2/5 px-4 lgg:px-6 text-center lgg:text-left">

                <!-- Badge -->
                <div class="inline-flex items-center gap-3 mb-6">
                    <span class="w-8 h-px bg-gray-400"></span>

                    <span class="text-[11px] uppercase tracking-[0.35em] text-gray-500 font-medium">
                        LIMITED TIME OFFER
                    </span>

                    <span class="w-8 h-px bg-gray-400"></span>
                </div>

                <!-- Heading -->
                <h2
                    class="heading-font text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-medium text-gray-900 leading-[1.15]">

                    Our Biggest Monsoon<br class="hidden lgg:block">
                    Sale of the Season

                </h2>

                <!-- Description -->
                <div class="mt-5 space-y-3">

                    <p
                        class="text-gray-600 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl leading-relaxed">

                        Enjoy up to
                        <span class="font-semibold text-gray-900">
                            50% OFF
                        </span>

                        on selected designer collections.

                    </p>

                    <p
                        class="text-gray-500 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl leading-relaxed">

                        Limited-time offer,

                        <span class="font-semibold text-gray-900">
                            shop now!
                        </span>

                    </p>

                </div>

                <!-- CTA -->

                <div class="mt-8">

                    <button
                        class="inline-flex items-center gap-3
    px-8 py-3
    text-xs font-semibold uppercase tracking-[0.18em]
    text-white
    bg-gradient-to-r from-primary to-secondary
    rounded-sm
    transition-all duration-300 ease-out
    hover:from-secondary hover:to-primary
    hover:text-white
    hover:shadow-xl hover:-translate-y-0.5
    active:translate-y-0 active:scale-95">

                        <span>Shop Now</span>

                        <svg
                            class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3">
                            </path>
                        </svg>
                    </button>

                </div>

                <!-- Timer -->
                @php
                $isTimmer = \App\Models\Offer::where('is_active', true)
                ->where('is_timer', true)
                ->where('end_date', '>', now())
                ->first();

                $days = 0;
                $hours = 0;
                $minutes = 0;

                if ($isTimmer) {
                $end = \Carbon\Carbon::parse($isTimmer->end_date);
                $now = now();

                $days = (int) $now->diffInDays($end, false);
                $hours = (int) $now->diffInHours($end, false);
                $minutes = (int) $now->diffInMinutes($end, false);
                }

                @endphp
                @if($isTimmer)
                <div class="mt-8">
                    {{-- @if((int) now()->diffInDays(\Carbon\Carbon::parse($isTimmer->end_date), false) == 0 )
                        <!-- 0 days left -->
                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry! Only a few hours left to grab these exclusive offers.
                    </h4>

                    @else
                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry…only 
                        <span id="daysLabel" class="font-semibold text-gray-900">
                            30
                        </span>
                        days left!
                    </h4>
                    @endif --}}
                    @if($days > 0)

                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry…only
                        <span id="daysLabel" class="font-semibold text-gray-900">{{ $days }}</span>
                        {{ $days == 1 ? 'day' : 'days' }} left!
                    </h4>

                    @elseif($hours > 0)

                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry…only
                        <span id="hoursLabel" class="font-semibold text-gray-900">{{ $hours }}</span>
                        {{ $hours == 1 ? 'hour' : 'hours' }} left!
                    </h4>

                    @elseif($minutes > 0)

                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry…only
                        <span id="minutesLabel" class="font-semibold text-gray-900">{{ $minutes }}</span>
                        {{ $minutes == 1 ? 'minute' : 'minutes' }} left!
                    </h4>

                    @endif



                    <div
                        class="mt-7 flex flex-wrap justify-center lgg:justify-start gap-6">

                        <div class="text-center">

                            <div
                                id="daysBox"
                                class="heading-font text-4xl font-medium text-gray-900">
                                35
                            </div>

                            <div class="w-10 h-px bg-gray-300 mx-auto my-2"></div>

                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">
                                Days
                            </p>

                        </div>

                        <div class="text-center">

                            <div
                                id="hoursBox"
                                class="heading-font text-4xl font-medium text-gray-900">
                                11
                            </div>

                            <div class="w-10 h-px bg-gray-300 mx-auto my-2"></div>

                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">
                                Hr
                            </p>

                        </div>

                        <div class="text-center">

                            <div
                                id="minutesBox"
                                class="heading-font text-4xl font-medium text-gray-900">
                                25
                            </div>

                            <div class="w-10 h-px bg-gray-300 mx-auto my-2"></div>

                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">
                                Mins
                            </p>

                        </div>

                        <div class="text-center">

                            <div
                                id="secondsBox"
                                class="heading-font text-4xl font-medium text-gray-900">
                                08
                            </div>

                            <div class="w-10 h-px bg-gray-300 mx-auto my-2"></div>

                            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-500">
                                Sec
                            </p>

                        </div>

                    </div>

                </div>
                @endif

            </div>

            <!-- Right Content - Carousel -->
            <div class="w-full lgg:w-[59%] flex justify-center items-center">
                <div class="second-owl owl-carousel owl-theme relative w-full">
                    @foreach ($secondaryBanners as $banner)
                    @php
                    $isCloudinary = str_contains($banner->image, 'cloudinary.com') ||
                    str_contains($banner->image, 'res.cloudinary.com') ||
                    str_contains($banner->image, 'aiman/banners/');

                    // Set image URL based on type
                    if ($isCloudinary) {
                    $secBannerImg = $banner->image; // Use Cloudinary URL directly
                    } else {
                    // $secBannerImg = asset('uploads/banners/' . $banner->image);
                    $secBannerImg = url('/img/uploads/banners/' . $banner->image . '?w=600&q=80');
                    }


                    $bannerFilterUrl = '#';
                    if ($banner->filter) {
                    if ($banner->filter_type === 'multiple' && $banner->filters) {
                    $bannerFilterUrl = '/products?' . $banner->filters;
                    } elseif ($banner->filter) {
                    $bannerFilterUrl = '/products?' . ($banner->filter ?? ($banner->discount ?? ''));
                    }
                    }
                    @endphp
                    <div class="item flex justify-center items-center px-2">

                        <div class="w-full bg-white shadow-lg hover:shadow-2xl transition-shadow duration-500 banner-card group relative"
                            @if($banner->filter_type === 'multiple' && $banner->filters)
                            data-filter="{{ $banner->filters }}"
                            @else
                            data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>

                            <!-- Image Container with 2:3 Aspect Ratio -->
                            <div class="relative overflow-hidden" style="aspect-ratio: 2/3;">
                                <img src="{{ $secBannerImg }}"
                                    srcset="{{ $secBannerImg }}?w=400&q=80 400w,
                                            {{ $secBannerImg }}?w=600&q=80 600w,
                                            {{ $secBannerImg }}?w=800&q=80 800w"
                                    sizes="(max-width: 640px) 200px, (max-width: 1024px) 300px, 400px"
                                    alt="{{ $banner->title }}"
                                    class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async"
                                    width="600"
                                    height="800"
                                    style="aspect-ratio: 600/800;" />

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-500"></div>
                            </div>

                            <!-- Banner Content - Bottom Left -->
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-[#00000005]">
                                <div class="px-4 py-4 sm:px-5 sm:py-5 text-center text-white">

                                    <!-- Subtitle -->
                                    <div class="flex items-center justify-center gap-2 mb-1">
                                        <span class="w-5 h-px bg-white/50"></span>

                                        <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.25em] text-white font-[700]">
                                            {{ $banner->subtitle }}
                                        </span>

                                        <span class="w-5 h-px bg-white/50"></span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-sm sm:text-base md:text-lg font-medium leading-tight">
                                        {{ $banner->title }}
                                    </h3>

                                    <!-- Discount -->
                                    <p class="mt-1 text-lg sm:text-xl md:text-2xl font-semibold">
                                        {{ $banner->discount }}
                                    </p>

                                    <!-- CTA -->
                                    <div class="mt-4 opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 ease-out">
                                        <a href="{{ $bannerFilterUrl }}"
                                            class="group/btn inline-flex items-center gap-2 px-5 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-white bg-gradient-to-r from-primary to-secondary border border-transparent rounded-sm shadow-md transition-all duration-300 ease-out hover:from-secondary hover:to-primary hover:shadow-xl hover:-translate-y-0.5">

                                            <span>Shop Now</span>

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-3.5 h-3.5 transition-transform duration-300 group-hover/btn:translate-x-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 12h14m-5-5 5 5-5 5" />
                                            </svg>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>



<section class="bg-white py-4 lg:py-6 border-y border-gray-100">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-gray-200">

            <!-- Item -->
            <div class="px-6 py-4 text-center">
                <img
                    src="{{ asset('web/images/icons/icon1.svg') }}"
                    alt="Premium Quality"
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100"
                    loading="lazy"
                    decoding="async"
                    width="44"
                    height="44">

                <h3 class="mt-5 heading-font text-lg font-medium text-gray-900">
                    Premium Quality
                </h3>

                <p class="mt-2 text-sm text-gray-500 leading-6">
                    Crafted from carefully selected fabrics.
                </p>
            </div>

            <!-- Item -->
            <div class="px-6 py-4 text-center">
                <img
                    src="{{ asset('web/images/icons/icon2.svg') }}"
                    alt="Buyer Protection"
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100"
                    loading="lazy"
                    decoding="async"
                    width="44"
                    height="44">

                <h3 class="mt-5 heading-font text-lg font-medium text-gray-900">
                    Buyer Protection
                </h3>

                <p class="mt-2 text-sm text-gray-500 leading-6">
                    Secure payments & easy returns.
                </p>
            </div>

            <!-- Item -->
            <div class="px-6 py-4 text-center">
                <img
                    src="{{ asset('web/images/icons/icon4.svg') }}"
                    alt="Free Shipping"
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100"
                    loading="lazy"
                    decoding="async"
                    width="44"
                    height="44">

                <h3 class="mt-5 heading-font text-lg font-medium text-gray-900">
                    Free Shipping
                </h3>

                <p class="mt-2 text-sm text-gray-500 leading-6">
                    Complimentary delivery over ₹999.
                </p>
            </div>

            <!-- Item -->
            <div class="px-6 py-4 text-center">
                <img
                    src="{{ asset('web/images/icons/icon3.svg') }}"
                    alt="24/7 Support"
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100"
                    loading="lazy"
                    decoding="async"
                    width="44"
                    height="44">

                <h3 class="mt-5 heading-font text-lg font-medium text-gray-900">
                    24 / 7 Support
                </h3>

                <p class="mt-2 text-sm text-gray-500 leading-6">
                    Dedicated assistance whenever needed.
                </p>
            </div>

        </div>

    </div>
</section>


@include('components.web.editor-banner')


<!--OPTIMIZED: Bookmarked Styles Section -->
<section class="px-4 lgg:py-8 py-6 bg-gray-50">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-6">
            <div>
                <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-light text-gray-800 heading-font tracking-wide">
                    Our Bookmarked Styles
                </h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-secondary to-primary mt-2"></div>
            </div>
            <a href="{{ route('page.multi-product') }}"
                class="group flex items-center gap-2 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-medium text-secondary hover:text-primary transition-all font-sans">
                View All
                <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @forelse($mostWishlisted as $index => $product)
            @php
            $variant = $product->variants->first();
            $imageUrl = $product->featured_image ? url('/img/' . $product->featured_image. '?w=600&q=80') : asset('assets/images/placeholder.jpg');
            if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
            $parts = explode('upload/', $imageUrl);
            $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
            }
            @endphp
            <div class="item flex justify-center items-center">
                <div class="group w-full bg-white xxs:max-w-full max-w-[320px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200"
                    onclick="window.location.href='{{ route('page.single-product', $product->slug) }}';">

                    <!-- Image Wrapper -->
                    <div class="relative overflow-hidden bg-gray-100">
                        <a href="{{ route('category.show', $product->category->slug) }}">
                            <img src="{{ $imageUrl }}"
                                alt="{{ $product->name }}"
                                class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="900"
                                style="aspect-ratio: 600/900;" />
                        </a>

                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                                Quick View
                            </button>
                        </div>

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if (optional($product->variants->first())->discount == 0)
                            <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                                Trending
                            </span>
                            @else
                            <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                                @php
                                $discount = optional($product->variants->first())->discount ?? 0;
                                $value = ($discount - floor($discount) >= 0.5) ? ceil($discount) : $discount;
                                @endphp

                                {{ round($value, 2) }}% OFF
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-2">
                        <div class="flex items-start justify-between">
                            <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                                {{ $product->name ?? '' }}
                            </h3>
                            <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $product->brand ?? '' }}</span>
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
                            <span class="text-xs font-sans text-gray-400">({{ rand(10, 200) }})</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center gap-2 flex-wrap mt-1">
                            <span class="text-lg font-semibold text-gray-900 font-sans">Rs.
                                {{ $variant->discount_price ?? $product->price }}</span>
                            @if ($variant != null && ($variant->discount_price ?? $product->price) != ($variant->price ?? $product->price))
                            <span class="text-xs text-gray-400 line-through font-sans">Rs.
                                {{ $variant->price ?? $product->price }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-gray-500 font-sans">No wishlisted products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Combined Premium Services Card -->
<section class="py-16 lg:py-20 px-4 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto">
        <div class="text-center mb-12 lg:mb-16">
            <h2 class="text-3xl lg:text-4xl lg:leading-[3rem] leading-[2.5rem] font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-4 heading-font">
                Know How Celebrities Book Us for Their Occasion
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Get the perfect fit through our online portals
            </p>
        </div>

        <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-rose-50 via-white to-pink-50"></div>
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-rose-200 to-transparent rounded-full -translate-x-32 -translate-y-32">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-pink-200 to-transparent rounded-full translate-x-48 translate-y-48">
                </div>
            </div>

            <div class="relative py-12 lg:py-16 px-6 lg:px-12">
                <div class="flex lg:flex-row flex-col gap-8 lg:gap-12">
                    <div
                        class="group flex flex-col justify-between relative bg-gradient-to-br from-white to-rose-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-rose-100 flex-1">
                        <div class="absolute -top-3 w-full flex justify-center left-0">
                            <span
                                class="bg-gradient-to-r from-rose-500 to-pink-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                FREE SERVICE
                            </span>
                        </div>
                        <div class="flex flex-col items-center text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500 shadow-lg">
                                <svg class="w-10 h-10 text-rose-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                                Get connected with fashion experts
                            </h3>
                        </div>
                        <p class="text-gray-600 text-center mb-8 leading-relaxed">
                            A free service that has been provided so that you can who are trusting with your style and money. What happens during your time with us
                        </p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>One-to-one private video session with our fashion experts</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Virtual tour of fashion collection</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Live preview of what your fit looks like</span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('page.appointment') }}#appoint-book-section"
                                class="group inline-flex items-center justify-center gap-3 w-full px-8 py-4 bg-gradient-to-r from-rose-600 to-pink-600 text-white font-semibold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                                <svg class="w-5 h-5 sm:block hidden transform group-hover:scale-110 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span class="text-lg">Schedule an Appointment</span>
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:flex flex-col items-center justify-center relative">
                        <div class="absolute inset-0 flex items-center justify-center w-[5px]">
                            <div class="w-[3px] h-full bg-gradient-to-b from-transparent via-rose-200 to-transparent">
                            </div>
                        </div>
                    </div>

                    <div
                        class="group flex flex-col justify-between relative bg-gradient-to-br from-white to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-pink-100 flex-1">
                        <div class="absolute -top-3 w-full flex justify-center left-0">
                            <span
                                class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                PREMIUM SERVICE
                            </span>
                        </div>
                        <div class="flex flex-col items-center text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-pink-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500 shadow-lg">
                                <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                                Know your style and fit
                            </h3>
                        </div>
                        <p class="text-gray-600 text-center mb-8 leading-relaxed">
                            A premium service that makes the showstopper for the occasion.
                        </p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Live session with our bridal stylist</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Accessory coordination with our design</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <div
                                    class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span>Expert advice on how to embrace your personality with our design</span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('page.appointment') }}#appoint-book-section"
                                class="group inline-flex items-center justify-center gap-3 w-full px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                                <svg class="w-5 h-5 sm:block hidden transform group-hover:scale-110 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="text-lg">Book Bridal Consultation</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative w-full min-h-[800px] h-auto py-12 flex items-center justify-center overflow-hidden">
    <div class="parallax-bg absolute inset-0 bg-cover bg-top scale-110" data-parallax>
    </div>
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="container mx-auto relative z-10 px-4 md:px-6">
        <div class="h-full flex items-center lg:justify-end justify-center">
            <div
                class="bg-gradient-to-br from-white to-red-50 rounded-2xl shadow-2xl max-w-2xl w-full p-8 md:p-6 relative overflow-hidden border border-red-100">
                <div class="flex justify-center items-center">
                    <div
                        class="w-auto flex sm:flex-row flex-col bg-gradient-to-r from-primary to-secondary text-white text-sm font-bold px-8 py-3 rounded-full shadow-lg items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:block hidden" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                clip-rule="evenodd" />
                        </svg>
                        DESIGNER'S PERSPECTIVE
                    </div>
                </div>

                <div class="absolute top-4 right-4 opacity-10 md:block hidden">
                    <div class="text-6xl font-serif font-bold text-secondary">AF</div>
                </div>

                <div id="designer-thoughts" class="owl-carousel owl-theme mt-8">
                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Elevating Lahenga Elegance</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "At Aiman Fashion, we believe every lahenga tells a story. Our designs blend traditional craftsmanship with contemporary silhouettes, creating pieces that honor heritage while embracing modern elegance."
                            </p>
                        </div>
                        <div class="md:mt-8 mt-4 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div
                                        class="w-16 h-16 rounded-full bg-secondary-light flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Lead Designer</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs text-gray-500">Premium Collection</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Modern Salwar Kameez</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "Our salwar kameez collection redefines comfort with style. We focus on flattering cuts and breathable fabrics that celebrate the feminine form while ensuring maximum comfort."
                            </p>
                        </div>
                        <div class="mt-8 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Fashion Director</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs text-gray-500">Style Innovator</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">The Palazzo Revolution</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "Palazzos are our canvas for innovation. We experiment with fabrics and draping techniques to create pieces that are both trendy and timeless for the modern woman on the go."
                            </p>
                        </div>
                        <div class="mt-8 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Creative Head</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs text-gray-500">Trendsetter</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex md:justify-between justify-center md:absolute w-full md:left-0 md:bottom-[20%] px-[37px] md:z-[10] gap-4 mt-8 thoughts-nav">
                    <button
                        class="custom-prev-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="custom-next-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <div
                    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-transparent via-secondary to-transparent rounded-full">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script> --}}
<script src="{{ asset('web/home.js') }}"></script>
<!-- <script>
  // Load confetti only when you actually need it
  function loadConfetti(callback) {
    if (window.confetti) {
      callback();
      return;
    }
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js';
    script.onload = callback;
    document.body.appendChild(script);
  }
</script> -->
<!-- Cart Functionality -->
<!-- <script>
    function toggleHomeWishlist(productId, event) {
        console.log('toggleHomeWishlist called with productId:', productId);
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (!productId) {
            alert('Product ID not found');
            return;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const heartIcon = document.getElementById(`wishlist-heart-${productId}`);
        console.log('Heart icon element:', heartIcon);
        if (!heartIcon) {
            console.error('Heart icon not found for product:', productId);
            return;
        }
        const isSVG = heartIcon.tagName === 'svg';
        const isInWishlist = isSVG ? false : heartIcon.classList.contains('fas');
        const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';
        console.log('Is SVG element:', isSVG);
        console.log('Current wishlist state:', isInWishlist);
        console.log('Calling URL:', url);
        const originalContent = heartIcon.innerHTML;
        heartIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => {
                console.log('Raw response:', response);
                return response.json();
            })
            .then(data => {
                console.log(data);
                console.log('Parsed data:', data);
                console.log('Wishlist updated successfully');
                if (data.success) {
                    showNotification(data.message, 'success');
                    if (isInWishlist) {
                        heartIcon.innerHTML = '<i class="far fa-heart text-red-500"></i>';
                    } else {
                        heartIcon.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
                    }
                    if (data.wishlist_count !== undefined) {
                        updateWishlistCount(data.wishlist_count);
                    }
                } else {
                    if (data.message && data.message.includes('already in wishlist')) {
                        showNotification('Product is already in wishlist!', 'info');
                        if (isSVG && !isInWishlist) {
                            heartIcon.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
                        }
                    } else {
                        showNotification(data.message || 'Failed to update wishlist', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showNotification('An error occurred while updating wishlist', 'error');
            })
            .finally(() => {
                if (heartIcon.innerHTML.includes('fa-spinner')) {
                    heartIcon.innerHTML = originalContent;
                }
            });
    }

    function checkHomeProductWishlist(productId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const heartIcon = document.getElementById(`wishlist-heart-${productId}`);
        if (!heartIcon) return;
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
                console.log('Wishlist check response:', data);
                const heartIcon = document.getElementById(`wishlist-heart-${productId}`);
                if (heartIcon) {
                    if (data.in_wishlist) {
                        heartIcon.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
                    } else {
                        heartIcon.innerHTML = '<i class="far fa-heart text-red-500"></i>';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking wishlist:', error);
            });
    }

    // function updateWishlistCount(count) {
    //     const wishlistCounter = document.getElementById('wishlist-counter');
    //     if (wishlistCounter) {
    //         wishlistCounter.textContent = count;
    //     }
    // }
    function updateWishlistCount(count) {

        const button = document.querySelector('a[href*="wishlist"] button');

        let badge = document.getElementById('wishlist-counter');

        if (count > 0) {

            if (!badge) {

                badge = document.createElement('span');

                badge.id = "wishlist-counter";

                badge.className =
                    "wishlist-count absolute -top-1 -right-1 w-5 h-5 bg-red-700 text-white text-xs rounded-full flex items-center justify-center";

                button.appendChild(badge);
            }

            badge.innerHTML = count;

        } else {

            if (badge) badge.remove();
        }

        // dropdown badge
        document.querySelectorAll(".wishlist-count").forEach(function(item) {

            item.innerHTML = count;

            item.style.display = count > 0 ? "flex" : "none";

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

    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });
    }
</script> -->

<!-- <script>
    const bg = document.querySelector(".parallax-bg");
    const section = bg.closest("section");

    function updateParallax() {
        const rect = section.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        if (rect.bottom > 0 && rect.top < windowHeight) {
            const scrollProgress = rect.top / windowHeight;
            const movement = scrollProgress * -500;
            bg.style.transform = `translateY(${movement}px) scale(1.2)`;
        }
    }

    window.addEventListener("scroll", updateParallax);
    window.addEventListener("resize", updateParallax);
    updateParallax();
</script> -->

<!-- <script defer>
    const sliders = [{
            className: 'slide-left',
            linkId: 'leftSliderLink'
        },
        {
            className: 'slide-top',
            linkId: 'topSliderLink'
        },
        {
            className: 'slide-center',
            linkId: 'centerSliderLink'
        },
        {
            className: 'slide-right',
            linkId: 'rightSliderLink'
        },
        {
            className: 'slide-bottom',
            linkId: 'bottomSliderLink'
        },
    ];

    let currentIndex = 0;

    function updateSlider(slider) {
        const slides = document.querySelectorAll('.' + slider.className);
        const link = document.getElementById(slider.linkId);
        if (slides.length === 0) return;
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        const activeIndex = currentIndex % slides.length;
        slides.forEach((slide, i) => {
            slide.classList.remove('opacity-100', 'z-10', 'fade-out', 'fade-in');
            slide.classList.add('opacity-0', 'z-0');
        });
        slides[prevIndex].classList.remove('opacity-0', 'z-0');
        slides[prevIndex].classList.add('opacity-100', 'z-10', 'fade-out');
        slides[activeIndex].classList.remove('opacity-0', 'z-0');
        slides[activeIndex].classList.add('fade-in', 'z-10');
        if (link) {
            link.href = slides[activeIndex].dataset.link || '#';
        }
        const prefix = slider.className.replace('slide-', '');
        const title = document.getElementById(prefix + 'TitleText');
        const shortText = document.getElementById(prefix + 'ShortText');
        const offerText = document.getElementById(prefix + 'OfferText');
        const shopBtn = document.getElementById(prefix + 'ShopBtn');
        if (title) title.innerText = slides[activeIndex].dataset.title || '';
        if (shortText) shortText.innerText = slides[activeIndex].dataset.short || '';
        if (shopBtn) shopBtn.href = slides[activeIndex].dataset.link || '#';
        if (offerText) {
            if (slides[activeIndex].dataset.offer) {
                offerText.innerHTML = `
                    <span class="inline-flex items-center gap-1 bg-black/20 backdrop-blur-md py-1 px-3 rounded-[50px] shadow-lg">
                        <span class="text-xl font-bold text-white">${slides[activeIndex].dataset.offer}</span>
                        <span class="text-lg uppercase tracking-[6px] text-white font-semibold">% OFF</span>
                    </span>
                `;
                offerText.style.display = "inline-flex";
                offerText.style.alignItems = "center";
            } else {
                offerText.style.display = "none";
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        sliders.forEach(updateSlider);
        setInterval(() => {
            currentIndex++;
            sliders.forEach(updateSlider);
        }, 4000);
    });

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
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        fetch(url, {
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
                if (data.success) {
                    if (isInWishlist) {
                        button.classList.remove('text-red-500');
                        button.innerHTML = '<i class="far fa-heart"></i>';
                    } else {
                        button.classList.add('text-red-500');
                        button.innerHTML = '<i class="fas fa-heart"></i>';
                        if (typeof fbq !== 'undefined') {
                            fbq('track', 'AddToWishlist', {
                                content_name: @json($product->name ?? ''),
                                content_ids: [@json($product->id ?? '')],
                                content_type: 'product',
                                value: {{
                                        $product->variants->first()->discount_price ?? $product->variants->first()->price ?? 0 }},
                                currency: 'INR'
                            });
                        }
                    }
                    document.querySelectorAll('.wishlist-count').forEach(function(item) {
                        item.textContent = data.wishlist_count;
                        if (data.wishlist_count > 0) {
                            item.style.display = "flex";
                        } else {
                            item.style.display = "none";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Added',
                        text: data.message,
                        ConfirmButtonText: 'Ok',
                        timer: 1800
                    });
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

        updateWishlistCount(data.wishlist_count);
    }
</script> -->

@if($isTimmer)
<script>
    (function() {

        const TARGET_DATE = new Date("{{ \Carbon\Carbon::parse($isTimmer->end_date)->format('Y-m-d H:i:s') }}");

        const daysBox = document.getElementById('daysBox');
        const hoursBox = document.getElementById('hoursBox');
        const minutesBox = document.getElementById('minutesBox');
        const secondsBox = document.getElementById('secondsBox');
        const daysLabel = document.getElementById('daysLabel');

        function pad(num) {
            return String(num).padStart(2, '0');
        }

        function updateCountdown() {

            const now = new Date();
            let diff = TARGET_DATE.getTime() - now.getTime();

            if (diff <= 0) {
                diff = 0;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            if (daysLabel) daysLabel.textContent = days;
            if (daysBox) daysBox.textContent = days;
            if (hoursBox) hoursBox.textContent = pad(hours);
            if (minutesBox) minutesBox.textContent = pad(minutes);
            if (secondsBox) secondsBox.textContent = pad(seconds);
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

    })();
</script>
@endif

<!-- <script defer>
    document.addEventListener('DOMContentLoaded', function() {
        if ($('#categories-tag-carousel').length) {
            $('#categories-tag-carousel').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                smartSpeed: 500,
                responsive: {
                    0: {
                        items: 1.5,
                        margin: 15,
                    },
                    480: {
                        items: 2.5,
                        margin: 15,
                    },
                    640: {
                        items: 3.5,
                        margin: 15,
                    },
                    768: {
                        items: 4.5,
                        margin: 20,
                    },
                    1024: {
                        items: 6.5,
                        margin: 20,
                    },
                    1280: {
                        items: 8.5,
                        margin: 25,
                    }
                }
            });
        }
    });
</script> -->

<script>
    // Wait for jQuery and OwlCarousel to load
    function initHeroCarousel() {
        if (typeof $ !== 'undefined' && typeof $.fn.owlCarousel !== 'undefined') {
            $('.hero-carousel').owlCarousel({
                items: 1,
                loop: true,
                margin: 0,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 5500,
                autoplayHoverPause: true,
                stopOnHover: true, // Add this line
                smartSpeed: 900,
                navText: ['', ''],
                responsive: {
                    0: {
                        nav: true,
                        dots: true
                    },
                    768: {
                        nav: true,
                        dots: true
                    }
                }
            });
        } else {
            console.warn('Owl Carousel not loaded, retrying...');
            setTimeout(initHeroCarousel, 500);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroCarousel);
    } else {
        initHeroCarousel();
    }
</script>
@endsection