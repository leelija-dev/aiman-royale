<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use App\Http\Service\Services;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Banner;
use App\Models\BannerDetails;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Occasion;
use App\Models\OfferProducts;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
class HomeController extends Controller
{
    public function __construct() {}
    public function home()
    {
        $data = Service::all();

        // Get active banners from database
        $mainBanners = Banner::active()->main()->ordered()->get();
        $secondaryBanners = Banner::active()->secondary()->ordered()->get();
        $bannerHeroSection = BannerDetails::where('is_active', true)->get();   //banner hero section
        // Debug: Log the counts
        Log::info('Main Banners count: ' . $mainBanners->count());
        Log::info('Secondary Banners count: ' . $secondaryBanners->count());

        $products = DB::table('products')
            ->Join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.stock', '>', 0)
                    ->whereRaw('product_variants.id = (
                         SELECT MIN(id) FROM product_variants 
                         WHERE product_id = products.id AND stock > 0
                     )');
            })
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->whereRaw('product_images.id = (
                         SELECT MIN(id) FROM product_images 
                         WHERE product_id = products.id
                     )');
            })
            ->where('products.is_active', 1)
            ->where('products.ready_to_ship', 1)
            ->select(
                'products.id',
                'products.name',
                'products.brand',
                'products.description',
                'products.category_id',
                'products.ocassion_id',
                'products.fabric',
                'products.fit',
                'products.status',
                'products.is_featured',
                'products.featured_image',
                'products.slug',
                'products.created_at',
                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.color_code',
                'product_variants.price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock',
                'product_images.image as product_image',
                'product_variants.discount as discount'
            )
            ->latest('products.created_at')
            ->take(12)
            ->get();

        // $mostWishlisted = Product::with('wishlists', 'images', 'variants')
        //     ->withCount('wishlists')
        //     ->orderByDesc('wishlists_count')
        //     ->take(12)
        //     ->get();
        // 🔹 Step 1: Get Most Wishlisted Products
        $mostWishlisted = Product::with('images', 'variants')
            ->withCount('wishlists')
            ->whereHas('wishlists') // only products in wishlist
            ->orderByDesc('wishlists_count')
            ->take(12)
            ->get();

        $wishlistCount = $mostWishlisted->count();

        // 🔹 Step 2: If less than 12 → add remaining normal products
        if ($wishlistCount < 12) {

            $remaining = 12 - $wishlistCount;

            $otherProducts = Product::with('images', 'variants')
                ->whereNotIn('id', $mostWishlisted->pluck('id'))
                ->where('is_active', 1)
                ->take($remaining)
                ->get();

            $mostWishlisted = $mostWishlisted->merge($otherProducts);
        }

        // dd($mostWishlisted);

        // dd($products);

        $categories = Category::Where('is_active', 1)->get();
        // $categories = Category::whereHas('products', function($query) {
        //     $query->where('is_active', 1)
        //           ->whereHas('variants');
        // })
        // ->withCount(['products' => function($query) {
        //     $query->where('is_active', 1)
        //           ->whereHas('variants');
        // }])
        // ->get();

        $categoriesWithProduct = Category::whereHas('products', function ($query) {
            $query->where('is_active', 1)
                ->whereHas('variants');
        })
            ->with('latestProductWithImage.images') // Eager load latest product with its images
            ->withCount(['products' => function ($query) {
                $query->where('is_active', 1)
                    ->whereHas('variants');
            }])
            ->get();

        // dd($categoriesWithProduct);
        $occasions = \App\Models\Occasion::active()->get();
        $homeCategories = Category::where('is_home', 1)
            ->whereNotNull('home_position')
            ->get()
            ->groupBy('home_position');


        $testimonials = [];
        return view('web.home', compact('data', 'testimonials', 'categoriesWithProduct', 'products', 'occasions', 'homeCategories', 'mostWishlisted', 'mainBanners', 'secondaryBanners', 'categories', 'bannerHeroSection'));
    }

    public function BannerFilter(Request $request)
    {
        $query = Product::with(['variants', 'categories', 'occasions', 'colors', 'sizes'])
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('ocassions', 'products.occasion_id', '=', 'ocassions.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'ocassions.name as occasion_name',
                DB::raw('MIN(product_variants.price) as min_price'),
                DB::raw('MAX(product_variants.price) as max_price'),
                DB::raw('MIN(product_variants.discount_price) as min_discount_price'),
                DB::raw('MAX(product_variants.discount_price) as max_discount_price')
            )
            ->groupBy('products.id')
            ->where('products.is_active', 1);

        $hasFilters = false;

        // Handle banner discount filter
        $bannerDiscount = $request->input('banner_discount');
        if ($bannerDiscount) {
            $hasFilters = true;
            if (preg_match('/(\d+)/', $bannerDiscount, $matches)) {
                $discountPercent = (int)$matches[1];
                $query->where(function ($q) use ($discountPercent) {
                    $q->whereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= ' . $discountPercent . ')');
                });
            }
        }

        // Handle banner category filter
        $bannerCategory = $request->input('banner_category');
        if ($bannerCategory) {
            $hasFilters = true;
            $query->where('categories.name', $bannerCategory);
        }

        // Handle banner color filter
        $bannerColor = $request->input('banner_color');
        if ($bannerColor) {
            $hasFilters = true;
            $query->whereHas('colors', function ($q) use ($bannerColor) {
                $q->where('colors.name', $bannerColor);
            });
        }

        // Handle banner size filter
        $bannerSize = $request->input('banner_size');
        if ($bannerSize) {
            $hasFilters = true;
            $query->whereHas('sizes', function ($q) use ($bannerSize) {
                $q->where('sizes.name', $bannerSize);
            });
        }

        // Handle banner occasion filter
        $bannerOccasion = $request->input('banner_occasion');
        if ($bannerOccasion) {
            $hasFilters = true;
            $query->where('ocassions.name', $bannerOccasion);
        }

        // Handle banner price range filter
        $bannerPriceRange = $request->input('banner_price_range');
        if ($bannerPriceRange) {
            $hasFilters = true;
            if (strpos($bannerPriceRange, '-') !== false) {
                list($min, $max) = explode('-', $bannerPriceRange);
                $query->where(function ($q) use ($min, $max) {
                    $q->whereBetween('product_variants.price', [(int)$min, (int)$max])
                        ->orWhereBetween('product_variants.discount_price', [(int)$min, (int)$max]);
                });
            }
        }

        // Only apply filters if at least one banner filter is present
        if (!$hasFilters) {
            return response()->json([
                'success' => false,
                'message' => 'No banner filters provided',
                'products' => []
            ]);
        }

        $products = $query->get()->map(function ($product) {
            // Calculate actual price range
            $prices = $product->variants->pluck('price')->filter();
            $discountPrices = $product->variants->pluck('discount_price')->filter();

            $minPrice = $prices->min() ?? 0;
            $maxPrice = $prices->max() ?? 0;
            $minDiscountPrice = $discountPrices->min() ?? 0;
            $maxDiscountPrice = $discountPrices->max() ?? 0;

            // Calculate discount percentage
            $discountPercentage = 0;
            if ($minDiscountPrice > 0 && $minPrice > 0) {
                $discountPercentage = round((($minPrice - $minDiscountPrice) / $minPrice) * 100);
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'featured_image' => $product->featured_image,
                'short_description' => $product->short_description,
                'category_name' => $product->category_name,
                'occasion_name' => $product->occasion_name,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'min_discount_price' => $minDiscountPrice,
                'max_discount_price' => $maxDiscountPrice,
                'discount_percentage' => $discountPercentage,
                'is_trending' => $product->is_trending,
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'price' => $variant->price,
                        'discount_price' => $variant->discount_price,
                        'color' => $variant->color,
                        'size' => $variant->size,
                        'stock' => $variant->stock,
                        'image' => $variant->image,
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Products filtered successfully',
            'filters_applied' => [
                'banner_discount' => $bannerDiscount,
                'banner_category' => $bannerCategory,
                'banner_color' => $bannerColor,
                'banner_size' => $bannerSize,
                'banner_occasion' => $bannerOccasion,
                'banner_price_range' => $bannerPriceRange,
            ],
            'total_products' => $products->count(),
            'products' => $products
        ]);
    }

    // public function ShowAllProduct(Request $request)
    // {
    //     // Get filter parameters from request
    //     $categories = $request->input('category', []);
    //     $colors = $request->input('colors', []);
    //     $sizes = $request->input('sizes', []);
    //     $discountRanges = $request->input('discount_ranges', []);
    //     $sortBy = $request->input('sort', 'date-desc');
    //     $priceMin = $request->input('price_min');
    //     $priceMax = $request->input('price_max');
    //     $search = $request->input('search');
    //     $priceRanges = $request->input('price_ranges', []);
    //     $occasions = $request->input('occasions', []);

    //     // Handle general filter parameter (from banner clicks)
    //     $generalFilter = $request->input('filter');

    //     // Handle multiple filters from banner clicks (proper query parameters)
    //     $bannerDiscount = $request->input('banner_discount');
    //     $bannerCategory = $request->input('banner_category');
    //     $bannerColor = $request->input('banner_color');
    //     $bannerSize = $request->input('banner_size');
    //     $bannerOccasion = $request->input('banner_occasion');
    //     $bannerPriceRange = $request->input('banner_price_range');

    //     // Process discount filters from banner
    //     if ($bannerDiscount) {
    //         if (preg_match('/(\d+)/', $bannerDiscount, $matches)) {
    //             $discountPercent = (int)$matches[1];
    //             $discountRanges = [$discountPercent . '-100'];
    //         }
    //     }

    //     // Process category filters from banner
    //     if ($bannerCategory) {
    //         $categories[] = $bannerCategory;
    //     }

    //     // Process color filters from banner
    //     if ($bannerColor) {
    //         $colors[] = $bannerColor;
    //     }

    //     // Process size filters from banner
    //     if ($bannerSize) {
    //         $sizes[] = $bannerSize;
    //     }

    //     // Process occasion filters from banner
    //     if ($bannerOccasion) {
    //         $occasions[] = $bannerOccasion;
    //     }

    //     // Process price range filters from banner
    //     if ($bannerPriceRange) {
    //         if (strpos($bannerPriceRange, '-') !== false) {
    //             list($min, $max) = explode('-', $bannerPriceRange);
    //             $priceMin = (int)$min;
    //             $priceMax = (int)$max;
    //         }
    //     }

    //     // Handle single filter (backward compatibility)
    //     if ($generalFilter) {
    //         // Check if filter contains discount percentage (e.g., "50%", "30%")
    //         if (preg_match('/(\d+)%/', $generalFilter, $matches)) {
    //             $discountPercent = (int)$matches[1];
    //             // Set discount range to filter products with this discount or higher
    //             $discountRanges = [$discountPercent . '-100'];
    //         }
    //         // Check if filter is a category name
    //         else {
    //             // Try to find category by name
    //             $categoryExists = DB::table('categories')->where('name', $generalFilter)->exists();
    //             if ($categoryExists) {
    //                 $categories = [$generalFilter];
    //             }
    //             // Try to find occasion by name
    //             $occasionExists = DB::table('ocassions')->where('name', $generalFilter)->exists();
    //             if ($occasionExists) {
    //                 $occasions = [$generalFilter];
    //             }
    //         }
    //     }

    //     // Handle multiple filters from banner data (for future enhancement)
    //     // This would be used if we want to process complex filter combinations
    //     $bannerFilters = $request->input('banner_filters');
    //     if ($bannerFilters && is_array($bannerFilters)) {
    //         foreach ($bannerFilters as $filter) {
    //             switch ($filter['type']) {
    //                 case 'discount':
    //                     if (preg_match('/(\d+)/', $filter['value'], $matches)) {
    //                         $discountPercent = (int)$matches[1];
    //                         $discountRanges = [$discountPercent . '-100'];
    //                     }
    //                     break;
    //                 case 'category':
    //                     $categories[] = $filter['value'];
    //                     break;
    //                 case 'color':
    //                     $colors[] = $filter['value'];
    //                     break;
    //                 case 'size':
    //                     $sizes[] = $filter['value'];
    //                     break;
    //                 case 'occasion':
    //                     $occasions[] = $filter['value'];
    //                     break;
    //                 case 'price_range':
    //                     if (strpos($filter['value'], '-') !== false) {
    //                         list($min, $max) = explode('-', $filter['value']);
    //                         $priceMin = (int)$min;
    //                         $priceMax = (int)$max;
    //                     }
    //                     break;
    //             }
    //         }
    //     }


    //     // Start building the query
    //     $query = DB::table('products')
    //         ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
    //         ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
    //         ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
    //         ->leftJoin('ocassions', 'products.ocassion_id', '=', 'ocassions.id')
    //         ->where('products.is_active', 1)
    //         ->where('products.ready_to_ship', 1)
    //         ->select(
    //             'products.*',
    //             'product_variants.id as variant_id',
    //             'product_variants.size',
    //             'product_variants.color',
    //             'product_variants.price',
    //             'product_variants.discount_price as price_after_discount',
    //             'product_variants.stock',
    //             'product_images.image as variant_image'
    //         );

    //     // Apply search filter
    //     // if ($search && !empty(trim($search))) {
    //     //     $searchTerm = trim($search);
    //     //     $query->where(function ($q) use ($searchTerm) {
    //     //         $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
    //     //             ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%')
    //     //             ->orWhere('products.brand', 'LIKE', '%' . $searchTerm . '%')
    //     //             ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
    //     //             ->orWhere('ocassions.name', 'LIKE', '%' . $searchTerm . '%');
    //     //     });
    //     // }

    //     // Apply search filter
    //    // Apply search filter
    //     if ($search && !empty(trim($search))) {

    //  $searchTerm = strtolower(trim($search));

    //  // Special case for trending products
    //  if ($searchTerm == 'trending') {

    //     $query->where('products.is_featured', 1);

    //  } else {

    //     $query->where(function ($q) use ($searchTerm) {

    //         $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('products.brand', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
    //             ->orWhere('ocassions.name', 'LIKE', '%' . $searchTerm . '%');

    //     });

    //  }
    //      }

    //     // Apply brand filters
    //     if (!empty($categories)) {
    //         $query->whereIn('categories.name', $categories);
    //     }
    //     // Apply occasion filters
    //     if (!empty($occasions)) {
    //         $query->whereIn('ocassions.name', $occasions);
    //     }
    //     // Apply price range filters

    //     if (!empty($priceRanges)) {
    //         $query->where(function ($q) use ($priceRanges) {
    //             foreach ($priceRanges as $range) {
    //                 [$min, $max] = explode('-', $range);


    //                 $q->orWhereBetween('product_variants.discount_price', [(int)$min, (int)$max]);
    //             }
    //         });
    //     }

    //     // Apply color filters
    //     if (!empty($colors)) {
    //         $query->whereIn('product_variants.color', $colors);
    //     }

    //     // Apply size filters
    //     if (!empty($sizes)) {
    //         $query->whereIn('product_variants.size', $sizes);
    //     }
    //     if (!empty($price)) {
    //         $query->where('product_variants.discount_price', $price);
    //     }

    //     // Apply price range filters
    //     if ($priceMin) {
    //         $query->where(function ($q) use ($priceMin) {
    //             $q->where('product_variants.price', '>=', $priceMin)
    //                 ->orWhere('product_variants.discount_price', '>=', $priceMin);
    //         });
    //     }

    //     if ($priceMax) {
    //         $query->where(function ($q) use ($priceMax) {
    //             $q->where('product_variants.price', '<=', $priceMax)
    //                 ->orWhere('product_variants.discount_price', '<=', $priceMax);
    //         });
    //     }

    //     // Apply discount range filters
    //     if (!empty($discountRanges)) {
    //         $query->where(function ($q) use ($discountRanges) {
    //             foreach ($discountRanges as $range) {
    //                 switch ($range) {
    //                     case '10+':
    //                         $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 10)');
    //                         break;
    //                     case '20+':
    //                         $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 20)');
    //                         break;
    //                     case '30+':
    //                         $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 30)');
    //                         break;
    //                     case '50+':
    //                         $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 50)');
    //                         break;
    //                     default:
    //                         // Handle custom ranges like "2-100", "50-100", etc.
    //                         if (preg_match('/(\d+)-(\d+)/', $range, $matches)) {
    //                             $minDiscount = (int)$matches[1];
    //                             $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= ' . $minDiscount . ')');
    //                         }
    //                         break;
    //                 }
    //             }
    //         });
    //     }

    //     // Apply sorting
    //     switch ($sortBy) {
    //         case 'name-asc':
    //             $query->orderBy('products.name', 'asc');
    //             break;
    //         case 'name-desc':
    //             $query->orderBy('products.name', 'desc');
    //             break;
    //         case 'price-low':
    //             $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.discount_price) ASC');
    //             break;
    //         case 'price-high':
    //             $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.discount_price) DESC');
    //             break;
    //         case 'date-asc':
    //             $query->orderBy('products.created_at', 'asc');
    //             break;
    //         case 'date-desc':
    //         default:
    //             $query->orderBy('products.created_at', 'desc');
    //             break;
    //     }

    //     // dd($query); 

    //     // Get filtered products
    //     $products = $query->get();

    //     // Group products by ID to avoid duplicates
    //     $groupedProducts = [];
    //     foreach ($products as $product) {
    //         $productId = $product->id;

    //         if (!isset($groupedProducts[$productId])) {
    //             // Create main product entry
    //             $groupedProducts[$productId] = [
    //                 'id' => $product->id,
    //                 'design_no' => $product->design_no,
    //                 'category_id' => $product->category_id,
    //                 'ocassion_id' => $product->ocassion_id,
    //                 'name' => $product->name,
    //                 'slug' => $product->slug,
    //                 'description' => $product->description,
    //                 'brand' => $product->brand,
    //                 'fabric' => $product->fabric,
    //                 'fit' => $product->fit,
    //                 'price' => $product->price,
    //                 'discount_price' => $product->discount_price,
    //                 'stock' => $product->stock,
    //                 'status' => $product->status,
    //                 'created_at' => $product->created_at,
    //                 'updated_at' => $product->updated_at,
    //                 'deleted_at' => $product->deleted_at,
    //                 'is_active' => $product->is_active,
    //                 'unit_id' => $product->unit_id,
    //                 'variants' => [],
    //                 'images' => [],
    //             ];
    //         }

    //         // Add variant if not already added
    //         $variantId = $product->variant_id;
    //         if (!isset($groupedProducts[$productId]['variants'][$variantId])) {
    //             $groupedProducts[$productId]['variants'][$variantId] = [
    //                 'variant_id' => $product->variant_id,
    //                 'size' => $product->size,
    //                 'color' => $product->color,
    //                 'price' => $product->price,
    //                 'price_after_discount' => $product->price_after_discount,
    //                 'stock' => $product->stock,
    //             ];
    //         }

    //         // Add image if not already added
    //         if ($product->variant_image && !in_array($product->variant_image, $groupedProducts[$productId]['images'])) {
    //             $groupedProducts[$productId]['images'][] = $product->variant_image;
    //         }
    //     }

    //     // Convert to collection for easier handling in view
    //     $products = collect(array_values($groupedProducts));

    //     // Get filter options for sidebar
    //     $filterOptions = [
    //         // 'brands' => DB::table('products')->whereNotNull('brand')->where('brand', '!=', '')->distinct()->pluck('brand')->filter()->toArray(),
    //         'categories' => DB::table('categories')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('name')->filter()->toArray(),
    //         'colors' => DB::table('product_variants')->whereNotNull('color')->where('color', '!=', '')->distinct()->pluck('color')->filter()->toArray(),
    //         // 'sizes' => DB::table('product_variants')->whereNotNull('size')->where('size', '!=', '')->distinct()->pluck('size')->filter()->toArray(),
    //         'sizes' => DB::table('sizes')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('code')->filter()->toArray(),
    //         'occasions' => DB::table('ocassions')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('name')->filter()->toArray(),
    //     ];

    //     // Get price range
    //     $priceRange = DB::table('product_variants')
    //         ->selectRaw('MIN(COALESCE(discount_price, price)) as min_price, MAX(COALESCE(discount_price, price)) as max_price')
    //         ->first();
    //     $selectedFilters = [
    //         'categories' => $categories,
    //         'colors' => $colors,
    //         'sizes' => $sizes,
    //         'occasions' => $occasions,
    //         'price_ranges' => array_unique($priceRanges),
    //         'discount_ranges' => $discountRanges,
    //     ];


    //     return view('web.multi-product', compact('products', 'filterOptions', 'priceRange', 'selectedFilters'));
    // }

    public function ShowAllProduct(Request $request)
    {
        // Get filter parameters from request
        $categories = $request->input('category', []);
        $colors = $request->input('colors', []);
        $sizes = $request->input('sizes', []);
        $discountRanges = $request->input('discount_ranges', []);
        $sortBy = $request->input('sort', 'date-desc');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $search = $request->input('search');
        $priceRanges = $request->input('price_ranges', []);
        $occasions = $request->input('occasions', []);
        $hasOffer = $request->input('has_offer');

        // Start building the query
        if (in_array(strtolower($search), ['offer', 'offers'])) {
        
    $query = DB::table('offer_products')
        ->join('products', 'offer_products.product_id', '=', 'products.id')
        ->join('product_variants', 'offer_products.product_variant_id', '=', 'product_variants.id')
        ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftJoin('ocassions', 'products.ocassion_id', '=', 'ocassions.id')
        ->where('products.is_active', 1)
        ->where('products.ready_to_ship', 1)
        ->select(
                'products.id',
                'products.design_no',
                'products.category_id',
                'products.ocassion_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand',
                'products.fabric',
                'products.fit',
                'products.price',
                'products.discount_price',
                'products.stock',
                'products.status',
                'products.featured_image',
                'products.ready_to_ship',
                'products.is_featured',
                'products.meta_title',
                'products.keywords',
                'products.tags',
                'products.meta_description',
                'products.schema_markup',
                'products.created_at',
                'products.updated_at',
                'products.deleted_at',
                'products.is_active',
                'products.unit_id',
                'products.lehenga_fabric',
                'products.choli_fabric',
                'products.dupatta_fabric',
                'products.type',
                'products.stitching_type',
                'products.pattern',
                'products.sales_package',

                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price as variant_price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock as variant_stock',

                DB::raw('MIN(product_images.image) as variant_image')
            )
            ->groupBy(
                'products.id',
                'products.design_no',
                'products.category_id',
                'products.ocassion_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand',
                'products.fabric',
                'products.fit',
                'products.price',
                'products.discount_price',
                'products.stock',
                'products.status',
                'products.featured_image',
                'products.ready_to_ship',
                'products.is_featured',
                'products.meta_title',
                'products.keywords',
                'products.tags',
                'products.meta_description',
                'products.schema_markup',
                'products.created_at',
                'products.updated_at',
                'products.deleted_at',
                'products.is_active',
                'products.unit_id',
                'products.lehenga_fabric',
                'products.choli_fabric',
                'products.dupatta_fabric',
                'products.type',
                'products.stitching_type',
                'products.pattern',
                'products.sales_package',

                'product_variants.id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price',
                'product_variants.discount_price',
                'product_variants.stock'
            )->orderByDesc('product_variants.discount' );
        // dd($query);
} else {
    // dd('else');
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('ocassions', 'products.ocassion_id', '=', 'ocassions.id')
            ->where('products.is_active', 1)
            ->where('products.ready_to_ship', 1)
            ->select(
                'products.id',
                'products.design_no',
                'products.category_id',
                'products.ocassion_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand',
                'products.fabric',
                'products.fit',
                'products.price',
                'products.discount_price',
                'products.stock',
                'products.status',
                'products.featured_image',
                'products.ready_to_ship',
                'products.is_featured',
                'products.meta_title',
                'products.keywords',
                'products.tags',
                'products.meta_description',
                'products.schema_markup',
                'products.created_at',
                'products.updated_at',
                'products.deleted_at',
                'products.is_active',
                'products.unit_id',
                'products.lehenga_fabric',
                'products.choli_fabric',
                'products.dupatta_fabric',
                'products.type',
                'products.stitching_type',
                'products.pattern',
                'products.sales_package',

                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price as variant_price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock as variant_stock',

                DB::raw('MIN(product_images.image) as variant_image')
            )
            ->groupBy(
                'products.id',
                'products.design_no',
                'products.category_id',
                'products.ocassion_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.brand',
                'products.fabric',
                'products.fit',
                'products.price',
                'products.discount_price',
                'products.stock',
                'products.status',
                'products.featured_image',
                'products.ready_to_ship',
                'products.is_featured',
                'products.meta_title',
                'products.keywords',
                'products.tags',
                'products.meta_description',
                'products.schema_markup',
                'products.created_at',
                'products.updated_at',
                'products.deleted_at',
                'products.is_active',
                'products.unit_id',
                'products.lehenga_fabric',
                'products.choli_fabric',
                'products.dupatta_fabric',
                'products.type',
                'products.stitching_type',
                'products.pattern',
                'products.sales_package',

                'product_variants.id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price',
                'product_variants.discount_price',
                'product_variants.stock'
            );
}
        // Apply search filter
        if ($search != 'offer' && $search != 'offers' && !empty(trim($search))) {

            $searchTerm = strtolower(trim($search));

            // Trending products
            if ($searchTerm == 'trending') {

                $query->where('products.is_featured', 1);
            } else {

                $query->where(function ($q) use ($searchTerm) {

                    $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('products.brand', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('ocassions.name', 'LIKE', '%' . $searchTerm . '%');
                });
            }
        }

        // Apply offer filter (show only products with discount)
        if ($hasOffer && $hasOffer == '1') {
            $query->whereNotNull('product_variants.discount_price')
                ->whereRaw('product_variants.discount_price < product_variants.price');
        }

        // Apply category filters
        if (!empty($categories)) {
            $query->whereIn('categories.name', $categories);
        }

        // Apply occasion filters
        if (!empty($occasions)) {
            $query->whereIn('ocassions.name', $occasions);
        }

        // Apply color filters
        if (!empty($colors)) {
            $query->whereIn('product_variants.color', $colors);
        }

        // Apply size filters
        if (!empty($sizes)) {
            $query->whereIn('product_variants.size', $sizes);
        }

        // Apply price range filters
        if (!empty($priceRanges)) {

            $query->where(function ($q) use ($priceRanges) {

                foreach ($priceRanges as $range) {

                    [$min, $max] = explode('-', $range);

                    $q->orWhereBetween(
                        'product_variants.discount_price',
                        [(int)$min, (int)$max]
                    );
                }
            });
        }

        // Apply min price
        if ($priceMin) {

            $query->where(function ($q) use ($priceMin) {

                $q->where('product_variants.price', '>=', $priceMin)
                    ->orWhere('product_variants.discount_price', '>=', $priceMin);
            });
        }

        // Apply max price
        if ($priceMax) {

            $query->where(function ($q) use ($priceMax) {

                $q->where('product_variants.price', '<=', $priceMax)
                    ->orWhere('product_variants.discount_price', '<=', $priceMax);
            });
        }

        // Apply discount filters
        if (!empty($discountRanges)) {

            $query->where(function ($q) use ($discountRanges) {

                foreach ($discountRanges as $range) {

                    if (preg_match('/(\d+)/', $range, $matches)) {

                        $minDiscount = (int)$matches[1];

                        $q->orWhereRaw("
                        (
                            product_variants.discount_price > 0
                            AND
                            (
                                (product_variants.price - product_variants.discount_price)
                                / product_variants.price * 100
                            ) >= ?
                        )
                    ", [$minDiscount]);
                    }
                }
            });
        }

        // Sorting
        switch ($sortBy) {

            case 'name-asc':
                $query->orderBy('products.name', 'asc');
                break;

            case 'name-desc':
                $query->orderBy('products.name', 'desc');
                break;

            case 'price-low':
                $query->orderBy('product_variants.discount_price', 'asc');
                break;

            case 'price-high':
                $query->orderBy('product_variants.discount_price', 'desc');
                break;

            case 'date-asc':
                $query->orderBy('products.created_at', 'asc');
                break;

            case 'date-desc':
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }

        // Get products
        // $products = $query->get();
        // Get products
        // $rawProducts = $query->get();
        // $rawProducts = $query->paginate(5)->withQueryString();
        
        // // Convert products to old array structure
        // $products = collect();

        // foreach ($rawProducts as $product) {

        //     $products->push([

        //         'id' => $product->id,
        //         'design_no' => $product->design_no,
        //         'category_id' => $product->category_id,
        //         'ocassion_id' => $product->ocassion_id,
        //         'name' => $product->name,
        //         'slug' => $product->slug,
        //         'description' => $product->description,
        //         'brand' => $product->brand,
        //         'fabric' => $product->fabric,
        //         'fit' => $product->fit,
        //         'price' => $product->price,
        //         'discount_price' => $product->discount_price,
        //         'stock' => $product->stock,
        //         'status' => $product->status,
        //         'featured_image' => $product->featured_image,
        //         'ready_to_ship' => $product->ready_to_ship,
        //         'is_featured' => $product->is_featured,
        //         'meta_title' => $product->meta_title,
        //         'keywords' => $product->keywords,
        //         'tags' => $product->tags,
        //         'meta_description' => $product->meta_description,
        //         'schema_markup' => $product->schema_markup,
        //         'created_at' => $product->created_at,
        //         'updated_at' => $product->updated_at,
        //         'deleted_at' => $product->deleted_at,
        //         'is_active' => $product->is_active,
        //         'unit_id' => $product->unit_id,

        //         // images structure expected in blade
        //         'images' => [
        //             [
        //                 'image' => $product->variant_image
        //             ]
        //         ],

        //         // variants structure expected in blade
        //         'variants' => [
        //             [
        //                 'variant_id' => $product->variant_id,
        //                 'size' => $product->size,
        //                 'color' => $product->color,
        //                 'price' => $product->variant_price,
        //                 'discount_price' => $product->price_after_discount,
        //                 'stock' => $product->variant_stock,
        //             ]
        //         ]
        //     ]);
        // }
            $rawProducts = $query->paginate(6)->withQueryString();

// Convert current page products
$mappedProducts = collect();

foreach ($rawProducts->items() as $product) {

    $mappedProducts->push([

        'id' => $product->id,
        'design_no' => $product->design_no,
        'category_id' => $product->category_id,
        'ocassion_id' => $product->ocassion_id,
        'name' => $product->name,
        'slug' => $product->slug,
        'description' => $product->description,
        'brand' => $product->brand,
        'fabric' => $product->fabric,
        'fit' => $product->fit,
        'price' => $product->price,
        'discount_price' => $product->discount_price,
        'stock' => $product->stock,
        'status' => $product->status,
        'featured_image' => $product->featured_image,
        'ready_to_ship' => $product->ready_to_ship,
        'is_featured' => $product->is_featured,
        'meta_title' => $product->meta_title,
        'keywords' => $product->keywords,
        'tags' => $product->tags,
        'meta_description' => $product->meta_description,
        'schema_markup' => $product->schema_markup,
        'created_at' => $product->created_at,
        'updated_at' => $product->updated_at,
        'deleted_at' => $product->deleted_at,
        'is_active' => $product->is_active,
        'unit_id' => $product->unit_id,

        'images' => [
            [
                'image' => $product->variant_image
            ]
        ],

        'variants' => [
            [
                'variant_id' => $product->variant_id,
                'size' => $product->size,
                'color' => $product->color,
                'price' => $product->variant_price,
                'discount_price' => $product->price_after_discount,
                'stock' => $product->variant_stock,
            ]
        ]
    ]);
}

$products = new LengthAwarePaginator(
    $mappedProducts,
    $rawProducts->total(),
    $rawProducts->perPage(),
    $rawProducts->currentPage(),
    [
        'path' => request()->url(),
        'query' => request()->query(),
    ]
);
        // Filter options
        $filterOptions = [
            'categories' => DB::table('categories')
                ->whereNotNull('name')
                ->where('name', '!=', '')
                ->whereNull('deleted_at')
                ->distinct()
                ->pluck('name')
                ->filter()
                ->toArray(),

            'colors' => DB::table('product_variants')
                ->whereNotNull('color')
                ->where('color', '!=', '')
                ->distinct()
                ->pluck('color')
                ->filter()
                ->toArray(),

            'sizes' => DB::table('sizes')
                ->whereNotNull('name')
                ->where('name', '!=', '')
                ->distinct()
                ->pluck('code')
                ->filter()
                ->toArray(),

            'occasions' => DB::table('ocassions')
                ->whereNotNull('name')
                ->where('name', '!=', '')
                ->distinct()
                ->pluck('name')
                ->filter()
                ->toArray(),
        ];

        // Price range
        $priceRange = DB::table('product_variants')
            ->selectRaw('
            MIN(COALESCE(discount_price, price)) as min_price,
            MAX(COALESCE(discount_price, price)) as max_price
        ')
            ->first();

        // Selected filters
        $selectedFilters = [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'occasions' => $occasions,
            'price_ranges' => array_unique($priceRanges),
            'discount_ranges' => $discountRanges,
        ];
            
        // if($request->search == 'offers' || $request->search == 'offer') { 
        //     $products = OfferProducts::with('productVariant');
        // }
    //    dd($products);
        return view(
            'web.multi-product',
            compact(
                'products',
                'filterOptions',
                'priceRange',
                'selectedFilters'
            )
        );
    }

    // public function ShowSingleProduct($slug)
    // {
    //     //  dd($slug);
    //     $data = Product::where('slug', $slug)->first();
    //     if (!$data) {
    //         abort(404);
    //     }

    //     $product = $data;
    //     $product->load(['images', 'variants', 'category', 'parts']);
    //     // dd($product);
    //     $sizes = Size::OrderBy('sort_order')->get();
    //     $colors = Color::orderBy('id')->get();

    //     // Track last viewed products in session
    //     $lastViewed = session()->get('last_viewed', []);

    //     // Add current product to the beginning of the array
    //     array_unshift($lastViewed, [
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'slug' => $product->slug,
    //         'featured_image' => $product->featured_image,
    //         'price' => $product->price,
    //         'is_trending' => $product->is_trending ?? false,
    //         'viewed_at' => now()->timestamp
    //     ]);

    //     // Keep only last 5 viewed products and remove duplicates
    //     $uniqueViewed = [];
    //     $seenIds = [];

    //     foreach ($lastViewed as $item) {
    //         if (!in_array($item['id'], $seenIds) && $item['id'] != $product->id) {
    //             $uniqueViewed[] = $item;
    //             $seenIds[] = $item['id'];
    //         }
    //     }

    //     session()->put('last_viewed', array_slice($uniqueViewed, 0, 5));

    //     // Convert to collection for easier handling in view
    //     $lastViewedProducts = collect($uniqueViewed)->take(5);

    //     // If no colors exist, create some default ones
    //     if ($colors->count() === 0) {
    //         $defaultColors = [
    //             ['name' => 'Red', 'code' => '#FF0000', 'color_tone' => 'warm'],
    //             ['name' => 'Blue', 'code' => '#0000FF', 'color_tone' => 'cool'],
    //             ['name' => 'Green', 'code' => '#00FF00', 'color_tone' => 'cool'],
    //             ['name' => 'Yellow', 'code' => '#FFFF00', 'color_tone' => 'warm'],
    //             ['name' => 'Black', 'code' => '#000000', 'color_tone' => 'neutral'],
    //             ['name' => 'White', 'code' => '#FFFFFF', 'color_tone' => 'neutral'],
    //             ['name' => 'Pink', 'code' => '#FFC0CB', 'color_tone' => 'warm'],
    //             ['name' => 'Purple', 'code' => '#800080', 'color_tone' => 'cool'],
    //         ];

    //         foreach ($defaultColors as $colorData) {
    //             Color::create($colorData);
    //         }

    //         $colors = Color::orderBy('id')->get();
    //     }

    //     // Get most wishlisted products
    //     $mostWishlistedProducts = Product::where('is_active', 1)
    //         ->withCount('wishlists')
    //         ->orderBy('wishlists_count', 'desc')
    //         ->limit(8)
    //         ->get(['id', 'name', 'slug', 'featured_image', 'price', 'category_id', 'is_trending']);

    //     // Load necessary relationships for most wishlisted products
    //     $mostWishlistedProducts->load(['variants', 'images']);

    //     $relatedProducts = Product::where('category_id', '=', $product->category_id)->where('is_active', 1)
    //         ->whereBetween('price', [
    //             $product->price - 1000,
    //             $product->price + 1000
    //         ])
    //         ->whereHas('variants')->with(['variants', 'images'])->get();
    //     return view('web.single-product', compact('product', 'sizes', 'relatedProducts', 'colors', 'mostWishlistedProducts', 'lastViewedProducts'));
    // }

    public function ShowSingleProduct($slug)
    {
        $data = Product::where('slug', $slug)->first();


        if (!$data) {
            abort(404);
        }

        $product = $data;
        $product->load(['images', 'variants', 'category', 'parts']);

        $sizes = Size::orderBy('sort_order')->get();
        $colors = Color::orderBy('id')->get();

        /*
    |--------------------------------------------------------------------------
    | Last Viewed Products (Store Last 5 in Session)
    |--------------------------------------------------------------------------
    */

        // Get session products
        $lastViewed = session()->get('last_viewed', []);

        // Remove current product if already exists
        $lastViewed = array_filter($lastViewed, function ($item) use ($product) {
            return $item['id'] != $product->id;
        });

        // Add current product at beginning
        array_unshift($lastViewed, [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'featured_image' => $product->featured_image,
            'price' => $product->price,
            'discount_price' => $product->discount_price,
            'is_trending' => $product->is_trending ?? false,
            'viewed_at' => now()->timestamp
        ]);

        // Keep only 5 products
        $lastViewed = array_slice($lastViewed, 0, 5);

        // Store again in session
        session()->put('last_viewed', $lastViewed);

        // Convert to collection for blade
        $lastViewedProducts = collect($lastViewed);
        // dd($lastViewedProducts);

        /*
    |--------------------------------------------------------------------------
    | Default Colors (If none exist)
    |--------------------------------------------------------------------------
    */

        if ($colors->count() === 0) {

            $defaultColors = [
                ['name' => 'Red', 'code' => '#FF0000', 'color_tone' => 'warm'],
                ['name' => 'Blue', 'code' => '#0000FF', 'color_tone' => 'cool'],
                ['name' => 'Green', 'code' => '#00FF00', 'color_tone' => 'cool'],
                ['name' => 'Yellow', 'code' => '#FFFF00', 'color_tone' => 'warm'],
                ['name' => 'Black', 'code' => '#000000', 'color_tone' => 'neutral'],
                ['name' => 'White', 'code' => '#FFFFFF', 'color_tone' => 'neutral'],
                ['name' => 'Pink', 'code' => '#FFC0CB', 'color_tone' => 'warm'],
                ['name' => 'Purple', 'code' => '#800080', 'color_tone' => 'cool'],
            ];

            foreach ($defaultColors as $colorData) {
                Color::create($colorData);
            }

            $colors = Color::orderBy('id')->get();
        }

        /*
    |--------------------------------------------------------------------------
    | Most Wishlisted Products
    |--------------------------------------------------------------------------
    */

        $mostWishlistedProducts = Product::where('is_active', 1)
            ->withCount('wishlists')
            ->orderBy('wishlists_count', 'desc')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'featured_image', 'price', 'category_id', 'is_trending']);

        $mostWishlistedProducts->load(['variants', 'images']);

        /*
    |--------------------------------------------------------------------------
    | Related Products
    |--------------------------------------------------------------------------
    */

        // $relatedProducts = Product::where('category_id', $product->category_id)
        //     ->where('id', '!=', $product->id)
        //     ->where('is_active', 1)
        //     ->whereBetween('price', [
        //         $product->price - 1000,
        //         $product->price + 1000
        //     ])
        //     ->whereHas('variants')
        //     ->with(['variants', 'images'])
        //     ->limit(8)
        //     ->get();
        $relatedProducts = Product::where('category_id', '=', $product->category_id)->where('is_active', 1)
            ->whereBetween('price', [
                $product->price - 1000,
                $product->price + 1000
            ])
            ->whereHas('variants')->with(['variants', 'images'])->get();
            
        return view('web.single-product', compact(
            'product',
            'sizes',
            'relatedProducts',
            'colors',
            'mostWishlistedProducts',
            'lastViewedProducts'
        ));
    }
}
