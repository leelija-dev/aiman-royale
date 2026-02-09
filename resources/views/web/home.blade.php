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
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-pink-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/glow-orange-2_17_11zon.webp') }}"
                            alt="Bestsellers"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>

                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-pink-700 transition-colors duration-300">Bestsellers</span>
                <span class="text-xs text-gray-500 mt-1">Most Loved</span>
            </a>

            <!-- Saree -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-amber-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}"
                            alt="Saree"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-amber-700 transition-colors duration-300">Saree</span>
                <span class="text-xs text-gray-500 mt-1">Elegant Drapes</span>
            </a>

            <!-- Salwar Kameez -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-emerald-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/cherry-plazo-6_4_11zon.webp') }}"
                            alt="Salwar Kameez"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-emerald-700 transition-colors duration-300">Salwar Kameez</span>
                <span class="text-xs text-gray-500 mt-1">Comfort & Style</span>
            </a>

            <!-- Lehenga -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-400/20 to-pink-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-rose-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/cobalt-plazo-1_5_11zon.webp') }}"
                            alt="Lehenga"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-rose-700 transition-colors duration-300">Lehenga</span>
                <span class="text-xs text-gray-500 mt-1">Festival Ready</span>
            </a>

            <!-- Indo Western -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-indigo-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/dark-red-plazo-4_14_11zon.webp') }}"
                            alt="Indo Western"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-indigo-700 transition-colors duration-300">Indo Western</span>
                <span class="text-xs text-gray-500 mt-1">Fusion Trends</span>
            </a>

            <!-- Blouses -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400/20 to-violet-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-purple-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/cherry-plazo-6_4_11zon.webp') }}"
                            alt="Blouses"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-purple-700 transition-colors duration-300">Blouses</span>
                <span class="text-xs text-gray-500 mt-1">Statement Pieces</span>
            </a>

            <!-- Menswear -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-blue-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/glow-orange-2_17_11zon.webp') }}"
                            alt="Menswear"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-blue-700 transition-colors duration-300">Menswear</span>
                <span class="text-xs text-gray-500 mt-1">Modern Ethnic</span>
            </a>

            <!-- Bridal Edit -->
            <a href="/" class="group flex flex-col items-center  snap-center">
                <div class="relative mb-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-300/20 to-yellow-400/20 rounded-full blur-md group-hover:blur-xl transition-all duration-500"></div>
                    <div class="relative w-20 h-20 sm:w-26 sm:h-26 rounded-full overflow-hidden mb-3 shadow-xl group-hover:border-amber-100 transition-all duration-300">
                        <img src="{{ asset('web/images/product-images/purple-plazo-5_85_11zon.webp') }}"
                            alt="Bridal Edit"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                    </div>

                </div>
                <span class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-amber-700 transition-colors duration-300">Bridal Edit</span>
                <span class="text-xs text-gray-500 mt-1">Luxury Collection</span>
            </a>

        </div>
    </div>


</div>

<!-- Required CSS for no scrollbar + smooth snap -->

