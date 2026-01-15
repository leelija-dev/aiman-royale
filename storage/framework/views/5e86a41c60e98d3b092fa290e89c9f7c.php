<header
  class="sticky top-[-1px] z-50 bg-gradient-to-r from-green-700/95 via-green-600/95 to-emerald-600/95 backdrop-blur supports-[backdrop-filter]:bg-opacity-90 text-white shadow-lg">
  <nav
    class="container mx-auto px-4 py-3 md:py-4 flex items-center gap-4">
    <!-- Logo -->
    <a
      href="/"
      class="text-2xl md:text-3xl font-bold tracking-tight flex items-center hover:scale-105 transition-transform duration-200">
      <img src="<?php echo e(asset('web/images/amarmaa-text.webp')); ?>" class="max-h-[35px] h-auto" alt="">
    </a>



    <!-- Desktop Menu -->
    <ul class="hidden lg:flex space-x-8 items-center ml-auto">

      <li>
        <a
          href="#weekly-deals"
          class="text-base lg:text-lg hover:text-green-200 transition-colors duration-200 flex items-center">
          <svg
            class="w-5 h-5 mr-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
          Deals
        </a>
      </li>
      <li>
        <a
          href="#about"
          class="text-base lg:text-lg hover:text-green-200 transition-colors duration-200 flex items-center">
          <svg
            class="w-5 h-5 mr-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          About
        </a>
      </li>
      <li>
        <a
          href="#contact"
          class="text-base lg:text-lg hover:text-green-200 transition-colors duration-200 flex items-center">
          <svg
            class="w-5 h-5 mr-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
          </svg>
          Contact
        </a>
      </li>
    </ul>

    <!-- Desktop Actions -->
    <div class="hidden lg:flex items-center gap-3 ml-2">
          <!-- <a href="/account" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/15 text-white" aria-label="Account">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.9 6.197M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </a> -->
          <a href="/admin/login" class=" xl:inline-flex items-center rounded-xl bg-white text-green-700 font-semibold px-4 py-2 hover:bg-green-50 shadow">
      Login
    </a>
         
         
        </div>
    <div class="ml-auto lg:hidden flex justify-end items-center gap-3 ">
      <a href="/admin/login" class=" xl:inline-flex items-center rounded-xl bg-white text-green-700 font-semibold px-4 py-2 hover:bg-green-50 shadow">
      Login
    </a>

    <!-- Mobile Menu Button -->
    <button
      id="mobile-menu-button"
      class="lg:hidden  focus:outline-none p-2 rounded-lg hover:bg-green-700 transition"
      aria-label="Open menu"
      aria-controls="mobile-sidebar"
      aria-expanded="false">
      <svg
        class="w-7 h-7"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
    </div>
  </nav>

  <!-- Mobile Sidebar -->
  <div id="mobile-sidebar" class="mobile-sidebar">
    <div class="py-6">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
          <svg
            class="w-8 h-8 mr-2 text-green-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 3h18M9 3v18m6-18v18M3 9h18M3 15h18"></path>
          </svg>
          <span class="text-2xl font-bold text-white">WoCommerce</span>
        </div>
        <button id="close-sidebar" class="text-white hover:text-green-200" aria-label="Close menu">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>



      <ul class="space-y-4">

        <li>
          <a
            href="#weekly-deals"
            class="text-white hover:text-green-200 transition-colors duration-200 flex items-center">
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Deals
          </a>
        </li>
        <li>
          <a
            href="#about"
            class="text-white hover:text-green-200 transition-colors duration-200 flex items-center">
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            About
          </a>
        </li>
        <li>
          <a
            href="#contact"
            class="text-white hover:text-green-200 transition-colors duration-200 flex items-center">
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            Contact
          </a>
        </li>
      </ul>

      <!-- Mobile Quick Actions -->
      <!-- <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="/account" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/15 text-white py-2.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.9 6.197M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              Account
            </a>
            
          </div> -->
    </div>
  </div>

  <!-- Overlay -->
  <div id="sidebar-overlay" class="mobile-sidebar-overlay"></div>
</header><?php /**PATH C:\xampp\htdocs\aiman\resources\views/components/web/navbar.blade.php ENDPATH**/ ?>