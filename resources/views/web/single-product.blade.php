@extends('layout.web.main-layout')
@section('page-type', 'single-product')


@php
    // Pass product category data to navbar for breadcrumbs
    $productCategory = null;
    if (isset($product) && $product->category) {
        $productCategory = [
            'name' => $product->category->name,
            'slug' => $product->category->slug,
        ];
    }

    // Calculate dynamic rating and review count from false_reviews table
    $reviews = \App\Models\FalseReview::where('product_id', $product->id)->get();

    $reviewCount = $reviews->count();
    $averageRating = $reviewCount > 0 ? round($reviews->avg('rating'), 1) : 0;
    $fullStars = floor($averageRating);
    $hasHalfStar = $averageRating - $fullStars >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

    // Debug: Log the product data to check if category is loaded
    error_log(
        'Product Data: ' .
            json_encode([
                'product_id' => $product->id ?? 'null',
                'product_name' => $product->name ?? 'null',
                'category_id' => $product->category_id ?? 'null',
                'category_exists' => isset($product->category),
                'category_name' => $product->category->name ?? 'null',
                'parts_count' => $product->parts ? $product->parts->count() : 0,
                'stitching_type' => $product->stitching_type ?? 'null',
                'review_count' => $reviewCount,
                'average_rating' => $averageRating,
            ]),
    );
@endphp

@section('content')
    @if ($product == true)
        <style>
            /* ========================================
           PRODUCT SECTION STYLES
           Targeting ONLY #single-right-content
           Respects Tailwind custom properties
           ======================================== */

            /* #single-right-content {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        } */

            /* ========== TYPOGRAPHY & HEADINGS ========== */

            #single-right-content .text-h3-xs,
            #single-right-content .text-h3-sm,
            #single-right-content .text-h3-md,
            #single-right-content .text-h3-lg,
            #single-right-content .text-h3-lgg {
                /* font-family: 'Playfair Display', Georgia, serif; */
                font-size: 1.75rem;
                /* font-weight: 700; */
                letter-spacing: -0.02em;
                background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 0.25rem;
            }

            /* Brand Name */
            #single-right-content .mt-1.text-gray-500:first-of-type {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                font-weight: 600;
                /* color: #b8652e !important; */
            }

            /* Manufacturer Text */
            #single-right-content .text-gray-500:last-of-type {
                font-size: 0.7rem;
                /* color: #8b7355 !important; */
                display: flex;
                align-items: center;
                gap: 6px;
            }

            /* ========== RATING SECTION ========== */

            #single-right-content .flex.items-center.gap-2 {
                /* background: #fef6ed; */
                /* padding: 0.5rem 1rem; */
                border-radius: 40px;
                display: inline-flex;
                width: auto;
                /* margin: 0.75rem 0; */
            }

            #single-right-content .flex.text-yellow-400 {
                gap: 3px;
            }

            #single-right-content .flex.text-yellow-400 i {
                font-size: 0.85rem;
                transition: transform 0.2s ease;
            }

            #single-right-content .flex.text-yellow-400 i:hover {
                transform: scale(1.1);
            }

            /* ========== PRICE CONTAINER ========== */

            #single-right-content #price-container {
                /* background: linear-gradient(135deg, #faf8f5 0%, #f5f0ea 100%); */
                padding: 1rem 1.25rem;
                border-radius: 20px;
                /* margin: 1rem 0 1.25rem 0; */
                /* border: 1px solid rgba(184, 101, 46, 0.15); */
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            }

            #single-right-content #price-container .text-xl {
                font-size: 1.85rem !important;

                color: #2c241a;
                letter-spacing: -0.5px;
            }

            #single-right-content #price-container .line-through {
                font-size: 1rem;
                color: #b8a28c;
            }

            /* Discount Badge - using Tailwind secondary color */
            #single-right-content .text-green-600.bg-green-50 {
                background: #e8f3e6 !important;
                color: #2d6a2d !important;
                font-weight: 600;
                padding: 0.25rem 0.85rem;
                border-radius: 30px;
                font-size: 0.75rem;
            }

            /* Trending Badge */
            #single-right-content .bg-\[\\#A13015\] {
                background: linear-gradient(135deg, #c0392b 0%, #a13015 100%) !important;
                padding: 0.25rem 1rem;
                border-radius: 30px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.5px;
                box-shadow: 0 2px 6px rgba(161, 48, 21, 0.3);
            }

            /* ========== SECTION HEADERS ========== */

            #single-right-content .font-medium.mb-3,
            #single-right-content #size-selection-section h3,
            #single-right-content #color-selection-section h3 {
                font-size: 1rem;
                font-weight: 600;
                color: #2d241c;
                margin-bottom: 1rem;
                position: relative;
                display: inline-block;
            }

            #single-right-content .font-medium.mb-3::after,
            #single-right-content #size-selection-section h3::after {
                content: '';
                position: absolute;
                bottom: -6px;
                left: 0;
                width: 35px;
                height: 2px;
                background: #A10000;
                border-radius: 2px;
            }

            /* ========== TYPE BUTTONS ========== */

            #single-right-content .type-btn {
                /* background: white; */
                /* border: 1.5px solid #e8dfd7; */
                border-radius: 50px;
                padding: 0.75rem 1.75rem;
                font-weight: 500;
                font-size: 0.9rem;
                transition: all 0.25s ease;
                cursor: pointer;
            }

            /* Stitched button - using Tailwind secondary */
            /* #single-right-content .type-btn[data-type="stitched"] {
            background: var(--secondary, #b8652e);
            background: linear-gradient(135deg, var(--secondary, #b8652e) 0%, #9a4d22 100%);
            border-color: var(--secondary, #b8652e);
            color: white;
        } */

            #single-right-content .type-btn[data-type="stitched"]:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 14px rgba(184, 101, 46, 0.2);
            }

            /* Custom Dimension Button */
            #single-right-content #custom-dimension-btn {
                /* background: white; */
                /* border: 1.5px dashed #c9b8a8; */
                border-radius: 50px;
                padding: 0.75rem 1.5rem;
                /* color: #8b6b4f; */
            }

            #single-right-content #custom-dimension-btn:hover {
                /* border-color: var(--secondary, #b8652e); */
                /* background: #fffaf5; */
                transform: translateY(-1px);
                /* color: var(--secondary, #b8652e); */
            }

            /* ========== CUSTOM DIMENSION SECTION ========== */

            #single-right-content #custom-dimension-section {

                border: 1px solid #f0e4d8;
                border-radius: 24px;
                padding: 1.5rem;
                margin: 1rem 0;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
            }

            #single-right-content #custom-dimension-section h3 {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 1.2rem;
                color: #2c241c;
            }

            /* Form Inputs */
            #single-right-content #custom-dimension-section input {
                border: 1.5px solid #e9dfd5;
                border-radius: 14px;
                padding: 0.7rem 1rem;
                font-size: 0.9rem;
                transition: all 0.2s;
                background: white;
                width: 100%;
            }

            #single-right-content #custom-dimension-section input:focus {
                border-color: var(--secondary, #b8652e);
                box-shadow: 0 0 0 3px rgba(184, 101, 46, 0.1);
                outline: none;
            }

            /* Custom Color Buttons */
            #single-right-content .custom-color-btn {
                transition: all 0.2s ease;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                cursor: pointer;
            }

            #single-right-content .custom-color-btn:hover {
                transform: scale(1.12);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            }

            /* Save & Cancel Buttons */
            #single-right-content #save-dimension-btn {
                /* background: linear-gradient(135deg, var(--secondary, #b8652e) 0%, #9a4d22 100%); */
                border: none;
                border-radius: 40px;
                padding: 0.7rem 1.8rem;
                font-weight: 600;
                transition: all 0.25s;
                cursor: pointer;
                color: white;
            }

            #single-right-content #save-dimension-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 14px rgba(184, 101, 46, 0.35);
            }

            #single-right-content #cancel-custom-btn {
                border: 1.5px solid #e0d4c8;
                background: white;
                border-radius: 40px;
                padding: 0.7rem 1.8rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
            }

            #single-right-content #cancel-custom-btn:hover {
                background: #f5f0ea;
                border-color: #c9b8a8;
            }

            /* ========== SIZE SELECTION SECTION ========== */

            #single-right-content #size-selection-section {
                background: white;
                border-radius: 28px;
                border: 1px solid #f0e8e0;
                padding: 1.5rem;
                margin: 1.25rem 0;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            }

            /* Size Guide Button */
            #single-right-content [data-size-guide-trigger] {
                background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
                border-radius: 40px;
                padding: 0.6rem 1.3rem;
                font-size: 0.8rem;
                font-weight: 500;
                transition: all 0.25s;
                cursor: pointer;
                border: none;
            }

            #single-right-content [data-size-guide-trigger]:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
            }

            /* Size Buttons - Circular Design */
            #single-right-content .size-btn {
                width: 58px;
                height: 58px;
                border-radius: 100px;
                /* background: white; */
                border: 1.5px solid #ece2d8;
                transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #single-right-content .size-btn:hover {
                border-color: var(--secondary, #b8652e);
                transform: scale(1.05);
                background: #fffaf5;
            }

            #single-right-content .size-btn span {
                font-size: 1rem;
                font-weight: 700;
                color: #4a3728;
                transition: color 0.2s;
            }

            #single-right-content .size-btn:hover span {
                color: var(--secondary, #b8652e);
            }

            /* Active Size State - using Tailwind secondary */
            #single-right-content .size-btn.active-size,
            #single-right-content .size-btn[data-selected="true"] {
                background: var(--secondary, #b8652e);
                border-color: var(--secondary, #b8652e);
            }

            #single-right-content .size-btn.active-size span,
            #single-right-content .size-btn[data-selected="true"] span {
                color: white !important;
            }

            /* ========== COLOR SELECTION ========== */

            #single-right-content #color-selection {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            #single-right-content .color-btn {
                width: 44px;
                height: 44px;
                border-radius: 100px;
                transition: all 0.2s ease;
                cursor: pointer;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            }

            #single-right-content .color-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
            }

            /* Selected color border - using Tailwind secondary */
            #single-right-content .color-btn.border-secondary {
                box-shadow: 0 0 0 2px white, 0 0 0 4px var(--secondary, #b8652e);
            }

            /* ========== BEST OFFERS SECTION ========== */

            #single-right-content>div:has(.font-medium.mb-2) {
                /* background: linear-gradient(135deg, #fef9f2 0%, #fcf5ec 100%); */
                border-radius: 20px;
                padding: 1rem 1.25rem;
                margin: 1.25rem 0;
            }

            #single-right-content .font-medium.mb-2 {
                font-size: 0.95rem;
                font-weight: 700;
                color: #2c241c;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            #single-right-content .font-medium.mb-2::before {
                content: '🎁';
                font-size: 1rem;
            }

            #single-right-content .text-sm.text-gray-600 li {
                font-size: 0.8rem;
                color: #6b5a4a;
                margin-bottom: 0.5rem;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            /* #single-right-content .text-secondary {
            color: var(--secondary, #b8652e) !important;
        } */

            #single-right-content .text-secondary.cursor-pointer {
                font-weight: 500;
                text-decoration: underline;
                text-decoration-thickness: 1px;
                text-underline-offset: 3px;
                transition: color 0.2s;
            }

            #single-right-content .text-secondary.cursor-pointer:hover {
                color: #9a4d22 !important;
            }

            /* ========== ACTION BUTTONS SECTION ========== */

            #single-right-content #action-buttons-section {
                margin-top: 1.5rem;
                border-radius: 24px;
            }

            /* Add to Cart Button - using Tailwind secondary */
            #single-right-content #add-to-cart {
                /* background: linear-gradient(135deg, #2c241c 0%, #1f1812 100%); */
                border: none;
                border-radius: 60px;
                padding: 1rem;
                font-weight: 700;
                font-size: 1rem;
                transition: all 0.25s ease;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            #single-right-content #add-to-cart:hover {
                /* background: linear-gradient(135deg, var(--secondary, #b8652e) 0%, #9a4d22 100%); */
                transform: translateY(-2px);
                box-shadow: 0 10px 22px rgba(184, 101, 46, 0.3);
            }

            #single-right-content #add-to-cart i {
                margin-right: 8px;
            }

            /* Wishlist Button */
            #single-right-content #wishlist-btn {
                border-radius: 60px;
                width: 56px;
                height: 56px;
                /* background: white; */
                /* border: 1.5px solid #ece2d8; */
                transition: all 0.2s;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* #single-right-content #wishlist-btn:hover {
            border-color: #e06c4a;
            background: #fff8f5;
            transform: scale(1.02);
        }

        #single-right-content #wishlist-btn i {
            transition: color 0.2s;
            font-size: 1.3rem;
            color: #b8a28c;
        }

        #single-right-content #wishlist-btn:hover i {
            color: #e06c4a;
        } */

            /* WhatsApp Button */
            #single-right-content .bg-\[\\#25D366\] {
                background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
                border-radius: 60px;
                padding: 0.9rem;
                font-weight: 600;
                transition: all 0.25s;
                text-decoration: none;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            #single-right-content .bg-\[\\#25D366\]:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
                filter: brightness(1.02);
            }

            /* ========== RESPONSIVE ADJUSTMENTS ========== */

            @media (max-width: 900px) {
                #single-right-content [data-size-guide-trigger] {
                    background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
                    border-radius: 40px;
                    padding: 0.6rem 1.3rem;
                    font-size: 0.7rem;
                    font-weight: 500;
                    transition: all 0.25s;
                    cursor: pointer;
                    border: none;
                }

            }

            @media (max-width: 768px) {

                #single-right-content .text-h3-xs,
                #single-right-content .text-h3-sm {
                    font-size: 1.5rem;
                }

                #single-right-content #price-container .text-xl {
                    font-size: 1.5rem !important;
                }

                #single-right-content .size-btn {
                    width: 48px;
                    height: 48px;
                }

                #single-right-content .color-btn {
                    width: 38px;
                    height: 38px;
                }

                #single-right-content #add-to-cart {
                    padding: 0.85rem;
                    font-size: 0.9rem;
                }

                #single-right-content #wishlist-btn {
                    width: 52px;
                    height: 52px;
                }

                #single-right-content .type-btn,
                #single-right-content #custom-dimension-btn {
                    padding: 0.6rem 1.25rem;
                    font-size: 0.85rem;
                }
            }

            @media (max-width: 480px) {
                #single-right-content #custom-dimension-section .grid {
                    grid-template-columns: 1fr;
                }

                #single-right-content #size-selection-section {
                    padding: 1rem;
                }

                #single-right-content .size-btn {
                    width: 42px;
                    height: 42px;
                }

                #single-right-content .size-btn span {
                    font-size: 0.85rem;
                }
            }

            /* ========== ANIMATIONS & UTILITIES ========== */

            /* Smooth transitions for all interactive elements */
            #single-right-content button,
            #single-right-content a,
            #single-right-content .color-btn,
            #single-right-content .size-btn,
            #single-right-content .type-btn {
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Loading skeleton animation (for dynamic content) */
            @keyframes shimmer {
                0% {
                    background-position: -200% 0;
                }

                100% {
                    background-position: 200% 0;
                }
            }

            /* Custom scrollbar for the section */
            #single-right-content::-webkit-scrollbar {
                width: 4px;
            }

            #single-right-content::-webkit-scrollbar-track {
                background: #f0e8e0;
                border-radius: 10px;
            }

            #single-right-content::-webkit-scrollbar-thumb {
                background: var(--secondary, #b8652e);
                border-radius: 10px;
            }
        </style>

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

            /* Fix for mobile accordion */
            .accordion-content-block {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
            }

            .accordion-wrapper.active .accordion-content-block {
                max-height: 2000px;
                transition: max-height 0.5s ease-in;
            }

            .accordion-chevron {
                transition: transform 0.3s ease;
            }

            .accordion-wrapper.active .accordion-chevron {
                transform: rotate(90deg) !important;
            }
        </style>

        <!-- Share Modal -->
        <div id="shareModal" class="fixed inset-0 z-[20000000] hidden">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeShareModal()"></div>

            <!-- Modal Container -->
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div
                    class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-0 relative z-10 transform transition-all duration-300 scale-100 overflow-hidden">



                    <!-- Close button -->
                    <button onclick="closeShareModal()"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                        aria-label="Close modal">
                        <i class="fas fa-times text-lg"></i>
                    </button>

                    <!-- Modal Content -->
                    <div class="p-7 pt-5">

                        <!-- Header -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 tracking-tight">Share</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Send this product link to anyone</p>
                        </div>

                        <!-- Product Info -->
                        <div class="bg-gray-50/90 border border-gray-200/60 rounded-xl p-4 mb-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex-shrink-0 w-9 h-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-box text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">From AymanRoyale
                                    </p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- URL & Copy -->
                        <div class="flex items-center gap-2 p-2 bg-gray-50/70 border border-gray-200/60 rounded-lg mb-6">
                            <div class="flex-1 min-w-0 pl-2">
                                <input type="text" id="shareUrl" value="{{ url()->current() }}" readonly
                                    class="w-full bg-transparent text-sm text-gray-600 outline-none truncate font-mono">
                            </div>
                            <button onclick="copyToClipboard()"
                                class="flex-shrink-0 text-indigo-600 hover:text-indigo-800 text-sm font-medium px-4 py-1.5 rounded-lg hover:bg-indigo-50 transition-colors duration-200 flex items-center gap-1.5">
                                <i class="far fa-copy text-xs"></i>
                                Copy
                            </button>
                        </div>

                        <!-- Share Options -->
                        <div class="grid grid-cols-4 gap-3 mb-4">
                            <!-- Facebook -->
                            <button onclick="shareOnFacebook()"
                                class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-gray-50/80 transition-all duration-200 group">
                                <div
                                    class="w-11 h-11 rounded-full bg-[#1877F2] flex items-center justify-center text-white shadow-sm group-hover:shadow-md transition-shadow">
                                    <i class="fab fa-facebook-f text-base"></i>
                                </div>
                                <span
                                    class="text-[11px] font-medium text-gray-500 group-hover:text-gray-700">Facebook</span>
                            </button>

                            <!-- Twitter -->
                            <button onclick="shareOnTwitter()"
                                class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-gray-50/80 transition-all duration-200 group">
                                <div
                                    class="w-11 h-11 rounded-full bg-black flex items-center justify-center text-white shadow-sm group-hover:shadow-md transition-shadow">
                                    <i class="fa-brands fa-x-twitter text-base"></i>
                                </div>
                                <span class="text-[11px] font-medium text-gray-500 group-hover:text-gray-700">Twitter</span>
                            </button>

                            <!-- WhatsApp -->
                            <button onclick="shareOnSecondWhatsApp()"
                                class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-gray-50/80 transition-all duration-200 group">
                                <div
                                    class="w-11 h-11 rounded-full bg-[#25D366] flex items-center justify-center text-white shadow-sm group-hover:shadow-md transition-shadow">
                                    <i class="fab fa-whatsapp text-base"></i>
                                </div>
                                <span
                                    class="text-[11px] font-medium text-gray-500 group-hover:text-gray-700">WhatsApp</span>
                            </button>

                            <!-- Email -->
                            <button onclick="shareOnEmail()"
                                class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-gray-50/80 transition-all duration-200 group">
                                <div
                                    class="w-11 h-11 rounded-full bg-[#EA4335] flex items-center justify-center text-white shadow-sm group-hover:shadow-md transition-shadow">
                                    <i class="fas fa-envelope text-base"></i>
                                </div>
                                <span class="text-[11px] font-medium text-gray-500 group-hover:text-gray-700">Email</span>
                            </button>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-center gap-2 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-400">Shared with</span>
                            <i class="fas fa-heart text-rose-400 text-xs"></i>
                            <span class="text-xs text-gray-400">from</span>
                            <span class="text-xs font-medium text-indigo-600">AymanRoyale</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">

            @if ($product->variants->first() == true)

                <div class=" mx-auto max-w-[1400px]">
                    <div class="flex md:flex-nowrap flex-wrap gap-6">
                        <!-- LEFT IMAGE SECTION -->
                        <div class="flex flex-col lg:flex-row gap-2 min-w-[59%]">
                            <!-- Thumbnails Container -->
                            <div id="thumbnail-container"
                                class="flex xll:min-w-40 xll:max-w-40 min-w-24 lg:max-w-24 lg:py-0 py-2 items-center lg:overflow-visible overflow-auto lg:flex-col gap-4 order-2 lg:order-1 px-2">
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
                                        // Use the accessor directly - it will handle both local and Cloudinary URLs
                                        $fullImagePath = $image->image_url;
                                    @endphp
                                    <div class="thumbnail lg:h-[25%] h-full w-full overflow-hidden rounded-lg border-2 cursor-pointer {{ $index == 0 ? 'selected border-secondary' : 'border-transparent' }}"
                                        data-display="{{ $fullImagePath }}" data-large="{{ $fullImagePath }}"
                                        onclick="updateMainImage('{{ $fullImagePath }}', '{{ $product->name }}', this)">
                                        <img src="{{ $fullImagePath }}"
                                            class="w-full h-full object-cover object-center object-top"
                                            alt="{{ $product->name }}" />
                                    </div>
                                @empty
                                    <div class="thumbnail lg:h-[25%] h-full w-full overflow-hidden rounded-lg border-2 border-secondary cursor-pointer selected"
                                        data-display="{{ asset('assets/images/placeholder.jpg') }}"
                                        data-large="{{ asset('assets/images/placeholder.jpg') }}"
                                        onclick="updateMainImage('{{ asset('assets/images/placeholder.jpg') }}', '{{ $product->name }}', this)">
                                        <img src="{{ asset('assets/images/placeholder.jpg') }}"
                                            class="w-full h-full object-cover object-center object-top"
                                            alt="{{ $product->name ?? 'Product' }}" />
                                    </div>
                                @endforelse
                            </div>

                            <!-- Main Image with Hover Pan Zoom -->
                            {{--
                <div id="get-zoom-container" class="zoom-container w-auto max-h-[1044px] relative group order-1 lg:order-2  aspect-[9/13] h-fit">
                    @php
                    $firstImage = $variantImages->first();
                    $mainImagePath = $firstImage ? ltrim($firstImage->image, '/') : 'assets/images/placeholder.jpg';
                    @endphp
                    <img src="{{ asset($mainImagePath) }}"
                        class="w-full h-full object-contain object-center object-top"
                        alt="{{ $product->name ?? 'Product' }}"
                        id="main-image" />
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur rounded-full p-3 shadow-lg opacity-0 transition-opacity fullscreen-btn">
                        <button id="fullscreen-btn" class="text-gray-800 hover:text-blue-700">
                            <i class="fas fa-expand text-xl"></i>
                        </button>
                    </div>
                </div>
                --}}
                            <div id="get-zoom-container"
                                class="zoom-container w-auto max-h-[1044px] relative group order-1 lg:order-2 aspect-[9/13] h-fit">
                                @php
                                    $firstImage = $variantImages->first();
                                    // Use the accessor - it handles both local and Cloudinary URLs
                                    $mainImagePath = $firstImage
                                        ? $firstImage->image_url
                                        : asset('assets/images/placeholder.jpg');
                                @endphp
                                <img src="{{ $mainImagePath }}"
                                    class="w-full h-full object-contain object-center object-top"
                                    alt="{{ $product->name ?? 'Product' }}" id="main-image" />
                                <div
                                    class="absolute bottom-4 right-4 bg-white/90 backdrop-blur rounded-full p-3 shadow-lg opacity-0 transition-opacity fullscreen-btn">
                                    <button id="fullscreen-btn" class="text-gray-800 hover:text-blue-700">
                                        <i class="fas fa-expand text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT CONTENT -->
                        <div id="single-right-content" class="space-y-2 w-full md:max-w-[50%] sm:min-w-[270px]">
                            <div class="relative pr-12">

    <!-- Product Information -->
    <div class="space-y-2">
        <!-- Product Name -->
        <h1
            class="text-h3-xs sm:text-h3-sm md:text-h3-md lg:text-h3-lg lgg:text-h3-lgg font-semibold leading-tight text-gray-900">
            {{ $product->name }}
        </h1>

        <!-- Brand -->
        <div class="flex items-center gap-2 text-sm">
            <span class="font-medium text-gray-900">
                {{ $product->brand ?? 'Aiman Royale' }}
            </span>

            <span class="w-1 h-1 rounded-full bg-gray-300"></span>

            <span class="text-gray-500">
                Premium Collection
            </span>
        </div>

        <!-- Manufacturer -->
        <p class="text-sm text-gray-500">
            Manufactured & Packed by
            <span class="font-medium text-gray-700">Aiman Royale</span>
        </p>
    </div>

    <!-- Share Button -->
    <button
        type="button"
        onclick="openShareModal()"
        aria-label="Share Product"
        class="group absolute top-0 right-0 flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:border-primary hover:bg-primary hover:shadow-lg">

        <svg xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 22 20"
            fill="none"
            class="transition-colors duration-300">

            <path
                d="M12.6053 12.3608C6.28947 11.9245 2.90351 16.5426 1.5 18.9062C2.34211 8.87003 8.74561 5.9063 12.6053 5.17896V1.9945C12.6053 1.56713 13.1067 1.33675 13.431 1.61513L20.6463 7.80961C21.1006 8.19968 21.1117 8.89973 20.671 9.30514L13.4446 15.9523C13.1241 16.2471 12.6053 16.0205 12.6053 15.5851V12.3608Z"
                stroke="currentColor"
                stroke-width="1.4"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="text-gray-600 group-hover:text-white" />
        </svg>
    </button>

</div>

                            <div class="flex items-center gap-2">
                                <div class="flex text-yellow-400 text-sm">
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if ($hasHalfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">{{ $averageRating }} · {{ $reviewCount }}
                                    {{ $reviewCount == 1 ? 'Review' : 'Reviews' }}</span>
                            </div>

                            <div class="flex items-center gap-3 flex-wrap bg-secondary/5 border-secondary/25 border-[1px]"
                                id="price-container">
                                @php
                                    $firstVariant = $product->variants->first();
                                    $currentPrice = $firstVariant->discount_price ?? $firstVariant->price;
                                    $originalPrice = $firstVariant->price;
                                    $discount = $firstVariant->discount;
                                @endphp
                                <span class="text-xl  text-gray-900">Rs. {{ $currentPrice }}</span>
                                @if ($originalPrice != $currentPrice)
                                    <span class="line-through text-gray-400">Rs. {{ $originalPrice }}</span>
                                @endif
                                @if ($discount > 0)
                                    <span
                                        class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">({{ $discount }}%
                                        off)</span>
                                @else
                                    <span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">Trending</span>
                                @endif
                            </div>

                            <!-- Type Selection -->
                            <div>
                                <h3 class="font-medium mb-3 text-gray-800">Select Type</h3>
                                <div class="flex gap-3 flex-wrap ">
                                    <button
                                        class="type-btn px-6 py-3 rounded-lg border-[1px] border-secondary/25 bg-secondary/10 text-secondary transition-all"
                                        data-type="stitched">
                                        Stitched
                                    </button>
                                    <button id="custom-dimension-btn"
                                        class="px-6 py-3 rounded-lg border-2 border-dashed border-gray-400 text-gray-600 hover:border-secondary hover:text-secondary transition-all flex items-center justify-center gap-2">
                                        <i class="fas fa-ruler-combined"></i> Custom Dimension
                                    </button>
                                </div>
                            </div>

                            <!-- Custom Dimension Input Section (Hidden by Default) -->
                            <div id="custom-dimension-section"
                                class="hidden space-y-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <h3 class="font-medium text-gray-800">Enter Custom Dimensions</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bust (in cm)</label>
                                        <input type="number" id="custom-bust"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                            placeholder="Enter bust" min="1" step="0.1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Waist (in cm)</label>
                                        <input type="number" id="custom-waist"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                            placeholder="Enter waist" min="1" step="0.1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Hip (in cm)</label>
                                        <input type="number" id="custom-hip"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                            placeholder="Enter hip" min="1" step="0.1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Armhole (in cm)</label>
                                        <input type="number" id="custom-armhole"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                            placeholder="Enter Armhole" min="1" step="0.1">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Color</label>
                                    <div class="flex gap-3" id="custom-color-selection">
                                        <div class="flex flex-wrap gap-2">
                                            @if (isset($colors) && $colors->count() > 0)
                                                @foreach ($colors as $color)
                                                 
                                                <button
                                                        class="custom-color-btn w-8 h-8 rounded-full border-2 border-gray-300 hover:scale-110 transition-all"
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
                                    <button id="save-dimension-btn"
                                        class="px-6 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/80 transition-colors">Save
                                        Dimensions</button>
                                    <button id="cancel-custom-btn"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">Cancel</button>
                                </div>
                            </div>

                            <!-- Size Selection -->
                            <!-- Size Selection -->
<div id="size-selection-section" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
        <div class="w-fit">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-expand-alt text-secondary"></i> Select Size
            </h3>
            <p class="text-sm text-primary/80 mt-1">Choose your perfect fit</p>
        </div>
        <button type="button" data-size-guide-trigger
            class="px-4 min-w-[155px] py-2.5 bg-gradient-to-r from-gray-900 to-gray-800 justify-center text-white rounded-xl hover:from-gray-800 hover:to-gray-700 transition-all shadow hover:shadow-md flex items-center gap-2 w-fit">
            <i class="fas fa-ruler-combined"></i> View Size Guide
        </button>
    </div>

    <div class="flex gap-3 flex-wrap" id="size-buttons">
        @php
            // Get unique sizes from variants that exist in the sizes table
            $productSizeCodes = $product->variants->pluck('size')->unique()->filter()->toArray();
            // Filter sizes to only those that have variants
            $availableSizes = $sizes->filter(function($size) use ($productSizeCodes) {
                return in_array($size->code, $productSizeCodes);
            });
        @endphp
        @foreach($availableSizes as $size)
            <button
                class="size-btn relative w-14 h-14 rounded-full border-2 border-gray-200 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 group"
                data-size="{{ $size->code }}"
                data-size-id="{{ $size->id }}">
                <span class="text-lg font-semibold text-gray-800 group-hover:text-secondary">{{ $size->code }}</span>
            </button>
        @endforeach
    </div>
