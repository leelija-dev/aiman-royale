@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
  <div class="container mx-auto">
    <div class="mb-4 flex flex-row lgg:justify-end justify-between gap-3 flex-wrap">
      <!-- Mobile Filter Button -->
      <button
        id="open-filter"
        type="button"
        class="lgg:hidden flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-700 text-sm font-medium shadow-sm transition-all duration-300 hover:bg-gray-100 hover:shadow-md active:scale-95">
        <!-- Filter Icon -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-4 h-4 text-gray-600"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
        Filter
      </button>

      <!-- Desktop Filter Dropdowns Container -->
      <div class="flex flex-row gap-3 flex-wrap">
        <!-- Filter Dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            id="filter-dropdown-button"
            class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
            aria-haspopup="true"
            aria-expanded="false">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            <span id="filter-label">Filter</span>
            <svg
              id="filter-chevron"
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <div
            id="filter-menu"
            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="filter-dropdown-button">
            <div class="py-2" role="none">
              <button
                type="button"
                class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="featured"
                role="menuitem">
                <span>Featured</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="best-seller"
                role="menuitem">
                <span>Best Seller</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                data-value="new-arrival"
                role="menuitem">
                <span>New Arrival</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-100 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="top-rated"
                role="menuitem">
                <span>Top Rated</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Occasion Dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            id="occasion-dropdown-button"
            class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
            aria-haspopup="true"
            aria-expanded="false">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span id="occasion-label">Occasion</span>
            <svg
              id="occasion-chevron"
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <div
            id="occasion-menu"
            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="occasion-dropdown-button">
            <div class="py-2" role="none">
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="casual"
                role="menuitem">
                <span>Casual</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="formal"
                role="menuitem">
                <span>Formal</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="party"
                role="menuitem">
                <span>Party</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                data-value="all"
                role="menuitem">
                <span>All Occasions</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-100 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="wedding"
                role="menuitem">
                <span>Wedding</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="sports"
                role="menuitem">
                <span>Sports</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Collection Dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            id="collection-dropdown-button"
            class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
            aria-haspopup="true"
            aria-expanded="false">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span id="collection-label">Collection</span>
            <svg
              id="collection-chevron"
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <div
            id="collection-menu"
            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="collection-dropdown-button">
            <div class="py-2" role="none">
              <button
                type="button"
                class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="spring-2024"
                role="menuitem">
                <span>Spring 2024</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="summer-essentials"
                role="menuitem">
                <span>Summer Essentials</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                data-value="all"
                role="menuitem">
                <span>All Collections</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-100 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="limited-edition"
                role="menuitem">
                <span>Limited Edition</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="winter-collection"
                role="menuitem">
                <span>Winter Collection</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Professional Sort Dropdown (Existing) -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            id="sort-button"
            class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
            aria-haspopup="true"
            aria-expanded="false">
            <!-- Sort Icon -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4 text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3 7h14M3 12h10M3 17h6M17 7l3 3m0 0l-3 3m3-3H10" />
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
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div
            id="sort-menu"
            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="sort-button">
            <div class="py-2" role="none">
              <!-- Menu Items -->
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="name-asc"
                role="menuitem">
                <span>Name (A to Z)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="name-desc"
                role="menuitem">
                <span>Name (Z to A)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                data-value="date-desc"
                role="menuitem">
                <span>Date (Newest first)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-100 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="date-asc"
                role="menuitem">
                <span>Date (Oldest first)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="price-asc"
                role="menuitem">
                <span>Price (Low to High)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button
                type="button"
                class="sort-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="price-desc"
                role="menuitem">
                <span>Price (High to Low)</span>
                <svg
                  class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-row gap-3 relative">
      <div
        id="filter-sidebar"
        class="lgg:sticky fixed lgg:top-0 lgg:left-0 top-0 left-0 lgg:max-w-[300px] max-w-[260px] lgg:h-fit h-full lgg:max-h-max max-h-screen w-full bg-white rounded-xl shadow-md py-5 px-2 z-[20003] transition-all duration-300 ease-in-out">
        <form id="filter-form" method="GET" action="{{ route('page.multi-product') }}">
          @csrf
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
              class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full">
              Tag for Brand
              <span class="cursor-pointer text-gray-500">×</span>
            </span>
            <span
              class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full">
              Tag for Clothes
              <span class="cursor-pointer text-gray-500">×</span>
            </span>
            <span
              class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full">
              Tag for Clothes Size
              <span class="cursor-pointer text-gray-500">×</span>
            </span>
          </div>

          <!-- ==================== Brand Accordion ==================== -->
          <div class="accordion-wrapper active">
            <div class="flex justify-between items-center cursor-pointer">
              <h3 class="font-semibold text-gray-900">Category</h3>
              <svg
                class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                {{-- @dd($filterOptions['sizes']) --}}
                @foreach($filterOptions['categories'] as $category)
                  <label class="flex items-center gap-2">
                    <input type="checkbox" 
                           name="category[]" 
                           value="{{ $category }}" 
                           class="accent-gray-800 filter-checkbox"
                           @if(in_array($category, $selectedFilters['categories'] ?? [])) checked @endif>
                    {{ ucfirst($category) }} <span class="text-gray-500"></span> {{--({{ DB::table('products')->where('brand', $category)->where('is_active', 1)->count() }})</span> --}}
                  </label>
                @endforeach
              </div>

              {{-- <button class="text-sm text-blue-600 hover:underline mt-3">
                + 40 more
              </button> --}}
            </div>
          </div>

          <!-- ==================== Occasion Accordion ==================== -->
          <div class="accordion-wrapper">
            <div class="flex justify-between items-center cursor-pointer">
              <h3 class="font-semibold text-gray-900">Occasion</h3>
              <svg
                class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                @foreach($filterOptions['occasions'] as $occasion)
                <label class="flex items-center gap-2">
                  <input type="checkbox"
                      name="occasions[]"
                      value="{{ $occasion}}"
                      class="accent-gray-800 filter-checkbox"
                      @if(in_array($occasion, $selectedFilters['occasions'] ?? [])) checked @endif>

                {{ $occasion}}<span class="text-gray-500"></span>
                </label>
                @endforeach
                {{-- <label class="flex items-center gap-2">
                  <input type="checkbox" name="price[]" value="500" checked class="accent-gray-800" >
                  Rs 500 to Rs 700 <span class="text-gray-500">(100)</span>
                </label>
                <label class="flex items-center gap-2">
                  <input type="checkbox" name="price[]" value="700" class="accent-gray-800" >
                  Rs 700 to Rs 900 <span class="text-gray-500">(206)</span>
                </label> --}}
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
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                @foreach($filterOptions['colors'] as $color)
                  <label class="flex items-center gap-2">
                    <input type="checkbox" 
                           name="colors[]" 
                           value="{{ $color }}" 
                           class="accent-gray-800 filter-checkbox"
                           @if(in_array($color, $selectedFilters['colors'] ?? [])) checked @endif>
                    {{ ucfirst($color) }} <span class="text-gray-500">({{ DB::table('product_variants')->where('color', $color)->count() }})</span>
                  </label>
                @endforeach
              </div>
            </div>
          </div>

          <!-- ==================== Discount Accordion ================= -->
          {{-- <div class="accordion-wrapper">
            <div class="flex justify-between items-center cursor-pointer">
              <h3 class="font-semibold text-gray-900">Discount Range</h3>
              <svg
                class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                <label class="flex items-center gap-2">
                  <input type="checkbox" 
                         name="discount_ranges[]" 
                         value="10+" 
                         class="accent-gray-800 filter-checkbox"
                         @if(in_array('10+', request('discount_ranges', []))) checked @endif>
                  10% and above <span class="text-gray-500">({{ DB::table('product_variants')->where('discount_price', '>', 0)->whereRaw('((price - discount_price) / price * 100) >= 10')->count() }})</span>
                </label>
                <label class="flex items-center gap-2">
                  <input type="checkbox" 
                         name="discount_ranges[]" 
                         value="20+" 
                         class="accent-gray-800 filter-checkbox"
                         @if(in_array('20+', request('discount_ranges', []))) checked @endif>
                  20% and above <span class="text-gray-500">({{ DB::table('product_variants')->where('discount_price', '>', 0)->whereRaw('((price - discount_price) / price * 100) >= 20')->count() }})</span>
                </label>
                <label class="flex items-center gap-2">
                  <input type="checkbox" 
                         name="discount_ranges[]" 
                         value="30+" 
                         class="accent-gray-800 filter-checkbox"
                         @if(in_array('30+', request('discount_ranges', []))) checked @endif>
                  30% and above <span class="text-gray-500">({{ DB::table('product_variants')->where('discount_price', '>', 0)->whereRaw('((price - discount_price) / price * 100) >= 30')->count() }})</span>
                </label>
                <label class="flex items-center gap-2">
                  <input type="checkbox" 
                         name="discount_ranges[]" 
                         value="50+" 
                         class="accent-gray-800 filter-checkbox"
                         @if(in_array('50+', request('discount_ranges', []))) checked @endif>
                  50% and above <span class="text-gray-500">({{ DB::table('product_variants')->where('discount_price', '>', 0)->whereRaw('((price - discount_price) / price * 100) >= 50')->count() }})</span>
                </label>
              </div>
            </div>
          </div> --}}

          <!-- ==================== Size Accordion ================= -->
          <div class="accordion-wrapper">
            <div class="flex justify-between items-center cursor-pointer">
              <h3 class="font-semibold text-gray-900">Size</h3>
              <svg
                class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                @foreach($filterOptions['sizes'] as $size)
                  <label class="flex items-center gap-2">
                    <input type="checkbox" 
                           name="sizes[]" 
                           value="{{ $size }}" 
                           class="accent-gray-800 filter-checkbox"
                           @if(in_array($size, $selectedFilters['sizes'] ?? [])) checked @endif>
                    {{ strtoupper($size) }} <span class="text-gray-500">({{ DB::table('product_variants')->where('size', $size)->count() }})</span>
                  </label>
                @endforeach
              </div>
            </div>
          </div>

           {{-- Price Range Accordion --}}
           <div class="accordion-wrapper">
            <div class="flex justify-between items-center cursor-pointer">
              <h3 class="font-semibold text-gray-900">Price</h3>
              <svg
                class="w-5 h-5 text-gray-600 accordion-chevron transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </div>

            <div class="line-border-block bg-gray-300 h-0.5 mt-3"></div>

            <div class="accordion-content-block">
              <div class="space-y-2 text-sm mt-4">
                <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="0-200" class="accent-gray-800 filter-checkbox"
                    @if(in_array('0-200', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                    Below < {{config('app.currency')}}200
                </label>
                 <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="200-300" class="accent-gray-800 filter-checkbox"
                    @if(in_array('200-300', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                    {{config('app.currency')}}200 - {{config('app.currency')}}300
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="300-400" class="accent-gray-800 filter-checkbox"
                    @if(in_array('300-400', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                    {{config('app.currency')}}300 - {{config('app.currency')}}400
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="400-500" class="accent-gray-800 filter-checkbox"
                    @if(in_array('400-500', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                    {{config('app.currency')}}400 - {{config('app.currency')}}500
                </label>
               <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="500-600" class="accent-gray-800 filter-checkbox"
                    @if(in_array('500-600', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                    {{config('app.currency')}}500 - {{config('app.currency')}}600
                </label>
                <label class="flex items-center gap-2">
                <input type="checkbox" name="price_ranges[]" value="600-5000" class="accent-gray-800 filter-checkbox"
                    @if(in_array('600-5000', $selectedFilters['price_ranges'] ?? [])) checked @endif>
                   {{config('app.currency')}}600  < Above 
                </label>
                   
                
              </div>
            </div>
          </div>

          
        </div>
        </form>
      </div>
      <div
        class="w-full grid xl:grid-cols-4 lg:grid-cols-3 lgg:grid-cols-2 smui:grid-cols-3 xxs:grid-cols-2 grid-cols-1 m gap-4">

        @if($products->count() > 0)
          @foreach($products as $product)
          <div class="item flex justify-center items-center">
            <a href="/products/{{ $product['slug'] }}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card">
              <!-- Image Wrapper -->
              <div class="relative rounded-xl overflow-hidden">
                <img
                  src="{{ !empty($product['images']) ? asset($product['images'][0]) : asset('assets/images/placeholder.jpg') }}"
                  alt="{{ $product['name'] }}"
                  class="w-full h-[340px] object-cover object-top object-center" />

                <!-- Badges -->
                <div class="absolute top-3 left-3 flex flex-col gap-2">
                  <span
                    class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                    Trending
                  </span>
                  @if($product['discount_price'] && $product['discount_price'] < $product['price'])
                  <span
                    class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                    {{-- {{$product['discount']}} --}}
                    -{{ round((($product['price'] - $product['discount_price']) / $product['price']) * 100) }}%
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

            </div>

            <!-- Content -->
            <div class="p-4 space-y-1">
              <h3 class="text-[15px] font-semibold text-gray-900">
                {{ $product['name'] }}
              </h3>

              <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>{{ $product['brand'] ?? 'Brand Name' }}</span>
                <span class="flex items-center gap-1 text-gray-700">
                  <span class="text-sm font-medium">4.4</span>
                </span>
              </div>

              <div class="flex items-center gap-2 mt-2 flex-wrap">
                @php
                $firstVariant = reset($product['variants']);
                $displayPrice = $firstVariant['price_after_discount'] ?? $firstVariant['price'] ?? $product['price'];
                $originalPrice = $firstVariant['price'] ?? $product['price'];
                @endphp
                <span class="text-lg font-bold text-gray-900">Rs. {{ number_format($displayPrice, 2) }}</span>
                @if($firstVariant['price_after_discount'] && $firstVariant['price_after_discount'] < $originalPrice)
                <span class="text-sm text-gray-400 line-through">Rs. {{ number_format($originalPrice, 2) }}</span>
                @endif
              </div>
              
              <div class="lgg:hidden block">
                <button
                  class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">
                  Add
                </button>
              </div>
            </div>
          </a>
        </div>
        @endforeach
        @else
        <!-- No Products Found Message -->
        <div class="col-span-full flex flex-col items-center justify-center py-16">
          <div class="text-center">
            <div class="mb-4">
              <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No product found</h3>
            <p class="text-gray-600 mb-6">
              @if(request('search'))
                We couldn't find any products matching "{{ request('search') }}".
              @else
                We couldn't find any products matching your criteria.
              @endif
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
              <a href="{{ route('page.multi-product') }}" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                View All Products
              </a>
              <button onclick="clearFilters()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Clear Filters
              </button>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
  <!-- Overlay - only visible on mobile when sidebar is open -->
</section>
<div
  id="filter-overlay"
  class="fixed inset-0 bg-black bg-opacity-50 z-[20002] lg:hidden hidden"></div>

<script src="{{asset('web/js/multi-product.js')}}"></script>


@endsection