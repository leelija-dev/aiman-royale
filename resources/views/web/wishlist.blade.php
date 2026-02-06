@extends('layout.web.main-layout')








@section('content')
<style>
    body {
        font-family: "Inter", sans-serif;
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
</style>
<section class="w-full px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <!-- User Profile Summary -->
                    <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            <div
                                class="w-20 h-20 rounded-full fashion-gradient flex items-center justify-center text-white text-xl font-bold mx-auto">
                                AJ
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Alex Johnson</h2>
                        <p class="text-gray-600 text-sm">Fashion Enthusiast</p>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a
                            href="profile.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-user w-5 text-center"></i>
                            <span>Profile Information</span>
                        </a>
                        <a
                            href="orders.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                        </a>
                        <a
                            href="addresses.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-map-marker-alt w-5 text-center"></i>
                            <span>My Addresses</span>
                        </a>
                        <a
                            href="wishlist.html"
                            class="sidebar-item active flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>My Wishlist</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">16</span>
                        </a>
                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-star w-5 text-center"></i>
                            <span>Reviews</span>
                        </a>
                    </nav>

                    <!-- Wishlist Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-4">Wishlist Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Items</span>
                                <span class="font-medium">16</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Collections</span>
                                <span class="font-medium">4</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">On Sale</span>
                                <span class="font-medium text-purple-600">5 items</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Value</span>
                                <span class="font-medium">$1,247.50</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6">
                        <button
                            class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium flex items-center justify-center gap-2 mb-3">
                            <i class="fas fa-share"></i>
                            Share Wishlist
                        </button>
                        <button
                            class="w-full py-3 border border-purple-600 text-purple-600 rounded-xl hover:bg-purple-50 transition font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i>
                            Create New Collection
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Page Header -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
                            <p class="text-gray-600 mt-1">
                                Save your favorite items for later
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex gap-3">
                            <button
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition duration-200 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-sliders-h"></i>
                                Filter
                            </button>
                            <button
                                class="px-4 py-2 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                Add All to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Collection Tabs -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button
                            class="collection-tab active px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            All Items
                        </button>
                        <button
                            class="collection-tab px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            Summer Collection
                        </button>
                        <button
                            class="collection-tab px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            Work Wear
                        </button>
                        <button
                            class="collection-tab px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            Casual Looks
                        </button>
                        <button
                            class="collection-tab px-4 py-2 text-gray-700 hover:text-purple-600 transition">
                            Formal Attire
                        </button>
                    </div>

                    <!-- Quick Filters -->
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="filter-active px-4 py-2 rounded-xl text-sm font-medium transition">
                            All Items
                        </button>
                        <button
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">
                            On Sale
                        </button>
                        <button
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">
                            In Stock
                        </button>
                        <button
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">
                            New Arrivals
                        </button>
                        <button
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-medium transition">
                            Price: Low to High
                        </button>
                    </div>
                </div>

                <!-- Wishlist Items Grid -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Wishlist Item 1 -->

                    @foreach($wishlistItems as $wishlist)

                    <div
                        class="wishlist-item product-card bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="relative">
                            <div
                                class="h-64 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                <div class="text-center">
                                    <i
                                        class="fas fa-tshirt text-6xl fashion-gradient-text mb-4"></i>
                                    <p class="text-gray-700 font-medium">
                                        Premium Cotton T-Shirt
                                    </p>
                                </div>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button
                                    class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-red-500 hover:bg-red-50 transition">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span
                                    class="sale-badge text-white text-xs px-3 py-1 rounded-full font-medium">
                                    20% OFF
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-gray-900">
                                    {{ $wishlist->product->name }}
                                </h3>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">₹{{ $wishlist->product->discount_price}}</p>
                                    <p class="text-gray-500 text-sm line-through">₹{{ $wishlist->product->price}}</p>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm mb-4">
                                Soft cotton blend in classic fit
                            </p>

                            <div
                                class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-tag text-purple-500"></i>
                                    <span>Casual Wear</span>
                                </div>
                                @if($wishlist->product->stock > 1):
                                <div class="flex items-center gap-1 text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                    <span>In Stock</span>
                                </div>
                                @else:
                                <div class="flex items-center gap-1 text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Out Of Stock</span>
                                </div>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <button
                                    class="flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                                <button
                                    class="w-10 h-10 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition flex items-center justify-center">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <!-- Empty State (Hidden by default) -->
                <div class="hidden bg-white rounded-2xl shadow-sm p-12 text-center">
                    <div
                        class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Your wishlist is empty
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Start adding items you love to your wishlist
                    </p>
                    <button
                        class="px-8 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                        Start Shopping
                    </button>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2">
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl fashion-gradient text-white">
                        1
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        2
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        3
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection