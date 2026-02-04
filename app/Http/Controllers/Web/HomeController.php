<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use App\Http\Service\Services;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'product_variants.id', '=', 'product_images.variant_id')
            ->where('products.is_active', 1)
            ->select(
                'products.*',
                'product_variants.id as variant_id',
                'product_variants.size',
                'product_variants.color',
                'product_variants.price',
                'product_variants.discount_price as price_after_discount',
                'product_variants.stock',
                'product_images.image as product_image'
            )
            ->get();


        // dd($products);

        $categories = Category::withCount('products')->get();
        $occasions = \App\Models\Occasion::active()->get();

        $testimonials = [];

        return view('web.home', compact('data', 'testimonials', 'categories', 'products', 'occasions'));
    }

    public function ShowAllProduct(Request $request)
    {
        // Get filter parameters from request
        $brands = $request->input('brands', []);
        $colors = $request->input('colors', []);
        $sizes = $request->input('sizes', []);
        $discountRanges = $request->input('discount_ranges', []);
        $sortBy = $request->input('sort', 'date-desc');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $search = $request->input('search');

        // Start building the query
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
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
                  ->orWhere('products.brand', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Apply brand filters
        if (!empty($brands)) {
            $query->whereIn('products.brand', $brands);
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
                $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.price) ASC');
                break;
            case 'price-high':
                $query->orderByRaw('COALESCE(product_variants.discount_price, product_variants.price) DESC');
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
            'brands' => DB::table('products')->whereNotNull('brand')->where('brand', '!=', '')->distinct()->pluck('brand')->filter()->toArray(),
            'colors' => DB::table('product_variants')->whereNotNull('color')->where('color', '!=', '')->distinct()->pluck('color')->filter()->toArray(),
            'sizes' => DB::table('product_variants')->whereNotNull('size')->where('size', '!=', '')->distinct()->pluck('size')->filter()->toArray(),
        ];

        // Get price range
        $priceRange = DB::table('product_variants')
            ->selectRaw('MIN(COALESCE(discount_price, price)) as min_price, MAX(COALESCE(discount_price, price)) as max_price')
            ->first();

        return view('web.multi-product', compact('products', 'filterOptions', 'priceRange'));
    }

    public function ShowSingleProduct($id)
    {
        // dd($id);
        $product = Product::with([
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'size', 'color', 'price', 'discount_price', 'stock');
            },
            'images' => function ($query) {
                $query->select('product_id', 'image');
            }
        ])
            ->where('is_active', 1)
            ->where('id', $id)
            ->firstOrFail();

        // dd($product);
        return view('web.single-product', compact('product'));
    }
}
