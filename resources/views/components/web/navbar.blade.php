<style>
    /* Fix z-index stacking */
    #categories-wrapper-menu {

        position: fixed;
        z-index: 20004;
        opacity: 0;
        pointer-events: none;
        top: 101px;
        left: 0;
        right: 0;
        transform: translateY(-20px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #mobile-sidebar .submenu.active {
        max-height: 600px;
    }

    #categories-wrapper-menu.visible {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }

    nav a {
        position: relative;
        cursor: pointer;
    }

    /* Optional: Add animation for smoother appearance */
    #categories-wrapper-menu {
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mega menu styles for mobile */
    .mega-menu {
        position: relative;
        width: 100%;
    }

    .top-level-item {
        position: relative;
        width: 100%;
    }

    .top-level-item .back-button {
        display: none;
        width: 100%;
        text-align: left;
        padding: 12px 16px;
        background-color: white !important;
        border: none;
        font-size: 16px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        margin-bottom: 10px;
    }

    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .menu-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: auto;
        padding: 12px 16px;
        text-decoration: none;
        color: #374151;
        border-radius: 7px;
        margin: 8px;
        margin-bottom: 0 !important;
    }

    .top-level-link {
        background-color: white !important;
    }

    .top-level-open .top-level-item:not(.top-level-active) {
        display: none !important;
    }

    .top-level-active .top-level-link {
        display: none !important;
    }

    .submenu-toggle {
        cursor: pointer;
    }

    /* Add some spacing for nested menus */
    .submenu .submenu {
        margin-left: 20px;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    /* Profile dropdown styles */
    #account-dropdown {
        display: none;
    }

    #account-dropdown.show {
        display: block;
    }

    /* ==================== NEW MOBILE SIDEBAR STYLES ==================== */
    #mobile-sidebar {
        background: linear-gradient(135deg, #ffffff 0%, #fef8f5 100%);
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.15);
        border-right: 1px solid rgba(212, 165, 116, 0.1);
    }

    #mobile-sidebar .border-b {
        background: linear-gradient(135deg, #fef8f5 0%, #ffffff 100%);
        border-bottom: 1px solid rgba(212, 165, 116, 0.1);
    }

    #mobile-sidebar .search-input {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(212, 165, 116, 0.2);
        transition: all 0.3s ease;
    }

    #mobile-sidebar .search-input:focus {
        border-color: #d4a574;
        box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        background: white;
    }

    #mobile-sidebar nav {
        background: linear-gradient(135deg, #fff9f5 0%, #fef6f0 100%);
    }

    .menu-link {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 3px solid transparent;
        margin: 4px 12px;
        position: relative;
        overflow: hidden;
    }

    .menu-link:hover {
        background: white;
        transform: translateX(5px);
        border-left-color: #d4a574;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .menu-link i {
        transition: transform 0.3s ease;
    }

    .menu-link:hover i {
        transform: translateX(3px);
        color: #d4a574;
    }

    .submenu .menu-link {
        background: rgba(255, 255, 255, 0.8);
        margin-left: 0px;
        margin-right: 12px;
        padding-left: 20px;
    }

    .submenu .submenu .menu-link {
        margin-left: 0px;
    }

    .back-button {
        background: linear-gradient(135deg, #ffffff 0%, #fef8f5 100%) !important;
        color: #5d4037;
        font-weight: 600;
        border-bottom: 1px solid rgba(212, 165, 116, 0.2) !important;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        background: white !important;
        padding-left: 20px;
        color: #d4a574;
    }

    .back-button i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .back-button:hover i {
        transform: translateX(-3px);
    }

    /* Mobile sidebar header */
    #mobile-sidebar .p-6 {
        position: relative;
    }

    #mobile-sidebar .p-6::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 20px;
        right: 20px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212, 165, 116, 0.3), transparent);
    }

    #close-sidebar-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(212, 165, 116, 0.1);
        transition: all 0.3s ease;
    }

    #close-sidebar-btn:hover {
        background: rgba(212, 165, 116, 0.2);
        transform: rotate(90deg);
        color: #d4a574;
    }

    /* Scrollbar styling for mobile sidebar */
    #mobile-sidebar nav::-webkit-scrollbar {
        width: 4px;
    }

    #mobile-sidebar nav::-webkit-scrollbar-track {
        background: rgba(212, 165, 116, 0.1);
        border-radius: 10px;
    }

    #mobile-sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(212, 165, 116, 0.5);
        border-radius: 10px;
    }

    #mobile-sidebar nav::-webkit-scrollbar-thumb:hover {
        background: rgba(212, 165, 116, 0.7);
    }

    /* Category indicator */
    .menu-item.has-submenu .menu-link::after {
        content: '';
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background: rgba(212, 165, 116, 0.3);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .menu-item.has-submenu .menu-link:hover::after {
        background: #d4a574;
        transform: translateY(-50%) scale(1.2);
    }

    /* Active state */
    .top-level-active .menu-link {
        background: white;
        box-shadow: 0 4px 15px rgba(212, 165, 116, 0.15);
        border-left-color: #d4a574;
    }

    /* ==================== DESKTOP SEARCH DROPDOWN STYLES ==================== */
    #search-dropdown {
        position: fixed;
        top: 136px;
        left: 0;
        right: 0;
        /* margin-top: 10px; */
        z-index: 20005;
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    #search-dropdown.active {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .search-section {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .search-section:last-child {
        border-bottom: none;
    }

    .search-section-title {
        font-size: 14px;
        font-weight: 600;
        color: #666;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-categories {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .search-category-item {
        padding: 12px;
        background: #f9f9f9;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .search-category-item:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .search-trending {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .trending-tag {
        padding: 8px 16px;
        background: #f5f5f5;
        border-radius: 20px;
        font-size: 13px;
        color: #666;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .trending-tag:hover {
        background: #e0e0e0;
        color: #333;
    }

    .search-products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .search-product-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .search-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #ddd;
    }

    .product-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        object-position: 0px -18px;
    }

    .product-info {
        padding: 12px;
    }

    .product-title {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: #222;
    }

    .view-more {
        display: block;
        text-align: center;
        padding: 12px;
        color: #d4a574;
        font-weight: 500;
        text-decoration: none;
        border-top: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .view-more:hover {
        background: #f9f9f9;
        color: #b8863c;
    }

    /* ==================== MOBILE SEARCH DROPDOWN STYLES ==================== */
    #mobile-search-dropdown {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        z-index: 20006;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        flex-direction: column;
        overflow: hidden;
        /* Prevent content from being pushed by keyboard */
    }

    #mobile-search-dropdown.active {
        opacity: 1;
        pointer-events: auto;
    }

    .mobile-search-header {
        padding: 15px;
        background: white;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        /* Prevent header from shrinking */
    }

    .mobile-search-header input {
        flex: 1;
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 60px;
        font-size: 16px;
        outline: none;
        box-sizing: border-box;
    }

    .mobile-search-header button {
        background: none;
        border: none;
        color: #666;
        font-size: 18px;
        cursor: pointer;
        padding: 8px;
        flex-shrink: 0;
        /* Prevent buttons from shrinking */
    }

    .mobile-search-results {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        -webkit-overflow-scrolling: touch;
        /* Smooth scrolling on iOS */
    }

    .mobile-search-section {
        margin-bottom: 20px;
    }

    .mobile-search-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .mobile-search-items {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .mobile-search-item {
        padding: 12px;
        background: #f9f9f9;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid #eee;
    }

    .mobile-search-item:hover {
        background: #f0f0f0;
    }

    .mobile-search-item.product-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mobile-search-item.product-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .mobile-search-item.product-item .product-details {
        flex: 1;
    }

    .mobile-search-item.product-item .product-name {
        font-weight: 500;
        margin-bottom: 2px;
    }

    .mobile-search-item.product-item .product-price {
        font-size: 12px;
        color: #666;
    }

    .mobile-search-no-results {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        font-style: italic;
    }

    /* Search result highlighting */
    .highlight {
        background-color: #fffacd;
        padding: 0 2px;
        border-radius: 2px;
    }

    /* No results message */
    .no-results {
        padding: 20px;
        text-align: center;
        color: #666;
        font-style: italic;
    }

    /* Loading indicator */
    .search-loading {
        display: none;
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .search-loading.active {
        display: block;
    }

    /* Mobile loading indicator */
    .mobile-search-loading {
        display: none;
        text-align: center;
        padding: 30px;
        color: #666;
    }

    .mobile-search-loading.active {
        display: block;
    }

    /* Category menu loading indicator */
    .category-menu-loading {
        display: none;
        text-align: center;
        padding: 20px;
        color: #666;
        font-size: 14px;
    }

    .category-menu-loading.active {
        display: block;
    }

    /* Close search button */
    .close-search {
        position: absolute;
        right: 45px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        display: none;
        padding: 5px;
        z-index: 10;
    }

    .close-search:hover {
        color: #666;
    }

    /* Search input focus state */
    .search-input:focus+.close-search,
    .search-input:not(:placeholder-shown)+.close-search {
        display: block;
    }

    /* Mobile specific search icon container */
    .mobile-search-icon-container {
        display: none;
    }

    @media screen and (min-width: 1366px) and (max-width: 1600px) {
        .respon-wrap-img {
            max-height: 350px !important;
        }
    }

    /* Mobile sidebar animation */
    #mobile-sidebar {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #sidebar-overlay {
        transition: opacity 0.3s ease;
    }

    /* Categories menu inner animation */
    .category-content {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease-out;
    }

    .category-content.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Category sidebar button animation */
    .category-sidebar-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    /* .category-sidebar-btn::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #d4a574;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .category-sidebar-btn.active::after {
        transform: translateX(0);
    } */

    .category-sidebar-btn:hover {
        padding-left: 24px !important;
        /* transform: translateX(5px); */
    }

    .category-sidebar-btn {
        transition:
    }

    /* Category menu container animation */
    #categories-wrapper-menu .max-w-\[calc\(100\%-50px\)\] {
        animation: scaleIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: top center;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Desktop nav link hover effect */
    .desktop-nav-link {
        transition: all 0.3s ease;
        position: relative;
    }

    .desktop-nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #d4a574, #b8863c);
        transition: width 0.3s ease;
    }

    .desktop-nav-link:hover::after {
        width: 100%;
    }

    .desktop-nav-link:hover {
        color: #d4a574;
        transform: translateY(-2px);
    }

    /* Hide/Show based on screen size */
    @media (max-width:991px) {
        #search-dropdown {
            display: none !important;
        }

        /* Hide desktop search input on mobile */
        #search-input {
            display: none !important;
        }

        /* Make search icon more prominent on mobile */
        #search-icon {
            width: 100%;
            justify-content: right;
            padding: 0 13px;
            height: 40px;
            display: flex !important;
            align-items: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-search {
            display: none !important;
        }

        /* Mobile search suggestions */
        .mobile-search-suggestions {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 20007;
            display: none;
            flex-direction: column;
        }

        .mobile-search-suggestions.active {
            display: flex;
        }

        .mobile-search-suggestions-header {
            padding: 15px;
            background: white;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .mobile-search-suggestions-header input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        .mobile-search-suggestions-header button {
            background: none;
            border: none;
            color: #666;
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-search-suggestions-content {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .search-suggestion-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-suggestion-item:hover {
            background: #f9f9f9;
            padding-left: 20px;
        }

        .search-suggestion-item:last-child {
            border-bottom: none;
        }

        .search-suggestion-item i {
            color: #999;
            min-width: 16px;
            text-align: center;
        }
    }

    @media (min-width: 992px) {
        #mobile-search-dropdown {
            display: none !important;
        }

        .mobile-search-suggestions {
            display: none !important;
        }

        #search-input {
            display: block !important;
        }
    }
