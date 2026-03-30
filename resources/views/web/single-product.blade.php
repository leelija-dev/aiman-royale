@extends('layout.web.main-layout')
@section('page-type', 'single-product')

@php
    // Pass product category data to navbar for breadcrumbs
    $productCategory = null;
    if (isset($product) && $product->category) {
        $productCategory = [
            'name' => $product->category->name,
            'slug' => $product->category->slug
        ];
    }
    
    // Calculate dynamic rating and review count from false_reviews table
    $reviews = \App\Models\FalseReview::where('product_id', $product->id)->get();
    
    $reviewCount = $reviews->count();
    $averageRating = $reviewCount > 0 ? round($reviews->avg('rating'), 1) : 0;
    $fullStars = floor($averageRating);
    $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
    
    // Debug: Log the product data to check if category is loaded
    error_log('Product Data: ' . json_encode([
        'product_id' => $product->id ?? 'null',
        'product_name' => $product->name ?? 'null',
        'category_id' => $product->category_id ?? 'null',
        'category_exists' => isset($product->category),
        'category_name' => $product->category->name ?? 'null',
        'parts_count' => $product->parts ? $product->parts->count() : 0,
        'stitching_type' => $product->stitching_type ?? 'null',
        'review_count' => $reviewCount,
        'average_rating' => $averageRating
    ]));
@endphp

@section('content')
@if($product == true)


