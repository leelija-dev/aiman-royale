@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
    <div class="container mx-auto">
        <!-- Products Grid -->
        <div class="w-full grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-6" id="products-grid">
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
                        <div class="absolute top-3 right-3 bg-white/80 rounded-full p-2 shadow-md w-[35px] h-[35px] flex justify-center items-center">
                            <div class="w-5 h-5 bg-gray-300 rounded-full"></div>
                        </div>
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
                <div class="group w-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card" data-product-slug="{{ $category->slug }}">
                    <!-- Image Wrapper -->
                    <div class="relative rounded-xl overflow-hidden">
                        <img
                            src="{{ $category->image 
                            ? asset('uploads/category/' . $category->image) 
                            : asset('assets/images/placeholder.jpg') }}"
                            alt="{{ $category->name }}"
                            class="w-full h-[340px] object-cover object-top object-center"
                            loading="lazy" />

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($category->is_trending ?? false)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                                Trending
                            </span>
                            @endif
                            @if($category->discount_percentage ?? false)
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                -{{ $category->discount_percentage }}%
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900 truncate">
                            {{ $category->name }}
                        </h3>

                        <div class="md:hidden block">
                            <button
                                class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full hover:bg-secondary-light transition-colors">
                                Add
                            </button>
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
        }, 1500); // Adjust timing as needed

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

<!-- Optional: Additional CSS for smooth skeleton loading -->
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
</style>
@endsection