@extends('layout.web.main-layout')

@section('content')

<style>
    #ads-carousel .owl-nav {
        display: none !important;
    }

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

    #unique-scroll .custom-nav-tags,#unique-scroll .owl-dots,#unique-scroll .owl-nav {
        display:none !important;
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
            @if ($categories)
            @foreach ($categories->whereNull('parent_id') as $category)
            <a href="{{ route('category.show', $category->slug) }}"
                class="group flex flex-col items-center snap-center">
                <div class="relative mb-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
                    </div>
                    <div
                        class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-pink-100 transition-all duration-300">
                        @php
                        $catImage = $category->image ?  $category->image : asset('assets/images/placeholder-category.jpg');
                        if (strpos($catImage, 'cloudinary.com') !== false && strpos($catImage, 'upload/') !== false) {
                            $parts = explode('upload/', $catImage);
                            $catImage = $parts[0] . 'upload/w_200,h_200,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img src="{{ $catImage }}"
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                            decoding="async"
                            width="200"
                            height="200">
                    </div>
                </div>
                <span
                    class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-pink-700 transition-colors duration-300">{{ $category->name }}</span>
                <span class="text-xs text-gray-500 mt-1">Most Loved</span>
            </a>
            @endforeach
            @endif
        </div>
    </div>
</div>

<section class="px-4 lgg:py-8 py-6 h-auto bg-gradient-to-b from-secondary-light to-white">
    <div class="container mx-auto">
        <div class="flex flex-row gap-3 lg:gap-6 justify-between items-stretch h-auto">
            <!-- Left Image Column -->
            @php
            $leftCategories = $homeCategories['left'] ?? collect();
            $leftBanners = $bannerHeroSection->where('position', 'left')->values();
            @endphp
            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl">
                    @if ($leftBanners->count())
                    <a id="leftSliderLink" href="{{ $leftBanners->first()->redirect_link }}"
                        class="block h-full w-full relative">
                        @foreach ($leftBanners as $index => $banner)
                        @php
                        $bannerImage = $banner->image;
                        if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
                            $parts = explode('upload/', $bannerImage);
                            $bannerImage = $parts[0] . 'upload/w_800,h_1000,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img class="slide-left absolute inset-0 object-cover h-full w-full transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                            data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                            data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                            loading="lazy"
                            decoding="async"
                            width="800"
                            height="1000">
                        @endforeach
                    </a>

                    <!-- Text Overlay -->
                    <div class="absolute inset-0 z-30 flex flex-col justify-center h-full lg:p-8 p-2">
                        @if ($leftBanners->first()?->offer)
                        <div id="leftOfferText" class="inline-flex items-center mb-4">
                            <span class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-md py-1 px-3 rounded-[50px] shadow-lg">
                                <span class="text-3xl font-bold text-white">
                                    {{ $leftBanners->first()->offer }}
                                </span>
                                <span class="text-lg uppercase tracking-[6px] text-white font-semibold">
                                    % OFF
                                </span>
                            </span>
                        </div>
                        @endif
                        <h2 id="leftTitleText"
                            class="heading-font text-4xl md:text-5xl text-white mb-4 drop-shadow-[0_0_10px_black] leading-tight font-extrabold">
                            {{ $leftBanners->first()->title }}
                        </h2>
                        <p id="leftShortText" class="text-lg text-white drop-shadow-[0_0_10px_black] mb-6">
                            Get <span class="font-semibold text-secondary-light">{{ $leftBanners->first()->short_description }}</span> | Use Code:
                            <span class="font-medium bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent bg-white/20 px-2 py-0.5 rounded">CODE20</span>
                        </p>
                        <a id="leftShopBtn" href="{{ $leftBanners->first()->redirect_link }}"
                            class="w-fit bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-2 text-sm tracking-wide rounded-none shadow-lg transition-all duration-300 inline-flex items-center">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
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
            <div class="xl:min-w-[600px] lgg:min-w-[350px] min-w-[250px] md:w-auto w-full flex flex-col gap-3 lg:gap-6">
                <!-- Top Image -->
                @php
                $topCategories = $homeCategories['top'] ?? collect();
                $topBanners = $bannerHeroSection->where('position', 'top')->values();
                @endphp
                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-[4px] shadow-lg">
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
                            $bannerImage = $parts[0] . 'upload/w_600,h_400,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img class="slide-top absolute inset-0 object-cover h-full w-full object-top object-center transition-opacity duration-1000 transform group-hover:scale-110 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                            data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                            data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="400">
                        @endforeach
                    </a>
                    <div class="absolute left-6 bottom-6 z-20 text-white">
                        @if ($topBanners->first()?->offer)
                        <div id="topOfferText" class="inline-flex items-center mb-2">
                            <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg shadow-lg">
                                <span class="text-4xl font-extrabold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent drop-shadow-lg">
                                    {{ $topBanners->first()->offer }}
                                </span>
                                <span class="text-sm uppercase tracking-wider bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent font-semibold">
                                    % OFF
                                </span>
                            </span>
                        </div>
                        @endif
                        <h3 id="topTitleText" class="text-3xl font-extrabold heading-font text-white drop-shadow-[0_0_10px_black]">
                            {{ $topBanners->first()?->title }}
                        </h3>
                        <p id="topShortText" class="mt-2 text-sm text-white drop-shadow-[0_0_10px_black]">
                            Get <span class="font-semibold text-secondary-light">{{ $topBanners->first()?->short_description }}</span>
                        </p>
                        <a id="topShopBtn" href="{{ $topBanners->first()?->redirect_link }}"
                            class="inline-flex items-center mt-4 px-5 py-2 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-none text-sm tracking-wide transition-all duration-300">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    @else
                    <!-- Default Image -->
                    <a href="{{ url('collections/' . 'lehanga') }}">
                        <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                            src="{{ asset('web/images/product-images/Poses In Frock Suit.jpg') }}"
                            alt="Glow Pink Dress"
                            loading="lazy"
                            decoding="async">
                    </a>
                    @endif
                </div>

                @php
                $centerBanners = $bannerHeroSection->where('position', 'center')->values();
                @endphp

                <div class="relative overflow-hidden rounded-[4px] shadow-2xl flex-grow min-h-[350px]">
                    @if ($centerBanners->count())
                    <a id="centerSliderLink" href="{{ $centerBanners->first()->redirect_link }}"
                        class="absolute inset-0 block">
                        @foreach ($centerBanners as $index => $banner)
                        @php
                        $bannerImage = $banner->image;
                        if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
                            $parts = explode('upload/', $bannerImage);
                            $bannerImage = $parts[0] . 'upload/w_600,h_400,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img class="slide-center absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                            data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                            data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="400">
                        @endforeach
                    </a>

                    <!-- Content -->
                    <div
                        class="absolute inset-0 z-30 flex flex-col justify-center items-center text-center px-8 text-white">
                        @if ($centerBanners->first()->offer)
                        <div id="centerOfferText" class="inline-flex items-center mb-4">
                            <span class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-md px-6 py-4 rounded-[40px] shadow-lg">
                                <span class="text-3xl font-bold text-white">
                                    {{ $centerBanners->first()->offer }}
                                </span>
                                <span class="text-xl font-semibold text-white">
                                    % OFF
                                </span>
                            </span>
                        </div>
                        @endif
                        <h2 id="centerTitleText" class="heading-font text-4xl md:text-5xl text-white mb-4 drop-shadow-lg leading-tight">
                            {{ $centerBanners->first()->title }}
                        </h2>
                        <p id="centerShortText" class="text-sm text-white drop-shadow-lg mb-8">
                            Get <span class="font-semibold text-secondary-light">{{ $centerBanners->first()->short_description }}</span>
                        </p>
                        <a id="centerShopBtn" href="{{ $centerBanners->first()->redirect_link }}"
                            class="px-8 py-3 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-none text-sm tracking-wide inline-flex items-center transition-all duration-300">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    @else
                    <div
                        class="flex flex-col items-center justify-center space-y-4 p-6 lg:p-8 bg-gradient-to-br from-secondary-light via-white to-primary/10 rounded-[4px] shadow-2xl border border-gray-100 flex-grow relative overflow-hidden h-full">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-5">
                            <div class="absolute top-0 left-0 w-32 h-32 bg-primary rounded-full -translate-x-16 -translate-y-16"></div>
                            <div class="absolute bottom-0 right-0 w-40 h-40 bg-secondary rounded-full translate-x-20 translate-y-20"></div>
                        </div>
                        <div
                            class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-transparent via-primary to-transparent">
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
                        <p class="text-gray-600 font-medium tracking-wider text-lg uppercase">
                            NEW COLLECTION
                        </p>
                        <div class="text-center text-gray-500 mb-2">
                            <span class="line-through text-sm mr-2">₹199.99</span>
                            <span class="text-xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">₹99.99</span>
                        </div>
                        <a href="{{ url('collections/new-collection') }}"
                            class="px-8 py-3 lg:px-10 lg:py-4 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-full text-[1.3rem] font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            Shop Now →
                        </a>
                        <p class="text-sm text-gray-500 mt-2">
                            Limited Period Offer
                        </p>
                    </div>
                    @endif
                </div>

                @php
                $bottomBanners = $bannerHeroSection->where('position', 'bottom')->values();
                @endphp

                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-[4px] shadow-lg">
                    @if ($bottomBanners->count())
                    <a id="bottomSliderLink" href="{{ $bottomBanners->first()->redirect_link }}"
                        class="block h-full w-full relative">
                        @foreach ($bottomBanners as $index => $banner)
                        @php
                        $bannerImage = $banner->image;
                        if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
                            $parts = explode('upload/', $bannerImage);
                            $bannerImage = $parts[0] . 'upload/w_600,h_400,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img class="slide-bottom absolute inset-0 object-cover h-full w-full object-top object-center transition-opacity duration-1000 transform group-hover:scale-110 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                            data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                            data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="400">
                        @endforeach
                    </a>

                    <!-- Bottom Banner Text -->
                    <div class="absolute left-6 bottom-6 z-30 text-white">
                        @if ($bottomBanners->first()->offer)
                        <div id="bottomOfferText" class="inline-flex items-center mb-2">
                            <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg shadow-lg">
                                <span class="text-4xl font-extrabold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent drop-shadow-lg">
                                    {{ $bottomBanners->first()->offer }}
                                </span>
                                <span class="text-sm uppercase tracking-wider bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent font-semibold">
                                    % OFF
                                </span>
                            </span>
                        </div>
                        @endif
                        <h3 id="bottomTitleText" class="text-3xl font-extrabold heading-font text-white drop-shadow-[0_0_10px_black]">
                            {{ $bottomBanners->first()->title }}
                        </h3>
                        <p id="bottomShortText" class="mt-2 text-sm text-white drop-shadow-[0_0_10px_black]">
                            Get <span class="font-semibold text-secondary-light">{{ $bottomBanners->first()->short_description }}</span>
                        </p>
                        <a id="bottomShopBtn" href="{{ $bottomBanners->first()->redirect_link }}"
                            class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white rounded-none text-sm tracking-wide transition-all duration-300">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
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

            <!-- Right Image Column -->
            @php
            $rightBanners = $bannerHeroSection->where('position', 'right')->values();
            @endphp

            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl">
                    @if ($rightBanners->count())
                    <a id="rightSliderLink" href="{{ $rightBanners->first()->redirect_link }}"
                        class="absolute inset-0 z-20 block">
                        @foreach ($rightBanners as $index => $banner)
                        @php
                        $bannerImage = $banner->image;
                        if (strpos($bannerImage, 'cloudinary.com') !== false && strpos($bannerImage, 'upload/') !== false) {
                            $parts = explode('upload/', $bannerImage);
                            $bannerImage = $parts[0] . 'upload/w_800,h_1000,c_fill,f_auto,q_auto/' . $parts[1];
                        }
                        @endphp
                        <img class="slide-right absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ $bannerImage }}" alt="{{ $banner->title }}"
                            data-link="{{ $banner->redirect_link }}" data-title="{{ $banner->title }}"
                            data-short="{{ $banner->short_description }}" data-offer="{{ $banner->offer }}"
                            loading="lazy"
                            decoding="async"
                            width="800"
                            height="1000">
                        @endforeach
                    </a>

                    <!-- Right Banner Text -->
                    <div class="absolute inset-0 z-30 flex flex-col justify-center h-full lg:p-8 p-2">
                        @if ($rightBanners->first()->offer)
                        <div id="rightOfferText" class="inline-flex items-center mb-4">
                            <span class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-md py-1 px-3 rounded-[50px] shadow-lg">
                                <span class="text-3xl font-bold text-white">
                                    {{ $rightBanners->first()->offer }}
                                </span>
                                <span class="text-lg uppercase tracking-[6px] text-white font-semibold">
                                    % OFF
                                </span>
                            </span>
                        </div>
                        @endif
                        <h2 id="rightTitleText"
                            class="heading-font text-4xl md:text-5xl text-white mb-4 drop-shadow-[0_0_10px_black] leading-tight font-extrabold">
                            {{ $rightBanners->first()->title }}
                        </h2>
                        <p id="rightShortText" class="text-lg text-white drop-shadow-[0_0_10px_black] mb-6">
                            Get <span class="font-semibold text-secondary-light">{{ $rightBanners->first()->short_description }}</span> | Use Code:
                            <span class="font-medium bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent bg-white/20 px-2 py-0.5 rounded">CODE20</span>
                        </p>
                        <a id="rightShopBtn" href="{{ $rightBanners->first()->redirect_link }}"
                            class="w-fit bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-2 text-sm tracking-wide rounded-none shadow-lg transition-all duration-300 inline-flex items-center">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
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
</section>

<section class="px-4 lgg:py-8 py-6 bg-gradient-to-b from-white to-gray-50/50">
    <div class="container mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-0">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-primary via-secondary to-black bg-clip-text text-transparent">
                    Be the showstopper on <br>every occasion
                </span>
            </h2>
            <p class="text-gray-600 max-w-xl mx-auto">
                Navigate our elite collections for gowns, salwar kameez, and suits
            </p>
        </div>

        <!-- Owl Carousel Container -->
        <div class="relative px-2">
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
                    <a href="{{ route('category.show', $category->slug) }}" class="group block relative overflow-hidden rounded-[0px]">
                        <div class="relative overflow-hidden rounded-[0px]">
                            @php
                            $catImg = $category->latestProductWithImage->featured_image ? $category->latestProductWithImage->featured_image : $category->image;
                            if (strpos($catImg, 'cloudinary.com') !== false && strpos($catImg, 'upload/') !== false) {
                                $parts = explode('upload/', $catImg);
                                $catImg = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto/' . $parts[1];
                            }
                            @endphp
                            <img src="{{ $catImg }}"
                                alt="{{ $category->name }}"
                                class="w-full h-auto aspect-[9/13] object-cover group-hover:scale-110 transition-transform duration-700"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="900" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="bg-gradient-to-r from-gray-800 to-black block text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Collection
                                        </span>
                                    </span>
                                </div>
                                <h3
                                    class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem] font-bold text-white mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    {{ $category->name }}
                                </h3>
                                <p
                                    class="text-gray-200 text-sm lgg:mb-4 mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Explore our exclusive collection
                                </p>
                                <div
                                    class="flex items-center lgg:mb-6 mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span
                                        class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        100+ Styles
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
                                <h3 class="text-2xl font-bold text-white mb-2">{{ $category->name }}</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        100+ Styles
                                    </span>
                                </div>
                            </div>
                        </div>
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
            <a href="#"
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

