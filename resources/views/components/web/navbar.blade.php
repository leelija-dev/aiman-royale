  <style>
    /* Fix z-index stacking */


    #categories-wrapper-menu {
      display: none;
      /* Start hidden */
      position: fixed;
      z-index: 20004;
      top: 80px;
      /* Adjust based on your header height */
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
  </style>

  <header
    id="nav-wrapper"
    class="bg-white shadow-sm sticky top-0 lg:z-[20004] z-[20000] px-3">
    <!-- Top Bar: Special Offer + Product Title (hidden on small screens for product title) -->
    <div class="text-sm text-gray-600 px-6 py-2 border-b">
      <div
        class="container mx-auto flex smx:flex-nowrap flex-wrap smx:justify-between justify-center items-center">
        <p>
          Special offer get <span class="font-semibold">25% off</span>
          <a href="#" class="underline ml-1">T&amp;C</a>
        </p>
        <p
          class="hidden md:inline-block text-2xl font-semibold tracking-wide">
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
          <!-- <div class="w-8 h-8 bg-blue-700 rounded-sm"></div> -->
          <img class="h-[50px] w-auto" src="{{asset('web/images/company-logo/aiman-royal-logo.webp')}}" alt="">
        </div>

        <!-- Desktop Navigation -->
        <nav
          class="hidden lgg:flex items-center gap-6 text-gray-700 font-medium">
          @if(isset($categories) && count($categories) > 0)
          @foreach($categories as $category)
          <a href="{{ route('category.show', $category->slug) }}" class="hover:text-black">{{ $category->name }}</a>
          @endforeach
          @else
          <a href="#" class="hover:text-black">Salwar Kameez</a>
          <a href="#" class="hover:text-black">Lehengas</a>
          <a href="#" class="hover:text-black">Bridal</a>
          <a href="#" class="hover:text-black">Wedding</a>
          @endif
        </nav>
      </div>

      <!-- Mobile Menu Button -->
      <button
        id="mobile-menu-btn"
        class="lgg:hidden text-gray-700 hover:text-black">
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
          <i
            class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
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
          <button
            id="profile-btn"
            class="flex items-center gap-2 text-gray-700 hover:text-black">
            <img
              src="https://i.pravatar.cc/32"
              alt="User"
              class="w-8 h-8 rounded-full object-cover" />
            <span class="hidden sm:block text-sm">{{ Auth::user()->name }}</span>
            <i class="fa-solid fa-chevron-down text-xs hidden sm:block"></i>
          </button>

          <!-- Account Dropdown -->
          <div
            id="account-dropdown"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden z-50">
            <a
              href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
            <a
              href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
            <a
              href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Wishlist</a>
            <hr class="my-1" />
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button
                type="submit"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
  <div
    id="mobile-sidebar"
    class="fixed inset-y-0 left-0  bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-[20005] lg:hidden w-full max-w-[400px]">
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
        <input
          type="text"
          placeholder="Search here"
          class="w-full pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none" />
        <i
          class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <nav class="py-6">
      <ul class="space-y-4 text-gray-700 font-medium">
        @if(isset($categories) && count($categories) > 0)
        @foreach($categories as $category)
        <!-- <li>
          <div>
            <a href="{{ route('category.show', $category->slug) }}" class="block hover:text-black w-full flex gap-1 justify-between items-center">{{ $category->name }}<i class="fa-solid fa-angle-right"></i></a>
            <ul>
              <li>
                <div class="flex justify-between items-center gap-1">
                  Salwar Kameez <i class="fa-solid fa-angle-right"></i>
                </div>
                <div>
                  <ul>
                    <li>
                      Red Saree
                    </li>
                    <li>
                      Salwar Kameez
                    </li>
                    <li>
                      Lehenga
                    </li>

                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li> -->

        <ul class="mega-menu">
          <li class="menu-item has-submenu top-level-item">
            <button class="back-button">← Back to Main Menu</button>
            <a href="{{ route('category.show', $category->slug) }}" class="menu-link top-level-link">
              Lahenga <i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="submenu">
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Style <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Ocation <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Collection <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <!-- You can add more level-2 items here -->
            </ul>
          </li>
          <li class="menu-item has-submenu top-level-item">
            <button class="back-button">← Back to Main Menu</button>
            <a href="{{ route('category.show', $category->slug) }}" class="menu-link top-level-link">
              Salwar Kameez <i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="submenu">
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Style <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Ocation <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <li class="menu-item has-submenu">
                <div class="menu-link submenu-toggle">
                  Collection <i class="fa-solid fa-angle-right"></i>
                </div>
                <ul class="submenu">
                  <li class="menu-item">
                    <a href="#" class="menu-link">Red Saree</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Salwar Kameez</a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">Lehenga</a>
                  </li>
                </ul>
              </li>
              <!-- You can add more level-2 items here -->
            </ul>
          </li>

          
        </ul>
        @endforeach
        @else
        <li>
          <div>
            <a href="{{ route('category.show', $category->slug) }}" class="block hover:text-black w-full flex gap-1 justify-between items-center">Lahenga<i class="fa-solid fa-angle-right"></i></a>
            <ul>
              <li>
                <div class="flex justify-between items-center gap-1">
                  Salwar Kameez <i class="fa-solid fa-angle-right"></i>
                </div>
                <div>
                  <ul>
                    <li>
                      Red Saree
                    </li>
                    <li>
                      Salwar Kameez
                    </li>
                    <li>
                      Lehenga
                    </li>

                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div>
            <a href="{{ route('category.show', $category->slug) }}" class="block hover:text-black w-full flex gap-1 justify-between items-center">Lahenga<i class="fa-solid fa-angle-right"></i></a>
            <ul>
              <li>
                <div class="flex justify-between items-center gap-1">
                  Salwar Kameez <i class="fa-solid fa-angle-right"></i>
                </div>
                <div>
                  <ul>
                    <li>
                      Red Saree
                    </li>
                    <li>
                      Salwar Kameez
                    </li>
                    <li>
                      Lehenga
                    </li>

                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li>
        @endif
      </ul>
    </nav>
  </div>

  <!-- Overlay for mobile sidebar -->
  <div
    id="sidebar-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-[20004] lg:hidden"></div>



  <div id="categories-wrapper-menu" class="fixed lg:z-[20004] z-[20000] w-full mx-auto lg:block  hidden top-[80px]">
    <div class="max-w-[calc(100%-50px)] mx-auto my-10 shadow-lg rounded-xl overflow-hidden bg-white  ">
      <div class="flex">

        <!-- Left Sidebar -->
        <div class=" bg-[#fdebdc] p-8 flex flex-col gap-1 pr-0 min-w-[300px] text-left">
          <button class=" px-6 py-2 rounded-full rounded-r-none text-lg font-medium  w-full text-left ">
            Style
          </button>
          <button class="bg-white px-6 py-2 rounded-full rounded-r-none text-lg font-medium   w-full text-left ">
            Ocation
          </button>
          <button class=" px-6 py-2 rounded-full rounded-r-none text-lg font-medium   w-full text-left ">
            Collection
          </button>


        </div>

        <!--  Product Section -->
        <div class="flex-1  bg-[url('https://www.transparenttextures.com/patterns/geometry.png')] bg-opacity-20 py-8 pl-8 pr-4">

          <div id="style-products" class="flex flex-col gap-2   pr-4">
            <div class="flex flex-row justify-between gap-3 items-start">



              <div class="w-full flex flex-row  gap-4">
                <div>
                  <ul class="px-0 ">
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                  </ul>

                </div>
                <div>
                  <ul class="px-0 ">
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                    <li class="mb-1 text-[1.5rem] ">Red Saree</li>
                  </ul>

                </div>





              </div>
              <div class="xl:max-w-[300px] lg:max-w-[270px] flex flex-col gap-2">
                <div class="overflow-hidden rounded-md  max-h-[500px] w-full relative">
                  <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">
                  <div class="absolute bottom-[10px] w-full flex justify-center flex-col items-center gap-3">
                    <p class="text-[2rem] font-bold text-white text-center">
                      Orlieve Striv
                    </p>
                    <button class="px-6 py-2 text-[1.2rem] font-bold bg-white ">Shop Now</button>
                  </div>

                </div>

              </div>
            </div>



          </div>
          <div id="occation-products" class="flex flex-col gap-2  hidden xll:max-h-[590px] max-h-[400px] overflow-y-auto pr-4">
            <div class="flex flex-row justify-between gap-3 xll:items-center items-start">



              <div class="w-full xll:grid-cols-4  xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 grid gap-3">
                <div class="">
                  <div class="overflow-hidden rounded-md ">
                    <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">

                  </div>

                  <p class="xl:text-[22px] lg:text-xl md:text-lg text-md  text-gray-700 mt-2 text-center">
                    Red Saree
                  </p>


                </div>
                <div class="">
                  <div class="overflow-hidden rounded-md ">
                    <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">

                  </div>

                  <p class="xl:text-[22px] lg:text-xl md:text-lg text-md  text-gray-700 mt-2 text-center">
                    Red Saree
                  </p>


                </div>
                <div class="">
                  <div class="overflow-hidden rounded-md ">
                    <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">

                  </div>

                  <p class="xl:text-[22px] lg:text-xl md:text-lg text-md  text-gray-700 mt-2 text-center">
                    Red Saree
                  </p>


                </div>
                <div class="">
                  <div class="overflow-hidden rounded-md ">
                    <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">

                  </div>

                  <p class="xl:text-[22px] lg:text-xl md:text-lg text-md  text-gray-700 mt-2 text-center">
                    Red Saree
                  </p>


                </div>



              </div>
              <div class="xl:max-w-[300px] lg:max-w-[270px] flex flex-col gap-2">
                <div class="overflow-hidden rounded-md  max-h-[500px] w-full">
                  <img class="w-full h-full object-cover aspect-auto" src="{{asset('web/images/banner-images/red-plazo-6.webp')}}" alt="">

                </div>
                <p class="text-[2rem] font-bold text-gray-700 text-center">
                  Orlieve Striv
                </p>
              </div>
            </div>

            <!-- Show More Button -->
            <button class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit ">
              Show More
            </button>

          </div>
          <div id="collection-products" class="flex flex-col gap-2 hidden max-h-[590px] overflow-y-auto pr-4">
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

            <!-- Show More Button -->
            <button class="mt-4 bg-black text-white px-8 py-3 rounded-lg shadow-md hover:bg-gray-800 transition w-fit ">
              Show More
            </button>

          </div>



        </div>




      </div>
    </div>

  </div>



  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get elements
      const navLinks = document.querySelectorAll('nav a');
      const categoriesMenu = document.getElementById('categories-wrapper-menu');
      const styleProducts = document.getElementById('style-products');
      const occasionProducts = document.getElementById('occation-products');
      const collectionProducts = document.getElementById('collection-products');
      const sidebarButtons = document.querySelectorAll('.bg-\\[\\#fdebdc\\] button');

      // Check if elements exist
      if (!categoriesMenu || !styleProducts || !occasionProducts || !collectionProducts) {
        console.error('Required elements not found');
        return;
      }

      // Variables for hover timeout management
      let menuTimeout;
      let linkTimeout;
      const HOVER_DELAY = 150; // milliseconds delay for hover

      // Track if mouse is over menu
      let isOverMenu = false;
      let isOverNav = false;

      // Function to show the categories menu
      function showCategoriesMenu() {
        clearTimeout(menuTimeout);
        categoriesMenu.style.display = 'block';
        isOverMenu = true;
      }

      // Function to hide the categories menu
      function hideCategoriesMenu() {
        isOverMenu = false;
        menuTimeout = setTimeout(() => {
          if (!isOverNav && !isOverMenu) {
            categoriesMenu.style.display = 'none';
            // Reset all product sections to default (show style)
            resetProductSections();
          }
        }, HOVER_DELAY);
      }

      // Function to reset product sections to default (show style)
      function resetProductSections() {
        if (styleProducts) styleProducts.classList.remove('hidden');
        if (occasionProducts) occasionProducts.classList.add('hidden');
        if (collectionProducts) collectionProducts.classList.add('hidden');

        // Reset sidebar button styles
        if (sidebarButtons && sidebarButtons.length > 0) {
          sidebarButtons.forEach(button => {
            button.classList.remove('bg-white');
            button.classList.add('bg-[#fdebdc]');
          });
          sidebarButtons[0].classList.remove('bg-[#fdebdc]');
          sidebarButtons[0].classList.add('bg-white');
        }
      }

      // Function to switch product sections
      function switchProductSection(sectionToShow) {
        // Hide all sections
        if (styleProducts) styleProducts.classList.add('hidden');
        if (occasionProducts) occasionProducts.classList.add('hidden');
        if (collectionProducts) collectionProducts.classList.add('hidden');

        // Show the requested section
        if (sectionToShow) sectionToShow.classList.remove('hidden');
      }

      // Add hover event listeners to desktop nav links
      navLinks.forEach(link => {
        link.addEventListener('mouseenter', function(e) {
          clearTimeout(linkTimeout);
          isOverNav = true;
          showCategoriesMenu();
        });

        link.addEventListener('mouseleave', function(e) {
          isOverNav = false;
          linkTimeout = setTimeout(() => {
            if (!isOverMenu) {
              hideCategoriesMenu();
            }
          }, HOVER_DELAY);
        });
      });

      // Add hover event listeners to categories menu
      if (categoriesMenu) {
        categoriesMenu.addEventListener('mouseenter', function() {
          clearTimeout(menuTimeout);
          isOverMenu = true;
        });

        categoriesMenu.addEventListener('mouseleave', function() {
          isOverMenu = false;
          hideCategoriesMenu();
        });
      }

      // Add hover event listeners to sidebar buttons
      if (sidebarButtons && sidebarButtons.length > 0) {
        sidebarButtons.forEach((button, index) => {
          button.addEventListener('mouseenter', function() {
            // Update button styles
            sidebarButtons.forEach(btn => {
              btn.classList.remove('bg-white');
              btn.classList.add('bg-[#fdebdc]');
            });
            this.classList.remove('bg-[#fdebdc]');
            this.classList.add('bg-white');

            // Switch to corresponding product section
            switch (index) {
              case 0:
                switchProductSection(styleProducts);
                break;
              case 1:
                switchProductSection(occasionProducts);
                break;
              case 2:
                switchProductSection(collectionProducts);
                break;
              default:
                switchProductSection(styleProducts);
            }
          });
        });
      }

      // Initialize with style section visible by default
      resetProductSections();

      // Add click event listener to close menu when clicking outside
      document.addEventListener('click', function(event) {
        const isClickInsideMenu = categoriesMenu.contains(event.target);
        const isClickOnNavLink = Array.from(navLinks).some(link => link.contains(event.target));

        if (!isClickInsideMenu && !isClickOnNavLink && categoriesMenu.style.display === 'block') {
          categoriesMenu.style.display = 'none';
          resetProductSections();
        }
      });

      // Mobile menu functionality (already in your code, but ensure it doesn't interfere)
      const mobileMenuBtn = document.getElementById('mobile-menu-btn');
      const mobileSidebar = document.getElementById('mobile-sidebar');
      const closeSidebarBtn = document.getElementById('close-sidebar-btn');
      const sidebarOverlay = document.getElementById('sidebar-overlay');

      if (mobileMenuBtn && mobileSidebar) {
        mobileMenuBtn.addEventListener('click', function() {
          mobileSidebar.classList.remove('-translate-x-full');
          if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
        });
      }

      if (closeSidebarBtn && mobileSidebar) {
        closeSidebarBtn.addEventListener('click', function() {
          mobileSidebar.classList.add('-translate-x-full');
          if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
        });
      }

      if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
          mobileSidebar.classList.add('-translate-x-full');
          sidebarOverlay.classList.add('hidden');
        });
      }
    });
  </script>


  <script>
   document.addEventListener('DOMContentLoaded', () => {
  const megaMenu = document.querySelector('.mega-menu');
  const backButtons = document.querySelectorAll('.back-button');
  
  // Reset function to show initial state - INSTANT
  function resetToInitialState() {
    // Remove all active classes
    document.querySelectorAll('.active, .top-level-active').forEach(el => {
      el.classList.remove('active', 'top-level-active');
    });
    
    // Remove top-level-open class
    megaMenu.classList.remove('top-level-open');
    
    // Hide all back buttons INSTANTLY
    backButtons.forEach(button => {
      button.style.display = 'none';
    });
    
    // Show all top level items INSTANTLY
    document.querySelectorAll('.top-level-item').forEach(item => {
      item.style.display = 'block';
      // Remove any inline max-height from submenus
      const submenu = item.querySelector('.submenu');
      if (submenu) {
        submenu.style.maxHeight = '';
        submenu.style.transition = 'none'; // Remove transition temporarily
      }
    });
    
    // Show all top level links
    document.querySelectorAll('.top-level-link').forEach(link => {
      link.style.display = 'flex';
    });
    
    // Reset all submenus to hidden INSTANTLY - no transition
    document.querySelectorAll('.submenu').forEach(submenu => {
      submenu.classList.remove('active');
      submenu.style.maxHeight = '0';
      submenu.style.transition = 'none'; // Disable transition for instant hide
    });
    
    // Re-enable transitions after a tiny delay
    setTimeout(() => {
      document.querySelectorAll('.submenu').forEach(submenu => {
        submenu.style.transition = '';
      });
    }, 10);
  }
  
  // Add back button functionality to ALL back buttons
  backButtons.forEach(button => {
    button.addEventListener('click', resetToInitialState);
  });

  // Handle top-level menu clicks (Lahenga, Salwar Kameez)
  document.querySelectorAll('.top-level-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      const parentItem = this.closest('.top-level-item');
      const isAlreadyActive = parentItem.classList.contains('top-level-active');
      const submenu = this.nextElementSibling;
      
      if (isAlreadyActive) {
        // If already active, close everything
        resetToInitialState();
      } else {
        // Close any other open top-level first
        resetToInitialState();
        
        // Open this top-level
        parentItem.classList.add('top-level-active');
        this.classList.add('active');
        
        // Force the submenu to open WITH transition
        if (submenu) {
          submenu.classList.add('active');
          submenu.style.maxHeight = '1000px';
          submenu.style.transition = ''; // Ensure transition is enabled
        }
        
        // Activate mega menu state
        megaMenu.classList.add('top-level-open');
        
        // Show the back button inside this specific top-level item
        const currentBackButton = parentItem.querySelector('.back-button');
        if (currentBackButton) {
          currentBackButton.style.display = 'block';
        }
        
        // Hide other top level items
        document.querySelectorAll('.top-level-item').forEach(item => {
          if (!item.classList.contains('top-level-active')) {
            item.style.display = 'none';
          }
        });
      }
    });
  });

  // Handle inner accordion clicks (Style, Ocation, Collection, etc.)
  document.querySelectorAll('.submenu-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      e.stopPropagation();
      
      const isAlreadyActive = this.classList.contains('active');
      const submenu = this.nextElementSibling;
      
      // Close other open items at the same level
      const parentSubmenu = this.closest('.submenu');
      if (parentSubmenu) {
        const siblings = parentSubmenu.querySelectorAll('.submenu-toggle.active');
        siblings.forEach(sib => {
          if (sib !== this) {
            sib.classList.remove('active');
            const sibSubmenu = sib.nextElementSibling;
            if (sibSubmenu) {
              sibSubmenu.classList.remove('active');
              sibSubmenu.style.maxHeight = '0';
            }
          }
        });
      }
      
      // Toggle current - WITH transition for smooth accordion
      if (isAlreadyActive) {
        this.classList.remove('active');
        if (submenu) {
          submenu.classList.remove('active');
          submenu.style.maxHeight = '0';
        }
      } else {
        this.classList.add('active');
        if (submenu) {
          submenu.classList.add('active');
          submenu.style.maxHeight = '500px';
        }
      }
    });
  });

  // Handle inner link clicks (Red Saree, etc.)
  document.querySelectorAll('.submenu .menu-link[href="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      // Add your navigation logic here
      console.log('Navigating to:', this.textContent);
    });
  });
});
  </script>