<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerDetails;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BannerDetailsController extends Controller
{
    public function index()
    {
        $search = request('search');

        $bannerDetails = BannerDetails::where('is_active', true)
            ->when($search, function ($query) use ($search) {
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
            'mobile_screen_image' => 'required|image|mimes:jpeg,png,jpg,webp|dimensions:ratio=2/3',
            'is_active' => 'boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                
                $upload = Cloudinary::uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'aiman/hero-section'
                    ]
                );

                $data['image'] = $upload['secure_url'];
                $data['public_id'] = $upload['public_id'];
            }
            if ($request->hasFile('mobile_screen_image')) {
                
                $upload = Cloudinary::uploadApi()->upload(
                    $request->file('mobile_screen_image')->getRealPath(),
                    [
                        'folder' => 'aiman/hero-section'
                    ]
                );

                $data['mobile_screen_image'] = $upload['secure_url'];
                $data['mobile_screen_image_public_id'] = $upload['public_id'];
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
        $data = $request->validate([
            'title' => 'nullable|string',
            'short_description' => 'nullable|string',
            'offer' => 'nullable|string',
            'redirect_link' => 'nullable|string',
            // 'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'mobile_screen_image' => 'nullable|image',
            'is_active' => 'boolean',
        ]);
        try {
            $bannerDetails = BannerDetails::findOrFail($id);
            if ($request->hasFile('image')) {

                if ($bannerDetails->public_id) {
                     Cloudinary::uploadApi()->destroy($bannerDetails->public_id);
                }

                $upload = Cloudinary::uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    ['folder' => 'aiman/hero-section']
                );

                $data['image'] = $upload['secure_url'];
                $data['public_id'] = $upload['public_id'];
            }
            if ($request->hasFile('mobile_screen_image')) {

                if ($bannerDetails->mobile_screen_image_public_id) {
                     Cloudinary::uploadApi()->destroy($bannerDetails->mobile_screen_image_public_id);
                }

                $upload = Cloudinary::uploadApi()->upload(
                    $request->file('mobile_screen_image')->getRealPath(),
                    ['folder' => 'aiman/hero-section']
                );

                $data['mobile_screen_image'] = $upload['secure_url'];
                $data['mobile_screen_image_public_id'] = $upload['public_id'];
            }
            $data['position'] = null ;
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
                if($bannerDetails->mobile_screen_image_public_id){
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