<section id="unique-scroll" class="px-4 lgg:py-8 py-6 bg-gradient-to-t from-white to-gray-50/50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Elegance at every wear</h2>
            <p class="text-gray-500">Experience class and sophistication for life's most memorable moments</p>
        </div>

        <!-- Owl Carousel Container -->
        <div class="relative px-2">
            <div id="categories-tag-carousel" class="owl-carousel owl-theme">
                @foreach ($categories as $category)
                <div class="item">
                    <a href="{{ route('category.show', $category->slug) }}" class="group relative mt-8 block">
                        <!-- String/Hanger -->
                        <div class="absolute -top-8 left-1/2 w-px h-8 bg-primary transform -translate-x-1/2"></div>
                        <div class="absolute -top-10 left-1/2 w-3 h-3 rounded-full bg-primary transform -translate-x-1/2"></div>

                        <!-- Tag -->
                        <div class="relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden w-full">
                            <!-- Tag Hole -->
                            <div class="absolute hidden top-3 left-1/2 w-4 h-4 rounded-full bg-amber-100 border-2 border-white transform -translate-x-1/2 z-10">
                            </div>

                            <!-- Image -->
                            <div class="h-32 overflow-hidden">
                                @php
                                $tagImage = $category->image ? $category->image : asset('assets/images/placeholder-category.jpg');
                                if (strpos($tagImage, 'cloudinary.com') !== false && strpos($tagImage, 'upload/') !== false) {
                                    $parts = explode('upload/', $tagImage);
                                    $tagImage = $parts[0] . 'upload/w_300,h_200,c_fill,f_auto,q_auto/' . $parts[1];
                                }
                                @endphp
                                <img src="{{ $tagImage }}"
                                    alt="{{ $category->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 object-top"
                                    loading="lazy"
                                    decoding="async"
                                    width="300"
                                    height="200" />
                            </div>

                            <!-- Content -->
                            <div class="p-3 text-center">
                                <h3 class="font-medium text-gray-800 text-sm mb-1 truncate">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Custom Navigation Arrows -->
            <div class="custom-nav-tags hidden lg:flex absolute top-1/2 -translate-y-1/2 left-0 right-0 justify-between px-2 pointer-events-none z-[1]">
                <button class="owl-tag-prev bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="owl-tag-next bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 🔥 OPTIMIZED: Trending Best Selling Products Section -->
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Trending Best Selling Products
            </h2>
            <a href="{{ route('page.multi-product') }}"
                class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
                All Products
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if ($products && $products->count() > 0)
            @foreach ($products as $product)
            <div class="item flex justify-center items-center">
                <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-[6px] shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                    onclick="window.location.href='{{ route('page.single-product', $product->slug) }}';">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-[6px] overflow-hidden">
                        @php
                        $imageUrl = $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg');
                        if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                            $parts = explode('upload/', $imageUrl);
                            $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
                        }
                        @endphp
                        <img src="{{ $imageUrl }}"
                            alt="{{ $product->name }}"
                            class="w-full h-auto aspect-[9/13] object-cover object-top object-center"
                            loading="lazy"
                            decoding="async"
                            width="600"
                            height="900" />

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if ($product->discount == 0)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                                Trending
                            </span>
                            @else
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                {{ $product->discount }}% OFF
                            </span>
                            @endif
                        </div>

                        <!-- Wishlist Heart Icon -->
                        @if (Auth::check())
                        <button
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                            onclick="toggleWishlist({{ $product->id }}, this, event);">
                            <i class="far fa-heart"></i>
                        </button>
                        @else
                        <a href="{{ route('page.login') }}">
                            <button
                                class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center">
                                <i class="far fa-heart"></i>
                            </button>
                        </a>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900 truncate">
                            {{ $product->name }}
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>{{ $product->brand }}</span>
                            <span class="flex items-center gap-1 text-gray-700">
                                <span class="text-sm font-medium">4.4</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="text-lg font-bold text-gray-900">Rs.
                                {{ $product->price_after_discount }}</span>
                            @if ($product->price_after_discount != $product->price)
                            <span class="text-sm text-gray-400 line-through">Rs.
                                {{ $product->price }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="text-center py-8">
                <p class="text-gray-500">No products available at the moment.</p>
            </div>
            @endif
        </div>
    </div>
</section>

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto lgg:py-12 lgg:px-12 py-12 px-4 relative rounded-[10px] overflow-hidden">
        <span class="absolute z-[1] top-[8px] right-[30px] text-secondary/30 text-[100px]">%</span>
        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 via-white to-pink-100 z-[-1]"></div>
        <div class="grid lgg:grid-cols-3 lgg:gap-4 gap-8 xl:gap-16 items-center">

            <!-- Left - Guarantee Info -->
            <div class="">
                <div class="lgg:text-left text-center">
                    <div class="mb-6">
                        <h3 class="text-2xl md:text-5xl font-bold text-gray-900">Shop With Complete Confidence</h3>
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
                            <p class="text-gray-900 text-xs font-bold">₹74.99</p>
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
                            class="absolute -top-3 -right-3 bg-secondary text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-6">
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
                            class="absolute -top-2 -right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
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
                            <span class="text-white text-sm font-bold">View</span>
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
                                class="text-gray-900 text-sm font-semibold group-hover:text-secondary transition-colors">
                                Premium Collection</p>
                            <p class="text-gray-500 text-xs">4+ stunning designs</p>
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
                    class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient mb-4">
                    Make Every Entrance Unforgettable.
                </h3>
                <button
                    class="w-full sm:w-auto relative p-[16px_34px] bg-gradient-to-r from-secondary to-pink-500 hover:from-secondary hover:to-primary text-white font-bold text-xl rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-secondary/20">
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i>
                    Grab now
                </button>
            </div>
        </div>
    </div>
</section>

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div id="ads-carousel" class="owl-carousel owl-theme">
            @foreach ($mainBanners as $banner)
            @php
            $bannerImg = asset('uploads/banners/' . $banner->image);
            if (strpos($bannerImg, 'cloudinary.com') !== false && strpos($bannerImg, 'upload/') !== false) {
                $parts = explode('upload/', $bannerImg);
                $bannerImg = $parts[0] . 'upload/w_1200,h_600,c_fill,f_auto,q_auto/' . $parts[1];
            }
            @endphp
            <div class="relative overflow-hidden rounded-[0px] shadow-lg bg-cover bg-center h-96 group banner-card"
                @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                @else
                data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top transition-transform duration-700 group-hover:scale-110"
                        src="{{ $bannerImg }}"
                        alt="{{ $banner->title }}"
                        loading="lazy"
                        decoding="async"
                        width="1200"
                        height="600" />
                </div>
                <div
                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/70 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out">
                    <div class="relative flex flex-col justify-end md:p-8 p-4 h-full text-white">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <span class="text-[2.7rem] font-bold font-serif uppercase tracking-wider lgg:mb-4 mb-2">
                            {{ $banner->title }}
                        </span>
                        @if ($banner->description)
                        <p class="lgg:text-3xl text-[1.2rem] font-serif lgg:mb-6 mb-3">
                            {{ $banner->description }}
                        </p>
                        @endif
                        <a href="#"
                            class="inline-block w-fit text-center bg-black text-white lgg:px-8 px-4 py-2 lgg:text-md text-sm font-sans rounded-full uppercase tracking-wide hover:bg-gray-600 transition-all duration-300 ease-in-out">{{ $banner->button_text }}</a>
                        @if ($banner->discount)
                        <p class="text-md lgg:mt-4 mt-2 font-sans opacity-80">
                            {{ $banner->discount }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="flex flex-col lgg:flex-row gap-8 lgg:gap-12">
            <div class="w-full lgg:w-2/5 px-4 lgg:text-left text-center">
                <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold text-gray-800">
                    Our Biggest Monsoon Sale of the Season
                </h2>
                <p class="mt-4 text-gray-500 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
                    Enjoy up to 50% OFF on selected designer collections.
                </p>
                <p class="mt-2 text-gray-500 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
                    Limited-time offer,
                </p>
                <p class="mt-2 text-gray-500 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
                    <strong>shop now!</strong>
                </p>
                <button class="mt-6 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-900 transition">
                    Shop Now
                </button>

                <h4 class="mt-10 text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg lgg:text-h4-lgg xl:text-h4-xl 2xl:text-h4-2xl font-semibold text-gray-800">
                    Hurry…only <span id="daysLabel">30</span> days left!
                </h4>

                <div class="mt-6 flex gap-4 flex-wrap lgg:justify-start justify-center">
                    <div class="text-center">
                        <div class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold" id="daysBox">
                            30
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Days</p>
                    </div>
                    <div class="text-center">
                        <div class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold" id="hoursBox">
                            00
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Hr</p>
                    </div>
                    <div class="text-center">
                        <div class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold" id="minutesBox">
                            00
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Mins</p>
                    </div>
                    <div class="text-center">
                        <div class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold" id="secondsBox">
                            00
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Sec</p>
                    </div>
                </div>
            </div>

            <div class="w-full lgg:w-[59%] flex justify-center items-center">
                <div class="second-owl owl-carousel owl-theme relative">
                    @foreach ($secondaryBanners as $banner)
                    @php
                    $secBannerImg = asset('uploads/banners/' . $banner->image);
                    if (strpos($secBannerImg, 'cloudinary.com') !== false && strpos($secBannerImg, 'upload/') !== false) {
                        $parts = explode('upload/', $secBannerImg);
                        $secBannerImg = $parts[0] . 'upload/w_600,h_800,c_fill,f_auto,q_auto/' . $parts[1];
                    }
                    @endphp
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow cursor-pointer banner-card"
                            @if($banner->filter_type === 'multiple' && $banner->filters)
                            data-filter="{{ $banner->filters }}"
                            @else
                            data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                            <div class="relative overflow-hidden">
                                <img src="{{ $secBannerImg }}"
                                    alt="{{ $banner->title }}"
                                    class="w-full h-[400px] object-cover object-center object-top"
                                    loading="lazy"
                                    decoding="async"
                                    width="600"
                                    height="800" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600">{{ $banner->subtitle }}</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">{{ $banner->title }}</span>
                                    </div>
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        {{ $banner->discount }}
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

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-gray-800">
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon1.svg') }}"
                    alt="" loading="lazy" decoding="async" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">Premium Quality</h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">Made of the finest material</p>
                </div>
            </div>
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon2.svg') }}"
                    alt="" loading="lazy" decoding="async" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">Buyer Protection</h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">2+ years</p>
                </div>
            </div>
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon4.svg') }}"
                    alt="" loading="lazy" decoding="async" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">Free Shipping</h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">Over **</p>
                </div>
            </div>
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon3.svg') }}"
                    alt="" loading="lazy" decoding="async" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">24 / 7 Support</h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">Dedicated guidance</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="px-4 lgg:py-8 py-6">
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
                    <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] w-full relative block" >
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
</section>

<!-- 🔥 OPTIMIZED: Bookmarked Styles Section -->
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Our Bookmarked Styles
            </h2>
            <p class="text-p-xs lgg:text-p-sm xl:text-p-md 2xl:text-p-lg text-gray-500">
                Step Into Every Occasion with Rihanna Ready Confidence
            </p>
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
                <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative rounded-[6px] overflow-hidden">
                        <a href="{{ route('category.show', $product->category->slug) }}">
                            <img src="{{ $imageUrl }}"
                                alt="{{ $product->name }}"
                                class="w-full h-auto aspect-[9/13] object-cover object-top object-center"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="900" />
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if (optional($product->variants->first())->discount == 0)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                                Trending
                            </span>
                            @else
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                {{ optional($product->variants->first())->discount }}% OFF
                            </span>
                            @endif
                        </div>

                        @php
                        $variant_id = optional($variant)->id ?? $variant?->first()->id;
                        @endphp
                        <div class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <a href="{{ route('page.single-product', $product->slug) }}">
                                <button class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                                    View
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900 truncate">
                            {{$product->name ?? ''}}
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>{{ $product->brand ?? '' }}</span>
                            <span class="flex items-center gap-1 text-gray-700">
                                <span class="text-sm font-medium">4.4</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="text-lg font-bold text-gray-900">Rs.
                                {{ $variant->discount_price ?? $product->price }}</span>
                            @if ($variant != null)
                            <span class="text-sm text-gray-400 line-through">Rs.
                                {{ $variant->price ?? $product->price }}</span>
                            @endif
                        </div>
                        <div class="lgg:hidden block">
                            <a href="{{ route('category.show', $product->category->slug) }}">
                                <button class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">View</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No wishlisted products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Combined Premium Services Card -->
<section class="py-16 lg:py-20 px-4 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto">
        <div class="text-center mb-12 lg:mb-16">
            <h2
                class="text-3xl lg:text-4xl lg:leading-[3rem] leading-[2.5rem] font-bold bg-gradient-to-r from-rose-700 via-pink-600 to-purple-600 bg-clip-text text-transparent mb-4">
                Know How Celebrities Book us for their Occasion
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
@endsection