<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Profile extends Controller
{
    //
    public function profile()
    {
        $user = auth()->user();
        
        // Get user's order count
        $orderCount = $user ? $user->orders()->count() : 0;
        
        // Get user's wishlist count
        $wishlistCount = $user ? $user->wishlists()->count() : 0;
        
        return view('web.profile', compact('user', 'orderCount', 'wishlistCount'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        $user->update($validated);

        return redirect()->route('web.profile')->with('success', 'Profile updated successfully!');
    }
}
