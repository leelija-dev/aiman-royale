@extends('layout.web.main-layout')

@section('content')


<style>
    /* Fade out animation */
    .fade-out {
        animation: fadeOut 1.2s ease-in-out forwards;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    #unique-scroll

    /* Fade in animation */
    .fade-in {
        animation: fadeIn 1.2s ease-in-out forwards;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Base styles for slides */
    .slide-left,
    .slide-top,
    .slide-center,
    .slide-right,
    .slide-bottom {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: none;
    }

    /* Ensure content transitions smoothly with the fade */
    .fade-out .content,
    .fade-in .content {
        transition: opacity 0.3s ease;
    }

    #unique-scroll .custom-nav-tags,
    #unique-scroll .owl-dots,
    #unique-scroll .owl-nav {
        display: none !important;
    }
</style>

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
                    <div
                        class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-pink-100 transition-all duration-300">
                        @php
                        $variantImage = $category->images->sortByDesc('id')->first()?->image;

                        $productImage = $category->product->images->sortByDesc('id')->first()?->image;
                        $catagoryImage = $category->product->category->image;
                        $catImage = $variantImage ?: $productImage ?: $catagoryImage;

                        // Optional: placeholder if neither exists
                        // if (!$catImage) {
                        // $catImage = asset('assets/images/placeholder-category.jpg');
                        // }

                        if (strpos($catImage, 'cloudinary.com') !== false && strpos($catImage, 'upload/') !== false) {
                        $parts = explode('upload/', $catImage);
                        $catImage = $parts[0] . 'upload/w_200,h_200,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img src="{{ $catImage }}"
                            alt="{{ $category->product->category->name }}"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                            decoding="async"
                            width="200"
                            height="200">
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

{{--<section class="px-4 lgg:py-8 py-6 h-auto bg-gradient-to-b from-secondary-light to-white">
    <div class="container mx-auto">
        <div class="flex flex-row gap-3 lgg:gap-[9px] justify-between items-stretch h-auto">
            <!-- Left Image Column - 9:16 Portrait (Responsive) -->
            @php
            $leftCategories = $homeCategories['left'] ?? collect();
            $leftBanners = $bannerHeroSection->where('position', 'left')->values();
            @endphp
            <div class="flex-1 overflow-hidden lgg:block hidden relative">
                <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl aspect-[9/16]">
                    @if ($leftBanners->count())
                    <a id="leftSliderLink" href="{{ $leftBanners->first()->redirect_link }}"
class="block h-full w-full relative">
@foreach ($leftBanners as $index => $banner)
@php
$bannerImage = $banner->image;
if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
$parts = explode('upload/', $bannerImage);
$bannerImage = $parts[0] . 'upload/w_750,h_1500,c_fill,f_auto,q_auto/' . $parts[1];
}
@endphp
<img class="slide-left absolute inset-0 object-cover h-full w-full transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
    src="{{ $bannerImage }}" alt="{{ $banner->title }}"
    data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
    data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
    loading="lazy"
    decoding="async"
    width="750"
    height="1500">
@endforeach
</a>
@else
<a id="leftSliderLink" href="{{ url('collections/lehanga') }}"
    class="absolute inset-0 z-20 block">
    <img class="slide-left absolute inset-0 object-cover h-full w-full transition-opacity duration-1000"
        src="{{ asset('web/images/banner-images/glow-orange-2.webp') }}" alt="Store"
        loading="lazy"
        decoding="async">
</a>
@endif
<div
    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
</div>
</div>
<div
    class="absolute bottom-4 left-4 opacity-1 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
    <a href="{{ url('collections/new-collection') }}">
        <span
            class="bg-gradient-to-r from-primary to-secondary backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-white shadow-lg">
            {{ $leftCategories->first()?->slug ?? 'New Collection' }}
        </span>
    </a>
</div>
</div>

<!-- Middle Content Column -->
<div class="3xl:min-w-[550px] 2xl:min-w-[450px] xl:min-w-[400px] lgg:min-w-[350px] min-w-[250px] lgg:w-auto lgg:mx-0 mx-auto smx:max-w-[550px]  w-full flex flex-col gap-3 lg:gap-6">
    <!-- Top Image - 16:10 Landscape -->
    @php
    $topCategories = $homeCategories['top'] ?? collect();
    $topBanners = $bannerHeroSection->where('position', 'top')->values();
    @endphp
    <div class="w-full overflow-hidden relative group rounded-[4px] shadow-lg aspect-[16/10]">
        <div
            class="absolute inset-0 bg-gradient-to-r from-primary/10 to-secondary/10 z-10 pointer-events-none">
        </div>
        @if ($topBanners->count())
        <a id="topSliderLink" href="{{ $topBanners->first()->redirect_link ?? '#' }}"
            class="block h-full w-full relative">
            @foreach ($topBanners as $index => $banner)
            @php
            $bannerImage = $banner->image;
            if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
            $parts = explode('upload/', $bannerImage);
            $bannerImage = $parts[0] . 'upload/w_800,h_500,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <img class="slide-top absolute inset-0 object-cover h-full w-full object-top object-center transition-opacity duration-1000 transform group-hover:scale-110 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                loading="lazy"
                decoding="async"
                width="800"
                height="500">
            @endforeach
        </a>
        @else
        <a href="{{ url('collections/' . 'lehanga') }}">
            <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                src="{{ asset('web/images/product-images/Poses In Frock Suit.jpg') }}"
                alt="Glow Pink Dress"
                loading="lazy"
                decoding="async">
        </a>
        @endif
    </div>

    <!-- Center Image - 9:16 Portrait -->
    @php
    $centerBanners = $bannerHeroSection->where('position', 'center')->values();
    @endphp

    <div class="relative overflow-hidden rounded-[4px] shadow-2xl flex-grow ">
        @if ($centerBanners->count())
        <a id="centerSliderLink" href="{{ $centerBanners->first()->redirect_link }}"
            class="absolute inset-0 block">
            @foreach ($centerBanners as $index => $banner)
            @php
            $bannerImage = $banner->image;
            if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
            $parts = explode('upload/', $bannerImage);
            $bannerImage = $parts[0] . 'upload/w_600,h_1067,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <img class="slide-center absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                loading="lazy"
                decoding="async"
                width="600"
                height="1067">
            @endforeach
        </a>

        <!-- Content Overlay -->
        <div
            class="absolute inset-0 z-30 flex flex-col justify-center items-center text-center px-4 text-white">
            @if ($centerBanners->first()->offer)
            <div id="centerOfferText" class="inline-flex items-center mb-1">
                <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-[40px] shadow-lg">
                    <span class="text-xl font-bold text-white">
                        {{ $centerBanners->first()->offer }}
                    </span>
                    <span class="text-base font-semibold text-white">
                        % OFF
                    </span>
                </span>
            </div>
            @endif
            <h2 id="centerTitleText" class="heading-font text-2xl md:text-3xl text-white mb-1.5 drop-shadow-lg leading-tight">
                {{ $centerBanners->first()->title }}
            </h2>
            <p id="centerShortText" class="text-[11px] text-white drop-shadow-lg mb-3">
                Get <span class="font-semibold text-secondary-light">{{ $centerBanners->first()->short_description }}</span>
            </p>
            <a id="centerShopBtn" href="{{ $centerBanners->first()->redirect_link }}"
                class="px-5 py-1.5 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-none text-[11px] tracking-wide inline-flex items-center transition-all duration-300">
                Shop Now
                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @else
        <div
            class="flex flex-col items-center justify-center space-y-1.5 p-3 lg:p-4 bg-gradient-to-br from-secondary-light via-white to-primary/10 rounded-[4px] shadow-2xl border border-gray-100 flex-grow relative overflow-hidden h-full">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-20 h-20 bg-primary rounded-full -translate-x-10 -translate-y-10"></div>
                <div class="absolute bottom-0 right-0 w-28 h-28 bg-secondary rounded-full translate-x-14 translate-y-14"></div>
            </div>
            <div
                class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-16 h-0.5 bg-gradient-to-r from-transparent via-primary to-transparent">
            </div>
            <h1
                class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-bold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent">
                PRICE DROP
            </h1>
            <div class="relative">
                <span
                    class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-extrabold text-white relative z-10"
                    style="-webkit-text-stroke:2px black;">
                    SALE
                </span>
            </div>
            <p class="text-gray-600 font-medium tracking-wider text-sm uppercase">
                NEW COLLECTION
            </p>
            <div class="text-center text-gray-500 mb-0.5">
                <span class="line-through text-[11px] mr-1">₹199.99</span>
                <span class="text-base font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">₹99.99</span>
            </div>
            <a href="{{ url('collections/new-collection') }}"
                class="px-5 py-1.5 lg:px-6 lg:py-2 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-full text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                Shop Now →
            </a>
            <p class="text-[11px] text-gray-500 mt-0.5">
                Limited Period Offer
            </p>
        </div>
        @endif
    </div>

    <!-- Bottom Image - 16:10 Landscape -->
    @php
    $bottomBanners = $bannerHeroSection->where('position', 'bottom')->values();
    @endphp

    <div class="w-full overflow-hidden relative group rounded-[4px] shadow-lg aspect-[16/10]">
        @if ($bottomBanners->count())
        <a id="bottomSliderLink" href="{{ $bottomBanners->first()->redirect_link }}"
            class="block h-full w-full relative">
            @foreach ($bottomBanners as $index => $banner)
            @php
            $bannerImage = $banner->image;
            if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
            $parts = explode('upload/', $bannerImage);
            $bannerImage = $parts[0] . 'upload/w_800,h_500,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <img class="slide-bottom absolute inset-0 object-cover h-full w-full object-top object-center transition-opacity duration-1000 transform group-hover:scale-110 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                loading="lazy"
                decoding="async"
                width="800"
                height="500">
            @endforeach
        </a>
        @else
        <a href="{{ url('collections/lehanga') }}">
            <img class="object-cover h-full w-full"
                src="{{ asset('web/images/product-images/Long Frock Poses Photo Ideas At Home.jpg') }}"
                alt="Bottom Banner"
                loading="lazy"
                decoding="async">
        </a>
        @endif
    </div>
</div>

<!-- Right Image Column - 9:16 Portrait (Responsive) -->
@php
$rightBanners = $bannerHeroSection->where('position', 'right')->values();
@endphp

<div class="flex-1 overflow-hidden lgg:block hidden relative">
    <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl aspect-[9/16]">
        @if ($rightBanners->count())
        <a id="rightSliderLink" href="{{ $rightBanners->first()->redirect_link }}"
            class="absolute inset-0 z-20 block">
            @foreach ($rightBanners as $index => $banner)
            @php
            $bannerImage = $banner->image;
            if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
            $parts = explode('upload/', $bannerImage);
            $bannerImage = $parts[0] . 'upload/w_750,h_1500,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <img class="slide-right absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                loading="lazy"
                decoding="async"
                width="750"
                height="1500">
            @endforeach
        </a>
        @else
        <a id="rightSliderLink" href="{{ url('collections/lehanga') }}"
            class="absolute inset-0 z-20 block">
            <img class="object-cover h-full w-full"
                src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Right Banner"
                loading="lazy"
                decoding="async">
        </a>
        @endif
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
        </div>
    </div>
</div>
</div>
</div>
</section> --}}

<style>
    /* ----- MODERN HERO SLIDER · redesigned ----- */
    .hero-carousel .slide-item {
        position: relative;

        /* more immersive */
        /* min-height: 600px; */
        /* max-height: 700px; */

        border-radius: 0;
        /* clean edge, no rounding */
    }

    .hero-carousel .owl-stage-outer {
        border-radius: 34px;
        overflow: hidden;
        padding: 0 !important;
        /* margin-top: 21px; */
    }

    /* image layer – subtle zoom + overlay for depth */
    .hero-carousel .slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 6s ease-in-out;
        transform: scale(1.05);
        /* gentle zoom */
    }

    .hero-carousel .slide-item:hover .slide-bg {
        transform: scale(1);
        /* slow pull-back on hover */
    }

    /* dark overlay for better text readability */
    /* .hero-carousel .slide-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.1) 70%);
        z-index: 1;
        pointer-events: none;
    } */

    /* content – centered with modern left-aligned refinement */
    .hero-carousel .slide-content {
        position: absolute;
        bottom: 15%;
        left: 8%;
        color: #fff;
        max-width: 580px;
        z-index: 2;
        text-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        padding: 24px 32px 32px 32px;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        border-radius: 12px;
        border-left: 4px solid #e6c9a8;
        transition: all 0.3s ease;
    }

    .hero-carousel .slide-content:hover {
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .hero-carousel .brand-name {
        font-size: 36px;
        font-weight: 400;
        letter-spacing: 6px;
        text-transform: uppercase;
        margin-bottom: 8px;
        font-family: 'Georgia', 'Times New Roman', serif;
        color: #f5ede4;
        line-height: 1.1;
    }

    .hero-carousel .brand-name span {
        display: inline-block;
        border-bottom: 2px solid #e6c9a8;
        padding-bottom: 6px;
    }

    .hero-carousel .tagline {
        font-size: 17px;
        font-weight: 300;
        letter-spacing: 3px;
        margin-bottom: 24px;
        opacity: 0.95;
        color: #f0e7dc;
        text-transform: uppercase;
        font-family: 'Inter', 'Helvetica Neue', sans-serif;
    }

    .hero-carousel .shop-btn {
        display: inline-block;
        padding: 14px 40px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        letter-spacing: 4px;
        transition: all 0.35s ease;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        border-radius: 40px;
        font-weight: 500;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .hero-carousel .shop-btn:hover {
        background: #fff;
        color: #1a1a1a;
        border-color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        letter-spacing: 5px;
    }

    .hero-carousel .shop-btn i {
        margin-left: 8px;
        font-size: 11px;
    }

    /* ---------- Owl Carousel custom overrides ---------- */

    /* dots – modern, minimal, placed at bottom-center */
    .hero-carousel .owl-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        /* display: flex; */
        gap: 12px;
        z-index: 5;
        display: none !important;
    }

    .hero-carousel .owl-dots .owl-dot span {
        background: rgba(255, 255, 255, 0.35);
        width: 12px;
        height: 12px;
        margin: 0;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .hero-carousel .owl-dots .owl-dot.active span {
        background: #f5ede4;
        transform: scale(1.25);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
    }

    .hero-carousel .owl-dots .owl-dot:hover span {
        background: rgba(255, 255, 255, 0.8);
    }

    /* navigation arrows – refined, circular, glass-morphism */
    .hero-carousel .owl-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        pointer-events: none;
        z-index: 5;
    }

    .hero-carousel .owl-nav button {
        pointer-events: auto;
        background: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        color: #fff !important;
        width: 52px;
        height: 52px;
        border-radius: 50% !important;
        font-size: 28px !important;
        font-weight: 300;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .hero-carousel .owl-nav .owl-prev {
        margin-left: 10px;
    }

    .hero-carousel .owl-nav .owl-next {
        margin-right: 10px;
    }

    .hero-carousel .owl-nav button:hover {
        background: rgba(255, 255, 255, 0.25) !important;
        transform: scale(1.08);
        border-color: rgba(255, 255, 255, 0.6) !important;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
    }

    /* hide default owl nav text (‹ ›) – we use font-awesome in JS */
    .hero-carousel .owl-nav button span {
        display: none;
    }

    /* custom icon via pseudo – but we'll use data-* in JS, so clean */
    .hero-carousel .owl-nav .owl-prev::before {
        content: '\f104';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 26px;
        display: inline-block;
    }

    .hero-carousel .owl-nav .owl-next::before {
        content: '\f105';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 26px;
        display: inline-block;
    }

    /* ensure no extra nav text */
    .hero-carousel .owl-nav button span {
        display: none !important;
    }

    /* make arrows visible on small screens */
    @media (min-width: 768px) {
        .hero-carousel .hero-carousel-desktop {
            display: block !important;
        }

        .hero-carousel .hero-carousel-mobile {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .hero-carousel .hero-carousel-mobile {
            display: block !important;
        }

        .hero-carousel .hero-carousel-desktop {
            display: none !important;
        }

        .hero-carousel .owl-nav {
            padding: 0 8px;
        }

        .hero-carousel .owl-nav button {
            width: 40px;
            height: 40px;
            font-size: 20px !important;
        }

        .hero-carousel .slide-content {
            left: 5%;
            bottom: 12%;
            max-width: 85%;
            padding: 18px 20px 24px 20px;
        }

        .hero-carousel .brand-name {
            font-size: 26px;
            letter-spacing: 4px;
        }

        .hero-carousel .tagline {
            font-size: 14px;
            letter-spacing: 2px;
        }

        .hero-carousel .shop-btn {
            padding: 10px 28px;
            font-size: 11px;
        }


    }

    @media (min-width: 576px) {
        .hero-carousel .hero-carousel-desktop {
            display: block !important;
            aspect-ratio: 16/6;
        }

        .hero-carousel .hero-carousel-mobile {
            display: none !important;

        }

        /* .hero-carousel .slide-item{
            max-height:700px;
        } */
    }

    @media (max-width: 576px) {
        .hero-carousel .hero-carousel-mobile {
            display: block !important;
            aspect-ratio: 2/3 !important;
        }

        .hero-carousel .hero-carousel-desktop {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .hero-carousel .slide-content {
            left: 4%;
            bottom: 10%;
            max-width: 92%;
            padding: 14px 16px 20px 16px;
            border-left-width: 3px;
        }

        .hero-carousel .brand-name {
            font-size: 20px;
            letter-spacing: 2px;
        }

        .hero-carousel .tagline {
            font-size: 12px;
            margin-bottom: 16px;
            letter-spacing: 1px;
        }

        .hero-carousel .shop-btn {
            padding: 8px 20px;
            font-size: 10px;
            letter-spacing: 2px;
        }

        .hero-carousel .owl-dots {
            bottom: 18px;
            gap: 8px;
        }

        .hero-carousel .owl-dots .owl-dot span {
            width: 10px;
            height: 10px;
        }
    }

    /* optional: subtle animation for content */
    .hero-carousel .slide-content {
        animation: fadeUp 0.9s ease-out both;
    }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ensure owl container has no overflow issues */
    .hero-carousel {
        overflow: hidden;
        border-radius: 0;
    }
</style>
<!-- updated HTML block – slide structure with Font Awesome icons -->
<section class="px-4 lgg:py-4 py-3 ">
    <div class="container mx-auto">
        <div class="hero-carousel owl-carousel owl-theme ">
            <!-- Slide 1 -->
            @foreach($bannerHeroSection as $banner)
            <div class="slide-item relative">

                {{-- @if($banner-> --}}
                <a href="{{$banner->redirect_link}}"><img class="hero-carousel-desktop" src="{{ $banner->image }}" class="w-full h-full object-cover md:hidden  " alt=""> </a>{{--asset('web/images/custom_design/1784293240602women-the-celebration-closet.webp')--}}
                <a href="{{$banner->redirect_link}}"> <img class="hero-carousel-mobile" src="{{ $banner->mobile_screen_image }}" class="w-full h-full object-cover md:block  hidden" alt=""></a> {{--asset('web/images/custom_design/portrait-image.jpg')--}}



                <!-- <div class="slide-content">
                    <h2 class="brand-name"><span>Seema Gujral</span></h2>
                    <p class="tagline">An ode to timeless elegance</p>
                    <a href="#" class="shop-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div> -->
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
                <!-- Category 1 -->
                <div class="item p-2">
                    <a href="#" class="group block relative overflow-hidden rounded-3xl">
                        <!-- Main Image Container -->
                        <div class="relative h-96 overflow-hidden rounded-3xl">
                            <!-- Image with zoom effect -->
                            <img src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}"
                                alt="Salwar Kameez"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                loading="lazy"
                                decoding="async" />
                            <!-- Transparent Overlay Content - Shows on hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                                <!-- Floating Badge -->
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Popular
                                        </span>
                                    </span>
                                </div>
                                <!-- Category Name -->
                                <h3
                                    class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem] font-bold text-white mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    Salwar Kameez
                                </h3>
                                <!-- Description -->
                                <p
                                    class="text-gray-200 text-sm mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Traditional elegance with modern designs
                                </p>
                                <!-- Styles Count -->
                                <div
                                    class="flex items-center mb-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span
                                        class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        120+ Designs
                                    </span>
                                </div>
                                <!-- Shop Now Button -->
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                    <span
                                        class="inline-flex items-center text-sm font-semibold text-white bg-white/20 px-5 py-2.5 rounded-full border border-white/30 hover:bg-white/30 transition-colors">
                                        Shop Now
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!-- Minimal Content Visible Before Hover -->
                            <div
                                class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                <h3 class="text-2xl font-bold text-white mb-2">Salwar Kameez</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        120+ Designs
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 2 -->
                <div class="item p-2">
                    <a href="#" class="group block relative overflow-hidden rounded-3xl">
                        <div class="relative h-96 overflow-hidden rounded-3xl">
                            <img src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}"
                                alt="Lehanga"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                loading="lazy"
                                decoding="async" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                            </svg>
                                            Bridal
                                        </span>
                                    </span>
                                </div>
                                <h3
                                    class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem] font-bold text-white mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    Lehengas
                                </h3>
                                <p
                                    class="text-gray-200 text-sm mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Royal bridal collections
                                </p>
                                <div
                                    class="flex items-center mb-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span
                                        class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        80+ Collections
                                    </span>
                                </div>
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                    <span
                                        class="inline-flex items-center text-sm font-semibold text-white bg-white/20 px-5 py-2.5 rounded-full border border-white/30 hover:bg-white/30 transition-colors">
                                        Shop Now
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!-- Minimal Content Before Hover -->
                            <div
                                class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                <h3 class="text-2xl font-bold text-white mb-2">Lehengas</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        80+ Collections
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <!-- Dynamic Categories -->
                @foreach ($categoriesWithProduct as $category)
                <div class="item p-2">

                    @php
                    $catImg = $category->latestProductWithImage->featured_image
                    ? $category->latestProductWithImage->featured_image
                    : $category->image;

                    if (strpos($catImg, 'cloudinary.com') !== false && strpos($catImg, 'upload/') !== false) {
                    $parts = explode('upload/', $catImg);
                    $catImg = $parts[0].'upload/w_700,h_950,c_fill,f_auto,q_auto/'.$parts[1];
                    }
                    @endphp

                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group relative block overflow-hidden">

                        <!-- Image -->

                        <img
                            src="{{ $catImg }}"
                            alt="{{ $category->name }}"
                            class="w-full aspect-[9/13] object-cover object-top transition duration-700 group-hover:scale-105">

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
                @endphp

                <div class="item ">

                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group block">

                        <!-- Image -->

                        <div class="overflow-hidden bg-[#fafafa]">

                            <div class="aspect-[3/4] overflow-hidden rounded-[10px]">

                                <img
                                    src="{{ $tagImage }}"
                                    alt="{{ $category->name }}"
                                    loading="lazy"
                                    decoding="async"
                                    width="400"
                                    height="520"
                                    class="w-full h-full object-cover object-top transition duration-700 group-hover:scale-105">

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
                        $imageUrl = $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg');
                        if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                        $parts = explode('upload/', $imageUrl);
                        $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
                        }
                        @endphp
                        <img src="{{ $imageUrl }}"
                            alt="{{ $product->name }}"
                            class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="900" />

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
                                {{ $product->discount }}% OFF
                            </span>
                            @endif
                        </div>

                        <!-- Wishlist Heart Icon -->
                        @if (Auth::check())
                        <button
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full p-2.5 shadow-lg transition-all hover:scale-110 w-[38px] h-[38px] flex justify-center items-center text-gray-400 hover:text-red-500"
                            onclick="toggleWishlist({{ $product->id }}, this, event);">
                            <i class="far fa-heart text-sm"></i>
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
                        <img src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}"
                            alt="Saree Collection"
                            class="w-full h-full object-cover object-top rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300"
                            loading="lazy"
                            decoding="async">
                        <div
                            class="absolute -bottom-2 -left-2 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 border border-gray-200 shadow-sm">
                            <p class="text-gray-900 text-xs font-bold digital-font">₹74.99</p>
                        </div>
                    </div>

                    <div
                        class="relative w-56 h-56 mx-auto transform -rotate-3 hover:rotate-0 transition-transform duration-500 cursor-pointer group z-[10]">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-pink-400/10 rounded-2xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}"
                            alt="Premium Lehenga"
                            class="w-full h-full object-cover object-top rounded-2xl shadow-xl border-4 border-white group-hover:border-secondary transition-all duration-300"
                            loading="lazy"
                            decoding="async">
                        <div
                            class="absolute -top-3 -right-3 bg-secondary text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-6 digital-font">
                            -25%
                        </div>
                    </div>

                    <div
                        class="absolute bottom-8 left-4 w-40 h-40 transform -rotate-12 hover:rotate-3 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tl from-secondary/10 to-pink-600/10 rounded-xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}"
                            alt="Party Wear"
                            class="w-full h-full object-cover object-top rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300"
                            loading="lazy"
                            decoding="async">
                        <div
                            class="absolute -top-2 -right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg font-sans">
                            New
                        </div>
                    </div>

                    <div
                        class="absolute bottom-4 right-0 w-32 h-32 rounded-full overflow-hidden border-4 border-white hover:border-secondary transition-all duration-300 cursor-pointer group z-10 shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary/10 to-pink-600/10"></div>
                        <img src="{{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}"
                            alt="Kurta Set"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                            decoding="async">
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
                <div class="mt-10 text-center">
                    <div
                        class="inline-flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-6 py-3 shadow-sm hover:border-secondary-light transition-all duration-300 cursor-pointer group">
                        <div class="flex -space-x-3">
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    alt="" class="w-full h-full object-cover" loading="lazy">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    alt="" class="w-full h-full object-cover" loading="lazy">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    alt="" class="w-full h-full object-cover" loading="lazy">
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
                </div>
            </div>

            <!-- Right - CTA + Trust -->
            <div class="text-center">
                <h3
                    class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient mb-4 font-serif">
                    Make Every Entrance Unforgettable.
                </h3>
                <button
                    class="w-full sm:w-auto relative p-[16px_34px] bg-gradient-to-r from-secondary to-pink-500 hover:from-secondary hover:to-primary text-white font-bold text-xl rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-secondary/20 font-sans">
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i>
                    Grab now
                </button>
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
            $bannerImg = asset('uploads/banners/' . $banner->image);
            if (strpos($bannerImg, 'cloudinary.com') !== false && strpos($bannerImg, 'upload/') !== false) {
            $parts = explode('upload/', $bannerImg);
            $bannerImg = $parts[0] . 'upload/w_600,h_1000,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <div class="px-2">
                <a href="{{ $banner->link }}" class="block w-full">
                    <div class="relative overflow-hidden group bg-[#f8f6f4] rounded-[18px]"
                        style="aspect-ratio: 9/15; "
                        @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                        @else
                        data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>

                        <!-- Image -->
                        <div class="absolute inset-0">
                            <img class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                src="{{ $bannerImg }}"
                                alt="{{ $banner->title }}"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="1000" />
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

<style>
    /* Vertical Text Utility */
    .writing-vertical {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        letter-spacing: 4px;
    }

    #uniq-ads-slider .owl-dots {
        display: none !important;
    }

    /* Owl Carousel Custom Styles - With Backdrop Blur & Font Awesome */
    #uniq-ads-slider .owl-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        pointer-events: none;
        margin-top: 0;
        z-index: 10;
    }

    #uniq-ads-slider .owl-nav button {
        pointer-events: auto;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-radius: 50% !important;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    #uniq-ads-slider .owl-nav button:hover {
        background: rgba(212, 168, 139, 0.92) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 8px 30px rgba(212, 168, 139, 0.4);
        border-color: rgba(212, 168, 139, 0.5);
    }

    #uniq-ads-slider .owl-nav button:active {
        transform: translateY(-50%) scale(0.95);
    }

    #uniq-ads-slider .owl-nav button.owl-prev {
        left: -12px;
    }

    #uniq-ads-slider .owl-nav button.owl-next {
        right: -12px;
    }

    /* Font Awesome Icons */
    #uniq-ads-slider .owl-nav button.owl-prev::before {
        content: "\f104";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 24px;
        color: #2c1810;
        transition: color 0.3s ease;
        line-height: 1;
    }

    #uniq-ads-slider .owl-nav button.owl-next::before {
        content: "\f105";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 24px;
        color: #2c1810;
        transition: color 0.3s ease;
        line-height: 1;
    }

    #uniq-ads-slider .owl-nav button:hover::before {
        color: #ffffff;
    }

    /* Hide default nav text */
    #uniq-ads-slider .owl-nav button span {
        display: none !important;
    }

    /* Dots Styling */
    #uniq-ads-slider .owl-dots {
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }

    #uniq-ads-slider .owl-dots .owl-dot {
        width: 8px;
        height: 8px;
        background: #d4a88b !important;
        border-radius: 50%;
        transition: all 0.3s ease;
        opacity: 0.5;
    }

    #uniq-ads-slider .owl-dots .owl-dot.active {
        background: #2c1810 !important;
        width: 28px;
        border-radius: 20px;
        opacity: 1;
    }

    #uniq-ads-slider .owl-dots .owl-dot:hover {
        opacity: 1;
    }

    /* Banner Card Hover */
    .banner-card {
        transition: all 0.4s ease;
    }

    .banner-card:hover {
        transform: translateY(-5px);
    }

    /* Line clamp */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Mobile Responsive */
    @media (max-width: 640px) {
        #uniq-ads-slider .owl-nav button {
            width: 38px;
            height: 38px;
        }

        #uniq-ads-slider .owl-nav button.owl-prev {
            left: -10px;
        }

        #uniq-ads-slider .owl-nav button.owl-next {
            right: -10px;
        }

        #uniq-ads-slider .owl-nav button.owl-prev::before,
        #uniq-ads-slider .owl-nav button.owl-next::before {
            font-size: 18px;
        }

        #uniq-ads-slider .owl-dots {
            bottom: -25px;
            gap: 6px;
        }

        #uniq-ads-slider .owl-dots .owl-dot {
            width: 6px;
            height: 6px;
        }

        #uniq-ads-slider .owl-dots .owl-dot.active {
            width: 20px;
        }

        #uniq-ads-slider .owl-nav {
            top: 55%;
        }
    }

    @media (min-width: 641px) and (max-width: 1024px) {
        #uniq-ads-slider .owl-nav button.owl-prev {
            left: -12px;
        }

        #uniq-ads-slider .owl-nav button.owl-next {
            right: -12px;
        }

        #uniq-ads-slider .owl-nav button {
            width: 42px;
            height: 42px;
        }

        #uniq-ads-slider .owl-nav button.owl-prev::before,
        #uniq-ads-slider .owl-nav button.owl-next::before {
            font-size: 20px;
        }
    }

    @media (min-width: 1025px) {
        #uniq-ads-slider .owl-nav button.owl-prev {
            left: -12px;
        }

        #uniq-ads-slider .owl-nav button.owl-next {
            right: -12px;
        }

        #uniq-ads-slider .owl-nav button {
            width: 54px;
            height: 54px;
        }

        #uniq-ads-slider .owl-nav button.owl-prev::before,
        #uniq-ads-slider .owl-nav button.owl-next::before {
            font-size: 26px;
        }
    }
