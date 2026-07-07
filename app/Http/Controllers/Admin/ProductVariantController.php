<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\StockIn;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use App\Traits\CloudinaryUploadTrait;  // ← Add this line
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;


class ProductVariantController extends Controller
{
    use CloudinaryUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductVariant::with(['product', 'colorModel', 'sizeModel', 'images']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                    ->orWhere('size', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        if ($request->filled('color')) {
            $query->where('color', $request->input('color'));
        }

        if ($request->filled('size')) {
            $query->where('size', $request->input('size'));
        }

        $data = $query->orderBy('product_id')->orderBy('color')->orderBy('size')->paginate(15);

        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.index', compact('data', 'products', 'colors', 'sizes'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.create', compact('products', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'size' => 'required|string|max:20',
    //         'color' => 'required|string|max:50',
    //         // 'sku' => 'required|string|max:100|unique:product_variants,sku',
    //         'price' => 'required|numeric|min:0',
    //         'discount' => 'nullable|numeric|min:0',
    //         'stock' => 'required|integer|min:0',
    //         'video_url' => 'nullable|url|max:500',
    //         // 'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
    //     ], [
    //         'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
    //     ]);
    //     $discount_price = ($data['price'] - (($data['price'] * $data['discount']) / 100));
    //     $data['discount_price'] = $discount_price;
    //     // Custom validation for unique combination of product_id, size, and color
    //     $existingVariant = ProductVariant::where('product_id', $data['product_id'])
    //         ->where('size', $data['size'] ?? '')
    //         ->where('color', $data['color'] ?? '')
    //         ->first();

    //     if ($existingVariant) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
    //     }

    //     $variant = ProductVariant::create($data);
    //     $product = Product::find($data['product_id']);
    //     $product->update([
    //         'stock' => $data['stock'],
    //         'ready_to_ship' => 1,
    //     ]);
    //     if ($variant) {
    //         if ($request->hasFile('images')) {

    //             foreach ($request->file('images') as $image) {

    //                 $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();
    //                 $folder = 'uploads/variants';
    //                 $image->move(public_path('uploads/variants'), $filename);
    //                 $imagePath = $folder . '/' . $filename;
    //                 // dd($variant->id);
    //                 ProductImage::create([
    //                     'product_id' => $variant->product_id,
    //                     'variant_id' => $variant->id,
    //                     'image' => $imagePath //$filename
    //                 ]);
    //             }
    //         }
    //     }
    //     // Create stock entry for the new variant
    //     StockIn::create([
    //         'product_variant_id' => $variant->id,
    //         'stock' => $data['stock'],
    //     ]);

    //     return redirect()->route('admin.product-variants')->with('success', 'Product variant created successfully!');
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:20',
            'color' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'video_url' => 'nullable|url|max:500',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,avif|max:10240',
        ], [
            'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
        ]);

        $discount_price = ($data['price'] - (($data['price'] * $data['discount']) / 100));
        $data['discount_price'] = $discount_price;

        // Custom validation for unique combination of product_id, size, and color
        $existingVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'] ?? '')
            ->where('color', $data['color'] ?? '')
            ->first();

        if ($existingVariant) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
        }

        $variant = ProductVariant::create($data);
        $product = Product::find($data['product_id']);
        $product->update([
            'stock' => $data['stock'],
            'ready_to_ship' => 1,
        ]);

