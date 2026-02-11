    @extends('layout.web.main-layout')
    <?php
    $user = $user ?? auth()->user();

    ?>







    @section('content')

    <style>
        .fashion-gradient {
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        }

        .fashion-gradient-light {
            background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
        }

        .fashion-gradient-text {
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
            border-right: 3px solid #a855f7;
            color: #7c3aed;
        }

        .sidebar-item:hover:not(.active) {
            background-color: #f8fafc;
        }

        .order-status-processing {
            background-color: #fef3c7;
            color: #d97706;
        }

        .order-status-shipped {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .order-status-delivered {
            background-color: #d1fae5;
            color: #059669;
        }

        .tab-active {
            border-bottom: 2px solid #a855f7;
            color: #7c3aed;
            font-weight: 600;
        }

        .avatar-upload {
            transition: all 0.3s ease;
        }

        .avatar-upload:hover {
            transform: scale(1.05);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>

    <section class="w-full px-4 lgg:py-12 py-6">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Navigation -->

                <div id="user-panel-sidebar" class="bg-white rounded-2xl shadow-sm p-6 sticky top-24 min-w-[300px] h-fit">
                    <!-- User Profile Summary -->
                    <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            @if($user && $user->profile_image && file_exists(public_path($user->profile_image)))
                            <img src="{{ asset($user->profile_image) }}"
                                alt="{{ $user->name }}"
                                class="w-20 h-20 rounded-full object-cover mx-auto">
                            @else
                            <div class="w-20 h-20 rounded-full fashion-gradient flex items-center justify-center text-white text-xl font-bold mx-auto">
                                {{ $user ? strtoupper(substr(trim($user->name), 0, 2)) : 'GU' }}
                            </div>
                            @endif
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $user ? $user->name : 'Guest User' }}</h2>
                        <p class="text-gray-600 text-sm">{{ $user ? $user->email : 'guest@example.com' }}</p>
                    </div>
                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a
                            href="#"
                            class="sidebar-item active flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-user w-5 text-center"></i>
                            <span>Profile Information</span>
                        </a>
                        <a
                            href="{{route('user.order-history', $user->id)}}"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">3</span>
                        </a>
                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>Wishlist</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">12</span>
                        </a>
                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-map-marker-alt w-5 text-center"></i>
                            <span>Addresses</span>
                        </a>

                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-bell w-5 text-center"></i>
                            <span>Notifications</span>
                        </a>
                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-lock w-5 text-center"></i>
                            <span>Security</span>
                        </a>

                    </nav>


                </div>




                <!-- Main Content -->
                <div class="w-full">
                    <!-- Welcome Header -->
                    <!-- <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
              <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center"
              >
                <div>
                  <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back, Alex!
                  </h1>
                  <p class="text-gray-600 mt-1">
                    Here's what's happening with your StyleHub account today.
                  </p>
                </div>
                <div class="mt-4 sm:mt-0 flex gap-3">
                  <button
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition duration-200 text-sm font-medium"
                  >
                    <i class="fas fa-download mr-2"></i>Export Data
                  </button>
                  <button
                    class="px-4 py-2 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 text-sm font-medium"
                  >
                    <i class="fas fa-plus mr-2"></i>New Order
                  </button>
                </div>
              </div>
            </div> -->

                    <!-- Quick Stats -->
                    <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
              <div class="stats-card bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-gray-600 text-sm font-medium">
                      Pending Orders
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">2</p>
                  </div>
                  <div
                    class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center"
                  >
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                  </div>
                </div>
              </div>
              <div class="stats-card bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-gray-600 text-sm font-medium">
                      Wishlist Items
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
                  </div>
                  <div
                    class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center"
                  >
                    <i class="fas fa-heart text-pink-600 text-xl"></i>
                  </div>
                </div>
              </div>
              <div class="stats-card bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-gray-600 text-sm font-medium">
                      Loyalty Points
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">1,250</p>
                  </div>
                  <div
                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center"
                  >
                    <i class="fas fa-gem text-purple-600 text-xl"></i>
                  </div>
                </div>
              </div>
            </div> -->

                    <!-- Profile Information Section -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">
                                Profile Information
                            </h2>
                            <button
                                class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                <i class="fas fa-edit mr-1"></i>Edit Profile
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    Alex Johnson
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    alex.johnson@example.com
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    +1 (555) 123-4567
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    March 15, 1990
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <div
                                class="p-3 bg-gray-50 rounded-xl border border-gray-200 min-h-20">
                                Fashion enthusiast with a passion for sustainable style. Love
                                exploring new trends while staying true to classic pieces.
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <!-- <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
              <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                <a
                  href="#"
                  class="text-purple-600 hover:text-purple-700 font-medium text-sm"
                >
                  View All Orders
                </a>
              </div>

              <div class="space-y-4">
                <div
                  class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition duration-200"
                >
                  <div class="flex items-center gap-4 mb-3 sm:mb-0">
                    <div
                      class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center"
                    >
                      <i class="fas fa-tshirt text-purple-600"></i>
                    </div>
                    <div>
                      <h3 class="font-medium text-gray-900">
                        Summer Collection Order
                      </h3>
                      <p class="text-sm text-gray-600">
                        Order #SH-7842 • Placed on Jun 12, 2023
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col sm:items-end gap-2">
                    <span
                      class="order-status-shipped px-3 py-1 rounded-full text-xs font-medium"
                    >
                      Shipped
                    </span>
                    <p class="text-lg font-bold text-gray-900">$148.99</p>
                  </div>
                </div>

                <div
                  class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition duration-200"
                >
                  <div class="flex items-center gap-4 mb-3 sm:mb-0">
                    <div
                      class="w-16 h-16 bg-gradient-to-br from-blue-100 to-teal-100 rounded-lg flex items-center justify-center"
                    >
                      <i class="fas fa-shoe-prints text-blue-600"></i>
                    </div>
                    <div>
                      <h3 class="font-medium text-gray-900">
                        Footwear & Accessories
                      </h3>
                      <p class="text-sm text-gray-600">
                        Order #SH-7791 • Placed on Jun 5, 2023
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col sm:items-end gap-2">
                    <span
                      class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium"
                    >
                      Delivered
                    </span>
                    <p class="text-lg font-bold text-gray-900">$89.50</p>
                  </div>
                </div>
              </div>
            </div> -->


                </div>
            </div>
        </div>
    </section>
    
    @endsection