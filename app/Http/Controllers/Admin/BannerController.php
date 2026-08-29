<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Traits\CloudinaryUploadTrait;  // ← Add this line
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $path = public_path('uploads/banners');

        //     // Ensure directory exists with proper permissions
        //     if (!File::exists($path)) {
        //         try {
        //             File::makeDirectory($path, 0775, true, true);

        //             // Set ownership if possible (for Linux servers)
        //             if (function_exists('chown')) {
        //                 @chown($path, 'www-data');
        //                 @chgrp($path, 'www-data');
        //             }
        //         } catch (\Exception $e) {
        //             Log::error('Failed to create upload directory: ' . $e->getMessage());
        //             throw new \Exception('Unable to create upload directory. Please check server permissions.');
        //         }
        //     }

        //     // Check if directory is writable
        //     if (!is_writable($path)) {
        //         Log::error('Upload directory is not writable: ' . $path);
        //         throw new \Exception('Upload directory is not writable. Please check server permissions.');
        //     }

        //     // CREATE UNIQUE NAME
        //     $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();

        //     // MOVE FILE with error handling
        //     try {
        //         $image->move($path, $filename);
        //         Log::info('File uploaded successfully: ' . $filename);
        //     } catch (\Exception $e) {
        //         Log::error('Failed to move uploaded file: ' . $e->getMessage());
        //         throw new \Exception('Failed to save uploaded file. Please check server permissions and disk space.');
        //     }

        //     $data['image'] = $filename;
        // }

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $path = public_path('uploads/banners');


        //     // Ensure directory exists
        //     if (!File::exists($path)) {
        //         File::makeDirectory($path, 0775, true, true);
        //     }

        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move($path, $imageName);
        //     $data['image'] = $imageName;
        // }

        if ($request->hasFile('image')) {
            // Delete old image from storage

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Store in storage/app/public/uploads/banners/
            try {
                $path = $image->storeAs('uploads/banners', $imageName, 'public');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0775, true, true);
                }

                // Check if stored successfully
                if ($path) {
                    $data['image'] = $imageName;
                } else {
                    Log::error('storeAs returned false or null');
                }
            } catch (\Exception $e) {
                Log::error('Exception while storing image:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            // Check storage directory
            Log::info('Storage directory check:', [
                'directory_exists' => is_dir(storage_path('app/public/uploads/banners')) ? 'Yes' : 'No',
                'directory_permissions' => substr(sprintf('%o', fileperms(storage_path('app/public/uploads/banners'))), -4),
                'storage_path' => storage_path('app/public/uploads/banners'),
            ]);

            // List all files in the directory
            if (is_dir(storage_path('app/public/uploads/banners'))) {
                $files = scandir(storage_path('app/public/uploads/banners'));
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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Delete old image from storage
            if ($banner->image) {
                $oldPath = 'uploads/banners/' . $banner->image;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                } else {
                    Log::warning('Old image not found:', ['path' => $oldPath]);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Store in storage/app/public/uploads/banners/
            try {
                $path = $image->storeAs('uploads/banners', $imageName, 'public');

                // Check if stored successfully
                if ($path) {
                    $data['image'] = $imageName;
                } else {
                    Log::error('storeAs returned false or null');
                }
            } catch (\Exception $e) {
                Log::error('Exception while storing image:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            // Check storage directory
            Log::info('Storage directory check:', [
                'directory_exists' => is_dir(storage_path('app/public/uploads/banners')) ? 'Yes' : 'No',
                'directory_permissions' => substr(sprintf('%o', fileperms(storage_path('app/public/uploads/banners'))), -4),
                'storage_path' => storage_path('app/public/uploads/banners'),
            ]);

            // List all files in the directory
            if (is_dir(storage_path('app/public/uploads/banners'))) {
                $files = scandir(storage_path('app/public/uploads/banners'));
            }
        } else {
            Log::warning('No image file in request');
        }

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');

        //     // DELETE OLD IMAGE FROM CLOUDINARY
        //     if ($banner->image_public_id) {
        //         try {
        //             $this->deleteFromCloudinary($banner->image_public_id);
        //             Log::info('Old banner image deleted from Cloudinary', [
        //                 'banner_id' => $banner->id,
        //                 'public_id' => $banner->image_public_id
        //             ]);
        //         } catch (\Exception $e) {
        //             Log::warning('Failed to delete old image from Cloudinary: ' . $e->getMessage());
        //         }
        //     }

        //     // UPLOAD NEW IMAGE TO CLOUDINARY
        //     $uploadResult = $this->uploadToCloudinary($image, 'aiman/banners', [
        //         'quality' => 'auto:good',
        //         'fetch_format' => 'auto',
        //         'transformation' => [
        //             'width' => 800,
        //             'height' => 800,
        //             'crop' => 'limit',
        //         ],
        //     ]);

        //     if ($uploadResult) {
        //         // FIXED: Use 'path' instead of 'url'
        //         $data['image'] = $uploadResult['path']; // Store the Cloudinary URL
        //         $data['image_public_id'] = $uploadResult['public_id']; // Store public_id for future deletion
        //         Log::info('New banner image uploaded to Cloudinary', [
        //             'banner_id' => $banner->id,
        //             'public_id' => $uploadResult['public_id'],
        //             'path' => $uploadResult['path']
        //         ]);
        //     } else {
        //         throw new \Exception('Failed to upload image to Cloudinary');
        //     }
        // }

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
