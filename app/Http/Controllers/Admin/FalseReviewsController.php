<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FalseReview;
use App\Models\Product;
use Illuminate\Http\Request;

class FalseReviewsController extends Controller
{
    // Display all reviews
    public function index()
    {
        $reviews = FalseReview::with('product')  //, 'user'
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    // Show form to create new review
    public function create()
    {
        $products = Product::where('is_active', 1)->pluck('name', 'id');
        
        return view('admin.reviews.create', compact('products'));
    }

    // Store new review
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        FalseReview::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'is_verified' => $request->boolean('is_verified', false),
            'is_featured' => $request->boolean('is_featured', false),
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review created successfully!');
    }

    // Show single review
    public function show(FalseReview $review)
    {
        $review->load(['product', 'user']);
        
        return view('admin.reviews.show', compact('review'));
    }

    // Show form to edit review
    public function edit(FalseReview $review)
    {
        $products = Product::where('is_active', 1)->pluck('name', 'id');
        
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    // Update review
    public function update(Request $request, FalseReview $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'admin_notes' => $request->admin_notes ?? ''
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    // Delete review
    public function destroy(FalseReview $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    // Bulk actions (approve/reject/delete multiple reviews)
    public function bulkAction(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:false_reviews,id',
            'action' => 'required|in:approve,reject,delete'
        ]);

        $reviewIds = $request->review_ids;

        switch ($request->action) {
            case 'approve':
                FalseReview::whereIn('id', $reviewIds)->update(['status' => 'approved']);
                $message = 'Reviews approved successfully!';
                break;
            case 'reject':
                FalseReview::whereIn('id', $reviewIds)->update(['status' => 'rejected']);
                $message = 'Reviews rejected successfully!';
                break;
            case 'delete':
                FalseReview::whereIn('id', $reviewIds)->delete();
                $message = 'Reviews deleted successfully!';
                break;
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', $message);
    }

    // Toggle review status (pending/approved/rejected)
    public function toggleStatus(FalseReview $review)
    {
        $statuses = ['pending', 'approved', 'rejected'];
        $currentIndex = array_search($review->status, $statuses);
        $newStatus = $statuses[($currentIndex + 1) % count($statuses)];

        $review->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => "Review status changed to {$newStatus}"
        ]);
    }

    // Toggle featured status
    public function toggleFeatured(FalseReview $review)
    {
        $review->update([
            'is_featured' => !$review->is_featured
        ]);

        return response()->json([
            'success' => true,
            'is_featured' => $review->is_featured,
            'message' => $review->is_featured ? 'Review marked as featured' : 'Review removed from featured'
        ]);
    }

    // Toggle verified status
    public function toggleVerified(FalseReview $review)
    {
        $review->update([
            'is_verified' => !$review->is_verified
        ]);

        return response()->json([
            'success' => true,
            'is_verified' => $review->is_verified,
            'message' => $review->is_verified ? 'Review marked as verified' : 'Review marked as unverified'
        ]);
    }
}