<section class="px-4 lgg:py-12 py-6 h-auto bg-gradient-to-b from-gray-100 to-white">
    <div class="container mx-auto">
        <div class="flex flex-row gap-3 lg:gap-6 justify-between items-stretch h-auto">
            <!-- Left Image Column -->
            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-xl shadow-xl">
                    <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-105 transition-transform duration-700"
                        src="{{ asset('web/images/banner-images/glow-orange-2.webp') }}" alt="Light Pink Salwar" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </div>
                <div
                    class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <span
                        class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800">Spring
                        Collection</span>
                </div>
            </div>

            <!-- Middle Content Column -->
            <div class="xl:min-w-[600px] lgg:min-w-[350px] min-w-[250px] md:w-auto w-full flex flex-col gap-3 lg:gap-6">
                <!-- Top Image -->
                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-xl shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-500/10 to-purple-500/10 z-10"></div>
                    <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('web/images/product-images/Poses In Frock Suit.jpg') }}" alt="Glow Pink Dress" />
                    <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                        <span
                            class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">NEW</span>
                    </div>
                </div>

                <!-- Center Banner -->
                <div
                    class="flex flex-col items-center justify-center space-y-4 p-6 lg:p-8 bg-gradient-to-br from-pink-100 via-white to-purple-100 rounded-xl shadow-2xl border border-gray-100 flex-grow relative overflow-hidden">
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
                        class="px-8 py-3 lg:px-10 lg:py-4 bg-gradient-to-r from-black via-gray-800 to-black rounded-full text-white text-[1.3rem] font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:from-gray-900 hover:via-black hover:to-gray-900 group relative overflow-hidden">
                        <span class="relative z-10">Shop Now →</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-rose-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </button>

                    <p class="text-sm text-gray-500 mt-2">Limited Time Offer</p>
                </div>

                <!-- Bottom Image -->
                <div class="w-full xll:h-[300px] h-[250px] overflow-hidden relative group rounded-xl shadow-lg">
                    <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('web/images/product-images/Long Frock Poses Photo Ideas At Home.jpg') }}"
                        alt="Gray Lahenga" />
                    <div
                        class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                        <span
                            class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800 shadow-lg">Elegant</span>
                    </div>
                </div>
            </div>

            <!-- Right Image Column -->
            <div class="flex-1 overflow-hidden md:block hidden relative group">
                <div class="h-full w-full relative overflow-hidden rounded-xl shadow-xl">
                    <img class="object-cover h-full w-full object-top object-center transform group-hover:scale-105 transition-transform duration-700"
                        src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Red Plazo" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                </div>
                <div
                    class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <span
                        class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800">Festival
                        Wear</span>
                </div>
            </div>
        </div>
    </div>
</section>







<section class="px-4 lgg:py-12 py-6 ">
    <div class="container mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h2
                class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl  font-bold mb-4 bg-gradient-to-r from-secondary via-primary to-secondary-light bg-clip-text text-transparent">
                Shop By Category
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Explore our exclusive collections curated just for you
            </p>
        </div>

        <!-- Owl Carousel Container -->
        <div class="relative">
            <div id="categories-carousel" class="owl-carousel owl-theme">

                @if(!isset($categories)):
                <!-- Category 1 -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-pink-100 to-purple-100">
                            <img src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Salwar Kameez"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Salwar Kameez
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                120+ Designs
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Popular
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category 2 -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-blue-100 to-cyan-100">
                            <img src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}"
                                alt="Lehengas"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-blue-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Lehengas
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                80+ Collections
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Bridal
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category 3 -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-amber-100 to-orange-100">
                            <img src="{{ asset('web/images/product-images/red-plazo-2_88_11zon.webp') }}" alt="Sarees"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-amber-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Sarees
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                200+ Styles
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Traditional
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category 4 -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-emerald-100 to-green-100">
                            <img src="{{ asset('web/images/product-images/glow-orange-2_17_11zon.webp') }}"
                                alt="Plazo Suits"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-emerald-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Plazo Suits
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                150+ Designs
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-emerald-500 to-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Modern
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category 5 -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-purple-100 to-violet-100">
                            <img src="{{ asset('web/images/product-images/cherry-plazo-3_1_11zon.webp') }}"
                                alt="Party Wear"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-purple-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Party Wear
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                90+ Outfits
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-purple-500 to-violet-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Trending
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Add more categories as needed -->
                <!-- Category 6 - Example -->
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-red-100 to-pink-100">
                            <img src="{{ asset('web/images/product-images/glow-orange-2_17_11zon.webp') }}"
                                alt="Kurtis"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-red-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                    Kurtis
                                </h3>
                                <span class="text-white/80 group-hover:text-white transition-colors">
                                    →
                                </span>
                            </div>
                            <p
                                class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                100+ Styles
                            </p>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Casual
                            </span>
                        </div>
                    </div>
                </div>
                @else
                @foreach($categories as $category)
                <div class="item flex justify-center items-center">
                    <div class="group relative w-fit  transition-all duration-500 transform hover:-translate-y-2 mx-2">
                        <div
                            class="aspect-square overflow-hidden rounded-t-full max-h-[250px] bg-gradient-to-br from-red-100 to-pink-100">
                            <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                                alt="Kurtis"
                                class="object-cover object-top w-full h-full transform group-hover:scale-110 transition-transform duration-700" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-red-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white z-10 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <a href="{{ route('category.show', $category->slug) }}" class="block">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl lg:text-2xl font-bold tracking-tight drop-shadow-lg">
                                        {{ $category->name }}
                                    </h3>
                                    <span class="text-white/80 group-hover:text-white transition-colors">
                                        →
                                    </span>
                                </div>
                                <p
                                    class="text-sm lg:text-base text-white/90 mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                    100+ Styles
                                </p>
                        </div>
                        </a>

                        <!-- Floating Badge -->
                        <div class="absolute sm:top-4 sm:left-4 left-3 top-3">
                            <span
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Casual
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>

            <!-- Custom Navigation Arrows -->
            <div
                class="owl-nav custom-nav hidden lg:flex w-full absolute left-0 top-[50%]  justify-between items-center px-0">
                <button
                    class="owl-prev ml-[-10px] bg-white/80 hover:bg-white text-gray-800 hover:text-black w-10 h-10 lg:w-12 lg:h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:shadow-xl z-10">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="owl-next  mr-[-10px] bg-white/80 hover:bg-white text-gray-800 hover:text-black w-10 h-10 lg:w-12 lg:h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:shadow-xl z-10">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- <!-- View All Button -->
            <div class="text-center mt-6">
                <a href="#"
                    class="inline-flex items-center gap-2 px-8 py-3 lg:px-10 lg:py-4 bg-gradient-to-r from-gray-900 to-black rounded-full text-white font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                    <span>View All Categories</span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div> --}}
    </div>
