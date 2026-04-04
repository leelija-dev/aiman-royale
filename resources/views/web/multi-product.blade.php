@extends('layout.web.main-layout')

@section('content')

<style>
    /* MAIN CONTAINER — proper grid, no flex override issues */
        .products-container {
            width: 100%;
            /* max-width: 1600px; */
            margin: 0 auto;
            display: grid;
            /* Responsive columns: consistent card widths, no flex-wrap quirks */
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem; /* 24px gap consistent */
        }

        /* CARD — each card has identical structure & fixed ratio behavior */
        .product-card {
            width: 100%;
            background: white;
            border-radius: 1rem; /* rounded-xl */
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .product-card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            transform: translateY(-2px);
        }

        /* IMAGE WRAPPER — enforces consistent aspect ratio (4/6) regardless of screen */
        .image-wrapper {
            position: relative;
            width: 100%;
            /* ASPECT RATIO 4:6 → same as original (4/6 = 0.666) -> height = width * 1.5 */
            /* Using aspect-ratio property guarantees same ratio on every screen size */
            aspect-ratio: 4 / 6;
            background-color: #f3f4f6; /* gray-100 */
            overflow: hidden;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        /* IMAGE styling — object-contain preserves full image visibility, object-top aligns nicely */
        .product-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: top center;
            display: block;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.02);
        }

        /* BADGES (discount) */
        .badge-container {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 2;
        }

        .discount-badge {
            background-color: #dc2626; /* primary red-like but modern */
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            letter-spacing: 0.3px;
        }

        /* WISHLIST BUTTON */
        .wishlist-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(2px);
            border-radius: 9999px;
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            z-index: 3;
        }

        .wishlist-btn:hover {
            background-color: white;
            transform: scale(1.1);
        }

        .wishlist-btn i {
            font-size: 1rem;
            color: #1f2937;
            transition: color 0.2s;
        }

        .wishlist-btn:hover i {
            color: #ef4444;
        }

        /* CONTENT AREA */
        .card-content {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            flex: 1;
        }

        .product-title {
            font-size: 0.9375rem; /* 15px */
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .brand-text {
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        .price-row {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.25rem;
        }

        .current-price {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
        }

        .old-price {
            font-size: 0.875rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        /* Fix for any anchor interference */
        a.wishlist-link {
            text-decoration: none;
            display: flex;
        }

        /* MEDIA QUERIES: grid adjusts column count automatically,
           but card ratio remains identical due to aspect-ratio on wrapper */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            .products-container {
                gap: 1rem;
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            .card-content {
                padding: 0.75rem;
            }
            .product-title {
                font-size: 0.85rem;
            }
            .current-price {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .products-container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 0.875rem;
            }
        }

        /* For very large screens, cards won't stretch beyond comfortable size,
           but each card's image ratio stays locked. No height distortion */
        @media (min-width: 1680px) {
            .products-container {
                grid-template-columns: repeat(5, minmax(180px, 1fr));
            }
        }
        
        /* keep hover transition consistent */
        .product-card {
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
</style>
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
  <div class="container mx-auto">
    <div class="mb-4 flex flex-row lgg:justify-end justify-between gap-3 flex-wrap">
      <!-- Mobile Filter Button -->
      <button
        id="open-filter"
        type="button"
        class="lgg:hidden flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-700 text-sm font-medium shadow-sm transition-all duration-300 hover:bg-gray-100 hover:shadow-md active:scale-95">
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
                  class="w-4 h-4 text-blue-600  checkmark"
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
              @foreach($filterOptions['occasions'] as $occasion)
              <button
                type="button"
                class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                data-value="{{ $occasion }}"
                role="menuitem">
                <span>{{ $occasion }}</span>
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
              @endforeach
              {{--
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
                  class="w-4 h-4 text-blue-600  checkmark"
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
              --}}
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
                  class="w-4 h-4 text-blue-600  checkmark"
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

        <!-- Professional Sort Dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            id="sort-button"
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
                d="M3 7h14M3 12h10M3 17h6M17 7l3 3m0 0l-3 3m3-3H10" />
            </svg>
            <span id="sort-label">Sort by</span>
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

          <div
            id="sort-menu"
            class="absolute right-0 z-20 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="sort-button">
            <div class="py-2" role="none">
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
                  class="w-4 h-4 text-blue-600  checkmark"
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
      <!-- Filter Sidebar -->
      <div
        id="filter-sidebar"
        class="lgg:sticky fixed lgg:top-0 lgg:left-0 top-0 left-0 lgg:max-w-[300px] lgg:min-w-[300px] max-w-[260px] lgg:h-fit h-full lgg:max-h-max max-h-screen w-full bg-white rounded-xl shadow-md py-5 px-2 z-[20003] transition-all duration-300 ease-in-out">
        <form id="filter-form">
          @csrf
          <div class="space-y-6 h-full overflow-auto px-2">
            <!-- Header -->
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
              <button type="button" id="clear-all-filters" class="text-sm text-blue-600 hover:underline">
                Clear all
              </button>
            </div>

            <!-- Selected Tags Container -->
            <div id="selected-tags-container" class="flex flex-wrap gap-2">
              <!-- Selected tags will be dynamically added here -->
            </div>

            <!-- Category Accordion -->
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
                  @foreach($filterOptions['categories'] as $category)
                  <label class="flex items-center gap-2">
                    <input type="checkbox"
                      name="category[]"
                      value="{{ $category }}"
                      class="accent-gray-800 filter-checkbox">
                    {{ ucfirst($category) }}
                  </label>
                  @endforeach
                </div>
              </div>
            </div>

            <!-- Occasion Accordion -->
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
                      class="accent-gray-800 filter-checkbox">
                    {{ $occasion }}
                  </label>
                  @endforeach
                </div>
              </div>
            </div>

            <!-- Color Accordion -->
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
                      class="accent-gray-800 filter-checkbox">
                    {{ ucfirst($color) }}
                  </label>
                  @endforeach
                </div>
              </div>
            </div>

            <!-- Size Accordion -->
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
                      class="accent-gray-800 filter-checkbox">
                    {{ strtoupper($size) }}
                  </label>
                  @endforeach
                </div>
              </div>
            </div>

            <!-- Price Range Accordion -->
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
                    <input type="checkbox" name="price_ranges[]" value="0-200" class="accent-gray-800 filter-checkbox">
                    Below {{config('app.currency')}}200
                  </label>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" name="price_ranges[]" value="200-300" class="accent-gray-800 filter-checkbox">
                    {{config('app.currency')}}200 - {{config('app.currency')}}300
                  </label>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" name="price_ranges[]" value="300-400" class="accent-gray-800 filter-checkbox">
                    {{config('app.currency')}}300 - {{config('app.currency')}}400
                  </label>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" name="price_ranges[]" value="400-500" class="accent-gray-800 filter-checkbox">
                    {{config('app.currency')}}400 - {{config('app.currency')}}500
                  </label>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" name="price_ranges[]" value="500-600" class="accent-gray-800 filter-checkbox">
                    {{config('app.currency')}}500 - {{config('app.currency')}}600
                  </label>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" name="price_ranges[]" value="600-5000" class="accent-gray-800 filter-checkbox">
                    {{config('app.currency')}}600 & Above
                  </label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Products Grid Container -->
    <div class="w-full">
       <div id="products-container" class="products-container">
        @include('web.partials.product-grid', ['products' => $products])
      </div>

    </div>
    </div>
  </div>
</section>

<!-- Overlay -->
<div id="filter-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[20002] lg:hidden hidden"></div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
  <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
</div>

<script src="{{asset('web/js/multi-product.js')}}"></script>
@endsection