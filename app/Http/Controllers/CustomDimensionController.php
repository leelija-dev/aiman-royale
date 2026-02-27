<?php

namespace App\Http\Controllers;

use App\Models\CustomDimension;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomDimensionController extends Controller
{
    /**
     * Display user's custom dimension requests.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all custom dimension requests for the user with product relationship
        $customRequests = CustomDimension::where('user_id', $user->id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web.custom-request', compact('customRequests'));
    }

    /**
     * Store custom dimensions for a product.
     */
    public function store(Request $request)
    {
        // Debug: Log the incoming request
        \Log::info('Custom dimensions request data:', $request->all());

        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save custom dimensions',
                'redirect' => route('page.login')
            ], 401);
        }

        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'bust' => 'nullable|numeric|min:1|max:500',
            'waist' => 'nullable|numeric|min:1|max:500',
            'hip' => 'nullable|numeric|min:1|max:500',
            'armhole' => 'nullable|numeric|min:1|max:500',
            'color_code' => 'nullable|string|max:20'
        ]);

        try {
            // Debug: Log validated data
            \Log::info('Validated data for user ' . Auth::id() . ':', [
                'product_id' => $request->product_id,
                'bust' => $request->bust,
                'waist' => $request->waist,
                'hip' => $request->hip,
                'armhole' => $request->armhole,
                'color_code' => $request->color_code
            ]);

            // Always create new record to allow multiple requests
            $dimension = CustomDimension::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'bust' => $request->bust,
                'waist' => $request->waist,
                'hip' => $request->hip,
                'armhole' => $request->armhole,
                'color_code' => $request->color_code,
                'status' => 'requested',
            ]);

            \Log::info('Created new custom dimension request:', $dimension->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Your custom dimension request has been sent! Our team will contact you within 24 hours.',
                'data' => $dimension
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving custom dimensions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save custom dimensions. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get custom dimensions for a product.
     */
    public function show($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view custom dimensions'
            ], 401);
        }

        $dimension = CustomDimension::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $dimension
        ]);
    }

    /**
     * Display all custom dimension requests for admin.
     */
    public function adminIndex()
    {
        // Get all custom dimension requests with user and product relationships
        $customRequests = CustomDimension::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.custom-dimensions.index', compact('customRequests'));
    }

    /**
     * Update custom dimension request status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:requested,viewed,processing,accepted,canceled'
        ]);

        $dimension = CustomDimension::find($id);

        if (!$dimension) {
            return response()->json([
                'success' => false,
                'message' => 'Custom dimension request not found'
            ], 404);
        }

        $dimension->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $dimension
        ]);
    }

    public function cancel($id)
    {
        $dimension = CustomDimension::find($id);

        if (!$dimension) {
            return redirect()->back()->with('error', 'Record not found');
        }

        $dimension->update([
            'status' => 'canceled'
        ]);

        return redirect()->back()->with('success', 'Order canceled successfully');
    }
    /**
     * Delete custom dimensions for a product.
     */
    public function destroy($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to delete custom dimensions'
            ], 401);
        }

        $dimension = CustomDimension::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($dimension) {
            $dimension->delete();
            return response()->json([
                'success' => true,
                'message' => 'Custom dimensions deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No custom dimensions found for this product'
        ], 404);
    }
}