</style>

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

                <div class="mt-8">

                    <h4 class="text-xl sm:text-2xl md:text-3xl lg:text-[31px] font-medium text-gray-800 leading-tight">
                        Hurry…only
                        <span id="daysLabel" class="font-semibold text-gray-900">
                            30
                        </span>
                        days left!
                    </h4>

                    <div
                        class="mt-7 flex flex-wrap justify-center lgg:justify-start gap-6">

                        <div class="text-center">

                            <div
                                id="daysBox"
                                class="heading-font text-4xl font-medium text-gray-900">
                                29
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

            </div>

            <!-- Right Content - Carousel -->
            <div class="w-full lgg:w-[59%] flex justify-center items-center">
                <div class="second-owl owl-carousel owl-theme relative w-full">
                    @foreach ($secondaryBanners as $banner)
                    @php
                    $secBannerImg = asset('uploads/banners/' . $banner->image);
                    if (strpos($secBannerImg, 'cloudinary.com') !== false && strpos($secBannerImg, 'upload/') !== false) {
                    $parts = explode('upload/', $secBannerImg);
                    $secBannerImg = $parts[0] . 'upload/w_600,h_800,c_fill,f_auto,q_auto/' . $parts[1];
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
                                    alt="{{ $banner->title }}"
                                    class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async"
                                    width="600"
                                    height="800" />

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-500"></div>
                            </div>

                            <!-- Banner Content - Bottom Left -->
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/50 to-[#00000005]">
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
                                        <a href="#"
                                            class="group/btn inline-flex items-center gap-2
        px-5 py-2
        text-xs font-semibold uppercase tracking-[0.15em]
        text-white
        bg-gradient-to-r from-primary to-secondary
        border border-transparent
        rounded-sm
        shadow-md
        transition-all duration-300 ease-out
        hover:from-secondary hover:to-primary
        hover:shadow-xl hover:-translate-y-0.5">

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
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100">

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
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100">

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
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100">

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
                    class="w-11 h-11 mx-auto opacity-80 transition duration-300 hover:opacity-100">

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

{{-- <section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Our signature Standouts
            </h2>
            <p class="text-p-xs lgg:text-p-sm xl:text-p-md 2xl:text-p-lg text-gray-500">
                Red Carpet Ready in Every Design We Create
            </p>
        </div>
        <div class="grid-container">
            @php
            $editorBanners = \App\Models\Banner::active()->where('type', 'editor')->ordered()->get();
            @endphp
            <div class="owl-carousel banner-carousel lgg:hidden">
                @foreach($editorBanners as $banner)
                @php
                $editorImg = asset('uploads/banners/' . $banner->image);
                if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
                $parts = explode('upload/', $editorImg);
                $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
                }
                @endphp
                <div class="relative bg-[#b8a89a] "
                    @if($banner->filter_type === 'multiple' && $banner->filters)
                    data-filter="{{ $banner->filters }}"
@else
data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
<a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] w-full relative block">
    <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
        class="absolute inset-0 w-full h-full object-contain object-center object-top"
        loading="lazy"
        decoding="async"
        width="800"
        height="600" />
</a>
<!-- <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
</div>
@endforeach
</div>

<div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 ">
    @foreach ($editorBanners as $index => $banner)
    @php
    $editorImg = asset('uploads/banners/' . $banner->image);
    if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
    $parts = explode('upload/', $editorImg);
    $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
    }
    @endphp
    @if ($index % 2 == 0)
    <div class="relative bg-[#b8a89a] "
        @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
        @else
        data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] relative block">
            <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
                class="absolute inset-0 w-full h-full object-contain object-center object-top"
                loading="lazy"
                decoding="async"
                width="800"
                height="600" />

        </a>

        <!-- <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
    </div>
    @endif
    @endforeach

    @foreach ($editorBanners as $index => $banner)
    @php
    $editorImg = asset('uploads/banners/' . $banner->image);
    if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
    $parts = explode('upload/', $editorImg);
    $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
    }
    @endphp
    @if ($index % 2 == 1)
    <div class="relative bg-[#e8dcd6] "
        @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
        @else
        data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] relative w-full block">
            <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
                class="absolute inset-0 w-full h-full object-cover object-center object-top"
                loading="lazy"
                decoding="async"
                width="800"
                height="600" />
        </a>
        <!-- <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
    </div>
    @endif
    @endforeach