</style>

<header id="nav-wrapper" class="bg-white shadow-sm sticky top-0 lg:z-[20004] z-[20000] px-3">
    <!-- Top Bar: Special Offer + Product Title (hidden on small screens for product title) -->
    <div class="text-sm text-gray-600 py-2 border-b">
        <div class="xl:container mx-auto flex smx:flex-nowrap gap-2 justify-between items-center relative">
            <div class="hidden lgg:flex justify-center">
                <p
                    class="inline-flex items-center gap-2 text-sm font-medium
            bg-gradient-to-r from-primary/10 via-secondary/10 to-primary/10
            text-primary px-4 py-2 rounded-full shadow-sm border border-primary/20">

                    <span class="animate-pulse text-secondary">🔥</span>
                    <span>New Arrivals!</span>

                    <span class="text-gray-400">|</span>

                    <span>
                        Get up to
                        <span class="font-semibold text-secondary">20% OFF</span>

                    </span>

                </p>
            </div>

            <div
                class="lgg:absolute lgg:top-0 lgg:left-0 lgg:w-full lgg:flex lgg:justify-center lgg:items-center lgg:pointer-events-none">
                <a href="/" >
                    <img class="xxs:h-[39px] xxs:max-h-max max-h-[37px] h-auto w-auto pointer-events-auto"
                        src="{{ asset('web/images/company-logo/aiman-navbar-logo.png') }}" alt="">
                </a>
            </div>
            <div class="flex flex-row gap-3 items-center justify-end">
                <!-- Social Media Icons (Desktop only) -->
                <div class="hidden md:flex items-center gap-3">

                    <a href="https://wa.me/1234567890" target="_blank"
                        class="text-gray-600 hover:text-green-600 transition-all duration-300 hover:scale-110"
                        title="WhatsApp">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-green-50 transition-colors">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </div>
                    </a>
                </div>

                <!-- Icons -->
                <a href="{{ route('wishlist.index') }}">
                    <button class="text-gray-700 hover:text-black group relative">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-50 bg-gray-100 transition-colors">
                            <i class="fa-regular fa-heart text-lg group-hover:text-red-500"></i>
                        </div>
                        <span
                            class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">
                            Wishlist
                        </span>
                    </button>
                </a>

                @php
                // Get cart count for current user/guest
                $cartCount = 0;
                if (Auth::check()) {
                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('count');
                } else {
                $cartCount = \App\Models\Cart::where('session_id', session()->getId())->sum('count');
                }
                @endphp

                <button onclick="window.location.href='{{ route('cart.index') }}'"
                    class="text-gray-700 hover:text-black group relative">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 hover:bg-blue-50 transition-colors relative">
                        <i class="fa-solid fa-bag-shopping text-lg group-hover:text-blue-600"></i>
                        @if($cartCount > 0)
                        <span
                            class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-xs rounded-full flex items-center justify-center font-semibold">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </div>
                    <span
                        class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">
                        Cart{{ $cartCount > 0 ? ' (' . $cartCount . ')' : '' }}
                    </span>
                </button>

                <!-- Profile Section -->
                @auth
                <!-- Profile with Dropdown (Logged In) -->
                <div class="relative group">
                    <button id="profile-btn" class="flex items-center gap-2 text-gray-700 hover:text-black">
                        <!-- <div class="relative">
                             <img src="https://i.pravatar.cc/32" alt="User"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 hover:border-primary transition-colors" />
                            <span
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span> 
                         </div> -->
                        <span class="hidden sm:block text-sm font-medium">{{ Str::of(Auth::user()->name)->trim()->explode(' ')[0] }}</span>
                        <i
                            class="fa-solid fa-chevron-down text-xs hidden sm:block group-hover:rotate-180 transition-transform"></i>
                    </button>

                    <!-- Account Dropdown -->
                    <div id="account-dropdown"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100 hidden group-hover:block hover:block">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="#"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-regular fa-user text-gray-500 w-4"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-regular fa-clipboard text-gray-500 w-4"></i>
                            <span>Orders</span>
                            <span class="ml-auto bg-primary text-white text-xs px-2 py-1 rounded-full">2</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-regular fa-heart text-gray-500 w-4"></i>
                            <span>Wishlist</span>
                            <span class="ml-auto text-primary text-xs">12</span>
                        </a>

                        <hr class="my-2 border-gray-100" />

                        <form method="POST" action="{{ route('web.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-right-from-bracket w-4"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Login Button (Not Logged In) -->

                <a href="{{ route('page.login') }}">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-secondary-light transition-colors">
                        <i class="fa-solid fa-user text-xs text-[14px]"></i>
                    </div>
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="py-4 flex items-center justify-between gap-6 xl:container mx-auto">
        <!-- Left: Logo + Desktop Nav -->
        <div class="lgg:flex hidden items-center gap-8 flex-1">
            <!-- Desktop Navigation -->
            <nav class="hidden lgg:flex items-center gap-6 text-gray-700 font-medium">
                @if (isset($categories) && count($categories) > 0)
                @foreach ($categories->where('parent_id', null) as $category)
                <div class="relative group">
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="hover:text-black desktop-nav-link flex items-center gap-1"
                        data-category="{{ $category->name }}" data-category-id="{{ $category->id }}">
                        {{ $category->name }}

                    </a>


                </div>
                @endforeach
                @else
                <a href="#" class="hover:text-black desktop-nav-link" data-category="Salwar Kameez">Salwar
                    Kameez</a>
                <a href="#" class="hover:text-black desktop-nav-link" data-category="Lehengas">Lehengas</a>
                <a href="#" class="hover:text-black desktop-nav-link" data-category="Bridal">Bridal</a>
                <a href="#" class="hover:text-black desktop-nav-link" data-category="Wedding">Wedding</a>
                @endif
            </nav>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lgg:hidden text-gray-700 hover:text-black">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>

        <!-- Right Section -->
        <div class="flex items-center gap-4 lgg:w-auto w-full relative">
            <!-- Search Container -->
            <div class="relative block w-full" id="search-container">
                <input type="text" placeholder="Search here" id="search-input"
                    class="search-input pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none w-56 xl:min-w-[400px] lg:min-w-[300px] min-w-full" />
                <button class="close-search" id="close-search-btn" type="button">
                    <i class="fa-solid fa-times"></i>
                </button>
                <input type="text" placeholder="Search here"
                    class="lgg:hidden block pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none w-56 xl:min-w-[400px] lg:min-w-[300px] min-w-full" />

                <i class="fa-solid fa-magnifying-glass absolute lgg:right-4 right-[5px] lgg:top-1/2 top-0 lgg:-translate-y-1/2 text-gray-500 cursor-pointer"
                    id="search-icon"></i>

                <!-- Desktop Search Dropdown (only shown on desktop) -->
                <div id="search-dropdown" class="px-4">
                    <div class="bg-white rounded-md shadow-lg px-4 py-3">
                        <div class="max-h-[70vh] overflow-y-auto">

                            <!-- Loading Indicator -->
                            <div class="search-loading" id="search-loading">
                                <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                                Searching...
                            </div>

                            <!-- Categories Section -->
                            <div class="search-section" id="categories-section">
                                <div class="search-section-title">CATEGORIES</div>
                                <div class="search-categories" id="categories-list">
                                    <!-- Categories will be populated here -->
                                </div>
                            </div>

                            <!-- Trending Searches Section -->
                            <div class="search-section" id="trending-section">
                                <div class="search-section-title">TRENDING SEARCHES</div>
                                <div class="search-trending" id="trending-list">
                                    <!-- Trending searches will be populated here -->
                                </div>
                            </div>

                            <!-- Products Section -->
                            <div class="search-section" id="products-section">
                                <div class="search-section-title">POPULAR PRODUCTS</div>
                                <div class="search-products" id="products-list">
                                    <!-- Products will be populated here -->
                                </div>
                                <a href="#" class="view-more" id="view-more">View More →</a>
                            </div>

                            <!-- No Results Message -->
                            <div class="no-results" id="no-results" style="display: none;">
                                No results found for "<span id="search-query"></span>"
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Mobile Search Suggestions (only shown on mobile) -->
                <div class="mobile-search-suggestions" id="mobile-search-suggestions">
                    <div class="mobile-search-suggestions-header">
                        <button id="mobile-suggestions-back">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <input type="text" placeholder="Search products..." id="mobile-suggestions-input"
                            autocomplete="off" />
                        <button id="mobile-suggestions-clear">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                    <div class="mobile-search-suggestions-content" id="mobile-suggestions-content">
                        <!-- Suggestions will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Search Dropdown (Full Screen) -->
