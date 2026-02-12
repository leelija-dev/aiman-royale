<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display the addresses page.
     */
    public function index()
    {
        $addresses = collect();
        
        if (Auth::check()) {
            $addresses = Address::where('user_id', Auth::id())
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('web.addresses', compact('addresses'));
    }
    
    /**
     * Store a new address.
     */
    public function store(Request $request)
    {
        // dd($request);
        // Debug: Log incoming request data
        \Log::info('Address store request data:', $request->all());
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'landmark' => 'nullable|string|max:255',
            'address_type' => 'nullable|string|in:home,work,other',
            // 'is_default' => 'boolean',
        ]);
        
        // Debug: Log after validation
        \Log::info('Address validation passed');
        
        // If this is set as default, unset all other default addresses
        if ($request->is_default) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }
        
        $address = Address::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'landmark' => $request->landmark,
            'address_type' => $request->address_type,
            'is_default' => $request->is_default ?? false,
        ]);
        
        // Debug: Log after creation
        \Log::info('Address created:', $address->toArray());
        
        return redirect()->route('addresses.index')
            ->with('success', 'Address added successfully!');
    }
    
    /**
     * Update an existing address.
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'phone_no' => 'nullable|string|max:20',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'landmark' => 'nullable|string|max:255',
            'address_type' => 'nullable|string|in:home,work,other',
            'is_default' => 'boolean',
        ]);
        
        // If this is set as default, unset all other default addresses
        if ($request->is_default) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }
        
        $address->update([
            'name' => $request->name,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'phone_no' => $request->phone_no,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'landmark' => $request->landmark,
            'address_type' => $request->address_type,
            'is_default' => $request->is_default ?? false,
        ]);
        
        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully!');
    }
    
    /**
     * Delete an address.
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        
        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully!');
    }
    
    /**
     * Set an address as default.
     */
    public function setDefault($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        
        // Unset all other default addresses
        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        
        // Set this address as default
        $address->update(['is_default' => true]);
        
        return redirect()->route('addresses.index')
            ->with('success', 'Address set as default successfully!');
    }
}
