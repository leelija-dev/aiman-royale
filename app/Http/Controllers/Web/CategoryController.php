<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Occasion;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products for a specific category.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    // public function show($slug)
    // {
    //     $category = Category::where('slug', $slug)
    //         ->where('is_active', 1)
    //         ->firstOrFail();

    //     $products = $category->products()
    //         ->where('is_active', 1)
    //         ->whereHas('variants') // Only include products that have variants
    //         ->with(['images' => function($query) {
    //             $query->select('product_id', 'image');
    //         }])
    //         ->select('products.*')
    //         ->latest()
    //         ->paginate(12);

    //     $occasions = Occasion::where('is_active', 1)->get();

    //     return view('web.category_product', compact('category', 'products', 'occasions'));
    // }

    public function show($slug)
    {
        $categoryExist = Category::where('slug', $slug)->first();
        if ($categoryExist) {

            $category = Category::where('slug', $slug)
                ->where('is_active', 1)
                ->firstOrFail();
        } else {
            $category = $categoryExist;
            $product = '';
            $priceRanges = '';
            $priceRange = [
                'min' => '',
                'max' => '',
            ];
            return view('web.category_product', compact('category', 'product', 'priceRanges', 'priceRange'));
        }
        // Get products from current category and its child categories if it's a parent
        $categoryIds = [$category->id];

        // If this is a parent category, get all child category IDs
        if ($category->parent_id == null) {
            $childCategories = Category::where('parent_id', $category->id)
                ->where('is_active', 1)
                ->pluck('id')
                ->toArray();
            $categoryIds = array_merge($categoryIds, $childCategories);
        }

        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', 1)
            ->whereHas('variants') // Only include products that have variants
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image');
            }, 'variants' => function ($query) {
                $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
            }])
            ->select('products.*')
            ->latest()
            ->paginate(12);

        $occasions = Occasion::where('is_active', 1)->get();

        // Get all available sizes from variants (including child categories)
        $allVariants = \App\Models\ProductVariant::whereHas('product', function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)->where('is_active', 1);
        })->get();

        // Get unique sizes (handle both string and potential JSON)
        $sizes = $allVariants->pluck('size')
            ->filter()
            ->map(function ($size) {
                // If size is JSON, decode it
                if (is_string($size) && $this->isJson($size)) {
                    return json_decode($size, true);
                }
                return $size;
            })
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Get unique colors (handle both string and potential JSON)
        $colors = $allVariants->pluck('color')
            ->filter()
            ->map(function ($color) {
                // If color is JSON, decode it
                if (is_string($color) && $this->isJson($color)) {
                    return json_decode($color, true);
                }
                return $color;
            })
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Get price range
        $priceRange = [
            'min' => $allVariants->min('discount_price') ?? $allVariants->min('price') ?? 0,
            'max' => $allVariants->max('price') ?? 10000
        ];

        // Calculate dynamic price ranges based on actual product data
        $priceRanges = $this->calculateDynamicPriceRanges($priceRange['min'], $priceRange['max']);

        return view('web.category_product', compact('category', 'products', 'occasions', 'sizes', 'colors', 'priceRange', 'priceRanges'));
    }

    // Helper function to check if string is JSON
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Calculate dynamic price ranges based on actual product data
     */
    private function calculateDynamicPriceRanges($minPrice, $maxPrice)
    {
        $range = $maxPrice - $minPrice;
        $rangeSize = $range / 5;

        $ranges = [];

        for ($i = 0; $i < 5; $i++) {
            $rangeMin = $minPrice + ($i * $rangeSize);
            $rangeMax = ($i == 4) ? $maxPrice : $minPrice + (($i + 1) * $rangeSize);

            $ranges[] = [
                'min' => $rangeMin,
                'max' => $rangeMax,
                'label' => '₹' . number_format($rangeMin) . ' - ₹' . number_format($rangeMax),
                'value' => $rangeMin . '-' . $rangeMax
            ];
        }

        return $ranges;
    }

    public function collection()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('web.collection', compact('categories'));
    }
    // public function filter($slug, Request $request)
    // {

    //     $category = Category::where('slug', $slug)
    //         ->where('is_active', 1)
    //         ->firstOrFail();

    //     // Get products from current category and its child categories if it's a parent
    //     $categoryIds = [$category->id];

    //     // If this is a parent category, get all child category IDs
    //     if ($category->parent_id == null) {
    //         $childCategories = Category::where('parent_id', $category->id)
    //             ->where('is_active', 1)
    //             ->pluck('id')
    //             ->toArray();
    //         $categoryIds = array_merge($categoryIds, $childCategories);
    //     }

    //     $query = Product::whereIn('category_id', $categoryIds)
    //         ->where('is_active', 1)
    //         ->whereHas('variants')
    //         ->with(['images' => function ($query) {
    //             $query->select('product_id', 'image');
    //         }, 'variants' => function ($query) {
    //             $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
    //         }])
    //         ->select('products.*');

    //     // Apply price range filters (checkboxes) - now handles dynamic ranges
    //     if ($request->filled('price_ranges')) {
    //         $priceRanges = json_decode($request->price_ranges);

    //         if (!empty($priceRanges)) {
    //             $query->whereHas('variants', function ($q) use ($priceRanges) {
    //                 $q->where(function ($subQ) use ($priceRanges) {
    //                     foreach ($priceRanges as $range) {
    //                         // Handle dynamic range format (min-max)
    //                         if (strpos($range, '-') !== false) {
    //                             list($min, $max) = explode('-', $range);
    //                             $subQ->orWhere(function ($orQ) use ($min, $max) {
    //                                 $orQ->whereBetween('discount_price', [$min, $max])
    //                                     ->orWhere(function ($q) use ($min, $max) {
    //                                         $q->whereNull('discount_price')
    //                                             ->whereBetween('price', [$min, $max]);
    //                                     });
    //                             });
    //                         } else {
    //                             // Fallback for old hardcoded ranges
    //                             switch ($range) {
    //                                 case 'below-200':
    //                                     $subQ->orWhere(function ($orQ) {
    //                                         $orQ->where('discount_price', '<', 200)
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->where('price', '<', 200);
    //                                             });
    //                                     });
    //                                     break;
    //                                 case '200-300':
    //                                     $subQ->orWhere(function ($orQ) use ($range) {
    //                                         $orQ->whereBetween('discount_price', [200, 300])
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->whereBetween('price', [200, 300]);
    //                                             });
    //                                     });
    //                                     break;
    //                                 case '300-400':
    //                                     $subQ->orWhere(function ($orQ) use ($range) {
    //                                         $orQ->whereBetween('discount_price', [300, 400])
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->whereBetween('price', [300, 400]);
    //                                             });
    //                                     });
    //                                     break;
    //                                 case '400-500':
    //                                     $subQ->orWhere(function ($orQ) use ($range) {
    //                                         $orQ->whereBetween('discount_price', [400, 500])
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->whereBetween('price', [400, 500]);
    //                                             });
    //                                     });
    //                                     break;
    //                                 case '500-600':
    //                                     $subQ->orWhere(function ($orQ) use ($range) {
    //                                         $orQ->whereBetween('discount_price', [500, 600])
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->whereBetween('price', [500, 600]);
    //                                             });
    //                                     });
    //                                     break;
    //                                 case '600-above':
    //                                     $subQ->orWhere(function ($orQ) {
    //                                         $orQ->where('discount_price', '>=', 600)
    //                                             ->orWhere(function ($q) {
    //                                                 $q->whereNull('discount_price')
    //                                                     ->where('price', '>=', 600);
    //                                             });
    //                                     });
    //                                     break;
    //                             }
    //                         }
    //                     }
    //                 });
    //             });
    //         }
    //     }

    //     // Apply custom price range (slider)
    //     if ($request->has('custom_min_price') && $request->has('custom_max_price')) {
    //         $query->whereHas('variants', function ($q) use ($request) {
    //             $q->where(function ($subQ) use ($request) {
    //                 $subQ->whereBetween('discount_price', [$request->custom_min_price, $request->custom_max_price])
    //                     ->orWhere(function ($orQ) use ($request) {
    //                         $orQ->whereNull('discount_price')
    //                             ->whereBetween('price', [$request->custom_min_price, $request->custom_max_price]);
    //                     });
    //             });
    //         });
    //     }

    //     // Apply size filter
    //     if ($request->filled('sizes')) {
    //         $sizes = json_decode($request->sizes);
    //         if (!empty($sizes)) {
    //             $query->whereHas('variants', function ($q) use ($sizes) {
    //                 $q->whereIn('size', $sizes);
    //             });
    //         }
    //     }

    //     // Apply color filter
    //     if ($request->filled('colors')) {
    //         $colors = json_decode($request->colors);
    //         if (!empty($colors)) {
    //             $query->whereHas('variants', function ($q) use ($colors) {
    //                 $q->whereIn('color', $colors);
    //             });
    //         }
    //     }

    //     // Apply occasion filter
    //     if ($request->filled('occasions')) {
    //         $occasions = json_decode($request->occasions);

    //         if (!empty($occasions)) {
    //             $query->whereHas('occasion', function ($q) use ($occasions) {
    //                 $q->whereIn('id', $occasions);
    //             });
    //         }
    //     }

    //     // Apply filter (featured, best-seller, new-arrival, top-rated)
    //     if ($request->filled('filter')) {
    //         $filterValue = $request->input('filter');
    //         if ($filterValue == 'best-seller') {
    //             // Order by total quantity sold across all orders
    //             $query->withCount(['orderProducts as total_sold' => function ($query) {
    //                 $query->selectRaw('SUM(quantity)');
    //             }])
    //                 ->orderBy('total_sold', 'desc');
    //         } elseif ($filterValue == 'new-arrival') {
    //             // Order by created_at (newest first)
    //             $query->orderBy('created_at', 'desc');
    //         } elseif ($filterValue == 'featured') {
    //             // Order by featured products
    //             $query->where('is_featured', true)->orderBy('created_at', 'desc');
    //         } elseif ($filterValue == 'top-rated') {
    //             // Order by rating (if you have rating field) or by created_at as fallback
    //             $query->orderBy('created_at', 'desc');
    //         }
    //     }

    //     // Apply collection filter
    //     if ($request->filled('collection')) {
    //         $collection = $request->input('collection');
    //         // You may need to adjust this based on your collection logic
    //         // This assumes you have a collection field or relationship
    //         if ($collection == 'spring-2024') {
    //             $query->where('collection', 'Spring 2024');
    //         } elseif ($collection == 'summer-essentials') {
    //             $query->where('collection', 'Summer Essentials');
    //         } elseif ($collection == 'limited-edition') {
    //             $query->where('collection', 'Limited Edition');
    //         } elseif ($collection == 'winter-collection') {
    //             $query->where('collection', 'Winter Collection');
    //         }
    //         // 'all-collections' doesn't need filtering as it shows all
    //     }

    //     // Apply sort
    //     if ($request->filled('sort')) {
    //         $sortValue = $request->input('sort');
    //         if ($sortValue == 'name-asc') {
    //             $query->orderBy('name', 'asc');
    //         } elseif ($sortValue == 'name-desc') {
    //             $query->orderBy('name', 'desc');
    //         } elseif ($sortValue == 'date-desc') {
    //             $query->orderBy('created_at', 'desc');
    //         } elseif ($sortValue == 'date-asc') {
    //             $query->orderBy('created_at', 'asc');
    //         } elseif ($sortValue == 'price-asc') {
    //             $query->orderBy('price', 'asc');
    //         } elseif ($sortValue == 'price-desc') {
    //             $query->orderBy('price', 'desc');
    //         }
    //     }

    //     // Apply default ordering if no specific sort is applied
    //     if (!$request->filled('sort') && !$request->filled('filter')) {
    //         $query->latest();
    //     }

    //     $products = $query->paginate(12);

    //     if ($request->ajax()) {
    //         $html = view('web.partials.category-grid', compact('products'))->render();

    //         return response()->json([
    //             'success' => true,
    //             'html' => $html,
    //             'total' => $products->total(),
    //             'firstItem' => $products->firstItem(),
    //             'lastItem' => $products->lastItem()
    //         ]);
    //     }

    //     return redirect()->route('category.show', $slug);
    // }

    public function filter($slug, Request $request)
    {
        // ============================================
        // 1. LOG START OF REQUEST
        // ============================================
        \Log::info('=== FILTER REQUEST STARTED ===');
        \Log::info('Category Slug: ' . $slug);
        \Log::info('Request URL: ' . $request->fullUrl());
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Is AJAX: ' . ($request->ajax() ? 'Yes' : 'No'));
        \Log::info('All Request Data:', $request->all());

        try {
            // ============================================
            // 2. LOG FILTER PARAMETERS
            // ============================================
            $filterParams = [
                'price_ranges' => $request->price_ranges,
                'custom_min_price' => $request->custom_min_price,
                'custom_max_price' => $request->custom_max_price,
                'sizes' => $request->sizes,
                'colors' => $request->colors,
                'occasions' => $request->occasions,
                'filter' => $request->filter,
                'collection' => $request->collection,
                'sort' => $request->sort
            ];
            \Log::info('Filter Parameters:', $filterParams);

            // ============================================
            // 3. GET CATEGORY
            // ============================================
            \Log::info('Fetching category...');
            $category = Category::where('slug', $slug)
                ->where('is_active', 1)
                ->firstOrFail();
            \Log::info('Category found:', [
                'id' => $category->id,
                'name' => $category->name,
                'parent_id' => $category->parent_id
            ]);

            // ============================================
            // 4. GET CATEGORY IDS (including children)
            // ============================================
            $categoryIds = [$category->id];
            \Log::info('Initial category IDs:', $categoryIds);

            if ($category->parent_id == null) {
                $childCategories = Category::where('parent_id', $category->id)
                    ->where('is_active', 1)
                    ->pluck('id')
                    ->toArray();
                \Log::info('Child categories found:', $childCategories);
                $categoryIds = array_merge($categoryIds, $childCategories);
            }
            \Log::info('Final category IDs for query:', $categoryIds);

            // ============================================
            // 5. BUILD BASE QUERY
            // ============================================
            \Log::info('Building base query...');
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

            // Log the base SQL without filters
            \Log::info('Base Query SQL (without filters): ' . $query->toSql());
            \Log::info('Base Query Bindings: ' . json_encode($query->getBindings()));

            // ============================================
            // 6. APPLY PRICE RANGE FILTERS
            // ============================================
            if ($request->filled('price_ranges')) {
                \Log::info('=== APPLYING PRICE RANGE FILTER ===');
                $priceRanges = json_decode($request->price_ranges, true);
                \Log::info('Price ranges (decoded):', $priceRanges);

                if (!empty($priceRanges)) {
                    $query->whereHas('variants', function ($q) use ($priceRanges) {
                        $q->where(function ($subQ) use ($priceRanges) {
                            foreach ($priceRanges as $range) {
                                \Log::info('Processing price range: ' . $range);

                                if (strpos($range, '-') !== false) {
                                    list($min, $max) = explode('-', $range);
                                    \Log::info('Dynamic range - min: ' . $min . ', max: ' . $max);

                                    $subQ->orWhere(function ($orQ) use ($min, $max) {
                                        $orQ->whereBetween('discount_price', [(float)$min, (float)$max])
                                            ->orWhere(function ($q) use ($min, $max) {
                                                $q->whereNull('discount_price')
                                                    ->whereBetween('price', [(float)$min, (float)$max]);
                                            });
                                    });
                                } else {
                                    \Log::info('Applying predefined range: ' . $range);
                                    $this->applyPredefinedPriceRange($subQ, $range);
                                }
                            }
                        });
                    });
                    \Log::info('Price filter applied successfully');
                } else {
                    \Log::warning('Price ranges array is empty after decoding');
                }
            } else {
                \Log::info('No price_ranges parameter found');
            }

            // ============================================
            // 7. APPLY CUSTOM PRICE RANGE (SLIDER)
            // ============================================
            if ($request->has('custom_min_price') && $request->has('custom_max_price')) {
                \Log::info('=== APPLYING CUSTOM PRICE RANGE ===');
                $minPrice = (float)$request->custom_min_price;
                $maxPrice = (float)$request->custom_max_price;
                \Log::info('Custom price range - min: ' . $minPrice . ', max: ' . $maxPrice);

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
                    \Log::info('Custom price filter applied successfully');
                } else {
                    \Log::info('Custom price filter skipped - using default values');
                }
            } else {
                \Log::info('No custom price parameters found');
            }

            // ============================================
            // 8. APPLY SIZE FILTER
            // ============================================
            if ($request->filled('sizes')) {
                \Log::info('=== APPLYING SIZE FILTER ===');
                $sizes = json_decode($request->sizes, true);
                \Log::info('Sizes (decoded):', $sizes);

                if (!empty($sizes)) {
                    $query->whereHas('variants', function ($q) use ($sizes) {
                        $q->whereIn('size', $sizes);
                    });
                    \Log::info('Size filter applied successfully');
                } else {
                    \Log::warning('Sizes array is empty after decoding');
                }
            } else {
                \Log::info('No sizes parameter found');
            }

            // ============================================
            // 9. APPLY COLOR FILTER
            // ============================================
            if ($request->filled('colors')) {
                \Log::info('=== APPLYING COLOR FILTER ===');
                $colors = json_decode($request->colors, true);
                \Log::info('Colors (decoded):', $colors);

                if (!empty($colors)) {
                    $query->whereHas('variants', function ($q) use ($colors) {
                        $q->whereIn('color', $colors);
                    });
                    \Log::info('Color filter applied successfully');
                } else {
                    \Log::warning('Colors array is empty after decoding');
                }
            } else {
                \Log::info('No colors parameter found');
            }

            // ============================================
            // 10. APPLY OCCASION FILTER
            // ============================================
            if ($request->filled('occasions')) {
                \Log::info('=== APPLYING OCCASION FILTER ===');
                $occasions = json_decode($request->occasions, true);
                \Log::info('Occasions (decoded):', $occasions);

                if (!empty($occasions)) {
                    $query->whereHas('occasion', function ($q) use ($occasions) {
                        $q->whereIn('id', $occasions);
                    });
                    \Log::info('Occasion filter applied successfully');
                } else {
                    \Log::warning('Occasions array is empty after decoding');
                }
            } else {
                \Log::info('No occasions parameter found');
            }

            // ============================================
            // 11. APPLY FILTER (Featured, Best-Seller, etc)
            // ============================================
            if ($request->filled('filter')) {
                $filterValue = $request->input('filter');
                \Log::info('=== APPLYING FILTER: ' . $filterValue . ' ===');

                if ($filterValue == 'best-seller') {
                    \Log::info('Applying Best Seller filter');
                    try {
                        $query->withCount(['orderProducts as total_sold' => function ($query) {
                            $query->selectRaw('COALESCE(SUM(quantity), 0)');
                        }])
                            ->orderBy('total_sold', 'desc');
                        \Log::info('Best Seller filter applied successfully');
                    } catch (\Exception $e) {
                        \Log::warning('orderProducts relationship not found: ' . $e->getMessage());
                        $query->orderBy('created_at', 'desc');
                    }
                } elseif ($filterValue == 'new-arrival') {
                    \Log::info('Applying New Arrival filter (order by created_at DESC)');
                    $query->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'featured') {
                    \Log::info('Applying Featured filter');
                    $query->where('is_featured', 1)->orderBy('created_at', 'desc');
                } elseif ($filterValue == 'top-rated') {
                    \Log::info('Applying Top Rated filter');
                    $query->orderBy('created_at', 'desc');
                } else {
                    \Log::warning('Unknown filter value: ' . $filterValue);
                }
            } else {
                \Log::info('No filter parameter found');
            }

            // ============================================
            // 12. APPLY COLLECTION FILTER
            // ============================================
            if ($request->filled('collection') && $request->input('collection') != 'all') {
                $collectionValue = $request->input('collection');
                \Log::info('=== APPLYING COLLECTION FILTER: ' . $collectionValue . ' ===');

                if (\Schema::hasColumn('products', 'collection')) {
                    \Log::info('Collection column exists in products table');
                    $query->where('collection', $collectionValue);
                    \Log::info('Collection filter applied using column');
                } else {
                    \Log::warning('Collection column does not exist in products table');
                    // Try relationship if exists
                    try {
                        $query->whereHas('collections', function ($q) use ($collectionValue) {
                            $q->where('slug', $collectionValue);
                        });
                        \Log::info('Collection filter applied using relationship');
                    } catch (\Exception $e) {
                        \Log::warning('Collections relationship not found: ' . $e->getMessage());
                    }
                }
            } else {
                \Log::info('Collection parameter: ' . ($request->filled('collection') ? $request->input('collection') : 'not found'));
            }

            // ============================================
            // 13. APPLY SORT
            // ============================================
            if ($request->filled('sort')) {
                $sortValue = $request->input('sort');
                \Log::info('=== APPLYING SORT: ' . $sortValue . ' ===');

                if (in_array($sortValue, ['price-asc', 'price-desc'])) {
                    \Log::info('Sorting by price (variant price)');
                    $query->leftJoin('product_variants', function ($join) use ($query) {
                        $join->on('products.id', '=', 'product_variants.product_id')
                            ->whereNull('product_variants.deleted_at');
                    })
                        ->select('products.*', \DB::raw('MIN(COALESCE(product_variants.discount_price, product_variants.price)) as min_price'))
                        ->groupBy('products.id')
                        ->orderBy('min_price', $sortValue == 'price-asc' ? 'asc' : 'desc');
                    \Log::info('Price sort applied successfully');
                } else {
                    switch ($sortValue) {
                        case 'name-asc':
                            $query->orderBy('name', 'asc');
                            \Log::info('Sort by name ASC');
                            break;
                        case 'name-desc':
                            $query->orderBy('name', 'desc');
                            \Log::info('Sort by name DESC');
                            break;
                        case 'date-desc':
                            $query->orderBy('created_at', 'desc');
                            \Log::info('Sort by date DESC');
                            break;
                        case 'date-asc':
                            $query->orderBy('created_at', 'asc');
                            \Log::info('Sort by date ASC');
                            break;
                        default:
                            $query->latest();
                            \Log::info('Default sort - latest');
                            break;
                    }
                }
            } else {
                \Log::info('No sort parameter found, using default');
                if (!$request->filled('filter')) {
                    $query->latest();
                }
            }

            // ============================================
            // 14. LOG FINAL QUERY BEFORE EXECUTION
            // ============================================
            \Log::info('=== FINAL QUERY BEFORE EXECUTION ===');
            \Log::info('Final SQL: ' . $query->toSql());
            \Log::info('Final Bindings: ' . json_encode($query->getBindings()));

            // ============================================
            // 15. EXECUTE QUERY AND GET RESULTS
            // ============================================
            \Log::info('=== EXECUTING QUERY ===');
            try {
                $products = $query->paginate(12);
                \Log::info('Query executed successfully');
                \Log::info('Products found: ' . $products->total());
                \Log::info('Products count in current page: ' . $products->count());

                if ($products->isEmpty()) {
                    \Log::warning('No products found matching the filters');

                    // Log what filters might have caused empty result
                    \Log::info('Active filters that might cause empty result:', [
                        'price_ranges' => $request->price_ranges,
                        'custom_min_price' => $request->custom_min_price,
                        'custom_max_price' => $request->custom_max_price,
                        'sizes' => $request->sizes,
                        'colors' => $request->colors,
                        'occasions' => $request->occasions
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('=== QUERY EXECUTION FAILED ===');
                \Log::error('Error: ' . $e->getMessage());
                \Log::error('Error Code: ' . $e->getCode());
                \Log::error('Error Trace: ' . $e->getTraceAsString());
                \Log::error('SQL: ' . $query->toSql());
                \Log::error('Bindings: ' . json_encode($query->getBindings()));

                // Fallback query without complex joins
                \Log::info('Falling back to simplified query');
                $query = Product::whereIn('category_id', $categoryIds)
                    ->where('is_active', 1)
                    ->whereHas('variants')
                    ->with(['images', 'variants']);

                $products = $query->paginate(12);
                \Log::info('Fallback query executed, products found: ' . $products->total());
            }

            // ============================================
            // 16. RETURN RESPONSE
            // ============================================
            if ($request->ajax()) {
                \Log::info('=== RENDERING AJAX RESPONSE ===');
                try {
                    $html = view('web.partials.category-grid', compact('products'))->render();
                    \Log::info('View rendered successfully, HTML length: ' . strlen($html));

                    $response = [
                        'success' => true,
                        'html' => $html,
                        'total' => $products->total(),
                        'firstItem' => $products->firstItem(),
                        'lastItem' => $products->lastItem(),
                        'currentPage' => $products->currentPage(),
                        'lastPage' => $products->lastPage(),
                        'perPage' => $products->perPage()
                    ];
                    \Log::info('Response data:', $response);

                    return response()->json($response);
                } catch (\Exception $e) {
                    \Log::error('View rendering failed: ' . $e->getMessage());
                    \Log::error('View error trace: ' . $e->getTraceAsString());
                    return response()->json([
                        'success' => false,
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            \Log::info('=== FILTER REQUEST COMPLETED (Non-AJAX) ===');
            return redirect()->route('category.show', $slug);
        } catch (\Exception $e) {
            // ============================================
            // 17. CATCH AND LOG ANY EXCEPTIONS
            // ============================================
            \Log::error('=== FILTER REQUEST FAILED ===');
            \Log::error('Exception: ' . $e->getMessage());
            \Log::error('Exception Code: ' . $e->getCode());
            \Log::error('Exception File: ' . $e->getFile() . ':' . $e->getLine());
            \Log::error('Exception Trace: ' . $e->getTraceAsString());
            \Log::error('Request Data:', $request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }

            return back()->with('error', 'An error occurred while filtering products. Please try again.');
        }
    }

    /**
     * Helper function for predefined price ranges
     */
    private function applyPredefinedPriceRange($query, $range)
    {
        \Log::info('Applying predefined price range: ' . $range);

        switch ($range) {
            case 'below-200':
                $query->orWhere(function ($orQ) {
                    $orQ->where('discount_price', '<', 200)
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->where('price', '<', 200);
                        });
                });
                break;
            case '200-300':
                $query->orWhere(function ($orQ) {
                    $orQ->whereBetween('discount_price', [200, 300])
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->whereBetween('price', [200, 300]);
                        });
                });
                break;
            case '300-400':
                $query->orWhere(function ($orQ) {
                    $orQ->whereBetween('discount_price', [300, 400])
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->whereBetween('price', [300, 400]);
                        });
                });
                break;
            case '400-500':
                $query->orWhere(function ($orQ) {
                    $orQ->whereBetween('discount_price', [400, 500])
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->whereBetween('price', [400, 500]);
                        });
                });
                break;
            case '500-600':
                $query->orWhere(function ($orQ) {
                    $orQ->whereBetween('discount_price', [500, 600])
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->whereBetween('price', [500, 600]);
                        });
                });
                break;
            case '600-above':
                $query->orWhere(function ($orQ) {
                    $orQ->where('discount_price', '>=', 600)
                        ->orWhere(function ($q) {
                            $q->whereNull('discount_price')
                                ->where('price', '>=', 600);
                        });
                });
                break;
            default:
                \Log::warning('Unknown predefined price range: ' . $range);
                break;
        }
    }

    /**
     * Display products for a specific category filtered by occasion.
     *
     * @param string $categorySlug
     * @param string $occasionSlug
     * @return \Illuminate\View\View
     */
    public function showWithOccasion($categorySlug, $occasionSlug)
    {
        // dd($categorySlug);
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', 1)
            ->firstOrFail();

        $occasion = Occasion::where('slug', $occasionSlug)
            ->where('is_active', 1)
            ->firstOrFail();

        // Get products from current category and its child categories if it's a parent
        $categoryIds = [$category->id];

        // If this is a parent category, get all child category IDs
        if ($category->parent_id == null) {
            $childCategories = Category::where('parent_id', $category->id)
                ->where('is_active', 1)
                ->pluck('id')
                ->toArray();
            $categoryIds = array_merge($categoryIds, $childCategories);
        }

        // Get products using occasion_slug -> occasion_id -> product_occasions -> products -> category filtering
        $products = Product::whereIn('id', function ($query) use ($occasion) {
            $query->select('product_id')
                ->from('product_occasions')
                ->where('occasion_id', $occasion->id);
        })
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', 1)
            ->whereHas('variants')
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image');
            }, 'variants' => function ($query) {
                $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
            }])
            ->select('products.*')
            ->latest()
            ->paginate(12);

        $occasions = Occasion::where('is_active', 1)->get();

        // Get all available sizes from variants for this category (including child categories)
        $allVariants = \App\Models\ProductVariant::whereHas('product', function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)->where('is_active', 1);
        })->get();

        // Get unique sizes
        $sizes = $allVariants->pluck('size')
            ->filter()
            ->map(function ($size) {
                if (is_string($size) && $this->isJson($size)) {
                    return json_decode($size, true);
                }
                return $size;
            })
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Get unique colors
        $colors = $allVariants->pluck('color')
            ->filter()
            ->map(function ($color) {
                if (is_string($color) && $this->isJson($color)) {
                    return json_decode($color, true);
                }
                return $color;
            })
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Get price range
        $priceRange = [
            'min' => $allVariants->min('discount_price') ?? $allVariants->min('price') ?? 0,
            'max' => $allVariants->max('price') ?? 10000
        ];

        // Calculate dynamic price ranges based on actual product data
        $priceRanges = $this->calculateDynamicPriceRanges($priceRange['min'], $priceRange['max']);

        return view('web.category_product', compact('category', 'products', 'occasions', 'occasion', 'sizes', 'colors', 'priceRange', 'priceRanges'));
    }
}