</section>


<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto px-4">
        <!-- Scroll Wrapper -->
        <div class="flex gap-4 flex-wrap lgg:gap-6 justify-start items-center ">
            @foreach ($categories->where('parent_id', null) as $category)

            <div
                class="group flex justify-between items-center lgg:gap-4 gap-[15px] border border-gray-200 rounded-full px-3 py-2 transition-all duration-300 ease-out hover:bg-secondary-light hover:border-pink-300 hover:shadow-md hover:-translate-y-0.5">
                <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                    class="min-w-12 min-h-2 w-12 h-12 rounded-full object-cover transition-transform duration-300 group-hover:scale-110" />

                <span
                    class="text-sm font-medium whitespace-nowrap transition-colors duration-300 group-hover:text-secondary">
                    {{ $category->name }}
                </span>

                <span
                    class="lgg:ml-auto min-w-9 min-h-9 w-9 h-9 flex items-center justify-center rounded-full bg-pink-100 text-secondary text-sm font-semibold transition-all duration-300 group-hover:bg-secondary group-hover:text-white">
                    {{ $category->products_count }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="px-4 lgg:py-12 py-6">
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
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                    onclick="window.location.href='{{ route('page.single-product', $product->slug) }}';">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ $product->product_image ? asset($product->product_image) : asset('assets/images/placeholder.jpg') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist({{ $product->id }}, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-{{ $product->id }}">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
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

<section class="px-4 lgg:py-12 py-6">
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
                        We guarantee the lowest prices on premium fashion. If you find it cheaper elsewhere within 30 days, we'll match or beat it.
                    </p>

                </div>


                <ul class=" text-gray-700 flex flex-col gap-3 lgg:items-start items-center justify-center">
                    <li class="flex items-center">
                        <div class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Price match within 30 days
                    </li>
                    <li class="flex items-center">
                        <div class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Always the lowest price guaranteed
                    </li>
                    <li class="flex items-center">
                        <div class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center mr-3 flex-shrink-0">
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
                    <div class="absolute top-0 right-8 w-36 h-36 transform rotate-12 hover:-rotate-6 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary/10 to-pink-500/10 rounded-xl"></div>
                        <img
                            src="{{ asset('web/images/product-images/light-red-plazo-4_73_11zon.webp') }}"
                            alt="Saree Collection"
                            class="w-full h-full object-cover object-top  rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300">
                        <div class="absolute -bottom-2 -left-2 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 border border-gray-200 shadow-sm">
                            <p class="text-gray-900 text-xs font-bold">₹74.99</p>
                        </div>
                    </div>

                    <div class="relative w-56 h-56 mx-auto transform -rotate-3 hover:rotate-0 transition-transform duration-500 cursor-pointer group z-[10]">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary/10 to-pink-400/10 rounded-2xl"></div>
                        <img
                            src="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}"
                            alt="Premium Lehenga"
                            class="w-full h-full object-cover object-top rounded-2xl shadow-xl border-4 border-white group-hover:border-secondary transition-all duration-300">
                        <div class="absolute -top-3 -right-3 bg-secondary text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-6">
                            -25%
                        </div>
                    </div>

                    <!-- Product 3 - Bottom Left (Tilted Square) -->
                    <div class="absolute bottom-8 left-4 w-40 h-40 transform -rotate-12 hover:rotate-3 transition-transform duration-500 cursor-pointer group z-10">
                        <div class="absolute inset-0 bg-gradient-to-tl from-secondary/10 to-pink-600/10 rounded-xl"></div>
                        <img
                            src="{{ asset('web/images/product-images/light-pink-m-4_51_11zon.webp') }}"
                            alt="Party Wear"
                            class="w-full h-full object-cover object-top  rounded-xl shadow-lg border-3 border-white group-hover:border-secondary-light transition-all duration-300">
                        <div class="absolute -top-2 -right-2 bg-secondary text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            New
                        </div>
                    </div>

                    <!-- Product 4 - Bottom Right (Circle) -->
                    <div class="absolute bottom-4 right-0 w-32 h-32 rounded-full overflow-hidden border-4 border-white hover:border-secondary transition-all duration-300 cursor-pointer group z-10 shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary/10 to-pink-600/10"></div>
                        <img
                            src="{{ asset('web/images/product-images/glow-orange-3_18_11zon.webp') }}"
                            alt="Kurta Set"
                            class="w-full h-full object-cover object-top  group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 flex items-center justify-center bg-secondary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-sm font-bold">View</span>
                        </div>
                    </div>

                    <!-- Connecting Lines -->
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-1/2 left-1/2 w-20 h-0.5 bg-gradient-to-r from-secondary/20 to-transparent transform -translate-x-20"></div>
                        <div class="absolute top-1/2 left-1/2 w-20 h-0.5 bg-gradient-to-l from-secondary/20 to-transparent transform translate-x-20"></div>
                    </div>

                </div>

                <!-- Collection Badge -->
                <div class="mt-10 text-center">
                    <div class="inline-flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-6 py-3 shadow-sm hover:border-secondary-light transition-all duration-300 cursor-pointer group">
                        <div class="flex -space-x-3">
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-gray-900 text-sm font-semibold group-hover:text-secondary transition-colors">Premium Collection</p>
                            <p class="text-gray-500 text-xs">4+ stunning designs</p>
                        </div>
                        <div class="w-10 min-w-10 h-10 min-h-10 rounded-full bg-gradient-to-r from-secondary to-pink-500 flex items-center justify-center group-hover:bg-secondary-light transition-all duration-300">
                            <i class="fas fa-arrow-right text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right - CTA + Trust -->
            <div class="text-center">
                <h3 class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl  font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-purple-600 bg-clip-text text-transparent animate-gradient mb-4">Exclusive Deals Just for You</h3>
                <button class="w-full sm:w-auto relative p-[16px_34px] bg-gradient-to-r from-secondary to-pink-500 hover:from-secondary hover:to-primary text-white font-bold text-xl rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-secondary/20">
                    <i class="fas fa-shopping-bag mr-3 text-xl"></i>
                    Shop Deals Now
                </button>




            </div>

        </div>
    </div>
</section>
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 smx:grid-cols-2 lg:grid-cols-4 lgg:gap-8 gap-4">
            <!-- Banner 1: Autumn Sale -->
            <div class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top"
                        src="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}" alt="" />
                </div>
                <div class="relative flex flex-col justify-end md:p-8 p-4 h-full text-white">
                    <span
                        class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">Autumn</span>
                    <span class="text-[2.7rem] font-bold font-serif uppercase tracking-wider lgg:mb-4 mb-2">
                        Sale
                    </span>
                    <p class="lgg:text-3xl text-[1.2rem] font-serif lgg:mb-6 mb-3">
                        Up to 50% off
                    </p>
                    <a href="#"
                        class="inline-block w-fit text-center bg-black text-white lgg:px-8 px-4 py-2 lgg:text-md text-sm font-sans rounded-full uppercase tracking-wide hover:bg-gray-600 transition-all duartion-300 ease-in-out">Shop
                        Now</a>
                    <p class="text-md lgg:mt-4 mt-2 font-sans opacity-80">
                        www.collegewalk.com
                    </p>
                </div>
            </div>

            <!-- Banner 2: Summer Skincare Tips -->
            <div class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top"
                        src="{{ asset('web/images/product-images/light-pink-plazo-5_57_11zon.webp') }}"
                        alt="" />
                </div>
                <div
                    class="relative flex flex-col justify-center items-center text-center lgg:p-8 p-4 h-full text-white">
                    <h1 class="lgg:text-7xl text-[3rem] font-script italic tracking-wider">
                        Summer
                    </h1>
                    <h2 class="lgg:text-5xl text-[2rem] font-serif-alt italic mt-[-20px]">
                        Skincare Tips
                    </h2>
                </div>
            </div>

            <!-- Banner 3: Summer Dress Sale -->
            <div class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top"
                        src="{{ asset('web/images/product-images/pink-plazo-1_76_11zon.webp') }}" alt="" />
                </div>
                <div class="relative flex flex-col justify-center p-12 h-full text-white">
                    <div class="max-w-xs">
                        <p class="text-sm uppercase tracking-widest font-sans mb-2 opacity-80">
                            Last Chance
                        </p>
                        <h1 class="lgg:text-[2rem] text-[1.3rem] font-serif uppercase leading-tight mb-4">
                            Summer Dress Sale 35% Off Storewide
                        </h1>
                        <p class="text-lg font-sans uppercase tracking-wider bg-white/20 inline-block px-4 py-2">
                            C-1623B5OFF
                        </p>
                    </div>
                </div>
            </div>

            <!-- Banner 4: Latest Fashion -->
            <div class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img class="w-full h-full object-cover object-center object-top"
                        src="{{ asset('web/images/product-images/red-plazo-9_95_11zon.webp') }}" alt="" />
                </div>
                <div class="relative flex flex-col justify-end p-8 h-full text-white">
                    <div class="text-right">
                        <p class="text-sm uppercase tracking-widest font-sans mb-2">
                            New Arrival
                        </p>
                        <h1 class="text-[2.5rem] font-serif-alt italic leading-none">
                            Latest Fashion
                        </h1>
                        <h2 class="text-[2.2rem] font-serif-alt italic mt-[-10px]">
                            Vibe
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-6">
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
                    <!-- Product Items (same as before) -->

                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('web/images/product-images/dark-red-plazo-2_12_11zon.webp') }}"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring
                                            Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('web/images/product-images/light-pink-salwar-s-3_65_11zon.webp') }}"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring
                                            Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('web/images/product-images/red-plazo-1_87_11zon.webp') }}"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring
                                            Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('web/images/product-images/purple-plazo-4_84_11zon.webp') }}"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring
                                            Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img src="{{ asset('web/images/product-images/short-plazo-2_100_11zon.webp') }}"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring
                                            Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Add more products... -->
                </div>
            </div>
        </div>
    </div>
