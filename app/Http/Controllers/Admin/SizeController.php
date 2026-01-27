<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Size::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        
        $data = $query->orderBy('sort_order')->orderBy('name')->paginate(15);
        
        return view('Admin.size.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.size.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20|unique:sizes,name',
            'code' => 'required|string|max:10|unique:sizes,code',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Size::create($data);

        return redirect()->route('admin.sizes')->with('success', 'Size created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('Admin.size.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20|unique:sizes,name,'.$size->id,
            'code' => 'required|string|max:10|unique:sizes,code,'.$size->id,
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $size->update($data);

        return redirect()->route('admin.sizes')->with('success', 'Size updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Size $size)
    {
        $size->delete();
        
        return redirect()->route('admin.sizes')->with('success', 'Size deleted successfully!');
    }
}
