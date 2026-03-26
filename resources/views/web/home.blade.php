@extends('layout.web.main-layout')









@section('content')

<style>
    #ads-carousel .owl-nav {
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
            <!-- <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 tracking-tight">
                        Explore Our <span class="bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Collections</span>
                    </h3> -->
            <!-- <p class="text-gray-600 text-sm md:text-base max-w-md mx-auto">
                        Curated styles for every occasion. Discover your perfect look.
                    </p> -->
        </div>
    </div>

    <!-- Horizontal Scroll with Enhanced Styling -->
    <div class="relative overflow-x-auto scrollbar-hide snap-x snap-mandatory px-2">
        <!-- Gradient fade edges -->
        {{-- <div class="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-white to-transparent z-10"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-white to-transparent z-10"></div> --}}

        <div class="flex gap-6 md:gap-8 pb-4 min-w-max px-4 pt-[10px]">

            <!-- Category Items with Enhanced Cards -->
            <!-- Bestsellers -->
            @if($categories)
            @foreach($categories->whereNull('parent_id') as $category)
            <a href="{{ route('category.show',$category->slug) }}" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
                    </div>
                    <div
                        class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-pink-100 transition-all duration-300">
                        <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                            alt="{{$category->name}}"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>

                </div>
                <span
                    class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-pink-700 transition-colors duration-300">{{$category->name}}</span>
                <span class="text-xs text-gray-500 mt-1">Most Loved</span>
            </a>
            @endforeach
            @endif
            <!-- Saree --> {{--
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
                    </div>
                    <div
                        class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-amber-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}"
            alt="Saree"
            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
        </div>
    </div>
    <span
        class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-amber-700 transition-colors duration-300">Saree</span>
    <span class="text-xs text-gray-500 mt-1">Elegant Drapes</span>
    </a>

    <!-- Salwar Kameez -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-emerald-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/cherry-plazo-6_4_11zon.webp') }}"
                    alt="Salwar Kameez"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
            </div>
        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-emerald-700 transition-colors duration-300">Salwar
            Kameez</span>
        <span class="text-xs text-gray-500 mt-1">Comfort & Style</span>
    </a>

    <!-- Lehenga -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-rose-400/20 to-pink-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-rose-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/cobalt-plazo-1_5_11zon.webp') }}" alt="Lehenga"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </div>

        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-rose-700 transition-colors duration-300">Lehenga</span>
        <span class="text-xs text-gray-500 mt-1">Festival Ready</span>
    </a>

    <!-- Indo Western -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-indigo-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/dark-red-plazo-4_14_11zon.webp') }}"
                    alt="Indo Western"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
            </div>
        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-indigo-700 transition-colors duration-300">Indo
            Western</span>
        <span class="text-xs text-gray-500 mt-1">Fusion Trends</span>
    </a>

    <!-- Blouses -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-purple-400/20 to-violet-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-purple-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/cherry-plazo-6_4_11zon.webp') }}" alt="Blouses"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
            </div>
        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-purple-700 transition-colors duration-300">Blouses</span>
        <span class="text-xs text-gray-500 mt-1">Statement Pieces</span>
    </a>

    <!-- Menswear -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-blue-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/glow-orange-2_17_11zon.webp') }}" alt="Menswear"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
            </div>
        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-blue-700 transition-colors duration-300">Menswear</span>
        <span class="text-xs text-gray-500 mt-1">Modern Ethnic</span>
    </a>

    <!-- Bridal Edit -->
    <a href="/" class="group flex flex-col items-center  snap-center">
        <div class="relative mb-2">
            <div
                class="absolute inset-0 bg-gradient-to-br from-amber-300/20 to-yellow-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500">
            </div>
            <div
                class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-amber-100 transition-all duration-300">
                <img src="{{ asset('web/images/product-images/purple-plazo-5_85_11zon.webp') }}"
                    alt="Bridal Edit"
                    class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
            </div>

        </div>
        <span
            class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-amber-700 transition-colors duration-300">Bridal
            Edit</span>
        <span class="text-xs text-gray-500 mt-1">Luxury Collection</span>
    </a>
    --}}
</div>
</div>


</div>



<!-- Required CSS for no scrollbar + smooth snap -->

<section class="px-4 lgg:py-8 py-6 h-auto bg-gradient-to-b from-gray-100 to-white">
    <div class="container mx-auto">
        <div class="flex flex-row gap-3 lg:gap-6 justify-between items-stretch h-auto">
            <!-- Left Image Column -->
            @php
            $leftCategories = $homeCategories['left'] ?? collect();
            @endphp
            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl">

                    @if ($leftCategories->count())
                    <a id="leftSliderLink" href="{{ url('collections/' . $leftCategories->first()?->slug) }}"
                        class="block h-full w-full relative">

                        @foreach ($leftCategories as $index => $cat)
                        <img class="slide-left absolute inset-0 object-cover h-full w-full transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ asset('uploads/category/' . $cat->image) }}" alt="{{ $cat->name }}"
                            data-link="{{ url('collections/' . $cat->slug) }}">
                        @endforeach

                    </a>
                    @else
                    {{-- <a id="leftSliderLink" href="{{ url('collections/lehengas') }}"
                    class="block h-full w-full relative"> --}}
                    <a id="leftSliderLink" href="{{ url('collections/lehanga') }}"
                        class="absolute inset-0 z-20 block">
                        <img class="slide-left absolute inset-0 object-cover h-full w-full transition-opacity duration-1000"
                            src="{{ asset('web/images/banner-images/glow-orange-2.webp') }}" alt="Store"> </a>
                    @endif

                    {{-- <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-105 transition-transform duration-700"
                        src="{{ asset('web/images/banner-images/glow-orange-2.webp') }}" alt="Light Pink Salwar" /> --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </div>
                <div
                    class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <a href="{{ url('collections/new-collection') }}"> <span
                            class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800">{{ $leftCategories->first()?->slug ?? 'New Collection' }}</span>
                    </a>
                </div>
            </div>

            <!-- Middle Content Column -->
            <div
                class="xl:min-w-[600px] lgg:min-w-[350px] min-w-[250px] md:w-auto w-full flex flex-col gap-3 lg:gap-6">
                <!-- Top Image -->
                @php
                $topCategories = $homeCategories['top'] ?? collect();
                @endphp
                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-[4px] shadow-lg">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-pink-500/10 to-purple-500/10 z-10 pointer-events-none">
                    </div>

                    @if ($topCategories->count())
                    <a id="topSliderLink" href="{{ url('collections/' . $topCategories->first()?->slug) }}"
                        class="block h-full w-full relative">
                        @foreach ($topCategories as $index => $cat)
                        <img data-link="{{ url('collections/' . $cat->slug) }}"
                            class="slide-top absolute inset-0 object-cover h-full w-full object-top object-center
                                transition-opacity duration-1000 transform group-hover:scale-110
                                {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ asset('uploads/category/' . $cat->image) }}" alt="{{ $cat->name }}">
                        @endforeach

                    </a>
                    @else
                    <!-- Default Image -->
                    <a href="{{ url('collections/' . 'lehanga') }}">
                        <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                            src="{{ asset('web/images/product-images/Poses In Frock Suit.jpg') }}"
                            alt="Glow Pink Dress">
                    </a>
                    @endif
                    {{-- <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('web/images/product-images/Poses In Frock Suit.jpg') }}" alt="Glow Pink Dress" /> --}}
                    <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                        <a href="{{ url('collections/new-collection') }}">
                            <span
                                class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">{{ $topCategories->first()?->slug ?? 'New Collection' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Center Banner -->
                <div
                    class="flex flex-col items-center justify-center space-y-4 p-6 lg:p-8 bg-gradient-to-br from-pink-100 via-white to-purple-100 rounded-[4px] shadow-2xl border border-gray-100 flex-grow relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div
                            class="absolute top-0 left-0 w-32 h-32 bg-pink-500 rounded-full -translate-x-16 -translate-y-16">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-40 h-40 bg-purple-500 rounded-full translate-x-20 translate-y-20">
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div
                        class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-transparent via-pink-500 to-transparent">
                    </div>

                    <h1
                        class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient">
                        ULTIMATE
                    </h1>

                    <div class="relative">
                        <span
                            class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-extrabold text-white relative z-10"
                            style="-webkit-text-stroke: 2px black; text-shadow: 3px 3px 0 rgba(0,0,0,0.1)">
                            SALE
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-pink-500 to-purple-500 blur-xl opacity-50 -z-10">
                        </div>
                    </div>

                    <p class="text-gray-600 font-medium tracking-wider text-lg uppercase">NEW COLLECTION</p>

                    <div class="text-center text-gray-500 mb-2">
                        <span class="line-through text-sm mr-2">₹199.99</span>
                        <span class="text-xl font-bold text-rose-600">₹99.99</span>
                    </div>

                    <button
                        class="px-8 py-3 lg:px-10 lg:py-4 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary rounded-full text-white text-[1.3rem] font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                        <span class="relative z-10">Shop Now →</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary to-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </button>

                    <p class="text-sm text-gray-500 mt-2">Limited Time Offer</p>
                </div>

                <!-- Bottom Image -->
                @php
                $bottomCategories = $homeCategories['bottom'] ?? collect();
                @endphp
                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-[4px] shadow-lg">
                    {{-- <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('web/images/product-images/Long Frock Poses Photo Ideas At Home.jpg') }}"
                    alt="Gray Lahenga" /> --}}
                    @if ($bottomCategories->count())
                    <a id="bottomSliderLink" href="{{ url('collections/' . $bottomCategories->first()?->slug) }}"
                        class="block h-full w-full relative">

                        @foreach ($bottomCategories as $index => $cat)
                        <img class="slide-bottom absolute inset-0 object-cover h-full w-full object-top object-center
                                            transition-opacity duration-1000 transform group-hover:scale-110
                                            {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            src="{{ asset('uploads/category/' . $cat->image) }}" alt="{{ $cat->name }}"
                            data-link="{{ url('collections/' . $cat->slug) }}">
                        @endforeach

                    </a>
                    @else
                    <!-- Default Image -->
                    <a href="{{ url('collections/' . 'lehanga') }}">
                        <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                            src="{{ asset('web/images/product-images/Long Frock Poses Photo Ideas At Home.jpg') }}"
                            alt="Gray Lahenga">
                    </a>
                    @endif
                    <div
                        class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                        <a href="{{ url('collections/new-collection') }}">
                            <span
                                class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800 shadow-lg">{{ $bottomCategories->first()?->slug ?? 'New Collection' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Image Column -->
            @php
            $rightCategories = $homeCategories['right'] ?? collect();
            @endphp
            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-[4px] shadow-xl">
                    {{-- <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-105 transition-transform duration-700"
                        src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Red Plazo" /> --}}
                    @if ($rightCategories->count())
                    <a id="rightSliderLink" href="{{ url('collections/' . $rightCategories->first()?->slug) }}"
                        class="absolute inset-0 z-20 block">

                        @foreach ($rightCategories as $index => $cat)
                        <img data-link="{{ url('collections/' . $cat->slug) }}"
                            class="slide-right absolute inset-0 w-full h-full object-cover
                               transition-opacity duration-1000
                               {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                            src="{{ asset('uploads/category/' . $cat->image) }}" alt="{{ $cat->name }}">
                        @endforeach

                    </a>
                    @else
                    <a id="rightSliderLink" href="{{ url('collections/lehanga') }}"
                        class="absolute inset-0 z-20 block">

                        <img class="object-cover h-full w-full"
                            src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Red Plazo">
                    </a>
                    @endif
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </div>
                <div
                    class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <a href="{{ url('collections/new-collection') }}"><span
                            class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800">{{ $rightCategories->first()?->slug ?? 'New Collection' }}</span>
                    </a>
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
                    Shop By Category
                </span>
            </h2>
            <p class="text-gray-600 max-w-xl mx-auto">
                Discover our curated collections
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
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />

                            <!-- Transparent Overlay Content - Shows on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">

                                <!-- Floating Badge -->
                                <div class="absolute top-6 left-6">
                                    <span class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Popular
                                        </span>
                                    </span>
                                </div>

                                <!-- Category Name -->
                                <h3 class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem]  font-bold text-white mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    Salwar Kameez
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-200 text-sm mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Traditional elegance with modern designs
                                </p>

                                <!-- Styles Count -->
                                <div class="flex items-center mb-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        120+ Designs
                                    </span>
                                </div>

                                <!-- Shop Now Button -->
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                    <span class="inline-flex items-center text-sm font-semibold text-white bg-white/20 px-5 py-2.5 rounded-full border border-white/30 hover:bg-white/30 transition-colors">
                                        Shop Now
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Minimal Content Visible Before Hover -->
                            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                <h3 class="text-2xl font-bold text-white mb-2">Salwar Kameez</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />

                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">

                                <div class="absolute top-6 left-6">
                                    <span class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                            </svg>
                                            Bridal
                                        </span>
                                    </span>
                                </div>

                                <h3 class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem]  font-bold text-white mb-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    Lehengas
                                </h3>

                                <p class="text-gray-200 text-sm mb-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Royal bridal collections
                                </p>

                                <div class="flex items-center mb-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        80+ Collections
                                    </span>
                                </div>

                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                    <span class="inline-flex items-center text-sm font-semibold text-white bg-white/20 px-5 py-2.5 rounded-full border border-white/30 hover:bg-white/30 transition-colors">
                                        Shop Now
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Minimal Content Before Hover -->
                            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                <h3 class="text-2xl font-bold text-white mb-2">Lehengas</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        80+ Collections
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Continue with similar structure for categories 3-6 -->
                <!-- ... -->

                @else
                <!-- Dynamic Categories -->
                @foreach ($categoriesWithProduct as $category)
                <div class="item p-2">
                    <a href="{{ route('category.show', $category->slug) }}" class="group block relative overflow-hidden rounded-[0px]">
                        <div class="relative  overflow-hidden rounded-[0px]">
                            <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                                alt="{{ $category->name }}"
                                class="w-full h-auto aspect-[9/13] object-cover group-hover:scale-110 transition-transform duration-700" />

                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">

                                <div class="absolute top-6 left-6">
                                    <span class="bg-gradient-to-r from-gray-800 to-black block text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg transform -rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                            </svg>
                                            Collection
                                        </span>
                                    </span>
                                </div>

                                <h3 class="smui:text-3xl text-[1.5rem] smui:leading-[2.25rem] leading-[1.6rem]  font-bold text-white mb-3 transform translate-y-4  group-hover:translate-y-0 transition-transform duration-500">
                                    {{ $category->name }}
                                </h3>

                                <p class="text-gray-200 text-sm lgg:mb-4 mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                    Explore our exclusive collection
                                </p>

                                <div class="flex items-center lgg:mb-6 mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150">
                                    <span class="flex items-center text-sm font-medium text-white bg-white/20 px-4 py-2 rounded-full border border-white/30">
                                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        100+ Styles
                                    </span>
                                </div>

                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                    <span class="inline-flex items-center text-sm font-semibold text-white bg-white/20 px-5 py-2.5 rounded-full border border-white/30 hover:bg-white/30 transition-colors">
                                        Shop Now
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Minimal Content Before Hover -->
                            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                <h3 class="text-2xl font-bold text-white mb-2">{{ $category->name }}</h3>
                                <div class="flex items-center">
                                    <span class="flex items-center text-sm text-white/90">
                                        <svg class="w-4 h-4 text-yellow-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
            <div class="custom-nav hidden lg:flex absolute top-1/2 -translate-y-1/2 left-0 right-0 justify-between px-2 pointer-events-none z-[1]">
                <button class="owl-prev bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="owl-next bg-white hover:bg-gray-50 text-gray-800 w-12 h-12 rounded-full shadow-lg flex items-center justify-center pointer-events-auto hover:shadow-xl transition-all">
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
                <svg class="w-5 h-5 transform hover:translate-x-1 transition-transform"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>


<section class="px-4 lgg:py-8 py-6 bg-gradient-to-t from-white to-gray-50/50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Tied with Love</h2>
            <p class="text-gray-500">Occasions wrapped perfectly</p>
        </div>


        <!-- Hanging Tags -->
        <div class="flex  lgg:justify-center justify-start items-start gap-5 md:gap-7 py-3 overflow-x-auto scrollbar-hide snap-x snap-mandatory">

            @foreach ($categoriesWithProduct->where('parent_id', null) as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="group relative mt-8">
                <!-- String/Hanger -->
                <div class="absolute -top-8 left-1/2 w-px h-8 bg-primary transform -translate-x-1/2"></div>
                <div class="absolute -top-10 left-1/2 w-3 h-3 rounded-full bg-primary transform -translate-x-1/2"></div>

                <!-- Tag -->
                <div class="relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden w-40">

                    <!-- Tag Hole -->
                    <div class="absolute hidden top-3 left-1/2 w-4 h-4 rounded-full bg-amber-100 border-2 border-white transform -translate-x-1/2 z-10"></div>

                    <!-- Image -->
                    <div class="h-32 overflow-hidden">
                        <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 object-top" />
                    </div>

                    <!-- Content -->
                    <div class="p-3 text-center">
                        <h3 class="font-medium text-gray-800 text-sm mb-1">{{ $category->name }}</h3>
                        <span class="inline-block px-2 py-0.5 bg-rose-100 text-rose-600 text-xs rounded-full">
                            {{ $category->products_count }} items
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>


<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <!-- Left Title -->
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Trending Best Selling Products
            </h2>

            <!-- Center Navigation -->

            <!-- Right Link -->
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
                        <img src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($product->discount == 0)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                                Trending
                            </span>
                            @else
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                {{ $product->discount }}% OFF
                            </span>
                            @endif
                        </div>

                        <!-- Wishlist Heart Icon (Top Right) -->
                        {{-- <button
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                            onclick="toggleHomeWishlist({{ $product->id }}, event)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
                            id="wishlist-heart-{{ $product->id }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        </button> --}}
                        @if(Auth::check())
                        <button

                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                            onclick="toggleWishlist({{ $product->id }}, this,event);">
                            <i class="far fa-heart"></i>
                        </button>
                        @else
                        <a href="{{ route('page.login') }}">

                            <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center">
                                <i class="far fa-heart"></i>
                            </button>
                        </a>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900">
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
    <div class="container mx-auto lgg:py-12 lgg:px-12 py-12  px-4 relative rounded-[10px] overflow-hidden">
        <span class="absolute z-[1] top-[8px] right-[30px] text-secondary/30 text-[100px]">%</span>
        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 via-white to-pink-100 z-[-1]"></div>
        <div class="grid lgg:grid-cols-3 lgg:gap-4 gap-8 xl:gap-16 items-center">

            <!-- Left - Guarantee Info -->
            <div class="">

                <div class="lgg:text-left text-center">
                    <div class="mb-6 ">
                        <h3 class="text-2xl md:text-5xl font-bold text-gray-900">Best Price Guarantee</h3>


                    </div>


                    <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-8 max-w-lg lgg:mx-0 mx-auto">
                        We guarantee the lowest prices on premium fashion. If you find it cheaper elsewhere within 30
                        days, we'll match or beat it.
                    </p>

                </div>


                <ul class=" text-gray-700 flex flex-col gap-3 lgg:items-start items-center justify-center">
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Price match within 30 days
                    </li>
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Always the lowest price guaranteed
                    </li>
                    <li class="flex items-center">
                        <div
                            class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        24/7 friendly support
                    </li>
                </ul>
            </div>

            <!-- Center - Geometric Product Mosaic -->
            <div class="relative">
                <!-- Main Geometric Container -->
                <div class="relative w-full max-w-md mx-auto">

                    <!-- Diamond Pattern Background -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <div class="w-64 h-64 border-2 border-secondary/30 rotate-45 rounded-3xl"></div>
                    </div>

                    <!-- Product 1 - Large & Centered (Parallelogram Shape) -->


                    <!-- Product 2 - Top Right (Rhombus Shape) -->
                    <div
                        class="absolute top-0 right-8 w-36 h-36 transform rotate-12 hover:-rotate-6 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary/10 to-pink-500/10 rounded-xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}"
                            alt="Saree Collection"
                            class="w-full h-full object-cover object-top  rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300">
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
                            class="w-full h-full object-cover object-top rounded-2xl shadow-xl border-4 border-white group-hover:border-secondary transition-all duration-300">
                        <div
                            class="absolute -top-3 -right-3 bg-secondary text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-6">
                            -25%
                        </div>
                    </div>

                    <!-- Product 3 - Bottom Left (Tilted Square) -->
                    <div
                        class="absolute bottom-8 left-4 w-40 h-40 transform -rotate-12 hover:rotate-3 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tl from-secondary/10 to-pink-600/10 rounded-xl">
                        </div>
                        <img src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}"
                            alt="Party Wear"
                            class="w-full h-full object-cover object-top  rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300">
                        <div
                            class="absolute -top-2 -right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            New
                        </div>
                    </div>

                    <!-- Product 4 - Bottom Right (Circle) -->
                    <div
                        class="absolute bottom-4 right-0 w-32 h-32 rounded-full overflow-hidden border-4 border-white hover:border-secondary transition-all duration-300 cursor-pointer group z-10 shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary/10 to-pink-600/10"></div>
                        <img src="{{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}"
                            alt="Kurta Set"
                            class="w-full h-full object-cover object-top  group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-secondary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-sm font-bold">View</span>
                        </div>
                    </div>

                    <!-- Connecting Lines -->
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
                                    alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                    alt="" class="w-full h-full object-cover">
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
                    class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl  font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient mb-4">
                    Exclusive Deals Just for You</h3>
                <button
                    class="w-full sm:w-auto relative p-[16px_34px] bg-gradient-to-r from-secondary to-pink-500 hover:from-secondary hover:to-primary text-white font-bold text-xl rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-secondary/20">
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i>
                    Shop Deals Now
                </button>




            </div>

        </div>
    </div>
</section>
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div id="ads-carousel" class="owl-carousel owl-theme">
            @foreach ($mainBanners as $banner)
            <div class="relative overflow-hidden rounded-[0px] shadow-lg bg-cover bg-center h-96 group banner-card"
                @if($banner->filter_type === 'multiple' && $banner->filters)
                data-filter="{{ $banner->filters }}"
                @else
                data-filter="{{ $banner->filter ?? $banner->discount ?? '' }}"
                @endif>
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top transition-transform duration-700 group-hover:scale-110"
                        src="{{ asset('uploads/banners/' . $banner->image) }}"
                        alt="{{ $banner->title }}" />
                </div>
                <!-- Blackish overlay that appears on hover -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <!-- Content that slides up from bottom -->
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/70 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out">
                    <div class="relative flex flex-col justify-end md:p-8 p-4 h-full text-white">
                        @if($banner->subtitle)
                        <span class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <span class="text-[2.7rem] font-bold font-serif uppercase tracking-wider lgg:mb-4 mb-2">
                            {{ $banner->title }}
                        </span>
                        @if($banner->description)
                        <p class="lgg:text-3xl text-[1.2rem] font-serif lgg:mb-6 mb-3">
                            {{ $banner->description }}
                        </p>
                        @endif
                        <a href="#"
                            class="inline-block w-fit text-center bg-black text-white lgg:px-8 px-4 py-2 lgg:text-md text-sm font-sans rounded-full uppercase tracking-wide hover:bg-gray-600 transition-all duration-300 ease-in-out">{{ $banner->button_text }}</a>
                        @if($banner->discount)
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
                <!-- Title -->
                <h2
                    class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold text-gray-800">
                    Deals Of The Month
                </h2>

                <!-- Description -->
                <p
                    class="mt-4 text-gray-500 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Scelerisque duis ultrices sollicitudin aliquam sem. Scelerisque
                    duis ultrices sollicitudin
                </p>

                <!-- Button -->
                <button class="mt-6 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-900 transition">
                    Buy Now
                </button>

                <!-- Countdown Title -->
                <h4
                    class="mt-10 text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg lgg:text-h4-lgg xl:text-h4-xl 2xl:text-h4-2xl font-semibold text-gray-800">
                    Hurry, Before It’s Too Late!
                </h4>

                <!-- Countdown -->
                <div class="mt-6 flex gap-4 flex-wrap lgg:justify-start justify-center">
                    <!-- Box -->
                    <div class="text-center">
                        <div
                            class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold">
                            02
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Days</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold">
                            06
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Hr</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold">
                            05
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Mins</p>
                    </div>

                    <div class="text-center">
                        <div
                            class="digital-font p-4 flex items-center justify-center bg-white shadow-md rounded-lg text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold">
                            30
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Sec</p>
                    </div>
                </div>
            </div>
            <div class="w-full lgg:w-[59%] flex justify-center items-center">
                <div class="second-owl owl-carousel owl-theme relative">
                    @foreach ($secondaryBanners as $banner)
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow cursor-pointer banner-card"
                            @if($banner->filter_type === 'multiple' && $banner->filters)
                            data-filter="{{ $banner->filters }}"
                            @else
                            data-filter="{{ $banner->filter ?? $banner->discount ?? '' }}"
                            @endif>
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                    alt="{{ $banner->title }}"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: subtitle — title -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">{{ $banner->subtitle }}</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">{{ $banner->title }}</span>
                                    </div>

                                    <!-- Big discount text -->
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

{{--
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <!-- Left Title -->
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Filled By Colour
            </h2>

            <!-- Center Navigation -->

            <!-- Right Link -->
            <a href="{{ route('page.multi-product') }}"
class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
All Products
<span aria-hidden="true">→</span>
</a>
</div>

<div class="main-owl owl-carousel owl-theme">

    @foreach ($products as $product)
    <div class="item flex justify-center items-center">
        <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-[6px] shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card"
            data-product-id="{{ $product->id }}">
            <!-- Image Wrapper -->
            <div class="relative rounded-[6px] overflow-hidden">
                <img src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                    @if ($product->is_trending ?? false)
                    <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                        Trending
                    </span>
                    @endif
                    @if ($product->price_after_discount && $product->price_after_discount != $product->price)
                    <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                        -{{ round((($product->price - $product->price_after_discount) / $product->price) * 100) }}%
                    </span>
                    @endif
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                    class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                    onclick="toggleHomeWishlist({{ $product->id }}, event)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
                        id="wishlist-heart-{{ $product->id }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                    class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                    <button onclick="addToCart(1, event)"
                        class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                        Add To Cart
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 space-y-1">
                <h3 class="text-[15px] font-semibold text-gray-900">
                    {{ $product->name }}, {{ $product->size }}, {{ $product->color }}
                </h3>

                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span>{{ $product->brand ?? 'Brand Name' }}</span>
                    <span class="flex items-center gap-1 text-gray-700">
                        <span class="text-sm font-medium">{{ $product->rating ?? '4.4' }}</span>
                    </span>
                </div>

                <div class="flex items-center gap-2 mt-2 flex-wrap">
                    <span class="text-lg font-bold text-gray-900">Rs.
                        {{ $product->price_after_discount }}</span>
                    @if ($product->price_after_discount != $product->price)
                    <span class="text-sm text-gray-400 line-through">Rs. {{ $product->price }}</span>
                    @endif
                </div>
                <div class="lgg:hidden block">
                    <button onclick="addToCart({{ $product->variant_id }}, event)"
                        class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Add more product items as needed -->
</div>
</div>
</section>
--}}
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-gray-800">
            <!-- Item 1 -->
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon1.svg') }}"
                    alt="" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">
                        High Quality
                    </h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">
                        crafted from top materials
                    </p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon2.svg') }}"
                    alt="" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">
                        Warranty Protection
                    </h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">
                        Over 2 years
                    </p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon4.svg') }}"
                    alt="" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">
                        Free Shipping
                    </h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">
                        Order over 150 $
                    </p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img class="min-w-12 w-12 h-12 min-h-12" src="{{ asset('web/images/icons/icon3.svg') }}"
                    alt="" />
                <div>
                    <h3 class="font-semibold xl:text-[1.5rem] text-[1.3rem]">
                        24 / 7 Support
                    </h3>
                    <p class="xl:text-[1.3rem] text-[1.1rem] text-gray-500">
                        Dedicated support
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{--
<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">

            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Filled By Categories
            </h2>


            <a href="#"
                class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
                All Products
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @foreach ($categories as $category)
            <div class="item flex justify-center items-center">
                <a href="{{ route('category.show', $category->slug) }}">
<div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-[6px] shadow-sm hover:shadow-md transition-shadow cursor-pointer category-card"
    data-category-id="{{ $category->id }}">
    <!-- Image Wrapper -->
    <div class="relative rounded-[6px] overflow-hidden">
        <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
            alt="{{ $category->name }}"
            class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

        <!-- Category Badge -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if ($category->products_count ?? false)
            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                {{ $category->products_count }} Products
            </span>
            @endif
            @if ($category->is_active)
            <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">
                Active
            </span>
            @endif
        </div>

        <!-- View Products Button (Top Right) -->
        <button
            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-blue-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>

        <!-- View Category (Hidden → Hover Show) -->
        <div
            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
            <a href="{{ route('category.show', $category->slug) }}"
                class="block bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors text-center">
                View Category
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 space-y-1">
        <h3 class="text-[15px] font-semibold text-gray-900">
            {{ $category->name }}
        </h3>

        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>{{ $category->description ? Str::limit($category->description, 50) : 'Browse our collection' }}</span>
        </div>

        <div class="flex items-center gap-2 mt-2 flex-wrap">
            @if ($category->products_count)
            <span class="text-lg font-bold text-gray-900">{{ $category->products_count }}
                Items</span>
            @else
            <span class="text-lg font-bold text-gray-900">Browse Collection</span>
            @endif
        </div>
        <div class="lgg:hidden block">
            <a href="{{ route('category.show', $category->slug) }}"
                class="block px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full text-center">
                View
            </a>
        </div>
    </div>
</div>
</a>
</div>
@endforeach
</div>
</div>
</section>
--}}

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Editor's Pick
            </h2>
        </div>
        <div class="grid-container">
            @php
            $editorBanners = \App\Models\Banner::active()->where('type', 'editor')->ordered()->get();
            @endphp
            <!-- Owl Carousel for mobile/tablet -->
            <div class="owl-carousel banner-carousel lgg:hidden">
                @foreach($editorBanners as $banner)
                <!-- Slide -->
                <div class="relative bg-[#b8a89a] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]"
                     @if($banner->filter_type === 'multiple' && $banner->filters)
                        data-filter="{{ $banner->filters }}"
                    @else
                        data-filter="{{ $banner->filter ?? $banner->discount ?? '' }}"
                    @endif>
                    <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}"
                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        @if($banner->subtitle)
                            <span class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>

                        @if($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif

                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? $banner->discount ?? '') : '#' }}"
                           class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Original grid layout for desktop -->
            <div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[600px] min-h-[500px] h-[50vh]">
                @foreach($editorBanners as $index => $banner)
                    @if($index % 2 == 0)
                        <!-- Left Banner -->
                        <div class="relative bg-[#b8a89a] overflow-hidden"
                             @if($banner->filter_type === 'multiple' && $banner->filters)
                                data-filter="{{ $banner->filters }}"
                            @else
                                data-filter="{{ $banner->filter ?? $banner->discount ?? '' }}"
                            @endif>
                            <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}"
                                class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                            <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                                @if($banner->subtitle)
                                    <span class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                                @endif
                                <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                                    {{ $banner->title }}
                                </h2>
                                @if($banner->description)
                                <p class="text-sm text-black mb-6">
                                    Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                                    <span class="text-white font-medium">{{ $banner->discount }}</span>
                                </p>
                                @endif
                                <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? $banner->discount ?? '') : '#' }}"
                                   class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                                    {{ $banner->button_text }}
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach

                @foreach($editorBanners as $index => $banner)
                    @if($index % 2 == 1)
                        <!-- Right Banner -->
                        <div class="relative bg-[#e8dcd6] overflow-hidden"
                             @if($banner->filter_type === 'multiple' && $banner->filters)
                                data-filter="{{ $banner->filters }}"
                            @else
                                data-filter="{{ $banner->filter ?? $banner->discount ?? '' }}"
                            @endif>
                            <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}"
                                class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                            <div class="relative z-10 flex flex-col justify-center h-full p-10">
                                @if($banner->subtitle)
                                    <span class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                                @endif
                                <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                                    {{ $banner->title }}
                                </h2>
                                @if($banner->description)
                                <p class="text-sm text-black mb-6">
                                    Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                                    <span class="text-white font-medium">{{ $banner->discount }}</span>
                                </p>
                                @endif
                                <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? $banner->discount ?? '') : '#' }}"
                                   class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                                    {{ $banner->button_text }}
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
</section>