<style>
    .custom-color-btn {
        transition: all 0.2s ease;
    }
    
    .custom-color-btn:hover {
        transform: scale(1.1);
    }
    
    .custom-color-btn.border-secondary {
        border-color: var(--secondary-color, #8b5cf6) !important;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
    }

    .thumbnail.selected {
        border-color: var(--secondary-color, #8b5cf6) !important;
    }

    .color-btn.border-secondary {
        border-color: var(--secondary-color, #8b5cf6) !important;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
    }

    .size-btn.border-secondary {
        border-color: var(--secondary-color, #8b5cf6) !important; 
        background-color: rgba(139, 92, 246, 0.1);
    }
</style>

<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">

    @if($product->variants->first() == true)

    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-[55%_40%] gap-6">
            <!-- LEFT IMAGE SECTION -->
            <div class="flex flex-col lg:flex-row gap-2">
                <!-- Thumbnails Container -->
                <div id="thumbnail-container" class="flex xl:min-w-32 min-w-24 lg:py-0 py-2 items-center lg:overflow-visible overflow-auto lg:flex-col gap-4 order-2 lg:order-1">
                    @php
                    // Get images of the currently selected variant
                    $currentVariant = $product->variants->first();
                    $variantImages = collect();
                    
                    if ($currentVariant) {
                        if ($currentVariant->images && $currentVariant->images->isNotEmpty()) {
                            $variantImages = $currentVariant->images;
                        } elseif ($currentVariant->image) {
                            // Create a collection with single image
                            $stdClass = new \stdClass();
                            $stdClass->image = $currentVariant->image;
                            $variantImages = collect([$stdClass]);
                        }
                    }
                    
                    // Fallback to product images if no variant images
                    if ($variantImages->isEmpty()) {
                        $variantImages = $product->images;
                    }
                    @endphp
                    
                    @forelse($variantImages as $index => $image)
                    @php
                    $imagePath = ltrim($image->image, '/');
                    @endphp
                    <div class="thumbnail xl:w-28 w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 cursor-pointer {{ $index == 0 ? 'selected border-secondary' : 'border-transparent' }}" 
                         data-display="{{ asset($imagePath) }}" 
                         data-large="{{ asset($imagePath) }}"
                         onclick="updateMainImage('{{ asset($imagePath) }}', '{{ $product->name }}', this)">
                        <img src="{{ asset($imagePath) }}" class="w-full h-full object-cover object-center object-top" alt="{{ $product->name }}" />
                    </div>
                    @empty
                    <div class="thumbnail xl:w-28 w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 border-secondary cursor-pointer selected" 
                         data-display="{{ asset('assets/images/placeholder.jpg') }}" 
                         data-large="{{ asset('assets/images/placeholder.jpg') }}"
                         onclick="updateMainImage('{{ asset('assets/images/placeholder.jpg') }}', '{{ $product->name }}', this)">
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" class="w-full h-full object-cover object-center object-top" alt="{{ $product->name ?? 'Product' }}" />
                    </div>
                    @endforelse
                </div>

                <!-- Main Image with Hover Pan Zoom -->
                <div class="zoom-container w-full relative group order-1 lg:order-2 h-full aspect-[1/2]">
                    @php
                    $firstImage = $variantImages->first();
                    $mainImagePath = $firstImage ? ltrim($firstImage->image, '/') : 'assets/images/placeholder.jpg';
                    @endphp
                    <img src="{{ asset($mainImagePath) }}" 
                         class="w-full h-full object-cover object-center object-top" 
                         alt="{{ $product->name ?? 'Product' }}" 
                         id="main-image" />
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur rounded-full p-3 shadow-lg opacity-0 transition-opacity fullscreen-btn">
                        <button id="fullscreen-btn" class="text-gray-800 hover:text-blue-700">
                            <i class="fas fa-expand text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="space-y-6">
                <div>
                    <!-- Title -->
                    <h3 class="text-h3-xs sm:text-h3-sm md:text-h3-md lg:text-h3-lg lgg:text-h3-lgg xl:text-h3-xl 2xl:text-h3-2xl font-semibold">
                        {{ $product->name }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $product->brand ?? 'Brand Name' }}</p>
                    <p class="text-sm text-gray-500">Sold By: Store</p>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="flex text-yellow-400 text-sm">
                        @for($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @if($hasHalfStar)
                            <i class="fas fa-star-half-alt"></i>
                        @endif
                        @for($i = 0; $i < $emptyStars; $i++)
                            <i class="far fa-star"></i>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">{{ $averageRating }} · {{ $reviewCount }} {{ $reviewCount == 1 ? 'Review' : 'Reviews' }}</span>
                </div>
                
                <div class="flex items-center gap-3 flex-wrap" id="price-container">
                    @php
                    $firstVariant = $product->variants->first();
                    $currentPrice = $firstVariant->discount_price ?? $firstVariant->price;
                    $originalPrice = $firstVariant->price;
                    $discount = $firstVariant->discount;
                    @endphp
                    <span class="text-2xl font-bold text-gray-900">Rs. {{ $currentPrice }}</span>
                    @if($originalPrice != $currentPrice)
                    <span class="line-through text-gray-400">Rs. {{ $originalPrice }}</span>
                    @endif
                    @if($discount > 0)
                    <span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">({{ $discount }}% off)</span>
                    @else
                    <span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">Trending</span>
                    @endif
                </div>

                <!-- Type Selection -->
                <div>
                    <h3 class="font-medium mb-3 text-gray-800">Select Type</h3>
                    <div class="flex gap-3 xxs:flex-row flex-col">
                        <button class="type-btn px-6 py-3 rounded-lg border-2 border-secondary bg-secondary/10 text-secondary transition-all" data-type="stitched">
                            Stitched
                        </button>
                        <button id="custom-dimension-btn" class="px-6 py-3 rounded-lg border-2 border-dashed border-gray-400 text-gray-600 hover:border-secondary hover:text-secondary transition-all flex items-center gap-2">
                            <i class="fas fa-ruler-combined"></i> Custom Dimension
                        </button>
                    </div>
                </div>

                <!-- Custom Dimension Input Section (Hidden by Default) -->
                <div id="custom-dimension-section" class="hidden space-y-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h3 class="font-medium text-gray-800">Enter Custom Dimensions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bust (in cm)</label>
                            <input type="number" id="custom-bust" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary" placeholder="Enter bust" min="1" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waist (in cm)</label>
                            <input type="number" id="custom-waist" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary" placeholder="Enter waist" min="1" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hip (in cm)</label>
                            <input type="number" id="custom-hip" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary" placeholder="Enter hip" min="1" step="0.1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Armhole (in cm)</label>
                            <input type="number" id="custom-armhole" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary" placeholder="Enter Armhole" min="1" step="0.1">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Color</label>
                        <div class="flex gap-3" id="custom-color-selection">
                            <div class="flex flex-wrap gap-2">
                                @if(isset($colors) && $colors->count() > 0)
                                    @foreach($colors as $color)
                                    <button class="custom-color-btn w-8 h-8 rounded-full border-2 border-gray-300 hover:scale-110 transition-all" 
                                            style="background-color: {{ $color->code }};" 
                                            data-color="{{ $color->code }}"
                                            title="{{ $color->name }}"></button>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 text-sm">No colors available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button id="save-dimension-btn" class="px-6 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/80 transition-colors">Save Dimensions</button>
                        <button id="cancel-custom-btn" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">Cancel</button>
                    </div>
                </div>

                <!-- Size Selection -->
                <div id="size-selection-section" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-expand-alt text-secondary"></i> Select Size
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Choose your perfect fit</p>
                        </div>
                        <button type="button" data-size-guide-trigger class="px-4 py-2.5 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-xl hover:from-gray-800 hover:to-gray-700 transition-all shadow hover:shadow-md flex items-center gap-2 w-fit">
                            <i class="fas fa-ruler-combined"></i> View Size Guide
                        </button>
                    </div>

                    <div class="flex gap-3 flex-wrap" id="size-buttons">
                        @php
                        $sizes = $product->variants->pluck('size')->unique()->filter();
                        @endphp
                        @foreach($sizes as $size)
                        <button class="size-btn relative w-14 h-14 rounded-full border-2 border-gray-200 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 group" 
                                data-size="{{ $size }}">
                            <span class="text-lg font-semibold text-gray-800 group-hover:text-secondary">{{ $size }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Color Selection -->
                <div id="color-selection-section">
                    <h3 class="font-medium mb-3 text-gray-800">Select Color</h3>
                    <div class="flex gap-3 flex-wrap" id="color-selection">
                        @php
                        $firstVariant = $product->variants->first();
                        $selectedSize = $firstVariant->size ?? 'M';
                        $colorsForSize = $product->variants->where('size', $selectedSize);
                        @endphp
                        
                        @forelse($colorsForSize as $index => $variant)
                        @php
                        $isSelected = ($index == 0);
                        
                        // Get variant image with proper path
                        $variantImage = '';
                        if ($variant->images && $variant->images->isNotEmpty()) {
                            $firstImage = $variant->images->first();
                            // Remove any leading slashes to avoid double slashes
                            $imagePath = ltrim($firstImage->image, '/');
                            $variantImage = asset($imagePath);
                        } elseif ($variant->image) {
                            $imagePath = ltrim($variant->image, '/');
                            $variantImage = asset($imagePath);
                        } else {
                            $variantImage = asset('assets/images/placeholder.jpg');
                        }
                        @endphp
                        <button class="color-btn w-10 h-10 rounded-full border-2 {{ $isSelected ? 'border-secondary' : 'border-gray-300' }} transition-all hover:scale-110"
                                style="background-color: {{ $variant->color }};"
                                data-color="{{ $variant->color }}"
                                data-size="{{ $variant->size }}"
                                data-variant-id="{{ $variant->id }}"
                                data-variant-image="{{ $variantImage }}"
                                title="{{ $variant->color }}">
                        </button>
                        @empty
                        <p class="text-gray-500 text-sm">No colors available for this size</p>
                        @endforelse
                    </div>
                </div>

                <!-- Best Offers Section -->
                <div>
                    <h3 class="font-medium mb-2">Best Offers</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Special offer get 25% off <span class="text-secondary cursor-pointer">T&C</span></li>
                        <li>• Bank offer get 30% off on Axis Bank Credit Card <span class="text-secondary cursor-pointer">T&C</span></li>
                        <li>• Wallet offer get 40% cashback via Paytm <span class="text-secondary cursor-pointer">T&C</span></li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div id="action-buttons-section" class="flex flex-col gap-3 pt-4 md:relative fixed md:bottom-auto md:left-auto md:z-0 md:bg-transparent md:backdrop-blur-none lgg:px-0 md:pb-0 bottom-0 left-0 w-full z-[1000] bg-white/32 p-4 backdrop-blur-[23px]"
                     data-product-variants="{{ json_encode($product->variants) }}">
                    <div class="flex items-center gap-4">
                        <button id="add-to-cart" data-variant-id="{{ $product->variants->first()->id }}" class="bg-secondary text-white lgg:px-8 px-4 py-4 rounded-lg hover:bg-secondary/80 font-medium flex-1 text-lg transition">
                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                        </button>
                        <button id="wishlist-btn" class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition border-gray-300">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    
                    <!-- WhatsApp Share Button -->
                    <a href="https://wa.me/91{{ config('app.wh_number') }}?text={{ urlencode('Hello! I am interested in this product: ' . $product->name . ' - ' . route('page.single-product', $product->slug) . ' Price: ₹' . $product->variants->first()->price) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="bg-[#25D366] text-white px-4 py-3 rounded-lg hover:bg-[#128C7E] font-medium flex items-center justify-center gap-2 transition w-full text-decoration-none">
                        <i class="fab fa-whatsapp text-xl"></i>
                        <span>Order on WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
        </div>
    </div>
    @endif
</section>

<!-- Fullscreen Modal -->
<div class="fixed inset-0 bg-black/95 hidden items-center justify-center z-50" id="zoom-modal">
    <button class="absolute top-8 right-8 text-white text-4xl hover:text-gray-300 z-10" id="close-zoom">
        <i class="fas fa-times"></i>
    </button>
    <div class="max-w-6xl max-h-full p-8">
        <img src="" id="zoom-modal-image" alt="Zoomed Image" class="max-w-full max-h-full object-contain" />
    </div>
</div>

<!-- Product Details and Specifications Section -->
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <!-- DESKTOP TABS -->
        <div class="hidden md:block">
            <div class="flex gap-10 border-b text-p-lg xl:text-p-xl 2xl:text-p-2xl">
                <button class="tab-btn border-b-2 border-black pb-2 text-black" data-tab="details">Product Details</button>
                <button class="tab-btn border-b-2 border-transparent pb-2 text-gray-500" data-tab="specification">Specification</button>
                <button class="tab-btn border-b-2 border-transparent pb-2 text-gray-500" data-tab="reviews">Ratings & Reviews</button>
            </div>

            <!-- Tab Content Container -->
            <div class="mt-6 relative min-h-[300px]">
                <!-- Product Details Tab -->
                <div class="tab-content active" id="details">
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-2">Product Details</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
                        {{ $product->description ?? 'No description available.' }}
                    </p>
                    @if($product->fabric)
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">Material & Care</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
                        {{ $product->fabric }}<br />Machine Wash
                    </p>
                    @endif
                    @if($product->fit)
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1">Size & Fit</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">
                        {{ $product->fit }}
                    </p>
                    @endif
                    
                    <!-- Product Parts with Fabric and Stitching Type -->
                    @if($product->parts && $product->parts->count() > 0)
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-2">Product Parts</h3>
                    <div class="space-y-3">
                        @foreach($product->parts as $part)
                        <div class="border-l-4 border-gray-300 pl-4 py-2">
                            <h4 class="font-medium text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl mb-2 text-gray-900">
                                {{ $part->part_name }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">
                                @if($part->fabric)
                                <div class="flex flex-col">
                                    <span class="text-gray-500 text-xs">Fabric</span>
                                    <span class="text-gray-900">{{ $part->fabric }}</span>
                                </div>
                                @endif
                                @if($part->work_type)
                                <div class="flex flex-col">
                                    <span class="text-gray-500 text-xs">Work Type</span>
                                    <span class="text-gray-900">{{ $part->work_type }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Specification Tab -->
                <div class="tab-content hidden" id="specification">
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-4">Product Specifications</h3>
                    
                    <div class="css-175oi2r" style="flex-flow: wrap; flex: 1 1 0%; padding: 16px 32px 16px 16px; margin-right: -24px;">
                        <!-- Stitching Type -->
                        @if($product->stitching_type)
                        <div class="mb-4 p-3 border rounded-lg bg-gray-50">
                            <h4 class="font-semibold text-lg mb-2" style="color: #333;">Stitching Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Stitching Type</span>
                                    <span class="text-base font-medium text-gray-900">{{ ucfirst($product->stitching_type) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Display Product Parts -->
                        @if($product->parts && $product->parts->count() > 0)
                        @foreach($product->parts as $part)
                        <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                            <h4 class="font-semibold text-lg mb-3" style="color: #333; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">
                                {{ $part->part_name }}
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($part->fabric)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Fabric</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->fabric }}</span>
                                </div>
                                @endif
                                @if($part->work_type)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Work Type</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->work_type }}</span>
                                </div>
                                @endif
                                @if($part->color)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Color</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->color }}</span>
                                </div>
                                @endif
                                @if($part->pattern)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Pattern</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->pattern }}</span>
                                </div>
                                @endif
                                @if($part->embroidery)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Embroidery</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->embroidery }}</span>
                                </div>
                                @endif
                                @if($part->lining)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Lining</span>
                                    <span class="text-base font-medium text-gray-900">{{ $part->lining }}</span>
                                </div>
                                @endif
                                @if($part->description)
                                <div class="flex flex-col md:col-span-2">
                                    <span class="text-sm text-gray-500">Details</span>
                                    <span class="text-base text-gray-900">{{ $part->description }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!-- Common Specifications -->
                        <div class="mt-4 p-3 border rounded-lg bg-gray-50">
                            <h4 class="font-semibold text-lg mb-2" style="color: #333;">Additional Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($product->type)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Type</span>
                                    <span class="text-base font-medium text-gray-900">{{ $product->type }}</span>
                                </div>
                                @endif
                                @if($product->color)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Color</span>
                                    <span class="text-base font-medium text-gray-900">{{ $product->color }}</span>
                                </div>
                                @endif
                                @if($product->fit)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Fit</span>
                                    <span class="text-base font-medium text-gray-900">{{ $product->fit }}</span>
                                </div>
                                @endif
                                @if($product->fabric && !$product->parts)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Fabric</span>
                                    <span class="text-base font-medium text-gray-900">{{ $product->fabric }}</span>
                                </div>
                                @endif
                                @if($product->sales_package)
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Package Contains</span>
                                    <span class="text-base font-medium text-gray-900">{{ $product->sales_package }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-content hidden" id="reviews">
                    <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-2">Ratings & Reviews</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700">Reviews content will appear here.</p>
                </div>
            </div>
        </div>

        <!-- MOBILE ACCORDION -->
        <div class="md:hidden border-t border-b divide-y">
            <div class="accordion-wrapper active">
                <div class="flex justify-between items-center py-4 cursor-pointer">
                    <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Product Details</span>
                    <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300" src="{{ asset('assets/images/arrow-down 1.svg') }}" alt="Toggle" />
                </div>
                <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
                <div class="accordion-content-block overflow-hidden">
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl pt-4 pb-4">
                        {{ $product->description ?? 'No description available.' }}
                    </p>
                </div>
            </div>

            <div class="accordion-wrapper">
                <div class="flex justify-between items-center py-4 cursor-pointer">
                    <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Specification</span>
                    <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300" src="{{ asset('assets/images/arrow-down 1.svg') }}" alt="Toggle" />
                </div>
                <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
                <div class="accordion-content-block overflow-hidden">
                    <div class="pt-4 pb-4">
                        @if($product->stitching_type)
                        <div class="mb-4 p-3 border rounded bg-gray-50">
                            <h5 class="font-semibold mb-2">Stitching Information</h5>
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Stitching Type:</span>
                                <span class="font-medium">{{ ucfirst($product->stitching_type) }}</span>
                            </div>
                        </div>
                        @endif

                        @if($product->parts && $product->parts->count() > 0)
                        @foreach($product->parts as $part)
                        <div class="mb-4 p-3 border rounded bg-gray-50">
                            <h5 class="font-semibold mb-2">{{ $part->part_name }}</h5>
                            @if($part->fabric)
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Fabric:</span>
                                <span class="font-medium">{{ $part->fabric }}</span>
                            </div>
                            @endif
                            @if($part->work_type)
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Work Type:</span>
                                <span class="font-medium">{{ $part->work_type }}</span>
                            </div>
                            @endif
                            @if($part->color)
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Color:</span>
                                <span class="font-medium">{{ $part->color }}</span>
                            </div>
                            @endif
                            @if($part->pattern)
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Pattern:</span>
                                <span class="font-medium">{{ $part->pattern }}</span>
                            </div>
                            @endif
                            @if($part->embroidery)
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Embroidery:</span>
                                <span class="font-medium">{{ $part->embroidery }}</span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <p class="text-gray-700">Specification details will appear here.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="accordion-wrapper">
                <div class="flex justify-between items-center py-4 cursor-pointer">
                    <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl">Ratings & Reviews</span>
                    <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px] transition-transform duration-300" src="{{ asset('assets/images/arrow-down 1.svg') }}" alt="Toggle" />
                </div>
                <div class="line-border-block h-[1px] bg-[#e5e7eb]"></div>
                <div class="accordion-content-block overflow-hidden">
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl pt-0 pb-0">Reviews content here</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
<section class="px-4 lgg:py-12 py-6">
     <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">Related Products</h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if(isset($relatedProducts))
            @forelse($relatedProducts as $relatedProduct)
            @php
            $variant = $relatedProduct->variants->first();
            $productImage = $relatedProduct->images->first();
            $imagePath = $productImage ? ltrim($productImage->image, '/') : 'assets/images/placeholder.jpg';
            @endphp
            <div class="item flex items-center justify-center">
                <div class="group w-full xxs:max-w-full max-w-[300px] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset($imagePath) }}" 
                             alt="{{ $relatedProduct->name }}" 
                             class="w-full h-[340px] object-cover object-top object-center" />
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($relatedProduct->is_trending ?? false)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">Trending</span>
                            @endif
                            @if($variant && $variant->discount)
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                @if($variant->discount == 0) Trending @else OFF {{ $variant->discount }}% @endif
                            </span>
                            @endif
                        </div>
                        {{--
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 wishlist-btn-related" 
                                data-product-id="{{ $variant->product_id }}">
                            <i class="far fa-heart"></i>
                        </button>
                        --}}
                    </div>
                    <a href="{{route('page.single-product', $relatedProduct->slug)}}">
                        <div class="p-4 space-y-1">
                            <h3 class="text-[15px] font-semibold text-gray-900">{{ $relatedProduct->name }}</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span>{{ $relatedProduct->brand ?? '' }}</span>
                                <span class="flex items-center gap-1 text-gray-700">
                                    <span class="text-sm font-medium">{{ $relatedProduct->rating ?? '4.4' }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                <span class="text-lg font-bold text-gray-900">Rs. {{ $variant->discount_price ?? $variant->price }}</span>
                                @if($variant->discount_price)
                                <span class="text-sm text-gray-400 line-through">Rs. {{ $variant->price }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="item flex items-center justify-center">
                <p class="text-gray-500">No related products found.</p>
            </div>
            @endforelse
            @else
            <div class="item flex items-center justify-center">
                <p class="text-gray-500">Related products not available.</p>
            </div>
            @endif
        </div>
    </div>
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">Most Wishlisted Products</h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if(isset($mostWishlistedProducts))
            @forelse($mostWishlistedProducts as $relatedProduct)
            @php
            $variant = $relatedProduct->variants->first();
            $productImage = $relatedProduct->featured_image;
            $imagePath = $productImage ? ltrim($productImage, '/') : 'assets/images/placeholder.jpg';
            // Debug: Check if variant exists
            if (!$variant) {
                continue; // Skip this product if no variant found
            }
            @endphp
            <div class="item flex items-center justify-center">
                <div class="group w-full xxs:max-w-full max-w-[300px] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset($imagePath) }}" 
                             alt="{{ $relatedProduct->name }}" 
                             class="w-full h-[340px] object-cover object-top object-center" />
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($relatedProduct->is_trending ?? false)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">Trending</span>
                            @endif
                            @if($variant && $variant->discount)
                            <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded">
                                @if($variant->discount == 0) Trending @else OFF {{ $variant->discount }}% @endif
                            </span>
                            @endif
                        </div>
                        {{--
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 wishlist-btn-related" 
                                data-product-id="{{ $variant->product_id }}">
                            <i class="far fa-heart"></i>
                        </button>
                        --}}
                    </div>
                    <a href="{{route('page.single-product', $relatedProduct->slug)}}">
                        <div class="p-4 space-y-1">
                            <h3 class="text-[15px] font-semibold text-gray-900">{{ $relatedProduct->name }}</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span>{{ $relatedProduct->brand ?? '' }}</span>
                                <span class="flex items-center gap-1 text-gray-700">
                                    <span class="text-sm font-medium">{{ $relatedProduct->rating ?? '4.4' }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                <span class="text-lg font-bold text-gray-900">Rs. {{ $variant->discount_price ?? $variant->price }}</span>
                                @if($variant->discount_price)
                                <span class="text-sm text-gray-400 line-through">Rs. {{ $variant->price }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="item flex items-center justify-center">
                <p class="text-gray-500">No related products found.</p>
            </div>
            @endforelse
            @else
            <div class="item flex items-center justify-center">
                <p class="text-gray-500">Related products not available.</p>
            </div>
            @endif
        </div>
    </div>
</section>


<!-- Last Viewed Products Section -->
@if($lastViewedProducts && $lastViewedProducts->isNotEmpty())

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-3">
            <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">Last Viewed Products</h2>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @forelse($lastViewedProducts as $lastViewedProduct)
           
            @php
            $imagePath = $lastViewedProduct['featured_image'] ? ltrim($lastViewedProduct['featured_image'], '/') : 'assets/images/placeholder.jpg';
            @endphp
            <div class="item flex items-center justify-center">
                <div class="group w-full xxs:max-w-full max-w-[300px] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="{{ asset($imagePath) }}" 
                             alt="{{ $lastViewedProduct['id'] }}" 
                             class="w-full h-[340px] object-cover object-top object-center" />
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($lastViewedProduct['is_trending'] ?? false)
                            <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">Trending</span>
                            @endif
                            <span class="bg-gray-800 text-white text-xs font-semibold px-2 py-1 rounded">Recently Viewed</span>
                        </div>
                        {{--
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110 wishlist-btn-related" 
                                data-product-id="{{ $lastViewedProduct['id'] }}">
                            <i class="far fa-heart"></i>
                        </button>
                        --}}
                    </div>
                    <a href="{{route('page.single-product', $lastViewedProduct['slug'])}}">
                        <div class="p-4 space-y-1">
                            <h3 class="text-[15px] font-semibold text-gray-900">{{ $lastViewedProduct['name'] }}</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span>{{ $lastViewedProduct->brand ?? '' }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                <span class="text-lg font-bold text-gray-900">Rs. {{ $lastViewedProduct['price'] }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="item flex items-center justify-center">
                <p class="text-gray-500">No recently viewed products.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endif

<!-- Editor's Pick Section -->
<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
            <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">Editor's Pick</h2>
        </div>
        <div class="grid-container">
            <div class="owl-carousel banner-carousel lgg:hidden">
                <div class="relative bg-[#b8a89a] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
                    <img src="{{ asset('assets/images/Home-image/pic-8.avif') }}" alt="Traditional Blouse" class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">Trendy To<br />Traditional Blouses</h2>
                        <p class="text-sm text-black mb-6">Get <span class="font-semibold">7% OFF</span> | Use Code: <span class="text-[#c28b54] font-medium">GLAM7</span></p>
                        <button class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">SHOP NOW</button>
                    </div>
                </div>
                <div class="relative bg-[#e8dcd6] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]">
                    <img src="{{ asset('assets/images/Home-image/pic-9.avif') }}" alt="Jewellery Edit" class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">Jewellery Edit</h2>
                        <p class="text-sm text-black mb-6">Get <span class="font-semibold">7% OFF</span> | Use Code: <span class="text-[#c28b54] font-medium">GLAM7</span></p>
                        <button class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">SHOP NOW</button>
                    </div>
                </div>
            </div>
            <div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[600px] min-h-[500px] h-[50vh]">
                <div class="relative bg-[#b8a89a] overflow-hidden">
                    <img src="{{ asset('assets/images/Home-image/pic-10.avif') }}" alt="Traditional Blouse" class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">Trendy To<br />Traditional Blouses</h2>
                        <p class="text-sm text-black mb-6">Get <span class="font-semibold">7% OFF</span> | Use Code: <span class="text-[#c28b54] font-medium">GLAM7</span></p>
                        <button class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">SHOP NOW</button>
                    </div>
                </div>
                <div class="relative bg-[#e8dcd6] overflow-hidden">
                    <img src="{{ asset('assets/images/Home-image/pic-11.avif') }}" alt="Jewellery Edit" class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                    <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">Jewellery Edit</h2>
                        <p class="text-sm text-black mb-6">Get <span class="font-semibold">7% OFF</span> | Use Code: <span class="text-[#c28b54] font-medium">GLAM7</span></p>
                        <button class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition">SHOP NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@else
<div class="container mx-auto">
    <div class="w-full text-center mb-6 mt-5">
        <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
    </div>
</div>
@endif

@php
$variant = $product?->variants?->first();
$basePrice = $variant?->discount_price ?? $variant?->price ?? 0;
@endphp

<!-- Tab Switching JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for scroll position in URL hash and restore it
    const urlHash = window.location.hash;
    if (urlHash) {
        if (urlHash.includes('action-section:')) {
            // Handle scroll position from previous implementation
            const scrollPosition = parseInt(urlHash.split('action-section:')[1]) || 0;
            setTimeout(() => {
                window.scrollTo({
                    top: scrollPosition,
                    behavior: 'smooth'
                });
            }, 100);
        } else if (urlHash.includes('action-buttons-section')) {
            // Handle action buttons section anchor
            setTimeout(() => {
                const element = document.getElementById('action-buttons-section');
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }, 100);
        }
    }

    // Desktop tab switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = {
        'details': document.getElementById('details'),
        'specification': document.getElementById('specification'),
        'reviews': document.getElementById('reviews')
    };
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            tabBtns.forEach(b => {
                b.classList.remove('border-black', 'text-black');
                b.classList.add('border-transparent', 'text-gray-500');
            });
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-black', 'text-black');
            
            Object.keys(tabContents).forEach(key => {
                if (tabContents[key]) {
                    if (key === tabId) {
                        tabContents[key].classList.remove('hidden');
                        tabContents[key].classList.add('active');
                    } else {
                        tabContents[key].classList.add('hidden');
                        tabContents[key].classList.remove('active');
                    }
                }
            });
        });
    });
    
    // Mobile accordion functionality
    const accordionWrappers = document.querySelectorAll('.accordion-wrapper');
    
    accordionWrappers.forEach(wrapper => {
        const header = wrapper.querySelector('.flex.justify-between');
        const content = wrapper.querySelector('.accordion-content-block');
        const chevron = wrapper.querySelector('.accordion-chevron');
        
        if (header && content) {
            if (wrapper.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + 'px';
                chevron.style.transform = 'rotate(180deg)';
            } else {
                content.style.maxHeight = '0';
                chevron.style.transform = 'rotate(0deg)';
            }
            
            header.addEventListener('click', function() {
                const isActive = wrapper.classList.contains('active');
                
                if (isActive) {
                    wrapper.classList.remove('active');
                    content.style.maxHeight = '0';
                    chevron.style.transform = 'rotate(0deg)';
                } else {
                    wrapper.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    chevron.style.transform = 'rotate(180deg)';
                }
            });
        }
    });

    // WhatsApp Share Button Functionality
    const whatsappBtn = document.getElementById('whatsapp-share-btn');
    // console.log(whatsappBtn)
    if (whatsappBtn) {
        whatsappBtn.addEventListener('click', function() {
            shareOnWhatsApp();
        });
    }
});
</script>

