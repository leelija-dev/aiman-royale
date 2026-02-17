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
    $category = Category::where('slug', $slug)
        ->where('is_active', 1)
        ->firstOrFail();

    $products = $category->products()
        ->where('is_active', 1)
        ->whereHas('variants') // Only include products that have variants
        ->with(['images' => function($query) {
            $query->select('product_id', 'image');
        }, 'variants' => function($query) {
            $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
        }])
        ->select('products.*')
        ->latest()
        ->paginate(12);
    
    $occasions = Occasion::where('is_active', 1)->get();
    
    // Get all available sizes from variants
    $allVariants = \App\Models\ProductVariant::whereHas('product', function($query) use ($category) {
        $query->where('category_id', $category->id)->where('is_active', 1);
    })->get();
    
    // Get unique sizes (handle both string and potential JSON)
    $sizes = $allVariants->pluck('size')
        ->filter()
        ->map(function($size) {
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
        ->map(function($color) {
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

    return view('web.category_product', compact('category', 'products', 'occasions', 'sizes', 'colors', 'priceRange'));
}

// Helper function to check if string is JSON
private function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

    public function collection(){
        $categories = Category::where('is_active', 1)->get();
        return view('web.collection', compact('categories'));
    }
  public function filter($slug, Request $request)
{
    $category = Category::where('slug', $slug)
        ->where('is_active', 1)
        ->firstOrFail();

    $query = $category->products()
        ->where('is_active', 1)
        ->whereHas('variants')
        ->with(['images' => function($query) {
            $query->select('product_id', 'image');
        }, 'variants' => function($query) {
            $query->select('product_id', 'size', 'color', 'price', 'discount_price', 'stock');
        }])
        ->select('products.*');

    // Apply price range filters (checkboxes)
    if ($request->filled('price_ranges')) {
        $priceRanges = json_decode($request->price_ranges);
        
        if (!empty($priceRanges)) {
            $query->whereHas('variants', function($q) use ($priceRanges) {
                $q->where(function($subQ) use ($priceRanges) {
                    foreach ($priceRanges as $range) {
                        switch($range) {
                            case 'below-200':
                                $subQ->orWhere(function($orQ) {
                                    $orQ->where('discount_price', '<', 200)
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->where('price', '<', 200);
                                        });
                                });
                                break;
                            case '200-300':
                                $subQ->orWhere(function($orQ) use ($range) {
                                    $orQ->whereBetween('discount_price', [200, 300])
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->whereBetween('price', [200, 300]);
                                        });
                                });
                                break;
                            case '300-400':
                                $subQ->orWhere(function($orQ) {
                                    $orQ->whereBetween('discount_price', [300, 400])
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->whereBetween('price', [300, 400]);
                                        });
                                });
                                break;
                            case '400-500':
                                $subQ->orWhere(function($orQ) {
                                    $orQ->whereBetween('discount_price', [400, 500])
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->whereBetween('price', [400, 500]);
                                        });
                                });
                                break;
                            case '500-600':
                                $subQ->orWhere(function($orQ) {
                                    $orQ->whereBetween('discount_price', [500, 600])
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->whereBetween('price', [500, 600]);
                                        });
                                });
                                break;
                            case '600-above':
                                $subQ->orWhere(function($orQ) {
                                    $orQ->where('discount_price', '>=', 600)
                                        ->orWhere(function($q) {
                                            $q->whereNull('discount_price')
                                              ->where('price', '>=', 600);
                                        });
                                });
                                break;
                        }
                    }
                });
            });
        }
    }
    
    // Apply custom price range (slider)
    if ($request->has('custom_min_price') && $request->has('custom_max_price')) {
        $query->whereHas('variants', function($q) use ($request) {
            $q->where(function($subQ) use ($request) {
                $subQ->whereBetween('discount_price', [$request->custom_min_price, $request->custom_max_price])
                    ->orWhere(function($orQ) use ($request) {
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
            $query->whereHas('variants', function($q) use ($sizes) {
                $q->whereIn('size', $sizes);
            });
        }
    }

    // Apply color filter
    if ($request->filled('colors')) {
        $colors = json_decode($request->colors);
        if (!empty($colors)) {
            $query->whereHas('variants', function($q) use ($colors) {
                $q->whereIn('color', $colors);
            });
        }
    }

    // Apply occasion filter
    if ($request->filled('occasions')) {
        $occasions = json_decode($request->occasions);
        if (!empty($occasions)) {
            $query->whereIn('occasion_id', $occasions);
        }
    }

    $products = $query->latest()->paginate(12);

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
}
