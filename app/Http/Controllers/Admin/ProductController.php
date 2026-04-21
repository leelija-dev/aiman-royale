<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'occasion', 'images' => function ($q) {
            $q->orderBy('id');
        }, 'parts']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('design_no', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }


        $data = $query->paginate(15);

        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $occasions = Occasion::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('Admin.product.index', compact('data', 'categories', 'occasions', 'brands'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $occasions = Occasion::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();

        return view('Admin.product.create', compact('categories', 'occasions', 'brands'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'design_no' => 'required|string|max:40|unique:products,design_no',
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'nullable|exists:ocassions,id',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products,slug',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'fabric' => 'nullable|string|max:100',
            'fit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'featured_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp,avif|max:10240',
            'is_featured' => 'required|boolean',
            'meta_title' => 'required|string',
            'keywords' => 'required|string',
            'tags' => 'required|string',
            'meta_description' => 'required|string',
            'schema_markup' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,webp,avif',
            'lehenga_fabric' => 'nullable|string|max:100',
            'choli_fabric' => 'nullable|string|max:100',
            'dupatta_fabric' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'stitching_type' => 'nullable|string|max:100',
            'pattern' => 'nullable|string|max:100',
            'sales_package' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:100',
        ]);
        $data['ocassion_id'] = $request->occasion_id;

        $product = Product::create($data);

        // Handle image upload if present
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $filename = time() . '_' . $image->getClientOriginalName();

        //     // Create upload directory if it doesn't exist
        //     $uploadPath = public_path('uploads/products');
        //     if (!file_exists($uploadPath)) {
        //         mkdir($uploadPath, 0777, true);
        //     }

        //     $image->move($uploadPath, $filename);

        //     ProductImage::create([
        //         'product_id' => $product->id,
        //         'image' => $filename,
        //     ]);
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . '_' . $image->getClientOriginalName();

            // Folder inside public
            $folder = 'uploads/products';

            // Absolute path for moving file
            $uploadPath = public_path($folder);

            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move file
            $image->move($uploadPath, $filename);

            // Path to store in DB (relative path)
            $imagePath = $folder . '/' . $filename;

            ProductImage::create([
                'product_id' => $product->id,
                // 'image'      => $filename,     // optional
                'image' => $imagePath,    // save full path
            ]);
        }

        // Handle featured image upload if present
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            
            // Create directory if not exists
            $featuredFolder = 'uploads/featured';
            $featuredUploadPath = public_path($featuredFolder);
            if (!file_exists($featuredUploadPath)) {
                mkdir($featuredUploadPath, 0777, true);
            }
            
            // Generate unique filename
            $featuredFilename = time() . '_featured_' . $featuredImage->getClientOriginalName();
            
            // Upload image without compression
            $featuredImage->move($featuredUploadPath, $featuredFilename);

            //  $this->compressImage($featuredImage, $featuredUploadPath . '/' . $featuredFilename, 10);
            
            // Update product with featured image path
            $product->featured_image = $featuredFolder . '/' . $featuredFilename;
            $product->save();
        }

        // Handle product parts
        if ($request->has('parts') && is_array($request->parts)) {
            foreach ($request->parts as $partData) {
                if (!empty($partData['part_name'])) {
                    $product->parts()->create([
                        'part_name' => $partData['part_name'],
                        'fabric' => $partData['fabric'] ?? null,
                        'work_type' => $partData['work_type'] ?? null,
                        'order' => $partData['order'] ?? 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }
    public function update(Request $request, $id)
    {
    //    dd($request);
        $data = $request->validate([
            'design_no' => 'required|string|max:40|unique:products,design_no,' . $id,
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'nullable|exists:ocassions,id',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'fabric' => 'nullable|string|max:100',
            'fit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'featured_image' => 'nullable|mimes:jpeg,jpg,png,gif,webp,avif|max:10240',
            'is_featured' => 'required|boolean',
            'meta_title' => 'required|string',
            'keywords' => 'required|string',
            'tags' => 'required|string',
            'meta_description' => 'required|string',
            'schema_markup' => 'nullable|string',
            'type' => 'nullable|string|max:100',
            'stitching_type' => 'nullable|string|max:100',
            'pattern' => 'nullable|string|max:100',
            'sales_package' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:100',

        ]);
        $data['ocassion_id'] = $request->occasion_id;

        $product = Product::findOrFail($id);
        $product->update($data);

        // Handle image upload if present
        // if ($request->hasFile('image')) {
        //     // Delete existing images
        //     $existingImages = ProductImage::where('product_id', $id)->get();
        //     foreach ($existingImages as $existingImage) {
        //         $imagePath = public_path('uploads/products/' . $existingImage->image);
        //         if (file_exists($imagePath)) {
        //             unlink($imagePath);
        //         }
        //         $existingImage->delete();
        //     }

        //     // Upload new image
        //     $image = $request->file('image');
        //     $filename = time() . '_' . $image->getClientOriginalName();

        //     $uploadPath = public_path('uploads/products');
        //     if (!file_exists($uploadPath)) {
        //         mkdir($uploadPath, 0777, true);
        //     }

        //     $image->move($uploadPath, $filename);

        //     ProductImage::create([
        //         'product_id' => $product->id,
        //         'image' => $filename,
        //     ]);
        // }

        if ($request->hasFile('image')) {

            $folder = 'uploads/products';
            $uploadPath = public_path($folder);

            // 1️⃣ Delete existing images from DB + storage
            $existingImages = ProductImage::where('product_id', $id)->get();

            foreach ($existingImages as $existingImage) {
                if (!empty($existingImage->image_path)) {
                    $fullPath = public_path($existingImage->image_path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
                $existingImage->delete();
            }

            // 2️⃣ Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $image->move($uploadPath, $filename);

            // 3️⃣ Save relative path in DB
            $imagePath = $folder . '/' . $filename;

            ProductImage::create([
                'product_id' => $product->id,
                // 'image'      => $filename,     // optional
                'image' => $imagePath,    // important
            ]);
        }

        // Handle featured image upload if present
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            
            // Delete existing featured image
            if ($product->featured_image && file_exists(public_path($product->featured_image))) {
                unlink(public_path($product->featured_image));
            }
            
            // Create directory if not exists
            $featuredFolder = 'uploads/featured';
            $featuredUploadPath = public_path($featuredFolder);
            if (!file_exists($featuredUploadPath)) {
                mkdir($featuredUploadPath, 0777, true);
            }
            
            // Generate unique filename
            $featuredFilename = time() . '_featured_' . $featuredImage->getClientOriginalName();

            //without compress image
            $featuredImage->move($featuredUploadPath, $featuredFilename);
            
            // Compress and save image to ~10KB
            // $this->compressImage($featuredImage, $featuredUploadPath . '/' . $featuredFilename, 10);
            
            // Update product with new featured image path
            $product->featured_image = $featuredFolder . '/' . $featuredFilename;
            $product->save();
        } else {
            // No featured image uploaded
        }

        // Handle product parts
        if ($request->has('parts') && is_array($request->parts)) {
            // Delete existing parts
            $product->parts()->delete();
            
            // Add new parts
            foreach ($request->parts as $partData) {
                if (!empty($partData['part_name'])) {
                    $product->parts()->create([
                        'part_name' => $partData['part_name'],
                        'fabric' => $partData['fabric'] ?? null,
                        'work_type' => $partData['work_type'] ?? null,
                        'order' => $partData['order'] ?? 1
                    ]);
                }
            }
        }

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    // In your controller
// public function update(Request $request, $id)
// {
//     // Check if file exists
//     if ($request->hasFile('featured_image')) {
//         dd([
//             'file_exists' => true,
//             'file_info' => [
//                 'original_name' => $request->file('featured_image')->getClientOriginalName(),
//                 'size' => $request->file('featured_image')->getSize(),
//                 'mime' => $request->file('featured_image')->getMimeType(),
//                 'extension' => $request->file('featured_image')->getClientOriginalExtension(),
//                 'is_valid' => $request->file('featured_image')->isValid(),
//             ],
//             'all_request_data' => $request->except(['_token', '_method']),
//             'files' => $_FILES, // Raw files data
//         ]);
//     }
    
//     dd('No file uploaded', $request->all(), $_FILES);
// }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
    public function trashed()
    {
        $data = Product::onlyTrashed()->get();
        return view('Admin.product.trashed', compact('data'));
    }
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        //$data=Product::all();
        return (redirect()->route('admin.products-trashed'))->with('success', 'Product restored successfully!');
    }
    public function permanentlyDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return (redirect()->route('admin.products-trashed'))->with('success', 'Product permanently deleted successfully!');
    }

    /**
     * Compress image to target file size (approximately)
     */
    private function compressImage($sourceFile, $destinationPath, $targetSizeKB = 10)
    {
        try {
            // Get image info
            $imageInfo = getimagesize($sourceFile->getPathname());
            $mimeType = $imageInfo['mime'];
            
            // Create image resource based on mime type
            switch ($mimeType) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($sourceFile->getPathname());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($sourceFile->getPathname());
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($sourceFile->getPathname());
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($sourceFile->getPathname());
                    break;
                default:
                    // If unsupported mime type, just move the file
                    move_uploaded_file($sourceFile->getPathname(), $destinationPath);
                    return;
            }
            
            if (!$image) {
                // If image creation fails, just move the file
                move_uploaded_file($sourceFile->getPathname(), $destinationPath);
                return;
            }
            
            // Get original dimensions
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Calculate compression quality iteratively
            $quality = 85;
            $step = 5;
            $minQuality = 10;
            
            while ($quality > $minQuality) {
                // Create temporary file to check size
                $tempPath = $destinationPath . '_temp';
                
                // Save with current quality
                switch ($mimeType) {
                    case 'image/jpeg':
                        imagejpeg($image, $tempPath, $quality);
                        break;
                    case 'image/png':
                        imagepng($image, $tempPath, (int)(9 * $quality / 100));
                        break;
                    case 'image/gif':
                        imagegif($image, $tempPath);
                        break;
                    case 'image/webp':
                        imagewebp($image, $tempPath, $quality);
                        break;
                }
                
                // Check file size
                $fileSizeKB = filesize($tempPath) / 1024;
                
                if ($fileSizeKB <= $targetSizeKB) {
                    // Target size achieved, move temp file to destination
                    rename($tempPath, $destinationPath);
                    break;
                } else {
                    // File too large, delete temp and reduce quality
                    unlink($tempPath);
                    $quality -= $step;
                }
            }
            
            // If we couldn't achieve target size, save with minimum quality
            if ($quality <= $minQuality && !file_exists($destinationPath)) {
                switch ($mimeType) {
                    case 'image/jpeg':
                        imagejpeg($image, $destinationPath, $minQuality);
                        break;
                    case 'image/png':
                        imagepng($image, $destinationPath, 0);
                        break;
                    case 'image/gif':
                        imagegif($image, $destinationPath);
                        break;
                    case 'image/webp':
                        imagewebp($image, $destinationPath, $minQuality);
                        break;
                }
            }
            
            // Clean up
            imagedestroy($image);
            
        } catch (\Exception $e) {
            // If compression fails, just move the original file
            move_uploaded_file($sourceFile->getPathname(), $destinationPath);
            // Error logged for debugging
        }
    }
}
