<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerDetails;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerDetailsController extends Controller
{
    public function index()
    {
        $search = request('search');

        $bannerDetails = BannerDetails::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('offer', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%")
                ->orWhere('redirect_link', 'like', "%{$search}%")
                ->orWhere('is_active', 'like', "%{$search}%");
        })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('Admin.hero-section.index', compact('bannerDetails', 'search'));
    }
    public function create()
    {
        return view('Admin.hero-section.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'short_description' => 'nullable|string',
            'offer' => 'nullable|string',
            'redirect_link' => 'nullable|string',
            // 'position' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'mobile_screen_image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'is_active' => 'boolean',
        ]);

        try {
            //cloudinary upload
            // if ($request->hasFile('image')) {

            //     $upload = Cloudinary::uploadApi()->upload(
            //         $request->file('image')->getRealPath(),
            //         [
            //             'folder' => 'aiman/hero-section'
            //         ]
            //     );

            //     $data['image'] = $upload['secure_url'];
            //     $data['public_id'] = $upload['public_id'];
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
            //cloudinary upload
            // if ($request->hasFile('mobile_screen_image')) {

            //     $upload = Cloudinary::uploadApi()->upload(
            //         $request->file('mobile_screen_image')->getRealPath(),
            //         [
            //             'folder' => 'aiman/hero-section'
            //         ]
            //     );

            //     $data['mobile_screen_image'] = $upload['secure_url'];
            //     $data['mobile_screen_image_public_id'] = $upload['public_id'];
            // }

            if ($request->hasFile('mobile_screen_image')) {
                // Delete old image from storage

                $image = $request->file('mobile_screen_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/uploads/banners/
                try {
                    $path = $image->storeAs('uploads/banners', $imageName, 'public');

                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0775, true, true);
                    }

                    // Check if stored successfully
                    if ($path) {
                        $data['mobile_screen_image'] = $imageName;
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

            $data['position'] = null;
            $bannerDetails = BannerDetails::create($data);
            if ($bannerDetails) {
                return redirect()->route('hero-section.index')->with('success', 'Banner Hero Section Created successfully');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $hero = BannerDetails::findOrFail($id);
        return view('Admin.hero-section.edit', compact('hero'));
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'title' => 'nullable|string',
            'short_description' => 'nullable|string',
            'offer' => 'nullable|string',
            'redirect_link' => 'nullable|string',
            // 'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'mobile_screen_image' => 'nullable|image',
            'status' => 'boolean',
        ]);
        try {
            $bannerDetails = BannerDetails::findOrFail($id);

            if ($request->hasFile('image')) {
               
                if ($bannerDetails->image) {
                    $oldImagePath = storage_path('app/public/uploads/banners/' . $bannerDetails->image);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }

                $image = $request->file('image');
               
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                try {
                    $path = $image->storeAs('uploads/banners', $imageName, 'public');
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
            }
            //cloudinary upload
            // if ($request->hasFile('image')) {

            //     if ($bannerDetails->public_id) {
            //         Cloudinary::uploadApi()->destroy($bannerDetails->public_id);
            //     }

            //     $upload = Cloudinary::uploadApi()->upload(
            //         $request->file('image')->getRealPath(),
            //         ['folder' => 'aiman/hero-section']
            //     );

            //     $data['image'] = $upload['secure_url'];
            //     $data['public_id'] = $upload['public_id'];
            // }

            if ($request->hasFile('mobile_screen_image')) {
                if ($bannerDetails->mobile_screen_image) {
                    $oldImagePath = storage_path('app/public/uploads/banners/' . $bannerDetails->mobile_screen_image);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }

                $image = $request->file('mobile_screen_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                try {
                    $path = $image->storeAs('uploads/banners', $imageName, 'public');
                    if ($path) {
                        $data['mobile_screen_image'] = $imageName;
                    } else {
                        Log::error('storeAs returned false or null');
                    }
                } catch (\Exception $e) {
                    Log::error('Exception while storing image:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
            //cloudinary upload
            // if ($request->hasFile('mobile_screen_image')) {

            //     if ($bannerDetails->mobile_screen_image_public_id) {
            //         Cloudinary::uploadApi()->destroy($bannerDetails->mobile_screen_image_public_id);
            //     }

            //     $upload = Cloudinary::uploadApi()->upload(
            //         $request->file('mobile_screen_image')->getRealPath(),
            //         ['folder' => 'aiman/hero-section']
            //     );

            //     $data['mobile_screen_image'] = $upload['secure_url'];
            //     $data['mobile_screen_image_public_id'] = $upload['public_id'];
            // }

            $data['is_active'] = $data['status'] ?? true;
            $data['position'] = null;
            // dd($data);
            $bannerDetails->update($data);
            return redirect()->route('hero-section.index')->with('success', 'Banner Hero Section Updated successfully');
            // return view('Admin.hero-section.index',compact('bannerDetails'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $bannerDetails = BannerDetails::findOrFail($id);
            if ($bannerDetails) {
                if ($bannerDetails->public_id) {
                    Cloudinary::uploadApi()->destroy($bannerDetails->public_id);
                }
                if ($bannerDetails->mobile_screen_image_public_id) {
                    Cloudinary::uploadApi()->destroy($bannerDetails->mobile_screen_image_public_id);
                }
                $bannerDetails->delete();

                return back()->with('success', 'Banner Hero Section Deleted successfully');
            } else {
                return back()->with('error', 'Banner Hero Section not found');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
