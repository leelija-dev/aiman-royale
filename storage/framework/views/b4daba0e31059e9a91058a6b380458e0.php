








<?php $__env->startSection('content'); ?>
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
      <div class="container mx-auto">
        <div
          class="mb-4 flex flex-row lgg:justify-end justify-between gap-3 flex-wrap"
        >
          <button
            id="open-filter"
            type="button"
            class="lgg:hidden flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-700 text-sm font-medium shadow-sm transition-all duration-300 hover:bg-gray-100 hover:shadow-md active:scale-95"
          >
            <!-- Filter Icon -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z"
              />
            </svg>

            Filter
          </button>
          <!-- Professional Sort Dropdown -->
          <div class="relative inline-block text-left">
            <!-- Dropdown Button -->
            <button
              type="button"
              id="sort-button"
              class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <!-- Sort Icon -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 7h14M3 12h10M3 17h6M17 7l3 3m0 0l-3 3m3-3H10"
                />
              </svg>
              <span id="sort-label">Sort by</span>
              <!-- Chevron Icon (rotates on open) -->
              <svg
                id="chevron-icon"
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
              id="sort-menu"
              class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
              role="menu"
              aria-orientation="vertical"
              aria-labelledby="sort-button"
            >
              <div class="py-2" role="none">
                <!-- Menu Items -->
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                  data-value="name-asc"
                  role="menuitem"
                >
                  <span>Name (A to Z)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                  data-value="name-desc"
                  role="menuitem"
                >
                  <span>Name (Z to A)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                  data-value="date-desc"
                  role="menuitem"
                >
                  <span>Date (Newest first)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-100 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                  data-value="date-asc"
                  role="menuitem"
                >
                  <span>Date (Oldest first)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                  data-value="price-asc"
                  role="menuitem"
                >
                  <span>Price (Low to High)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
                <button
                  type="button"
                  class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                  data-value="price-desc"
                  role="menuitem"
                >
                  <span>Price (High to Low)</span>
                  <svg
                    class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-row gap-3 relative">
          <div
            id="filter-sidebar"
            class="lgg:sticky fixed lgg:top-0 lgg:left-0 top-0 left-0 lgg:max-w-[300px] max-w-[260px] lgg:h-fit h-full lgg:max-h-max max-h-screen w-full bg-white rounded-xl shadow-md py-5 px-2 z-[20003] transition-all duration-300 ease-in-out"
          >
            <div class="space-y-6 h-full overflow-auto px-2">
              <!-- Header -->
              <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
                <button class="text-sm text-blue-600 hover:underline">
                  Clear all
                </button>
              </div>

              <!-- Selected Tags -->
              <div class="flex flex-wrap gap-2">
                <span
                  class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full"
                >
                  Tag for Brand
                  <span class="cursor-pointer text-gray-500">×</span>
                </span>
                <span
                  class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full"
                >
                  Tag for Clothes
                  <span class="cursor-pointer text-gray-500">×</span>
                </span>
                <span
                  class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full"
                >
                  Tag for Clothes Size
                  <span class="cursor-pointer text-gray-500">×</span>
                </span>
              </div>

              <!-- ==================== Brand Accordion ==================== -->
              <div class="accordion-wrapper active">
                <div class="flex justify-between items-center cursor-pointer">
                  <h3 class="font-semibold text-gray-900">Brand</h3>
                  <svg
                    class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </div>

                <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

                <div class="accordion-content-block">
                  <div class="space-y-2 text-sm mt-4">
                    <label class="flex items-center gap-2">
                      <input type="checkbox" checked class="accent-gray-800" />
                      Tokyo Talkies <span class="text-gray-500">(206)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Roadster <span class="text-gray-500">(26)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Here&amp;Now <span class="text-gray-500">(706)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      High Star <span class="text-gray-500">(64)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" checked class="accent-gray-800" />
                      Miss Chase <span class="text-gray-500">(16)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Vovati <span class="text-gray-500">(20)</span>
                    </label>
                  </div>

                  <button class="text-sm text-blue-600 hover:underline mt-3">
                    + 40 more
                  </button>
                </div>
              </div>

              <!-- ==================== Price Accordion ==================== -->
              <div class="accordion-wrapper">
                <div class="flex justify-between items-center cursor-pointer">
                  <h3 class="font-semibold text-gray-900">Price</h3>
                  <svg
                    class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </div>

                <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

                <div class="accordion-content-block">
                  <div class="space-y-2 text-sm mt-4">
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Rs 350 to Rs 500 <span class="text-gray-500">(206)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" checked class="accent-gray-800" />
                      Rs 500 to Rs 700 <span class="text-gray-500">(100)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Rs 700 to Rs 900 <span class="text-gray-500">(206)</span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- ==================== Color Accordion ==================== -->
              <div class="accordion-wrapper">
                <div class="flex justify-between items-center cursor-pointer">
                  <h3 class="font-semibold text-gray-900">Color</h3>
                  <svg
                    class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </div>

                <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

                <div class="accordion-content-block">
                  <div class="space-y-2 text-sm mt-4">
                    <label class="flex items-center gap-2">
                      <input type="checkbox" checked class="accent-gray-800" />
                      Blue <span class="text-gray-500">(206)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      Black <span class="text-gray-500">(206)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      White <span class="text-gray-500">(206)</span>
                    </label>
                  </div>

                  <button class="text-sm text-blue-600 hover:underline mt-3">
                    + 40 more
                  </button>
                </div>
              </div>

              <!-- ==================== Discount Accordion ==================== -->
              <div class="accordion-wrapper">
                <div class="flex justify-between items-center cursor-pointer">
                  <h3 class="font-semibold text-gray-900">Discount Range</h3>
                  <svg
                    class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </div>

                <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

                <div class="accordion-content-block">
                  <div class="space-y-2 text-sm mt-4">
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      10% and above <span class="text-gray-500">(26)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      20% and above <span class="text-gray-500">(62)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      30% and above <span class="text-gray-500">(20)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      40% and above <span class="text-gray-500">(106)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" checked class="accent-gray-800" />
                      50% and above <span class="text-gray-500">(32)</span>
                    </label>
                    <label class="flex items-center gap-2">
                      <input type="checkbox" class="accent-gray-800" />
                      60% and above <span class="text-gray-500">(46)</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="w-full grid xl:grid-cols-4 lg:grid-cols-3 lgg:grid-cols-2 smui:grid-cols-3 xxs:grid-cols-2 grid-cols-1 m gap-4"
          >
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-8.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-9.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-10.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-11.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-12.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-13.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-14.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-15.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-16.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="./assets/images/Home-image/pic-17.avif"
                  alt="Silver Lehenga"
                  class="w-full h-[340px] object-cover object-top object-center"
                />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    Trending
                  </span>
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded"
                  >
                    -17%
                  </span>
                </div>

                <!-- Wishlist Heart Icon (Top Right) -->
                <button
                  class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-5 h-5 text-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                  </svg>
                </button>

                <!-- Add To Cart (Hidden → Hover Show) -->
                <div
                  class="lgg:block hidden absolute bottom-0 w-full px-3 py-4 bg-white/45 backdrop-blur-[2px] opacity-100 translate-y-0 lg:opacity-0 lg:translate-y-4 lg:group-hover:opacity-100 lg:group-hover:translate-y-0 transition-all duration-300 ease-out"
                >
                  <button
                    class="bg-white border w-full border-secondary text-black text-xs sm:text-sm font-medium px-4 py-2 rounded-lg hover:bg-secondary-light transition-colors"
                  >
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
                  <span class="text-sm text-gray-400 line-through"
                    >Rs. 1000</span
                  >
                </div>
                <div class="lgg:hidden block">
                  <button
                    class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Overlay - only visible on mobile when sidebar is open -->
    </section>
    <div
      id="filter-overlay"
      class="fixed inset-0 bg-black bg-opacity-50 z-[20002] lg:hidden hidden"
    ></div>



<script src="<?php echo e(asset('web/js/multi-product.js')); ?>"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.web.main-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\aiman-royal\aiman-royale\resources\views/web/multi-product.blade.php ENDPATH**/ ?>