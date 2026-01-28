<style>
    /* Fix z-index stacking */
    #categories-wrapper-menu {
        display: none;
        position: fixed;
        z-index: 20004;
        top: 80px;
        left: 0;
        right: 0;
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
        width:auto;
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
    }
    
    /* Profile dropdown styles */
    #account-dropdown {
        display: none;
    }
    
    #account-dropdown.show {
        display: block;
    }
</style>

<header id="nav-wrapper" class="bg-white shadow-sm sticky top-0 lg:z-[20004] z-[20000] px-3">
    <!-- Top Bar: Special Offer + Product Title (hidden on small screens for product title) -->
    <div class="text-sm text-gray-600 px-6 py-2 border-b">
        <div class="container mx-auto flex smx:flex-nowrap flex-wrap smx:justify-between justify-center items-center">
            <p>
                Special offer get <span class="font-semibold">25% off</span>
                <a href="#" class="underline ml-1">T&amp;C</a>
            </p>
            <p class="hidden md:inline-block text-2xl font-semibold tracking-wide">
                Aiman
            </p>
            <p class="text-gray-700">Womens Denim Jacket (Blue)</p>
        </div>
    </div>

    <!-- Main Header -->
    <div class=" py-4 flex items-center justify-between gap-6 container mx-auto">
        <!-- Left: Logo + Desktop Nav -->
        <div class="lgg:flex hidden items-center gap-8 flex-1">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img class="h-[50px] w-auto" src="{{asset('web/images/company-logo/aiman-royal-logo.webp')}}" alt="">
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lgg:flex items-center gap-6 text-gray-700 font-medium">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" 
                           class="hover:text-black desktop-nav-link"
                           data-category="{{ $category->name }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                @else
                    <a href="#" class="hover:text-black desktop-nav-link" data-category="Salwar Kameez">Salwar Kameez</a>
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
        <div class="flex items-center gap-4">
            <!-- Search (visible on sm and up) -->
            <div class="relative hidden sm:block">
                <input
                    type="text"
                    placeholder="Search here"
                    class="pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none w-56" />
                <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
            </div>

            <!-- Mobile Search Icon -->
            <button class="sm:hidden text-gray-700 hover:text-black">
                <i class="fa-solid fa-magnifying-glass text-lg"></i>
            </button>

            <!-- Icons -->
            <button class="text-gray-700 hover:text-black">
                <i class="fa-regular fa-heart text-lg"></i>
            </button>

            <button onclick="window.location.href='{{ route('cart.index') }}'" class="text-gray-700 hover:text-black">
                <i class="fa-solid fa-bag-shopping text-lg"></i>
            </button>

            <!-- Profile Section -->
            @auth
            <!-- Profile with Dropdown (Logged In) -->
            <div class="relative">
                <button id="profile-btn" class="flex items-center gap-2 text-gray-700 hover:text-black">
                    <img src="https://i.pravatar.cc/32" alt="User" class="w-8 h-8 rounded-full object-cover" />
                    <span class="hidden sm:block text-sm">{{ Auth::user()->name }}</span>
                    <i class="fa-solid fa-chevron-down text-xs hidden sm:block"></i>
                </button>

                <!-- Account Dropdown -->
                <div id="account-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Wishlist</a>
                    <hr class="my-1" />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Login Button (Not Logged In) -->
            <a href="{{ route('page.login') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-user text-sm"></i>
                <span class="text-sm font-medium">Login</span>
            </a>
            @endauth
        </div>
    </div>
