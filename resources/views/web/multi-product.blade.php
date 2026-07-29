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

  
    .offer-banner-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 3px;
        margin: 2rem 0;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    }
    
    .offer-banner {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border-radius: 18px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .offer-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .offer-banner::after {
        content: '30%';
        position: absolute;
        bottom: -30px;
        right: -10px;
        font-size: 200px;
        font-weight: 900;
        color: rgba(102, 126, 234, 0.05);
        line-height: 1;
        pointer-events: none;
    }
    
    .offer-content {
        position: relative;
        z-index: 1;
    }
    
    .offer-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        animation: pulse-badge 2s infinite;
    }
    
    @keyframes pulse-badge {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .offer-title {
        font-size: 2.8rem;
        font-weight: 800;
        color: #2d3748;
        margin: 1rem 0 0.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .offer-subtitle {
        font-size: 1.1rem;
        color: #718096;
        margin-bottom: 1.5rem;
    }
    
    .offer-highlight {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        display: inline-block;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .offer-highlight:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: white;
        text-decoration: none;
    }
    
    .offer-features {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    
    .offer-feature {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #4a5568;
        font-size: 0.95rem;
    }
    
    .offer-feature i {
        color: #667eea;
        font-size: 1.2rem;
    }
    
    .offer-image {
        max-height: 300px;
        object-fit: contain;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .offer-title {
            font-size: 2rem;
        }
        .offer-banner {
            padding: 1.5rem;
        }
        .offer-features {
            gap: 1rem;
        }
        .offer-image {
            max-height: 200px;
            margin-top: 1rem;
        }
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
                  class="absolute lgg:right-0 left-0 z-[201] mt-2 w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
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
                      class="filter-option w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none "
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
                  class="absolute right-0 z-[201] mt-2 w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
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
                  class="absolute right-0 z-[201] mt-2  w-fit min-w-[164px] origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
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
                  class="absolute lg:right-0 left-0 z-[201] mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden focus:outline-none"
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


    <div class="flex flex-row gap-3 relative">
      <!-- Filter Sidebar -->
      <div
        id="filter-sidebar"
        class="lgg:sticky fixed lgg:top-0 lgg:left-0 top-0 left-0 lgg:max-w-[300px] lgg:min-w-[300px] max-w-[260px] lgg:h-fit h-full lgg:max-h-max max-h-screen w-full bg-white rounded-xl shadow-md py-5 px-2 lgg:z-[200] z-[20003] transition-all duration-300 ease-in-out">
        <button id="close-filter" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
        <form id="filter-form" class="mt-8">
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
        <div
          class="py-[10px] flex flex-wrap items-center justify-end gap-4 border-b border-gray-200/80 mb-[10px] ">
          
               @if(request('search') == 'offer' || request('search') == 'offers')
    @php
        $offer = App\Models\Offer::where('is_active', 1)
            ->where('start_date', '<=', date('Y-m-d H:i'))
            ->where('end_date', '>=', date('Y-m-d H:i'))
            ->first();
        $coupon = App\Models\Coupon::where('is_active', 1)->where('expiry_date', '>=', date('Y-m-d H:i'))->first();
    @endphp

    @if($offer)
    <div class="w-full mb-6">
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-pink-600 via-pink-500 to-fuchsia-500 p-8 lg:p-12">

            <!-- Decorative circles -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200/20 rounded-full"></div>
            <div class="absolute -bottom-16 -left-10 w-56 h-56 bg-pink-200/20 rounded-full"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">

                <div class="text-white">
                    {{-- <span class="inline-block bg-white text-pink-600 font-semibold px-4 py-2 rounded-full mb-4">
                        🔥 Limited Time Offer
                    </span> --}}

                    <h2 class="text-3xl lg:text-5xl font-bold mb-3">
                        {{ $offer->name ?? '' }}
                    </h2>

                    <p class="text-xl lg:text-2xl font-medium mb-6">
                        Get Up To
                        <span class="font-bold text-yellow-300">
                            {{ $offer->discount ?? '' }}% OFF
                        </span>
                    </p>

                    <p class="text-lg font-medium mb-2">
                        Use Coupon Code 
                        <span class="font-bold text-white" style="size: 15px;">
                            {{ $coupon->code ?? '' }}
                        </span>
                    </p>
                </div>

            </div>

        </div>
    </div>
    @endif
@endif
            
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
        <div id="products-container" class="products-container">
          {{-- @dd($products->count()) --}}
          @include('web.partials.product-grid', ['products' => $products])
          {{-- {{ $products->links('pagination::bootstrap-5') }} --}}
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
<script>
    window.initialFilters = {
        search: '{{ request('search') }}',
        category: '{{ request('category') }}',
        colors: '{{ request('colors') }}',
        sizes: '{{ request('sizes') }}',
        price_ranges: '{{ request('price_ranges') }}',
        sort: '{{ request('sort', 'date-desc') }}',
        has_offer: '{{ request('has_offer') }}'
    };
</script>
<script src="{{asset('web/js/multi-product.js')}}"></script>
@endsection