</div>
</div>
</div>
</section> --}}
@include('components.web.editor-banner')


<!-- 🔥 OPTIMIZED: Bookmarked Styles Section -->
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
            $imageUrl = $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg');
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
                                height="900" />
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
                                {{ optional($product->variants->first())->discount }}% OFF
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
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<!-- Cart Functionality -->
<script>
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
                console.loj('Wishlist updated successfully');
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

    function updateWishlistCount(count) {
        const wishlistCounter = document.getElementById('wishlist-counter');
        if (wishlistCounter) {
            wishlistCounter.textContent = count;
        }
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
</script>

<script>
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
</script>

<script>
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
    }
</script>

<script>
    (function() {
        const TARGET_DATE = new Date();
        TARGET_DATE.setDate(TARGET_DATE.getDate() + 30);
        TARGET_DATE.setHours(0, 0, 0, 0);

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
            const diffMs = TARGET_DATE - now;
            let remainingSeconds = Math.max(0, Math.floor(diffMs / 1000));
            const days = Math.floor(remainingSeconds / 86400);
            remainingSeconds %= 86400;
            const hours = Math.floor(remainingSeconds / 3600);
            remainingSeconds %= 3600;
            const minutes = Math.floor(remainingSeconds / 60);
            const seconds = remainingSeconds % 60;

            const daysStr = String(days);
            const hoursStr = pad(hours);
            const minsStr = pad(minutes);
            const secsStr = pad(seconds);

            if (daysLabel) {
                daysLabel.textContent = daysStr;
            }
            if (daysBox) {
                daysBox.textContent = daysStr;
            }
            if (hoursBox) {
                hoursBox.textContent = hoursStr;
            }
            if (minutesBox) {
                minutesBox.textContent = minsStr;
            }
            if (secondsBox) {
                secondsBox.textContent = secsStr;
            }
        }

        updateCountdown();
        const timerInterval = setInterval(updateCountdown, 1000);
        window.addEventListener('beforeunload', function() {
            clearInterval(timerInterval);
        });
    })();
</script>

<script>
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
</script>

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