</header>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed inset-y-0 left-0 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-[20005] lg:hidden w-full max-w-[400px]">
    <div class="flex items-center justify-between p-6 border-b">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-700 rounded-sm"></div>
            <span class="text-xl font-semibold">Aiman</span>
        </div>
        <button id="close-sidebar-btn" class="text-gray-700 hover:text-black">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
    </div>

    <!-- Mobile Search -->
    <div class="p-6 border-b">
        <div class="relative">
            <input type="text" placeholder="Search here" class="w-full pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none" />
            <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <nav class="py-6 bg-[#fdebdc] h-full overflow-y-auto">
        <div class="mega-menu">
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                    <div class="menu-item has-submenu top-level-item">
                        <button class="back-button bg-white" style="background-color: white !important; display: none;">← Back to Main Menu</button>
                        <a href="{{ route('category.show', $category->slug) }}" class="menu-link top-level-link bg-white rounded-[7px] my-2 mb-0 mx-0 ">
                            {{ $category->name }} <i class="fa-solid fa-angle-right"></i>
                        </a>
                        <ul class="submenu">
                            <li class="menu-item has-submenu">
                                <div class="menu-link submenu-toggle">
                                    Style <i class="fa-solid fa-angle-right"></i>
                                </div>
                                <ul class="submenu bg-white mx-[23px] rounded-[6px] pl-[5px]">
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Red Saree</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Salwar Kameez</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Lehenga</a></li>
                                </ul>
                            </li>
                            <li class="menu-item has-submenu">
                                <div class="menu-link submenu-toggle">
                                    Occasion <i class="fa-solid fa-angle-right"></i>
                                </div>
                                <ul class="submenu bg-white mx-[23px] rounded-[6px] pl-[5px]">
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Red Saree</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Salwar Kameez</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Lehenga</a></li>
                                </ul>
                            </li>
                            <li class="menu-item has-submenu">
                                <div class="menu-link submenu-toggle">
                                    Collection <i class="fa-solid fa-angle-right"></i>
                                </div>
                                <ul class="submenu bg-white mx-[23px] rounded-[6px] pl-[5px]">
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Red Saree</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Salwar Kameez</a></li>
                                    <li class="menu-item mb-1"><a href="#" class="menu-link">Lehenga</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endforeach
            @else
                <!-- Default menu items -->
                <div class="menu-item has-submenu top-level-item">
                    <button class="back-button bg-white" style="background-color: white !important; display: none;">← Back to Main Menu</button>
                    <a href="#" class="menu-link top-level-link bg-white rounded-[7px] my-2 mb-0 mx-0">
                        Lahenga <i class="fa-solid fa-angle-right"></i>
                    </a>
                    <ul class="submenu">
                        <li class="menu-item has-submenu">
                            <div class="menu-link submenu-toggle">
                                Style <i class="fa-solid fa-angle-right"></i>
                            </div>
                            <ul class="submenu bg-white mx-[23px] rounded-[6px] pl-[5px]">
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Red Saree</a></li>
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Salwar Kameez</a></li>
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Lehenga</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="menu-item has-submenu top-level-item">
                    <button class="back-button bg-white" style="background-color: white !important; display: none;">← Back to Main Menu</button>
                    <a href="#" class="menu-link top-level-link bg-white rounded-[7px] my-2 mb-0 mx-0">
                        Salwar Kameez <i class="fa-solid fa-angle-right"></i>
                    </a>
                    <ul class="submenu">
                        <li class="menu-item has-submenu">
                            <div class="menu-link submenu-toggle">
                                Style <i class="fa-solid fa-angle-right"></i>
                            </div>
                            <ul class="submenu bg-white mx-[23px] rounded-[6px] pl-[5px]">
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Red Saree</a></li>
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Salwar Kameez</a></li>
                                <li class="menu-item mb-1"><a href="#" class="menu-link">Lehenga</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
</div>

<!-- Overlay for mobile sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[20004] lg:hidden"></div>