        // Handle image uploads with Cloudinary
        if ($variant && $request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Upload to Cloudinary
                $uploadResult = $this->uploadToCloudinary($image, "products/variants/{$variant->id}", [
                    'quality' => 'auto:good',
                    'fetch_format' => 'auto',
                    'transformation' => [
                        'width' => 800,
                        'height' => 800,
                        'crop' => 'limit',
                    ],
                ]);

                if ($uploadResult) {
                    ProductImage::create([
                        'product_id' => $variant->product_id,
                        'variant_id' => $variant->id,
                        'image' => $uploadResult['path'], // Cloudinary URL
                        'public_id' => $uploadResult['public_id'], // Store public_id for future deletion
                    ]);

                    \Log::info('Variant image uploaded to Cloudinary', [
                        'variant_id' => $variant->id,
                        'public_id' => $uploadResult['public_id']
                    ]);
                } else {
                    // Fallback to local upload if Cloudinary fails
                    $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();
                    $folder = 'uploads/variants';
                    $image->move(public_path('uploads/variants'), $filename);
                    $imagePath = $folder . '/' . $filename;

                    ProductImage::create([
                        'product_id' => $variant->product_id,
                        'variant_id' => $variant->id,
                        'image' => $imagePath,
                        'public_id' => null, // No public_id for local files
                    ]);
                }
            }
        }

        // Create stock entry for the new variant
        StockIn::create([
            'product_variant_id' => $variant->id,
            'stock' => $data['stock'],
        ]);

        return redirect()->route('admin.product-variants')->with('success', 'Product variant created successfully with Cloudinary!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $products = Product::select('id', 'name')->orderBy('name')->get();
        $colors = Color::select('name')->distinct()->orderBy('name')->pluck('name');
        $sizes = Size::select('name')->distinct()->orderBy('name')->pluck('name');

        return view('Admin.product-variant.edit', compact('productVariant', 'products', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, ProductVariant $productVariant)
    // {
    //     $data = $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'size' => 'nullable|string|max:20',
    //         'color' => 'nullable|string|max:50',
    //         // 'sku' => 'required|string|max:100|unique:product_variants,sku,' . $productVariant->id,
    //         'price' => 'required|numeric|min:0',
    //         'discount' => 'nullable|numeric|min:0',
    //         'video_url' => 'nullable|url|max:500',
    //         'images' => 'nullable|array',
    //         'images.*' => 'mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
    //     ], [
    //         'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
    //     ]);
    //     $discount_price = ($data['price'] - (($data['price'] * $data['discount']) / 100));
    //     $data['discount_price'] = $discount_price;

    //     // Custom validation for unique combination of product_id, size, and color (excluding current variant)
    //     $existingVariant = ProductVariant::where('product_id', $data['product_id'])
    //         ->where('size', $data['size'] ?? '')
    //         ->where('color', $data['color'] ?? '')
    //         ->where('id', '!=', $productVariant->id)
    //         ->first();

    //     if ($existingVariant) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
    //     }

    //     // $productVariant->update($data);
    //     $productVariant->update([
    //         'product_id'      => $request->product_id,
    //         // 'sku'             => $request->sku,
    //         'price'           => $request->price,
    //         'discount_price'  => $discount_price,
    //         'discount'        => $request->discount,
    //         'color'           => $request->color,
    //         'size'            => $request->size,
    //         'video_url'       => $request->video_url,
    //     ]);

    //     $product = Product::find($data['product_id']);
    //     $product->update([
    //         'ready_to_ship' => 1,
    //     ]);
    //     //if removed images
    //     if ($request->removed_images) {

    //         $removedIds = explode(',', $request->removed_images);

    //         foreach ($removedIds as $id) {

    //             $image = ProductImage::find($id);

    //             if ($image) {

    //                 $path = public_path('uploads/variants/' . $image->image);

    //                 if (File::exists($path)) {
    //                     File::delete($path);
    //                 }

    //                 $image->delete();
    //             }
    //         }
    //     }
    //     //store images
    //     if ($request->hasFile('images')) {

    //         foreach ($request->file('images') as $image) {
    //             $folder = 'uploads/variants';
    //             $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();
    //             $imagePath = $folder . '/' . $filename;
    //             $image->move(public_path('uploads/variants'), $filename);

    //             ProductImage::create([
    //                 'product_id' => $request->product_id,
    //                 'variant_id' => $productVariant->id,
    //                 'image' => $imagePath //$filename
    //             ]);
    //         }
    //     }


    //     // Note: Stock is managed separately through Stock Management
    //     // Stock entry is not updated here since stock field is readonly in edit form

    //     return redirect()->route('admin.product-variants')->with('success', 'Product variant updated successfully!');
    // }

    public function update(Request $request, ProductVariant $productVariant)
    {
   
        // dd($productVariant->id);
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:500',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,png,jpg,gif,webp,avif|max:10240',
        ], [
            'product_id.unique_combination' => 'This product already has a variant with the same size and color combination.',
        ]);

        $discount_price = ($data['price'] - (($data['price'] * $data['discount']) / 100));
        $data['discount_price'] = $discount_price;

        // Custom validation for unique combination of product_id, size, and color (excluding current variant)
        $existingVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'] ?? '')
            ->where('color', $data['color'] ?? '')
            ->where('id', '!=', $productVariant->id)
            ->first();

        if ($existingVariant) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['unique_combination' => 'This product already has a variant with the same size and color combination.']);
        }

        // Update variant details
        $productVariant->update([
            'product_id'      => $request->product_id,
            'price'           => $request->price,
            'discount_price'  => $discount_price,
            'discount'        => $request->discount,
            'color'           => $request->color,
            'size'            => $request->size,
            'video_url'       => $request->video_url,
        ]);

        $product = Product::find($data['product_id']);
        $product->update([
            'ready_to_ship' => 1,
        ]);

        // Handle removed images from Cloudinary
        if ($request->removed_images) {
            $removedIds = explode(',', $request->removed_images);

            foreach ($removedIds as $id) {
                $image = ProductImage::find($id);

                if ($image) {
                    // Delete from Cloudinary if public_id exists
                    if ($image->public_id) {
                        try {
                            $this->deleteFromCloudinary($image->public_id);
                            Log::info('Deleted variant image from Cloudinary', [
                                'image_id' => $id,
                                'public_id' => $image->public_id
                            ]);
                        } catch (\Exception $e) {
                            Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                        }
                    } elseif ($image->image && File::exists(public_path($image->image))) {
                        // Fallback for local files
                        File::delete(public_path($image->image));
                    }

                    $image->delete();
                }
            }
        }
        
        // Store new images to Cloudinary
        if ($request->hasFile('images')) {
        //    dd($request->file('images'));
            foreach ($request->file('images') as $image) {
                // Upload to Cloudinary
                $uploadResult = $this->uploadToCloudinary($image, "products/variants/{$productVariant->id}", [
                    'quality' => 'auto:good',
                    'fetch_format' => 'auto',
                    'transformation' => [
                        'width' => 800,
                        'height' => 800,
                        'crop' => 'limit',
                    ],
                ]);

                if ($uploadResult) {
                    ProductImage::create([
                        'product_id' => $request->product_id,
                        'variant_id' => $productVariant->id,
                        'image' => $uploadResult['path'], // Cloudinary URL
                        'public_id' => $uploadResult['public_id'], // Store public_id for future deletion
                    ]);

                    Log::info('Variant image uploaded to Cloudinary', [
                        'variant_id' => $productVariant->id,
                        'public_id' => $uploadResult['public_id']
                    ]);
                } else {
                    // Fallback to local upload if Cloudinary fails
                    $folder = 'uploads/variants';
                    $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $folder . '/' . $filename;
                    $image->move(public_path('uploads/variants'), $filename);

                    ProductImage::create([
                        'product_id' => $request->product_id,
                        'variant_id' => $productVariant->id,
                        'image' => $imagePath,
                        'public_id' => null, // No public_id for local files
                    ]);
                }
            }
        }

        return redirect()->route('admin.product-variants')->with('success', 'Product variant updated successfully with Cloudinary!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        // Delete the associated stock entry
        StockIn::where('product_variant_id', $productVariant->id)->delete();

        $productVariant->delete();

        return redirect()->route('admin.product-variants')->with('success', 'Product variant deleted successfully!');
    }

    /**
     * Get variants for a specific product (AJAX endpoint).
     */
    public function getByProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $variants = ProductVariant::with(['colorModel', 'sizeModel'])
            ->where('product_id', $productId)
            ->orderBy('color')
            ->orderBy('size')
            ->get();

        return response()->json($variants);
    }
}
