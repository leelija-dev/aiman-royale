<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Traits\CloudinaryUploadTrait;  // ← Add this line
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    use CloudinaryUploadTrait;
    public function index()
    {
        $banners = Banner::ordered()->get();
        return view('Admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('Admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10048',
            'discount' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'filter' => 'nullable|string|max:255',
            'filter_type' => 'required|in:single,multiple,discount,category',
            'filter_types' => 'nullable|array',
            'filter_values' => 'nullable|array',
            'type' => 'required|in:main,secondary,editor',
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

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('uploads/banners'), $imageName);
        //     $data['image'] = $imageName;
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // UPLOAD NEW IMAGE TO CLOUDINARY
            $uploadResult = $this->uploadToCloudinary($image, 'aiman/banners', [
                'quality' => 'auto:good',
                'fetch_format' => 'auto',
                'transformation' => [
                    'width' => 800,
                    'height' => 800,
                    'crop' => 'limit',
                ],
            ]);

            if ($uploadResult) {
                $data['image'] = $uploadResult['path']; // Store the Cloudinary URL
                $data['image_public_id'] = $uploadResult['public_id']; // Store public_id for future deletion
                Log::info('Banner image uploaded to Cloudinary', [
                    'public_id' => $uploadResult['public_id'],
                    'path' => $uploadResult['path']
                ]);
            } else {
                throw new \Exception('Failed to upload image to Cloudinary');
            }
        }

        Banner::create($data);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('Admin.banners.show', compact('banner'));
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('Admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10048',
            'discount' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:255',
            'filter' => 'nullable|string|max:255|unique:banners,filter,' . $id,
            'filter_type' => 'required|in:single,multiple,discount,category',
            'filter_types' => 'nullable|array',
            'filter_values' => 'nullable|array',
            'type' => 'required|in:main,secondary,editor',
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

        // if ($request->hasFile('image')) {
        //     // Delete old image
        //     if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
        //         unlink(public_path('uploads/banners/' . $banner->image));
        //     }

        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('uploads/banners'), $imageName);
        //     $data['image'] = $imageName;
        // }

          if ($request->hasFile('image')) {
                $image = $request->file('image');

                // DELETE OLD IMAGE FROM CLOUDINARY
                if ($banner->image_public_id) {
                    try {
                        $this->deleteFromCloudinary($banner->image_public_id);
                        Log::info('Old banner image deleted from Cloudinary', [
                            'banner_id' => $banner->id,
                            'public_id' => $banner->image_public_id
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old image from Cloudinary: ' . $e->getMessage());
                    }
                }

                // UPLOAD NEW IMAGE TO CLOUDINARY
                $uploadResult = $this->uploadToCloudinary($image, 'aiman/banners', [
                    'quality' => 'auto:good',
                    'fetch_format' => 'auto',
                    'transformation' => [
                        'width' => 800,
                        'height' => 800,
                        'crop' => 'limit',
                    ],
                ]);

                if ($uploadResult) {
                    // FIXED: Use 'path' instead of 'url'
                    $data['image'] = $uploadResult['path']; // Store the Cloudinary URL
                    $data['image_public_id'] = $uploadResult['public_id']; // Store public_id for future deletion
                    Log::info('New banner image uploaded to Cloudinary', [
                        'banner_id' => $banner->id,
                        'public_id' => $uploadResult['public_id'],
                        'path' => $uploadResult['path']
                    ]);
                } else {
                    throw new \Exception('Failed to upload image to Cloudinary');
                }
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
