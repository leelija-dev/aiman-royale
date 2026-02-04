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
     * Get all child categories by parent category ID
     *
     * @param int $categoryId
     * @return JsonResponse
     */
    public function getAllProduct(): JsonResponse
    {
        try {

            $products = Product::where('is_active', 1)
                ->with(['images', 'variants', 'category', 'occasion'])
                ->get();
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving child categories: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
