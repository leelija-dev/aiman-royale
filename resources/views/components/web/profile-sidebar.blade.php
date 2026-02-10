<?php
$user = $user ?? auth()->user();
$currentRoute = request()->route()->getName();
?>

<aside>
    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
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
                href="{{route('web.profile')}}"
                class="sidebar-item flex items-center gap-3 p-3 rounded-lg {{ $currentRoute === 'web.profile' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-user w-5 text-center"></i>
                <span>Profile Information</span>
            </a>
            <a
                href="{{ route('page.multi-product') }}"
                class="sidebar-item flex items-center gap-3 p-3 rounded-lg {{ $currentRoute === 'page.multi-product' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-shopping-bag w-5 text-center"></i>
                <span>Order History</span>
            </a>
            <a
                href="#"
                class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50">
                <i class="fas fa-map-marker-alt w-5 text-center"></i>
                <span>My Addresses</span>
            </a>
            <a
                href="{{route('wishlist.index')}}"
                class="sidebar-item flex items-center gap-3 p-3 rounded-lg {{ $currentRoute === 'wishlist.index' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-heart w-5 text-center"></i>
                <span>My Wishlist</span>
            </a>
            <a
                href="#"
                class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-gray-50">
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
</aside>