@extends('layout.web.main-layout')
@dd($wishlistItems)
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

                <!-- Wishlist Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 wishlist-grid">
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
                            <div class="wishlist-item product-card bg-white rounded-2xl shadow-sm overflow-hidden" data-product-id="{{ $product->id }}">
                                <div class="relative">
                                    <a href="{{ route('page.single-product', $product->slug) }}">
                                        <div class="h-64 w-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                            @if($image)
                                                <img src="{{ asset($image->image) }}" 
                                                     alt="{{ $product->name }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <i class="fas fa-tshirt text-6xl fashion-gradient-text"></i>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="absolute top-4 right-4">
                                        <button
                                            onclick="removeWishlist({{ $wishlist->product_id }})"
                                            class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-red-500 hover:bg-red-50 transition remove-wishlist-btn">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="absolute top-4 left-4">
                                        <span class="sale-badge text-white text-xs px-3 py-1 rounded-full font-medium">
                                            @if($variant?->discount > 0)
                                                {{ $variant->discount }}% OFF
                                            @else
                                                Trending
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-bold text-gray-900">
                                            {{ $product->name }}
                                        </h3>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">{{ config('app.currency') }}{{ number_format($variant?->discount_price ?? 0, 2) }}</p>
                                            @if($variant?->price > $variant?->discount_price)
                                                <p class="text-gray-500 text-sm line-through">{{ config('app.currency') }}{{ number_format($variant?->price ?? 0, 2) }}</p>
                                            @endif
                                        </div>
                                    </div>

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

                                    <div class="flex gap-2">
                                        <button
                                            onclick="addToCart({{ $variant?->id }}, this)"
                                            class="flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium add-to-cart-btn"
                                            {{ $product->stock < 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                        </button>
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
// Main JavaScript Object
const WishlistManager = {
    init: function() {
        this.attachEvents();
        this.initPagination();
    },

    attachEvents: function() {
        this.attachRemoveEvents();
        this.attachAddToCartEvents();
        this.attachCollectionTabEvents();
        this.attachFilterEvents();
        this.attachNotifyEvents();
        this.attachShareEvents();
    },

    attachRemoveEvents: function() {
        const removeButtons = document.querySelectorAll('.remove-wishlist-btn');
        removeButtons.forEach(button => {
            button.removeEventListener('click', this.handleRemoveClick);
            button.addEventListener('click', this.handleRemoveClick);
        });
    },

    attachAddToCartEvents: function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            if (!button.disabled) {
                button.removeEventListener('click', this.handleAddToCartClick);
                button.addEventListener('click', this.handleAddToCartClick);
            }
        });
    },

    attachCollectionTabEvents: function() {
        const collectionTabs = document.querySelectorAll('.collection-tab');
        collectionTabs.forEach(tab => {
            tab.removeEventListener('click', this.handleCollectionTabClick);
            tab.addEventListener('click', this.handleCollectionTabClick);
        });
    },

    attachFilterEvents: function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.removeEventListener('click', this.handleFilterClick);
            button.addEventListener('click', this.handleFilterClick);
        });
    },

    attachNotifyEvents: function() {
        const notifyButtons = document.querySelectorAll('.notify-btn');
        notifyButtons.forEach(button => {
            button.removeEventListener('click', this.handleNotifyClick);
            button.addEventListener('click', this.handleNotifyClick);
        });
    },

    attachShareEvents: function() {
        const shareButton = document.querySelector('.share-wishlist-btn');
        if (shareButton) {
            shareButton.removeEventListener('click', this.handleShareClick);
            shareButton.addEventListener('click', this.handleShareClick);
        }
    },

    handleRemoveClick: function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const button = e.currentTarget;
        const productCard = button.closest('.product-card');
        const productId = button.getAttribute('onclick')?.match(/\d+/)?.[0];
        
        if (!productId) return;

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
                WishlistManager.removeWishlist(productId, productCard);
            }
        });
    },

    handleAddToCartClick: function(e) {
        e.preventDefault();
        const button = e.currentTarget;
        const variantId = button.getAttribute('onclick')?.match(/\d+/)?.[0];
        
        if (!variantId) return;
        
        WishlistManager.addToCart(variantId, button);
    },

    handleCollectionTabClick: function(e) {
        const tabs = document.querySelectorAll('.collection-tab');
        tabs.forEach(t => t.classList.remove('active'));
        e.currentTarget.classList.add('active');
        const collectionName = e.currentTarget.textContent;
        WishlistManager.showNotification(`Showing ${collectionName}`, 'info');
    },

    handleFilterClick: function(e) {
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('filter-active');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        e.currentTarget.classList.remove('bg-gray-100', 'text-gray-700');
        e.currentTarget.classList.add('filter-active');
        
        const filterText = e.currentTarget.textContent.trim();
        WishlistManager.showNotification(`Filtering by: ${filterText}`, 'info');
    },

    handleNotifyClick: function(e) {
        e.preventDefault();
        const productCard = e.currentTarget.closest('.product-card');
        const productName = productCard?.querySelector('h3')?.textContent || 'Product';
        WishlistManager.showNotification(`You'll be notified when ${productName} is back in stock`, 'info');
    },

    handleShareClick: function(e) {
        e.preventDefault();
        WishlistManager.showNotification('Wishlist sharing options would appear here', 'info');
    },

    initPagination: function() {
        const paginationLinks = document.querySelectorAll('.pagination-link');
        paginationLinks.forEach(link => {
            link.removeEventListener('click', WishlistManager.handlePaginationClick);
            link.addEventListener('click', WishlistManager.handlePaginationClick);
        });
    },

    handlePaginationClick: function(e) {
        e.preventDefault();
        
        const link = e.currentTarget;
        const url = link.getAttribute('href');
        const page = link.getAttribute('data-page');
        
        if (!url || url === '#') return;
        
        WishlistManager.loadPage(url, page);
    },

    loadPage: function(url, page) {
        // Show loading state
        const grid = document.querySelector('.wishlist-grid');
        const paginationContainer = document.querySelector('.pagination-container');
        
        if (grid) {
            grid.style.opacity = '0.5';
            grid.style.pointerEvents = 'none';
        }

        // Add loading spinner
        const loadingSpinner = document.createElement('div');
        loadingSpinner.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50';
        loadingSpinner.innerHTML = '<div class="loading-spinner"></div>';
        document.body.appendChild(loadingSpinner);

        // Make AJAX request
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update grid
            const newGrid = doc.querySelector('.wishlist-grid');
            if (newGrid && grid) {
                grid.innerHTML = newGrid.innerHTML;
            }
            
            // Update pagination
            const newPagination = doc.querySelector('.pagination-container');
            if (newPagination && paginationContainer) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }
            
            // Update URL without reload
            window.history.pushState({}, '', url);
            
            // Reattach events
            WishlistManager.attachEvents();
            WishlistManager.initPagination();
            
            // Remove loading states
            if (grid) {
                grid.style.opacity = '1';
                grid.style.pointerEvents = 'auto';
            }
            
            loadingSpinner.remove();
            
            // Scroll to top
            const header = document.querySelector('.bg-white.rounded-2xl.shadow-sm.p-6.mb-6');
            if (header) {
                header.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            WishlistManager.showNotification(`Page ${page} loaded`, 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            if (grid) {
                grid.style.opacity = '1';
                grid.style.pointerEvents = 'auto';
            }
            loadingSpinner.remove();
            WishlistManager.showNotification('Error loading page', 'error');
        });
    },

    addToCart: function(variantId, btn) {
        if (!variantId) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

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
                WishlistManager.showNotification('Product added to cart!', 'success');
                
                // Trigger confetti
                WishlistManager.blastCelebration(btn);
            } else {
                WishlistManager.showNotification(data.message || 'Error adding to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            WishlistManager.showNotification('Error adding to cart', 'error');
        });
    },

    removeWishlist: function(productId, productCard) {
        fetch(`/wishlist/remove`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
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
                productCard.style.opacity = '0';
                productCard.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    productCard.remove();
                    WishlistManager.showNotification('Item removed from wishlist', 'success');
                    
                    // Check if wishlist is empty
                    const remainingItems = document.querySelectorAll('.product-card').length;
                    if (remainingItems === 0) {
                        const grid = document.querySelector('.wishlist-grid');
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
                        
                        // Hide pagination
                        const pagination = document.querySelector('.pagination-container');
                        if (pagination) {
                            pagination.style.display = 'none';
                        }
                    }
                }, 300);
            } else {
                WishlistManager.showNotification(data.message || 'Error removing item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            WishlistManager.showNotification('Error removing item', 'error');
        });
    },

    blastCelebration: function(buttonElement) {
        const rect = buttonElement.getBoundingClientRect();
        const x = (rect.left + rect.width / 2) / window.innerWidth;
        const y = (rect.top + rect.height / 2) / window.innerHeight;

        confetti({
            particleCount: 120,
            spread: 90,
            startVelocity: 45,
            origin: { x: x, y: y },
            shapes: ['text'],
            scalar: 1.5,
            text: {
                value: ['🎁', '🎉', '🎈'],
                font: '10px Arial'
            }
        });
    },

    showNotification: function(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => {
            document.body.removeChild(notification);
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' : 
            type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' :
            'bg-blue-50 text-blue-800 border border-blue-200'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${
                    type === 'error' ? 'fa-exclamation-circle text-red-500' : 
                    type === 'success' ? 'fa-check-circle text-green-500' :
                    'fa-info-circle text-blue-500'
                }"></i>
                <span class="font-medium">${message}</span>
                <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 4 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentElement) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }
        }, 4000);
    }
};

// Initialize on document load
document.addEventListener('DOMContentLoaded', function() {
    WishlistManager.init();
});

// Handle browser back/forward buttons
window.addEventListener('popstate', function() {
    const url = window.location.href;
    WishlistManager.loadPage(url, '');
});
</script>
@endsection