<div id="mobile-search-dropdown">
    <div class="mobile-search-header flex flex-row">
        <button id="mobile-search-back">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <input type="text" placeholder="Search products..." id="mobile-search-input" autocomplete="off" class="w-full rounded-full" />
        <button id="mobile-search-clear">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>

    <div class="mobile-search-results" id="mobile-search-results">
        <!-- Loading Indicator -->
        <div class="mobile-search-loading" id="mobile-search-loading">
            <i class="fa-solid fa-spinner fa-spin mr-2"></i>
            Searching...
        </div>

        <!-- Categories Section -->
        <div class="mobile-search-section" id="mobile-categories-section">
            <div class="mobile-search-section-title">Categories</div>
            <div class="mobile-search-items" id="mobile-categories-list">
                <!-- Categories will be populated here -->
            </div>
        </div>

        <!-- Products Section -->
        <div class="mobile-search-section" id="mobile-products-section">
            <div class="mobile-search-section-title">Products</div>
            <div class="mobile-search-items" id="mobile-products-list">
                <!-- Products will be populated here -->
            </div>
        </div>

        <!-- No Results Message -->
        <div class="mobile-search-no-results" id="mobile-no-results" style="display: none;">
            No results found for "<span id="mobile-search-query"></span>"
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar"
    class="fixed inset-y-0 left-0 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-[20005] lg:hidden w-full max-w-[320px]">
    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b">
        <div class="flex items-center gap-3">
            <img class="h-[40px] w-auto" src="{{ asset('web/images/company-logo/aiman-navbar-logo.png') }}"
                alt="Aiman Royal">
        </div>
        <button id="close-sidebar-btn" class="text-gray-600 hover:text-primary transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Mobile Search -->
    <div class="p-4 border-b">
        <div class="relative">
            <input type="text" placeholder="Search products..." id="mobile-sidebar-search-input"
                class="search-input w-full pl-4 pr-10 py-3 text-sm outline-none rounded-[60px]" />
            <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"
                id="mobile-sidebar-search-icon"></i>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <nav class="py-4 h-[calc(100vh-160px)] overflow-y-auto">
        <div class="mega-menu px-2">
            @if (isset($categories) && count($categories) > 0)
            @foreach ($categories->where('parent_id', null) as $category)
            <div class="menu-item has-submenu top-level-item">
                <button class="back-button">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </button>
                <a href="{{ route('category.show', $category->slug) }}"
                    class="menu-link top-level-link group">
                    <span class="flex-1">{{ $category->name }}</span>
                    <i class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                </a>
                <ul class="submenu">
                    <li class="menu-item has-submenu">
                        <div class="menu-link submenu-toggle group">
                            <span class="flex-1">Style</span>
                            <i
                                class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                        </div>
                        <ul class="submenu">
                            @if (isset($categories) && count($categories) > 0)
                            @foreach ($categories->take(5) as $cat)
                            <li class="menu-item">
                                <a href="{{ route('category.show', $cat->slug) }}"
                                    class="menu-link hover:pl-6 transition-all">{{ $cat->name }}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="menu-item has-submenu">
                        <div class="menu-link submenu-toggle group">
                            <span class="flex-1">Occasion</span>
                            <i
                                class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                        </div>
                        <ul class="submenu">
                            @if (isset($occasions) && count($occasions) > 0)
                            @foreach ($occasions->take(5) as $occasion)
                            <li class="menu-item">
                                <a href="{{ route('occasion.show', $occasion->slug) }}"
                                    class="menu-link hover:pl-6 transition-all">{{ $occasion->name }}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="menu-item has-submenu">
                        <div class="menu-link submenu-toggle group">
                            <span class="flex-1">Collection</span>
                            <i
                                class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                        </div>
                        <ul class="submenu">
                            <li class="menu-item">
                                <a href="#" class="menu-link hover:pl-6 transition-all">Red Saree</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link hover:pl-6 transition-all">Salwar
                                    Kameez</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link hover:pl-6 transition-all">Lehenga</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endforeach
            @else
            <!-- Default menu items -->
            <div class="menu-item has-submenu top-level-item">
                <button class="back-button">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </button>
                <a href="#" class="menu-link top-level-link group">
                    <span class="flex-1">Lahenga</span>
                    <i class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                </a>
                <ul class="submenu">
                    <li class="menu-item has-submenu">
                        <div class="menu-link submenu-toggle group">
                            <span class="flex-1">Style</span>
                            <i class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                        </div>
                        <ul class="submenu">
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Red Saree</a></li>
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Salwar Kameez</a></li>
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Lehenga</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu-item has-submenu top-level-item">
                <button class="back-button">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </button>
                <a href="#" class="menu-link top-level-link group">
                    <span class="flex-1">Salwar Kameez</span>
                    <i class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                </a>
                <ul class="submenu">
                    <li class="menu-item has-submenu">
                        <div class="menu-link submenu-toggle group">
                            <span class="flex-1">Style</span>
                            <i class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"></i>
                        </div>
                        <ul class="submenu">
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Red Saree</a></li>
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Salwar Kameez</a></li>
                            <li class="menu-item"><a href="#"
                                    class="menu-link hover:pl-6 transition-all">Lehenga</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </nav>

    <!-- Quick Links Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t bg-white">
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('page.login') }}"
                class="text-center py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition-colors text-sm">
                <i class="fa-solid fa-user mr-2"></i> Login
            </a>
            <a href="{{ route('cart.index') }}"
                class="text-center py-3 border border-primary text-primary rounded-lg font-medium hover:bg-primary hover:text-white transition-colors text-sm">
                <i class="fa-solid fa-shopping-cart mr-2"></i> Cart
            </a>
        </div>

    </div>
</div>

<!-- Overlay for mobile sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[20004] lg:hidden"></div>

