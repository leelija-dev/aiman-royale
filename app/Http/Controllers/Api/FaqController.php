<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Faq;
use App\Models\Product;

class FaqController extends Controller
{
    //
    /**
     * Get all products
     *
     * @return JsonResponse
     */
    public function getAllFaqs(): JsonResponse
    {
        try {
            $faqs = Faq::where('is_active', 1)
                ->with(['category', 'product'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $faqs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving products: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getFaqUsingCategory(int $categoryId): JsonResponse  //http://127.0.0.1:8000/api/faqs/category/2
    {
        try {
            $faqs = Faq::where('is_active', 1)
                ->where('category_id', $categoryId)
                ->with(['category', 'product'])
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $faqs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving FAQs by category: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getFaqsUsingId($faqId): JsonResponse
    {
        try {
            $faq = Faq::where('is_active', 1)
                ->where('id', $faqId)
                ->with(['category', 'product'])
                ->first();

            if (!$faq) {
                return response()->json([
                    'success' => false,
                    'message' => 'FAQ not found',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $faq
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving FAQ: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getFaqsUsingproductId($productSlug): JsonResponse
    {
        try {
            // Get product by slug first
            $product = Product::where('slug', $productSlug)->first();
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'data' => null
                ], 404);
            }

            // Get FAQs using product ID with only category name and product name
            $faqs = Faq::where('is_active', 1)
                ->where('product_id', $product->id)
                ->with(['category:id,category_name', 'product:id,name'])
                ->get();

            if ($faqs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No FAQs found for this product',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $faqs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving FAQ: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
