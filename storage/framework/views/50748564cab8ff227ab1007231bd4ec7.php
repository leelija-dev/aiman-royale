<?php $__env->startSection('content'); ?>
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 h-auto">
    <div class="container mx-auto">
        <div class="flex flex-row gap-3 justify-between items-stretch h-auto">
            <div class="flex-1 overflow-hidden md:block hidden">
                <div class="h-full w-full">
                    <img
                        class="object-cover h-full w-full object-top object-center"
                        src="./assets/images/Home-image/pic-16.avif"
                        alt="" />
                </div>
            </div>

            <div
                class="xl:min-w-[600px] lgg:min-w-[350px] min-w-[250px] md:w-auto w-full flex flex-col gap-3">
                <div
                    class="w-full xll:h-[300px] h-[250px] overflow-hidden flex-shrink-0">
                    <img
                        class="object-cover h-full w-full object-top object-center"
                        src="./assets/images/Home-image/pic-2.avif"
                        alt="" />
                </div>

                <div
                    class="flex flex-col items-center justify-center space-y-4 p-6 bg-white rounded-lg flex-grow">
                    <h1
                        class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-bold">
                        ULTIMATE
                    </h1>
                    <span
                        class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-extrabold text-white"
                        style="-webkit-text-stroke: 1px black">
                        SALE
                    </span>
                    <p>NEW COLLECTION</p>
                    <button
                        class="px-8 py-3 bg-black rounded-lg text-white text-[1.3rem]">
                        Shop Now
                    </button>
                </div>

                <div
                    class="w-full xll:h-[300px] h-[250px] overflow-hidden flex-shrink-0">
                    <img
                        class="object-cover h-full w-full object-top object-center"
                        src="./assets/images/Home-image/pic-3.avif"
                        alt="" />
                </div>
            </div>

            <div class="flex-1 overflow-hidden md:block hidden">
                <div class="h-full w-full">
                    <img
                        class="object-cover h-full w-full object-top object-center"
                        src="./assets/images/Home-image/pic-4.avif"
                        alt="" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-6">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   
    <div class="container mx-auto px-4">
        <!-- Scroll Wrapper -->
        <div
            class="grid xl:grid-cols-5 lg:grid-cols-4 sm:grid-cols-3 smxl:grid-cols-2 grid-cols-1 gap-3">
            <div
                class="group flex justify-between items-center lgg:gap-3 gap-[3px] border border-gray-200 rounded-full px-3 py-2 transition-all duration-300 ease-out hover:bg-secondary-light hover:border-pink-300 hover:shadow-md hover:-translate-y-0.5">
                <img
                    src="./assets/images/Home-image/pic-5.avif"
                    class="min-w-12 min-h-2 w-12 h-12 rounded-full object-cover transition-transform duration-300 group-hover:scale-110" />

                <span
                    class="text-sm font-medium whitespace-nowrap transition-colors duration-300 group-hover:text-secondary">
                    <?php echo e($category->name); ?>

                </span>

                <span
                    class="lgg:ml-auto min-w-9 min-h-9 w-9 h-9 flex items-center justify-center rounded-full bg-pink-100 text-secondary text-sm font-semibold transition-all duration-300 group-hover:bg-secondary group-hover:text-white">
                   <?php echo e($category->products_count); ?>

                </span>
            </div>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div
            class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <!-- Left Title -->
            <h2
                class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Trending Best Selling Products
            </h2>

            <!-- Center Navigation -->

            <!-- Right Link -->
            <a
                href="#"
                class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
                All Products
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>:
              
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
                                Add To Cart
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900">
                            <?php echo e($product->name); ?>, <?php echo e($product->size); ?>, <?php echo e($product->color); ?>

                        </h3>

                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span><?php echo e($product->brand); ?></span>
                            <span class="flex items-center gap-1 text-gray-700">
                                <span class="text-sm font-medium">4.4</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="text-lg font-bold text-gray-900">Rs. <?php echo e($product->discount_price); ?></span>
                            <span class="text-sm text-gray-400 line-through">Rs. <?php echo e($product->price); ?></span>
                        </div>
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Add more product items as needed -->
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Red Policy Card -->
            <div
                class="flex xxs:flex-row flex-col xxs:text-left text-center overflow-hidden relative items-center justify-between gap-4 border-2 border-red-500 bg-red-100 rounded-lg px-6 py-5">
                <div>
                    <h3 class="text-red-600 font-semibold text-lg">
                        Our Policy: Best Price !
                    </h3>
                    <p class="text-red-500 text-sm">
                        Sign Up to avoid missing diamonds!
                    </p>
                </div>
                <button
                    class="shrink-0 bg-primary hover:bg-red-700 text-white text-sm font-medium px-5 py-2 rounded-md transition">
                    Check Coupons
                </button>
            </div>

            <!-- Green Policy Card -->
            <div
                class="flex xxs:flex-row flex-col xxs:text-left text-center items-center justify-between gap-4 border-2 border-green-500 bg-green-100 rounded-lg px-6 py-5">
                <div>
                    <h3 class="text-green-600 font-semibold text-lg">
                        Our Policy: Best Price !
                    </h3>
                    <p class="text-green-500 text-sm">
                        Sign Up to avoid missing diamonds!
                    </p>
                </div>
                <button
                    class="shrink-0 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-md transition">
                    Check Coupons
                </button>
            </div>
        </div>
    </div>
