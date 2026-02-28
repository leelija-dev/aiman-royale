<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomDimension;
use Illuminate\Http\Request;

class CustomDimensionController extends Controller
{
    /**
     * Display all custom dimension requests for admin.
     */
    public function index()
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
}