<script src="{{asset('web/js/single-product.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const loginUrl = "{{route('page.login')}}";

// Store all product variants data
const productVariants = @json($product->variants);
// console.log(productVariants)

// Set default size and color from first variant
let selectedSize = '{{ $product?->variants?->first()->size ?? "M" }}';
let selectedColor = '{{ $product?->variants?->first()->color ?? "" }}';
let selectedVariantId = '{{ $product?->variants?->first()->id ?? "" }}';

let selectedType = 'stitched';
let customDimensions = null;
let selectedCustomColor = null;

// WhatsApp Share Function
function shareOnWhatsApp() {
    // Get product details
    const productName = "{{ $product->name ?? 'Product' }}";
    const productPrice = document.querySelector('#price-container .text-2xl')?.textContent || "{{ $basePrice }}";
    const productUrl = window.location.href;
    const mainImage = document.getElementById('main-image')?.src || '';
    
    // Get selected variant details
    let selectedVariant = null;
    if (selectedVariantId) {
        selectedVariant = productVariants.find(v => v.id == selectedVariantId);
    }
    
    const size = selectedSize || 'N/A';
    const color = selectedColor || 'N/A';
    
    // Build the message
    let message = `*${productName}*\n\n`;
    message += `💰 *Price:* ${productPrice}\n`;
    message += `📏 *Size:* ${size}\n`;
    message += `🎨 *Color:* ${color}\n`;
    
    if (customDimensions) {
        message += `📐 *Custom Dimensions:*\n`;
        message += `   Bust: ${customDimensions.bust} cm\n`;
        message += `   Waist: ${customDimensions.waist} cm\n`;
        message += `   Hip: ${customDimensions.hip} cm\n`;
        message += `   Armhole: ${customDimensions.armhole} cm\n`;
    }
    
    message += `\n🔗 *Product Link:* ${productUrl}\n\n`;
    message += `🛍️ Check out this amazing product!`;
    
    // Encode the message for URL
    const encodedMessage = encodeURIComponent(message);
    
    // Open WhatsApp Web with the message
    window.open(`https://web.whatsapp.com/send?text=${encodedMessage}`, '_blank');
    
    // Optional: Show success message
    showNotification('WhatsApp opened! Share this product with your friends.', 'success');
}

// Image functions
function updateMainImage(imageSrc, altText, thumbnailElement) {
    const mainImage = document.getElementById('main-image');
    if (mainImage) {
        mainImage.src = imageSrc;
        mainImage.alt = altText;
    }
    
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('selected', 'border-secondary');
        thumb.classList.add('border-transparent');
    });
    
    if (thumbnailElement) {
        thumbnailElement.classList.add('selected', 'border-secondary');
        thumbnailElement.classList.remove('border-transparent');
    }
}

// Custom dimensions and color functionality
document.addEventListener('DOMContentLoaded', function() {
    const saveDimensionBtn = document.getElementById('save-dimension-btn');
    const cancelCustomBtn = document.getElementById('cancel-custom-btn');
    const customBustInput = document.getElementById('custom-bust');
    const customWaistInput = document.getElementById('custom-waist');
    const customHipInput = document.getElementById('custom-hip');
    const customArmholeInput = document.getElementById('custom-armhole');
    
    // Custom color selection
    const customColorBtns = document.querySelectorAll('.custom-color-btn');
    
    if (customColorBtns.length > 0) {
        customColorBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                customColorBtns.forEach(b => {
                    b.classList.remove('ring-2', 'ring-offset-2', 'border-secondary');
                });
                this.classList.add('ring-2', 'ring-offset-2', 'border-secondary');
                selectedCustomColor = this.getAttribute('data-color');
            });
        });
    }
    
    if (saveDimensionBtn) {
        saveDimensionBtn.addEventListener('click', function() {
            // Get fresh references to input elements
            const bustInput = document.getElementById('custom-bust');
            const waistInput = document.getElementById('custom-waist');
            const hipInput = document.getElementById('custom-hip');
            const armholeInput = document.getElementById('custom-armhole');

            const bust = bustInput ? bustInput.value : '';
            const waist = waistInput ? waistInput.value : '';
            const hip = hipInput ? hipInput.value : '';
            const armhole = armholeInput ? armholeInput.value : '';

            console.log('Input values:', { bust, waist, hip, armhole }); // Debug log

            if (!bust || !waist || !hip || !armhole) {
                showNotification('Please enter all measurements', 'error');
                return;
            }

            if (bust <= 0 || waist <= 0 || hip <= 0 || armhole <= 0) {
                showNotification('All measurements must be positive numbers', 'error');
                return;
            }

            const selectedColorBtn = document.querySelector('#custom-color-selection .ring-2');
            const selectedColor = selectedColorBtn ? selectedColorBtn.getAttribute('data-color') : null;

            if (!selectedColor) {
                showNotification('Please select a color', 'error');
                return;
            }

            customDimensions = {
                bust: parseFloat(bust),
                waist: parseFloat(waist),
                hip: parseFloat(hip),
                armhole: parseFloat(armhole),
                color: selectedColor,
                type: selectedType
            };

            console.log('Custom dimensions to save:', customDimensions); // Debug log

            // Send to backend to save to database
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                showNotification('Security token not found. Please refresh the page.', 'error');
                return;
            }

            // Show loading state
            const originalText = saveDimensionBtn.innerHTML;
            saveDimensionBtn.disabled = true;
            saveDimensionBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            fetch('/custom-dimensions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                    bust: parseFloat(bust),
                    waist: parseFloat(waist),
                    hip: parseFloat(hip),
                    armhole: parseFloat(armhole),
                    color_code: selectedColor,
                    type: selectedType
                })
            })
            .then(response => {
                if (response.status === 401) {
                    // Redirect to action buttons section after login
                    const currentUrl = window.location.href.split('#')[0]; // Remove any existing hash
                    const redirectUrl = currentUrl + '#action-buttons-section';
                    window.location.href = loginUrl + '?redirect=' + encodeURIComponent(redirectUrl);
                    return;
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                
                if (data.success) {
                    showNotification('Custom dimensions saved successfully!', 'success');
                    toggleCustomDimension();

                    const addToCartBtn = document.getElementById('add-to-cart');
                    if (addToCartBtn) {
                        addToCartBtn.setAttribute('data-custom-dimensions', JSON.stringify(customDimensions));
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add Custom Item to Cart';
                        addToCartBtn.classList.remove('bg-green-600');
                        addToCartBtn.classList.add('bg-secondary');
                        addToCartBtn.disabled = false;
                    }
                    
                    updateCustomPrice();
                } else {
                    showNotification(data.message || 'Failed to save custom dimensions', 'error');
                }
            })
            .catch(error => {
                if (error.message !== 'Authentication required') {
                    console.error('Error saving custom dimensions:', error);
                    showNotification('An error occurred while saving custom dimensions', 'error');
                }
            })
            .finally(() => {
                // Restore button state
                saveDimensionBtn.disabled = false;
                saveDimensionBtn.innerHTML = originalText;
            });
        });
    }
    
    if (cancelCustomBtn) {
        cancelCustomBtn.addEventListener('click', function() {
            if (customBustInput) customBustInput.value = '';
            if (customWaistInput) customWaistInput.value = '';
            if (customHipInput) customHipInput.value = '';
            if (customArmholeInput) customArmholeInput.value = '';
            
            if (customColorBtns.length > 0) {
                customColorBtns.forEach(btn => btn.classList.remove('ring-2', 'ring-offset-2', 'border-secondary'));
                selectedCustomColor = null;
            }
            
            toggleCustomDimension();
        });
    }

    // Type buttons
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            selectType(type);
        });
    });

    // Custom dimension button
    const customDimensionBtn = document.getElementById('custom-dimension-btn');
    if (customDimensionBtn) {
        customDimensionBtn.addEventListener('click', toggleCustomDimension);
    }

    // Size buttons
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const size = this.getAttribute('data-size');
            selectSize(size);
        });
    });

    // Set initial type
    selectType('stitched');

    // Set initial size and color
    if (selectedSize) {
        selectSize(selectedSize);
    }

    // Add to cart button
    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            addToCart();
        });

        if (selectedVariantId) {
            checkVariantInCart(selectedVariantId);
        }
    }

    // Wishlist button
    const wishlistBtn = document.getElementById('wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            toggleWishlist({{ $product?->id }}, this);
        });
    }

    // Related products wishlist buttons
    document.querySelectorAll('.wishlist-btn-related').forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            const productId = this.getAttribute('data-product-id');
            toggleWishlist(productId, this);
        });
    });

    checkProductInWishlist({{ $product?->id }});
});