</section>
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div
            class="grid grid-cols-1 smx:grid-cols-2 lg:grid-cols-4 lgg:gap-8 gap-4">
            <!-- Banner 1: Autumn Sale -->
            <div
                class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img
                        class="w-full h-full object-cover object-center object-top"
                        src="./assets/images/Home-image/pic-17.avif"
                        alt="" />
                </div>
                <div
                    class="relative flex flex-col justify-end md:p-8 p-4 h-full text-white">
                    <span
                        class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">Autumn</span>
                    <span
                        class="text-[2.7rem] font-bold font-serif uppercase tracking-wider lgg:mb-4 mb-2">
                        Sale
                    </span>
                    <p class="lgg:text-3xl text-[1.2rem] font-serif lgg:mb-6 mb-3">
                        Up to 50% off
                    </p>
                    <a
                        href="#"
                        class="inline-block w-fit text-center bg-black text-white lgg:px-8 px-4 py-2 lgg:text-md text-sm font-sans rounded-full uppercase tracking-wide hover:bg-gray-600 transition-all duartion-300 ease-in-out">Shop Now</a>
                    <p class="text-md lgg:mt-4 mt-2 font-sans opacity-80">
                        www.collegewalk.com
                    </p>
                </div>
            </div>

            <!-- Banner 2: Summer Skincare Tips -->
            <div
                class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img
                        class="w-full h-full object-cover object-center object-top"
                        src="./assets/images/Home-image/pic-18.avif"
                        alt="" />
                </div>
                <div
                    class="relative flex flex-col justify-center items-center text-center lgg:p-8 p-4 h-full text-white">
                    <h1
                        class="lgg:text-7xl text-[3rem] font-script italic tracking-wider">
                        Summer
                    </h1>
                    <h2
                        class="lgg:text-5xl text-[2rem] font-serif-alt italic mt-[-20px]">
                        Skincare Tips
                    </h2>
                </div>
            </div>

            <!-- Banner 3: Summer Dress Sale -->
            <div
                class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img
                        class="w-full h-full object-cover object-center object-top"
                        src="./assets/images/Home-image/pic-19.avif"
                        alt="" />
                </div>
                <div
                    class="relative flex flex-col justify-center p-12 h-full text-white">
                    <div class="max-w-xs">
                        <p
                            class="text-sm uppercase tracking-widest font-sans mb-2 opacity-80">
                            Last Chance
                        </p>
                        <h1
                            class="lgg:text-[2rem] text-[1.3rem] font-serif uppercase leading-tight mb-4">
                            Summer Dress Sale 35% Off Storewide
                        </h1>
                        <p
                            class="text-lg font-sans uppercase tracking-wider bg-white/20 inline-block px-4 py-2">
                            C-1623B5OFF
                        </p>
                    </div>
                </div>
            </div>

            <!-- Banner 4: Latest Fashion -->
            <div
                class="relative overflow-hidden rounded-lg shadow-lg bg-cover bg-center h-96">
                <div class="absolute top-0 left-0 w-full h-full">
                    <img
                        class="w-full h-full object-cover object-center object-top"
                        src="./assets/images/Home-image/pic-20.avif"
                        alt="" />
                </div>
                <div
                    class="relative flex flex-col justify-end p-8 h-full text-white">
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
                <button
                    class="mt-6 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-900 transition">
                    Buy Now
                </button>

                <!-- Countdown Title -->
                <h4
                    class="mt-10 text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg lgg:text-h4-lgg xl:text-h4-xl 2xl:text-h4-2xl font-semibold text-gray-800">
                    Hurry, Before It’s Too Late!
                </h4>

                <!-- Countdown -->
                <div
                    class="mt-6 flex gap-4 flex-wrap lgg:justify-start justify-center">
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
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-21.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-22.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-23.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-24.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-25.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                                        30% OFF
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item flex justify-center items-center">
                        <div
                            class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
                            <div class="relative overflow-hidden">
                                <img
                                    src="./assets/images/Home-image/pic-26.avif"
                                    alt="Silver Lehenga"
                                    class="w-full h-[400px] object-cover object-center object-top" />
                            </div>
                            <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
                                <div class="text-left">
                                    <!-- Top line: 01 — Spring Sale -->
                                    <div class="flex items-center justify-center gap-4 mb-1">
                                        <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                                        <div class="h-px w-4 bg-gray-400"></div>
                                        <span
                                            class="text-[1.1rem] font-medium text-gray-600 tracking-wider">Spring Sale</span>
                                    </div>

                                    <!-- Big discount text -->
                                    <div
                                        class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
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
        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-gray-800">
            <!-- Item 1 -->
            <div
                class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img
                    class="min-w-12 w-12 h-12 min-h-12"
                    src="./assets/images/icon1.svg"
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
            <div
                class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img
                    class="min-w-12 w-12 h-12 min-h-12"
                    src="./assets/images/icon2.svg"
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
            <div
                class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img
                    class="min-w-12 w-12 h-12 min-h-12"
                    src="./assets/images/icon4.svg"
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
            <div
                class="flex justify-center sm:flex-row flex-col sm:text-left text-center items-center gap-4">
                <img
                    class="min-w-12 w-12 h-12 min-h-12"
                    src="./assets/images/icon3.svg"
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
        <div
            class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <!-- Left Title -->
            <h2
                class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Filled By Colour
            </h2>

            <!-- Center Navigation -->

            <!-- Right Link -->
            <a
                href="#"
                class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
                All Products
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-4.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-5.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-6.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-7.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more product items as needed -->
        </div>
    </div>
