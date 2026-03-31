<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FalseReview;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'order_id' => 'nullable|exists:orders,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|min:10'
        ]);

        $review = FalseReview::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id ?? auth()->id(),
            'order_id' => $request->order_id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'is_verified' => false,
            'is_featured' => false,
            'status' => 'approved',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review
        ], 201);
    }

    /**
     * Get reviews for a specific product by slug
     */
    public function getProductReviews($productSlug): JsonResponse
    {
        try {
            // Get product by slug first
            $product = Product::where('slug', $productSlug)
                ->where('status', 'active')
                ->select('id', 'name')
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'data' => null
                ], 404);
            }

            // Get approved reviews for the product
            $reviews = FalseReview::where('product_id', $product->id)
                ->with('product:id,name') // ✅ only name (id required internally)
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate rating statistics
            $totalReviews = $reviews->count();
            $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 2) : 0;

            $ratingDistribution = [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ];

            // Calculate percentages
            $ratingPercentages = [];
            foreach ($ratingDistribution as $rating => $count) {
                $ratingPercentages[$rating] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            }

            // Get verified reviews count
            $verifiedReviews = $reviews->where('is_verified', true)->count();
            $verifiedPercentage = $totalReviews > 0 ? round(($verifiedReviews / $totalReviews) * 100) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'product' => $product,
                    'reviews' => $reviews,
                    'statistics' => [
                        'total_reviews' => $totalReviews,
                        'average_rating' => $averageRating,
                        'verified_reviews' => $verifiedReviews,
                        'verified_percentage' => $verifiedPercentage,
                        'rating_distribution' => $ratingDistribution,
                        'rating_percentages' => $ratingPercentages
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching reviews: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