</div>

                            <!-- Color Selection -->
                            <div id="color-selection-section">
                                <h3 class="font-medium mb-3 text-gray-800">Select Color</h3>
                                <div class="flex gap-3 flex-wrap" id="color-selection">
                                    @php
                                        // // Get first variant
                                        $firstVariant = $product->variants->first();
                                        // // dd($firstVariant);
                                        // // Default selected color
                                        $selectedColor = $firstVariant->color ?? '';

                                        // Get all unique colors
                                        $colorsForSize = $product->variants->unique('color')->values();
                                        // dd($colorsForSize->count());
                                    @endphp
                                    {{-- @dd($product->variants->pluck('color')); --}}
                                    {{-- @php
                                        dd($colorsForSize);
                                    @endphp --}}
                                    @forelse($colorsForSize as $index => $variant)
                                        @php
                                            $isSelected = $index == 0;
                                            // $sizeCode = $variant->size ?? '';
                                            // Get variant image with proper path using the accessor
                                            $variantImage = '';
                                            if ($variant->images && $variant->images->isNotEmpty()) {
                                                $firstImage = $variant->images->first();
                                                $variantImage = $firstImage->image_url; // Use accessor
                                            } elseif ($variant->image) {
                                                // If variant has direct image property, check if it's a URL
    $imagePath = trim($variant->image);
    $variantImage = filter_var($imagePath, FILTER_VALIDATE_URL)
        ? $imagePath
        : asset(ltrim($imagePath, '/'));
} else {
    $variantImage = asset('assets/images/placeholder.jpg');
                                            }
                                        @endphp
                                        <button
                                            class="color-btn w-10 h-10 rounded-full border-2 {{ $isSelected ? 'border-secondary' : 'border-gray-300' }} transition-all hover:scale-110"
                                            style="background-color: {{ $variant->color_code ?? ($variant->color ?? '#CCCCCC') }};"
                                            data-color="{{ $variant->color }}"
                                            data-color-code="{{ $variant->color_code }}"
                                            data-size="{{ $variant->size }}" data-variant-id="{{ $variant->id }}"
                                            data-variant-image="{{ $variantImage }}" title="{{ $variant->color }}">
                                        </button>
                                    @empty
                                        <p class="text-gray-500 text-sm">No colors available for this size</p>
                                    @endforelse

                                </div>
                            </div>
                            {{-- @dd({{ $colorsForSize->count() }}) --}}
                            <!-- Best Offers Section -->
                            <div class="bg-secondary/5">
                                <h3 class="font-medium mb-2">Best Offers</h3>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Special offer get 25% off <span class="text-secondary cursor-pointer">T&C</span>
                                    </li>
                                    <li>• Bank offer get 30% off on Axis Bank Credit Card <span
                                            class="text-secondary cursor-pointer">T&C</span></li>
                                    <li>• Wallet offer get 40% cashback via Paytm <span
                                            class="text-secondary cursor-pointer">T&C</span></li>
                                </ul>
                            </div>

                            <!-- Action Buttons -->
                            <div id="action-buttons-section"
                                class="flex flex-col gap-3 pt-4 md:relative fixed md:bottom-auto md:left-auto md:z-0 md:bg-transparent md:backdrop-blur-none lgg:px-0 md:pb-0 bottom-0 left-0 w-full z-[1000] bg-white/32 p-4 backdrop-blur-[23px]"
                                data-product-variants="{{ json_encode($product->variants) }}">

                                <!-- Coupon Toggle Button -->
                                {{-- <button id="coupon-toggle-btn" class="text-secondary hover:text-secondary/80 font-medium text-sm flex items-center justify-center gap-2 transition w-full">
        <i class="fas fa-ticket-alt"></i>
        <span>Have a coupon? Click here</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="coupon-arrow"></i>
    </button> --}}

                                <!-- Coupon Input Block (Hidden by default) -->
                                {{-- <div id="coupon-block" class="hidden bg-gray-50 rounded-lg p-3 border border-gray-200 transition-all duration-300">
        <div class="flex gap-2 flex-col xxs:flex-row">
            <input type="text" 
                   id="coupon-input" 
                   placeholder="Enter coupon code" 
                   class="flex-1 px-3 py-2 border w-full border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm">
            <button id="apply-coupon-btn" 
                    class="bg-secondary min-w-[100px] text-white px-4 py-2 rounded-lg hover:bg-secondary/80 transition text-sm font-medium whitespace-nowrap">
                Apply
            </button>
        </div>
        <div id="coupon-message" class="text-sm mt-2 hidden"></div>
    </div> --}}

                                <div class="flex items-center gap-4">
                                    <button id="add-to-cart" data-variant-id="{{ $product->variants->first()->id }}"
                                        class="bg-secondary text-white lgg:px-8 px-4 py-4 rounded-lg hover:bg-secondary/80 font-medium flex-1 text-lg transition">
                                        <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                    </button>
                                    <button id="wishlist-btn"
                                        class="w-14 h-14 rounded-lg border-2 flex items-center justify-center text-2xl hover:border-red-500 transition border-gray-300">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>

                                <!-- WhatsApp Share Button -->
                                <a href="https://wa.me/91{{ config('app.wh_number') }}?text={{ urlencode('Hello! I am interested in this product: ' . $product->name . ' - ' . route('page.single-product', $product->slug) . ' Price: ₹' . $product->variants->first()->price) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="bg-[#25D366] text-white px-4 py-3 rounded-lg hover:bg-[#128C7E] font-medium flex items-center justify-center gap-2 transition w-full text-decoration-none">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                    <span>Order on WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class=" mx-auto max-w-[1400px]">
                    <div class="w-full text-center mb-6">
                        <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
                    </div>
                </div>
            @endif
        </section>

        <!-- Fullscreen Modal -->
        <div class="fixed inset-0 bg-black/95 hidden items-center justify-center z-[40000]" id="zoom-modal">
            <button class="absolute top-8 right-8 text-white text-4xl hover:text-gray-300 z-10" id="close-zoom">
                <i class="fas fa-times"></i>
            </button>
            <div class="max-w-6xl max-h-full p-8">
                <img src="" id="zoom-modal-image" alt="Zoomed Image"
                    class="max-w-full max-h-full object-contain" />
            </div>
        </div>

        <!-- Product Details and Specifications Section -->
      <section class="px-4 lgg:py-12 py-6">
   <div class="container mx-auto">
      <!-- DESKTOP TABS -->
      <div class="hidden md:block">
         <div class="flex gap-10 border-b text-p-lg xl:text-p-xl 2xl:text-p-2xl">
            <button class="tab-btn border-b-2 border-black pb-2 text-black font-sans" data-tab="details">Product
            Details</button>
            <button class="tab-btn border-b-2 border-transparent pb-2 text-gray-500 font-sans"
               data-tab="specification">Specification</button>
            <button class="tab-btn border-b-2 border-transparent pb-2 text-gray-500 font-sans"
               data-tab="reviews">Ratings & Reviews</button>
         </div>
         <!-- Tab Content Container -->
         <div class="mt-6 relative min-h-[300px]">
            <!-- Product Details Tab -->
            <div class="tab-content active" id="details">
               <h3
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-2 font-sans">
                  Product Details
               </h3>
               <p
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                  {{ $product->description ?? 'No description available.' }}
               </p>
               @if ($product->fabric)
               <h3
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1 font-sans">
                  Material & Care
               </h3>
               <p
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                  {{ $product->material_care }}
               </p>
               @endif
               @if ($product->fit)
               <h3
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1 font-sans">
                  Size & Fit
               </h3>
               <p
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                  {{ $product->fit }}
               </p>
               @endif
               <!-- Product Parts with Fabric and Stitching Type -->
               {{--
               @if ($product->parts && $product->parts->count() > 0)
               <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-2 font-sans">Product Parts</h3>
               <div class="space-y-3">
                  @foreach ($product->parts as $part)
                  <div class="border-l-4 border-gray-300 pl-4 py-2">
                     <h4 class="font-medium text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl mb-2 text-gray-900 font-sans">
                        {{ $part->part_name }}
                     </h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-sans">
                        @if ($part->fabric)
                        <div class="flex flex-col">
                           <span class="text-gray-500 text-xs font-sans">Fabric</span>
                           <span class="text-gray-900 font-sans">{{ $part->fabric }}</span>
                        </div>
                        @endif
                        @if ($part->work_type)
                        <div class="flex flex-col">
                           <span class="text-gray-500 text-xs font-sans">Work Type</span>
                           <span class="text-gray-900 font-sans">{{ $part->work_type }}</span>
                        </div>
                        @endif
                     </div>
                  </div>
                  @endforeach
               </div>
               @endif
               --}}
               <div class="mt-4 p-3 border rounded-lg bg-gray-50">
                  <h4 class="font-semibold text-lg mb-2 font-sans" style="color: #333;">Additional Information</h4>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     @if ($product->type)
                     <div class="flex flex-col">
                        <span class="text-sm text-gray-500 font-sans">Type</span>
                        <span class="text-base font-medium text-gray-900 font-sans">{{ $product->type }}</span>
                     </div>
                     @endif
                     @if ($product->color)
                     <div class="flex flex-col">
                        <span class="text-sm text-gray-500 font-sans">Color</span>
                        <span class="text-base font-medium text-gray-900 font-sans">{{ $product->color }}</span>
                     </div>
                     @endif
                     @if ($product->fit)
                     <div class="flex flex-col">
                        <span class="text-sm text-gray-500 font-sans">Fit</span>
                        <span class="text-base font-medium text-gray-900 font-sans">{{ $product->fit }}</span>
                     </div>
                     @endif
                     @if ($product->fabric && !$product->parts)
                     <div class="flex flex-col">
                        <span class="text-sm text-gray-500 font-sans">Fabric</span>
                        <span
                           class="text-base font-medium text-gray-900 font-sans">{{ $product->fabric }}</span>
                     </div>
                     @endif
                     @if ($product->sales_package)
                     <div class="flex flex-col">
                        <span class="text-sm text-gray-500 font-sans">Package Contains</span>
                        <span
                           class="text-base font-medium text-gray-900 font-sans">{{ $product->sales_package }}</span>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
            <!-- Specification Tab -->
            <div class="tab-content hidden" id="specification">
               <h3
                  class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mb-4 font-sans">
                  Product Specifications
               </h3>
               <div class="css-175oi2r"
                  style="flex-flow: wrap; flex: 1 1 0%; padding: 16px 32px 16px 16px; margin-right: -24px;">
                  <!-- Stitching Type -->
                  @if ($product->stitching_type)
                  <div class="mb-4 p-3 border rounded-lg bg-gray-50">
                     <h4 class="font-semibold text-lg mb-2 font-sans" style="color: #333;">Stitching Information
                     </h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Stitching Type</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ ucfirst($product->stitching_type) }}</span>
                        </div>
                     </div>
                  </div>
                  @endif
                  <!-- Display Product Parts -->
                  @if ($product->parts && $product->parts->count() > 0)
                  @foreach ($product->parts as $part)
                  <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                     <h4 class="font-semibold text-lg mb-3 font-sans"
                        style="color: #333; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">
                        {{ $part->part_name }}
                     </h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($part->fabric)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Fabric</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->fabric }}</span>
                        </div>
                        @endif
                        @if ($part->work_type)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Work Type</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->work_type }}</span>
                        </div>
                        @endif
                        @if ($part->color)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Color</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->color }}</span>
                        </div>
                        @endif
                        @if ($part->pattern)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Pattern</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->pattern }}</span>
                        </div>
                        @endif
                        @if ($part->embroidery)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Embroidery</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->embroidery }}</span>
                        </div>
                        @endif
                        @if ($part->lining)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Lining</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $part->lining }}</span>
                        </div>
                        @endif
                        @if ($part->description)
                        <div class="flex flex-col md:col-span-2">
                           <span class="text-sm text-gray-500 font-sans">Details</span>
                           <span
                              class="text-base text-gray-900 font-sans">{{ $part->description }}</span>
                        </div>
                        @endif
                     </div>
                  </div>
                  @endforeach
                  @endif
                  <!-- Common Specifications -->
                  {{--
                  <div class="mt-4 p-3 border rounded-lg bg-gray-50">
                     <h4 class="font-semibold text-lg mb-2 font-sans" style="color: #333;">Additional Information</h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($product->type)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Type</span>
                           <span class="text-base font-medium text-gray-900 font-sans">{{ $product->type }}</span>
                        </div>
                        @endif
                        @if ($product->color)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Color</span>
                           <span class="text-base font-medium text-gray-900 font-sans">{{ $product->color }}</span>
                        </div>
                        @endif
                        @if ($product->fit)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Fit</span>
                           <span class="text-base font-medium text-gray-900 font-sans">{{ $product->fit }}</span>
                        </div>
                        @endif
                        @if ($product->fabric && !$product->parts)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Fabric</span>
                           <span class="text-base font-medium text-gray-900 font-sans">{{ $product->fabric }}</span>
                        </div>
                        @endif
                        @if ($product->sales_package)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Package Contains</span>
                           <span class="text-base font-medium text-gray-900 font-sans">{{ $product->sales_package }}</span>
                        </div>
                        @endif
                     </div>
                  </div>
                  --}}
               </div>
            </div>
            <!-- Reviews Tab -->
            <div class="tab-content hidden" id="reviews">
               <div class="p-6 lg:p-8">
                  <!-- Header with rating summary row -->
                  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-8">
                     <div>
                        <h3 class="text-2xl font-bold text-gray-900 tracking-tight font-sans">Ratings & Reviews</h3>
                        <p class="text-gray-500 mt-1 text-sm font-sans">What our customers are saying</p>
                     </div>
                     <!-- Overall rating badge with stars -->
                     <div
                        class="flex items-center gap-4 bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100">
                        <div class="text-center">
                           <span id="average-rating"
                              class="text-4xl font-extrabold text-gray-900 font-sans">0.0</span>
                           <span class="text-gray-500 text-sm font-sans">/5</span>
                           <div id="average-stars"
                              class="flex items-center justify-center mt-1 star-rating">
                              <!-- Stars will be generated dynamically -->
                           </div>
                        </div>
                        <div class="border-l border-gray-300 pl-4">
                           <div class="text-sm text-gray-600 font-sans"><span id="total-reviews"
                              class="font-semibold text-gray-900 font-sans">0</span> verified reviews</div>
                           <div id="verified-percentage" class="text-xs text-green-600 mt-0.5 font-sans"><i
                              class="fas fa-check-circle mr-1"></i> 0% recommend</div>
                        </div>
                     </div>
                  </div>
                  <!-- Rating breakdown bars (visual summary) -->
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                     <div id="rating-breakdown" class="space-y-3">
                        <!-- Rating bars will be generated dynamically -->
                        <div class="flex items-center gap-2 text-sm font-sans">
                           <span class="w-12 text-gray-600 font-medium font-sans">5 ★</span>
                           <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                              <div class="bg-yellow-400 h-full rounded-full" data-rating="5"
                                 style="width: 0%"></div>
                           </div>
                           <span class="w-8 text-gray-500 text-xs percentage-5 font-sans">0%</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-sans">
                           <span class="w-12 text-gray-600 font-medium font-sans">4 ★</span>
                           <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                              <div class="bg-yellow-400 h-full rounded-full" data-rating="4"
                                 style="width: 0%"></div>
                           </div>
                           <span class="w-8 text-gray-500 text-xs percentage-4 font-sans">0%</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-sans">
                           <span class="w-12 text-gray-600 font-medium font-sans">3 ★</span>
                           <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                              <div class="bg-yellow-400 h-full rounded-full" data-rating="3"
                                 style="width: 0%"></div>
                           </div>
                           <span class="w-8 text-gray-500 text-xs percentage-3 font-sans">0%</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-sans">
                           <span class="w-12 text-gray-600 font-medium font-sans">2 ★</span>
                           <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                              <div class="bg-gray-300 h-full rounded-full" data-rating="2"
                                 style="width: 0%"></div>
                           </div>
                           <span class="w-8 text-gray-500 text-xs percentage-2 font-sans">0%</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-sans">
                           <span class="w-12 text-gray-600 font-medium font-sans">1 ★</span>
                           <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                              <div class="bg-gray-300 h-full rounded-full" data-rating="1"
                                 style="width: 0%"></div>
                           </div>
                           <span class="w-8 text-gray-500 text-xs percentage-1 font-sans">0%</span>
                        </div>
                     </div>
                     <div class="flex items-center justify-center lg:justify-end">
                        <div
                           class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-4 text-center w-full max-w-[220px] border border-indigo-100">
                           <i class="fas fa-medal text-indigo-500 text-2xl mb-1"></i>
                           <p class="text-xs font-medium text-indigo-700 font-sans">Top-rated product</p>
                           <p class="text-xs text-gray-600 mt-1 font-sans">⭐ Featured in "Customer Favorites"</p>
                        </div>
                     </div>
                  </div>
                  <!-- Reviews list header with sorting mock -->
                  <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-5">
                     <h4 class="font-semibold text-gray-800 text-lg font-sans">Customer reviews</h4>
                     <div
                        class="flex items-center gap-1 text-sm text-gray-500 cursor-pointer hover:text-gray-700 font-sans">
                        <span>Most relevant</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                     </div>
                  </div>
                  <!-- Dynamic reviews list (beautiful cards) -->
                  <div id="reviews-list" class="space-y-5 reviews-list max-h-[500px] overflow-y-auto pr-1">
                     <!-- Loading state -->
                     <div class="text-center py-12">
                        <div
                           class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-dark">
                        </div>
                        <p class="text-gray-500 mt-3 font-sans">Loading reviews...</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- MOBILE ACCORDION - FIXED VERSION -->
      <div class="md:hidden border-t border-b">
         <div class="accordion-wrapper border-b">
            <div class="flex justify-between items-center py-4 cursor-pointer">
               <span class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-medium font-sans">Product
               Details</span>
               <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px]"
                  src="{{ asset('images/icons/up-arrow.png') }}" alt="Toggle" />
            </div>
            <div class="accordion-content-block">
               <div class="pb-4">
                  <p
                     class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                     {{ $product->description ?? 'No description available.' }}
                  </p>
                  @if ($product->fabric)
                  <h3
                     class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1 font-sans">
                     Material & Care
                  </h3>
                  <p
                     class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                     {{ $product->fabric }}<br />{{ $product->material_care }}
                  </p>
                  @endif
                  @if ($product->fit)
                  <h3
                     class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-1 font-sans">
                     Size & Fit
                  </h3>
                  <p
                     class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl text-gray-700 font-sans">
                     {{ $product->fit }}
                  </p>
                  @endif
                  <!-- Product Parts with Fabric and Stitching Type -->
                  {{--
                  @if ($product->parts && $product->parts->count() > 0)
                  <h3 class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-semibold mt-4 mb-2 font-sans">Product Parts</h3>
                  <div class="space-y-3">
                     @foreach ($product->parts as $part)
                     <div class="border-l-4 border-gray-300 pl-4 py-2">
                        <h4 class="font-medium text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl mb-2 text-gray-900 font-sans">
                           {{ $part->part_name }}
                        </h4>
                        <div class="grid grid-cols-1 gap-2 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-sans">
                           @if ($part->fabric)
                           <div class="flex flex-col">
                              <span class="text-gray-500 text-xs font-sans">Fabric</span>
                              <span class="text-gray-900 font-sans">{{ $part->fabric }}</span>
                           </div>
                           @endif
                           @if ($part->work_type)
                           <div class="flex flex-col">
                              <span class="text-gray-500 text-xs font-sans">Work Type</span>
                              <span class="text-gray-900 font-sans">{{ $part->work_type }}</span>
                           </div>
                           @endif
                        </div>
                     </div>
                     @endforeach
                  </div>
                  @endif
                  --}}
                  <div class="mt-4 p-3 border rounded-lg bg-gray-50">
                     <h4 class="font-semibold text-lg mb-2 font-sans" style="color: #333;">Additional Information
                     </h4>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($product->type)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Type</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $product->type }}</span>
                        </div>
                        @endif
                        @if ($product->color)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Color</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $product->color }}</span>
                        </div>
                        @endif
                        @if ($product->fit)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Fit</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $product->fit }}</span>
                        </div>
                        @endif
                        @if ($product->fabric && !$product->parts)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Fabric</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $product->fabric }}</span>
                        </div>
                        @endif
                        @if ($product->sales_package)
                        <div class="flex flex-col">
                           <span class="text-sm text-gray-500 font-sans">Package Contains</span>
                           <span
                              class="text-base font-medium text-gray-900 font-sans">{{ $product->sales_package }}</span>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="accordion-wrapper border-b">
            <div class="flex justify-between items-center py-4 cursor-pointer">
               <span
                  class="text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl font-medium font-sans">Specification</span>
               <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px]"
                  src="{{ asset('images/icons/up-arrow.png') }}" alt="Toggle" />
            </div>
            <div class="accordion-content-block">
               <div class="pb-4">
                  @if ($product->stitching_type)
                  <div class="mb-4 p-3 border rounded bg-gray-50">
                     <h5 class="font-semibold mb-2 font-sans">Stitching Information</h5>
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Stitching Type:</span>
                        <span class="font-medium font-sans">{{ ucfirst($product->stitching_type) }}</span>
                     </div>
                  </div>
                  @endif
                  @if ($product->parts && $product->parts->count() > 0)
                  @foreach ($product->parts as $part)
                  <div class="mb-4 p-3 border rounded bg-gray-50">
                     <h5 class="font-semibold mb-2 font-sans">{{ $part->part_name }}</h5>
                     @if ($part->fabric)
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Fabric:</span>
                        <span class="font-medium font-sans">{{ $part->fabric }}</span>
                     </div>
                     @endif
                     @if ($part->work_type)
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Work Type:</span>
                        <span class="font-medium font-sans">{{ $part->work_type }}</span>
                     </div>
                     @endif
                     @if ($part->color)
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Color:</span>
                        <span class="font-medium font-sans">{{ $part->color }}</span>
                     </div>
                     @endif
                     @if ($part->pattern)
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Pattern:</span>
                        <span class="font-medium font-sans">{{ $part->pattern }}</span>
                     </div>
                     @endif
                     @if ($part->embroidery)
                     <div class="flex justify-between py-1 font-sans">
                        <span class="text-gray-500 font-sans">Embroidery:</span>
                        <span class="font-medium font-sans">{{ $part->embroidery }}</span>
                     </div>
                     @endif
                  </div>
                  @endforeach
                  @else
                  <p class="text-gray-700 font-sans">Specification details will appear here.</p>
                  @endif
               </div>
            </div>
         </div>
         <div class="accordion-wrapper">
            <div class="flex justify-between items-center py-4 cursor-pointer group">
               <div class="flex flex-col">
                  <span class="text-lg font-semibold text-gray-900 font-sans">Ratings & Reviews</span>
                  <div class="flex items-center gap-2 mt-1">
                     <div class="star-rating flex gap-0.5">
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                     </div>
                     <span class="text-xs text-gray-500 font-medium font-sans">{{ $averageRating }} ·
                     {{ $reviewCount }} {{ $reviewCount == 1 ? 'Review' : 'Reviews' }}</span>
                  </div>
               </div>
               <img class="accordion-chevron min-w-[23px] min-h-[23px] w-[23px] h-[23px]"
                  src="{{ asset('images/icons/up-arrow.png') }}" alt="Toggle" />
            </div>
            <div class="accordion-content-block">
               <div class="pb-4 space-y-6">
                  <!-- Compact rating summary card for mobile -->
                  <div
                     class="bg-gray-50 rounded-2xl p-4 flex items-center justify-between border border-gray-100">
                     <div>
                        <div class="text-3xl font-bold text-gray-900 font-sans">{{ $averageRating }}</div>
                        <div class="star-rating text-xs mt-1">
                           @for ($i = 0; $i < $fullStars; $i++)
                           <i class="fas fa-star text-yellow-400"></i>
                           @endfor
                           @if ($hasHalfStar)
                           <i class="fas fa-star-half-alt text-yellow-400"></i>
                           @endif
                           @for ($i = 0; $i < $emptyStars; $i++)
                           <i class="far fa-star text-yellow-400"></i>
                           @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-1 font-sans">Based on {{ $reviewCount }} reviews</p>
                     </div>
                     <div class="text-right">
                        <div class="text-xs text-green-700 bg-green-50 px-3 py-1 rounded-full font-sans"><i
                           class="fas fa-check-circle mr-1"></i>
                           {{ $reviewCount > 0 ? round(($averageRating / 5) * 100) : 0 }}% recommend
                        </div>
                     </div>
                  </div>
                  <!-- Rating breakdown bars (mobile friendly) -->
                  <div class="space-y-2">
                     @php
                     $fiveStarCount = $reviews->where('rating', 5)->count();
                     $fourStarCount = $reviews->where('rating', 4)->count();
                     $threeStarCount = $reviews->where('rating', 3)->count();
                     $fivePercent =
                     $reviewCount > 0 ? round(($fiveStarCount / $reviewCount) * 100) : 0;
                     $fourPercent =
                     $reviewCount > 0 ? round(($fourStarCount / $reviewCount) * 100) : 0;
                     $threePercent =
                     $reviewCount > 0 ? round(($threeStarCount / $reviewCount) * 100) : 0;
                     @endphp
                     <div class="flex items-center gap-2 text-xs font-sans">
                        <span class="w-8 font-sans">5★</span>
                        <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                           <div class="bg-yellow-400 h-full rounded-full"
                              style="width: {{ $fivePercent }}%"></div>
                        </div>
                        <span class="text-gray-500 w-8 font-sans">{{ $fivePercent }}%</span>
                     </div>
                     <div class="flex items-center gap-2 text-xs font-sans">
                        <span class="w-8 font-sans">4★</span>
                        <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                           <div class="bg-yellow-400 h-full rounded-full"
                              style="width: {{ $fourPercent }}%"></div>
                        </div>
                        <span class="text-gray-500 w-8 font-sans">{{ $fourPercent }}%</span>
                     </div>
                     <div class="flex items-center gap-2 text-xs font-sans">
                        <span class="w-8 font-sans">3★</span>
                        <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                           <div class="bg-yellow-400 h-full rounded-full"
                              style="width: {{ $threePercent }}%"></div>
                        </div>
                        <span class="text-gray-500 w-8 font-sans">{{ $threePercent }}%</span>
                     </div>
                  </div>
                  <!-- Reviews list for mobile (clean card design) -->
                  <div class="space-y-4 max-h-[420px] overflow-y-auto">
                     @forelse($reviews->take(4) as $review)
                     <div class="border-b border-gray-100 pb-4 last:border-0">
                        <div class="flex justify-between items-center">
                           <div class="flex items-center gap-2">
                              <div
                                 class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold font-sans">
                                 {{ strtoupper(substr($review->name ?? 'U', 0, 2)) }}
                              </div>
                              <span
                                 class="font-semibold text-sm font-sans">{{ $review->name ?? 'Anonymous User' }}</span>
                           </div>
                           <div class="star-rating text-[10px]">
                              @for ($i = 0; $i < floor($review->rating); $i++)
                              <i class="fas fa-star text-yellow-400"></i>
                              @endfor
                              @if ($review->rating - floor($review->rating) >= 0.5)
                              <i class="fas fa-star-half-alt text-yellow-400"></i>
                              @endif
                              @for ($i = 0; $i < 5 - ceil($review->rating); $i++)
                              <i class="far fa-star text-gray-300"></i>
                              @endfor
                           </div>
                        </div>
                        <p class="text-gray-600 text-xs mt-2 leading-relaxed font-sans">
                           {{ $review->review ?? 'No review text provided.' }}
                        </p>
                        <div class="flex gap-3 mt-2 text-[11px] text-gray-400 font-sans">
                           <span class="font-sans"><i class="far fa-thumbs-up"></i>
                           {{ $review->helpful_count ?? 0 }}</span>
                           <span class="font-sans">{{ $review->created_at ? $review->created_at->diffForHumans() : 'Recently' }}</span>
                        </div>
                     </div>
                     @empty
                     <div class="text-center py-8">
                        <i class="fas fa-star text-gray-300 text-4xl mb-2"></i>
                        <p class="text-gray-500 text-sm font-sans">No reviews yet. Be the first to review this
                           product!
                        </p>
                     </div>
                     @endforelse
                  </div>
                  <p class="text-center text-[11px] text-gray-400 font-sans">Showing {{ min(4, $reviewCount) }} of
                     {{ $reviewCount }} reviews
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

        <!-- Related Products Section -->
       <section class="px-4 lgg:py-12 py-6 bg-gray-50">
    <div class="container mx-auto">
        <!-- Related Products Section -->
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-6">
            <div>
                <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-light text-gray-800 heading-font tracking-wide">
                    Related Products
                </h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-secondary to-primary mt-2"></div>
            </div>
            <a href="{{ route('page.multi-product') }}"
                class="group flex items-center gap-2 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-medium text-secondary hover:text-primary transition-all font-sans">
                View All
                <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if (isset($relatedProducts))
                @forelse($relatedProducts as $relatedProduct)
                    @php
                        $variant = $relatedProduct->variants->first();
                        $productImage = $relatedProduct->images->first();
                        $imagePath = $productImage
                            ? ltrim($productImage->image, '/')
                            : 'assets/images/placeholder.jpg';
                        $imageUrl = $relatedProduct->featured_image ? asset($relatedProduct->featured_image) : asset('assets/images/placeholder.jpg');
                        if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                            $parts = explode('upload/', $imageUrl);
                            $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
                        }
                    @endphp
                    <div class="item flex justify-center items-center">
                        <div class="group w-full bg-white xxs:max-w-full max-w-[320px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200"
                            onclick="window.location.href='{{ route('page.single-product', $relatedProduct->slug) }}';">
                            
                            <!-- Image Wrapper -->
                            <div class="relative overflow-hidden bg-gray-100">
                                <img src="{{ $imageUrl }}"
                                    alt="{{ $relatedProduct->name }}"
                                    class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async"
                                    width="600"
                                    height="900" />

                                <!-- Quick View Overlay -->
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                    <button class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                                        Quick View
                                    </button>
                                </div>

                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if ($variant && $variant->discount && $variant->discount > 0)
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                                            {{ $variant->discount }}% OFF
                                        </span>
                                    @elseif($relatedProduct->is_trending ?? false)
                                        <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                                            Trending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4 space-y-2">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $relatedProduct->brand ?? '' }}</span>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    </div>
                                    <span class="text-xs font-sans text-gray-400">({{ $relatedProduct->rating_count ?? rand(10, 200) }})</span>
                                </div>

                                <!-- Price -->
                                <div class="flex items-center gap-2 flex-wrap mt-1">
                                    <span class="text-lg font-semibold text-gray-900 font-sans">Rs.
                                        {{ $variant->discount_price ?? $variant->price ?? $relatedProduct->price }}</span>
                                    @if ($variant && $variant->discount_price && $variant->discount_price != $variant->price)
                                        <span class="text-xs text-gray-400 line-through font-sans">Rs.
                                            {{ $variant->price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 font-sans">No related products found.</p>
                    </div>
                @endforelse
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 font-sans">Related products not available.</p>
                </div>
            @endif
        </div>

        
    </div>
</section>

<section class="px-4 lgg:py-12 py-6 ">
    <div class="container mx-auto">
        <!-- Most Wishlisted Products Section -->
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-6 ">
            <div>
                <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-light text-gray-800 heading-font tracking-wide">
                    Most Wishlisted Products
                </h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-secondary to-primary mt-2"></div>
            </div>
            <a href="{{ route('page.multi-product') }}"
                class="group flex items-center gap-2 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-medium text-secondary hover:text-primary transition-all font-sans">
                View All
                <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @if (isset($mostWishlistedProducts))
                @forelse($mostWishlistedProducts as $relatedProduct)
                    @php
                        $variant = $relatedProduct->variants->first();
                        $imageUrl = $relatedProduct->featured_image ? asset($relatedProduct->featured_image) : asset('assets/images/placeholder.jpg');
                        if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                            $parts = explode('upload/', $imageUrl);
                            $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
                        }
                        if (!$variant) {
                            continue;
                        }
                    @endphp
                    <div class="item flex justify-center items-center">
                        <div class="group w-full bg-white xxs:max-w-full max-w-[320px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200"
                            onclick="window.location.href='{{ route('page.single-product', $relatedProduct->slug) }}';">
                            
                            <!-- Image Wrapper -->
                            <div class="relative overflow-hidden bg-gray-100">
                                <img src="{{ $imageUrl }}"
                                    alt="{{ $relatedProduct->name }}"
                                    class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async"
                                    width="600"
                                    height="900" />

                                <!-- Quick View Overlay -->
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                    <button class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                                        Quick View
                                    </button>
                                </div>

                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if ($variant && $variant->discount && $variant->discount > 0)
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                                            {{ $variant->discount }}% OFF
                                        </span>
                                    @elseif($relatedProduct->is_trending ?? false)
                                        <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                                            Trending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4 space-y-2">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $relatedProduct->brand ?? '' }}</span>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-0.5">
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    </div>
                                    <span class="text-xs font-sans text-gray-400">({{ $relatedProduct->rating_count ?? rand(10, 200) }})</span>
                                </div>

                                <!-- Price -->
                                <div class="flex items-center gap-2 flex-wrap mt-1">
                                    <span class="text-lg font-semibold text-gray-900 font-sans">Rs.
                                        {{ $variant->discount_price ?? $variant->price }}</span>
                                    @if ($variant && $variant->discount_price && $variant->discount_price != $variant->price)
                                        <span class="text-xs text-gray-400 line-through font-sans">Rs.
                                            {{ $variant->price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 font-sans">No wishlisted products found.</p>
                    </div>
                @endforelse
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 font-sans">Wishlisted products not available.</p>
                </div>
            @endif
        </div>
</div>
</section>


        <!-- Last Viewed Products Section -->
        @if ($lastViewedProducts && $lastViewedProducts->isNotEmpty())

           <section class="px-4 lgg:py-12 py-6 bg-gray-50">
    <div class="container mx-auto">
        <div class="w-full py-4 flex items-center justify-between flex-wrap gap-4 mb-6">
            <div>
                <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-light text-gray-800 heading-font tracking-wide">
                    Last Viewed Products
                </h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-secondary to-primary mt-2"></div>
            </div>
            <a href="{{ route('page.multi-product') }}"
                class="group flex items-center gap-2 text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-medium text-secondary hover:text-primary transition-all font-sans">
                View All
                <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="main-owl owl-carousel owl-theme">
            @forelse($lastViewedProducts as $lastViewedProduct)
                @php
                    $imageUrl = $lastViewedProduct['featured_image'] 
                        ? asset($lastViewedProduct['featured_image']) 
                        : asset('assets/images/placeholder.jpg');
                    if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
                        $parts = explode('upload/', $imageUrl);
                        $imageUrl = $parts[0] . 'upload/w_600,h_900,c_fill,f_auto,q_auto,dpr_auto/' . $parts[1];
                    }
                @endphp
                <div class="item flex justify-center items-center">
                    <div class="group w-full bg-white xxs:max-w-full max-w-[320px] rounded-lg overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer border border-gray-100 hover:border-gray-200"
                        onclick="window.location.href='{{ route('page.single-product', $lastViewedProduct['slug']) }}';">
                        
                        <!-- Image Wrapper -->
                        <div class="relative overflow-hidden bg-gray-100">
                            <img src="{{ $imageUrl }}"
                                alt="{{ $lastViewedProduct['name'] }}"
                                class="w-full h-auto aspect-[9/13] object-cover object-top object-center transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                                decoding="async"
                                width="600"
                                height="900" />

                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                <button class="bg-white/90 backdrop-blur-sm text-gray-800 px-6 py-2.5 rounded-full font-sans text-sm font-medium tracking-wide hover:bg-white hover:scale-105 transition-all duration-300 shadow-lg">
                                    Quick View
                                </button>
                            </div>

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if ($lastViewedProduct['is_trending'] ?? false)
                                    <span class="bg-black/90 backdrop-blur-sm text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider border border-white/20">
                                        Trending
                                    </span>
                                @endif
                                <span class="bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white text-[11px] font-medium px-3 py-1.5 rounded-full font-sans uppercase tracking-wider shadow-lg">
                                    Recently Viewed
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-2">
                            <div class="flex items-start justify-between">
                                <h3 class="text-[14px] font-medium text-gray-800 truncate font-sans uppercase tracking-wide flex-1 pr-2">
                                    {{ $lastViewedProduct['name'] }}
                                </h3>
                                <span class="text-[10px] font-sans uppercase text-gray-400 whitespace-nowrap">{{ $lastViewedProduct['brand'] ?? '' }}</span>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-0.5">
                                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                    <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                                </div>
                                <span class="text-xs font-sans text-gray-400">({{ rand(10, 200) }})</span>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center gap-2 flex-wrap mt-1">
                                <span class="text-lg font-semibold text-gray-900 font-sans">Rs.
                                    {{ $lastViewedProduct['discount_price'] ?? $lastViewedProduct['price'] }}</span>
                                @if (isset($lastViewedProduct['discount_price']) && $lastViewedProduct['discount_price'] != $lastViewedProduct['price'])
                                    <span class="text-xs text-gray-400 line-through font-sans">Rs.
                                        {{ $lastViewedProduct['price'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 font-sans">No recently viewed products.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
        @endif

        <!-- Editor's Pick Section -->
        {{-- <section class="px-4 lgg:py-12 py-6">
            <div class="container mx-auto">
                <div class="w-full text-center mb-6">
                    <h2 class="text-p-xl 2xl:text-p-2xl font-semibold text-gray-900">Editor's Pick</h2>
                </div>
                <div class="grid-container">
                    @php
                        $editorBanners = \App\Models\Banner::active()->where('type', 'editor')->ordered()->get();
                    @endphp
                    <!-- Owl Carousel for mobile/tablet -->
                    <div class="owl-carousel banner-carousel lgg:hidden">
                        @foreach ($editorBanners as $banner)
                            <!-- Slide -->
                            <div class="relative bg-[#b8a89a] overflow-hidden max-h-[600px] min-h-[500px] h-[50vh]"
                                @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                                <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="{{ $banner->title }}"
                                    class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                                <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                                    @if ($banner->subtitle)
                                        <span
                                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                                    @endif
                                    <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                                        {{ $banner->title }}
                                    </h2>

                                    @if ($banner->description)
                                        <p class="text-sm text-black mb-6">
                                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                                        </p>
                                    @endif

                                    <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                                        class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                                        {{ $banner->button_text }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Original grid layout for desktop -->
                    <div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[600px] min-h-[500px] h-[50vh]">
                        @foreach ($editorBanners as $index => $banner)
                            @if ($index % 2 == 0)
                                <!-- Left Banner -->
                                <div class="relative bg-[#b8a89a] overflow-hidden"
                                    @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                                    <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                        alt="{{ $banner->title }}"
                                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                                    <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                                        @if ($banner->subtitle)
                                            <span
                                                class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                                        @endif
                                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                                            {{ $banner->title }}
                                        </h2>
                                        @if ($banner->description)
                                            <p class="text-sm text-black mb-6">
                                                Get <span class="font-semibold">{{ $banner->description }}</span> | Use
                                                Code:
                                                <span class="text-white font-medium">{{ $banner->discount }}</span>
                                            </p>
                                        @endif
                                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                                            {{ $banner->button_text }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach ($editorBanners as $index => $banner)
                            @if ($index % 2 == 1)
                                <!-- Right Banner -->
                                <div class="relative bg-[#e8dcd6] overflow-hidden"
                                    @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                                    <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                        alt="{{ $banner->title }}"
                                        class="absolute inset-0 w-full h-full object-cover object-center object-top" />
                                    <div class="relative z-10 flex flex-col justify-center h-full p-10">
                                        @if ($banner->subtitle)
                                            <span
                                                class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                                        @endif
                                        <h2 class="heading-font text-4xl md:text-5xl text-black mb-4">
                                            {{ $banner->title }}
                                        </h2>
                                        @if ($banner->description)
                                            <p class="text-sm text-black mb-6">
                                                Get <span class="font-semibold">{{ $banner->description }}</span> | Use
                                                Code:
                                                <span class="text-[#c28b54] font-medium">{{ $banner->discount }}</span>
                                            </p>
                                        @endif
                                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                                            {{ $banner->button_text }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section> --}}
        @include('components.web.editor-banner')
    @else
        <div class="container mx-auto">
            <div class="w-full text-center mb-6 mt-5">
                <h1 class="text-2xl font-semibold mb-2">Product Not Found!</h1>
            </div>
        </div>
    @endif

    @php
        $variant = $product?->variants?->first();
        $basePrice = $variant?->discount_price ?? ($variant?->price ?? 0);
    @endphp
<script>
    // ===== PASS SIZES DATA FROM DATABASE =====
    // Create a mapping of size code to sort_order
    const sizeOrderMap = {};
    @foreach($sizes as $size)
        sizeOrderMap['{{ $size->code }}'] = {{ $size->sort_order }};
    @endforeach
    
    // Get ordered size codes
    const orderedSizeCodes = [];
    @foreach($sizes->sortBy('sort_order') as $size)
        orderedSizeCodes.push('{{ $size->code }}');
    @endforeach
    
    // Store in window for global access
    window.sizeOrderMap = sizeOrderMap;
    window.orderedSizeCodes = orderedSizeCodes;
    window.productVariants = @json($product->variants);
    
    console.log('Size Order Map (code => sort_order):', window.sizeOrderMap);
    console.log('Ordered Size Codes:', window.orderedSizeCodes);
    console.log('Product Variants:', window.productVariants);
</script>

    <!-- share modal code  -->
    <script>
        const BRAND_NAME = "{{ config('app.name') }}";
        // Get product name dynamically
        const productName = document.querySelector('h3')?.textContent || 'this product';

        // Open share modal
        function openShareModal() {
            document.getElementById('shareModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close share modal
        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Copy URL to clipboard
        function copyToClipboard() {
            const shareUrl = document.getElementById('shareUrl');
            shareUrl.select();
            shareUrl.setSelectionRange(0, 99999);

            try {
                navigator.clipboard.writeText(shareUrl.value);
                alert('✅ Link copied to clipboard!');
            } catch (err) {
                document.execCommand('copy');
                alert('✅ Link copied to clipboard!');
            }
        }

        // Get share text with greeting
        function getShareText() {
            const productName = document.querySelector('h3')?.textContent || 'this amazing product';
            const url = window.location.href;
            return `✨ Hey! Check out this amazing product "${productName}" from AymanRoyale 🛍️\n\n${url}`;
        }

        // Share on Facebook
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            const quote = encodeURIComponent(
                `Check out "${document.querySelector('h3')?.textContent || 'this amazing product'}" from AymanRoyale!`);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${quote}`, '_blank',
                'width=600,height=400');
        }

        // Share on Twitter
        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(
                `✨ Hey! Check out "${document.querySelector('h3')?.textContent || 'this amazing product'}" from AymanRoyale! 🛍️`
            );
            window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
        }

        // Share on WhatsApp
        function shareOnSecondWhatsApp() {
            const productName = "{{ $product->name ?? 'Product' }}";
            const priceElement = document.querySelector('#price-container .text-xl');
            const productPrice = priceElement ? priceElement.textContent.trim() : "{{ $basePrice }}";
            const productUrl = window.location.href;

            let selectedVariant = null;
            if (selectedVariantId) {
                selectedVariant = productVariants.find(v => v.id == selectedVariantId);
            }

            const size = selectedSize || 'N/A';
            const color = selectedColor || 'N/A';

            // ========================================
            // 📝 EDIT THIS MESSAGE FORMAT
            // Customize the WhatsApp message below
            // ========================================
            let message = `Hi, I found this style, what do you think?\n\n`;
            message += `*${productName}*\n\n`;
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
            message += `🛍️ Check out this amazing product from ${BRAND_NAME}!`;

            const encodedMessage = encodeURIComponent(message);
            window.open(`https://web.whatsapp.com/send?text=${encodedMessage}`, '_blank');
            showNotification('WhatsApp opened! Share this product with your friends.', 'success');
        }

        // Share via Email
        function shareOnEmail() {
            const productName = document.querySelector('h3')?.textContent || 'this amazing product';
            const subject = encodeURIComponent(`Check out "${productName}" from AymanRoyale!`);
            const body = encodeURIComponent(
                `✨ Hey!\n\nI thought you'd like this amazing product "${productName}" from AymanRoyale.\n\nCheck it out here:\n${window.location.href}\n\nShared with ❤️`
            );
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeShareModal();
            }
        });
    </script>

    <!-- Tab Switching JavaScript -->
    <script>
        // Make product name available globally for breadcrumbs
        window.productName = "{{ $product->name ?? 'Product' }}";

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

            // Mobile accordion functionality - FIXED
            const accordionWrappers = document.querySelectorAll('.accordion-wrapper');

            accordionWrappers.forEach(wrapper => {
                const header = wrapper.querySelector('.flex.justify-between');
                const content = wrapper.querySelector('.accordion-content-block');
                const chevron = wrapper.querySelector('.accordion-chevron');

                if (header && content && chevron) {
                    // Initialize: first accordion open by default
                    if (wrapper.classList.contains('active')) {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        chevron.style.transform = 'rotate(180deg)';
                    } else {
                        content.style.maxHeight = '0';
                        chevron.style.transform = 'rotate(0deg)';
                    }

                    header.addEventListener('click', function(e) {
                        e.stopPropagation();
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
            if (whatsappBtn) {
                whatsappBtn.addEventListener('click', function() {
                    shareOnWhatsApp();
                });
            }
        });
    </script>


    <script src="{{ asset('web/js/single-product.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fetch and display product reviews
        document.addEventListener('DOMContentLoaded', function() {
            const productSlug = '{{ $product->slug ?? null }}';

            if (!productSlug) {
                document.getElementById('reviews-list').innerHTML = `
                                    <div class="text-center py-12 text-gray-500">
                                        <p class="text-sm">No product found for reviews.</p>
                                    </div>
                                `;
                return;
            }

            const apiUrl = `{{ env('APP_URL', 'http://localhost') }}/api/reviews/products/${productSlug}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        displayReviews(data.data);
                    } else {
                        showNoReviews();
                    }
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    showError();
                });
        });

        function displayReviews(reviewData) {
            const {
                reviews,
                statistics
            } = reviewData;

            // Update overall rating
            updateOverallRating(statistics);

            // Update rating breakdown
            updateRatingBreakdown(statistics);

            // Display reviews list
            displayReviewsList(reviews);
        }

        function updateOverallRating(stats) {
            document.getElementById('average-rating').textContent = stats.average_rating.toFixed(2);
            document.getElementById('total-reviews').textContent = stats.total_reviews;
            document.getElementById('verified-percentage').innerHTML =
                `<i class="fas fa-check-circle mr-1"></i> ${stats.verified_percentage}% recommend`;

            // Generate star rating
            const starsContainer = document.getElementById('average-stars');
            const fullStars = Math.floor(stats.average_rating);
            const hasHalfStar = stats.average_rating % 1 >= 0.5;

            let starsHTML = '';
            for (let i = 0; i < fullStars; i++) {
                starsHTML += '<i class="fas fa-star text-yellow-400 text-sm"></i>';
            }
            if (hasHalfStar) {
                starsHTML += '<i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>';
            }
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                starsHTML += '<i class="far fa-star text-yellow-400 text-sm"></i>';
            }
            starsContainer.innerHTML = starsHTML;
        }

        function updateRatingBreakdown(stats) {
            // Update rating bars and percentages
            for (let rating = 5; rating >= 1; rating--) {
                const percentage = stats.rating_percentages[rating] || 0;
                const bar = document.querySelector(`[data-rating="${rating}"]`);
                const percentageText = document.querySelector(`.percentage-${rating}`);

                if (bar) {
                    bar.style.width = `${percentage}%`;
                    // Change color based on rating
                    if (rating >= 4) {
                        bar.className = 'bg-yellow-400 h-full rounded-full';
                    } else {
                        bar.className = 'bg-gray-300 h-full rounded-full';
                    }
                }

                if (percentageText) {
                    percentageText.textContent = `${percentage}%`;
                }
            }
        }

        function displayReviewsList(reviews) {
            const container = document.getElementById('reviews-list');

            if (reviews.length === 0) {
                showNoReviews();
                return;
            }

            let reviewsHTML = '';
            reviews.forEach(review => {
                const initials = review.reviewer_name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
                const stars = generateStarRating(review.rating);
                const timeAgo = getTimeAgo(review.created_at);
                const verifiedBadge = review.is_verified ?
                    '<span class="text-green-600 text-xs"><i class="fas fa-check-circle mr-1"></i>Verified</span>' :
                    '';
                const featuredBadge = review.is_featured ?
                    '<span class="text-indigo-600 text-xs"><i class="fas fa-star mr-1"></i>Featured</span>' : '';

                reviewsHTML += `
                                    <div class="review-card bg-white rounded-xl border border-gray-100 p-5 transition-all">
                                        <div class="flex items-start gap-3">
                                            <div class="avatar-placeholder w-10 h-10 rounded-full flex items-center justify-center text-gray-500 font-semibold text-sm bg-gray-200 shadow-inner">${initials}</div>
                                            <div class="flex-1">
                                                <div class="flex flex-wrap items-center justify-between gap-2">
                                                    <div>
                                                        <span class="font-bold text-gray-800">${review.reviewer_name}</span>
                                                        <div class="flex items-center gap-1 mt-1 star-rating">
                                                            ${stars}
                                                        </div>
                                                    </div>
                                                    <span class="text-xs text-gray-400">${timeAgo}</span>
                                                </div>
                                                <div class="flex gap-2 mt-1">
                                                    ${verifiedBadge}
                                                    ${featuredBadge}
                                                </div>
                                                <p class="text-gray-700 text-sm mt-2 leading-relaxed">${review.review_text}</p>
                                                <div class="flex gap-4 mt-3 text-xs text-gray-400">
                                                    <span><i class="far fa-thumbs-up mr-1"></i> Helpful (0)</span>
                                                    <span><i class="far fa-flag mr-1"></i> Report</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
            });

            container.innerHTML = reviewsHTML;
        }

        function generateStarRating(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<i class="fas fa-star text-yellow-400 text-xs"></i>';
                } else {
                    stars += '<i class="far fa-star text-yellow-400 text-xs"></i>';
                }
            }
            return stars;
        }

        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays === 1) return '1 day ago';
            if (diffDays < 30) return `${diffDays} days ago`;
            if (diffDays < 60) return '1 month ago';
            if (diffDays < 365) return `${Math.floor(diffDays / 30)} months ago`;
            return `${Math.floor(diffDays / 365)} years ago`;
        }

        function showNoReviews() {
            document.getElementById('reviews-list').innerHTML = `
                                <div class="text-center py-12 text-gray-500">
                                    <i class="fas fa-star text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-sm font-medium">No reviews yet</p>
                                    <p class="text-xs mt-1">Be the first to review this product!</p>
                                </div>
                            `;
        }

        function showError() {
            document.getElementById('reviews-list').innerHTML = `
                                <div class="text-center py-12 text-red-500">
                                    <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                                    <p class="text-sm font-medium">Unable to load reviews</p>
                                    <p class="text-xs mt-1">Please refresh the page to try again.</p>
                                </div>
                            `;
        }
    </script>

    <script>
        const loginUrl = "{{ route('page.login') }}";

        // Store all product variants data
        const productVariants = @json($product->variants);

        // Set default size and color from first variant
        let selectedSize = '{{ $product?->variants?->first()->size ?? 'M' }}';
        let selectedColor = '{{ $product?->variants?->first()->color ?? '' }}';
        let selectedVariantId = '{{ $product?->variants?->first()->id ?? '' }}';

        let selectedType = 'stitched';
        let customDimensions = null;
        let selectedCustomColor = null;

        // WhatsApp Share Function
        function shareOnWhatsApp() {
            const productName = "{{ $product->name ?? 'Product' }}";
            const productPrice = document.querySelector('#price-container .text-2xl')?.textContent ||
                "{{ $basePrice }}";
            const productUrl = window.location.href;
            const mainImage = document.getElementById('main-image')?.src || '';

            let selectedVariant = null;
            if (selectedVariantId) {
                selectedVariant = productVariants.find(v => v.id == selectedVariantId);
            }

            const size = selectedSize || 'N/A';
            const color = selectedColor || 'N/A';

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

            const encodedMessage = encodeURIComponent(message);
            window.open(`https://web.whatsapp.com/send?text=${encodedMessage}`, '_blank');
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

        // Store current color's images to prevent image changes on size selection
        let currentColorImages = null;
        let currentColorName = null;

        // Update size options based on selected color
        function updateSizeOptionsForColor(color, currentVariantId) {
            const sizeButtonsContainer = document.getElementById('size-buttons');
            if (!sizeButtonsContainer) return;

            // Find all variants with the selected color
            const variantsForColor = productVariants.filter(variant => variant.color === color);

            // Store the images for this color (same for all sizes of this color)
            if (variantsForColor.length > 0 && currentColorName !== color) {
                const firstVariant = variantsForColor[0];
                currentColorImages = firstVariant.images || (firstVariant.image ? [{
                    image: firstVariant.image
                }] : null);
                currentColorName = color;
            }

            // Get unique sizes for this color
            const availableSizes = [...new Set(variantsForColor.map(v => v.size))];

            // Clear existing size buttons
            sizeButtonsContainer.innerHTML = '';

            if (availableSizes.length === 0) {
                sizeButtonsContainer.innerHTML = '<p class="text-gray-500 text-sm">No sizes available for this color</p>';
                return;
            }

            // Create new size buttons
            availableSizes.forEach(size => {
                const sizeBtn = document.createElement('button');
                sizeBtn.className =
                    'size-btn relative w-14 h-14 rounded-full border-2 border-gray-200 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 group';
                sizeBtn.setAttribute('data-size', size);

                const sizeSpan = document.createElement('span');
                sizeSpan.className = 'text-lg font-semibold text-gray-800 group-hover:text-secondary';
                sizeSpan.textContent = size;
                sizeBtn.appendChild(sizeSpan);

                // Add click event to select this size
                sizeBtn.addEventListener('click', function() {
                    selectSizeForColor(size, color);
                });

                sizeButtonsContainer.appendChild(sizeBtn);
            });

            // Find and select the variant for the current color and size
            let defaultVariant = variantsForColor.find(v => v.size === selectedSize);

            if (!defaultVariant && variantsForColor.length > 0) {
                defaultVariant = variantsForColor[0];
            }

            if (defaultVariant) {
                const oldSize = selectedSize;
                selectedSize = defaultVariant.size;
                selectedVariantId = defaultVariant.id;

                // Update size button styling
                document.querySelectorAll('.size-btn').forEach(btn => {
                    if (btn.getAttribute('data-size') === selectedSize) {
                        btn.classList.add('border-secondary', 'bg-secondary/10');
                        btn.classList.remove('border-gray-200');
                    } else {
                        btn.classList.remove('border-secondary', 'bg-secondary/10');
                        btn.classList.add('border-gray-200');
                    }
                });

                // Only update price, NOT images when size changes
                updatePrice(defaultVariant);

                // IMPORTANT: Only update images if the color changed, not when size changes
                if (currentColorName !== color || oldSize !== selectedSize) {
                    // Only update images when color changes, not size
                    if (currentColorName !== color) {
                        updateVariantImages(defaultVariant);
                    }
                }

                // Update add to cart button variant ID
                const addToCartBtn = document.getElementById('add-to-cart');
                if (addToCartBtn) {
                    addToCartBtn.setAttribute('data-variant-id', defaultVariant.id);
                }

                checkVariantInCart(defaultVariant.id);
            }
        }

        // Select size when color is already selected - IMAGE SHOULD NOT CHANGE
        function selectSizeForColor(size, color) {
            selectedSize = size;

            // Update size button styling
            document.querySelectorAll('.size-btn').forEach(btn => {
                if (btn.getAttribute('data-size') === size) {
                    btn.classList.add('border-secondary', 'bg-secondary/10');
                    btn.classList.remove('border-gray-200');
                } else {
                    btn.classList.remove('border-secondary', 'bg-secondary/10');
                    btn.classList.add('border-gray-200');
                }
            });

            // Find the variant with the selected color and size
            const selectedVariant = productVariants.find(v => v.color === color && v.size === size);

            if (selectedVariant) {
                selectedVariantId = selectedVariant.id;

                // Update price only - DO NOT update images when size changes
                updatePrice(selectedVariant);

                // IMPORTANT: Do NOT call updateVariantImages here - images should stay the same for the same color

                // Update add to cart button
                const addToCartBtn = document.getElementById('add-to-cart');
                if (addToCartBtn) {
                    addToCartBtn.setAttribute('data-variant-id', selectedVariant.id);
                }

                // Check if variant is in cart
                checkVariantInCart(selectedVariant.id);
            }

            // Reset custom dimensions if any
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
            }
        }

        // Update color options based on selected size
        // function updateColorOptions(size) {
        //     const colorSelection = document.getElementById('color-selection');
        //     if (!colorSelection) return;

        //     // Clear existing buttons
        //     while (colorSelection.firstChild) {
        //         colorSelection.removeChild(colorSelection.firstChild);
        //     }

        //     // Filter variants by selected size
        //     const colorsForSize = productVariants.filter(variant => variant.size === size);

        //     if (colorsForSize.length === 0) {
        //         const noColorsMsg = document.createElement('p');
        //         noColorsMsg.className = 'text-gray-500 text-sm';
        //         noColorsMsg.textContent = 'No colors available for this size';
        //         colorSelection.appendChild(noColorsMsg);
        //         return;
        //     }

        //     colorsForSize.forEach((variant, index) => {
        //         const colorBtn = document.createElement('button');
        //         colorBtn.className =
        //             `color-btn w-10 h-10 rounded-full border-2 ${index === 0 ? 'border-secondary' : 'border-gray-300'} transition-all hover:scale-110`;
        //         const bgColor = variant.color_code || variant.color || '#CCCCCC';
        //         colorBtn.style.backgroundColor = bgColor;
        //         // colorBtn.style.backgroundColor = variant.color;
        //         colorBtn.setAttribute('data-color', variant.color);
        //         colorBtn.setAttribute('data-size', size);
        //         colorBtn.setAttribute('data-variant-id', variant.id);

        //         // Generate correct image URL
        //         let variantImage = '{{ asset('assets/images/placeholder.jpg') }}';

        //         // if (variant.images && variant.images.length > 0) {
        //         //     if (typeof variant.images[0] === 'object' && variant.images[0].image) {
        //         //         let imagePath = variant.images[0].image;
        //         //         imagePath = imagePath.replace(/^\/+/, '');
        //         //         variantImage = imagePath; //'{{ url('') }}/' + imagePath;
        //         //     } 
        //         //     else if (typeof variant.images[0] === 'string') {
        //         //         let imagePath = variant.images[0];
        //         //         imagePath = imagePath.replace(/^\/+/, '');
        //         //         variantImage = variant.images[0].startsWith('http') ? variant.images[0] : '{{ url('') }}/' + imagePath;
        //         //     }
        //         // } else if (variant.image) {
        //         //     let imagePath = variant.image;
        //         //     imagePath = imagePath.replace(/^\/+/, '');
        //         //     variantImage = variant.image.startsWith('http') ? variant.image : '{{ url('') }}/' + imagePath;
        //         // }

        //         if (variant.images && variant.images.length > 0) {
        //             if (typeof variant.images[0] === 'object' && variant.images[0].image) {
        //                 // Cloudinary URL - no need to modify
        //                 variantImage = variant.images[0].image;
        //             } else if (typeof variant.images[0] === 'string') {
        //                 // Cloudinary URL - use as is
        //                 variantImage = variant.images[0];
        //             }
        //         } else if (variant.image) {
        //             // Cloudinary URL - use as is
        //             variantImage = variant.image;
        //         }

        //         colorBtn.setAttribute('data-variant-image', variantImage);
        //         colorBtn.setAttribute('title', variant.color);

        //         colorBtn.addEventListener('click', function() {
        //             selectColor(variant.color, size, variant.id, this);
        //         });

        //         colorSelection.appendChild(colorBtn);
        //     });

        //     // Select first color by default
        //     if (colorsForSize.length > 0) {
        //         const firstColorBtn = colorSelection.querySelector('.color-btn');
        //         if (firstColorBtn) {
        //             selectColor(colorsForSize[0].color, size, colorsForSize[0].id, firstColorBtn);
        //         }
        //     }
        // }
        function updateColorOptions(size) {
            const colorSelection = document.getElementById('color-selection');
            if (!colorSelection) return;

            // Clear existing buttons
            while (colorSelection.firstChild) {
                colorSelection.removeChild(colorSelection.firstChild);
            }

            // CHANGE THIS: Show ALL unique colors, not filtered by size
            const uniqueColors = [...new Set(productVariants.map(v => v.color))];

            // REMOVE THIS LINE: const colorsForSize = productVariants.filter(variant => variant.size === size);

            if (uniqueColors.length === 0) {
                const noColorsMsg = document.createElement('p');
                noColorsMsg.className = 'text-gray-500 text-sm';
                noColorsMsg.textContent = 'No colors available for this size';
                colorSelection.appendChild(noColorsMsg);
                return;
            }

            // CHANGE THIS: Use uniqueColors instead of colorsForSize
            uniqueColors.forEach((color, index) => {
                // Find any variant with this color
                const variant = productVariants.find(v => v.color === color);
                if (!variant) return;

                const colorBtn = document.createElement('button');
                colorBtn.className =
                    `color-btn w-10 h-10 rounded-full border-2 ${index === 0 ? 'border-secondary' : 'border-gray-300'} transition-all hover:scale-110`;
                const bgColor = variant.color_code || variant.color || '#CCCCCC';
                colorBtn.style.backgroundColor = bgColor;
                colorBtn.setAttribute('data-color', variant.color);
                // REMOVE THIS: Don't set data-size
                // colorBtn.setAttribute('data-size', size);
                colorBtn.setAttribute('data-variant-id', variant.id);

                // ... rest of your image handling code remains the same ...

                colorBtn.setAttribute('title', variant.color);

                colorBtn.addEventListener('click', function() {
                    // CHANGE THIS: Don't pass size parameter
                    selectColor(variant.color, null, variant.id, this);
                });

                colorSelection.appendChild(colorBtn);
            });

            // Select first color by default
            if (uniqueColors.length > 0) {
                const firstColorBtn = colorSelection.querySelector('.color-btn');
                if (firstColorBtn) {
                    const firstVariant = productVariants.find(v => v.color === uniqueColors[0]);
                    if (firstVariant) {
                        selectColor(firstVariant.color, null, firstVariant.id, firstColorBtn);
                    }
                }
            }
        }
        // Select color when size is already selected - IMAGES SHOULD CHANGE HERE
        // function selectColor(color, size, variantId, element) {
        //     selectedColor = color;
        //     selectedVariantId = variantId;

        //     // Update color button styling
        //     document.querySelectorAll('.color-btn').forEach(btn => {
        //         if (btn.getAttribute('data-color') === color && btn.getAttribute('data-size') === size) {
        //             btn.classList.add('border-secondary');
        //             btn.classList.remove('border-gray-300');
        //         } else {
        //             btn.classList.remove('border-secondary');
        //             btn.classList.add('border-gray-300');
        //         }
        //     });

        //     // Update size options based on selected color
        //     updateSizeOptionsForColor(color, variantId);

        //     const addToCartBtn = document.getElementById('add-to-cart');
        //     if (addToCartBtn) {
        //         addToCartBtn.setAttribute('data-variant-id', variantId);
        //     }

        //     if (customDimensions) {
        //         customDimensions = null;
        //         selectedCustomColor = null;
        //         if (addToCartBtn) {
        //             addToCartBtn.removeAttribute('data-custom-dimensions');
        //             addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
        //             addToCartBtn.classList.remove('bg-green-600');
        //             addToCartBtn.classList.add('bg-secondary');
        //             addToCartBtn.disabled = false;
        //         }
        //     }

        //     const variantImage = element.getAttribute('data-variant-image');

        //     if (variantImage) {
        //         const mainImage = document.getElementById('main-image');

        //         if (mainImage) {
        //             mainImage.src = variantImage;
        //         }
        //     }

        //     const selectedVariant = productVariants.find(v => v.id == variantId);
        //     if (selectedVariant) {
        //         updatePrice(selectedVariant);
        //         // Update images when color changes (NOT when size changes)
        //         updateVariantImages(selectedVariant);
        //     }

        //     checkVariantInCart(variantId);
        // }

        // Original selectSize function for initial load - IMAGES SHOULD NOT CHANGE
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

            // Update color options based on selected size
            updateColorOptions(size);

            // Find the variant for current color and new size
            const newVariant = productVariants.find(v => v.color === selectedColor && v.size === size);

            if (newVariant) {
                selectedVariantId = newVariant.id;
                // Update price only - images remain the same
                updatePrice(newVariant);

                // Update add to cart button
                const addToCartBtn = document.getElementById('add-to-cart');
                if (addToCartBtn) {
                    addToCartBtn.setAttribute('data-variant-id', newVariant.id);
                }

                checkVariantInCart(newVariant.id);
            }

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
            }
        }

        // function updateVariantImages(variant) {
        //     const mainImage = document.getElementById('main-image');
        //     const thumbnailContainer = document.getElementById('thumbnail-container');

        //     if (!variant) return;

        //     if (variant.images && variant.images.length > 0) {
        //         if (mainImage) {
        //             const firstImage = variant.images[0];
        //             let firstImagePath = '{{ asset('assets/images/placeholder.jpg') }}';

        //             if (typeof firstImage === 'object' && firstImage.image) {
        //                 let imagePath = firstImage.image.replace(/^\/+/, '');
        //                 firstImagePath = '{{ url('') }}/' + imagePath;
        //             } else if (typeof firstImage === 'string') {
        //                 let imagePath = firstImage.replace(/^\/+/, '');
        //                 firstImagePath = firstImage.startsWith('http') ? firstImage : '{{ url('') }}/' + imagePath;
        //             }

        //             mainImage.src = firstImagePath;
        //             mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
        //         }

        //         if (thumbnailContainer) {
        //             let thumbnailsHtml = '';
        //             variant.images.forEach((image, index) => {
        //                 let imagePath = '{{ asset('assets/images/placeholder.jpg') }}';

        //                 if (typeof image === 'object' && image.image) {
        //                     let path = image.image.replace(/^\/+/, '');
        //                     imagePath = '{{ url('') }}/' + path;
        //                 } else if (typeof image === 'string') {
        //                     let path = image.replace(/^\/+/, '');
        //                     imagePath = image.startsWith('http') ? image : '{{ url('') }}/' + path;
        //                 }

        //                 const selectedClass = index === 0 ? 'selected border-secondary' : 'border-transparent';
        //                 thumbnailsHtml += `<div class="thumbnail xll:min-h-[200px] lg:min-h-[170px] h-fit w-full lg:max-w-full min-w-[64px] max-w-[64px] overflow-hidden rounded-lg border-2 cursor-pointer ${selectedClass}" data-display="${imagePath}" data-large="${imagePath}" onclick="updateMainImage('${imagePath}', '{{ $product?->name }}', this)"><img src="${imagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
        //             });
        //             thumbnailContainer.innerHTML = thumbnailsHtml;
        //         }
        //     } else if (variant.image) {
        //         let imagePath = variant.image.replace(/^\/+/, '');
        //         const fullImagePath = variant.image.startsWith('http') ? variant.image : '{{ url('') }}/' + imagePath;

        //         if (mainImage) {
        //             mainImage.src = fullImagePath;
        //             mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
        //         }

        //         if (thumbnailContainer) {
        //             thumbnailContainer.innerHTML = `<div class="thumbnail h-fit w-full overflow-hidden rounded-lg border-2 cursor-pointer border-secondary" data-display="${fullImagePath}" data-large="${fullImagePath}" onclick="updateMainImage('${fullImagePath}', '{{ $product?->name }}', this)"><img src="${fullImagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
        //         }
        //     }
        // }

        function updateVariantImages(variant) {
            const mainImage = document.getElementById('main-image');
            const thumbnailContainer = document.getElementById('thumbnail-container');

            if (!variant) return;

            if (variant.images && variant.images.length > 0) {
                if (mainImage) {
                    const firstImage = variant.images[0];
                    let firstImagePath = '{{ asset('assets/images/placeholder.jpg') }}';

                    // Check if it's an object with image property
                    if (typeof firstImage === 'object' && firstImage.image_url) {
                        // Use image_url if available
                        firstImagePath = firstImage.image_url;
                    } else if (typeof firstImage === 'object' && firstImage.image) {
                        // Fallback to image property
                        let imagePath = firstImage.image;
                        firstImagePath = imagePath.startsWith('http') ? imagePath : '{{ url('') }}/' + imagePath
                            .replace(/^\/+/, '');
                    } else if (typeof firstImage === 'string') {
                        let imagePath = firstImage;
                        firstImagePath = imagePath.startsWith('http') ? imagePath : '{{ url('') }}/' + imagePath
                            .replace(/^\/+/, '');
                    }

                    mainImage.src = firstImagePath;
                    mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
                }

                if (thumbnailContainer) {
                    let thumbnailsHtml = '';
                    variant.images.forEach((image, index) => {
                        let imagePath = '{{ asset('assets/images/placeholder.jpg') }}';

                        if (typeof image === 'object' && image.image_url) {
                            imagePath = image.image_url;
                        } else if (typeof image === 'object' && image.image) {
                            let path = image.image;
                            imagePath = path.startsWith('http') ? path : '{{ url('') }}/' + path.replace(
                                /^\/+/, '');
                        } else if (typeof image === 'string') {
                            let path = image;
                            imagePath = path.startsWith('http') ? path : '{{ url('') }}/' + path.replace(
                                /^\/+/, '');
                        }

                        const selectedClass = index === 0 ? 'selected border-secondary' : 'border-transparent';
                        thumbnailsHtml +=
                            `<div class="thumbnail xll:min-h-[200px] lg:min-h-[170px] h-fit w-full lg:max-w-full min-w-[64px] max-w-[64px] overflow-hidden rounded-lg border-2 cursor-pointer ${selectedClass}" data-display="${imagePath}" data-large="${imagePath}" onclick="updateMainImage('${imagePath}', '{{ $product?->name }}', this)"><img src="${imagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
                    });
                    thumbnailContainer.innerHTML = thumbnailsHtml;
                }
            } else if (variant.image) {
                let imagePath = variant.image;
                const fullImagePath = imagePath.startsWith('http') ? imagePath : '{{ url('') }}/' + imagePath
                    .replace(/^\/+/, '');

                if (mainImage) {
                    mainImage.src = fullImagePath;
                    mainImage.alt = `${variant.color} ${variant.size} - {{ $product?->name }}`;
                }

                if (thumbnailContainer) {
                    thumbnailContainer.innerHTML =
                        `<div class="thumbnail h-fit w-full overflow-hidden rounded-lg border-2 cursor-pointer border-secondary" data-display="${fullImagePath}" data-large="${fullImagePath}" onclick="updateMainImage('${fullImagePath}', '{{ $product?->name }}', this)"><img src="${fullImagePath}" class="w-full h-full object-cover object-center object-top" alt="{{ $product?->name }}" /></div>`;
                }
            }
        }

        // Simplified selectColor function
        function selectColor(color, size, variantId, element) {
            selectedColor = color;
            selectedVariantId = variantId;

            // Update color button styling
            document.querySelectorAll('.color-btn').forEach(btn => {
                if (btn.getAttribute('data-color') === color && btn.getAttribute('data-size') === size) {
                    btn.classList.add('border-secondary');
                    btn.classList.remove('border-gray-300');
                } else {
                    btn.classList.remove('border-secondary');
                    btn.classList.add('border-gray-300');
                }
            });

            // Update size options based on selected color
            updateSizeOptionsForColor(color, variantId);

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
                }
            }

            const selectedVariant = productVariants.find(v => v.id == variantId);
            if (selectedVariant) {
                console.log('selected', selectedVariant);
                updatePrice(selectedVariant);
                updateVariantImages(selectedVariant);
            }

            checkVariantInCart(variantId);
        }

        function updatePrice(variant) {
            const priceContainer = document.getElementById('price-container');
            if (priceContainer && variant) {
                const currentPrice = variant.discount_price || variant.price;
                const originalPrice = variant.price;
                const discount = variant.discount;

                let discountHtml = '';
                if (discount > 0) {
                    discountHtml =
                        `<span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded">(${Number(discount).toFixed(2)}% off)</span>`;
                } else {
                    discountHtml = `<span class="text-white font-medium px-2 py-1 rounded bg-[#A13015]">Trending</span>`;
                }

                let originalPriceHtml = '';
                if (originalPrice != currentPrice) {
                    originalPriceHtml = `<span class="line-through text-gray-400">Rs. ${originalPrice}</span>`;
                }

                priceContainer.innerHTML = `
            <span class="text-xl text-gray-900 font-semibold">Rs. ${currentPrice}</span>
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
                    body: JSON.stringify({
                        variant_id: variantId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    updateAddToCartButton(data.in_cart, data.quantity);
                })
                .catch(error => console.error('Error checking cart:', error));
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
                const hasStock = productVariants && productVariants.some(variant => variant.stock > 0);
                if (!hasStock) {
                    alert('This product is currently out of stock. Please check back later.');
                    return;
                }

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
                        const currentUrl = window.location.href.split('#')[0];
                        const redirectUrl = currentUrl + '#action-buttons-section';
                        window.location.href = loginUrl + '?redirect=' + encodeURIComponent(redirectUrl);
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showNotification('Product added to cart successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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

        function showNotification(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'Success!' : 'Error!',
                    text: message,
                    confirmButtonText: 'OK',
                    showConfirmButton: true
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

        // Rest of the functions (custom dimensions, wishlist, etc.) remain the same...
        // [The remaining functions like selectType, toggleCustomDimension, updateCustomPrice, 
        //  toggleWishlist, checkProductInWishlist, updateWishlistButton, and fullscreen functionality 
        //  remain unchanged from your original code]

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
                            b.classList.remove('ring-2', 'ring-offset-2',
                                'border-secondary');
                        });
                        this.classList.add('ring-2', 'ring-offset-2', 'border-secondary');
                        selectedCustomColor = this.getAttribute('data-color');
                    });
                });
            }

            if (saveDimensionBtn) {
                saveDimensionBtn.addEventListener('click', function() {
                    const bustInput = document.getElementById('custom-bust');
                    const waistInput = document.getElementById('custom-waist');
                    const hipInput = document.getElementById('custom-hip');
                    const armholeInput = document.getElementById('custom-armhole');

                    const bust = bustInput ? bustInput.value : '';
                    const waist = waistInput ? waistInput.value : '';
                    const hip = hipInput ? hipInput.value : '';
                    const armhole = armholeInput ? armholeInput.value : '';

                    if (!bust || !waist || !hip || !armhole) {
                        showNotification('Please enter all measurements', 'error');
                        return;
                    }

                    if (bust <= 0 || waist <= 0 || hip <= 0 || armhole <= 0) {
                        showNotification('All measurements must be positive numbers', 'error');
                        return;
                    }

                    const selectedColorBtn = document.querySelector('#custom-color-selection .ring-2');
                    const selectedColor = selectedColorBtn ? selectedColorBtn.getAttribute('data-color') :
                        null;

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

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content');
                    if (!csrfToken) {
                        showNotification('Security token not found. Please refresh the page.', 'error');
                        return;
                    }

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
                                const currentUrl = window.location.href.split('#')[0];
                                const redirectUrl = currentUrl + '#action-buttons-section';
                                window.location.href = loginUrl + '?redirect=' + encodeURIComponent(
                                    redirectUrl);
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.success) {
                                showNotification('Custom dimensions saved successfully!', 'success');
                                toggleCustomDimension();

                                const addToCartBtn = document.getElementById('add-to-cart');
                                if (addToCartBtn) {
                                    addToCartBtn.setAttribute('data-custom-dimensions', JSON.stringify(
                                        customDimensions));
                                    addToCartBtn.innerHTML =
                                        '<i class="fas fa-shopping-cart mr-2"></i> Add Custom Item to Cart';
                                    addToCartBtn.classList.remove('bg-green-600');
                                    addToCartBtn.classList.add('bg-secondary');
                                    addToCartBtn.disabled = false;
                                }

                                updateCustomPrice();
                            } else {
                                showNotification(data?.message || 'Failed to save custom dimensions',
                                    'error');
                            }
                        })
                        .catch(error => {
                            if (error.message !== 'Authentication required') {
                                console.error('Error saving custom dimensions:', error);
                                showNotification('An error occurred while saving custom dimensions',
                                    'error');
                            }
                        })
                        .finally(() => {
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
                        customColorBtns.forEach(btn => btn.classList.remove('ring-2', 'ring-offset-2',
                            'border-secondary'));
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
            <span class="text-xl text-gray-900 font-semibold">Rs. ${customPrice}</span>
            <span class="text-sm text-gray-500 ml-2">(Custom)</span>
        `;
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
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => {
                    if (response.status === 401) {
                        const currentUrl = window.location.href.split('#')[0];
                        const redirectUrl = currentUrl + '#action-buttons-section';
                        window.location.href = loginUrl + '?redirect=' + encodeURIComponent(redirectUrl);
                        return;
                    }
                    return response.json();
                })
                .then(data => {

                    if (!data) return;

                    if (data.success) {

                        if (isInWishlist) {
                            button.classList.remove('text-red-500');
                            button.innerHTML = '<i class="far fa-heart"></i>';
                        } else {
                            button.classList.add('text-red-500');
                            button.innerHTML = '<i class="fas fa-heart"></i>';
                        }

                        // Update all wishlist badges
                        document.querySelectorAll('.wishlist-count').forEach(function(item) {
                            item.textContent = data.wishlist_count;
                        });

                    } else {

                        Swal.fire({
                            icon: 'info',
                            title: 'Wishlist',
                            text: data.message,
                            timer: 1800,
                            showConfirmButton: false
                        });

                    }

                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    button.disabled = false;
                });
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
                    body: JSON.stringify({
                        product_id: productId
                    })
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
    <script>
        /**
         * Sets up responsive height synchronization between zoom container and thumbnail container
         * When screen width > 1023px, thumbnail container height matches zoom container height
         */
        function setupThumbnailHeightSync() {
            const zoomContainer = document.getElementById('get-zoom-container');
            const thumbnailContainer = document.getElementById('thumbnail-container');

            if (!zoomContainer || !thumbnailContainer) {
                console.warn('Required containers not found: get-zoom-container or thumbnail-container');
                return;
            }

            let resizeObserver = null;
            let imageLoadObserver = null;

            /**
             * Gets the accurate height of zoom container considering all content
             */
            function getAccurateZoomContainerHeight() {
                if (!zoomContainer) return 0;

                // Get computed height including padding, borders, etc.
                const computedStyle = window.getComputedStyle(zoomContainer);
                const height = zoomContainer.getBoundingClientRect().height;

                return height;
            }

            /**
             * Applies the max-height to thumbnail container if screen width > 1023px
             */
            function applyThumbnailMaxHeight() {
                const screenWidth = window.innerWidth;

                if (screenWidth > 1023) {
                    const zoomHeight = getAccurateZoomContainerHeight();

                    if (zoomHeight > 0) {
                        thumbnailContainer.style.maxHeight = `${zoomHeight}px`;
                        thumbnailContainer.style.overflowY = 'auto'; // Enable scrolling if content exceeds height

                        // Optional: Add a class for styling
                        thumbnailContainer.classList.add('thumbnail-height-synced');
                    } else {
                        console.log('Zoom container height not yet available');
                    }
                } else {
                    // Reset styles when screen width <= 1023px
                    thumbnailContainer.style.maxHeight = '';
                    thumbnailContainer.style.overflowY = '';
                    thumbnailContainer.classList.remove('thumbnail-height-synced');
                }
            }

            /**
             * Waits for all images in zoom container to load completely
             */
            function waitForImagesInContainer(container) {
                const images = container.querySelectorAll('img');
                const imagePromises = Array.from(images).map(img => {
                    if (img.complete) {
                        return Promise.resolve();
                    }
                    return new Promise((resolve) => {
                        img.addEventListener('load', resolve);
                        img.addEventListener('error', resolve); // Resolve even on error to continue
                    });
                });

                return Promise.all(imagePromises);
            }

            /**
             * Ensures accurate height after all content is loaded
             */
            async function updateHeightAfterContentLoad() {
                // Wait for images in zoom container to load
                await waitForImagesInContainer(zoomContainer);

                // Small delay to ensure layout is updated after images load
                setTimeout(() => {
                    applyThumbnailMaxHeight();
                }, 50);
            }

            /**
             * Observes DOM mutations in zoom container to detect content changes
             */
            function observeZoomContainerChanges() {
                if (imageLoadObserver) {
                    imageLoadObserver.disconnect();
                }

                imageLoadObserver = new MutationObserver((mutations) => {
                    // Check if any image was added or changed
                    const hasImageChanges = mutations.some(mutation => {
                        return mutation.type === 'childList' &&
                            mutation.addedNodes.length > 0 &&
                            Array.from(mutation.addedNodes).some(node =>
                                node.nodeType === 1 && (node.tagName === 'IMG' || node.querySelectorAll(
                                    'img').length > 0)
                            );
                    });

                    if (hasImageChanges) {
                        updateHeightAfterContentLoad();
                    } else {
                        // For other content changes, apply height with slight delay
                        setTimeout(applyThumbnailMaxHeight, 100);
                    }
                });

                imageLoadObserver.observe(zoomContainer, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    attributeFilter: ['src', 'style']
                });
            }

            /**
             * Handles resize events with debouncing
             */
            let resizeTimeout;

            function handleResize() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    applyThumbnailMaxHeight();
                }, 150);
            }

            /**
             * Sets up resize observer for zoom container size changes
             */
            function setupResizeObserver() {
                if (typeof ResizeObserver !== 'undefined') {
                    resizeObserver = new ResizeObserver(() => {
                        applyThumbnailMaxHeight();
                    });
                    resizeObserver.observe(zoomContainer);
                }
            }

            /**
             * Initializes the functionality
             */
            async function init() {
                // Initial application of height
                await updateHeightAfterContentLoad();

                // Set up event listeners
                window.addEventListener('resize', handleResize);

                // Set up resize observer for container size changes
                setupResizeObserver();

                // Set up mutation observer for content changes
                observeZoomContainerChanges();

                // Also listen for image load events globally
                document.addEventListener('load', (e) => {
                    if (e.target.tagName === 'IMG' && zoomContainer.contains(e.target)) {
                        updateHeightAfterContentLoad();
                    }
                }, true);
            }

            // Start the functionality
            init();

            // Return cleanup function for removing event listeners if needed
            return function cleanup() {
                window.removeEventListener('resize', handleResize);
                if (resizeObserver) {
                    resizeObserver.disconnect();
                }
                if (imageLoadObserver) {
                    imageLoadObserver.disconnect();
                }
                if (resizeTimeout) {
                    clearTimeout(resizeTimeout);
                }
            };
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                setupThumbnailHeightSync();
            });
        } else {
            setupThumbnailHeightSync();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const couponToggleBtn = document.getElementById('coupon-toggle-btn');
            const couponBlock = document.getElementById('coupon-block');
            const couponArrow = document.getElementById('coupon-arrow');
            const couponInput = document.getElementById('coupon-input');
            const applyCouponBtn = document.getElementById('apply-coupon-btn');
            const couponMessage = document.getElementById('coupon-message');

            // Toggle coupon block visibility
            couponToggleBtn.addEventListener('click', function() {
                couponBlock.classList.toggle('hidden');
                couponArrow.style.transform = couponBlock.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';

                // Clear previous messages when toggling
                couponMessage.classList.add('hidden');
                couponMessage.textContent = '';
            });

            // Apply coupon
            applyCouponBtn.addEventListener('click', function() {
                const couponCode = couponInput.value.trim();

                if (!couponCode) {
                    showCouponMessage('Please enter a coupon code', 'red');
                    return;
                }

                // Here you would typically make an AJAX request to validate the coupon
                // For demonstration, I'll show a success message
                // Replace this with your actual coupon validation logic

                // Example AJAX call (uncomment and modify as needed):
                /*
                fetch('/validate-coupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ coupon: couponCode })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        showCouponMessage('Coupon applied successfully!', 'green');
                        // Update price or do other actions
                    } else {
                        showCouponMessage('Invalid coupon code', 'red');
                    }
                })
                .catch(error => {
                    showCouponMessage('Error applying coupon', 'red');
                });
                */

                // For demonstration purposes only - remove this in production
                if (couponCode.length > 3) {
                    showCouponMessage('✓ Coupon "' + couponCode + '" applied successfully!', 'green');
                } else {
                    showCouponMessage('✗ Invalid coupon code. Please try again.', 'red');
                }
            });

            // Allow Enter key to apply coupon
            couponInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    applyCouponBtn.click();
                }
            });

            // Function to show messages
            function showCouponMessage(message, type) {
                couponMessage.textContent = message;
                couponMessage.className = 'text-sm mt-2 font-medium';
                couponMessage.classList.remove('hidden');

                if (type === 'green') {
                    couponMessage.classList.add('text-green-600');
                } else if (type === 'red') {
                    couponMessage.classList.add('text-red-600');
                }
            }
        });
    </script>



@endsection