</section>


<section class="px-4 lgg:py-12 py-6">
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
                <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card"
                    data-product-id="{{ $product->id }}">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ $product->product_image ? asset($product->product_image) : asset('assets/images/placeholder.jpg') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist({{ $product->id }}, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-{{ $product->id }}">
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

<section class="px-4 lgg:py-12 py-6">
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

<section class="px-4 lgg:py-12 py-6">
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
                <div class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer category-card"
                    data-category-id="{{ $category->id }}">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ $category->image ? asset('uploads/category/' . $category->image) : asset('assets/images/placeholder-category.jpg') }}"
                            alt="{{ $category->name }}"
                            class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
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
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Editor's Pick
            </h2>
        </div>
        <div class="grid-container">
            <!-- Owl Carousel for mobile/tablet -->
            <div class="owl-carousel banner-carousel lgg:hidden">
                <!-- Slide 1 -->
                <div class="relative bg-[#b8a89a] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
                    <img src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Traditional Blouse"
                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            Trendy To<br />Traditional Blouses
                        </h2>
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">7% OFF</span> | Use Code:
                            <span class="text-white font-medium">GLAM7</span>
                        </p>
                        <button
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
                            SHOP NOW
                        </button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="relative bg-[#e8dcd6] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
                    <img src="{{ asset('web/images/banner-images/gray-lahenga-2.webp') }}" alt="Jewellery Edit"
                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            Jewellery Edit
                        </h2>
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">7% OFF</span> | Use Code:
                            <span class="text-white font-medium">GLAM7</span>
                        </p>
                        <button
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
                            SHOP NOW
                        </button>
                    </div>
                </div>
            </div>

            <!-- Original grid layout for desktop -->
            <div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[600px] min-h-[500px] h-[50vh]">
                <!-- Left Banner -->
                <div class="relative bg-[#b8a89a] overflow-hidden">
                    <img src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="Traditional Blouse"
                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            Trendy To<br />Traditional Blouses
                        </h2>
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">7% OFF</span> | Use Code:
                            <span class="text-white font-medium">GLAM7</span>
                        </p>
                        <button
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">
                            SHOP NOW
                        </button>
                    </div>
                </div>

                <!-- Right Banner -->
                <div class="relative bg-[#e8dcd6] overflow-hidden">
                    <img src="{{ asset('web/images/banner-images/gray-lahenga-2.webp') }}" alt="Jewellery Edit"
                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            Jewellery Edit
                        </h2>
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">7% OFF</span> | Use Code:
                            <span class="text-white font-medium">GLAM7</span>
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
        <div class="w-full text-center mb-6">
            <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Most Wishlisted Styles
            </h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset('web/images/product-images/short-plazo-2_100_11zon.webp') }}"
                            alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist(1, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-1">
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
                            Red Plazo
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
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset('web/images/product-images/light-pink-plazo-2_54_11zon.webp') }}"
                            alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist(1, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-1">
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
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset('web/images/product-images/cherry-plazo-3_1_11zon.webp') }}"
                            alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist(1, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-1">
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
                            Cherry Plazo Light
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
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset('web/images/product-images/dark-red-plazo-3_13_11zon.webp') }}"
                            alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center" />

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
                            class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                            onclick="toggleHomeWishlist(1, event)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500" id="wishlist-heart-1">
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
            </div>

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
                            <a href=""
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
                            <a href=""
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
            <div class="bg-gradient-to-br from-white to-red-50 rounded-2xl shadow-2xl max-w-2xl w-full p-8 md:p-6 relative overflow-hidden border border-red-100">

                <!-- Top Banner -->
                <div class="flex justify-center items-center">
                    <div class="w-auto flex sm:flex-row flex-col  bg-gradient-to-r from-primary  to-secondary text-white text-sm font-bold px-8 py-3 rounded-full shadow-lg   items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:block hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
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
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Elevating Lahenga Elegance</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "At Aiman Fashion, we believe every lahenga tells a story. Our designs blend traditional craftsmanship with contemporary silhouettes, creating pieces that honor heritage while embracing modern elegance."
                            </p>
                        </div>
                        <div class="md:mt-8 mt-4 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-secondary-light flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Lead Designer</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Modern Salwar Kameez</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "Our salwar kameez collection redefines comfort with style. We focus on flattering cuts and breathable fabrics that celebrate the feminine form while ensuring maximum comfort."
                            </p>
                        </div>
                        <div class="mt-8 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Fashion Director</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
                            <div class="w-16 h-1 bg-gradient-to-r from-secondary  to-secondary-light rounded-full"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">The Palazzo Revolution</h3>
                        <div class="relative">
                            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 text-secondary rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed text-center px-8 italic">
                                "Palazzos are our canvas for innovation. We experiment with fabrics and draping techniques to create pieces that are both trendy and timeless for the modern woman on the go."
                            </p>
                        </div>
                        <div class="mt-8 pt-6 pb-3 border-t border-red-100">
                            <div class="flex items-center justify-center gap-4">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center ring-4 ring-white shadow-lg">
                                        <span class="text-secondary font-bold text-xl">A</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-secondary rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900 text-lg">Aiman Design Team</p>
                                    <p class="text-sm text-secondary font-medium">Creative Head</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs text-gray-500">Trendsetter</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Custom Navigation -->
                <div class="flex  md:justify-between justify-center md:absolute w-full md:left-0 md:bottom-[20%] px-[37px] md:z-[10] gap-4 mt-8 thoughts-nav">
                    <button class="custom-prev-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="custom-next-btn bg-gradient-to-r from-secondary to-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Decorative Bottom Border -->
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-transparent via-secondary to-transparent rounded-full"></div>

            </div>
        </div>
    </div>
</section>













@endsection
@section('scripts')


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
    
    function addToCart(variantId, event) {
        // Show loading state
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Adding...';
        button.disabled = true;

        // Create form data
        const formData = new FormData();
        formData.append('variant_id', variantId);
        formData.append('count', 1);
        console.log(formData);
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Send AJAX request
        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.success) {
                    showNotification(data.message, 'success');
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while adding to cart', 'error');
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
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


@endsection