</section>
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Banner 1 -->
        <div
            class="relative xxs:flex-row flex-col xxs:text-left text-center gap-4 overflow-hidden rounded-lg bg-gradient-to-r from-red-700 to-red-600 px-6 py-6 flex items-center justify-between">
            <!-- Decorative shape -->
            <div
                class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_20%_50%,orange_0%,transparent_40%)]"></div>

            <div class="relative z-10">
                <h3 class="text-white font-semibold text-lg">
                    Special campaigns: November!
                </h3>
                <p class="text-white/80 text-sm mt-1">
                    Sign up to avoid missing discounts!
                </p>
            </div>

            <button
                class="relative z-10 bg-white text-red-700 text-sm font-medium px-4 py-2 rounded-md shadow hover:bg-gray-100 transition">
                Buy Products
            </button>
        </div>

        <!-- Banner 2 -->
        <div
            class="relative overflow-hidden xxs:flex-row flex-col xxs:text-left text-center gap-4 rounded-lg bg-red-700 px-6 py-6 flex items-center justify-between">
            <!-- Pattern overlay -->
            <div
                class="absolute inset-0 opacity-25 bg-[url('https://www.transparenttextures.com/patterns/floral.png')]"></div>

            <div class="relative z-10">
                <h3 class="text-white font-semibold text-lg">Check New Patterns</h3>
                <p class="text-white/80 text-sm mt-1">
                    Sign up to avoid missing campaigns!
                </p>
            </div>

            <button
                class="relative z-10 bg-white text-red-700 text-sm font-medium px-4 py-2 rounded-md shadow hover:bg-gray-100 transition">
                Check Products
            </button>
        </div>
    </div>
</section>
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div
            class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <!-- Left Title -->
            <h2
                class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Filled By Categories
            </h2>

            <!-- Center Navigation -->

            <!-- Right Link -->
            <a
                href="#"
                class="flex items-center gap-1 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-black hover:gap-2 transition-all">
                All Products
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more product items as needed -->
        </div>
    </div>
</section>

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2
                class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
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
        <div class="w-full text-center mb-6">
            <h2
                class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">
                Most Wishlisted Styles
            </h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-22.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-23.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-24.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item flex justify-center items-center">
                <div
                    class="group w-full bg-white xxs:max-w-full max-w-[300px]  rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="./assets/images/Home-image/pic-25.avif"
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
                            class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out">
                            <button onclick="addToCart(<?php echo e($product->variant_id); ?>, event)" class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors">
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
                        <div class="lgg:hidden block">
                            <button class=" px-4 py-1 bg-white border-secondary border-[1px] rounded-md  w-full">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more product items as needed -->
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<!-- jQuery (required for Owl Carousel) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Cart Functionality -->
<script>
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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.web.main-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\aiman-royale\resources\views/web/home.blade.php ENDPATH**/ ?>