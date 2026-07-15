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

    .status-requested {
        background-color: #fef3c7;
        color: #d97706;
    }

    .status-viewed {
        background-color: #e0e7ff;
        color: #3730a3;
    }

    .status-processing {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-accepted {
        background-color: #d1fae5;
        color: #059669;
    }

    .status-canceled {
        background-color: #fee2e2;
        color: #dc2626;
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
                @include('components.web.profile-sidebar', ['user' => auth()->user()])
            </div>
            
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Page Header -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <!-- You can add header content here if needed -->
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
                                            @if($request->product && $request->product->featured_image)
                                                <img src="{{ asset('storage/' . $request->product->featured_image) }}" alt="{{ $request->product->name }}" class="w-20 h-20 object-cover rounded-lg">
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

                                        @if($request->price)
                                            <div class="mt-3 pt-3 border-t">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-medium text-gray-700">Revised Price:</span>
                                                    <span class="text-lg font-semibold text-green-600">{{config('app.currency')}}{{ number_format($request->price, 2) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status & Action -->
                                    <div class="lg:w-1/3">
                                        <div class="flex flex-col h-full justify-between">
                                            <div class="text-right">
                                                @php
                                                    $status = $request->status ?? 'pending';
                                                    $statusClass = match($status) {
                                                        'completed' => 'status-completed',
                                                        'accepted' => 'status-accepted',
                                                        'processing' => 'status-processing',
                                                        'canceled' => 'status-canceled',
                                                        default => 'status-requested'
                                                    };
                                                @endphp
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                                
                                                @if($status === 'accepted')
                                                    @php
                                                        // Check if payment is done for this custom dimension
                                                        $isPaid = false;
                                                        $orderProduct = \App\Models\OrderProduct::where('request_id', $request->id)->first();
                                                        if ($orderProduct) {
                                                            $order = \App\Models\Order::find($orderProduct->order_id);
                                                            $isPaid = $order && $order->payment_status === 'paid';
                                                        }
                                                    @endphp
                                                    
                                                    <div class="mt-3 space-y-2">
                                                        @if($isPaid)
                                                            <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                                                                <i class="fas fa-check-circle mr-2"></i>
                                                                Paid
                                                            </span>
                                                        @else
                                                            <a href="{{ route('custom-order.payment', $request->id) }}" 
                                                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                                                <i class="fas fa-credit-card mr-2"></i>
                                                                Proceed to Payment
                                                            </a>
                                                        @endif
                                                        {{--
                                                        <a href="{{ route('custom-dimensions.cancel', $request->id) }}" 
                                                           class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">
                                                            <i class="fas fa-times mr-2"></i>
                                                            Cancel Request
                                                        </a>
                                                        --}}
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if($request->status !== 'canceled' && $request->status !== 'accepted')
                                                <form action="{{ route('custom-dimensions.cancel', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this request?')">
                                                    @csrf
                                                    <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 text-sm font-medium">
                                                        <i class="fas fa-times mr-2"></i>Cancel Request
                                                    </button>
                                                </form>
                                            @endif
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

                <!-- Pagination -->
                @if($customRequests->hasPages())
                    <div class="mt-8">
                        {{ $customRequests->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection