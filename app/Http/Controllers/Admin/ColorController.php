<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Color::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('color_tone', 'like', "%{$search}%");
            });
        }
        
        $data = $query->orderBy('name')->paginate(15);
        
        return view('Admin.color.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name',
            'code' => 'required',
            'color_tone' => 'nullable|string|max:50',
        ]);

        Color::create($data);

        return redirect()->route('admin.colors')->with('success', 'Color created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('Admin.color.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name,'.$color->id,
            'code' => 'required|string|max:7|unique:colors,code,'.$color->id.'|regex:/^#[0-9A-Fa-f]{6}$/',
            'color_tone' => 'nullable|string|max:50',
        ]);

        $color->update($data);

        return redirect()->route('admin.colors')->with('success', 'Color updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Color $color)
    {
        $color->delete();
        
        return redirect()->route('admin.colors')->with('success', 'Color deleted successfully!');
    }
}