<!-- Categories Menu for Desktop -->
<div id="categories-wrapper-menu" class="fixed lg:z-[20004] z-[20000] w-full mx-auto lg:block hidden top-[80px]">
    <div class="max-w-[calc(100%-50px)] mx-auto my-10 shadow-lg rounded-xl overflow-hidden bg-white">
        <div class="flex">
            <!-- Left Sidebar -->
            <div class="bg-[#fdebdc] p-8 flex flex-col gap-1 pr-0 min-w-[300px] text-left">
                <button class="category-sidebar-btn active px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left" data-target="style-products">
                    Style
                </button>
                <button class="category-sidebar-btn px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left" data-target="occation-products">
                    Occasion
                </button>
                <button class="category-sidebar-btn px-6 py-2 rounded-full rounded-r-none text-lg font-medium w-full text-left" data-target="collection-products">
                    Collection
                </button>
            </div>

            <!-- Product Section -->
            <div class="flex-1 bg-[url('https://www.transparenttextures.com/patterns/geometry.png')] bg-opacity-20 py-8 pl-8 pr-4">
                <!-- Style Products -->
                <div id="style-products" class="category-content active">
                    <div class="flex flex-row justify-between gap-3 items-start">
                        <div class="w-full flex flex-row gap-4">
                            <div>
                                <ul class="px-0">
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                </ul>
                            </div>
                            <div>
                                <ul class="px-0">
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                    <li class="mb-1 text-[1.5rem]">Red Saree</li>
                                </ul>
                            </div>
                        </div>
                        <div class="xl:max-w-[300px] lg:max-w-[270px] flex flex-col gap-2">
                            <div class="overflow-hidden rounded-md max-h-[500px] w-full relative">
                                <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">
                                <div class="absolute bottom-[10px] w-full flex justify-center flex-col items-center gap-3">
                                    <p class="text-[2rem] font-bold text-white text-center">Orlieve Striv</p>
                                    <button class="px-6 py-2 text-[1.2rem] font-bold bg-white">Shop Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Occasion Products -->
                <div id="occation-products" class="category-content hidden">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row justify-between gap-3 xll:items-center items-start">
                            <div class="w-full xll:grid-cols-4 xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 grid gap-3">
                                <!-- Product items here -->
                            </div>
                            <div class="xl:max-w-[300px] lg:max-w-[270px] flex flex-col gap-2">
                                <div class="overflow-hidden rounded-md max-h-[500px] w-full">
                                    <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">
                                </div>
                                <p class="text-[2rem] font-bold text-gray-700 text-center">Orlieve Striv</p>
                            </div>
                        </div>
                        <button class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit">Show More</button>
                    </div>
                </div>

                <!-- Collection Products -->
                <div id="collection-products" class="category-content hidden">
                    <div class="grid xll:grid-cols-4 xl:grid-cols-3 lg:grid-cols-2 gap-3">
                        <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <!-- Image Wrapper -->
                <div class="relative rounded-xl overflow-hidden">
                  <img src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center">



                  <!-- Wishlist Heart Icon (Top Right) -->
                  <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>


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

                </div>
              </div>
              <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <!-- Image Wrapper -->
                <div class="relative rounded-xl overflow-hidden">
                  <img src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center">



                  <!-- Wishlist Heart Icon (Top Right) -->
                  <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>


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

                </div>
              </div>
              <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <!-- Image Wrapper -->
                <div class="relative rounded-xl overflow-hidden">
                  <img src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center">



                  <!-- Wishlist Heart Icon (Top Right) -->
                  <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>


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

                </div>
              </div>
              <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <!-- Image Wrapper -->
                <div class="relative rounded-xl overflow-hidden">
                  <img src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="Silver Lehenga" class="w-full h-[340px] object-cover object-top object-center">



                  <!-- Wishlist Heart Icon (Top Right) -->
                  <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                  </button>


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

                </div>
              </div>
                    </div>
                    <button class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit">Show More</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            if (categoriesMenu && categoriesMenu.style.display === 'block') {
                const isClickInsideMenu = categoriesMenu.contains(event.target);
                const isClickOnNavLink = Array.from(desktopNavLinks).some(link => link.contains(event.target));
                
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
                        parentSubmenu.querySelectorAll('.submenu-toggle.active').forEach(activeToggle => {
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
            if (categoriesMenu) {
                categoriesMenu.style.display = 'block';
            }
        }
        
        function hideCategoriesMenu() {
            if (categoriesMenu) {
                categoriesMenu.style.display = 'none';
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
    });
</script>