function selectType(type) {
    selectedType = type;
    document.querySelectorAll('.type-btn').forEach(btn => {
        if (btn.getAttribute('data-type') === type) {
            btn.classList.add('border-secondary', 'bg-secondary/10', 'text-secondary');
            btn.classList.remove('border-gray-300', 'text-gray-700');
        } else {
            btn.classList.remove('border-secondary', 'bg-secondary/10', 'text-secondary');
            btn.classList.add('border-gray-300', 'text-gray-700');
        }
    });
}

function toggleCustomDimension() {
    const section = document.getElementById('custom-dimension-section');
    const customBtn = document.getElementById('custom-dimension-btn');
    const sizeSection = document.getElementById('size-selection-section');
    const colorSection = document.getElementById('color-selection-section');

    if (!section || !customBtn) return;

    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        customBtn.classList.add('border-secondary', 'text-secondary', 'bg-secondary/10');
        customBtn.classList.remove('border-dashed', 'border-gray-400', 'text-gray-600');
        if (sizeSection) sizeSection.classList.add('hidden');
        if (colorSection) colorSection.classList.add('hidden');
    } else {
        section.classList.add('hidden');
        customBtn.classList.remove('border-secondary', 'text-secondary', 'bg-secondary/10');
        customBtn.classList.add('border-dashed', 'border-gray-400', 'text-gray-600');
        if (sizeSection) sizeSection.classList.remove('hidden');
        if (colorSection) colorSection.classList.remove('hidden');
    }
}

function updateCustomPrice() {
    if (!customDimensions) return;
    
    const basePrice = {{ $basePrice ?? 0 }};
    const customPrice = Math.round(basePrice * 1.2);

    const priceContainer = document.getElementById('price-container');
    if (priceContainer) {
        priceContainer.innerHTML = `
            <span class="text-2xl font-bold text-gray-900">Rs. ${customPrice}</span>
            <span class="text-sm text-gray-500 ml-2">(Custom)</span>
        `;
    }
}

function selectSize(size) {
    selectedSize = size;

    document.querySelectorAll('.size-btn').forEach(btn => {
        if (btn.getAttribute('data-size') === size) {
            btn.classList.add('border-secondary', 'bg-secondary/10');
            btn.classList.remove('border-gray-200');
        } else {
            btn.classList.remove('border-secondary', 'bg-secondary/10');
            btn.classList.add('border-gray-200');
        }
    });

    updateColorOptions(size);

    if (customDimensions) {
        customDimensions = null;
        selectedCustomColor = null;
        const addToCartBtn = document.getElementById('add-to-cart');
        if (addToCartBtn) {
            addToCartBtn.removeAttribute('data-custom-dimensions');
            addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
            addToCartBtn.classList.remove('bg-green-600');
            addToCartBtn.classList.add('bg-secondary');
            addToCartBtn.disabled = false;
        }
        
        const selectedVariant = productVariants.find(v => v.id == selectedVariantId);
        if (selectedVariant) {
            updatePrice(selectedVariant);
        }
    }
}

function updateColorOptions(size) {
    const colorSelection = document.getElementById('color-selection');
    if (!colorSelection) return;
    
    // Clear existing buttons but keep the container
    while (colorSelection.firstChild) {
        colorSelection.removeChild(colorSelection.firstChild);
    }
    
    const colorsForSize = productVariants.filter(variant => variant.size === size);

    if (colorsForSize.length === 0) {
        const noColorsMsg = document.createElement('p');
        noColorsMsg.className = 'text-gray-500 text-sm';
        noColorsMsg.textContent = 'No colors available for this size';
        colorSelection.appendChild(noColorsMsg);
        return;
    }

    colorsForSize.forEach((variant, index) => {
        const colorBtn = document.createElement('button');
        colorBtn.className = `color-btn w-10 h-10 rounded-full border-2 ${index === 0 ? 'border-secondary' : 'border-gray-300'} transition-all hover:scale-110`;
        colorBtn.style.backgroundColor = variant.color;
        colorBtn.setAttribute('data-color', variant.color);
        colorBtn.setAttribute('data-size', size);
        colorBtn.setAttribute('data-variant-id', variant.id);
        
        // Fix: Generate correct image URL
        let variantImage = '{{ asset("assets/images/placeholder.jpg") }}';
        
        if (variant.images && variant.images.length > 0) {
            // If images is an array of objects with image property
            if (typeof variant.images[0] === 'object' && variant.images[0].image) {
                let imagePath = variant.images[0].image;
                // Remove leading slash if present to avoid double slashes
                imagePath = imagePath.replace(/^\/+/, '');
                variantImage = '{{ url("") }}/' + imagePath;
            } 
            // If images is an array of strings
            else if (typeof variant.images[0] === 'string') {
                let imagePath = variant.images[0];
                imagePath = imagePath.replace(/^\/+/, '');
                variantImage = variant.images[0].startsWith('http') ? variant.images[0] : '{{ url("") }}/' + imagePath;
            }
        } else if (variant.image) {
            let imagePath = variant.image;
            imagePath = imagePath.replace(/^\/+/, '');
            variantImage = variant.image.startsWith('http') ? variant.image : '{{ url("") }}/' + imagePath;
        }
        
        colorBtn.setAttribute('data-variant-image', variantImage);
        colorBtn.setAttribute('title', variant.color);
        
        colorBtn.addEventListener('click', function() {
            selectColor(variant.color, size, variant.id, this);
        });

        colorSelection.appendChild(colorBtn);
    });

    if (colorsForSize.length > 0) {
        const firstColorBtn = colorSelection.querySelector('.color-btn');
        if (firstColorBtn) {
            selectColor(colorsForSize[0].color, size, colorsForSize[0].id, firstColorBtn);
        }
    }
}

function selectColor(color, size, variantId, element) {
    selectedColor = color;
    selectedVariantId = variantId;

    document.querySelectorAll('.color-btn').forEach(btn => {
        if (btn.getAttribute('data-color') === color && btn.getAttribute('data-size') === size) {
            btn.classList.add('border-secondary');
            btn.classList.remove('border-gray-300');
        } else {
            btn.classList.remove('border-secondary');
            btn.classList.add('border-gray-300');
        }
    });

    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.setAttribute('data-variant-id', variantId);
    }

    if (customDimensions) {
        customDimensions = null;
        selectedCustomColor = null;
        if (addToCartBtn) {
            addToCartBtn.removeAttribute('data-custom-dimensions');
            addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
            addToCartBtn.classList.remove('bg-green-600');
            addToCartBtn.classList.add('bg-secondary');
            addToCartBtn.disabled = false;
        }
    }

    const variantImage = element.getAttribute('data-variant-image');
    if (variantImage) {
        const mainImage = document.getElementById('main-image');
        if (mainImage) {
            mainImage.src = variantImage;
            console.log('Updated main image to:', variantImage);
        }
    }

    const selectedVariant = productVariants.find(v => v.id == variantId);
    if (selectedVariant) {
        updatePrice(selectedVariant);
        
        // Update images for the selected variant
        updateVariantImages(selectedVariant);
    }

    checkVariantInCart(variantId);
}

function updateVariantImages(variant) {
    console.log(variant)
    const mainImage = document.getElementById('main-image');
    const thumbnailContainer = document.getElementById('thumbnail-container');
    
    if (!variant) return;
    
    // Handle variant images
    if (variant.images && variant.images.length > 0) {
        // Update main image to first variant image
        if (mainImage) {
            const firstImage = variant.images[0];
            let firstImagePath = '{{ asset("assets/images/placeholder.jpg") }}';
            
            if (typeof firstImage === 'object' && firstImage.image) {
                let imagePath = firstImage.image.replace(/^\/+/, '');
                firstImagePath = '{{ url("") }}/' + imagePath;
            } else if (typeof firstImage === 'string') {
                let imagePath = firstImage.replace(/^\/+/, '');
                firstImagePath = firstImage.startsWith('http') ? firstImage : '{{ url("") }}/' + imagePath;
            }
            
            mainImage.src = firstImagePath;
            mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
            console.log('Updated main image to:', firstImagePath);
        }
        
        // Update thumbnails with variant images
        if (thumbnailContainer) {
            let thumbnailsHtml = '';
            variant.images.forEach((image, index) => {
                let imagePath = '{{ asset("assets/images/placeholder.jpg") }}';
                
                if (typeof image === 'object' && image.image) {
                    let path = image.image.replace(/^\/+/, '');
                    imagePath = '{{ url("") }}/' + path;
                } else if (typeof image === 'string') {
                    let path = image.replace(/^\/+/, '');
                    imagePath = image.startsWith('http') ? image : '{{ url("") }}/' + path;
                }
                
                const selectedClass = index === 0 ? 'selected border-secondary' : 'border-transparent';
                thumbnailsHtml += `<div class="thumbnail xl:w-28 w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 cursor-pointer ${selectedClass}" data-display="${imagePath}" data-large="${imagePath}" onclick="updateMainImage('${imagePath}', '{{ $product?->name }}', this)"><img src="${imagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
            });
            thumbnailContainer.innerHTML = thumbnailsHtml;
        }
    } else if (variant.image) {
        // Update with single variant image
        let imagePath = variant.image.replace(/^\/+/, '');
        const fullImagePath = variant.image.startsWith('http') ? variant.image : '{{ url("") }}/' + imagePath;
        
        if (mainImage) {
            mainImage.src = fullImagePath;
            mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
            console.log('Updated main image to:', fullImagePath);
        }
        
        // Update thumbnails with single image
        if (thumbnailContainer) {
            const imagePath = variant.image.startsWith('http') ? variant.image : '{{ url("") }}/' + variant.image.replace(/^\/+/, '');
            thumbnailContainer.innerHTML = `<div class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 cursor-pointer selected border-secondary" data-display="${imagePath}" data-large="${imagePath}" onclick="updateMainImage('${imagePath}', '{{ $product?->name }}', this)"><img src="${imagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
        }
    } else {
        // No images available - show placeholder
        const placeholderPath = '{{ asset("assets/images/placeholder.jpg") }}';
        if (mainImage) {
            mainImage.src = placeholderPath;
            mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
            console.log('No images found, using placeholder:', placeholderPath);
        }
        
        if (thumbnailContainer) {
            thumbnailContainer.innerHTML = `<div class="thumbnail w-20 lg:h-[25%] h-full min-w-20 overflow-hidden rounded-lg border-2 cursor-pointer selected border-secondary" data-display="${placeholderPath}" data-large="${placeholderPath}" onclick="updateMainImage('${placeholderPath}', '{{ $product?->name }}', this)"><img src="${placeholderPath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
        }
    }
}

function updatePrice(variant) {
    const priceContainer = document.getElementById('price-container');
    if (priceContainer && variant) {
        const currentPrice = variant.discount_price || variant.price;
        const originalPrice = variant.price;
        const discount = variant.discount;

        let discountHtml = '';
        if (discount > 0) {
            discountHtml = `<span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">(${discount}% off)</span>`;
        } else {
            discountHtml = `<span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">Trending</span>`;
        }

        let originalPriceHtml = '';
        if (originalPrice != currentPrice) {
            originalPriceHtml = `<span class="line-through text-gray-400">Rs. ${originalPrice}</span>`;
        }

        priceContainer.innerHTML = `
            <span class="text-2xl font-bold text-gray-900">Rs. ${currentPrice}</span>
            ${originalPriceHtml}
            ${discountHtml}
        `;
    }
}

function checkVariantInCart(variantId) {
    if (!variantId) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) return;

    fetch('/cart/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ variant_id: variantId })
    })
    .then(response => response.json())
    .then(data => {
        updateAddToCartButton(data.in_cart, data.quantity);
    })
    .catch(error => console.error('Error checking cart:', error));
}

function checkProductInWishlist(productId) {
    if (!productId) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) return;

    fetch('/wishlist/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        updateWishlistButton(data.in_wishlist);
    })
    .catch(error => console.error('Error checking wishlist:', error));
}

function updateWishlistButton(inWishlist) {
    const wishlistBtn = document.getElementById('wishlist-btn');
    if (!wishlistBtn) return;

    if (inWishlist) {
        wishlistBtn.innerHTML = '<i class="fas fa-heart"></i>';
        wishlistBtn.classList.add('border-red-500', 'text-red-500');
        wishlistBtn.classList.remove('border-gray-300');
    } else {
        wishlistBtn.innerHTML = '<i class="far fa-heart"></i>';
        wishlistBtn.classList.remove('border-red-500', 'text-red-500');
        wishlistBtn.classList.add('border-gray-300');
    }
}

function toggleWishlist(productId, button) {
    if (!productId) {
        alert('Product ID not found');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) return;

    const isInWishlist = button.classList.contains('text-red-500');
    const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';

    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => {
        if (response.status === 401) {
            // Redirect to action buttons section after login
            const currentUrl = window.location.href.split('#')[0]; // Remove any existing hash
            const redirectUrl = currentUrl + '#action-buttons-section';
            window.location.href = loginUrl + '?redirect=' + encodeURIComponent(redirectUrl);
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            if (isInWishlist) {
                button.classList.remove('text-red-500');
                button.innerHTML = '<i class="far fa-heart"></i>';
            } else {
                button.classList.add('text-red-500');
                button.innerHTML = '<i class="fas fa-heart"></i>';
            }
        } else if (data && data.message) {
            Swal.fire({
                icon: 'info',
                title: 'Already Added',
                text: data.message,
                confirmButtonText: 'Ok',
                timer: 1800
            });
            button.classList.add('text-red-500');
            button.innerHTML = '<i class="fas fa-heart"></i>';
        }
    })
    .catch(error => console.error('Error toggling wishlist:', error))
    .finally(() => {
        button.disabled = false;
    });
}

function updateAddToCartButton(inCart, quantity = 0) {
    const addToCartBtn = document.getElementById('add-to-cart');
    if (!addToCartBtn) return;

    if (inCart) {
        addToCartBtn.innerHTML = `<i class="fas fa-check mr-2"></i> Added (${quantity})`;
        addToCartBtn.classList.remove('bg-secondary');
        addToCartBtn.classList.add('bg-green-600');
        addToCartBtn.disabled = true;
    } else {
        if (customDimensions) {
            addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add Custom Item to Cart';
        } else {
            addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
        }
        addToCartBtn.classList.remove('bg-green-600');
        addToCartBtn.classList.add('bg-secondary');
        addToCartBtn.disabled = false;
    }
}

function addToCart() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        alert('Security token not found. Please refresh the page.');
        return;
    }

    const addToCartBtn = document.getElementById('add-to-cart');
    if (!addToCartBtn) return;

    const customDimensionsAttr = addToCartBtn.getAttribute('data-custom-dimensions');
    let requestData = {};

    if (customDimensionsAttr) {
        requestData = {
            product_id: {{ $product?->id }},
            custom_dimensions: JSON.parse(customDimensionsAttr),
            type: selectedType,
            count: 1
        };
    } else {
        const variantId = addToCartBtn.getAttribute('data-variant-id');

        if (!variantId) {
            alert('Please select a size and color');
            return;
        }

        requestData = {
            variant_id: variantId,
            type: selectedType,
            count: 1
        };
    }

    const originalText = addToCartBtn.innerHTML;
    addToCartBtn.disabled = true;
    addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        if (response.status === 401) {
            // Redirect to action buttons section after login
            const currentUrl = window.location.href.split('#')[0]; // Remove any existing hash
            const redirectUrl = currentUrl + '#action-buttons-section';
            window.location.href = loginUrl + '?redirect=' + encodeURIComponent(redirectUrl);
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            showNotification('Product added to cart successfully!', 'success');

            if (data.cart_count !== undefined) {
                updateCartCount(data.cart_count);
            }

            if (customDimensionsAttr) {
                addToCartBtn.innerHTML = `<i class="fas fa-check mr-2"></i> Added`;
                addToCartBtn.classList.remove('bg-secondary');
                addToCartBtn.classList.add('bg-green-600');
                addToCartBtn.disabled = true;
            } else {
                const variantId = addToCartBtn.getAttribute('data-variant-id');
                checkVariantInCart(variantId);
            }
        } else {
            showNotification(data?.message || 'Failed to add product to cart', 'error');
            addToCartBtn.disabled = false;
            addToCartBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding to cart', 'error');
        addToCartBtn.disabled = false;
        addToCartBtn.innerHTML = originalText;
    });
}

// function showNotification(message, type = 'success') {
//     if (typeof Swal !== 'undefined') {
//         Swal.fire({
//             icon: type,
//             title: type === 'success' ? 'Success!' : 'Error!',
//             text: message,
//             timer: 3000,
//             showConfirmButton: false
//         });
//     } else {
//         const notification = document.createElement('div');
//         notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
//             type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
//         }`;
//         notification.textContent = message;

//         document.body.appendChild(notification);

//         setTimeout(() => {
//             notification.style.opacity = '0';
//             setTimeout(() => {
//                 document.body.removeChild(notification);
//             }, 300);
//         }, 3000);
//     }
// }

function showNotification(message, type = 'success') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: type === 'success' ? 'Success!' : 'Error!',
            text: message,
            confirmButtonText: 'OK',
            showConfirmButton: true
        }).then((result) => {
            if (result.isConfirmed && type === 'success') {
                location.reload();
            }
        });
    } else {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
                if (type === 'success') {
                    location.reload();
                }
            }, 300);
        }, 3000);
    }
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    const cartBadges = document.querySelectorAll('.absolute.-top-1.-right-1.w-5.h-5.bg-primary');

    cartCountElements.forEach(element => {
        element.textContent = count;
    });
    
    cartBadges.forEach(badge => {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    });
}

// Fullscreen image functionality
document.addEventListener('DOMContentLoaded', function() {
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const zoomModal = document.getElementById('zoom-modal');
    const closeZoom = document.getElementById('close-zoom');
    const zoomModalImage = document.getElementById('zoom-modal-image');
    const mainImage = document.getElementById('main-image');

    if (fullscreenBtn && zoomModal && closeZoom && zoomModalImage) {
        fullscreenBtn.addEventListener('click', function() {
            zoomModalImage.src = mainImage.src;
            zoomModal.classList.remove('hidden');
        });

        closeZoom.addEventListener('click', function() {
            zoomModal.classList.add('hidden');
        });

        zoomModal.addEventListener('click', function(e) {
            if (e.target === zoomModal) {
                zoomModal.classList.add('hidden');
            }
        });
    }
});
</script>

@endsection