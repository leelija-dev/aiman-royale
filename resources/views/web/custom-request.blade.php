   @extends('layout.web.main-layout')

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

    .request-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .request-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .status-pending {
        background-color: #fef3c7;
        color: #d97706;
    }

    .status-processing {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #059669;
    }

    .dimension-badge {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
    }

    .color-preview {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
    }
</style>

<section class="w-full px-4 lg:py-12 py-6">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <!-- User Profile Summary -->
                    <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            <div class="w-20 h-20 rounded-full fashion-gradient flex items-center justify-center text-white text-xl font-bold mx-auto">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600 text-sm">Premium Member</p>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a href="{{ route('web.profile') }}" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-user w-5 text-center"></i>
                            <span>Profile Information</span>
                        </a>
                        <a href="{{ route('user.order-history', auth()->user()->id) }}" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                        </a>
                        <a href="{{ route('custom-request') }}" class="sidebar-item active flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-ruler-combined w-5 text-center"></i>
                            <span>Custom Requests</span>
                            <span class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ $customRequests->count() }}</span>
                        </a>
                        <a href="#" class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>Wishlist</span>
                        </a>
                    </nav>

                    <!-- Request Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-4">Request Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Requests</span>
                                <span class="font-medium">{{ $customRequests->count() }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Pending</span>
                                <span class="font-medium text-amber-600">{{ $customRequests->where('status', 'pending')->count() }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Processing</span>
                                <span class="font-medium text-blue-600">{{ $customRequests->where('status', 'processing')->count() }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Completed</span>
                                <span class="font-medium text-green-600">{{ $customRequests->where('status', 'completed')->count() }}</span>
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
                            <h1 class="text-2xl font-bold text-gray-900">Custom Dimension Requests</h1>
                            <p class="text-gray-600 mt-1">Track all your custom measurement requests and their status</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex gap-3">
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition duration-200 text-sm font-medium">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <button class="px-4 py-2 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 text-sm font-medium">
                                <i class="fas fa-download mr-2"></i>Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Custom Requests List -->
                @if($customRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($customRequests as $request)
                            <div class="bg-white rounded-2xl shadow-sm p-6 request-card">
                                <div class="flex flex-col lg:flex-row gap-6">
                                    <!-- Product Info -->
                                    <div class="lg:w-1/3">
                                        <div class="flex gap-4">
                                            @if($request->product && $request->product->image)
                                                <img src="{{ asset('storage/' . $request->product->image) }}" alt="{{ $request->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900">{{ $request->product->name ?? 'Unknown Product' }}</h3>
                                                <p class="text-sm text-gray-600">Request ID: #{{ str_pad($request->id, 6, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $request->created_at->format('M d, Y - h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dimensions -->
                                    <div class="lg:w-1/3">
                                        <h4 class="font-medium text-gray-900 mb-3">Custom Measurements</h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            @if($request->bust)
                                                <div class="dimension-badge px-3 py-2 rounded-lg text-sm">
                                                    <span class="font-medium">Bust:</span> {{ $request->bust }}cm
                                                </div>
                                            @endif
                                            
                                            @if($request->waist)
                                                <div class="dimension-badge px-3 py-2 rounded-lg text-sm">
                                                    <span class="font-medium">Waist:</span> {{ $request->waist }}cm
                                                </div>
                                            @endif
                                            
                                            @if($request->hip)
                                                <div class="dimension-badge px-3 py-2 rounded-lg text-sm">
                                                    <span class="font-medium">Hip:</span> {{ $request->hip }}cm
                                                </div>
                                            @endif
                                            
                                            @if($request->armhole)
                                                <div class="dimension-badge px-3 py-2 rounded-lg text-sm">
                                                    <span class="font-medium">Armhole:</span> {{ $request->armhole }}cm
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($request->color_code)
                                            <div class="flex items-center gap-2 mt-3">
                                                <span class="text-sm font-medium text-gray-700">Color:</span>
                                                <div class="color-preview" style="background-color: {{ $request->color_code }};"></div>
                                                <span class="text-sm text-gray-600">{{ $request->color_code }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status & Actions -->
                                    <div class="lg:w-1/3">
                                        <div class="text-right">
                                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium 
                                                {{ $request->status == 'pending' ? 'status-pending' : 
                                                   ($request->status == 'processing' ? 'status-processing' : 'status-completed') }}">
                                                <i class="fas fa-circle text-xs"></i>
                                                {{ ucfirst($request->status ?? 'pending') }}
                                            </div>
                                            
                                            <div class="mt-4 space-y-2">
                                                @if($request->status == 'pending')
                                                    <button class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 text-sm font-medium">
                                                        <i class="fas fa-times mr-2"></i>Cancel Request
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-ruler-combined text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Custom Requests Yet</h3>
                        <p class="text-gray-600 mb-6">You haven't submitted any custom dimension requests yet. Start by browsing our products and requesting custom measurements.</p>
                        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 font-medium">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Browse Products
                        </a>
                    </div>
                @endif

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

                {{-- <div class="order-card bg-white rounded-2xl shadow-sm p-6">
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
                    </div>
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
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                                View Details
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
    </section>
    @endsection