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
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 1.5rem;
        /* 24px gap consistent */
    }

    /* CARD — each card has identical structure & fixed ratio behavior */
    .product-card {
        width: 100%;
        background: white;
        border-radius: 1rem;
        /* rounded-xl */
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
        background-color: #f3f4f6;
        /* gray-100 */
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
        background-color: #dc2626;
        /* primary red-like but modern */
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        font-size: 0.9375rem;
        /* 15px */
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
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
            grid-template-columns: repeat(4, minmax(180px, 1fr));
        }
    }

    /* keep hover transition consistent */
    .product-card {
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
</style>
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
 <div class="container mx-auto">
       
        <div class="mb-[0px] flex items-center justify-between gap-3 px-4 lgg:px-6 lgg:hidden ">

            <!-- Mobile Filter Button -->
            <button
                id="open-filter"
                type="button"
                class=" inline-flex items-center gap-2 rounded-[40px] border border-gray-200 bg-white py-[9px] px-[14px] text-sm font-semibold text-gray-700 shadow-sm transition-all duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#A10000] hover:shadow-md active:scale-95">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>

                <span>Filters</span>
            </button>

            <!-- Sort / Accordion Button -->
            <button
                id="accordion-trigger-1"
                class="accordion-trigger flex items-center gap-2 rounded-[40px] border border-gray-200 bg-white py-[9px] px-[14px] text-sm font-semibold text-gray-700 shadow-sm transition-all duration-300 hover:border-red-200 hover:bg-red-50 hover:text-[#A10000] hover:shadow-md"
                data-target="panel1">

                <span>Sort Types</span>

                <svg class="icon-chevron h-5 w-5 transition-transform duration-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

        </div>

        <div id="custom-unique-accordian" class="lgg:px-6 px-4">
            <!-- Accordion Item 1 -->
            <div class="">
                <div id="panel1" class="accordion-panel py-0 px-1 text-gray-600">
                    <div class=" py-3">
                        <div class="flex flex-row gap-3 flex-wrap lgg:justify-end items-center justify-center">

                            <!-- Filter Dropdown -->
                            <div class="relative inline-block text-left">
                                <button type="button" id="filter-dropdown-button"
                                    class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    <span id="filter-label">Filter</span>
                                    <svg id="filter-chevron" xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="filter-menu"
                                    class="absolute lg:right-0 left-0 z-[201] mt-2 w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="filter-dropdown-button">
                                    <div class="py-2" role="none">
                                        <button type="button"
                                            class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                                            data-value="featured" role="menuitem">
                                            <span>Featured</span>
                                            <svg class="w-4 h-4 text-blue-600 opacity-0 checkmark" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                                            data-value="best-seller" role="menuitem">
                                            <span>Best Seller</span>
                                            <svg class="w-4 h-4 text-blue-600 opacity-0 checkmark" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                                            data-value="new-arrival" role="menuitem">
                                            <span>New Arrival</span>
                                            <svg class="w-4 h-4 text-blue-600  checkmark" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                                            data-value="top-rated" role="menuitem">
                                            <span>Top Rated</span>
                                            <svg class="w-4 h-4 text-blue-600 opacity-0 checkmark" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Occasion Dropdown -->
                            <div class="relative inline-block text-left">
                                <button type="button" id="occasion-dropdown-button"
                                    class="flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-300 bg-white text-gray-800 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 hover:border-gray-400 hover:shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:scale-95"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span id="occasion-label">Occasion</span>
                                    <svg id="occasion-chevron" xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-gray-600 ml-1 transition-transform duration-200" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="occasion-menu"
                                    class="absolute lgg:right-0 left-0 z-[201] mt-2 w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="occasion-dropdown-button">
                                    <div class="py-2" role="none">
                                        @if (isset($occasions) && $occasions->isNotEmpty())
                                        @foreach ($occasions as $occasion)
                                        <button type="button"
                                            class="occasion-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                                            data-value="{{ $occasion->id }}" role="menuitem">
                                            <span>{{ $occasion->name }}</span>
                                            <svg class="w-4 h-4 text-blue-600 opacity-0 checkmark"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        @endforeach
                                        @else
                                        <div class="px-4 py-2.5 text-sm text-gray-500">No occasions available</div>
                                        @endif
                                    </div>
                                </div>
                            </div>



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
                                    <span id="collection-label">
                                        @if(isset($category))
                                        {{ $category->name }}
                                        @else
                                        Collection
                                        @endif
                                    </span>
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
                                    class="absolute lgg:right-0 left-0 z-[201] mt-2 w-auto min-w-[200px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
                                    role="menu"
                                    aria-orientation="vertical"
                                    aria-labelledby="collection-dropdown-button">
                                    <div class="py-2" role="none">
                                        @if(isset($category))
                                        <button
                                            type="button"
                                            class="collection-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none active"
                                            data-value="{{ $category->slug }}"
                                            role="menuitem">
                                            <span>{{ $category->name }}</span>
                                            <svg
                                                class="w-4 h-4 text-blue-600 checkmark"
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
                                        @else
                                        <div class="px-4 py-2.5 text-sm text-gray-500">No collection available</div>
                                        @endif
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
                                    class="absolute right-0 z-[201] mt-2 w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
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
                </div>
            </div>


        </div>

        <style>
            .accordion-panel {
                max-height: 0;
                /* overflow: hidden; */
                transition: max-height 0.3s ease-out, opacity 0.3s ease-out, padding 0.3s ease-out;
                opacity: 0;
                padding: 0 4px;
            }

            .accordion-panel.open {
                max-height: 500px;
                /* Adjust based on content */
                opacity: 1;
                padding: 0px 4px;
            }

            .accordion-trigger .icon-chevron {
                transition: transform 0.3s ease-in-out;
            }

            .accordion-trigger.open .icon-chevron {
                transform: rotate(180deg);
            }

            #open-filter.active svg {
                transform: rotate(180deg);
            }
        </style>

        <script>
            (function() {
                const panel = document.getElementById("panel1");
                const trigger = document.getElementById("accordion-trigger-1");

                if (!panel || !trigger) {
                    console.error("Accordion elements not found");
                    return;
                }

                const DESKTOP_WIDTH = 992;

                function updateAccordionState() {
                    if (window.innerWidth >= DESKTOP_WIDTH) {
                        // Always open on desktop
                        panel.classList.add("open");
                        trigger.classList.add("open");
                    } else {
                        // Mobile starts closed (remove these two lines if you want to preserve state)
                        panel.classList.remove("open");
                        trigger.classList.remove("open");
                    }
                }

                window.toggleAccordion = function() {
                    // Disable accordion toggle on desktop
                    if (window.innerWidth >= DESKTOP_WIDTH) {
                        return;
                    }

                    const isOpen = panel.classList.contains("open");

                    if (isOpen) {
                        panel.classList.remove("open");
                        trigger.classList.remove("open");
                    } else {
                        panel.classList.add("open");
                        trigger.classList.add("open");

                        setTimeout(() => {
                            trigger.scrollIntoView({
                                behavior: "smooth",
                                block: "nearest",
                            });
                        }, 100);
                    }
                };

                trigger.addEventListener("click", function(e) {
                    e.preventDefault();
                    window.toggleAccordion();
                });

                // Set initial state
                updateAccordionState();

                // Update when resizing
                window.addEventListener("resize", updateAccordionState);
            })();
        </script>



    <div class="w-full">
        <div class="flex flex-row gap-3 relative">
            @if($category!=null)
            <!-- Filters Sidebar -->
            <div id="filter-sidebar"
                class="lgg:sticky fixed lgg:top-0 lgg:left-0 top-0 left-0 lgg:max-w-[300px] lgg:min-w-[300px] max-w-[260px] lgg:h-fit h-full lgg:max-h-max max-h-screen w-full bg-white rounded-xl shadow-md py-5 px-2 lg:z-[200] z-[20003] transition-all duration-300 ease-in-out">
                <button id="close-filter" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Filters</h2>

                    <!-- Occasion Filter -->
                    @if (isset($occasions) && $occasions->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Occasion</h3>
                        <div class="space-y-2">
                            @foreach ($occasions as $occasion)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="occasion[]" value="{{ $occasion->id }}"
                                    class="occasion-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox">
                                <span class="text-sm text-gray-700">{{ $occasion->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Custom Price Range Slider (Optional - can keep or remove) -->
                    {{-- <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Custom Price Range</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Rs. <span id="min-price-display">{{ number_format($priceRange['min']) }}</span></span>
                    <span class="text-sm text-gray-600">Rs. <span id="max-price-display">{{ number_format($priceRange['max']) }}</span></span>
                </div>
                <input
                    type="range"
                    id="min-price"
                    min="{{ $priceRange['min'] }}"
                    max="{{ $priceRange['max'] }}"
                    value="{{ $priceRange['min'] }}"
                    class="w-full accent-primary">
                <input
                    type="range"
                    id="max-price"
                    min="{{ $priceRange['min'] }}"
                    max="{{ $priceRange['max'] }}"
                    value="{{ $priceRange['max'] }}"
                    class="w-full accent-primary">
            </div>
        </div> --}}

        <!-- Size Filter -->
        @if (isset($sizes) && $sizes->isNotEmpty())
        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Size</h3>
            <div class="space-y-2">
                @foreach ($sizes as $size)
                @php
                $sizeId = is_object($size) ? $size->id : $size;
                $sizeName = is_object($size) ? $size->name : $size;
                $sizeCode = is_object($size) && isset($size->code) ? $size->code : '';
                $displayText = $sizeCode ? "$sizeCode" : $sizeName;
                @endphp
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="size[]" value="{{ $displayText }}"
                        class="size-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox">
                    <span class="text-sm text-gray-700">{{ $displayText }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Color Filter -->
        @if (isset($colors) && $colors->isNotEmpty())
        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Color</h3>
            <div class="space-y-2">
                @foreach ($colors as $color)
                @php
                $colorId = is_object($color) ? $color->id : $color;
                $colorName = is_object($color) ? $color->name : $color;
                @endphp
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="color[]" value="{{ $colorId }}"
                        class="color-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox">
                    <span class="text-sm text-gray-700">{{ $colorName }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endif


        <!-- Price Range Filter - Dynamic from Product Variants -->
        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Price</h3>
            <div class="space-y-2">
                @foreach ($priceRanges as $range)
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="price_range[]" value="{{ $range['value'] }}"
                        class="price-range-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox">
                    <span class="text-sm text-gray-700">{{ $range['label'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Active Filters Display -->
        <div id="active-filters" class="mb-4 hidden">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Active Filters:</h4>
            <div id="filter-tags" class="flex flex-wrap gap-2"></div>
        </div>

        <!-- Filter Actions -->
        <div class="flex gap-2 mt-4">
            <button id="clear-filters"
                class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                Clear Filters
            </button>
        </div>
    </div>
    </div>

    <!-- Products Grid -->
    <div class=" w-full">
        <!-- Category Header -->
        <div
            class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-gray-200/80 pb-4">
            <!-- Left: Title & Description -->
            <div class="flex-1 min-w-[200px]">
                <h1 class="text-h2-md md:text-h2-lg font-bold text-gray-900 tracking-tight">
                    {{ $category->title ?? ($category->name ?? 'Products') }}
                </h1>

                @if (isset($category->about))
                <p class="mt-1 text-p-sm text-gray-600 max-w-2xl leading-relaxed">
                    {{ $category->about }}
                </p>
                @endif
            </div>

            <!-- Right: Status Badge -->
            @if ($products->count() == 0)
            <div
                class="flex shrink-0 items-center gap-2 rounded-full bg-red-50 px-4 py-2 border border-red-200">
                <svg class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-sm font-medium text-primary">This style is not available right
                    now!</span>
            </div>
            @endif
        </div>

        <!-- Products Count -->
        {{-- <div id="products-count" class="mb-4 text-sm text-gray-600">
          Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
    </div> --}}

    <!-- Products Container -->
    <div id="products-container" class="products-container">
        @include('web.partials.category-grid', ['products' => $products])
    </div>

    <!-- Loading Spinner -->
    <div id="loading-spinner" class="hidden text-center py-8">
        <div
            class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent">
        </div>
    </div>

    <!-- Pagination -->
    @if ($products->hasPages())
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @endif
    </div>
    @else
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h1 class="text-2xl font-semibold mb-2">This style is not available right now!</h1>
        </div>
    </div>
    @endif
    </div>
    </div>
 </div>
</section>

<!-- Overlay -->
<div id="filter-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[20002] lg:hidden hidden"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // DOM Elements
        const filterButton = document.querySelector("#open-filter");
        const sideCloseButton = document.getElementById("close-filter");
        const sidebar = document.getElementById("filter-sidebar");
        const overlay = document.getElementById("filter-overlay");

        // State to track if sidebar is open on mobile
        let isSidebarOpen = false;

        // ──────────────────────────────────────────────
        //  Utility Functions
        // ──────────────────────────────────────────────
        function isMobile() {
            return window.innerWidth < 991;
        }

        sideCloseButton.addEventListener("click", function() {
            closeSidebar();
        });

        // ──────────────────────────────────────────────
        //  Mobile Sidebar Functions
        // ──────────────────────────────────────────────
        function openSidebar() {
            if (!isMobile()) return;
            sidebar.classList.remove("translate-x-[-150%]");
            sidebar.classList.add("translate-x-0");
            overlay.classList.remove("hidden");
            document.body.style.overflow = "hidden";
            isSidebarOpen = true;
        }

        function closeSidebar() {
            if (!isMobile()) return;
            sidebar.classList.remove("translate-x-0");
            sidebar.classList.add("translate-x-[-150%]");
            overlay.classList.add("hidden");
            document.body.style.overflow = "";
            isSidebarOpen = false;
        }

        // ──────────────────────────────────────────────
        //  Initialize Sidebar Position Based on Screen Size
        // ──────────────────────────────────────────────
        function initSidebarPosition() {
            if (isMobile()) {
                // On mobile: sidebar is fixed and hidden off-canvas
                sidebar.classList.add("fixed", "translate-x-[-150%]");
                sidebar.classList.remove("relative", "lgg:sticky", "translate-x-0");
                // Ensure it's closed when switching to mobile
                if (isSidebarOpen) {
                    closeSidebar();
                } else {
                    // Make sure it's in closed state
                    sidebar.classList.remove("translate-x-0");
                    sidebar.classList.add("translate-x-[-150%]");
                    overlay.classList.add("hidden");
                    document.body.style.overflow = "";
                }
            } else {
                // On desktop: sidebar is relative/sticky and always visible
                sidebar.classList.remove("fixed", "translate-x-[-150%]", "translate-x-0");
                sidebar.classList.add("relative", "lgg:sticky");
                overlay.classList.add("hidden");
                document.body.style.overflow = "";
                isSidebarOpen = false;
            }
        }

        // ──────────────────────────────────────────────
        //  Event Listeners
        // ──────────────────────────────────────────────
        if (filterButton) filterButton.addEventListener("click", openSidebar);
        if (overlay) overlay.addEventListener("click", closeSidebar);

        // Handle window resize
        window.addEventListener("resize", function() {
            initSidebarPosition();
        });

        // Initialize on page load
        initSidebarPosition();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize filters
        let currentFilters = {
            priceRanges: [],
            customPrice: {
                min: 0,
                max: 10000
            },
            sizes: [],
            colors: [],
            occasions: [],
            filter: 'new-arrival', // Default
            collection: '', // Will be set dynamically
            sort: 'date-desc' // Default
        };

        let filterTimeout;
        let isLoading = false;

        // DOM Elements
        const productsContainer = document.getElementById('products-container');
        const loadingSpinner = document.getElementById('loading-spinner');
        const productsCountDiv = document.getElementById('products-count');

        // Get category slug from the page
        const categorySlug = window.location.pathname.split('/').pop();

        // Track currently open dropdown
        let currentlyOpenDropdown = null;

        // ──────────────────────────────────────────────
        //  Dropdown Management Functions
        // ──────────────────────────────────────────────

        function closeAllDropdowns() {
            const dropdowns = ['filter-menu', 'occasion-menu', 'collection-menu', 'sort-menu'];
            const buttons = {
                'filter-menu': {
                    button: 'filter-dropdown-button',
                    chevron: 'filter-chevron'
                },
                'occasion-menu': {
                    button: 'occasion-dropdown-button',
                    chevron: 'occasion-chevron'
                },
                'collection-menu': {
                    button: 'collection-dropdown-button',
                    chevron: 'collection-chevron'
                },
                'sort-menu': {
                    button: 'sort-button',
                    chevron: 'chevron-icon'
                }
            };

            dropdowns.forEach(menuId => {
                const menu = document.getElementById(menuId);
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    const btnConfig = buttons[menuId];
                    if (btnConfig) {
                        const chevron = document.getElementById(btnConfig.chevron);
                        if (chevron) chevron.style.transform = 'rotate(0deg)';
                        const button = document.getElementById(btnConfig.button);
                        if (button) button.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            currentlyOpenDropdown = null;
        }

        function setupDropdownToggle(buttonId, menuId, chevronId) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);
            const chevron = document.getElementById(chevronId);

            if (!button || !menu || !chevron) return;

            button.addEventListener('click', function(e) {
                e.stopPropagation();

                // Close any other open dropdown
                closeAllDropdowns();

                // Toggle current dropdown
                const isHidden = menu.classList.contains('hidden');

                if (isHidden) {
                    menu.classList.remove('hidden');
                    chevron.style.transform = 'rotate(180deg)';
                    button.setAttribute('aria-expanded', 'true');
                    currentlyOpenDropdown = menuId;
                } else {
                    menu.classList.add('hidden');
                    chevron.style.transform = 'rotate(0deg)';
                    button.setAttribute('aria-expanded', 'false');
                    currentlyOpenDropdown = null;
                }
            });
        }

        // ──────────────────────────────────────────────
        //  Collection Dropdown Setup (Modified)
        // ──────────────────────────────────────────────

        function setupCollectionDropdown() {
            const collectionMenu = document.getElementById('collection-menu');
            const collectionButton = document.getElementById('collection-dropdown-button');
            const collectionChevron = document.getElementById('collection-chevron');
            const collectionLabel = document.getElementById('collection-label');

            // Get all collection options
            const collectionOptions = document.querySelectorAll('.collection-option');

            if (!collectionMenu || !collectionButton || !collectionChevron || !collectionLabel) {
                console.warn('Collection dropdown elements not found');
                return;
            }

            // Setup toggle
            setupDropdownToggle('collection-dropdown-button', 'collection-menu', 'collection-chevron');

            // Find default active option
            let defaultActive = false;
            collectionOptions.forEach(option => {
                if (option.classList.contains('active')) {
                    const value = option.getAttribute('data-value');
                    const text = option.querySelector('span').textContent;
                    currentFilters.collection = value;
                    collectionLabel.textContent = text;
                    defaultActive = true;
                }
            });

            // If no active option, set first one as default
            if (!defaultActive && collectionOptions.length > 0) {
                const firstOption = collectionOptions[0];
                firstOption.classList.add('active');
                const checkmark = firstOption.querySelector('.checkmark');
                if (checkmark) checkmark.style.opacity = '1';
                const value = firstOption.getAttribute('data-value');
                const text = firstOption.querySelector('span').textContent;
                currentFilters.collection = value;
                collectionLabel.textContent = text;
            }

            // Handle collection option clicks
            collectionOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span').textContent;

                    // Update active state
                    collectionOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });

                    this.classList.add('active');
                    const selectedCheckmark = this.querySelector('.checkmark');
                    if (selectedCheckmark) selectedCheckmark.style.opacity = '1';

                    // Update currentFilters
                    currentFilters.collection = value;
                    collectionLabel.textContent = text;

                    // Close dropdown
                    collectionMenu.classList.add('hidden');
                    collectionChevron.style.transform = 'rotate(0deg)';
                    collectionButton.setAttribute('aria-expanded', 'false');
                    currentlyOpenDropdown = null;

                    // Apply filter
                    applyFilters();
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Filter Dropdown Setup
        // ──────────────────────────────────────────────

        function setupFilterDropdown() {
            const filterMenu = document.getElementById('filter-menu');
            const filterButton = document.getElementById('filter-dropdown-button');
            const filterChevron = document.getElementById('filter-chevron');
            const filterLabel = document.getElementById('filter-label');
            const filterOptions = document.querySelectorAll('.filter-option');

            if (!filterMenu || !filterButton || !filterChevron || !filterLabel) return;

            // Setup toggle
            setupDropdownToggle('filter-dropdown-button', 'filter-menu', 'filter-chevron');

            // Find default active option
            let defaultActive = false;
            filterOptions.forEach(option => {
                if (option.classList.contains('active')) {
                    const value = option.getAttribute('data-value');
                    const text = option.querySelector('span').textContent;
                    currentFilters.filter = value;
                    filterLabel.textContent = text;
                    defaultActive = true;
                }
            });

            // If no active option, set default
            if (!defaultActive && filterOptions.length > 0) {
                const defaultOption = document.querySelector('.filter-option[data-value="new-arrival"]');
                if (defaultOption) {
                    defaultOption.classList.add('active');
                    const checkmark = defaultOption.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '1';
                    const text = defaultOption.querySelector('span').textContent;
                    currentFilters.filter = 'new-arrival';
                    filterLabel.textContent = text;
                }
            }

            // Handle filter option clicks
            filterOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span').textContent;

                    // Update active state
                    filterOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });

                    this.classList.add('active');
                    const selectedCheckmark = this.querySelector('.checkmark');
                    if (selectedCheckmark) selectedCheckmark.style.opacity = '1';

                    // Update currentFilters
                    currentFilters.filter = value;
                    filterLabel.textContent = text;

                    // Close dropdown
                    filterMenu.classList.add('hidden');
                    filterChevron.style.transform = 'rotate(0deg)';
                    filterButton.setAttribute('aria-expanded', 'false');
                    currentlyOpenDropdown = null;

                    // Apply filter
                    applyFilters();
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Occasion Dropdown Setup
        // ──────────────────────────────────────────────

        function setupOccasionDropdown() {
            const occasionMenu = document.getElementById('occasion-menu');
            const occasionButton = document.getElementById('occasion-dropdown-button');
            const occasionChevron = document.getElementById('occasion-chevron');
            const occasionLabel = document.getElementById('occasion-label');
            const occasionOptions = document.querySelectorAll('.occasion-option');

            if (!occasionMenu || !occasionButton || !occasionChevron || !occasionLabel) return;

            // Setup toggle
            setupDropdownToggle('occasion-dropdown-button', 'occasion-menu', 'occasion-chevron');

            // Handle occasion option clicks
            occasionOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span').textContent;

                    // Update active state
                    occasionOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });

                    this.classList.add('active');
                    const selectedCheckmark = this.querySelector('.checkmark');
                    if (selectedCheckmark) selectedCheckmark.style.opacity = '1';

                    // Update currentFilters
                    currentFilters.occasions = [value];
                    occasionLabel.textContent = text;

                    // Close dropdown
                    occasionMenu.classList.add('hidden');
                    occasionChevron.style.transform = 'rotate(0deg)';
                    occasionButton.setAttribute('aria-expanded', 'false');
                    currentlyOpenDropdown = null;

                    // Apply filter
                    applyFilters();
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Sort Dropdown Setup
        // ──────────────────────────────────────────────

        function setupSortDropdown() {
            const sortMenu = document.getElementById('sort-menu');
            const sortButton = document.getElementById('sort-button');
            const sortChevron = document.getElementById('chevron-icon');
            const sortLabel = document.getElementById('sort-label');
            const sortOptions = document.querySelectorAll('.sort-option');

            if (!sortMenu || !sortButton || !sortChevron || !sortLabel) return;

            // Setup toggle
            setupDropdownToggle('sort-button', 'sort-menu', 'chevron-icon');

            // Find default active option
            let defaultActive = false;
            sortOptions.forEach(option => {
                if (option.classList.contains('active')) {
                    const value = option.getAttribute('data-value');
                    const text = option.querySelector('span').textContent;
                    currentFilters.sort = value;
                    sortLabel.textContent = text;
                    defaultActive = true;
                }
            });

            // If no active option, set default
            if (!defaultActive && sortOptions.length > 0) {
                const defaultOption = document.querySelector('.sort-option[data-value="date-desc"]');
                if (defaultOption) {
                    defaultOption.classList.add('active');
                    const checkmark = defaultOption.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '1';
                    const text = defaultOption.querySelector('span').textContent;
                    currentFilters.sort = 'date-desc';
                    sortLabel.textContent = text;
                }
            }

            // Handle sort option clicks
            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span').textContent;

                    // Update active state
                    sortOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });

                    this.classList.add('active');
                    const selectedCheckmark = this.querySelector('.checkmark');
                    if (selectedCheckmark) selectedCheckmark.style.opacity = '1';

                    // Update currentFilters
                    currentFilters.sort = value;
                    sortLabel.textContent = text;

                    // Close dropdown
                    sortMenu.classList.add('hidden');
                    sortChevron.style.transform = 'rotate(0deg)';
                    sortButton.setAttribute('aria-expanded', 'false');
                    currentlyOpenDropdown = null;

                    // Apply filter
                    applyFilters();
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Collect Filters Function
        // ──────────────────────────────────────────────

        function collectFilters() {
            // Price ranges
            currentFilters.priceRanges = Array.from(document.querySelectorAll('.price-range-filter:checked')).map(cb => cb.value);

            // Sizes
            currentFilters.sizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb.value);

            // Colors
            currentFilters.colors = Array.from(document.querySelectorAll('.color-filter:checked')).map(cb => cb.value);

            // Occasions - check both dropdown and sidebar
            const dropdownOccasion = document.querySelector('.occasion-option.active');
            const sidebarOccasions = Array.from(document.querySelectorAll('.occasion-filter:checked')).map(cb => cb.value);

            if (dropdownOccasion) {
                currentFilters.occasions = [dropdownOccasion.getAttribute('data-value')];
            } else if (sidebarOccasions.length > 0) {
                currentFilters.occasions = sidebarOccasions;
            } else {
                currentFilters.occasions = [];
            }

            // Collection - get from dropdown
            const collectionOption = document.querySelector('.collection-option.active');
            if (collectionOption) {
                currentFilters.collection = collectionOption.getAttribute('data-value');
            }

            // Filter and Sort are already updated via dropdown clicks
        }

        // ──────────────────────────────────────────────
        //  Update Active Filters Display
        // ──────────────────────────────────────────────

        function updateActiveFiltersDisplay() {
            const activeFiltersDiv = document.getElementById('active-filters');
            const filterTagsDiv = document.getElementById('filter-tags');

            if (!activeFiltersDiv || !filterTagsDiv) return;

            const activeFilters = [];

            // Add collection filter
            const collectionOption = document.querySelector('.collection-option.active');
            if (collectionOption && collectionOption.getAttribute('data-value') !== 'all') {
                const text = collectionOption.querySelector('span').textContent;
                activeFilters.push({
                    type: 'collection',
                    text: `Collection: ${text}`,
                    value: collectionOption.getAttribute('data-value')
                });
            }

            // Add filter type
            const filterOption = document.querySelector('.filter-option.active');
            if (filterOption) {
                const text = filterOption.querySelector('span').textContent;
                if (text !== 'Filter') {
                    activeFilters.push({
                        type: 'filter',
                        text: text,
                        value: filterOption.getAttribute('data-value')
                    });
                }
            }

            // Add price range filters
            document.querySelectorAll('.price-range-filter:checked').forEach(cb => {
                const label = cb.closest('label').querySelector('span').textContent;
                activeFilters.push({
                    type: 'price',
                    text: label,
                    value: cb.value
                });
            });

            // Add size filters
            document.querySelectorAll('.size-filter:checked').forEach(cb => {
                const label = cb.closest('label').querySelector('span').textContent;
                activeFilters.push({
                    type: 'size',
                    text: label,
                    value: cb.value
                });
            });

            // Add color filters
            document.querySelectorAll('.color-filter:checked').forEach(cb => {
                const label = cb.closest('label').querySelector('span').textContent;
                activeFilters.push({
                    type: 'color',
                    text: label,
                    value: cb.value
                });
            });

            // Add occasion filters
            const occasionActive = document.querySelector('.occasion-option.active');
            if (occasionActive) {
                const text = occasionActive.querySelector('span').textContent;
                activeFilters.push({
                    type: 'occasion',
                    text: `Occasion: ${text}`,
                    value: occasionActive.getAttribute('data-value')
                });
            }

            document.querySelectorAll('.occasion-filter:checked').forEach(cb => {
                const label = cb.closest('label').querySelector('span').textContent;
                activeFilters.push({
                    type: 'occasion',
                    text: label,
                    value: cb.value
                });
            });

            if (activeFilters.length > 0) {
                activeFiltersDiv.classList.remove('hidden');
                filterTagsDiv.innerHTML = activeFilters.map(filter => `
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">
                        ${filter.text}
                        <button onclick="removeFilter('${filter.type}', '${filter.value || ''}')" class="hover:text-primary-dark">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                `).join('');
            } else {
                activeFiltersDiv.classList.add('hidden');
            }
        }

        // ──────────────────────────────────────────────
        //  Remove Filter
        // ──────────────────────────────────────────────

        window.removeFilter = function(type, value) {
            if (type === 'collection') {
                // Reset collection to default
                const collectionOptions = document.querySelectorAll('.collection-option');
                collectionOptions.forEach(opt => {
                    opt.classList.remove('active');
                    const checkmark = opt.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '0';
                });
                const defaultCollection = document.querySelector('.collection-option[data-value="all"]');
                if (defaultCollection) {
                    defaultCollection.classList.add('active');
                    const checkmark = defaultCollection.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '1';
                    currentFilters.collection = 'all';
                    document.getElementById('collection-label').textContent = 'Collection';
                }
            } else if (type === 'filter') {
                const filterOptions = document.querySelectorAll('.filter-option');
                filterOptions.forEach(opt => {
                    opt.classList.remove('active');
                    const checkmark = opt.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '0';
                });
                const defaultFilter = document.querySelector('.filter-option[data-value="new-arrival"]');
                if (defaultFilter) {
                    defaultFilter.classList.add('active');
                    const checkmark = defaultFilter.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '1';
                    currentFilters.filter = 'new-arrival';
                    document.getElementById('filter-label').textContent = 'Filter';
                }
            } else if (type === 'price' || type === 'custom-price') {
                if (type === 'custom-price') {
                    const minPriceInput = document.getElementById('min-price');
                    const maxPriceInput = document.getElementById('max-price');
                    if (minPriceInput && maxPriceInput) {
                        minPriceInput.value = 0;
                        maxPriceInput.value = 10000;
                        updatePriceDisplay();
                    }
                } else {
                    document.querySelectorAll(`.price-range-filter[value="${value}"]`).forEach(cb => cb.checked = false);
                }
            } else if (type === 'size') {
                document.querySelectorAll(`.size-filter[value="${value}"]`).forEach(cb => cb.checked = false);
            } else if (type === 'color') {
                document.querySelectorAll(`.color-filter[value="${value}"]`).forEach(cb => cb.checked = false);
            } else if (type === 'occasion') {
                document.querySelectorAll(`.occasion-filter[value="${value}"]`).forEach(cb => cb.checked = false);
                const occasionOptions = document.querySelectorAll('.occasion-option');
                occasionOptions.forEach(opt => {
                    opt.classList.remove('active');
                    const checkmark = opt.querySelector('.checkmark');
                    if (checkmark) checkmark.style.opacity = '0';
                });
                currentFilters.occasions = [];
                document.getElementById('occasion-label').textContent = 'Occasion';
            }

            applyFilters();
        };

        // ──────────────────────────────────────────────
        //  Price Display Functions
        // ──────────────────────────────────────────────

        function updatePriceDisplay() {
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');
            const minPriceDisplay = document.getElementById('min-price-display');
            const maxPriceDisplay = document.getElementById('max-price-display');

            if (minPriceDisplay && maxPriceDisplay && minPriceInput && maxPriceInput) {
                minPriceDisplay.textContent = Number(minPriceInput.value).toLocaleString();
                maxPriceDisplay.textContent = Number(maxPriceInput.value).toLocaleString();
                currentFilters.customPrice.min = parseInt(minPriceInput.value);
                currentFilters.customPrice.max = parseInt(maxPriceInput.value);
            }
        }

        // ──────────────────────────────────────────────
        //  Apply Filters
        // ──────────────────────────────────────────────

        async function applyFilters() {
            if (isLoading) return;

            collectFilters();
            updateActiveFiltersDisplay();

            // Show loading
            isLoading = true;
            if (loadingSpinner) loadingSpinner.classList.remove('hidden');
            if (productsContainer) productsContainer.style.opacity = '0.5';

            // Build query string
            const params = new URLSearchParams({
                price_ranges: JSON.stringify(currentFilters.priceRanges),
                custom_min_price: currentFilters.customPrice.min,
                custom_max_price: currentFilters.customPrice.max,
                sizes: JSON.stringify(currentFilters.sizes),
                colors: JSON.stringify(currentFilters.colors),
                occasions: JSON.stringify(currentFilters.occasions),
                filter: currentFilters.filter,
                collection: currentFilters.collection,
                sort: currentFilters.sort
            });
            console.log('Applying filters with params:', params.toString());
            try {
                const response = await fetch(`/category/${categorySlug}/filter?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success && productsContainer) {
                    productsContainer.innerHTML = data.html;

                    // Update products count
                    if (productsCountDiv) {
                        productsCountDiv.innerHTML = `Showing ${data.firstItem} - ${data.lastItem} of ${data.total} products`;
                    }

                    // Re-attach product card handlers
                    attachProductCardHandlers();
                } else {
                    console.error('Controller returned error:', data);
                }
            } catch (error) {
                console.error('Filter error:', error);
            } finally {
                isLoading = false;
                if (loadingSpinner) loadingSpinner.classList.add('hidden');
                if (productsContainer) productsContainer.style.opacity = '1';
            }
        }

        // ──────────────────────────────────────────────
        //  Attach Product Card Handlers
        // ──────────────────────────────────────────────

        function attachProductCardHandlers() {
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.closest('button') || e.target.closest('a')) {
                        return;
                    }
                    const productSlug = this.getAttribute('data-product-slug');
                    if (productSlug) {
                        window.location.href = `/products/${productSlug}`;
                    }
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Setup Filter Checkboxes
        // ──────────────────────────────────────────────

        function setupFilterCheckboxes() {
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    applyFilters();
                });
            });
        }

        // ──────────────────────────────────────────────
        //  Setup Clear Filters Button
        // ──────────────────────────────────────────────

        function setupClearFilters() {
            const clearFiltersBtn = document.getElementById('clear-filters');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function() {
                    // Uncheck all checkboxes
                    document.querySelectorAll('.price-range-filter, .size-filter, .color-filter, .occasion-filter').forEach(cb => {
                        cb.checked = false;
                    });

                    // Reset price ranges
                    const minPriceInput = document.getElementById('min-price');
                    const maxPriceInput = document.getElementById('max-price');
                    if (minPriceInput && maxPriceInput) {
                        minPriceInput.value = 0;
                        maxPriceInput.value = 10000;
                        updatePriceDisplay();
                    }

                    // Reset collection
                    const collectionOptions = document.querySelectorAll('.collection-option');
                    collectionOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });
                    const defaultCollection = document.querySelector('.collection-option[data-value="all"]');
                    if (defaultCollection) {
                        defaultCollection.classList.add('active');
                        const checkmark = defaultCollection.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '1';
                        currentFilters.collection = 'all';
                        document.getElementById('collection-label').textContent = 'Collection';
                    }

                    // Reset filter
                    const filterOptions = document.querySelectorAll('.filter-option');
                    filterOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });
                    const defaultFilter = document.querySelector('.filter-option[data-value="new-arrival"]');
                    if (defaultFilter) {
                        defaultFilter.classList.add('active');
                        const checkmark = defaultFilter.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '1';
                        currentFilters.filter = 'new-arrival';
                        document.getElementById('filter-label').textContent = 'Filter';
                    }

                    // Reset sort
                    const sortOptions = document.querySelectorAll('.sort-option');
                    sortOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });
                    const defaultSort = document.querySelector('.sort-option[data-value="date-desc"]');
                    if (defaultSort) {
                        defaultSort.classList.add('active');
                        const checkmark = defaultSort.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '1';
                        currentFilters.sort = 'date-desc';
                        document.getElementById('sort-label').textContent = 'Sort by';
                    }

                    // Reset occasion
                    const occasionOptions = document.querySelectorAll('.occasion-option');
                    occasionOptions.forEach(opt => {
                        opt.classList.remove('active');
                        const checkmark = opt.querySelector('.checkmark');
                        if (checkmark) checkmark.style.opacity = '0';
                    });
                    currentFilters.occasions = [];
                    document.getElementById('occasion-label').textContent = 'Occasion';

                    // Apply filters with cleared values
                    applyFilters();
                });
            }
        }

        // ──────────────────────────────────────────────
        //  Initialize All Dropdowns and Filters
        // ──────────────────────────────────────────────

        function init() {
            // Setup all dropdowns
            setupCollectionDropdown();
            setupFilterDropdown();
            setupOccasionDropdown();
            setupSortDropdown();

            // Setup filter checkboxes
            setupFilterCheckboxes();

            // Setup clear filters
            setupClearFilters();

            // Initial attachment of product card handlers
            attachProductCardHandlers();

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const isClickInsideDropdown = e.target.closest('.relative.inline-block.text-left');
                if (!isClickInsideDropdown) {
                    closeAllDropdowns();
                }
            });

            // Close dropdown on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllDropdowns();
                }
            });

            // Initial filter application
            applyFilters();
        }

        // Start the application
        init();
    });

    // Wishlist toggle function
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

                        // Hide badge when count is 0 (optional)
                        if (data.wishlist_count > 0) {
                            item.style.display = "flex";
                        } else {
                            item.style.display = "none";
                        }
                    });
                } else {
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

<!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize filters
            let currentFilters = {
                priceRanges: [],
                customPrice: {
                    min: 0,
                    max: 10000
                },
                sizes: [],
                colors: [],
                occasions: [],
                filter: '', // Add filter for best-seller, new-arrival, etc.
                collection: '', // Add collection filter
                sort: '' // Add sort filter
            };

            let filterTimeout;
            let isLoading = false;

            // DOM Elements
            const productsContainer = document.getElementById('products-container');
            const loadingSpinner = document.getElementById('loading-spinner');
            const productsCountDiv = document.getElementById('products-count');

            // Price range elements
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');
            const minPriceDisplay = document.getElementById('min-price-display');
            const maxPriceDisplay = document.getElementById('max-price-display');

            // Update price displays
            function updatePriceDisplay() {
                minPriceDisplay.textContent = Number(minPriceInput.value).toLocaleString();
                maxPriceDisplay.textContent = Number(maxPriceInput.value).toLocaleString();
                currentFilters.customPrice.min = parseInt(minPriceInput.value);
                currentFilters.customPrice.max = parseInt(maxPriceInput.value);
            }

            // Ensure min doesn't exceed max and vice versa
            if (minPriceInput && maxPriceInput) {
                minPriceInput.addEventListener('input', function() {
                    if (parseInt(this.value) > parseInt(maxPriceInput.value)) {
                        this.value = maxPriceInput.value;
                    }
                    updatePriceDisplay();
                    debouncedFilter();
                });

                maxPriceInput.addEventListener('input', function() {
                    if (parseInt(this.value) < parseInt(minPriceInput.value)) {
                        this.value = minPriceInput.value;
                    }
                    updatePriceDisplay();
                    debouncedFilter();
                });
            }

            // Collect filter values
            function collectFilters() {
                // Price ranges
                currentFilters.priceRanges = Array.from(document.querySelectorAll('.price-range-filter:checked'))
                    .map(cb => cb.value);

                // Sizes
                currentFilters.sizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb
                    .value);

                // Colors
                currentFilters.colors = Array.from(document.querySelectorAll('.color-filter:checked')).map(cb => cb
                    .value);

                // Occasions - check both dropdown and sidebar
                const dropdownOccasion = document.querySelector('.occasion-option.active');
                const sidebarOccasions = Array.from(document.querySelectorAll('.occasion-filter:checked')).map(cb =>
                    cb.value);

                console.log('=== COLLECT FILTERS ===');
                console.log('Dropdown occasion found:', dropdownOccasion ? dropdownOccasion.getAttribute(
                    'data-value') : 'none');
                console.log('Sidebar occasions found:', sidebarOccasions);

                if (dropdownOccasion) {
                    // Use dropdown selection if active
                    currentFilters.occasions = [dropdownOccasion.getAttribute('data-value')];
                    console.log('Using dropdown occasion:', currentFilters.occasions);
                } else {
                    // Use sidebar checkboxes if any are checked
                    currentFilters.occasions = sidebarOccasions;
                    console.log('Using sidebar occasions:', currentFilters.occasions);
                }

                console.log('Final occasions after collectFilters:', currentFilters.occasions);
            }

            // Convert price range to min/max values (now handles dynamic ranges)
            function getPriceRangeValues(range) {
                // Handle dynamic range format (min-max)
                if (range.includes('-')) {
                    const [min, max] = range.split('-').map(Number);
                    return {
                        min,
                        max
                    };
                }

                // Fallback for old hardcoded ranges
                switch (range) {
                    case 'below-200':
                        return {
                            min: 0, max: 200
                        };
                    case '200-300':
                        return {
                            min: 200, max: 300
                        };
                    case '300-400':
                        return {
                            min: 300, max: 400
                        };
                    case '400-500':
                        return {
                            min: 400, max: 500
                        };
                    case '500-600':
                        return {
                            min: 500, max: 600
                        };
                    case '600-above':
                        return {
                            min: 600, max: 999999
                        };
                    default:
                        return null;
                }
            }

            // Update active filters display
            function updateActiveFiltersDisplay() {
                const activeFiltersDiv = document.getElementById('active-filters');
                const filterTagsDiv = document.getElementById('filter-tags');

                const activeFilters = [];

                // Add price range filters
                document.querySelectorAll('.price-range-filter:checked').forEach(cb => {
                    const label = cb.closest('label').querySelector('span').textContent;
                    activeFilters.push({
                        type: 'price',
                        text: label,
                        value: cb.value
                    });
                });

                // Add custom price if different from default
                if (currentFilters.customPrice.min > 0 || currentFilters.customPrice.max < 10000) {
                    activeFilters.push({
                        type: 'custom-price',
                        text: `Rs. ${currentFilters.customPrice.min} - Rs. ${currentFilters.customPrice.max}`
                    });
                }

                // Add size filters
                document.querySelectorAll('.size-filter:checked').forEach(cb => {
                    const label = cb.closest('label').querySelector('span').textContent;
                    activeFilters.push({
                        type: 'size',
                        text: label,
                        value: cb.value
                    });
                });

                // Add color filters
                document.querySelectorAll('.color-filter:checked').forEach(cb => {
                    const label = cb.closest('label').querySelector('span').textContent;
                    activeFilters.push({
                        type: 'color',
                        text: label,
                        value: cb.value
                    });
                });

                // Add occasion filters
                document.querySelectorAll('.occasion-filter:checked').forEach(cb => {
                    const label = cb.closest('label').querySelector('span').textContent;
                    activeFilters.push({
                        type: 'occasion',
                        text: label,
                        value: cb.value
                    });
                });

                if (activeFilters.length > 0) {
                    activeFiltersDiv.classList.remove('hidden');
                    filterTagsDiv.innerHTML = activeFilters.map(filter => `
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">
                    ${filter.text}
                    <button onclick="removeFilter('${filter.type}', '${filter.value || ''}')" class="hover:text-primary-dark">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            `).join('');
                } else {
                    activeFiltersDiv.classList.add('hidden');
                }
            }

            // Remove individual filter
            window.removeFilter = function(type, value) {
                if (type === 'price' || type === 'custom-price') {
                    if (type === 'custom-price') {
                        if (minPriceInput && maxPriceInput) {
                            minPriceInput.value = 0;
                            maxPriceInput.value = 10000;
                            updatePriceDisplay();
                        }
                    } else {
                        document.querySelectorAll(`.price-range-filter[value="${value}"]`).forEach(cb => cb
                            .checked = false);
                    }
                } else if (type === 'size') {
                    document.querySelectorAll(`.size-filter[value="${value}"]`).forEach(cb => cb.checked =
                        false);
                } else if (type === 'color') {
                    document.querySelectorAll(`.color-filter[value="${value}"]`).forEach(cb => cb.checked =
                        false);
                } else if (type === 'occasion') {
                    document.querySelectorAll(`.occasion-filter[value="${value}"]`).forEach(cb => cb.checked =
                        false);
                }

                applyFilters();
            };

            // Debounced filter function
            function debouncedFilter() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(() => {
                    applyFilters();
                }, 500);
            }

            // Apply filters
            async function applyFilters() {
                if (isLoading) return;

                collectFilters();
                updateActiveFiltersDisplay();

                // Show loading
                isLoading = true;
                loadingSpinner.classList.remove('hidden');
                productsContainer.style.opacity = '0.5';

                // Build query string
                const params = new URLSearchParams({
                    price_ranges: JSON.stringify(currentFilters.priceRanges),
                    custom_min_price: currentFilters.customPrice.min,
                    custom_max_price: currentFilters.customPrice.max,
                    sizes: JSON.stringify(currentFilters.sizes),
                    colors: JSON.stringify(currentFilters.colors),
                    occasions: JSON.stringify(currentFilters.occasions),
                    filter: currentFilters.filter,
                    collection: currentFilters.collection,
                    sort: currentFilters.sort
                });

                // Get category slug from the page
                const categorySlug = window.location.pathname.split('/').pop();

                // Debug: Log what's being sent to controller
                console.log('=== SENDING TO CONTROLLER ===');
                console.log('Full URL:', `/category/${categorySlug}/filter?${params.toString()}`);
                console.log('Occasions parameter:', JSON.stringify(currentFilters.occasions));
                console.log('All params:', params.toString());


                try {
                    const response = await fetch(`/category/${categorySlug}/filter?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();
                    console.log('=== CONTROLLER RESPONSE ===');
                    console.log('Response status:', response.status);
                    console.log('Response data:', data);
                    console.log('Success:', data.success);
                    console.log('HTML length:', data.html ? data.html.length : 'No HTML');

                    if (data.success) {
                        productsContainer.innerHTML = data.html;

                        // Update products count
                        if (productsCountDiv) {
                            productsCountDiv.innerHTML =
                                `Showing ${data.firstItem} - ${data.lastItem} of ${data.total} products`;
                        }

                        // Re-attach product card handlers
                        attachProductCardHandlers();
                    } else {
                        console.error('Controller returned error:', data);
                    }
                } catch (error) {
                    console.error('Filter error:', error);
                } finally {
                    isLoading = false;
                    loadingSpinner.classList.add('hidden');
                    productsContainer.style.opacity = '1';
                }
            }

            // Attach product card click handlers
            function attachProductCardHandlers() {
                document.querySelectorAll('.product-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('button') || e.target.closest('a')) {
                            return;
                        }
                        const productSlug = this.getAttribute('data-product-slug');
                        if (productSlug) {
                            window.location.href = `/products/${productSlug}`;
                        }
                    });
                });
            }

            // Add event listeners to all checkboxes for instant filtering
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    applyFilters();
                });
            });

            // Clear all filters button
            document.getElementById('clear-filters').addEventListener('click', function() {
                // Uncheck all checkboxes
                document.querySelectorAll(
                    '.price-range-filter, .size-filter, .color-filter, .occasion-filter').forEach(
                cb => {
                    cb.checked = false;
                });

                // Reset price ranges
                if (minPriceInput && maxPriceInput) {
                    minPriceInput.value = 0;
                    maxPriceInput.value = 10000;
                    updatePriceDisplay();
                }

                // Apply filters with cleared values
                applyFilters();
            });

            // Initial attachment of product card handlers
            attachProductCardHandlers();

            // Filter dropdown functionality
            const filterDropdownButton = document.getElementById('filter-dropdown-button');
            const filterMenu = document.getElementById('filter-menu');
            const filterLabel = document.getElementById('filter-label');
            const filterChevron = document.getElementById('filter-chevron');

            if (filterDropdownButton && filterMenu && filterChevron) {
                // Toggle dropdown
                filterDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = filterMenu.classList.contains('hidden');

                    if (isHidden) {
                        filterMenu.classList.remove('hidden');
                        filterChevron.style.transform = 'rotate(180deg)';
                    } else {
                        filterMenu.classList.add('hidden');
                        filterChevron.style.transform = 'rotate(0deg)';
                    }
                });

                // Handle filter option clicks
                const filterOptions = filterMenu.querySelectorAll('.filter-option');
                filterOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();

                        const value = this.getAttribute('data-value');
                        const text = this.querySelector('span').textContent;

                        // Update active state
                        filterOptions.forEach(opt => {
                            opt.classList.remove('active');
                            opt.querySelector('.checkmark').style.opacity = '0';
                        });

                        this.classList.add('active');
                        this.querySelector('.checkmark').style.opacity = '1';

                        // Update filter
                        currentFilters.filter = value;
                        filterLabel.textContent = text;

                        // Close dropdown
                        filterMenu.classList.add('hidden');
                        filterChevron.style.transform = 'rotate(0deg)';

                        // Apply filter
                        applyFilters();
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!filterDropdownButton.contains(e.target) && !filterMenu.contains(e.target)) {
                        filterMenu.classList.add('hidden');
                        filterChevron.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // Occasion dropdown functionality
            const occasionDropdownButton = document.getElementById('occasion-dropdown-button');

            const occasionMenu = document.getElementById('occasion-menu');
            const occasionLabel = document.getElementById('occasion-label');
            const occasionChevron = document.getElementById('occasion-chevron');

            if (occasionDropdownButton && occasionMenu && occasionChevron) {
                // Toggle dropdown
                occasionDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = occasionMenu.classList.contains('hidden');

                    if (isHidden) {
                        occasionMenu.classList.remove('hidden');
                        occasionChevron.style.transform = 'rotate(180deg)';
                    } else {
                        occasionMenu.classList.add('hidden');
                        occasionChevron.style.transform = 'rotate(0deg)';
                    }
                });

                // Handle occasion option clicks
                const occasionOptions = occasionMenu.querySelectorAll('.occasion-option');
                occasionOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();

                        const value = this.getAttribute('data-value');
                        const text = this.querySelector('span').textContent;

                        // Debug: Log what's being clicked
                        console.log('=== OCCASION DROPDOWN CLICKED ===');
                        console.log('Clicked value:', value);
                        console.log('Clicked text:', text);
                        console.log('Current occasions before:', currentFilters.occasions);
                        console.log('Value type:', typeof value);
                        console.log('Value length:', value ? value.length : 'null');
                        console.log('Is value null?', value === null);
                        console.log('Is value undefined?', value === undefined);

                        // Update active state
                        occasionOptions.forEach(opt => {
                            opt.classList.remove('active');
                            opt.querySelector('.checkmark').style.opacity = '0';
                        });

                        this.classList.add('active');
                        this.querySelector('.checkmark').style.opacity = '1';

                        // Update filter - toggle occasion selection
                        const index = currentFilters.occasions.indexOf(value);
                        console.log('Index of value in array:', index);

                        if (index > -1) {
                            currentFilters.occasions.splice(index, 1);
                            occasionLabel.textContent = 'Occasion';
                            this.classList.remove('active');
                            this.querySelector('.checkmark').style.opacity = '0';
                            console.log('Removed occasion. New occasions:', currentFilters
                                .occasions);
                        } else {
                            currentFilters.occasions = [value]; // Single selection for simplicity
                            occasionLabel.textContent = text;
                            console.log('Added occasion. New occasions:', currentFilters.occasions);
                        }

                        console.log('Final occasions array before applyFilters:', currentFilters
                            .occasions);
                        console.log('Array length:', currentFilters.occasions.length);

                        // Close dropdown
                        occasionMenu.classList.add('hidden');
                        occasionChevron.style.transform = 'rotate(0deg)';

                        console.log('Calling applyFilters...');
                        // Apply filter
                        applyFilters();
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!occasionDropdownButton.contains(e.target) && !occasionMenu.contains(e.target)) {
                        occasionMenu.classList.add('hidden');
                        occasionChevron.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // Collection dropdown functionality
            const collectionDropdownButton = document.getElementById('collection-dropdown-button');
            const collectionMenu = document.getElementById('collection-menu');
            const collectionLabel = document.getElementById('collection-label');
            const collectionChevron = document.getElementById('collection-chevron');

            if (collectionDropdownButton && collectionMenu && collectionChevron) {
                // Toggle dropdown
                collectionDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = collectionMenu.classList.contains('hidden');

                    if (isHidden) {
                        collectionMenu.classList.remove('hidden');
                        collectionChevron.style.transform = 'rotate(180deg)';
                    } else {
                        collectionMenu.classList.add('hidden');
                        collectionChevron.style.transform = 'rotate(0deg)';
                    }
                });

                // Handle collection option clicks
                const collectionOptions = collectionMenu.querySelectorAll('.collection-option');
                collectionOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();

                        const value = this.getAttribute('data-value');
                        const text = this.querySelector('span').textContent;

                        // Update active state
                        collectionOptions.forEach(opt => {
                            opt.classList.remove('active');
                            opt.querySelector('.checkmark').style.opacity = '0';
                        });

                        this.classList.add('active');
                        this.querySelector('.checkmark').style.opacity = '1';

                        // Update filter
                        currentFilters.collection = value;
                        collectionLabel.textContent = text;

                        // Close dropdown
                        collectionMenu.classList.add('hidden');
                        collectionChevron.style.transform = 'rotate(0deg)';

                        // Apply filter
                        applyFilters();
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!collectionDropdownButton.contains(e.target) && !collectionMenu.contains(e
                        .target)) {
                        collectionMenu.classList.add('hidden');
                        collectionChevron.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // Sort dropdown functionality
            const sortButton = document.getElementById('sort-button');
            const sortMenu = document.getElementById('sort-menu');
            const sortLabel = document.getElementById('sort-label');
            const chevronIcon = document.getElementById('chevron-icon');

            if (sortButton && sortMenu && chevronIcon) {
                // Toggle dropdown
                sortButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = sortMenu.classList.contains('hidden');

                    if (isHidden) {
                        sortMenu.classList.remove('hidden');
                        chevronIcon.style.transform = 'rotate(180deg)';
                    } else {
                        sortMenu.classList.add('hidden');
                        chevronIcon.style.transform = 'rotate(0deg)';
                    }
                });

                // Handle sort option clicks
                const sortOptions = sortMenu.querySelectorAll('.sort-option');
                sortOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();

                        const value = this.getAttribute('data-value');
                        const text = this.querySelector('span').textContent;

                        // Update active state
                        sortOptions.forEach(opt => {
                            opt.classList.remove('active');
                            opt.querySelector('.checkmark').style.opacity = '0';
                        });

                        this.classList.add('active');
                        this.querySelector('.checkmark').style.opacity = '1';

                        // Update sort
                        currentFilters.sort = value;
                        sortLabel.textContent = text;

                        // Close dropdown
                        sortMenu.classList.add('hidden');
                        chevronIcon.style.transform = 'rotate(0deg)';

                        // Apply filter
                        applyFilters();
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sortButton.contains(e.target) && !sortMenu.contains(e.target)) {
                        sortMenu.classList.add('hidden');
                        chevronIcon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });

        // Wishlist toggle function
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
                    } else {
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
    </script> -->
@endsection