<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
            $query = Product::where('is_active', 1)
                ->where('products.ready_to_ship', 1)
                ->with(['variants', 'category', 'occasion']);

            // Filter by category slug
            if ($request->filled('category_slug')) {
                $categorySlug = $request->input('category_slug');

                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            // Filter by occasion slug
            if ($request->filled('occasion_slug')) {
                $occasionSlug = $request->input('occasion_slug');

                $query->whereHas('occasion', function ($q) use ($occasionSlug) {
                    $q->where('slug', $occasionSlug);
                });
            }

            // Filter by color
            if ($request->filled('color')) {
                $color = $request->input('color');
                $query->whereHas('variants', function ($q) use ($color) {
                    $q->where('color', $color);
                });
            }

            // Filter by size
            if ($request->filled('size')) {
                $size = $request->input('size');
                $query->whereHas('variants', function ($q) use ($size) {
                    $q->where('size', $size);
                });
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

            $products = $query->get();

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
                    'category_slug' => $request->input('category_slug'),
                    'occasion_slug' => $request->input('occasion_slug'),
                    'color' => $request->input('color'),
                    'size' => $request->input('size'),
                    'price_range' => $request->input('price_range'),
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
}
