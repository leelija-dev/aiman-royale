@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
    <div class="container mx-auto">
        <!-- Products Grid -->
        <div class="w-full grid xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-3 smxl:grid-cols-2 lg:gap-4 gap-3" id="products-grid">
            <!-- Skeleton Loading -->
            <div id="skeleton-loading" class="contents">
                @for($i = 0; $i < 8; $i++)
                <div class="group w-full bg-white rounded-xl shadow-sm cursor-pointer">
                    <!-- Image Skeleton -->
                    <div class="relative rounded-xl overflow-hidden bg-gray-200 animate-pulse">
                        <div class="w-full h-[340px]"></div>
                        <!-- Badge Skeleton -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            <div class="w-16 h-6 bg-gray-300 rounded"></div>
                        </div>
                        <!-- Wishlist Skeleton -->
                        <!-- <div class="absolute top-3 right-3 bg-white/80 rounded-full p-2 shadow-md w-[35px] h-[35px] flex justify-center items-center">
                            <div class="w-5 h-5 bg-gray-300 rounded-full"></div>
                        </div> -->
                    </div>
                    
                    <!-- Content Skeleton -->
                    <div class="p-4 space-y-3">
                        <div class="h-5 bg-gray-200 rounded w-3/4 animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2 animate-pulse"></div>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="h-6 bg-gray-200 rounded w-1/3 animate-pulse"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4 animate-pulse"></div>
                        </div>
                        <div class="md:hidden block">
                            <div class="px-4 py-1 bg-gray-200 rounded-md w-full h-10 animate-pulse"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Actual Products -->
            <div id="products-content" class="contents" style="display: none;">
                @forelse($categories as $category)
                <div class="px-0">
                    <div class="block w-full product-card" data-product-slug="{{ $category->slug }}">
                        <div class="relative overflow-hidden group bg-[#f8f6f4] rounded-[18px] transition-all duration-300 hover:shadow-lg" style="aspect-ratio: 9/15;">
                            
                            <!-- Image -->
                            <div class="absolute inset-0">
                                <img 
                                    src="{{ $category->image ?  $category->image : asset('assets/images/placeholder.jpg') }}" 
                                    alt="{{ $category->name }}" 
                                    class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                    loading="lazy" 
                                    decoding="async" 
                                    width="600" 
                                    height="1000">
                            </div>

                            <!-- Subtle Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-40 transition-opacity duration-500"></div>

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
                                @if($category->is_trending ?? false)
                                <span class="bg-primary text-white text-[10px] font-semibold px-3 py-1 rounded-full shadow-lg">
                                    Trending
                                </span>
                                @endif
                                @if($category->discount_percentage ?? false)
                                <span class="bg-red-500 text-white text-[10px] font-semibold px-3 py-1 rounded-full shadow-lg">
                                    -{{ $category->discount_percentage }}%
                                </span>
                                @endif
                            </div>

                            <!-- Wishlist Button -->
                            <!-- <div class="absolute top-3 right-3 z-10">
                                <button class="bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-lg hover:bg-white transition-all duration-300 w-[35px] h-[35px] flex justify-center items-center group/like">
                                    <svg class="w-4 h-4 text-gray-600 group-hover/like:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div> -->

                            <!-- Content - Clean Layout at Bottom -->
                            <div class="absolute bottom-[5px] left-0 right-0 py-5 md:py-6 px-[14px]">
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 ease-out flex flex-col items-center justify-center">
                                    <!-- Category/Subtitle -->
                                    <span class="inline-block text-white/80 text-[9px] md:text-[10px] font-medium tracking-[0.2em] uppercase mb-1.5">
                                        {{ $category->parent ? $category->parent->name : 'Collection' }}
                                    </span>
                                    
                                    <!-- Title -->
                                    <h3 class="text-white text-lg md:text-xl lg:text-2xl font-light tracking-wide leading-tight mb-1 text-center uppercase">
                                        {{ $category->name }}
                                    </h3>

                                    <!-- Description -->
                                    @if($category->description)
                                    <p class="text-white/60 text-[10px] md:text-xs text-center line-clamp-1 mb-2 uppercase">
                                        {!! Str::limit($category->description, 60) !!}
                                    </p>
                                    @endif
                                    
                                    <!-- Shop Now Button -->
                                    <span class="inline-block rounded-[11px] bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-5 md:px-6 py-1.5 md:py-2 text-[10px] md:text-xs font-medium tracking-wide transition-all duration-300 ease-in-out cursor-pointer shadow-lg">
                                        Shop Now
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 col-span-full">
                    <p class="text-gray-500 text-lg">No products found in this category.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulate loading
        const skeleton = document.getElementById('skeleton-loading');
        const products = document.getElementById('products-content');
        
        // Show skeleton immediately
        skeleton.style.display = 'contents';
        products.style.display = 'none';
        
        // Simulate API/data fetch delay
        setTimeout(function() {
            // Hide skeleton, show products
            skeleton.style.display = 'none';
            products.style.display = 'contents';
        }, 1500);

        // Add click event listeners to all product cards
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Prevent navigation if clicking on buttons or links inside the card
                if (e.target.closest('button') || e.target.closest('a')) {
                    return;
                }

                const productSlug = this.getAttribute('data-product-slug');
                if (productSlug) {
                    window.location.href = `/collections/${productSlug}`;
                }
            });
        });
    });
</script>

<style>
    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }
        100% {
            background-position: 200px 0;
        }
    }
    
    .animate-pulse {
        animation: pulse 1.5s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    /* Custom styles for the new card design */
    .product-card .group {
        transition: all 0.3s ease;
    }

    .product-card:hover .group {
        transform: translateY(-2px);
    }

    /* Line clamp for description */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection