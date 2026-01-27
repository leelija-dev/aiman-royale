<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = Cart::with(['product', 'variant'])
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->count;
        });

        $shipping = $subtotal > 400 ? 0 : 50; // Free shipping over $400
        $total = $subtotal + $shipping;
        $cartCount = $cartItems->sum('count');

        return view('web.cart', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartCount'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'variant_id' => 'required|exists:product_variants,id',
                'count' => 'required|integer|min:1',
            ]);

            $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
            
            // Check if variant is in stock
            if ($variant->stock < $request->count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $variant->stock . ' items left.'
                ]);
            }

            // Get user or session
            $userId = Auth::id();
            $sessionId = $userId ? null : session()->getId();

            // Check if item already exists in cart
            $existingCart = Cart::where('variant_id', $request->variant_id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if ($existingCart) {
                // Update existing cart item
                $newCount = $existingCart->count + $request->count;
                
                if ($variant->stock < $newCount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available. Only ' . $variant->stock . ' items left.'
                    ]);
                }

                $existingCart->update([
                    'count' => $newCount,
                    'price' => $variant->discount_price ?? $variant->price
                ]);

                $cartCount = $this->getCartCount();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_count' => $cartCount
                ]);
            } else {
                // Add new item to cart
                Cart::create([
                    'product_id' => $variant->product_id,
                    'variant_id' => $request->variant_id,
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'count' => $request->count,
                    'price' => $variant->discount_price ?? $variant->price
                ]);

                $cartCount = $this->getCartCount();

                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully!',
                    'cart_count' => $cartCount
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'count' => 'required|integer|min:1',
            ]);

            $userId = Auth::id();
            $sessionId = $userId ? null : session()->getId();

            $cartItem = Cart::where('id', $id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ]);
            }

            // Check stock
            $variant = $cartItem->variant;
            if ($variant && $variant->stock < $request->count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $variant->stock . ' items left.'
                ]);
            }

            $cartItem->update(['count' => $request->count]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::id();
            $sessionId = $userId ? null : session()->getId();

            $cartItem = Cart::where('id', $id)
                ->where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ]);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    private function getCartCount()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->sum('count');
    }
}
