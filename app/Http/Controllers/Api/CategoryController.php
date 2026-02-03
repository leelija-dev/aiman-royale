<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Cashfree\Model\Products;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Get all child categories by parent category ID
     *
     * @param int $categoryId
     * @return JsonResponse
     */
    public function getChildCategories($categoryId): JsonResponse
    {
        try {
            // Validate if parent category exists
            $parentCategory = Category::find($categoryId);

            if (!$parentCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent category not found',
                    'data' => null
                ], 404);
            }

            // Get child categories
            $childCategories = Category::where('parent_id', $categoryId)
                ->where('is_active', true)
                ->withCount('products') // Include product count if needed
                ->get(['id', 'name', 'slug', 'description', 'image', 'parent_id', 'products_count']);

            $occasions = \App\Models\Occasion::whereHas('products', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
                ->where('is_active', true)
                ->withCount(['products' => function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                }])
                ->get(['id', 'name', 'slug', 'description', 'parent_id']);

            // Get all category IDs (parent + children)
            $categoryIds = collect([$categoryId])->merge($childCategories->pluck('id'));

            // Get products from parent category and all child categories
            $products = \App\Models\Product::whereIn('category_id', $categoryIds)
                ->where('status', 'active')
                ->with(['images', 'variants', 'category', 'occasion'])
                ->get();

            // Group products by category for better organization
            $productsByCategory = $products->groupBy('category_id');

            // $collections = Products::where('category_id', $categoryId)
           

            return response()->json([
                'success' => true,
                'message' => 'Child categories retrieved successfully',
                'data' => [
                    'parent_category' => [
                        'id' => $parentCategory->id,
                        'name' => $parentCategory->name,
                        'slug' => $parentCategory->slug
                    ],
                    'style' => $childCategories,
                    'ocassions' => $occasions,
                    'collection' => [
                        // 'all_products' => $products,
                        'products_by_category' => $productsByCategory,
                        'total_products' => $products->count(),
                        'parent_category_products' => $productsByCategory->get($categoryId, collect()),
                        'child_categories_products' => $productsByCategory->filter(function ($products, $categoryIdKey) use ($categoryId) {
                            return $categoryIdKey != $categoryId;
                        })
                    ],
                    'total_child_categories' => $childCategories->count()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving child categories: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getOccassionByCategoryId($categoryId): JsonResponse
    {
        try {
            // Validate if parent category exists
            $parentCategory = Category::find($categoryId);

            if (!$parentCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent category not found',
                    'data' => null
                ], 404);
            }

            // Get occasions that have products belonging to the specific category
            $occasions = \App\Models\Occasion::whereHas('products', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
                ->where('is_active', true)
                ->withCount(['products' => function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                }])
                ->get(['id', 'name', 'slug', 'description', 'parent_id']);

            return response()->json([
                'success' => true,
                'message' => 'Occasions retrieved successfully for category',
                'data' => [
                    'parent_category' => [
                        'id' => $parentCategory->id,
                        'name' => $parentCategory->name,
                        'slug' => $parentCategory->slug
                    ],
                    'occasions' => $occasions,
                    'total_occasions' => $occasions->count()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving occasions: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
