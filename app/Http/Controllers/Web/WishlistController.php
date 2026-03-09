<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index()
    {
        $wishlistItems = Wishlist::with(['product.images', 'product.variants'])
            ->forCurrentUser()
            ->paginate(9);
            // ->get();
            dd($wishlistItems);
            
        // Load stock data for each wishlist item
        $wishlistItems->each(function ($wishlist) {
            // Get stock from stock_in table for this product/variant
            $stockQuery = DB::table('stock_in')
                ->where('product_id', $wishlist->product_id);
                
            // If variant exists, get variant-specific stock
            if ($wishlist->variant_id) {
                $stockQuery->where('product_variant_id', $wishlist->variant_id);
            } else {
                $stockQuery->whereNull('product_variant_id');
            }
            
            $stockRecord = $stockQuery->first();
            $wishlist->stock = $stockRecord ? $stockRecord->stock : 0;
        });
        
        // Calculate wishlist statistics
        $totalItems = $wishlistItems->count();
        $totalValue = $wishlistItems->sum(function($item) {
            return $item->product->discount_price ?? $item->product->price ?? 0;
        });
        $onSaleItems = $wishlistItems->filter(function($item) {
            return $item->product->discount_price && $item->product->discount_price < $item->product->price;
        })->count();
        
        // Get user data
        $user = auth()->user();
        $userInitials = $user ? substr($user->name, 0, 2) : 'GU';
        $userName = $user ? $user->name : 'Guest User';
        // dd($wishlistItems->pluck('variant_id'));

        return view('web.wishlist', compact('wishlistItems', 'totalItems', 'totalValue', 'onSaleItems', 'userInitials', 'userName'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'nullable|exists:product_variants,id',
            ]);

            $userId = Auth::id();
            $sessionId = $userId ? null : session()->getId();

            // Check if product already in wishlist
            $existingWishlist = Wishlist::where('product_id', $request->product_id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if ($existingWishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in wishlist!'
                ]);
            }

            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'session_id' => $sessionId,
            ]);

            $wishlistCount = $this->getWishlistCount();

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully!',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $userId = Auth::id();
            $sessionId = $userId ? null : session()->getId();

            $wishlistItem = Wishlist::where('product_id', $request->product_id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if (!$wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in wishlist!'
                ]);
            }

            $wishlistItem->delete();

            $wishlistCount = $this->getWishlistCount();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully!',
                'wishlist_count' => $wishlistCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::id();
        $sessionId = $userId ? null : session()->getId();

        $wishlistItem = Wishlist::where('product_id', $productId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        return response()->json([
            'in_wishlist' => $wishlistItem ? true : false
        ]);
    }

    /**
     * Get wishlist count for current user/session
     */
    private function getWishlistCount()
    {
        $userId = Auth::id();
        $sessionId = $userId ? null : session()->getId();

        return Wishlist::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->count();
    }
}
