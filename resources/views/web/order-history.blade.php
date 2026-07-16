   @extends('layout.web.main-layout')
   <?php
    $user = $user ?? auth()->user();

    // dd($user); exit;

    ?>




   @section('content')
   <meta name="csrf-token" content="{{ csrf_token() }}">

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
                           <form method="GET" action="{{ route('user.order-history', base64_encode($user->id)) }}">
                               <div class="flex-1">
                                   <div class="relative">
                                       <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                           <i class="fas fa-search text-gray-400"></i>
                                       </div>

                                       <input type="text" placeholder="Search orders by product or order ID..." name="search" value="{{ request('search') }}"
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
                           <a href="{{route('user.order-history', base64_encode($user->id))}}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition"><button class="filter-active px-4 py-2 rounded-xl text-sm font-medium transition">All Orders</button> </a>
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
                                           @if(ucfirst($ord->order_status)=='Paid')
                                           <span class="order-status-delivered px-3 py-1 rounded-full text-xs font-medium">
                                               {{ucfirst($ord->order_status ?? '')}}
                                           </span>
                                           @else
                                           <span class="bg-red-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                                               {{ ucfirst($ord->order_status ?? 'Pending') }}
                                           </span>
                                           @endif
                                       </div>
                                       <p class="text-gray-600 text-sm">Placed on {{$ord->created_at->format('M d, Y h:i A')}}</p>
                                       <p class="text-gray-600 text-bold">Total Price: <strong>{{config('app.currency')}}{{$ord->total_amount ?? '0'}}</strong> </p>
                                   </div>
                                   <div class="mt-3 lg:mt-0">
                                       <a href="{{ route('track.page') }}?order_id={{ $ord->id }}" class="inline-block px-4 py-2 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition text-sm font-medium">
                                           Track Order
                                       </a>
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

                                       <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center overflow-hidden">
                                           {{-- <i class="fas fa-tshirt text-purple-600"></i> --}}
                                           <a href="{{route('page.single-product', $orderProduct->product->slug)}}"> <img

                                                   src="{{asset($orderProduct->product->featured_image ?? '')}}"
                                                   class="w-full h-18 object-cover object-center group-hover:scale-110 transition-transform duration-500"
                                                   alt="{{$orderProduct->product->name ?? ''}}" /></a>
                                       </div>

                                       <div class="flex-1">
                                           <a href="{{route('page.single-product', $orderProduct->product->slug)}}">
                                               <h4 class="font-medium text-gray-900">{{$orderProduct->product->name ?? ''}}</h4>
                                               <p class="text-gray-600 text-sm">Size: {{$orderProduct->variant->size ?? ''}} • Color: {{ucfirst($orderProduct->variant->color ?? '')}}</p>
                                               <p class="text-gray-600 text-sm">Quantity: {{$orderProduct->quantity ?? ''}}</p>
                                           </a>
                                       </div>

                                       <div class="text-right">
                                           <p class="font-medium text-gray-900">{{config('app.currency')}}{{$orderProduct->total ?? ''}}</p>
                                           <p class="text-green-600 text-sm">In Stock</p>
                                       </div>
                                   </div>

                                   <!-- Review Section - Only show for delivered orders -->
                                   @if($ord->order_status == 'delivered')
                                   @php
                                   $hasReviewed = \App\Models\FalseReview::where('user_id', $user->id)
                                   ->where('product_id', $orderProduct->product->id)
                                   ->where('order_id', $ord->id)
                                   ->exists();

                                   @endphp

                                   @if($hasReviewed)
                                   <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                       <div class="flex items-center gap-2">
                                           <i class="fas fa-check-circle text-green-600"></i>
                                           <span class="text-green-800 font-medium">You've reviewed this product</span>
                                       </div>
                                       <div class="mt-2">
                                           <div class="flex items-center gap-1">
                                               @for($i = 1; $i <= 5; $i++)
                                                   <i class="fas fa-star text-yellow-400"></i>
                                                   @endfor
                                           </div>
                                           <p class="text-sm text-gray-600 mt-1">Thank you for your feedback!</p>
                                       </div>
                                   </div>
                                   @else
                                   <div class="mt-4 p-4 bg-purple-50 border border-purple-200 rounded-xl">
                                       <h5 class="font-medium text-purple-900 mb-3">Rate this product</h5>
                                       <form id="reviewForm-{{$orderProduct->product->id}}" class="space-y-3" onsubmit="submitReview(event, {{$orderProduct->product->id}})">
                                           @csrf
                                           <input type="hidden" name="product_id" value="{{$orderProduct->product->id}}">
                                           <input type="hidden" name="order_id" value="{{$ord->id}}">
                                           <input type="hidden" name="user_id" value="{{$user->id}}">

                                           <!-- Star Rating -->
                                           <div class="flex items-center gap-2">
                                               <label class="text-sm font-medium text-gray-700">Rating:</label>
                                               <div class="flex gap-1" id="starRating-{{$orderProduct->product->id}}">
                                                   @for($i = 1; $i <= 5; $i++)
                                                       <button type="button"
                                                       class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors"
                                                       data-rating="{{$i}}"
                                                       data-product-id="{{$orderProduct->product->id}}"
                                                       onclick="setRating({{$orderProduct->product->id}}, {{$i}})">
                                                       <i class="fas fa-star"></i>
                                                       </button>
                                                       @endfor
                                               </div>
                                               <input type="hidden" name="rating" id="rating-{{$orderProduct->product->id}}" value="0" required>
                                           </div>

                                           <!-- Review Text -->
                                           <div>
                                               <label class="text-sm font-medium text-gray-700">Your Review:</label>
                                               <textarea name="review_text"
                                                   rows="3"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                                   placeholder="Share your experience with this product..."
                                                   required></textarea>
                                           </div>

                                           <!-- Reviewer Info -->
                                           <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                               <div>
                                                   <label class="text-sm font-medium text-gray-700">Your Name:</label>
                                                   <input type="text"
                                                       name="reviewer_name"
                                                       value="{{$user->name}}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                                       required>
                                               </div>
                                               <div>
                                                   <label class="text-sm font-medium text-gray-700">Email:</label>
                                                   <input type="email"
                                                       name="reviewer_email"
                                                       value="{{$user->email}}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                                       required>
                                               </div>
                                           </div>

                                           <!-- Submit Button -->
                                           <button type="submit"
                                               class="w-full px-4 py-2 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 text-sm font-medium">
                                               <i class="fas fa-paper-plane mr-2"></i>Submit Review
                                           </button>
                                       </form>
                                   </div>
                                   @endif
                                   @endif

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
                                   @php $hasActiveReturn = isset($ord->active_return_requests_count) && $ord->active_return_requests_count > 0; @endphp
                                   @if($ord->order_status == 'delivered' && !$hasActiveReturn)
                                    <button class="px-4 py-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition text-sm font-medium"
                                       onclick="returnOrder(event, {{ $ord->id }}, '{{ $ord->order_status }}')">
                                       <i class="fas fa-undo mr-2"></i>Return Order
                                   </button>
                                   @elseif($ord->order_status == 'delivered' && $hasActiveReturn)
                                   <button class="px-4 py-2 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed text-sm font-medium" disabled>
                                       <i class="fas fa-undo mr-2"></i>Return Requested
                                   </button>
                                   @elseif(in_array($ord->order_status, ['pending', 'confirmed', 'paid']))
                                   <button class="px-4 py-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition text-sm font-medium"
                                       onclick="cancelOrder({{ $ord->id }}, '{{ $ord->order_status }}')">
                                       <i class="fas fa-times mr-2"></i>Cancel Order
                                   </button>
                                   @elseif(in_array($ord->order_status, ['delivered']) && !$hasActiveReturn)
                                   <button class="px-4 py-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 transition text-sm font-medium"
                                       onclick="returnOrder(event, {{ $ord->id }}, '{{ $ord->order_status }}')">
                                       <i class="fas fa-undo mr-2"></i>Return Order
                                   </button>
                                   @elseif(in_array($ord->order_status, ['delivered']) && $hasActiveReturn)
                                   <button class="px-4 py-2 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed text-sm font-medium" disabled>
                                       <i class="fas fa-undo mr-2"></i>Return Requested
                                   </button>
                                   @else
                                   <button class="px-4 py-2 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed text-sm font-medium" disabled>
                                       <i class="fas fa-times mr-2"></i>Cannot Cancel
                                   </button>
                                   @endif
                                   <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                       <i class="fas fa-question-circle mr-2"></i>Get Help
                                   </button>
                                   <a href="{{ route('order.invoice', $ord->id) }}"  class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium"><button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                       <i class="fas fa-receipt mr-2"></i>View Invoice
                                   </button>
                                   </a>
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
       @if($orders->hasPages())
       <div class="flex justify-center items-center gap-2 mt-8">
           <!-- Previous Button -->
           @if($orders->onFirstPage())
           <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed" disabled>
               <i class="fas fa-chevron-left"></i>
           </button>
           @else
           <a href="{{ $orders->previousPageUrl() }}"
               class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
               <i class="fas fa-chevron-left"></i>
           </a>
           @endif

           <!-- Page Numbers -->
           @php
           $currentPage = $orders->currentPage();
           $lastPage = $orders->lastPage();
           $start = max(1, $currentPage - 2);
           $end = min($lastPage, $currentPage + 2);

           // Show first page if not in range
           if ($start > 1) {
           echo '<a href="'.$orders->url(1).'" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">1</a>';
           if ($start > 2) {
           echo '<span class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400">...</span>';
           }
           }
           @endphp

           @for($i = $start; $i <= $end; $i++)
               @if($i==$currentPage)
               <span class="w-10 h-10 flex items-center justify-center rounded-xl fashion-gradient text-white">
               {{ $i }}
               </span>
               @else
               <a href="{{ $orders->url($i) }}"
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                   {{ $i }}
               </a>
               @endif
               @endfor

               @php
               // Show last page if not in range
               if ($end < $lastPage) {
                   if ($end < $lastPage - 1) {
                   echo '<span class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400">...</span>' ;
                   }
                   echo '<a href="' .$orders->url($lastPage).'" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">'.$lastPage.'</a>';
                   }
                   @endphp

                   <!-- Next Button -->
                   @if($orders->hasMorePages())
                   <a href="{{ $orders->nextPageUrl() }}"
                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                       <i class="fas fa-chevron-right"></i>
                   </a>
                   @else
                   <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed" disabled>
                       <i class="fas fa-chevron-right"></i>
                   </button>
                   @endif
       </div>
       @endif
       </div>
       </div>
       </div>
   </section>

   <script>
       // Star rating functionality
       function setRating(productId, rating) {
           // Update hidden input
           document.getElementById('rating-' + productId).value = rating;

           // Update star display
           const stars = document.querySelectorAll('#starRating-' + productId + ' .star-btn');
           stars.forEach((star, index) => {
               if (index < rating) {
                   star.classList.remove('text-gray-300');
                   star.classList.add('text-yellow-400');
               } else {
                   star.classList.remove('text-yellow-400');
                   star.classList.add('text-gray-300');
               }
           });
       }

       // Review submission
       function submitReview(event, productId) {
           event.preventDefault();

           const form = document.getElementById('reviewForm-' + productId);
           const formData = new FormData(form);

           // Add CSRF token
           formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

           fetch('/api/reviews', {
                   method: 'POST',
                   body: formData,
                   headers: {
                       'X-Requested-With': 'XMLHttpRequest'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success) {
                       // Show success message
                       showReviewSuccess(productId);

                       // Update the review section to show "You've reviewed this product"
                       setTimeout(() => {
                           location.reload();
                       }, 2000);
                   } else {
                       // Show error message
                       showReviewError(data.message || 'Failed to submit review');
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   showReviewError('An error occurred while submitting your review');
               });
       }

       function showReviewSuccess(productId) {
           const form = document.getElementById('reviewForm-' + productId);
           if (form) {
               form.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-check-circle text-green-600 text-4xl mb-2"></i>
                    <p class="text-green-800 font-medium">Review submitted successfully!</p>
                    <p class="text-sm text-gray-600">Thank you for your feedback</p>
                </div>
            `;
           }
       }

       function showReviewError(message) {
           // Create error alert
           const errorDiv = document.createElement('div');
           errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg z-50';
           errorDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span>${message}</span>
            </div>
        `;

           document.body.appendChild(errorDiv);

           // Remove after 3 seconds
           setTimeout(() => {
               if (errorDiv.parentNode) {
                   errorDiv.parentNode.removeChild(errorDiv);
               }
           }, 3000);
       }

       // Cancel Order Function
       function cancelOrder(orderId, currentStatus) {
           if (!confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
               return;
           }

           // Show loading state
           const button = event.target;
           const originalText = button.innerHTML;
           button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Cancelling...';
           button.disabled = true;

           // Make AJAX request
           fetch(`/cancel-order/${orderId}`, {
                   method: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json',
                   },
                   body: JSON.stringify({
                       reason: 'Customer requested cancellation'
                   })
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success) {
                       // Show success message
                       showNotification(data.message, 'success');
                       // Reload page after 2 seconds to show updated status
                       setTimeout(() => {
                           window.location.reload();
                       }, 2000);
                   } else {
                       // Show error message
                       showNotification(data.message, 'error');
                       // Restore button
                       button.innerHTML = originalText;
                       button.disabled = false;
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   showNotification('Error cancelling order. Please try again.', 'error');
                   // Restore button
                   button.innerHTML = originalText;
                   button.disabled = false;
               });
       }

       // Return Order Function
       function returnOrder(event, orderId, currentStatus) {
           // Use Swal or custom confirm dialog
           if (!confirm('Are you sure you want to return this order? This action cannot be undone.')) {
               return;
           }

           // Get the button element
           const button = (event && (event.currentTarget || event.target)) || document.activeElement;
           const originalText = button.innerHTML;

           // Show loading state
           button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
           button.disabled = true;

           // Make AJAX request
           fetch(`/refund/${orderId}`, {
                   method: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json',
                       'Accept': 'application/json', // Important: Tell server we want JSON
                   },
                   body: JSON.stringify({
                       return_reason: 'Customer requested return'
                   })
               })
               .then(response => {
                   // Check if response is OK
                   if (!response.ok) {
                       return response.json().then(data => {
                           throw new Error(data.message || 'Request failed');
                       });
                   }
                   return response.json();
               })
               .then(data => {
                   console.log('Return response:', data);

                   if (data.success) {
                       // Show success notification
                       showNotification(data.message, 'success');

                       // Update button text to show success
                       button.innerHTML = '<i class="fas fa-check mr-2"></i>Returned';
                       button.className = 'px-4 py-2 bg-green-100 text-green-700 rounded-xl text-sm font-medium';

                       // Reload page after 2 seconds
                       setTimeout(() => {
                           window.location.reload();
                       }, 2000);
                   } else {
                       // Show error
                       showNotification(data.message || 'Failed to process return', 'error');

                       // Restore button
                       button.innerHTML = originalText;
                       button.disabled = false;
                   }
               })
               .catch(error => {
                   console.error('Error:', error);

                   // Show error notification
                   showNotification(error.message || 'Error processing return request. Please try again.', 'error');

                   // Restore button
                   button.innerHTML = originalText;
                   button.disabled = false;
               });
       }

       // Notification function (if you don't have one)
       function showNotification(message, type = 'success') {
           // Check if we have a notification container
           let container = document.getElementById('notification-container');
           if (!container) {
               container = document.createElement('div');
               container.id = 'notification-container';
               container.className = 'fixed top-4 right-4 z-50 space-y-2';
               document.body.appendChild(container);
           }

           // Create notification element
           const notification = document.createElement('div');
           notification.className = `px-6 py-4 rounded-lg shadow-lg text-white transition-all duration-500 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
           notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;

           container.appendChild(notification);

           // Auto remove after 5 seconds
           setTimeout(() => {
               notification.style.opacity = '0';
               notification.style.transform = 'translateX(100px)';
               setTimeout(() => {
                   notification.remove();
               }, 500);
           }, 5000);
       }

       // Show notification helper
       function showNotification(message, type) {
           const notification = document.createElement('div');
           const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
           notification.className = `fixed top-4 right-4 ${bgColor} px-4 py-3 rounded-lg z-50 border`;
           notification.innerHTML = `
               <div class="flex items-center">
                   <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                   <span>${message}</span>
               </div>
           `;

           document.body.appendChild(notification);

           setTimeout(() => {
               if (notification.parentNode) {
                   notification.parentNode.removeChild(notification);
               }
           }, 5000);
       }
   </script>
   @endsection