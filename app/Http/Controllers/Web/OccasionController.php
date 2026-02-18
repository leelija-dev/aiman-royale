<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    public function show($slug)
    {
        $occasion = Occasion::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

            // dd($occasion);
        $products = Product::where('ocassion_id', $occasion->id)
            ->where('is_active', 1)
            ->where('ready_to_ship', 1)
            ->with(['images' => function($query) {
                $query->select('product_id', 'image');
            }])
            ->select('products.*')
            ->latest()
            ->paginate(12);

        $occasions = Occasion::active()->get();

        return view('web.occasion', compact('occasion', 'products', 'occasions'));
    }
}
