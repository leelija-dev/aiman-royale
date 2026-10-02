<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $search = request('search');
        $coupons = Coupon::orderBy('id', 'desc')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('discount', 'like', '%' . $search . '%')
                    ->orWhere('code_type', 'like', '%' . $search . '%')
                    ->orWhere('minimum_amount', 'like', '%' . $search . '%')
                    ->orWhere('expiry_date', 'like', '%' . $search . '%')
                    ->orWhere('is_active', 'like', '%' . $search . '%')
                    ->orWhere('code_for', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        return view('Admin.coupon.index', compact('coupons'));
    }
    public function create()
    {
        return view('Admin.coupon.create');
    }
    public function store(Request $request)
    {
        
            $data = $request->validate([
                'name' => 'required',
                'code' => 'required|unique:coupon,code',
                'discount' => 'required|numeric',
                'validity' =>   'required',
                'code_type' => 'required',
                'minimum_amount' => 'nullable|numeric|min:0',
                'code_for' => 'nullable',
                'is_active' => 'required',

            ]);
            $data['minimum_amount'] = $data['minimum_amount'] ?? 0;
        try {
            $expireDate = Carbon::now()->addDays((int)$data['validity'])->endOfDay();
            $data['expiry_date'] = $expireDate;
            Coupon::create($data);
            return redirect()->route('coupon.index')->with('success', 'Coupon created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('Admin.coupon.edit', compact('coupon'));
    }
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
                'code' => 'required|unique:coupon,code,' . $id,
                'discount' => 'required|numeric',
                'validity' =>   'required|min:1',
                'code_type' => 'required',
                'minimum_amount' => 'nullable|numeric',
                'code_for' => 'nullable',
                'is_active' => 'required',
            ]);
           $expireDate = Carbon::now()->addDays((int) $data['validity'])->endOfDay();
            $data['expiry_date'] = $expireDate;
            $coupon = Coupon::findOrFail($id);
            $coupon->update($data);
            return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function delete($id){
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();
            return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
