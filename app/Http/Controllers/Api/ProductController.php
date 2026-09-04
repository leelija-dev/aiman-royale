<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferProducts;
use App\Models\Product;
use App\Models\Order;
use Cashfree\Model\Products;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Get all products
     *
     * @return JsonResponse
     */
    public function getAllProduct(): JsonResponse
    {
        try {
            $products = Product::where('is_active', 1)
                ->where('products.ready_to_ship', 1)
                ->with(['images', 'variants', 'category', 'occasion'])
                ->get();
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }


   
    public function filterProducts(Request $request): JsonResponse
    {
       
        try {
            if ($request->search == 'offers' || $request->search == 'offer') {
                $query = OfferProducts::join('product_variants', 'offer_products.product_variant_id', '=', 'product_variants.id')
                    ->join('products', 'offer_products.product_id', '=', 'products.id')
                    ->where('products.ready_to_ship', 1)
                    ->select(
                        'offer_products.*',
                        'product_variants.discount'
                    )
                    ->orderByDesc('product_variants.discount')
                    ->with([
                        'productVariant',
                        'product.category',
                        'product.occasion'
                    ]);
            } else {
                
                $query = Product::where('is_active', 1)
                    ->where('products.ready_to_ship', 1)
                    ->with(['variants', 'category', 'occasion']);

                // Filter by search term
                if ($request->filled('search') != 'offers' && $request->filled('search') != 'offer') {
                    $searchTerm = $request->input('search');
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('design_no', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhereHas('category', function ($cat) use ($searchTerm) {
                                $cat->where('name', 'LIKE', '%' . $searchTerm . '%');
                            })
                            ->orWhereHas('occasion', function ($occ) use ($searchTerm) {
                                $occ->where('name', 'LIKE', '%' . $searchTerm . '%');
                            });
                    });
                }
            }

            // Filter by products with offer (discount applied)
            if ($request->filled('has_offer') && $request->input('has_offer') == '1') {
                $query->whereNotNull('discount_price')
                    ->where('discount_price', '<', 'price');
            }

            // Filter by category slug
            if ($request->filled('category_slug')) {
                $categorySlug = $request->input('category_slug');
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            // Filter by categories (comma-separated or array)
            if ($request->filled('categories')) {
                $categories = $request->input('categories');
                $categoryArray = is_string($categories) ? explode(',', $categories) : $categories;
                $categoryArray = array_filter(array_map('trim', $categoryArray));

                if (!empty($categoryArray)) {
                    $query->whereHas('category', function ($q) use ($categoryArray) {
                        $q->whereIn('name', $categoryArray);
                    });
                }
            }

            // Filter by occasion slug
            if ($request->filled('occasion_slug')) {
                $occasionSlug = $request->input('occasion_slug');
                $query->whereHas('occasion', function ($q) use ($occasionSlug) {
                    $q->where('slug', $occasionSlug);
                });
            }

            // Filter by occasions (comma-separated or array)
            if ($request->filled('occasions')) {
                $occasions = $request->input('occasions');
                $occasionArray = is_string($occasions) ? explode(',', $occasions) : $occasions;
                $occasionArray = array_filter(array_map('trim', $occasionArray));

                if (!empty($occasionArray)) {
                    $query->whereHas('occasion', function ($q) use ($occasionArray) {
                        $q->whereIn('name', $occasionArray);
                    });
                }
            }

            // Filter by color
            if ($request->filled('color')) {
                $color = $request->input('color');
                $query->whereHas('variants', function ($q) use ($color) {
                    $q->where('color', $color);
                });
            }

            // Filter by colors (comma-separated or array)
            if ($request->filled('colors')) {
                $colors = $request->input('colors');
                $colorArray = is_string($colors) ? explode(',', $colors) : $colors;
                $colorArray = array_filter(array_map('trim', $colorArray));

                if (!empty($colorArray)) {
                    $query->whereHas('variants', function ($q) use ($colorArray) {
                        $q->whereIn('color', $colorArray);
                    });
                }
            }

            // Filter by size
            if ($request->filled('size')) {
                $size = $request->input('size');
                $query->whereHas('variants', function ($q) use ($size) {
                    $q->where('size', $size);
                });
            }

            // Filter by sizes (comma-separated or array)
            if ($request->filled('sizes')) {
                $sizes = $request->input('sizes');
                $sizeArray = is_string($sizes) ? explode(',', $sizes) : $sizes;
                $sizeArray = array_filter(array_map('trim', $sizeArray));

                if (!empty($sizeArray)) {
                    $query->whereHas('variants', function ($q) use ($sizeArray) {
                        $q->whereIn('size', $sizeArray);
                    });
                }
            }

            // Filter by price range
            if ($request->filled('price_range')) {
                 
                $priceRange = $request->input('price_range');
                if (strpos($priceRange, '-') !== false) {
                    [$minPrice, $maxPrice] = explode('-', $priceRange);

                    $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                        if (is_numeric($minPrice)) {
                            $q->where('discount_price', '>=', $minPrice);
                        }
                        if (is_numeric($maxPrice)) {
                            $q->where('discount_price', '<=', $maxPrice);
                        }
                    });
                }
            }

            // Filter by price ranges (comma-separated or array)
            if ($request->filled('price_ranges')) {
                
                $priceRanges = $request->input('price_ranges');
               
                $rangeArray = is_string($priceRanges) ? explode(',', $priceRanges) : $priceRanges;
                $rangeArray = array_filter(array_map('trim', $rangeArray));

                if (!empty($rangeArray)) {
                    $query->whereHas('variants', function ($q) use ($rangeArray) {
                        $q->where(function ($subQ) use ($rangeArray) {
                            foreach ($rangeArray as $range) {
                                if (strpos($range, '-') !== false) {
                                    [$minPrice, $maxPrice] = explode('-', $range);
                                    $subQ->orWhere(function ($orQ) use ($minPrice, $maxPrice) {
                                        if (is_numeric($minPrice)) {
                                            $orQ->where('discount_price', '>=', $minPrice);
                                        }
                                        if (is_numeric($maxPrice)) {
                                            $orQ->where('discount_price', '<=', $maxPrice);
                                        }
                                    });
                                }
                            }
                        });
                    });
                }
            }

            if ($request->filled('filter')) {
                $filterValue = $request->input('filter');
                if ($filterValue == 'best-seller') {
                    $query->withCount(['orderProducts as total_sold' => function ($query) {
                        $query->selectRaw('SUM(quantity)');
                    }])
                        ->orderBy('total_sold', 'desc');
                } elseif ($filterValue == 'new-arrival') {
                    $query->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'featured') {
                    $query->where('is_featured', true)->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'top-rated') {
                    $query->orderBy('created_at', 'desc');
                }
            }

            $products = $query->paginate(5)->WithQueryString();

            $processedProducts = $products->map(function ($product) {
                // Get the first variant's price and discount price
                $firstVariantPrice = null;
                $firstVariantDiscountPrice = null;

                // Check if product has variants
                if ($product->variants && $product->variants->isNotEmpty()) {
                    $firstVariant = $product->variants->first();
                    $firstVariantPrice = $firstVariant->price;
                    $firstVariantDiscountPrice = $firstVariant->discount_price;
                }

                // If this is an OfferProducts query (different structure)
                if ($product instanceof \App\Models\OfferProducts) {
                    // For offer products, we need to get the variant from the relationship
                    if ($product->productVariant) {
                        $firstVariantPrice = $product->productVariant->price;
                        $firstVariantDiscountPrice = $product->productVariant->discount_price;
                    }
                }

                $firstImage = optional(
                    \App\Models\ProductImage::where('product_id', $product->id)->first()
                )->image;

                // Get variants data for the response
                $variantsData = [];
                if ($product->variants && $product->variants->isNotEmpty()) {
                    $variantsData = $product->variants->map(function ($variant) {
                        return [
                            'variant_id' => $variant->id,
                            'size' => $variant->size,
                            'color' => $variant->color,
                            'price' => $variant->price,
                            'discount_price' => $variant->discount_price,
                            'stock' => $variant->stock,
                        ];
                    })->toArray();
                } elseif ($product instanceof \App\Models\OfferProducts && $product->productVariant) {
                    // For offer products, include the single variant
                    $variantsData = [
                        [
                            'variant_id' => $product->productVariant->id,
                            'size' => $product->productVariant->size,
                            'color' => $product->productVariant->color,
                            'price' => $product->productVariant->price,
                            'discount_price' => $product->productVariant->discount_price,
                            'stock' => $product->productVariant->stock,
                        ]
                    ];
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'design_no' => $product->design_no,
                    'brand' => $product->brand,
                    'fabric' => $product->fabric,
                    'fit' => $product->fit,
                    'price' => $firstVariantPrice ?? $product->price, // Use first variant price or fallback
                    'discount_price' => $firstVariantDiscountPrice ?? $product->discount_price, // Use first variant discount or fallback
                    'stock' => $product->stock,
                    'is_featured' => $product->is_featured,
                    'lowest_price' => $firstVariantPrice ?? $product->price,
                    'image' => $firstImage,
                    'category' => optional($product->category)->only(['id', 'name', 'slug']),
                    'occasion' => optional($product->occasion)->only(['id', 'name', 'slug']),
                    // Include variants for frontend use
                    'variants' => $variantsData,
                    // Also include images if needed
                    'images' => $firstImage ? [['image' => $firstImage]] : [],
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $processedProducts,
                'filters_applied' => [
                    'search' => $request->input('search'),
                    'category_slug' => $request->input('category_slug'),
                    'categories' => $request->input('categories'),
                    'occasion_slug' => $request->input('occasion_slug'),
                    'occasions' => $request->input('occasions'),
                    'color' => $request->input('color'),
                    'colors' => $request->input('colors'),
                    'size' => $request->input('size'),
                    'sizes' => $request->input('sizes'),
                    'price_range' => $request->input('price_range'),
                    'price_ranges' => $request->input('price_ranges'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error filtering products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Search products by name or description
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchProducts(Request $request): JsonResponse
    {
        try {
            $searchTerm = $request->input('search');

            if (empty($searchTerm)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search term is required',
                    'data' => null
                ], 400);
            }

            // $query = Product::where('is_active', 1)
            //     ->where(function ($q) use ($searchTerm) {
            //         $q->where('name', 'LIKE', '%' . $searchTerm . '%')
            //             ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
            //             ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
            //             ->orWhere('design_no', 'LIKE', '%' . $searchTerm . '%');
            //     })


            //     ->with(['variants', 'category', 'occasion']);

            $query = Product::where('is_active', 1)
                ->where('products.ready_to_ship', 1)
                ->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('design_no', 'LIKE', '%' . $searchTerm . '%')

                        // Search in category name
                        ->orWhereHas('category', function ($cat) use ($searchTerm) {
                            $cat->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })

                        // Search in occasion name
                        ->orWhereHas('occasion', function ($occ) use ($searchTerm) {
                            $occ->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })

                        // Search by occasion ID (if search term is numeric)
                        ->orWhere('ocassion_id', $searchTerm);
                })
                ->with(['variants', 'category', 'occasion']);

            // Get products
            $products = $query->get();

            // Process products to get essential data
            $processedProducts = $products->map(function ($product) {
                $variants = $product->variants;

                // Get lowest price from variants
                $lowestPrice = null;
                if ($variants->isNotEmpty()) {
                    $lowestPrice = $variants->min('price');
                }

                // Get first image
                $firstImage = null;
                $images = \App\Models\ProductImage::where('product_id', $product->id)->first();
                if ($images) {
                    $firstImage = $images->image;
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'design_no' => $product->design_no,
                    'brand' => $product->brand,
                    'fabric' => $product->fabric,
                    'fit' => $product->fit,
                    'price' => $product->price,
                    'discount_price' => $product->discount_price,
                    'stock' => $product->stock,
                    'is_featured' => $product->is_featured,
                    'lowest_price' => $lowestPrice,
                    'image' => $firstImage,
                    'category' => optional($product->category)->only(['id', 'name', 'slug']),
                    'occasion' => optional($product->occasion)->only(['id', 'name', 'slug']),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $processedProducts,
                'search_term' => $searchTerm,
                'total_results' => $processedProducts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getLatestProductUsingProductSlug($productSlug): JsonResponse
    {
        try {
            // Get the current product by slug
            $currentProduct = Product::where('slug', $productSlug)
                ->where('status', 'active')
                ->first();

            if (!$currentProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'data' => null
                ], 404);
            }

            // Get latest 10 products from the same category
            $latestProducts = Product::where('category_id', $currentProduct->category_id)
                ->where('status', 'active')
                ->where('id', '!=', $currentProduct->id) // Exclude current product
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $latestProducts,
                'current_product' => $currentProduct,
                'total_results' => $latestProducts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getShippedProducts(): JsonResponse
    {
        try {
            $shippedProducts = Order::where('order_status', 'shipped')
                ->with(['orderProducts', 'variants'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $shippedProducts,
                'total_results' => $shippedProducts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching shipped products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getDeliveredProducts(): JsonResponse
    {
        try {
            $deliveredProducts = Order::where('order_status', 'delivered')
                ->with(['orderProducts', 'variants'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $deliveredProducts,
                'total_results' => $deliveredProducts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching delivered products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getCancelledProducts(): JsonResponse
    {
        try {
            $cancelledProducts = Order::where('order_status', 'cancelled')
                ->with(['orderProducts', 'variants'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $cancelledProducts,
                'total_results' => $cancelledProducts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cancelled products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