<!-- Categories Menu for Desktop -->
<div id="categories-wrapper-menu" class="fixed lg:z-[20004] z-[20000] w-full mx-auto opacity-0 pointer-events-none top-[80px] hidden">
    <div class="max-w-[calc(100%-50px)] mx-auto my-10 shadow-lg rounded-xl overflow-hidden bg-white">
        <div class="flex">
            <!-- Left Sidebar -->
            <div class="bg-[#fdebdc] p-8 flex flex-col gap-1 pr-0 min-w-[300px] text-left">
                <button
                    class="category-sidebar-btn active px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left"
                    data-target="style-products">
                    Style
                </button>
                <button
                    class="category-sidebar-btn px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left"
                    data-target="occation-products">
                    Occasion
                </button>
                <button
                    class="category-sidebar-btn px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left"
                    data-target="collection-products">
                    Collection
                </button>
            </div>

            <!-- Product Section -->
            <div
                class="flex-1 bg-[url('https://www.transparenttextures.com/patterns/geometry.png')] bg-opacity-20 py-8 pl-8 pr-4 ">
                <!-- Loading Indicator for Category Data -->
                <div class="category-menu-loading" id="category-menu-loading">
                    <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                    Loading category data...
                </div>

                <!-- Style Products -->
                <div id="style-products"
                    class="category-content xll:max-h-max max-h-[450px] pr-3 overflow-auto active">
                    <!-- Content will be loaded dynamically -->
                    <div class="flex flex-row justify-between gap-3 items-start">
                        <div class="w-full flex flex-row gap-4 justify-between pr-[1.2rem]">
                            <div id="style-list-left" class="flex flex-col">

                            </div>
                            <div id="style-list-right" class="flex flex-col">

                            </div>
                        </div>
                        <div class="xl:max-w-[300px] lg:max-w-[270px] flex flex-col gap-2">
                            <div class="overflow-hidden rounded-md max-h-[400px] w-full relative">
                                <img class="w-full h-full object-cover aspect-auto" id="category-banner-image"
                                    src="{{ asset('web/images/banner-images/red-plazo-6.webp') }}" alt="">
                                <div
                                    class="absolute bottom-[10px] w-full flex justify-center flex-col items-center gap-3">
                                    <p class="text-[2rem] font-bold text-white text-center" id="category-banner-title">
                                        Styles
                                    </p>
                                    <button class="px-6 py-2 text-[1.2rem] font-bold bg-white" id="category-shop-btn">Shop Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Occasion Products -->
                <div id="occation-products"
                    class="category-content xll:max-h-max max-h-[450px] pr-3 overflow-auto hidden">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row justify-between gap-3 xll:items-center items-start">
                            <div
                                class="w-full xll:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid gap-3" id="occasion-list">
                                <!-- Occasion items will be populated here -->
                            </div>
                        </div>
                        <button
                            class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit" id="occasion-show-more">Show
                            More</button>
                    </div>
                </div>

                <!-- Collection Products -->
                <div id="collection-products"
                    class="category-content xll:max-h-max max-h-[450px] pr-3 overflow-auto hidden">
                    <div class="grid xll:grid-cols-4 xl:grid-cols-3 lg:grid-cols-2 gap-3" id="collection-products-list">
                        <!-- Collection products will be populated here -->
                    </div>
                    <button
                        class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit" id="collection-show-more">Show
                        More</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== GLOBAL VARIABLES ====================
        let currentCategoryId = null;
        let currentCategoryData = null;
        let categoryCache = {}; // Cache for API responses

        // ==================== SEARCH DATA ====================
        const searchData = {
            categories: [
                "Saree",
                "Saree Gown",
                "Saree with Ready-made Blouse",
                "Salwar Kameez",
                "Lehengas",
                "Bridal Wear",
                "Party Wear",
                "Casual Wear"
            ],

            trending: [
                "Saree Gown for Women",
                "Saree with Readymade Blouse for women",
                "Saree for women",
                "Saree Gown for Cocktail",
                "Saree Gown for Reception",
                "Saree Gown for Party",
                "Saree Gown for Bridal Cocktail",
                "Blue Banarasi Silk Saree",
                "Mint Green Satin Saree",
                "Wine Tissue Organza Saree"
            ],

            products: [{
                    title: "Blue Banarasi Silk Woven Saree With Zari Paisley Motifs",
                    price: "MRP ₹5,085",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["blue", "banarasi", "silk", "saree", "zari"]
                },
                {
                    title: "Mint Green Satin Printed Saree With Digital Florals",
                    price: "MRP ₹16,895",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["mint", "green", "satin", "saree", "floral"]
                },
                {
                    title: "Wine Tissue Organza Embroidered Saree with Unstitched Blouse",
                    price: "MRP ₹8,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["wine", "organza", "embroidered", "saree", "blouse"]
                },
                {
                    title: "Teal Green Organza Silk Saree with Unstitched Blouse",
                    price: "MRP ₹5,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["teal", "green", "organza", "silk", "saree"]
                },
                {
                    title: "Maroon Shaded Organza Silk Saree with Unstitched Blouse",
                    price: "MRP ₹5,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["maroon", "organza", "silk", "saree", "shaded"]
                },
                {
                    title: "Black Cotton Linen Saree with Blouse Fabric",
                    price: "MRP ₹7,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["black", "cotton", "linen", "saree", "blouse"]
                },
                {
                    title: "Olive Green Linen Printed Saree With Heritage Ajrakh Geometric Print",
                    price: "MRP ₹2,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["olive", "green", "linen", "saree", "printed"]
                },
                {
                    title: "Maroon Tissue Organza Resham Work Saree with Unstitched Blouse",
                    price: "MRP ₹10,995",
                    image: "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                    tags: ["maroon", "tissue", "organza", "resham", "saree"]
                }
            ]
        };

        // ==================== CATEGORY API FUNCTIONS ====================
        async function fetchCategoryData(categoryId) {
            // Check cache first
            if (categoryCache[categoryId]) {
                return categoryCache[categoryId];
            }

            const loadingElement = document.getElementById('category-menu-loading');
            if (loadingElement) {
                loadingElement.classList.add('active');
            }

            try {
                const response = await fetch(`/api/categories/${categoryId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                console.log(data);

                if (data.success) {
                    // Cache the response
                    categoryCache[categoryId] = data.data;
                    return data.data;
                } else {
                    throw new Error(data.message || 'Failed to fetch category data');
                }
            } catch (error) {
                console.error('Error fetching category data:', error);
                // Return fallback data structure
                return {
                    parent_category: {
                        id: categoryId,
                        name: 'Category',
                        slug: 'category'
                    },
                    style: [],
                    ocassions: [],
                    collection: [],
                    products_by_category: {},
                    parent_category_products: []
                };
            } finally {
                if (loadingElement) {
                    loadingElement.classList.remove('active');
                }
            }
        }

        function renderCategoryMenuData(categoryData) {
            if (!categoryData) return;

            currentCategoryData = categoryData;
            const parentCategory = categoryData.parent_category;

            // Update category banner
            const bannerTitle = document.getElementById('category-banner-title');
            const shopBtn = document.getElementById('category-shop-btn');
            if (bannerTitle) bannerTitle.textContent = parentCategory.name || 'Styles';
            if (shopBtn) shopBtn.textContent = 'Shop Now';

            // Update shop button link
            if (shopBtn && parentCategory.slug) {
                shopBtn.onclick = function() {
                    window.location.href = `/category/${parentCategory.slug}`;
                };
            }

            // ==================== RENDER STYLE SECTION ====================
            renderStyleSection(categoryData);

            // ==================== RENDER OCCASION SECTION ====================
            renderOccasionSection(categoryData);

            // ==================== RENDER COLLECTION SECTION ====================
            renderCollectionSection(categoryData);
        }

        function renderStyleSection(categoryData) {
            const styleLeftList = document.getElementById('style-list-left');
            const styleRightList = document.getElementById('style-list-right');

            if (!styleLeftList || !styleRightList) return;

            // Clear existing content
            styleLeftList.innerHTML = '';
            styleRightList.innerHTML = '';

            const styleItems = categoryData.style || [];

            if (styleItems.length === 0) {
                // Show default message if no styles
                styleLeftList.innerHTML = '<li class="mb-4 text-[1.1rem] text-gray-400">No styles found</li>';
                return;
            }

            // Split styles into two columns
            const midIndex = Math.ceil(styleItems.length / 2);
            const leftStyles = styleItems.slice(0, midIndex);
            const rightStyles = styleItems.slice(midIndex);

            // Render left column styles
            leftStyles.forEach(style => {
                const li = document.createElement('a');
                li.className = 'mb-4 text-[1.3rem]';
                li.textContent = style.name;
                li.href = `/category/${style.slug}`;

                // Create subcategories list
                const subUl = document.createElement('ul');
                subUl.className = 'ml-4 mb-4';

                // You might want to fetch subcategories or use existing data
                // For now, we'll show the style name as the only item
                const subLi = document.createElement('li');
                subLi.className = 'mb-2 text-[1.1rem] text-gray-600';

                const link = document.createElement('a');
                link.href = `/category/${style.slug}`;
                link.className = 'hover:text-black transition-colors';
                link.textContent = style.name;

                // subLi.appendChild(link);
                // subUl.appendChild(subLi);

                // li.appendChild(subUl);
                styleLeftList.appendChild(li);
            });

            // Render right column styles
            rightStyles.forEach(style => {
                const li = document.createElement('a');
                li.className = 'mb-4 text-[1.3rem]';
                li.textContent = style.name;
                li.href = `/category/${style.slug}`;

                const subUl = document.createElement('ul');
                subUl.className = 'ml-4 mb-4';

                const subLi = document.createElement('li');
                subLi.className = 'mb-2 text-[1.1rem] text-gray-600';

                const link = document.createElement('a');
                link.href = `/category/${style.slug}`;
                link.className = 'hover:text-black transition-colors';
                link.textContent = style.name;

                // subLi.appendChild(link);
                // subUl.appendChild(subLi);
                // li.appendChild(subUl);
                styleRightList.appendChild(li);
            });
        }

        function renderOccasionSection(categoryData) {
            const occasionList = document.getElementById('occasion-list');
            const showMoreBtn = document.getElementById('occasion-show-more');

            if (!occasionList) return;

            occasionList.innerHTML = '';

            const occasions = categoryData.ocassions || [];


            if (occasions.length === 0) {
                // Show default fallback occasions
                const fallbackOccasions = [{
                        name: 'Wedding',
                        slug: 'wedding'
                    },
                    {
                        name: 'Party',
                        slug: 'party'
                    },
                    {
                        name: 'Festival',
                        slug: 'festival'
                    },
                    {
                        name: 'Casual',
                        slug: 'casual'
                    }
                ];

                fallbackOccasions.forEach(occasion => {
                    const div = document.createElement('div');
                    div.className = 'flex flex-col gap-2';

                    const link = document.createElement('a');
                    link.href = `/occasion/${occasion.slug}`;
                    link.className = 'overflow-hidden rounded-md w-full block hover:opacity-90 transition-opacity';

                    const img = document.createElement('img');
                    img.className = 'w-full h-full object-cover aspect-auto';
                    img.src = "{{ asset('web/images/banner-images/red-plazo-6.webp') }}";
                    img.alt = occasion.name;

                    link.appendChild(img);
                    div.appendChild(link);

                    const p = document.createElement('p');
                    p.className = 'text-[1.2rem] font-bold text-gray-700 text-center';

                    const occLink = document.createElement('a');
                    occLink.href = `/occasion/${occasion.slug}`;
                    occLink.className = 'hover:text-black transition-colors';
                    occLink.textContent = occasion.name;

                    p.appendChild(occLink);
                    div.appendChild(p);
                    occasionList.appendChild(div);
                });
            } else {
                occasions.slice(0, 4).forEach(occasion => {
                    const div = document.createElement('div');
                    div.className = 'flex flex-col gap-2';

                    const link = document.createElement('a');
                    link.href = `/occasion/${occasion.slug}`;
                    link.className = 'overflow-hidden rounded-md w-full block hover:opacity-90 transition-opacity';

                    const img = document.createElement('img');
                    img.className = 'w-full h-full object-cover aspect-auto';
                    img.src = "{{ asset('web/images/banner-images/red-plazo-6.webp') }}";
                    img.alt = occasion.name;

                    link.appendChild(img);
                    div.appendChild(link);

                    const p = document.createElement('p');
                    p.className = 'text-[1.2rem] font-bold text-gray-700 text-center';

                    const occLink = document.createElement('a');
                    occLink.href = `/occasion/${occasion.slug}`;
                    occLink.className = 'hover:text-black transition-colors';
                    occLink.textContent = occasion.name;

                    p.appendChild(occLink);
                    div.appendChild(p);
                    occasionList.appendChild(div);
                });
            }

            // Update show more button
            if (showMoreBtn && occasions.length > 4) {
                showMoreBtn.style.display = 'block';
                showMoreBtn.onclick = function() {
                    // Implement show more functionality
                    console.log('Show more occasions clicked');
                };
            } else if (showMoreBtn) {
                showMoreBtn.style.display = 'none';
            }
        }

        function renderCollectionSection(categoryData) {
            const collectionList = document.getElementById('collection-products-list');
            const showMoreBtn = document.getElementById('collection-show-more');

            if (!collectionList) return;

            collectionList.innerHTML = '';

            // Extract products from the complex data structure
            let products = [];

            if (categoryData && categoryData.collection && categoryData.collection.products_by_category) {
                // Get all products from all categories in products_by_category
                const productsByCategory = categoryData.collection.products_by_category;

                // Iterate through each category's product array
                for (const categoryId in productsByCategory) {
                    if (Array.isArray(productsByCategory[categoryId])) {
                        products = products.concat(productsByCategory[categoryId]);
                    }
                }
            }

            console.log("Extracted products:", products);

            if (products.length === 0) {
                // Show default fallback products
                const fallbackProducts = [{
                        name: "Light Pink Salwar",
                        price: "Rs. 700",
                        originalPrice: "Rs. 1000",
                        image: "{{ asset('web/images/product-images/light-pink-m-2_49_11zon.webp') }}",
                        slug: "light-pink-salwar"
                    },
                    {
                        name: "Gray Lahenga",
                        price: "Rs. 700",
                        originalPrice: "Rs. 1000",
                        image: "{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}",
                        slug: "gray-lahenga"
                    },
                    {
                        name: "Red Plazo",
                        price: "Rs. 700",
                        originalPrice: "Rs. 1000",
                        image: "{{ asset('web/images/product-images/red-plazo-3_89_11zon.webp') }}",
                        slug: "red-plazo"
                    },
                    {
                        name: "Short Plazo",
                        price: "Rs. 700",
                        originalPrice: "Rs. 1000",
                        image: "{{ asset('web/images/product-images/short-plazo-1_99_11zon.webp') }}",
                        slug: "short-plazo"
                    }
                ];

                fallbackProducts.forEach(product => {
                    const productCard = createProductCard(product);
                    collectionList.appendChild(productCard);
                });
            } else {
                // Display products (limit to 4 for initial view)
                products.slice(0, 4).forEach(product => {
                    const productCard = createProductCard({
                        name: product.name,
                        price: product.discount_price ? `Rs. ${product.discount_price}` : `Rs. ${product.price}`,
                        originalPrice: product.price && product.discount_price ? `Rs. ${product.price}` : null,
                        image: product.images && product.images[0] ? product.images[0].image : "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                        slug: product.slug || product.name.toLowerCase().replace(/\s+/g, '-')
                    });
                    collectionList.appendChild(productCard);
                });
            }

            // Update show more button
            if (showMoreBtn) {
                if (products.length > 4) {
                    showMoreBtn.style.display = 'block';
                    showMoreBtn.onclick = function() {
                        // Show remaining products
                        products.slice(4).forEach(product => {
                            const productCard = createProductCard({
                                name: product.name,
                                price: product.discount_price ? `Rs. ${product.discount_price}` : `Rs. ${product.price}`,
                                originalPrice: product.price && product.discount_price ? `Rs. ${product.price}` : null,
                                image: product.images && product.images[0] ? product.images[0].image : "{{ asset('web/images/banner-images/red-plazo-6.webp') }}",
                                slug: product.slug || product.name.toLowerCase().replace(/\s+/g, '-')
                            });
                            collectionList.appendChild(productCard);
                        });
                        showMoreBtn.style.display = 'none';
                    };
                } else {
                    showMoreBtn.style.display = 'none';
                }
            }
        }

        function createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow';

            card.innerHTML = `
                <!-- Image Wrapper -->
                <div class="relative rounded-xl overflow-hidden">
                    <img src="${product.image}" alt="${product.name}"
                        class="w-full h-[340px] object-cover object-top object-center">
                    
                    <!-- Wishlist Heart Icon (Top Right) -->
                    <button
                        class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4 space-y-1">
                    <h3 class="text-[15px] font-semibold text-gray-900">
                        ${product.name}
                    </h3>

                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Brand Name</span>
                        <span class="flex items-center gap-1 text-gray-700">
                            <span class="text-sm font-medium">4.4</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                        <span class="text-lg font-bold text-gray-900">${product.price}</span>
                        ${product.originalPrice ? `<span class="text-sm text-gray-400 line-through">${product.originalPrice}</span>` : ''}
                    </div>
                </div>
            `;

            // Add click event to navigate to product page
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                window.location.href = `/product/${product.slug}`;
            });

            return card;
        }

        // ==================== SEARCH FUNCTIONALITY ====================
        // Desktop elements
        const searchInput = document.getElementById('search-input');
        const searchIcon = document.getElementById('search-icon');
        const searchDropdown = document.getElementById('search-dropdown');
        const closeSearchBtn = document.getElementById('close-search-btn');
        const searchContainer = document.getElementById('search-container');
        const searchLoading = document.getElementById('search-loading');
        const noResults = document.getElementById('no-results');
        const searchQuery = document.getElementById('search-query');

        // Mobile elements
        const mobileSearchDropdown = document.getElementById('mobile-search-dropdown');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const mobileSearchBack = document.getElementById('mobile-search-back');
        const mobileSearchClear = document.getElementById('mobile-search-clear');
        const mobileSearchResults = document.getElementById('mobile-search-results');
        const mobileSearchLoading = document.getElementById('mobile-search-loading');
        const mobileNoResults = document.getElementById('mobile-no-results');
        const mobileSearchQuery = document.getElementById('mobile-search-query');
        const mobileSearchSuggestions = document.getElementById('mobile-search-suggestions');
        const mobileSidebarSearchInput = document.getElementById('mobile-sidebar-search-input');
        const mobileSidebarSearchIcon = document.getElementById('mobile-sidebar-search-icon');
        const mobileSuggestionsInput = document.getElementById('mobile-suggestions-input');
        const mobileSuggestionsBack = document.getElementById('mobile-suggestions-back');
        const mobileSuggestionsClear = document.getElementById('mobile-suggestions-clear');
        const mobileSuggestionsContent = document.getElementById('mobile-suggestions-content');

        // DOM elements for desktop search results
        const categoriesList = document.getElementById('categories-list');
        const trendingList = document.getElementById('trending-list');
        const productsList = document.getElementById('products-list');
        const viewMore = document.getElementById('view-more');

        // DOM elements for mobile search results
        const mobileCategoriesList = document.getElementById('mobile-categories-list');
        const mobileProductsList = document.getElementById('mobile-products-list');

        // Check if we're on mobile
        function isMobile() {
            return window.innerWidth <= 991;
        }

        // Highlight search terms in text
        function highlightText(text, searchTerm) {
            if (!searchTerm) return text;

            const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        // Filter data based on search term
        function filterData(searchTerm) {
            const term = searchTerm.toLowerCase().trim();

            if (!term) {
                return {
                    categories: searchData.categories.slice(0, 3),
                    trending: searchData.trending.slice(0, 7),
                    products: searchData.products.slice(0, 4),
                    hasResults: true
                };
            }

            // Filter categories
            const filteredCategories = searchData.categories.filter(category =>
                category.toLowerCase().includes(term)
            ).slice(0, 3);

            // Filter trending searches
            const filteredTrending = searchData.trending.filter(trend =>
                trend.toLowerCase().includes(term)
            ).slice(0, 7);

            // Filter products
            const filteredProducts = searchData.products.filter(product => {
                // Search in title
                if (product.title.toLowerCase().includes(term)) return true;

                // Search in tags
                if (product.tags.some(tag => tag.toLowerCase().includes(term))) return true;

                return false;
            }).slice(0, 8);

            return {
                categories: filteredCategories,
                trending: filteredTrending,
                products: filteredProducts,
                hasResults: filteredCategories.length > 0 || filteredTrending.length > 0 || filteredProducts
                    .length > 0
            };
        }

        // ==================== DESKTOP SEARCH FUNCTIONS ====================
        // Render desktop search results
        function renderDesktopSearchResults(searchTerm = '') {
            const results = filterData(searchTerm);

            // Clear previous results
            categoriesList.innerHTML = '';
            trendingList.innerHTML = '';
            productsList.innerHTML = '';

            // Show/hide sections based on results
            const categoriesSection = document.getElementById('categories-section');
            const trendingSection = document.getElementById('trending-section');
            const productsSection = document.getElementById('products-section');

            categoriesSection.style.display = results.categories.length > 0 ? 'block' : 'none';
            trendingSection.style.display = results.trending.length > 0 ? 'block' : 'none';
            productsSection.style.display = results.products.length > 0 ? 'block' : 'none';
            noResults.style.display = results.hasResults ? 'none' : 'block';

            if (!results.hasResults) {
                searchQuery.textContent = searchTerm;
                return;
            }

            // Render categories
            results.categories.forEach(category => {
                const categoryElement = document.createElement('div');
                categoryElement.className = 'search-category-item';
                categoryElement.innerHTML = highlightText(category, searchTerm);
                categoryElement.addEventListener('click', () => {
                    searchInput.value = category;
                    searchInput.focus();
                    performComprehensiveSearch(category);
                });
                categoriesList.appendChild(categoryElement);
            });

            // Render trending searches
            results.trending.forEach(trend => {
                const trendElement = document.createElement('div');
                trendElement.className = 'trending-tag';
                trendElement.innerHTML = highlightText(trend, searchTerm);
                trendElement.addEventListener('click', () => {
                    searchInput.value = trend;
                    searchInput.focus();
                    performComprehensiveSearch(trend);
                });
                trendingList.appendChild(trendElement);
            });

            // Render products
            results.products.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'search-product-card';
                productElement.innerHTML = `
                    <img src="${product.image}" alt="${product.title}" class="product-image">
                    <div class="product-info">
                        <div class="product-title">${highlightText(product.title, searchTerm)}</div>
                        <div class="product-price">${product.price}</div>
                    </div>
                `;
                productElement.addEventListener('click', () => {
                    // Navigate to product detail page
                    if (product.id) {
                        window.location.href = `/products/${product.id}`;
                    } else {
                        // If no ID, perform search with product title
                        performComprehensiveSearch(product.title);
                    }
                });
                productsList.appendChild(productElement);
            });

            // Update view more link
            if (searchTerm) {
                viewMore.href = `/collections?search=${encodeURIComponent(searchTerm)}`;
                viewMore.textContent = `View all results for "${searchTerm}" →`;
            } else {
                viewMore.href = '#';
                viewMore.textContent = 'View More →';
            }
        }

        // Perform desktop search
        function performDesktopSearch(searchTerm) {
            showDesktopSearchDropdown();

            // Show loading indicator
            searchLoading.classList.add('active');

            // Simulate API call delay
            setTimeout(() => {
                renderDesktopSearchResults(searchTerm);
                searchLoading.classList.remove('active');
            }, 300);
        }

        // Show desktop search dropdown
        function showDesktopSearchDropdown() {
            if (!isMobile()) {
                searchDropdown.classList.add('active');
            }
        }

        // Hide desktop search dropdown
        function hideDesktopSearchDropdown() {
            searchDropdown.classList.remove('active');
        }

        // ==================== MOBILE SEARCH FUNCTIONS ====================
        // Render mobile search results
        function renderMobileSearchResults(searchTerm = '') {
            const results = filterData(searchTerm);

            // Clear previous results
            mobileCategoriesList.innerHTML = '';
            mobileProductsList.innerHTML = '';

            // Show/hide sections based on results
            const mobileCategoriesSection = document.getElementById('mobile-categories-section');
            const mobileProductsSection = document.getElementById('mobile-products-section');

            mobileCategoriesSection.style.display = results.categories.length > 0 ? 'block' : 'none';
            mobileProductsSection.style.display = results.products.length > 0 ? 'block' : 'none';
            mobileNoResults.style.display = results.hasResults ? 'none' : 'block';

            if (!results.hasResults) {
                mobileSearchQuery.textContent = searchTerm;
                return;
            }

            // Render categories for mobile
            results.categories.forEach(category => {
                const categoryElement = document.createElement('div');
                categoryElement.className = 'mobile-search-item';
                categoryElement.innerHTML = `
                    <i class="fa-solid fa-tag mr-2"></i>
                    ${highlightText(category, searchTerm)}
                `;
                categoryElement.addEventListener('click', () => {
                    mobileSearchInput.value = category;
                    performMobileSearch(category);
                });
                mobileCategoriesList.appendChild(categoryElement);
            });

            // Render products for mobile (simplified view)
            results.products.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'mobile-search-item product-item';
                productElement.innerHTML = `
                    <img src="${product.image}" alt="${product.title}">
                    <div class="product-details">
                        <div class="product-name">${highlightText(product.title, searchTerm)}</div>
                        <div class="product-price">${product.price}</div>
                    </div>
                `;
                productElement.addEventListener('click', () => {
                    console.log('Mobile product clicked:', product.title);
                    closeMobileSearch();
                });
                mobileProductsList.appendChild(productElement);
            });
        }

        // Update mobile search suggestions
        function updateMobileSuggestions(searchTerm = '') {
            const suggestionsContainer = mobileSuggestionsContent;
            suggestionsContainer.innerHTML = '';

            if (!searchTerm.trim()) {
                // Show default trending suggestions
                searchData.trending.slice(0, 5).forEach(trend => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'search-suggestion-item';
                    suggestionItem.setAttribute('data-search', trend);
                    suggestionItem.innerHTML = `
                        <i class="fa-solid fa-tag"></i>
                        <span>${trend}</span>
                    `;
                    suggestionItem.addEventListener('click', () => {
                        openMobileSearch(trend);
                        hideMobileSuggestions();
                    });
                    suggestionsContainer.appendChild(suggestionItem);
                });
            } else {
                // Show filtered suggestions
                const term = searchTerm.toLowerCase();
                const filteredTrending = searchData.trending.filter(trend =>
                    trend.toLowerCase().includes(term)
                ).slice(0, 5);

                if (filteredTrending.length === 0) {
                    const noSuggestion = document.createElement('div');
                    noSuggestion.className = 'search-suggestion-item';
                    noSuggestion.innerHTML = `
                        <i class="fa-solid fa-search"></i>
                        <span>No suggestions found</span>
                    `;
                    suggestionsContainer.appendChild(noSuggestion);
                } else {
                    filteredTrending.forEach(trend => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'search-suggestion-item';
                        suggestionItem.setAttribute('data-search', trend);
                        suggestionItem.innerHTML = `
                            <i class="fa-solid fa-tag"></i>
                            <span>${highlightText(trend, searchTerm)}</span>
                        `;
                        suggestionItem.addEventListener('click', () => {
                            openMobileSearch(trend);
                            hideMobileSuggestions();
                        });
                        suggestionsContainer.appendChild(suggestionItem);
                    });
                }
            }
        }

        // Perform mobile search
        function performMobileSearch(searchTerm) {
            // Show loading indicator
            mobileSearchLoading.classList.add('active');

            // Simulate API call delay
            setTimeout(() => {
                renderMobileSearchResults(searchTerm);
                mobileSearchLoading.classList.remove('active');
            }, 300);
        }

        // Open mobile search
        function openMobileSearch(initialValue = '') {
            if (!isMobile()) return;

            // Close any open suggestions first
            hideMobileSuggestions();

            mobileSearchDropdown.classList.add('active');
            document.body.style.overflow = 'hidden';

            if (initialValue) {
                mobileSearchInput.value = initialValue;
                performMobileSearch(initialValue);
            } else {
                mobileSearchInput.value = '';
                renderMobileSearchResults(); // Show default results
            }

            // Focus on mobile search input with a delay to ensure it works
            setTimeout(() => {
                mobileSearchInput.focus();
                // Scroll to top to ensure input is visible
                mobileSearchResults.scrollTop = 0;
            }, 150);
        }

        // Close mobile search
        function closeMobileSearch() {
            mobileSearchDropdown.classList.remove('active');
            document.body.style.overflow = '';
            mobileSearchInput.value = '';
            hideMobileSuggestions();
        }

        // Show mobile suggestions
        function showMobileSuggestions() {
            if (!isMobile()) return;
            mobileSearchSuggestions.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Focus on suggestions input
            setTimeout(() => {
                mobileSuggestionsInput.focus();
            }, 100);
        }

        // Hide mobile suggestions
        function hideMobileSuggestions() {
            mobileSearchSuggestions.classList.remove('active');
            document.body.style.overflow = '';
        }

        // ==================== INITIALIZE SEARCH ====================
        function initSearch() {
            // Initial render of default results
            renderDesktopSearchResults();
            updateMobileSuggestions();

            // ==================== DESKTOP SEARCH EVENTS ====================
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    if (!isMobile()) {
                        showDesktopSearchDropdown();
                        hideCategoriesMenu();
                        renderDesktopSearchResults();
                    }
                });

                // Real-time search as user types (desktop only)
                let desktopSearchTimeout;
                searchInput.addEventListener('input', function() {
                    if (isMobile()) return;

                    clearTimeout(desktopSearchTimeout);

                    const searchTerm = this.value.trim();

                    // Debounce the search
                    desktopSearchTimeout = setTimeout(() => {
                        performDesktopSearch(searchTerm);
                    }, 300);
                });

                // Handle Enter key
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            performComprehensiveSearch(searchTerm);
                        }
                    }
                });
            }

            // ==================== SEARCH FUNCTIONALITY ====================

            // Search icon click - main search trigger
            if (searchIcon) {
                searchIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const searchValue = searchInput.value.trim();

                    if (isMobile()) {
                        // On mobile: open full-screen mobile search dropdown
                        openMobileSearch(searchValue);
                    } else {
                        // On desktop: perform search or toggle dropdown
                        if (searchValue) {
                            // If there's a search term, navigate to results
                            performComprehensiveSearch(searchValue);
                        } else {
                            // If no search term, toggle the desktop search dropdown
                            if (searchDropdown.classList.contains('active')) {
                                hideDesktopSearchDropdown();
                            } else {
                                showDesktopSearchDropdown();
                                searchInput.focus();
                            }
                        }
                    }
                });
            }

            // ==================== COMPREHENSIVE SEARCH FUNCTION ====================

            function performComprehensiveSearch(searchTerm) {
                // Navigate to all-product page with search parameter
                // This will search across product names, categories, occasions, etc.
                window.location.href = `/collections?search=${encodeURIComponent(searchTerm)}`;
            }

            // Close search button (desktop)
            if (closeSearchBtn) {
                closeSearchBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    searchInput.value = '';
                    searchInput.focus();
                    hideDesktopSearchDropdown();
                    renderDesktopSearchResults(); // Reset to default results
                });
            }

            // Mobile search input events
            if (mobileSearchInput) {
                // Real-time mobile search
                let mobileSearchTimeout;
                mobileSearchInput.addEventListener('input', function() {
                    clearTimeout(mobileSearchTimeout);

                    const searchTerm = this.value.trim();

                    // Debounce the search
                    mobileSearchTimeout = setTimeout(() => {
                        performMobileSearch(searchTerm);
                    }, 300);
                });

                // Handle Enter key in mobile search
                mobileSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            window.location.href = `/search?q=${encodeURIComponent(searchTerm)}`;
                        }
                    }
                });
            }

            // Mobile suggestions input events
            if (mobileSuggestionsInput) {
                let suggestionsTimeout;
                mobileSuggestionsInput.addEventListener('input', function() {
                    clearTimeout(suggestionsTimeout);

                    const searchTerm = this.value.trim();

                    // Debounce the suggestions update
                    suggestionsTimeout = setTimeout(() => {
                        updateMobileSuggestions(searchTerm);
                    }, 200);
                });

                // Handle Enter key in suggestions
                mobileSuggestionsInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            openMobileSearch(searchTerm);
                            hideMobileSuggestions();
                        }
                    }
                });
            }

            // Mobile sidebar search input focus - also opens mobile search
            if (mobileSidebarSearchInput) {
                mobileSidebarSearchInput.addEventListener('focus', function() {
                    if (isMobile()) {
                        openMobileSearch();
                    }
                });
            }

            // Mobile sidebar search icon click - also opens mobile search
            if (mobileSidebarSearchIcon) {
                mobileSidebarSearchIcon.addEventListener('click', function() {
                    if (isMobile()) {
                        openMobileSearch(mobileSidebarSearchInput.value);
                    }
                });
            }

            // Mobile search back button
            if (mobileSearchBack) {
                mobileSearchBack.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeMobileSearch();
                });
            }

            // Mobile search clear button
            if (mobileSearchClear) {
                mobileSearchClear.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileSearchInput.value = '';
                    mobileSearchInput.focus();
                    renderMobileSearchResults();
                });
            }

            // Mobile suggestions back button
            if (mobileSuggestionsBack) {
                mobileSuggestionsBack.addEventListener('click', function(e) {
                    e.stopPropagation();
                    hideMobileSuggestions();
                });
            }

            // Mobile suggestions clear button
            if (mobileSuggestionsClear) {
                mobileSuggestionsClear.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileSuggestionsInput.value = '';
                    mobileSuggestionsInput.focus();
                    updateMobileSuggestions('');
                });
            }

            // Close search when clicking outside (desktop only)
            if (!isMobile()) {
                document.addEventListener('click', function(event) {
                    const isClickInsideSearch = searchContainer && searchContainer.contains(event
                        .target);

                    if (!isClickInsideSearch) {
                        hideDesktopSearchDropdown();
                    }
                });
            }

            // Mobile search input focus for suggestions (when clicking on main search input on mobile)
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    if (isMobile()) {
                        // On mobile, when search input gets focus, open mobile suggestions
                        showMobileSuggestions();
                        updateMobileSuggestions(this.value);
                    }
                });
            }

            // Handle keyboard visibility changes on mobile
            let originalHeight = window.innerHeight;
            window.addEventListener('resize', function() {
                if (!isMobile()) return;

                const newHeight = window.innerHeight;
                const keyboardVisible = newHeight < originalHeight;

                if (keyboardVisible) {
                    // Keyboard is shown - ensure search dropdown is visible
                    if (mobileSearchDropdown.classList.contains('active')) {
                        // Adjust scroll position to keep input visible
                        setTimeout(() => {
                            mobileSearchResults.scrollTop = 0;
                        }, 100);
                    }
                } else {
                    // Keyboard is hidden - check if we need to close search
                    if (mobileSearchInput.value.trim() === '' && mobileSearchDropdown.classList
                        .contains('active')) {
                        // User might have closed keyboard without searching
                        // Keep search open but reset results
                        renderMobileSearchResults();
                    }
                }

                originalHeight = newHeight;
            });

            // Handle back button on Android/iOS
            window.addEventListener('popstate', function(event) {
                if (isMobile() && mobileSearchDropdown.classList.contains('active')) {
                    closeMobileSearch();
                    event.preventDefault();
                }
            });
        }

        // Initialize search functionality
        initSearch();

        // ==================== DESKTOP CATEGORIES MENU ====================
        const categoriesMenu = document.getElementById('categories-wrapper-menu');
        const desktopNavLinks = document.querySelectorAll('.desktop-nav-link');
        const categorySidebarBtns = document.querySelectorAll('.category-sidebar-btn');
        const categoryContents = document.querySelectorAll('.category-content');

        // Variables for hover timeout
        let hideMenuTimeout;
        let HOVER_DELAY = 150;
        let isOverMenu = false;
        let isOverNav = false;

        // Initialize categories menu
        if (categoriesMenu && desktopNavLinks.length > 0) {
            // Show menu on nav link hover
            desktopNavLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    clearTimeout(hideMenuTimeout);
                    isOverNav = true;

                    const categoryId = this.getAttribute('data-category-id');
                    if (categoryId) {
                        currentCategoryId = categoryId;
                        loadCategoryData(categoryId);
                    }

                    showCategoriesMenu();
                });

                link.addEventListener('mouseleave', function() {
                    isOverNav = false;
                    hideMenuTimeout = setTimeout(() => {
                        if (!isOverMenu) {
                            hideCategoriesMenu();
                        }
                    }, HOVER_DELAY);
                });
            });

            // Menu hover events
            categoriesMenu.addEventListener('mouseenter', function() {
                clearTimeout(hideMenuTimeout);
                isOverMenu = true;
            });

            categoriesMenu.addEventListener('mouseleave', function() {
                isOverMenu = false;
                hideMenuTimeout = setTimeout(() => {
                    if (!isOverNav) {
                        hideCategoriesMenu();
                    }
                }, HOVER_DELAY);
            });
        }

        // Load category data from API
        async function loadCategoryData(categoryId) {
            const categoryData = await fetchCategoryData(categoryId);
            renderCategoryMenuData(categoryData);
        }

        // Category sidebar button functionality
        if (categorySidebarBtns.length > 0) {
            categorySidebarBtns.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    // Remove active class from all buttons
                    categorySidebarBtns.forEach(b => {
                        b.classList.remove('active', 'bg-white');
                        b.classList.add('bg-[#fdebdc]');
                    });

                    // Add active class to current button
                    this.classList.add('active', 'bg-white');
                    this.classList.remove('bg-[#fdebdc]');

                    // Show corresponding content
                    const targetId = this.getAttribute('data-target');
                    categoryContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                    });

                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                        targetContent.classList.add('active');
                    }
                });
            });
        }

        // Click outside to close menu
        document.addEventListener('click', function(event) {
            if (categoriesMenu && categoriesMenu.classList.contains('visible')) {
                const isClickInsideMenu = categoriesMenu.contains(event.target);
                const isClickOnNavLink = Array.from(desktopNavLinks).some(link => link.contains(event
                    .target));

                if (!isClickInsideMenu && !isClickOnNavLink) {
                    hideCategoriesMenu();
                }
            }
        });

        // ==================== MOBILE MEGA MENU ====================
        const megaMenu = document.querySelector('.mega-menu');
        const backButtons = document.querySelectorAll('.back-button');
        const topLevelLinks = document.querySelectorAll('.top-level-link');
        const submenuToggles = document.querySelectorAll('.submenu-toggle');

        if (megaMenu && backButtons.length > 0) {
            // Reset function for mobile mega menu
            function resetMobileMenu() {
                // Remove active classes
                document.querySelectorAll('.top-level-active, .active').forEach(el => {
                    el.classList.remove('top-level-active', 'active');
                });

                // Hide all back buttons
                backButtons.forEach(btn => {
                    btn.style.display = 'none';
                });

                // Show all top level items
                document.querySelectorAll('.top-level-item').forEach(item => {
                    item.style.display = 'block';
                });

                // Reset all submenus
                document.querySelectorAll('.submenu').forEach(submenu => {
                    submenu.style.maxHeight = '0';
                    submenu.classList.remove('active');
                });

                // Remove top-level-open class
                megaMenu.classList.remove('top-level-open');
            }

            // Back button functionality
            backButtons.forEach(btn => {
                btn.addEventListener('click', resetMobileMenu);
            });

            // Top level link clicks
            topLevelLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const parentItem = this.closest('.top-level-item');
                    const isActive = parentItem.classList.contains('top-level-active');
                    const submenu = this.nextElementSibling;

                    if (isActive) {
                        resetMobileMenu();
                    } else {
                        // Close any open menu first
                        resetMobileMenu();

                        // Open this menu
                        parentItem.classList.add('top-level-active');
                        megaMenu.classList.add('top-level-open');

                        // Show back button
                        const backBtn = parentItem.querySelector('.back-button');
                        if (backBtn) {
                            backBtn.style.display = 'block';
                        }

                        // Hide other top level items
                        document.querySelectorAll('.top-level-item').forEach(item => {
                            if (!item.classList.contains('top-level-active')) {
                                item.style.display = 'none';
                            }
                        });

                        // Open submenu with animation
                        if (submenu) {
                            setTimeout(() => {
                                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                                submenu.classList.add('active');
                            }, 10);
                        }
                    }
                });
            });

            // Submenu toggle clicks
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const submenu = this.nextElementSibling;
                    const isActive = this.classList.contains('active');

                    // Close other submenus at same level
                    const parentSubmenu = this.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.querySelectorAll('.submenu-toggle.active').forEach(
                            activeToggle => {
                                if (activeToggle !== this) {
                                    activeToggle.classList.remove('active');
                                    const activeSubmenu = activeToggle.nextElementSibling;
                                    if (activeSubmenu) {
                                        activeSubmenu.style.maxHeight = '0';
                                        activeSubmenu.classList.remove('active');
                                    }
                                }
                            });
                    }

                    // Toggle current submenu
                    if (isActive) {
                        this.classList.remove('active');
                        if (submenu) {
                            submenu.style.maxHeight = '0';
                            submenu.classList.remove('active');
                        }
                    } else {
                        this.classList.add('active');
                        if (submenu) {
                            submenu.style.maxHeight = submenu.scrollHeight + 'px';
                            submenu.classList.add('active');
                        }
                    }
                });
            });
        }

        // ==================== MOBILE SIDEBAR ====================
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (mobileMenuBtn && mobileSidebar) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileSidebar.classList.remove('-translate-x-full');
                if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeSidebarBtn && mobileSidebar) {
            closeSidebarBtn.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
                resetMobileMenu(); // Reset mobile menu when closing
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
                resetMobileMenu(); // Reset mobile menu when closing
            });
        }

        // ==================== PROFILE DROPDOWN ====================
        const profileBtn = document.getElementById('profile-btn');
        const accountDropdown = document.getElementById('account-dropdown');

        if (profileBtn && accountDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                accountDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileBtn.contains(event.target) && !accountDropdown.contains(event.target)) {
                    accountDropdown.classList.remove('show');
                }
            });
        }

        // ==================== HELPER FUNCTIONS ====================
        function showCategoriesMenu() {
            clearTimeout(hideMenuTimeout);
            categoriesMenu.classList.remove('hidden');

            if (categoriesMenu) {
                categoriesMenu.classList.add('visible');
            }
        }

        function hideCategoriesMenu() {
            if (categoriesMenu) {
                categoriesMenu.classList.remove('visible');

                // Reset to default state
                if (categorySidebarBtns.length > 0 && categoryContents.length > 0) {
                    categorySidebarBtns.forEach((btn, index) => {
                        btn.classList.remove('active', 'bg-white');
                        btn.classList.add('bg-[#fdebdc]');
                        if (index === 0) {
                            btn.classList.add('active', 'bg-white');
                            btn.classList.remove('bg-[#fdebdc]');
                        }
                    });

                    categoryContents.forEach((content, index) => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                        if (index === 0) {
                            content.classList.remove('hidden');
                            content.classList.add('active');
                        }
                    });
                }
            }
        }

        // Initialize desktop menu to default state
        hideCategoriesMenu();

        // Handle window resize
        // Handle window resize
        let lastWindowWidth = window.innerWidth;
        window.addEventListener('resize', function() {
            const currentWidth = window.innerWidth;
            const widthChanged = currentWidth !== lastWindowWidth;
            lastWindowWidth = currentWidth;

            // If only height changed (likely keyboard show/hide on mobile), do nothing
            if (!widthChanged && isMobile()) {
                return;
            }

            // Close all search dropdowns on real resizes (orientation / breakpoint)
            hideDesktopSearchDropdown();
            closeMobileSearch();
            hideMobileSuggestions();

            // Reset mobile menu if switching to desktop
            if (!isMobile()) {
                if (mobileSidebar && !mobileSidebar.classList.contains('-translate-x-full')) {
                    mobileSidebar.classList.add('-translate-x-full');
                    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        });
    });
</script>