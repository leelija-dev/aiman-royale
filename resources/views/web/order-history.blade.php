   
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
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <!-- User Profile Summary -->
                    {{-- <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            <div class="w-20 h-20 rounded-full fashion-gradient flex items-center justify-center text-white text-xl font-bold mx-auto">
                                AJ
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Alex Johnson</h2>
                        <p class="text-gray-600 text-sm">Premium Member</p>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a href="profile.html" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-user w-5 text-center"></i>
                            <span>Profile Information</span>
                        </a>
                        <a href="{{route('user.order-history', $user->id)}}" class="sidebar-item active flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                            <span class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{count($orders)}}</span>
                        </a>
                        <a href="wishlist.html" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>Wishlist</span>
                            <span class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">12</span>
                        </a>
                        <a href="#" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-map-marker-alt w-5 text-center"></i>
                            <span>Addresses</span>
                        </a>
                        <a href="#" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-credit-card w-5 text-center"></i>
                            <span>Payment Methods</span>
                        </a>
                    </nav> --}}
                      @include('components.web.profile-sidebar', $user)

                    <!-- Order Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Orders</span>
                                <span class="font-medium">{{count($orders)}}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">This Month</span>
                                <span class="font-medium">{{count($orders)}}</span>
                            </div>
                            {{-- <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Pending</span>
                                <span class="font-medium text-amber-600">2</span>
                            </div> --}}
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivered</span>
                                <span class="font-medium text-green-600">{{count($orders)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Page Header -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Order History</h1>
                            <p class="text-gray-600 mt-1">Track and manage all your StyleHub orders in one place</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex gap-3">
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition duration-200 text-sm font-medium">
                                <i class="fas fa-download mr-2"></i>Export Orders
                            </button>
                            <button class="px-4 py-2 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Start Return
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col md:flex-row gap-4 justify-between">
                        <form method="GET" action="{{ route('user.order-history', $user->id) }}">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                
                                <input type="text" placeholder="Search orders by product or order ID..." name="search"  value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                            </div>
                        </div>
                        </form>
                        <div class="flex gap-2">
                            <select class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option>All Time</option>
                                <option>Last 30 Days</option>
                                <option>Last 3 Months</option>
                                <option>Last Year</option>
                            </select>
                            <select class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option>All Status</option>
                                <option>Processing</option>
                                <option>Shipped</option>
                                <option>Delivered</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Quick Filter Tabs -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button class="filter-active px-4 py-2 rounded-xl text-sm font-medium transition">All Orders</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">To Ship</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">To Receive</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">Completed</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">Cancelled</button>
                    </div>
                </div>

                <!-- Orders List -->
                
                <div class="space-y-6">
                    <!-- Current/Processing Orders -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Current Orders</h2>
                        {{-- @if($orders->count() > 0) --}}
                        @foreach($orders as $ord)
                        {{-- @dd($ord->product); --}}
                        <div class="order-card bg-white rounded-2xl shadow-sm p-6 mb-4">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-900">Order #{{$ord->id ?? ''}}</h3>
                                        <span class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium">
                                            {{ucfirst($ord->order_status ?? '')}}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">Placed on {{$ord->created_at->format('M d, Y h:i A')}}</p>
                                </div>
                                <div class="mt-3 lg:mt-0">
                                    <button class="px-4 py-2 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition text-sm font-medium">
                                        Track Order
                                    </button>
                                </div>
                            </div>

                            <!-- Order Progress -->
                            <div class="mb-6">
                                <div class="flex justify-between text-xs text-gray-600 mb-2">
                                    <span>Order Placed</span>
                                    <span>Processing</span>
                                    <span>Shipped</span>
                                    <span>Delivered</span>
                                </div>
                                <div class="progress-bar bg-gray-200">
                                    <div class="progress-fill fashion-gradient" style="width: 33%"></div>
                                </div>
                            </div>

                            <!-- Order Items -->
                              @foreach($ord->orderProducts as $orderProduct)
                            <div class="space-y-4 mt-2">
                                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tshirt text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{$orderProduct->product->name ?? ''}}</h4>
                                        <p class="text-gray-600 text-sm">Size: {{$orderProduct->variant->size}} • Color: {{ucfirst($orderProduct->variant->color ?? '')}}</p>
                                        <p class="text-gray-600 text-sm">Quantity: {{$orderProduct->quantity ?? ''}}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">{{config('app.currency')}}{{$orderProduct->total ?? ''}}</p>
                                        <p class="text-green-600 text-sm">In Stock</p>
                                    </div>
                                </div>

                                {{-- <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-teal-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-shoe-prints text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">Urban Sneakers</h4>
                                        <p class="text-gray-600 text-sm">Size: 10 • Color: White</p>
                                        <p class="text-gray-600 text-sm">Quantity: 1</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">$89.50</p>
                                        <p class="text-green-600 text-sm">In Stock</p>
                                    </div>
                                </div> --}}
                            </div>
                              @endforeach
                            <!-- Order Actions -->
                            <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-times mr-2"></i>Cancel Order
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-question-circle mr-2"></i>Get Help
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-receipt mr-2"></i>View Invoice
                                </button>
                            </div>
                          
                        </div>
                        @endforeach
                          {{-- @endif --}}
                    </div>
                  
                    <!-- Recent Orders -->
                    {{-- <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h2>
                        
                        <div class="order-card bg-white rounded-2xl shadow-sm p-6 mb-4">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-900">Order #SH-7889</h3>
                                        <span class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium">
                                            Delivered
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">Placed on June 28, 2023 • 2 items • $124.99</p>
                                </div>
                                <div class="mt-3 lg:mt-0">
                                    <button class="px-4 py-2 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition text-sm font-medium">
                                        Order Details
                                    </button>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tshirt text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">Organic Linen Shirt</h4>
                                        <p class="text-gray-600 text-sm">Size: L • Color: Olive Green</p>
                                        <p class="text-gray-600 text-sm">Quantity: 1</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">$65.00</p>
                                        <button class="text-purple-600 text-sm font-medium mt-1">Buy Again</button>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Order Actions -->
                            {{-- <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-star mr-2"></i>Rate Products
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-undo mr-2"></i>Return Items
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-receipt mr-2"></i>View Invoice
                                </button>
                            </div> --}}
                        </div>

                        {{-- <div class="order-card bg-white rounded-2xl shadow-sm p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-900">Order #SH-7842</h3>
                                        <span class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium">
                                            Delivered
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">Placed on June 12, 2023 • 4 items • $243.75</p>
                                </div>
                                <div class="mt-3 lg:mt-0">
                                    <button class="px-4 py-2 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition text-sm font-medium">
                                        Order Details
                                    </button>
                                </div>
                            </div> --}}

                            <!-- Order Items -->
                            {{-- <div class="space-y-4">
                                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tshirt text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">Summer Collection Bundle</h4>
                                        <p class="text-gray-600 text-sm">3 T-shirts, 1 Short • Mixed Colors</p>
                                        <p class="text-gray-600 text-sm">Quantity: 1 Bundle</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">$148.99</p>
                                        <button class="text-purple-600 text-sm font-medium mt-1">Buy Again</button>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Order Actions -->
                            <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-star mr-2"></i>Rate Products
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-receipt mr-2"></i>View Invoice
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Older Orders -->
                    {{-- <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Older Orders</h2>
                        
                        <div class="order-card bg-white rounded-2xl shadow-sm p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-bold text-gray-900">Order #SH-7791</h3>
                                        <span class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium">
                                            Delivered
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm">Placed on June 5, 2023 • 2 items • $89.50</p>
                                </div>
                                <div class="mt-3 lg:mt-0">
                                    <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2 mt-8">
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl fashion-gradient text-white">1</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">2</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">3</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
      </div>
    </section>
    @endsection