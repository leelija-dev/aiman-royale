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
        if($categoryExist){

        $category = Category::where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();
        }else{
            $category =$categoryExist;
            $product = '';
            $priceRanges ='';
            $priceRange=[
                'min'=>'',
                'max'=>'',
            ];
            return view('web.category_product', compact('category','product','priceRanges','priceRange'));
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
    public function filter($slug, Request $request)
    {
        $category = Category::where('slug', $slug)
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

        $query = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', 1)
            ->whereHas('variants')
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image');
            }, 'variants' => function ($query) {
                $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
            }])
            ->select('products.*');

        // Apply price range filters (checkboxes) - now handles dynamic ranges
        if ($request->filled('price_ranges')) {
            $priceRanges = json_decode($request->price_ranges);

            if (!empty($priceRanges)) {
                $query->whereHas('variants', function ($q) use ($priceRanges) {
                    $q->where(function ($subQ) use ($priceRanges) {
                        foreach ($priceRanges as $range) {
                            // Handle dynamic range format (min-max)
                            if (strpos($range, '-') !== false) {
                                list($min, $max) = explode('-', $range);
                                $subQ->orWhere(function ($orQ) use ($min, $max) {
                                    $orQ->whereBetween('discount_price', [$min, $max])
                                        ->orWhere(function ($q) use ($min, $max) {
                                            $q->whereNull('discount_price')
                                                ->whereBetween('price', [$min, $max]);
                                        });
                                });
                            } else {
                                // Fallback for old hardcoded ranges
                                switch ($range) {
                                    case 'below-200':
                                        $subQ->orWhere(function ($orQ) {
                                            $orQ->where('discount_price', '<', 200)
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->where('price', '<', 200);
                                                });
                                        });
                                        break;
                                    case '200-300':
                                        $subQ->orWhere(function ($orQ) use ($range) {
                                            $orQ->whereBetween('discount_price', [200, 300])
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->whereBetween('price', [200, 300]);
                                                });
                                        });
                                        break;
                                    case '300-400':
                                        $subQ->orWhere(function ($orQ) use ($range) {
                                            $orQ->whereBetween('discount_price', [300, 400])
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->whereBetween('price', [300, 400]);
                                                });
                                        });
                                        break;
                                    case '400-500':
                                        $subQ->orWhere(function ($orQ) use ($range) {
                                            $orQ->whereBetween('discount_price', [400, 500])
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->whereBetween('price', [400, 500]);
                                                });
                                        });
                                        break;
                                    case '500-600':
                                        $subQ->orWhere(function ($orQ) use ($range) {
                                            $orQ->whereBetween('discount_price', [500, 600])
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->whereBetween('price', [500, 600]);
                                                });
                                        });
                                        break;
                                    case '600-above':
                                        $subQ->orWhere(function ($orQ) {
                                            $orQ->where('discount_price', '>=', 600)
                                                ->orWhere(function ($q) {
                                                    $q->whereNull('discount_price')
                                                        ->where('price', '>=', 600);
                                                });
                                        });
                                        break;
                                }
                            }
                        }
                    });
                });
            }
        }

        // Apply custom price range (slider)
        if ($request->has('custom_min_price') && $request->has('custom_max_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where(function ($subQ) use ($request) {
                    $subQ->whereBetween('discount_price', [$request->custom_min_price, $request->custom_max_price])
                        ->orWhere(function ($orQ) use ($request) {
                            $orQ->whereNull('discount_price')
                                ->whereBetween('price', [$request->custom_min_price, $request->custom_max_price]);
                        });
                });
            });
        }

        // Apply size filter
        if ($request->filled('sizes')) {
            $sizes = json_decode($request->sizes);
            if (!empty($sizes)) {
                $query->whereHas('variants', function ($q) use ($sizes) {
                    $q->whereIn('size', $sizes);
                });
            }
        }

        // Apply color filter
        if ($request->filled('colors')) {
            $colors = json_decode($request->colors);
            if (!empty($colors)) {
                $query->whereHas('variants', function ($q) use ($colors) {
                    $q->whereIn('color', $colors);
                });
            }
        }

        // Apply occasion filter
        if ($request->filled('occasions')) {
            $occasions = json_decode($request->occasions);
            
            if (!empty($occasions)) {
                $query->whereHas('occasion', function ($q) use ($occasions) {
                    $q->whereIn('id', $occasions);
                });
            }
        }

        // Apply filter (featured, best-seller, new-arrival, top-rated)
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

        // Apply collection filter
        if ($request->filled('collection')) {
            $collection = $request->input('collection');
            // You may need to adjust this based on your collection logic
            // This assumes you have a collection field or relationship
            if ($collection == 'spring-2024') {
                $query->where('collection', 'Spring 2024');
            } elseif ($collection == 'summer-essentials') {
                $query->where('collection', 'Summer Essentials');
            } elseif ($collection == 'limited-edition') {
                $query->where('collection', 'Limited Edition');
            } elseif ($collection == 'winter-collection') {
                $query->where('collection', 'Winter Collection');
            }
            // 'all-collections' doesn't need filtering as it shows all
        }

        // Apply sort
        if ($request->filled('sort')) {
            $sortValue = $request->input('sort');
            if ($sortValue == 'name-asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sortValue == 'name-desc') {
                $query->orderBy('name', 'desc');
            } elseif ($sortValue == 'date-desc') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sortValue == 'date-asc') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sortValue == 'price-asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sortValue == 'price-desc') {
                $query->orderBy('price', 'desc');
            }
        }

        // Apply default ordering if no specific sort is applied
        if (!$request->filled('sort') && !$request->filled('filter')) {
            $query->latest();
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            $html = view('web.partials.category-grid', compact('products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $products->total(),
                'firstItem' => $products->firstItem(),
                'lastItem' => $products->lastItem()
            ]);
        }

        return redirect()->route('category.show', $slug);
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

        // Get products that belong to both the category(ies) and occasion
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('ocassion_id', $occasion->id) // Note: ocassion_id with double 's' in database
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
