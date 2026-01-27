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
        $products = DB::table('products')
            ->rightJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
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
                'product_images.image'
            )
            ->get();




        $categories = Category::withCount('products')->get();


        $testimonials = [];

        return view('web.home', compact('data', 'testimonials', 'categories', 'products'));
    }

    public function ShowAllProduct()
    {

        //  $products = DB::table('products')
        //         ->rightJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        //         ->leftjoin('product_images', 'product_variants.id', '=', 'product_variants.product_id')
        //         ->where('products.is_active', 1)
        //         ->select(
        //             'products.*',
        //             'product_variants.id as variant_id',
        //             'product_variants.size',
        //             'product_variants.color',
        //             'product_variants.price',
        //             'product_variants.discount_price as price_after_discount',
        //             'product_variants.stock'
        //         )
        //         ->get();



        $products = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id') // 👈 inner join
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
            )
            ->get();

        // dd($products);
        return view('web.multi-product', compact('products'));
    }

    public function ShowSingleProduct($id)
    {
        $product = Product::with([
            'variants' => function($query) {
                $query->select('id', 'product_id', 'size', 'color', 'price', 'discount_price', 'stock');
            },
            'images' => function($query) {
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
