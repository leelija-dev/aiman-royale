<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Cashfree\Model\Products;
use App\Models\Occasion;
use App\Models\Product;
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

            // Alternative approach using direct join with product_occasions table
            // $occasions = \App\Models\Occasion::join('product_occasions', 'ocassions.id', '=', 'product_occasions.occasion_id')
            //     ->join('products', 'product_occasions.product_id', '=', 'products.id')
            //     ->where('products.category_id', $categoryId)
            //     ->where('products.status', 'active')
            //     ->where('ocassions.is_active', true)
            //     ->whereNull('products.deleted_at')
            //     ->whereNull('ocassions.deleted_at')
            //     ->select('ocassions.id', 'ocassions.name', 'ocassions.slug', 'ocassions.description', 'ocassions.parent_id')
            //     ->selectRaw('COUNT(DISTINCT products.id) as products_count')
            //     ->groupBy('ocassions.id', 'ocassions.name', 'ocassions.slug', 'ocassions.description', 'ocassions.parent_id')
            //     ->get();

            $occasions = \App\Models\Occasion::join('product_occasions', 'ocassions.id', '=', 'product_occasions.occasion_id')
                ->join('products', 'product_occasions.product_id', '=', 'products.id')
                ->where('products.category_id', $categoryId)
                ->where('products.status', 'active')
                ->where('ocassions.is_active', true)
                ->whereNull('products.deleted_at')
                ->whereNull('ocassions.deleted_at')
                ->select('ocassions.id', 'ocassions.name', 'ocassions.slug', 'ocassions.description', 'ocassions.parent_id')
                ->selectRaw('COUNT(DISTINCT products.id) as products_count')
                ->selectSub(
                    \App\Models\Product::join('product_occasions', 'product_occasions.product_id', '=', 'products.id')
                        ->whereColumn('product_occasions.occasion_id', 'ocassions.id')
                        ->where('products.category_id', $categoryId)
                        ->where('products.status', 'active')
                        ->whereNull('products.deleted_at')
                        ->orderBy('products.created_at', 'desc')
                        ->limit(1)
                        ->select('products.featured_image'),
                    'latest_product_image'
                )
                ->groupBy('ocassions.id', 'ocassions.name', 'ocassions.slug', 'ocassions.description', 'ocassions.parent_id')
                ->get();

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

    public function getCategoryProductUsingOccasionSlug($slug)
    {
        try {
            // Find the occasion by slug
            $occasion = Occasion::where('slug', $slug)->first();

            if (!$occasion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Occasion not found'
                ], 404);
            }

            $occasionId = $occasion->id;

            // Get categories with products for this occasion
            $categories = Category::whereHas('products', function ($query) use ($occasionId) {
                $query->whereHas('occasions', function ($subQuery) use ($occasionId) {
                    $subQuery->where('occasion_id', $occasionId);
                })
                    ->where('is_active', 1)
                    ->where('ready_to_ship', 1);
            })
                ->where('is_active', 1)
                ->with(['products' => function ($query) use ($occasionId) {
                    $query->whereHas('occasions', function ($subQuery) use ($occasionId) {
                        $subQuery->where('occasion_id', $occasionId);
                    })
                        ->where('is_active', 1)
                        ->where('ready_to_ship', 1)
                        ->with(['variants', 'images']);
                }])
                ->withCount(['products' => function ($query) use ($occasionId) {
                    $query->whereHas('occasions', function ($subQuery) use ($occasionId) {
                        $subQuery->where('occasion_id', $occasionId);
                    })
                        ->where('is_active', 1)
                        ->where('ready_to_ship', 1);
                }])
                ->orderBy('products_count', 'desc')
                ->get();

            $products = Product::whereHas('occasions', function ($query) use ($occasionId) {
                $query->where('occasion_id', $occasionId);
            })
                ->where('is_active', 1)
                ->where('ready_to_ship', 1)
                ->with(['variants', 'images'])
                ->get();

            // dd($products);

            // Format the response
            $formattedCategories = $categories->map(function ($category) use ($occasionId) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image' => $category->image,
                    'product_count' => $category->products_count,
                    'products' => $category->products->map(function ($product) {
                        // Get first variant price and discount
                        $firstVariant = $product->variants->first();

                        // Get first image
                        $firstImage = $product->images->first();

                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'design_no' => $product->design_no,
                            'brand' => $product->brand,
                            'description' => $product->description,
                            'price' => $firstVariant ? $firstVariant->price : $product->price,
                            'discount_price' => $firstVariant ? $firstVariant->discount_price : $product->discount_price,
                            'stock' => $product->stock,
                            'is_featured' => $product->is_featured,
                            'image' => $firstImage ? $firstImage->image : $product->featured_image,
                            'variants' => $product->variants->map(function ($variant) {
                                return [
                                    'id' => $variant->id,
                                    'size' => $variant->size,
                                    'color' => $variant->color,
                                    'price' => $variant->price,
                                    'discount_price' => $variant->discount_price,
                                    'stock' => $variant->stock,
                                ];
                            }),
                            'images' => $product->images->map(function ($image) {
                                return [
                                    'id' => $image->id,
                                    'image' => $image->image,
                                ];
                            }),
                        ];
                    }),
                ];
            });



            return response()->json([
                'success' => true,
                'data' => [
                    'occasion' => [
                        'id' => $occasion->id,
                        'name' => $occasion->name,
                        'slug' => $occasion->slug,
                        'description' => $occasion->description,
                    ],
                    'style' => $formattedCategories,
                    'total_categories' => $categories->count(),
                    'total_products' => $categories->sum('products_count'),
                    'collection' => $products
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories and products: ' . $e->getMessage()
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

            // Get occasions that have products belonging to the specific category using direct join
            $occasions = \App\Models\Occasion::join('product_occasions', 'occasions.id', '=', 'product_occasions.occasion_id')
                ->join('products', 'product_occasions.product_id', '=', 'products.id')
                ->where('products.category_id', $categoryId)
                ->where('products.status', 'active')
                ->where('occasions.is_active', true)
                ->whereNull('products.deleted_at')
                ->whereNull('occasions.deleted_at')
                ->select('occasions.id', 'occasions.name', 'occasions.slug', 'occasions.description', 'occasions.parent_id')
                ->selectRaw('COUNT(DISTINCT products.id) as products_count')
                ->groupBy('occasions.id', 'occasions.name', 'occasions.slug', 'occasions.description', 'occasions.parent_id')
                ->get();

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

    // In your CategoryController or a new FilterController

    public function getFilterOptions(Request $request)
    {
        $categorySlug = $request->category_slug;
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }

        // Get all products in this category
        $products = Product::where('category_id', $category->id)->get();

        // Get filter options from product variants
        $filters = [
            // Filter options (featured, best-seller, etc.) - these can be static or dynamic
            'filter_options' => [
                ['value' => 'featured', 'label' => 'Featured'],
                ['value' => 'best-seller', 'label' => 'Best Seller'],
                ['value' => 'new-arrival', 'label' => 'New Arrival'],
                ['value' => 'top-rated', 'label' => 'Top Rated'],
            ],

            // Get occasions from products or a separate table
            'occasions' => Occasion::whereHas('products', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->get()->map(function ($occasion) {
                return ['id' => $occasion->id, 'name' => $occasion->name];
            })->toArray(),

            // Get collections from products or a separate table
            'collections' => Category::whereHas('products', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->get()->map(function ($collection) {
                return ['value' => $collection->slug, 'label' => $collection->name];
            })->toArray(),

            // Sort options
            'sort_options' => [
                ['value' => 'name-asc', 'label' => 'Name (A to Z)'],
                ['value' => 'name-desc', 'label' => 'Name (Z to A)'],
                ['value' => 'date-desc', 'label' => 'Date (Newest first)'],
                ['value' => 'date-asc', 'label' => 'Date (Oldest first)'],
                ['value' => 'price-asc', 'label' => 'Price (Low to High)'],
                ['value' => 'price-desc', 'label' => 'Price (High to Low)'],
            ]
        ];

        return response()->json(['success' => true, 'filters' => $filters]);
    }
}
