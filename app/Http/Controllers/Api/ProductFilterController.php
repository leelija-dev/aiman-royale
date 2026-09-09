<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductFilterController extends Controller
{
    /**
     * Filter products by category slug
     * 
     * @param string $slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function filter($slug, Request $request)
    // {
    //     try {
    //         // Validate request
    //         $validator = \Validator::make($request->all(), [
    //             'price_ranges' => 'sometimes|json',
    //             'custom_min_price' => 'sometimes|numeric|min:0',
    //             'custom_max_price' => 'sometimes|numeric|min:0|gte:custom_min_price',
    //             'sizes' => 'sometimes|json',
    //             'colors' => 'sometimes|json',
    //             'occasions' => 'sometimes|json',
    //             'filter' => 'sometimes|in:best-seller,new-arrival,featured,top-rated',
    //             'collection' => 'sometimes|string',
    //             'sort' => 'sometimes|in:price-asc,price-desc,name-asc,name-desc,date-desc,date-asc',
    //             'per_page' => 'sometimes|integer|min:1|max:100',
    //             'page' => 'sometimes|integer|min:1'
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'errors' => $validator->errors()
    //             ], 422);
    //         }

    //         // Get category
    //         $category = Category::where('slug', $slug)
    //             ->where('is_active', 1)
    //             ->firstOrFail();

    //         // Get category IDs (including children)
    //         $categoryIds = [$category->id];

    //         if ($category->parent_id == null) {
    //             $childCategories = Category::where('parent_id', $category->id)
    //                 ->where('is_active', 1)
    //                 ->pluck('id')
    //                 ->toArray();
    //             $categoryIds = array_merge($categoryIds, $childCategories);
    //         }

    //         // Build base query
    //         $query = Product::whereIn('category_id', $categoryIds)
    //             ->where('is_active', 1)
    //             ->whereHas('variants')
    //             ->with(['images' => function ($query) {
    //                 $query->select('product_id', 'image');
    //             }, 'variants' => function ($query) {
    //                 $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
    //             }])
    //             ->select('products.*')
    //             ->distinct();

    //         // Apply price range filters
    //         $this->applyPriceRangeFilters($query, $request);

    //         // Apply custom price range (slider)
    //         $this->applyCustomPriceRange($query, $request);

    //         // Apply size filter
    //         $this->applySizeFilter($query, $request);

    //         // Apply color filter
    //         $this->applyColorFilter($query, $request);

    //         // Apply occasion filter
    //         $this->applyOccasionFilter($query, $request);

    //         // Apply filter (featured, best-seller, new-arrival, top-rated)
    //         $this->applyFilterType($query, $request);

    //         // Apply collection filter
    //         $this->applyCollectionFilter($query, $request);

    //         // Apply sort
    //         $this->applySort($query, $request);

    //         // Get pagination parameters
    //         $perPage = $request->input('per_page', 12);

    //         // Execute query with pagination
    //         try {
    //             $products = $query->paginate($perPage);
    //         } catch (\Exception $e) {
    //             // Fallback query without complex joins
    //             $query = Product::whereIn('category_id', $categoryIds)
    //                 ->where('is_active', 1)
    //                 ->whereHas('variants')
    //                 ->with(['images', 'variants']);

    //             $products = $query->paginate($perPage);
    //         }

    //         // Get latest products for recommendations
    //         $latestProducts = Product::where('is_active', 1)
    //             ->whereHas('variants')
    //             ->with(['images' => function ($query) {
    //                 $query->select('product_id', 'image');
    //             }])
    //             ->select('products.*')
    //             ->latest()
    //             ->take(5)
    //             ->get();

    //         // Transform products for API response
    //         $transformedProducts = $this->transformProducts($products);

    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'products' => $transformedProducts,
    //                 'latest_products' => $this->transformProducts($latestProducts),
    //                 'pagination' => [
    //                     'total' => $products->total(),
    //                     'per_page' => $products->perPage(),
    //                     'current_page' => $products->currentPage(),
    //                     'last_page' => $products->lastPage(),
    //                     'from' => $products->firstItem(),
    //                     'to' => $products->lastItem(),
    //                     'path' => $products->path(),
    //                     'next_page_url' => $products->nextPageUrl(),
    //                     'prev_page_url' => $products->previousPageUrl()
    //                 ]
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function filter($slug, Request $request)
    {
        try {
            // Validate request
            $validator = \Validator::make($request->all(), [
                'price_ranges' => 'sometimes|json',
                'custom_min_price' => 'sometimes|numeric|min:0',
                'custom_max_price' => 'sometimes|numeric|min:0|gte:custom_min_price',
                'sizes' => 'sometimes|json',
                'colors' => 'sometimes|json',
                'occasions' => 'sometimes|json',
                'filter' => 'sometimes|in:best-seller,new-arrival,featured,top-rated',
                'collection' => 'sometimes|string',
                'sort' => 'sometimes|in:price-asc,price-desc,name-asc,name-desc,date-desc,date-asc'
                // 'per_page' and 'page' removed from validation
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get category
            $category = Category::where('slug', $slug)
                ->where('is_active', 1)
                ->firstOrFail();

            // Get category IDs (including children)
            $categoryIds = [$category->id];

            if ($category->parent_id == null) {
                $childCategories = Category::where('parent_id', $category->id)
                    ->where('is_active', 1)
                    ->pluck('id')
                    ->toArray();
                $categoryIds = array_merge($categoryIds, $childCategories);
            }

            // Build base query
            $query = Product::whereIn('category_id', $categoryIds)
                ->where('is_active', 1)
                ->whereHas('variants')
                ->with(['images' => function ($query) {
                    $query->select('product_id', 'image');
                }, 'variants' => function ($query) {
                    $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
                }])
                ->select('products.*')
                ->distinct();

            // Apply price range filters
            $this->applyPriceRangeFilters($query, $request);

            // Apply custom price range (slider)
            $this->applyCustomPriceRange($query, $request);

            // Apply size filter
            $this->applySizeFilter($query, $request);

            // Apply color filter
            $this->applyColorFilter($query, $request);

            // Apply occasion filter
            $this->applyOccasionFilter($query, $request);

            // Apply filter (featured, best-seller, new-arrival, top-rated)
            $this->applyFilterType($query, $request);

            // Apply collection filter
            $this->applyCollectionFilter($query, $request);

            // Apply sort
            $this->applySort($query, $request);

            // Execute query with NO pagination and NO limit - get ALL products
            try {
                $products = $query->get();
            } catch (\Exception $e) {
                // Fallback query without complex joins
                $query = Product::whereIn('category_id', $categoryIds)
                    ->where('is_active', 1)
                    ->whereHas('variants')
                    ->with(['images', 'variants']);

                $products = $query->get();
            }

            // Get latest products for recommendations
            $latestProducts = Product::where('is_active', 1)
                ->whereHas('variants')
                ->with(['images' => function ($query) {
                    $query->select('product_id', 'image');
                }])
                ->select('products.*')
                ->latest()
                ->take(5)
                ->get();

            // Transform products for API response
            $transformedProducts = $this->transformProducts($products);

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $transformedProducts,
                    'latest_products' => $this->transformProducts($latestProducts),
                    'total' => $products->count()
                    // No pagination data returned
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Transform products for API response
     */
    private function transformProducts($products)
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'title' => $product->title ?? $product->name,
                'description' => $product->description,
                'price' => $this->getProductPrice($product),
                'discount_price' => $this->getProductDiscountPrice($product),
                'stock' => $this->getTotalStock($product),
                'image' => $this->getProductImage($product),
                'images' => $product->images->map(function ($image) {
                    return '/img/' . $image->image;
                })->toArray(),
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'size' => $variant->size,
                        'color' => $variant->color,
                        'price' => $variant->price,
                        'discount_price' => $variant->discount_price,
                        'stock' => $variant->stock
                    ];
                })->toArray(),
                'is_featured' => (bool) $product->is_featured,
                'collection' => $product->collection ?? null,
                'created_at' => $product->created_at->toISOString(),
                'updated_at' => $product->updated_at->toISOString()
            ];
        });
    }

    /**
     * Get product main image
     */
    private function getProductImage($product)
    {
        if ($product->images && $product->images->isNotEmpty()) {
            return '/img/' . $product->images->first()->image;
        }
        return '/img/placeholder.jpg';
    }

    /**
     * Get product price
     */
    private function getProductPrice($product)
    {
        if ($product->variants && $product->variants->isNotEmpty()) {
            $prices = $product->variants->pluck('price')->filter();
            return $prices->isNotEmpty() ? $prices->min() : null;
        }
        return $product->price ?? null;
    }

    /**
     * Get product discount price
     */
    private function getProductDiscountPrice($product)
    {
        if ($product->variants && $product->variants->isNotEmpty()) {
            $prices = $product->variants->pluck('discount_price')->filter();
            return $prices->isNotEmpty() ? $prices->min() : null;
        }
        return $product->discount_price ?? null;
    }

    /**
     * Get total stock
     */
    private function getTotalStock($product)
    {
        if ($product->variants && $product->variants->isNotEmpty()) {
            return $product->variants->sum('stock');
        }
        return $product->stock ?? 0;
    }

    /**
     * Apply price range filters
     */
    private function applyPriceRangeFilters($query, Request $request)
    {
        if ($request->filled('price_ranges')) {
            $priceRanges = json_decode($request->price_ranges, true);

            if (!empty($priceRanges)) {
                $query->whereHas('variants', function ($q) use ($priceRanges) {
                    $q->where(function ($subQ) use ($priceRanges) {
                        foreach ($priceRanges as $range) {
                            if (strpos($range, '-') !== false) {
                                list($min, $max) = explode('-', $range);
                                $subQ->orWhere(function ($orQ) use ($min, $max) {
                                    $orQ->whereBetween('discount_price', [(float)$min, (float)$max])
                                        ->orWhere(function ($q) use ($min, $max) {
                                            $q->whereNull('discount_price')
                                                ->whereBetween('price', [(float)$min, (float)$max]);
                                        });
                                });
                            } else {
                                $this->applyPredefinedPriceRange($subQ, $range);
                            }
                        }
                    });
                });
            }
        }
    }

    /**
     * Apply custom price range
     */
    private function applyCustomPriceRange($query, Request $request)
    {
        if ($request->has('custom_min_price') && $request->has('custom_max_price')) {
            $minPrice = (float)$request->custom_min_price;
            $maxPrice = (float)$request->custom_max_price;

            if ($minPrice > 0 || $maxPrice < 10000) {
                $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                    $q->where(function ($subQ) use ($minPrice, $maxPrice) {
                        $subQ->whereBetween('discount_price', [$minPrice, $maxPrice])
                            ->orWhere(function ($orQ) use ($minPrice, $maxPrice) {
                                $orQ->whereNull('discount_price')
                                    ->whereBetween('price', [$minPrice, $maxPrice]);
                            });
                    });
                });
            }
        }
    }

    /**
     * Apply size filter
     */
    private function applySizeFilter($query, Request $request)
    {
        if ($request->filled('sizes')) {
            $sizes = json_decode($request->sizes, true);

            if (!empty($sizes)) {
                $sizes = array_map(function ($size) {
                    return strtoupper(trim($size));
                }, $sizes);

                $query->whereHas('variants', function ($q) use ($sizes) {
                    $q->whereIn('size', $sizes);
                });
            }
        }
    }

    /**
     * Apply color filter
     */
    private function applyColorFilter($query, Request $request)
    {
        if ($request->filled('colors')) {
            $colors = json_decode($request->colors, true);

            if (!empty($colors)) {
                $query->whereHas('variants', function ($q) use ($colors) {
                    $q->whereIn('color', $colors);
                });
            }
        }
    }

    /**
     * Apply occasion filter
     */
    private function applyOccasionFilter($query, Request $request)
    {
        if ($request->filled('occasions')) {
            $occasions = json_decode($request->occasions, true);

            if (!empty($occasions)) {
                $occasions = array_map('intval', $occasions);

                $query->whereHas('occasion', function ($q) use ($occasions) {
                    $q->whereIn('id', $occasions);
                });
            }
        }
    }

    /**
     * Apply filter type
     */
    private function applyFilterType($query, Request $request)
    {
        if ($request->filled('filter')) {
            $filterValue = $request->input('filter');

            if ($filterValue == 'best-seller') {
                try {
                    $query->withCount(['orderProducts as total_sold' => function ($query) {
                        $query->selectRaw('COALESCE(SUM(quantity), 0)');
                    }])
                        ->orderBy('total_sold', 'desc');
                } catch (\Exception $e) {
                    $query->orderBy('created_at', 'desc');
                }
            } elseif ($filterValue == 'new-arrival') {
                $query->orderBy('created_at', 'desc');
            } elseif ($filterValue == 'featured') {
                $query->where('is_featured', 1)->orderBy('created_at', 'desc');
            } elseif ($filterValue == 'top-rated') {
                $query->orderBy('created_at', 'desc');
            }
        }
    }

    /**
     * Apply collection filter
     */
    private function applyCollectionFilter($query, Request $request)
    {
        if ($request->filled('collection') && $request->input('collection') != 'all') {
            $collectionValue = $request->input('collection');

            if (Schema::hasColumn('products', 'collection')) {
                $query->where('collection', $collectionValue);
            } else {
                try {
                    $query->whereHas('collections', function ($q) use ($collectionValue) {
                        $q->where('slug', $collectionValue);
                    });
                } catch (\Exception $e) {
                    // Relationship doesn't exist, skip
                }
            }
        }
    }

    /**
     * Apply sort
     */
    private function applySort($query, Request $request)
    {
        if ($request->filled('sort')) {
            $sortValue = $request->input('sort');

            if (in_array($sortValue, ['price-asc', 'price-desc'])) {
                $query->leftJoin('product_variants', function ($join) {
                    $join->on('products.id', '=', 'product_variants.product_id')
                        ->whereNull('product_variants.deleted_at');
                })
                    ->select('products.*', DB::raw('MIN(COALESCE(product_variants.discount_price, product_variants.price)) as min_price'))
                    ->groupBy('products.id')
                    ->orderBy('min_price', $sortValue == 'price-asc' ? 'asc' : 'desc');
            } else {
                switch ($sortValue) {
                    case 'name-asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name-desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'date-desc':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'date-asc':
                        $query->orderBy('created_at', 'asc');
                        break;
                    default:
                        $query->latest();
                        break;
                }
            }
        } else {
            if (!$request->filled('filter')) {
                $query->latest();
            }
        }
    }

    /**
     * Apply predefined price ranges
     */
    private function applyPredefinedPriceRange($query, $range)
    {
        switch ($range) {
            case 'under-500':
                $query->orWhere(function ($q) {
                    $q->whereBetween('discount_price', [0, 500])
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->whereBetween('price', [0, 500]);
                        });
                });
                break;
            case '500-1000':
                $query->orWhere(function ($q) {
                    $q->whereBetween('discount_price', [500, 1000])
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->whereBetween('price', [500, 1000]);
                        });
                });
                break;
            case '1000-2000':
                $query->orWhere(function ($q) {
                    $q->whereBetween('discount_price', [1000, 2000])
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->whereBetween('price', [1000, 2000]);
                        });
                });
                break;
            case '2000-5000':
                $query->orWhere(function ($q) {
                    $q->whereBetween('discount_price', [2000, 5000])
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->whereBetween('price', [2000, 5000]);
                        });
                });
                break;
            case '5000-10000':
                $query->orWhere(function ($q) {
                    $q->whereBetween('discount_price', [5000, 10000])
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->whereBetween('price', [5000, 10000]);
                        });
                });
                break;
            case 'above-10000':
                $query->orWhere(function ($q) {
                    $q->where('discount_price', '>', 10000)
                        ->orWhere(function ($q2) {
                            $q2->whereNull('discount_price')
                                ->where('price', '>', 10000);
                        });
                });
                break;
        }
    }
}
