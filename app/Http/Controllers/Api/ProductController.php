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

    /**
     * Filter products with multiple criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function filterProducts(Request $request): JsonResponse
    // {
    //     try {
    //         $query = Product::where('is_active', 1)
    //             ->with(['variants', 'category', 'occasion']);

    //         // Filter by category
    //         if ($request->filled('category_id')) {
    //             $categoryId = $request->input('category_id');
    //             $query->where('category_id', $categoryId);
    //         }

    //         // Filter by occasion
    //         if ($request->filled('occasion_id')) {
    //             $occasionId = $request->input('occasion_id');
    //             $query->where('occasion_id', $occasionId);
    //         }

    //         // Filter by color
    //         if ($request->filled('color')) {
    //             $color = $request->input('color');
    //             $query->whereHas('variants', function($q) use ($color) {
    //                 $q->where('color', $color);
    //             });
    //         }

    //         // Filter by size
    //         if ($request->filled('size')) {
    //             $size = $request->input('size');
    //             $query->whereHas('variants', function($q) use ($size) {
    //                 $q->where('size', $size);
    //             });
    //         }

    //         // Filter by price range (format: "100-500")
    //         if ($request->filled('price_range')) {
    //             $priceRange = $request->input('price_range');
    //             if (strpos($priceRange, '-') !== false) {
    //                 [$minPrice, $maxPrice] = explode('-', $priceRange);
    //                 if (is_numeric($minPrice)) {
    //                     $query->whereHas('variants', function($q) use ($minPrice) {
    //                         $q->where('price', '>=', $minPrice);
    //                     });
    //                 }
    //                 if (is_numeric($maxPrice)) {
    //                     $query->whereHas('variants', function($q) use ($maxPrice) {
    //                         $q->where('price', '<=', $maxPrice);
    //                     });
    //                 }
    //             }
    //         }

    //         // Get products
    //         $products = $query->get();

    //         // Process products to get essential data
    //         $processedProducts = $products->map(function ($product) {
    //             $variants = $product->variants;

    //             // Get lowest price from variants
    //             $lowestPrice = null;
    //             if ($variants->isNotEmpty()) {
    //                 $lowestPrice = $variants->min('price');
    //             }

    //             // Get first image (simplified - just get first image)
    //             $firstImage = null;
    //             $images = \App\Models\ProductImage::where('product_id', $product->id)->first();
    //             if ($images) {
    //                 $firstImage = $images->image;
    //             }

    //             return [
    //                 'id' => $product->id,
    //                 'name' => $product->name,
    //                 'slug' => $product->slug,
    //                 'description' => $product->description,
    //                 'design_no' => $product->design_no,
    //                 'brand' => $product->brand,
    //                 'fabric' => $product->fabric,
    //                 'fit' => $product->fit,
    //                 'price' => $product->price,
    //                 'discount_price' => $product->discount_price,
    //                 'stock' => $product->stock,
    //                 'is_featured' => $product->is_featured,
    //                 'lowest_price' => $lowestPrice,
    //                 'image' => $firstImage,
    //                 'category' => $product->category ? [
    //                     'id' => $product->category->id,
    //                     'name' => $product->category->name,
    //                     'slug' => $product->category->slug
    //                 ] : null,
    //                 'occasion' => $product->occasion ? [
    //                     'id' => $product->occasion->id,
    //                     'name' => $product->occasion->name,
    //                     'slug' => $product->occasion->slug
    //                 ] : null
    //             ];
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'data' => $processedProducts,
    //             'filters_applied' => [
    //                 'category_id' => $request->input('category_id'),
    //                 'occasion_id' => $request->input('occasion_id'),
    //                 'color' => $request->input('color'),
    //                 'size' => $request->input('size'),
    //                 'price_range' => $request->input('price_range'),
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error filtering products: ' . $e->getMessage(),
    //             'data' => null
    //         ], 500);
    //     }
    // }
    public function filterProducts(Request $request): JsonResponse
    {
        try {
            if($request->search == 'offers' || $request->search == 'offer' ){
                
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
    
                
            }else{
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
                        // Search in category name
                        ->orWhereHas('category', function ($cat) use ($searchTerm) {
                            $cat->where('name', 'LIKE', '%' . $searchTerm . '%');
                        })
                        // Search in occasion name
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
                            $q->where('price', '>=', $minPrice);
                        }
                        if (is_numeric($maxPrice)) {
                            $q->where('price', '<=', $maxPrice);
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
                                            $orQ->where('price', '>=', $minPrice);
                                        }
                                        if (is_numeric($maxPrice)) {
                                            $orQ->where('price', '<=', $maxPrice);
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
                    // Order by total quantity sold across all orders
                    $query->withCount(['orderProducts as total_sold' => function ($query) {
                        $query->selectRaw('SUM(quantity)');
                    }])
                        ->orderBy('total_sold', 'desc');
                } elseif ($filterValue == 'new-arrival') {
                    // Order by created_at (newest first)
                    $query->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'featured') {
                    // Order by featured products
                    $query->where('is_featured', true)->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'top-rated') {
                    // Order by rating (if you have rating field) or by created_at as fallback
                    $query->orderBy('created_at', 'desc');
                }
            }

            $products = $query->paginate(12);

            $processedProducts = $products->map(function ($product) {

                $lowestPrice = $product->variants->min('price');

                $firstImage = optional(
                    \App\Models\ProductImage::where('product_id', $product->id)->first()
                )->image;

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
