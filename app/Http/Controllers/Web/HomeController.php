<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use App\Http\Service\Services;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;

class HomeController extends Controller
{
    public function __construct() {}
    public function home()
    {
        $data = Service::all();
        // $products = Product::with([
        //     'variants' => function($query) {
        //         $query->select('id', 'product_id', 'size', 'color', 'price', 'discount_price', 'stock');
        //     },
        //     'images' => function($query) {
        //         $query->select('product_id', 'image');
        //     }
        // ])
        // ->where('is_active', 1)
        // ->select('id', 'name', 'brand', 'description', 'is_active')
        // ->latest()
        // ->take(10)
        // ->get();

        $products = DB::table('products')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->where('product_variants.stock', '>', 0)
                     ->whereRaw('product_variants.id = (
                         SELECT MIN(id) FROM product_variants 
                         WHERE product_id = products.id AND stock > 0
                     )');
            })
            ->leftJoin('product_images', function($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                     ->whereRaw('product_images.id = (
                         SELECT MIN(id) FROM product_images 
                         WHERE product_id = products.id
                     )');
            })
            ->where('products.is_active', 1)
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
                'products.slug',
                'products.created_at',
                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock',
                'product_images.image as product_image'
            )
            ->latest('products.created_at')
            ->take(12)
            ->get();

        $mostWishlisted = Product::with('wishlists', 'images')
            ->withCount('wishlists')
            ->orderByDesc('wishlists_count')
            ->take(12)
            ->get();
        // dd($mostWishlisted);

        // dd($products);

        $categories = Category::withCount('products')->get();
        $occasions = \App\Models\Occasion::active()->get();
        $homeCategories = Category::where('is_home', 1)
        ->whereNotNull('home_position')
        ->get()
        ->groupBy('home_position');


        $testimonials = [];

        return view('web.home', compact('data', 'testimonials', 'categories', 'products', 'occasions','homeCategories', 'mostWishlisted'));
    }

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


        // Start building the query
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('ocassions', 'products.ocassion_id', '=', 'ocassions.id')
            ->where('products.is_active', 1)
            ->select(
                'products.*',
                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock',
                'product_images.image as variant_image'
            );

        // Apply search filter
        if ($search && !empty(trim($search))) {
            $searchTerm = trim($search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('products.brand', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('ocassions.name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
       
        // Apply brand filters
        if (!empty($categories)) {
            $query->whereIn('categories.name', $categories);

        }
        // Apply occasion filters
        if (!empty($occasions)) {
            $query->whereIn('ocassions.name', $occasions);
        }
        // Apply price range filters
      
        if (!empty($priceRanges)) {
            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    [$min, $max] = explode('-', $range);
                

                $q->orWhereBetween('product_variants.discount_price', [(int)$min, (int)$max]);
                    
                }
            });
        }

        // Apply color filters
        if (!empty($colors)) {
            $query->whereIn('product_variants.color', $colors);
        }

        // Apply size filters
        if (!empty($sizes)) {
            $query->whereIn('product_variants.size', $sizes);
        }
        if(!empty($price)){
            $query->where('product_variants.discount_price',$price);
        }

        // Apply price range filters
        if ($priceMin) {
            $query->where(function($q) use ($priceMin) {
                $q->where('product_variants.price', '>=', $priceMin)
                  ->orWhere('product_variants.discount_price', '>=', $priceMin);
            });
        }

        if ($priceMax) {
            $query->where(function($q) use ($priceMax) {
                $q->where('product_variants.price', '<=', $priceMax)
                  ->orWhere('product_variants.discount_price', '<=', $priceMax);
            });
        }

        // Apply discount range filters
        if (!empty($discountRanges)) {
            $query->where(function($q) use ($discountRanges) {
                foreach ($discountRanges as $range) {
                    switch ($range) {
                        case '10+':
                            $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 10)');
                            break;
                        case '20+':
                            $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 20)');
                            break;
                        case '30+':
                            $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 30)');
                            break;
                        case '50+':
                            $q->orWhereRaw('(product_variants.discount_price > 0 AND ((product_variants.price - product_variants.discount_price) / product_variants.price * 100) >= 50)');
                            break;
                    }
                }
            });
        }

        // Apply sorting
        switch ($sortBy) {
            case 'name-asc':
                $query->orderBy('products.name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('products.name', 'desc');
                break;
            case 'price-low':
                $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.discount_price) ASC');
                break;
            case 'price-high':
                $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.discount_price) DESC');
                break;
            case 'date-asc':
                $query->orderBy('products.created_at', 'asc');
                break;
            case 'date-desc':
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }

        // Get filtered products
        $products = $query->get();

        // Group products by ID to avoid duplicates
        $groupedProducts = [];
        foreach ($products as $product) {
            $productId = $product->id;
            
            if (!isset($groupedProducts[$productId])) {
                // Create main product entry
                $groupedProducts[$productId] = [
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
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'deleted_at' => $product->deleted_at,
                    'is_active' => $product->is_active,
                    'unit_id' => $product->unit_id,
                    'variants' => [],
                    'images' => [],
                ];
            }
            
            // Add variant if not already added
            $variantId = $product->variant_id;
            if (!isset($groupedProducts[$productId]['variants'][$variantId])) {
                $groupedProducts[$productId]['variants'][$variantId] = [
                    'variant_id' => $product->variant_id,
                    'size' => $product->size,
                    'color' => $product->color,
                    'price' => $product->price,
                    'price_after_discount' => $product->price_after_discount,
                    'stock' => $product->stock,
                ];
            }
            
            // Add image if not already added
            if ($product->variant_image && !in_array($product->variant_image, $groupedProducts[$productId]['images'])) {
                $groupedProducts[$productId]['images'][] = $product->variant_image;
            }
        }

        // Convert to collection for easier handling in view
        $products = collect(array_values($groupedProducts));

        // Get filter options for sidebar
        $filterOptions = [
            // 'brands' => DB::table('products')->whereNotNull('brand')->where('brand', '!=', '')->distinct()->pluck('brand')->filter()->toArray(),
            'categories' => DB::table('categories')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('name')->filter()->toArray(),
            'colors' => DB::table('product_variants')->whereNotNull('color')->where('color', '!=', '')->distinct()->pluck('color')->filter()->toArray(),
            // 'sizes' => DB::table('product_variants')->whereNotNull('size')->where('size', '!=', '')->distinct()->pluck('size')->filter()->toArray(),
            'sizes' => DB::table('sizes')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('code')->filter()->toArray(),
            'occasions' => DB::table('ocassions')->whereNotNull('name')->where('name', '!=', '')->distinct()->pluck('name')->filter()->toArray(),
        ];

        // Get price range
        $priceRange = DB::table('product_variants')
            ->selectRaw('MIN(COALESCE(discount_price, price)) as min_price, MAX(COALESCE(discount_price, price)) as max_price')
            ->first();
        $selectedFilters = [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'occasions' => $occasions,
            'price_ranges' => array_unique($priceRanges),
            'discount_ranges' => $discountRanges,
        ];


        return view('web.multi-product', compact('products', 'filterOptions', 'priceRange','selectedFilters'));
    }

    public function ShowSingleProduct($slug)
    {
        $product = Product::with(['images', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();
        $sizes=Size::OrderBy('sort_order')->get();
        // print_r($product->category);die;
        $relatedProducts=Product::where('category_id','=',$product->category_id)->where('is_active',1)->with('variants','images')->get();
        //  print_r($relatedProducts->first()->variants);die;
        // dd($product);
        return view('web.single-product', compact('product','sizes','relatedProducts'));
    }
}
