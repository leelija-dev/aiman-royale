@extends('layout.web.main-layout')
@section('event', 'AddToWishlist')
@section('content')
@if(!auth()->check())
<!-- Guest User Login Prompt -->
<div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
    <div class="text-center">
        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-user text-purple-600 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Sign In to View Your Wishlist</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Save your favorite items and access them from any device by signing in to your account.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('page.login') }}"
                class="px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition font-medium flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </a>
            <a href="{{ route('page.register') }}"
                class="px-8 py-3 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition font-medium">
                Create Account
            </a>
        </div>
        <p class="text-gray-500 text-sm mt-6">
            Don't want to sign in? Your wishlist will be saved temporarily in your browser.
        </p>
    </div>
</div>
@endif

<!-- Main Wishlist Content (only for authenticated users) -->
@if(auth()->check())
<section class="w-full px-4 lgg:py-12 py-6">
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #F9FAFB;
        }

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

        .product-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .wishlist-item {
            transition: all 0.3s ease;
        }

        .wishlist-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .sale-badge {
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        }

        .out-of-stock {
            position: relative;
        }

        .out-of-stock::after {
            content: "Out of Stock";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .filter-active {
            background-color: #7c3aed;
            color: white;
        }

        .collection-tab.active {
            border-bottom: 3px solid #a855f7;
            color: #7c3aed;
            font-weight: 600;
        }

        .pagination-ellipsis {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            color: #6b7280;
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #a855f7;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

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
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
                            <p class="text-gray-600 mt-1">
                                Save your favorite items for later
                            </p>
                        </div>
                    </div>
                </div>
                {{-- @dd($wishCount,$wishCount->count()) --}}
                <!-- Wishlist Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 wishlist-grid">
                    @if($wishlistItems->isEmpty())
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm p-12 text-center empty-state">
                            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-heart text-purple-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                Your wishlist is empty
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Start adding items you love to your wishlist
                            </p>
                            <a href="{{ url('/') }}"
                                class="inline-block px-8 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                                Start Shopping
                            </a>
                        </div>
                    </div>
                    @else
                    @foreach($wishlistItems as $wishlist)
                    @php
                    $product = $wishlist->product;
                    $image = $product->images->first();
                    $variant = $product->variants->first();
                    @endphp
                    <div class="wishlist-item flex flex-col  product-card bg-white rounded-2xl shadow-sm overflow-hidden" data-product-id="{{ $product->id }}">
                        <div class="relative">
                            <a href="{{ route('page.single-product', $product->slug) }}">
                                <div class="h-64 w-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center ">
                                    @if($product->featured_image)
                                    <img src="{{ asset($product->featured_image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover">
                                    @else
                                    <i class="fas fa-tshirt text-6xl fashion-gradient-text"></i>
                                    @endif
                                </div>
                            </a>
                            <div class="absolute top-4 right-4">
                                <button
                                    onclick="removeWishlist({{ $product->id }})"
                                    class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-red-500 hover:bg-red-50 transition remove-wishlist-btn"
                                    data-product-id="{{ $product->id }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="sale-badge text-white text-xs px-3 py-1 rounded-full font-medium">
                                    @if($variant?->discount > 0)
                                    {{-- {{ $variant->discount }} --}}
                                    {{ number_format(
                                        ($variant->discount - floor($variant->discount)) >= 0.5
                                            ? ceil($variant->discount)
                                            : $variant->discount,
                                        2
                                    ) }}% OFF
                                    @else
                                    Trending
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="p-4 h-full flex flex-col justify-between ">
                            <a href="{{ route('page.single-product', $product->slug) }}" class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-gray-900">
                                    {{ $product->name }}
                                </h3>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ config('app.currency') }}{{ number_format($variant?->discount_price ?? 0, 2) }}</p>
                                    @if($variant?->price > $variant?->discount_price)
                                    <p class="text-gray-500 text-sm line-through">{{ config('app.currency') }}{{ number_format($variant?->price ?? 0, 2) }}</p>
                                    @endif
                                </div>
                            </a>

                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($product->description, 65) }}
                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-tag text-purple-500"></i>
                                    <span>{{ $product->category->name ?? 'Casual Wear' }}</span>
                                </div>
                                @if($product->stock > 0)
                                <div class="flex items-center gap-1 text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                    <span>In Stock</span>
                                </div>
                                @else
                                <div class="flex items-center gap-1 text-red-600">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Out of Stock</span>
                                </div>
                                @endif
                            </div>

                           <div>
                             <!-- Add to Cart Button -->
                            <div class="flex gap-2 mb-3">
                                <button
                                    onclick="addToCart({{ $variant?->id }}, this)"
                                    class="flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium add-to-cart-btn"
                                    {{ $product->stock < 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </div>

                            <!-- Remove from Wishlist Button -->
                            <div class="flex gap-2">
                                <button
                                    onclick="removeWishlist({{ $product->id }})"
                                    class="w-full py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition text-sm font-medium remove-from-wishlist-btn"
                                    data-product-id="{{ $product->id }}">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Remove from Wishlist
                                </button>
                            </div>
                           </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

                <!-- Pagination Section -->
                @if($wishlistItems->count() > 0 && $wishlistItems instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pagination-container">
                    <div class="text-sm text-gray-600">
                        Showing {{ $wishlistItems->firstItem() }} to {{ $wishlistItems->lastItem() }} of {{ $wishlistItems->total() }} items
                    </div>

                    <div class="flex items-center gap-2 pagination">
                        {{-- Previous Page Link --}}
                        @if($wishlistItems->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        @else
                        <a href="{{ $wishlistItems->previousPageUrl() }}"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition pagination-link"
                            data-page="{{ $wishlistItems->currentPage() - 1 }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        @endif

                        {{-- First Page --}}
                        @if($wishlistItems->currentPage() > 3)
                        <a href="{{ $wishlistItems->url(1) }}"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition pagination-link"
                            data-page="1">
                            1
                        </a>
                        @if($wishlistItems->currentPage() > 4)
                        <span class="pagination-ellipsis">...</span>
                        @endif
                        @endif

                        {{-- Page Numbers --}}
                        @for($i = max(1, $wishlistItems->currentPage() - 2); $i <= min($wishlistItems->lastPage(), $wishlistItems->currentPage() + 2); $i++)
                            @if($i == $wishlistItems->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl fashion-gradient text-white">
                                {{ $i }}
                            </span>
                            @else
                            <a href="{{ $wishlistItems->url($i) }}"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition pagination-link"
                                data-page="{{ $i }}">
                                {{ $i }}
                            </a>
                            @endif
                            @endfor

                            {{-- Last Page --}}
                            @if($wishlistItems->currentPage() < $wishlistItems->lastPage() - 2)
                                @if($wishlistItems->currentPage() < $wishlistItems->lastPage() - 3)
                                    <span class="pagination-ellipsis">...</span>
                                    @endif
                                    <a href="{{ $wishlistItems->url($wishlistItems->lastPage()) }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition pagination-link"
                                        data-page="{{ $wishlistItems->lastPage() }}">
                                        {{ $wishlistItems->lastPage() }}
                                    </a>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if($wishlistItems->hasMorePages())
                                    <a href="{{ $wishlistItems->nextPageUrl() }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition pagination-link"
                                        data-page="{{ $wishlistItems->currentPage() + 1 }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    @else
                                    <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                    @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Define removeWishlist globally
    function removeWishlist(productId) {
        // Show confirmation dialog
        Swal.fire({
            title: 'Remove from Wishlist?',
            text: 'Are you sure you want to remove this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ec4899',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, remove it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the product card
                let productCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                // Make AJAX request
                fetch('/wishlist/remove', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Animate removal
                        if (productCard) {
                            productCard.style.opacity = '0';
                            productCard.style.transform = 'scale(0.9)';
                            productCard.style.transition = 'all 0.3s ease';
                        }
                        
                        // Update wishlist count badges
                        document.querySelectorAll('.wishlist-count').forEach(function(item) {
                            item.textContent = data.wishlist_count;
                            if (data.wishlist_count > 0) {
                                item.style.display = "flex";
                            } else {
                                item.style.display = "none";
                            }
                        });
                        // Update total items
                        const totalItems = document.getElementById('wishlist-total-items');
                        if (totalItems) {
                            totalItems.textContent = data.wishlist_count;
                        }
                        
                        setTimeout(() => {
                            if (productCard) {
                                productCard.remove();
                            }
                            
                            // Show success message
                            Swal.fire({
                                title: 'Removed!',
                                text: 'Item removed from wishlist',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Check if wishlist is empty
                            const remainingItems = document.querySelectorAll('.product-card').length;
                            if (remainingItems === 0) {
                                const grid = document.querySelector('.wishlist-grid');
                                if (grid) {
                                    const emptyState = `
                                <div class="col-span-full">
                                    <div class="bg-white rounded-2xl shadow-sm p-12 text-center empty-state">
                                        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <i class="fas fa-heart text-purple-600 text-3xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                                            Your wishlist is empty
                                        </h3>
                                        <p class="text-gray-600 mb-6">
                                            Start adding items you love to your wishlist
                                        </p>
                                        <a href="{{ url('/') }}"
                                            class="inline-block px-8 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                                            Start Shopping
                                        </a>
                                    </div>
                                </div>
                            `;
                                    grid.innerHTML = emptyState;
                                }

                                // Hide pagination
                                const pagination = document.querySelector('.pagination-container');
                                if (pagination) {
                                    pagination.style.display = 'none';
                                }
                            }
                        }, 300);
                    } else {
                        Swal.fire('Error', data.message || 'Error removing item', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error removing item from wishlist', 'error');
                });
            }
        });
    }

    // Define addToCart globally
    function addToCart(variantId, btn) {
        if (!variantId) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Show loading state
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
        btn.disabled = true;

        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    variant_id: variantId,
                    count: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button UI
                    btn.innerHTML = '<i class="fas fa-check mr-2"></i> Added';
                    btn.disabled = true;
                    btn.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    btn.classList.add('bg-green-500', 'text-white', 'cursor-not-allowed');

                    // Show success message
                    Swal.fire({
                        title: 'Added!',
                        text: 'Product added to cart!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Trigger confetti
                    blastCelebration(btn);
                } else {
                    // Restore button
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    Swal.fire('Error', data.message || 'Error adding to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                Swal.fire('Error', 'Error adding to cart', 'error');
            });
    }

    // Confetti celebration function
    function blastCelebration(buttonElement) {
        const rect = buttonElement.getBoundingClientRect();
        const x = (rect.left + rect.width / 2) / window.innerWidth;
        const y = (rect.top + rect.height / 2) / window.innerHeight;

        if (typeof confetti !== 'undefined') {
            confetti({
                particleCount: 120,
                spread: 90,
                startVelocity: 45,
                origin: {
                    x: x,
                    y: y
                },
                shapes: ['text'],
                scalar: 1.5,
                text: {
                    value: ['🎁', '🎉', '🎈'],
                    font: '10px Arial'
                }
            });
        }
    }

    // Document ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Wishlist page loaded');
        
        // Initialize any additional functionality here if needed
    });

    console.log('Wishlist JavaScript loaded');
</script>
@endsection