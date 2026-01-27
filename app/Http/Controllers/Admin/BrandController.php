<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(15);
        return view('Admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191|unique:brands,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|in:0,1',
        ]);

        // Ensure is_active is set to 0 if not provided
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $brand = Brand::create($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('Admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        // Eager load any relationships that might be needed in the view
        $brand->load('products');
        
        return view('Admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|in:0,1',
        ]);

        // Ensure is_active is set to 0 if not provided
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $brand->update($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        
        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand moved to trash successfully.');
    }

    /**
     * Display a listing of the trashed brands.
     */
    public function trashed()
    {
        $brands = Brand::onlyTrashed()->latest()->paginate(10);
        return view('Admin.brands.trashed', compact('brands'));
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();
        
        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', 'Brand restored successfully.');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->forceDelete();
        
        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', 'Brand permanently deleted.');
    }
}
