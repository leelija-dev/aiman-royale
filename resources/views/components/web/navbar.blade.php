  <header
      id="nav-wrapper"
      class="bg-white shadow-sm sticky top-0 lg:z-[20004] z-[20000] px-3"
    >
      <!-- Top Bar: Special Offer + Product Title (hidden on small screens for product title) -->
      <div class="text-sm text-gray-600 px-6 py-2 border-b">
        <div
          class="container mx-auto flex smx:flex-nowrap flex-wrap smx:justify-between justify-center items-center"
        >
          <p>
            Special offer get <span class="font-semibold">25% off</span>
            <a href="#" class="underline ml-1">T&amp;C</a>
          </p>
          <p
            class="hidden md:inline-block text-2xl font-semibold tracking-wide"
          >
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
            <div class="w-8 h-8 bg-blue-700 rounded-sm"></div>
          </div>

          <!-- Desktop Navigation -->
          <nav
            class="hidden lgg:flex items-center gap-6 text-gray-700 font-medium"
          >
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
          class="lgg:hidden text-gray-700 hover:text-black"
        >
          <i class="fa-solid fa-bars text-2xl"></i>
        </button>

        <!-- Right Section -->
        <div class="flex items-center gap-4">
          <!-- Search (visible on sm and up) -->
          <div class="relative hidden sm:block">
            <input
              type="text"
              placeholder="Search here"
              class="pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none w-56"
            />
            <i
              class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"
            ></i>
          </div>

          <!-- Mobile Search Icon -->
          <button class="sm:hidden text-gray-700 hover:text-black">
            <i class="fa-solid fa-magnifying-glass text-lg"></i>
          </button>

          <!-- Icons -->
          <button class="text-gray-700 hover:text-black">
            <i class="fa-regular fa-heart text-lg"></i>
          </button>

          <button  onclick="window.location.href='{{ route('cart.index') }}'" class="text-gray-700 hover:text-black">
            <i class="fa-solid fa-bag-shopping text-lg"></i>
          </button>
          


          <!-- Profile Section -->
          @auth
            <!-- Profile with Dropdown (Logged In) -->
            <div class="relative">
              <button
                id="profile-btn"
                class="flex items-center gap-2 text-gray-700 hover:text-black"
              >
                <img
                  src="https://i.pravatar.cc/32"
                  alt="User"
                  class="w-8 h-8 rounded-full object-cover"
                />
                <span class="hidden sm:block text-sm">{{ Auth::user()->name }}</span>
                <i class="fa-solid fa-chevron-down text-xs hidden sm:block"></i>
              </button>

              <!-- Account Dropdown -->
              <div
                id="account-dropdown"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden z-50"
              >
                <a
                  href="#"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >My Profile</a
                >
                <a
                  href="#"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >Orders</a
                >
                <a
                  href="#"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >Wishlist</a
                >
                <hr class="my-1" />
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button
                    type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
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
      class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-[20005] lg:hidden"
    >
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
            class="w-full pl-4 pr-10 py-2 rounded-full bg-gray-100 text-sm outline-none"
          />
          <i
            class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-500"
          ></i>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <nav class="p-6">
        <ul class="space-y-4 text-gray-700 font-medium">
          @if(isset($categories) && count($categories) > 0)
            @foreach($categories as $category)
              <li><a href="{{ route('category.show', $category->slug) }}" class="block hover:text-black">{{ $category->name }}</a></li>
            @endforeach
          @else
            <li><a href="#" class="block hover:text-black">Salwar Kameez</a></li>
            <li><a href="#" class="block hover:text-black">Lehengas</a></li>
            <li><a href="#" class="block hover:text-black">Bridal</a></li>
            <li><a href="#" class="block hover:text-black">Wedding</a></li>
          @endif
        </ul>
      </nav>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div
      id="sidebar-overlay"
      class="fixed inset-0 bg-black bg-opacity-50 hidden z-[20004] lg:hidden"
    ></div>