<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Most Wishlisted Styles
            </h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @forelse($mostWishlisted as $index => $product)
            @php
            $variant = $product->variants->first();
            @endphp



            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-[6px] overflow-hidden">

                        <a href="{{route('category.show', $product->category->slug)}}">
                            <img src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/images/placeholder.jpg') }}"
                                alt="Silver Lehenga" class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />
                            {{--<img src="{{ asset($product->images->first()->image) }}"
                            alt="Silver Lehenga" class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />--}}
                        </a>

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            {{-- @dd($product->variants->first()->discount) --}}
                            @if(optional($product->variants->first())->discount == 0)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                                Trending
                            </span>
                            @else
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                {{ optional($product->variants->first())->discount }}% OFF
                            </span>
                            @endif
                        </div>

                        <!-- Wishlist Heart Icon (Top Right) -->
                        {{-- <button
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                            onclick="toggleHomeWishlist(1, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
                                id="wishlist-heart-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button> --}}

                        <!-- Add To Cart (Hidden → Hover Show) -->
                        @php
                        $variant_id = optional($variant)->id ?? $variant?->first()->id;
                        @endphp
                        <div
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">


                            <a href="{{route('page.single-product', $product->slug)}}">
                                <button class="add-to-cart-btn bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                                    View
                                </button>
                            </a>

                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900">
                            {{$product->name ?? ''}}
                        </h3>

                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>{{$product->brand ?? ''}}</span>
                            <span class="flex items-center gap-1 text-gray-700">
                                <span class="text-sm font-medium">4.4</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="text-lg font-bold text-gray-900">Rs. {{$variant->discount_price ?? $product->price}}</span>
                            @if($variant != null )
                            <span class="text-sm text-gray-400 line-through">Rs. {{$variant->price ?? $product->price}}</span>
                            @endif
                        </div>
                        <div class="lgg:hidden block">

                            {{-- <button onclick="addToCart({{$variant_id}}, event)"
                            class="add-to-cart-btn px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button> --}}
                            <a href="{{route('category.show', $product->category->slug)}}">
                                <button
                                    class="add-to-cart-btn px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">View</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="item flex justify-center items-center">
                <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-[6px] overflow-hidden">
                        <img src="{{ asset('web/images/product-images/light-pink-plazo-2_54_11zon.webp') }}"
            alt="Silver Lehenga" class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                    Trending
                </span>
                <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                    -17%
                </span>
            </div>

            <!-- Wishlist Heart Icon (Top Right) -->
            <button
                class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
                onclick="toggleHomeWishlist(1, event)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
                    id="wishlist-heart-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>

            <!-- Add To Cart (Hidden → Hover Show) -->
            <div
                class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                <button onclick="addToCart(1, event)"
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                    Add To Cart
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 space-y-1">
            <h3 class="text-[15px] font-semibold text-gray-900">
                Light Pink Plazo
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
            <div class="lgg:hidden block">
                <button onclick="addToCart(1, event)"
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button>
            </div>
        </div>
    </div>
    </div> --}}
    {{-- <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-[6px] overflow-hidden">
                        <img src="{{ asset('web/images/product-images/cherry-plazo-3_1_11zon.webp') }}"
    alt="Silver Lehenga" class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

    <!-- Badges -->
    <div class="absolute top-3 left-3 flex flex-col gap-2">

        @if($product->wishlists_count > 0)
        <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
            Trending
        </span>
        @endif
        @if($product->discount_price && $product->discount_price < $product->price)
            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
            </span>
            @endif
    </div>

    <!-- Wishlist Heart Icon (Top Right) -->
    <button
        class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
        onclick="toggleHomeWishlist(1, event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
            id="wishlist-heart-1">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>

    <!-- Add To Cart (Hidden → Hover Show) -->
    {{-- <div class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart({{ $product->id }}, event)"
    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
    Add To Cart
    </button>
    </div> --}}
    {{-- </div> --}}

    <!-- Content -->
    {{-- <div class="p-4 space-y-1">
                    <h3 class="text-[15px] font-semibold text-gray-900">
                        {{ $product->name }}
    </h3>

    <div class="flex items-center gap-2 text-sm text-gray-600">
        <span>{{ $product->brand_name ?? 'Brand Name' }}</span>
        <span class="flex items-center gap-1 text-gray-700">
            <span class="text-sm font-medium">{{ $product->rating ?? '4.4' }}</span>
        </span>
    </div>

    <div class="flex items-center gap-2 mt-2 flex-wrap">
        <span class="text-lg font-bold text-gray-900">Rs. 700</span>
        <span class="text-sm text-gray-400 line-through">Rs. 1000</span>
    </div>
    <div class="lgg:hidden block">
        <button onclick="addToCart(1, event)"
            class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button>
    </div>
    </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div class="item flex justify-center items-center">
            <div
                class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <!-- Image Wrapper -->
                <div class="relative rounded-[6px] overflow-hidden">
                    <img src="{{ asset('web/images/product-images/dark-red-plazo-3_13_11zon.webp') }}"
    alt="Silver Lehenga" class="w-full h-auto aspect-[9/13] object-cover object-top object-center" />

    <!-- Badges -->
    <div class="absolute top-3 left-3 flex flex-col gap-2">
        <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
            Trending
        </span>
        <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
            -17%
        </span>
    </div>

    <!-- Wishlist Heart Icon (Top Right) -->
    <button
        class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 w-[35px] h-[35px] flex justify-center items-center"
        onclick="toggleHomeWishlist(1, event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500"
            id="wishlist-heart-1">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>

    <!-- Add To Cart (Hidden → Hover Show) -->
    <div
        class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
        <button onclick="addToCart(1, event)"
            class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
            Add To Cart
        </button>
    </div>
    </div>

    <!-- Content -->
    <div class="p-4 space-y-1">
        <h3 class="text-[15px] font-semibold text-gray-900">
            Cherry Plazo
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
        <div class="lgg:hidden block">
            <button onclick="addToCart(1, event)"
                class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button>
        </div>
    </div>
    </div>
    </div> --}}
    @empty
    <div class="text-center py-8">
        <p class="text-gray-500">No wishlisted products found.</p>
    </div>
    @endforelse

    <!-- Add more product items as needed -->
    </div>
    </div>
</section>

<!-- Combined Premium Services Card -->
<section class="py-16 lg:py-20 px-4 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h2
                class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-rose-700 via-pink-600 to-purple-600 bg-clip-text text-transparent mb-4">
                Premium Personal Services
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Choose your preferred way to experience luxury fashion with our experts
            </p>
        </div>

        <!-- Main Horizontal Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-rose-50 via-white to-pink-50"></div>
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-rose-200 to-transparent rounded-full -translate-x-32 -translate-y-32">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-pink-200 to-transparent rounded-full translate-x-48 translate-y-48">
                </div>
            </div>



            <!-- Main Content -->
            <div class="relative py-12 lg:py-16 px-6 lg:px-12">
                <div class="flex lg:flex-row flex-col  gap-12 lg:gap-16">
                    <!-- Left Service - Virtual Styling -->
                    <div
                        class="group relative bg-gradient-to-br from-white to-rose-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-rose-100">
                        <!-- Service Badge -->
                        <div class="absolute -top-3 w-full flex justify-center items-center left-0">
                            <span
                                class="bg-gradient-to-r from-rose-500 to-pink-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                FREE SERVICE
                            </span>
                        </div>

                        <!-- Service Icon -->
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
                                Virtual Styling Session
                            </h3>
                        </div>

                        <!-- Service Description -->
                        <p class="text-gray-600 text-center mb-8 leading-relaxed">
                            Connect with our expert stylists via video call for personalized fashion advice and virtual
                            try-ons from the comfort of your home.
                        </p>

                        <!-- Features -->
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
                                <span>Personalized styling advice</span>
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
                                <span>Virtual outfit try-ons</span>
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
                                <span>Live Q&A with fashion experts</span>
                            </li>
                        </ul>

                        <!-- Button -->
                        <div class="text-center">
                            <a href="{{ route('page.appointment') }}"
                                class="group inline-flex items-center justify-center gap-3 w-full px-8 py-4 bg-gradient-to-r from-rose-600 to-pink-600 text-white font-semibold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                                <svg class="w-5 h-5 sm:block hidden transform group-hover:scale-110 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span class="text-lg">Book Video Appointment</span>
                            </a>
                        </div>
                    </div>

                    <!-- Center Divider -->
                    <div class="hidden lg:flex flex-col items-center justify-center relative">
                        <div class="absolute inset-0 flex items-center justify-center w-[5px]">
                            <div class="w-[3px] h-full bg-gradient-to-b from-transparent via-rose-200 to-transparent">
                            </div>
                        </div>


                    </div>

                    <!-- Right Service - Bridal Stylist -->
                    <div
                        class="group relative bg-gradient-to-br from-white to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-pink-100">
                        <!-- Service Badge -->
                        <div class="absolute -top-3 w-full flex justify-center items-center left-0">
                            <span
                                class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                PREMIUM SERVICE
                            </span>
                        </div>

                        <!-- Service Icon -->
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
                                Bridal Stylist Service
                            </h3>
                        </div>

                        <!-- Service Description -->
                        <p class="text-gray-600 text-center mb-8 leading-relaxed">
                            Your personal bridal expert guiding you through every step to find the perfect wedding dress
                            and complete bridal look.
                        </p>

                        <!-- Features -->
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
                                <span>One-on-one bridal consultation</span>
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
                                <span>Complete wedding look planning</span>
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
                                <span>Accessory & jewelry coordination</span>
                            </li>
                        </ul>

                        <!-- Button -->
                        <div class="text-center">
                            <a href="{{ route('page.appointment') }}"
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
            <!-- Enhanced Designer Thoughts Card -->
            <div
                class="bg-gradient-to-br from-white to-red-50 rounded-2xl shadow-2xl max-w-2xl w-full p-8 md:p-6 relative overflow-hidden border border-red-100">

                <!-- Top Banner -->
                <div class="flex justify-center items-center">
                    <div
                        class="w-auto flex sm:flex-row flex-col  bg-gradient-to-r from-primary  to-secondary text-white text-sm font-bold px-8 py-3 rounded-full shadow-lg   items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:block hidden" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                clip-rule="evenodd" />
                        </svg>
                        DESIGNER'S PERSPECTIVE
                    </div>
                </div>

                <!-- Brand Logo Watermark -->
                <div class="absolute top-4 right-4 opacity-10 md:block hidden">
                    <div class="text-6xl font-serif font-bold text-secondary">AF</div>
                </div>

                <!-- Owl Carousel Container -->
                <div id="designer-thoughts" class="owl-carousel owl-theme mt-8">

                    <!-- Slide 1 -->
                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Elevating Lahenga
                            Elegance</h3>
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
                                "At Aiman Fashion, we believe every lahenga tells a story. Our designs blend traditional
                                craftsmanship with contemporary silhouettes, creating pieces that honor heritage while
                                embracing modern elegance."
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

                    <!-- Slide 2 -->
                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Modern Salwar Kameez
                        </h3>
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
                                "Our salwar kameez collection redefines comfort with style. We focus on flattering cuts
                                and breathable fabrics that celebrate the feminine form while ensuring maximum comfort."
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

                    <!-- Slide 3 -->
                    <div class="slide-item">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">The Palazzo
                            Revolution</h3>
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
                                "Palazzos are our canvas for innovation. We experiment with fabrics and draping
                                techniques to create pieces that are both trendy and timeless for the modern woman on
                                the go."
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

                <!-- Custom Navigation -->
                <div
                    class="flex  md:justify-between justify-center md:absolute w-full md:left-0 md:bottom-[20%] px-[37px] md:z-[10] gap-4 mt-8 thoughts-nav">
                    <button
                        class="custom-prev-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        class="custom-next-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Decorative Bottom Border -->
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
    // Wishlist functionality
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

        // Check if already in wishlist by checking if it's an SVG (empty) or FontAwesome (filled)
        const isSVG = heartIcon.tagName === 'svg';
        const isInWishlist = isSVG ? false : heartIcon.classList.contains('fas');
        const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';

        console.log('Is SVG element:', isSVG);
        console.log('Current wishlist state:', isInWishlist);
        console.log('Calling URL:', url);

        // Show loading state
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
                console.log('Parsed data:', data);
                if (data.success) {
                    showNotification(data.message, 'success');

                    // Update heart icon using innerHTML like single-product
                    if (isInWishlist) {
                        // Was in wishlist, now removed
                        heartIcon.innerHTML = '<i class="far fa-heart text-red-500"></i>';
                    } else {
                        // Was not in wishlist, now added
                        heartIcon.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
                    }

                    // Update wishlist count if you have a counter
                    if (data.wishlist_count !== undefined) {
                        updateWishlistCount(data.wishlist_count);
                    }
                } else {
                    // Handle case where product is already in wishlist
                    if (data.message && data.message.includes('already in wishlist')) {
                        showNotification('Product is already in wishlist!', 'info');
                        // Don't change the heart icon if already in wishlist
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
                // Restore original content if error occurred
                if (heartIcon.innerHTML.includes('fa-spinner')) {
                    heartIcon.innerHTML = originalContent;
                }
            });
    }

    // Check if product is in wishlist
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

    // Update wishlist count (if you have a counter)
    function updateWishlistCount(count) {
        const wishlistCounter = document.getElementById('wishlist-counter');
        if (wishlistCounter) {
            wishlistCounter.textContent = count;
        }
    }

    // function addToCart(variantId, event) {
    //     // Show loading state
    //     console.log('Adding to cart, variantId:', variantId);
    //     const button = event.target;
    //     const originalText = button.textContent;
    //     button.textContent = 'Adding...';
    //     button.disabled = true;

    //     // Create form data
    //     const formData = new FormData();
    //     formData.append('variant_id', variantId);
    //     formData.append('count', 1);
    //     console.log(formData);
    //     // Get CSRF token
    //     const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    //     // Send AJAX request
    //     fetch('/cart/add', {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': token,
    //                 'Accept': 'application/json'
    //             },
    //             body: formData
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log(data)
    //             if (data.success) {
    //                 button.textContent = 'Added';
    //                 button.disabled = true;

    //                 // Optional styling change
    //                 button.classList.remove('bg-white');
    //                 button.classList.add('bg-green-600', 'text-white');

    //                 showNotification(data.message, 'success');
    //                 updateCartCount(data.cart_count);
    //                 blastCelebration(button);
    //             } else {
    //                  button.textContent = originalText;
    //                  button.disabled = false;
    //                 showNotification(data.message, 'error');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             showNotification('An error occurred while adding to cart', 'error');
    //         });
    //         // .finally(() => {
    //         //     button.textContent = originalText;
    //         //     button.disabled = false;
    //         // });
    // }

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

        // Only run when section is visible
        if (rect.bottom > 0 && rect.top < windowHeight) {
            const scrollProgress = rect.top / windowHeight;
            const movement = scrollProgress * -500; // adjust strength here

            bg.style.transform = `translateY(${movement}px) scale(1.2)`;
        }
    }

    window.addEventListener("scroll", updateParallax);
    window.addEventListener("resize", updateParallax);
    updateParallax();
</script>
<script>
    function autoSlider(className, linkId, interval = 3000) {
        const slides = document.querySelectorAll('.' + className);
        const link = document.getElementById(linkId);

        if (slides.length <= 1) return;

        let index = 0;

        setInterval(() => {
            slides[index].classList.replace('opacity-100', 'opacity-0');
            slides[index].classList.replace('z-10', 'z-0');

            index = (index + 1) % slides.length;

            slides[index].classList.replace('opacity-0', 'opacity-100');
            slides[index].classList.replace('z-0', 'z-10');

            // UPDATE LINK
            link.href = slides[index].dataset.link;

        }, interval);
    }

    document.addEventListener('DOMContentLoaded', function() {
        autoSlider('slide-left', 'leftSliderLink', 4000);
        autoSlider('slide-top', 'topSliderLink', 3500);
        autoSlider('slide-right', 'rightSliderLink', 4500);
        autoSlider('slide-bottom', 'bottomSliderLink', 4500);

        // Banner click handler for filtering and discount
        document.querySelectorAll('.banner-card').forEach(function(banner) {
            banner.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                console.log('Banner filter clicked:', filter);
                if (filter) {
                    try {
                        // Try to parse as JSON for multiple filters
                        const filterData = JSON.parse(filter);
                        console.log('Parsed filter data:', filterData);

                        // For multiple filters, create proper query parameters
                        if (Array.isArray(filterData)) {
                            const queryParams = new URLSearchParams();
                            filterData.forEach(f => {
                                queryParams.append(`banner_${f.type}`, f.value);
                            });
                            // Redirect to products page with banner filters
                            window.location.href = '/products?' + queryParams.toString();
                        } else {
                            // Single filter case
                            window.location.href = '/products?filter=' + encodeURIComponent(filter);
                        }
                    } catch (e) {
                        // Not JSON, treat as simple string
                        console.log('Using simple filter:', filter);
                        window.location.href = '/products?filter=' + encodeURIComponent(filter);
                    }
                }
            });
        });
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

        // Show loading
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
</script>

@endsection