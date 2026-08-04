<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = Cart::with(['product.images', 'variant'])
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
       

        $subtotal = $cartItems->sum(function ($item) {
                //  dd($item->variant->discount_price);

            return (($item->variant->price - (($item->variant->price * $item->variant->discount) / 100)) * $item->count);
        });
        
        $shipping = $subtotal > 400 ? 0 : 50; // Free shipping over $400
        $total = $subtotal + $shipping;
        $cartCount = $cartItems->sum('count');
        
        $occasions = \App\Models\Occasion::active()->get();

        // Check if we need to force refresh (coming from checkout)
        $forceRefresh = session()->pull('force_cart_refresh', false);

        return view('web.cart', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartCount', 'occasions', 'forceRefresh'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'variant_id' => 'required|exists:product_variants,id',
                'count' => 'required|integer|min:1',
            ]);

            $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
            // dd($variant);
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

    public function buyNow(Request $request)
    {
        try {
            $request->validate([
                'variant_id' => 'nullable|exists:product_variants,id',
                'product_id' => 'nullable|exists:products,id',
                'count' => 'required|integer|min:1',
                'type' => 'nullable|string',
                'custom_dimensions' => 'nullable|array',
            ]);

            $variant = null;
            if ($request->filled('variant_id')) {
                $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
            } elseif ($request->filled('product_id')) {
                $variant = ProductVariant::with('product')->where('product_id', $request->product_id)->first();
            }

            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a valid variant first.'
                ], 422);
            }

            if ($variant->stock < $request->count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $variant->stock . ' items left.'
                ], 422);
            }

            session()->put('checkout_source', 'buy_now');
            session()->put('checkout_payload', [
                'items' => [[
                    'cart_id' => 0,
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id,
                    'name' => $variant->product->name,
                    'size' => $variant->size,
                    'color' => $variant->color,
                    'price' => $variant->price ?? $variant->price,
                    'discount' => $variant->discount ?? 0,
                    'discount_price' => $variant->discount_price ?? $variant->price,
                    'count' => $request->count,
                    'type' => $request->input('type', 'stitched'),
                    'custom_dimensions' => $request->input('custom_dimensions'),
                    'image' => optional($variant->product)->featured_image,
                ]]
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('checkout.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'count' => 'required|integer|min:1',
    //         ]);

    //         $userId = Auth::id();
    //         $sessionId = $userId ? null : session()->getId();

    //         $cartItem = Cart::where('id', $id)
    //             ->where(function ($query) use ($userId, $sessionId) {
    //                 if ($userId) {
    //                     $query->where('user_id', $userId);
    //                 } else {
    //                     $query->where('session_id', $sessionId);
    //                 }
    //             })
    //             ->first();

    //         if (!$cartItem) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Cart item not found'
    //             ]);
    //         }

    //         // Check stock
    //         $variant = $cartItem->variant;
    //         if ($variant && $variant->stock < $request->count) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Not enough stock available. Only ' . $variant->stock . ' items left.'
    //             ]);
    //         }

    //         $cartItem->update(['count' => $request->count]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Cart updated successfully!'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ]);
    //     }
    // }

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

    public function checkVariantInCart(Request $request)
    {
        $variantId = $request->variant_id;
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItem = Cart::where('variant_id', $variantId)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        return response()->json([
            'in_cart' => $cartItem ? true : false,
            'quantity' => $cartItem ? $cartItem->count : 0
        ]);
    }
    public function update(Request $request)
{
    $data=$request->validate([
        'cart_id' => 'required|array',
        'cart_id.*' => 'integer|exists:carts,id',
        'quantity' => 'required|array',
        'quantity.*' => 'integer|min:1',
    ]);
    // dd($data);
    foreach ($request->cart_id as $index => $cartId) {

        $cart = Cart::findorFail($cartId);

        if ($cart) {
            $cart->count = $request->quantity[$index];
            $cart->save();
        }
    }

    return redirect()->route('checkout.index');
}



public function applyCoupon(Request $request)
{
    $validator = Validator::make($request->all(), [
    'coupon_code' => 'required',
    'total' => 'required|numeric',
]);

if ($validator->fails()) {
    return response()->json([
        'status' => false,
        'message' => $validator->errors()->first(),
    ]);
}

    $coupon = Coupon::where('code', $request->coupon_code)->where('code_type','!=','special-discount') 
        // ->where('expiry_date', '>=', Carbon::now())
        ->where('is_active', 1)->select('id','code','discount','expiry_date')
        ->first();

    if (!$coupon) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid coupon code.'
        ]);
    }

    if (Carbon::now()->gt($coupon->expiry_date)) {
        return response()->json([
            'status' => false,
            'message' => 'Coupon has expired.'
        ]);
    }

    // if ($coupon->code_type == 'special' && $request->total < $coupon->minimum_amount) {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Minimum order amount is ₹'.$coupon->minimum_amount
    //     ]);
    // }

    // $discount = ($request->total * $coupon->discount) / 100;
    // $grandTotal = $request->total - $discount;

    return response()->json([
        'status' => true,
        'message' => 'Coupon applied successfully.',
        'coupon' => $coupon
    ]);
}
}
