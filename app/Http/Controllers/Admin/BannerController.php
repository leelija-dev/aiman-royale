<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::ordered()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'discount' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'filter' => 'nullable|string|max:255',
            'filter_type' => 'required|in:single,multiple,discount,category',
            'filter_types' => 'nullable|array',
            'filter_values' => 'nullable|array',
            'type' => 'required|in:main,secondary',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle multiple filters
        if ($request->filter_type === 'multiple' && $request->has('filter_types') && $request->has('filter_values')) {
            $filters = [];
            foreach ($request->filter_types as $index => $type) {
                if (isset($request->filter_values[$index]) && !empty($request->filter_values[$index])) {
                    $filters[] = [
                        'type' => $type,
                        'value' => $request->filter_values[$index]
                    ];
                }
            }
            $data['filters'] = json_encode($filters);
            $data['filter'] = null; // Clear single filter for multiple type
        } else if ($request->filter_type === 'discount') {
            // For discount type, set filter to discount percentage
            $data['filter'] = $request->discount;
            $data['filters'] = null;
        } else if ($request->filter_type === 'category') {
            // For category type, you might want to set filter based on a category field
            $data['filter'] = $request->filter ?? 'category';
            $data['filters'] = null;
        } else {
            // Single filter type
            $data['filters'] = null;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $imageName);
            $data['image'] = $imageName;
        }

        Banner::create($data);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'discount' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'filter' => 'nullable|string|max:255|unique:banners,filter,' . $id,
            'filter_type' => 'required|in:single,multiple,discount,category',
            'filter_types' => 'nullable|array',
            'filter_values' => 'nullable|array',
            'type' => 'required|in:main,secondary',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle multiple filters
        if ($request->filter_type === 'multiple' && $request->has('filter_types') && $request->has('filter_values')) {
            $filters = [];
            foreach ($request->filter_types as $index => $type) {
                if (isset($request->filter_values[$index]) && !empty($request->filter_values[$index])) {
                    $filters[] = [
                        'type' => $type,
                        'value' => $request->filter_values[$index]
                    ];
                }
            }
            $data['filters'] = json_encode($filters);
            $data['filter'] = null; // Clear single filter for multiple type
            $data['filter_type'] = 'multiple'; // Explicitly set filter type
        } else if ($request->filter_type === 'discount') {
            // For discount type, set filter to discount percentage
            $data['filter'] = $request->discount;
            $data['filters'] = null;
            $data['filter_type'] = 'discount'; // Explicitly set filter type
        } else if ($request->filter_type === 'category') {
            // For category type, you might want to set filter based on a category field
            $data['filter'] = $request->filter ?? 'category';
            $data['filters'] = null;
            $data['filter_type'] = 'category'; // Explicitly set filter type
        } else {
            // Single filter type
            $data['filters'] = null;
            $data['filter_type'] = 'single'; // Explicitly set filter type
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
                unlink(public_path('uploads/banners/' . $banner->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $imageName);
            $data['image'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        // Delete image
        if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
            unlink(public_path('uploads/banners/' . $banner->image));
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully!');
    }
}
