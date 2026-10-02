    @extends('layout.web.main-layout')

    @section('content')

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>Please fix the following errors:</strong>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
                <div class="lg:w-1/4">
                    @include('components.web.profile-sidebar', ['user' => auth()->user()])
                </div>
                {{--<div id="user-panel-sidebar" class="bg-white rounded-2xl shadow-sm p-6 sticky top-24 min-w-[300px] h-fit">
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
                            href="{{ route('page.multi-product') }}"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                            @if($orderCount > 0)
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ $orderCount }}</span>
                            @endif
                        </a>
                        <a
                            href="{{ route('wishlist.index') }}"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>Wishlist</span>
                            @if($wishlistCount > 0)
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ $wishlistCount }}</span>
                            @endif
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


                </div>--}}




                <!-- Main Content -->
                <div class="w-full">
                    <!-- Welcome Header -->
                    <!-- <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
              <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center"
              >
                <div>
                  <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back, {{ $user ? $user->name : 'User' }}!
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
                                onclick="openEditProfileModal()"
                                class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                <i class="fas fa-edit mr-1"></i>Edit Profile
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    {{ $user ? $user->name : 'Not Available' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    {{ $user ? $user->email : 'Not Available' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    {{ $user ? ($user->phone ?? 'Not Provided') : 'Not Available' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                    {{ $user ? ($user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not Provided') : 'Not Available' }}
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <div
                                class="p-3 bg-gray-50 rounded-xl border border-gray-200 min-h-20">
                                Fashion enthusiast with a passion for sustainable style. Love
                                exploring new trends while staying true to classic pieces.
                            </div>
                        </div> --}}
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

    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Profile</h3>
                <button onclick="closeEditProfileModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('web.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ $user->phone ?? '' }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeEditProfileModal()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditProfileModal() {
            document.getElementById('edit-profile-modal').classList.remove('hidden');
        }

        function closeEditProfileModal() {
            document.getElementById('edit-profile-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('edit-profile-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditProfileModal();
            }
        });
    </script>
    @if (session('registration_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                if (typeof fbq !== 'undefined') {
                    fbq('track', 'CompleteRegistration');
                }

                @php
                    session()->forget('registration_success');
                @endphp
            });
        </script>
    @endif
    @endsection