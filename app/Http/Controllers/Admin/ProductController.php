<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request){
        $query = Product::with(['category', 'occasion', 'images' => function ($q) {
            $q->orderBy('id');
        }]); 
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('design_no', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        $data = $query->paginate(15);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $occasions = Occasion::select('id','name')->orderBy('name')->get();
        
        return view('Admin.product.index', compact('data', 'categories', 'occasions'));
    }
    
    public function create(){
        $categories = Category::select('id','name')->orderBy('name')->get();
        $occasions = Occasion::select('id','name')->orderBy('name')->get();
        
        return view('Admin.product.create', compact('categories', 'occasions'));
    }
    public function store(Request $request){
        $data = $request->validate([
            'design_no' => 'required|string|max:40|unique:products,design_no',
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'nullable|exists:occasions,id',
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'fabric' => 'nullable|string|max:100',
            'fit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::create($data);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            
            // Create upload directory if it doesn't exist
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $image->move($uploadPath, $filename);
            
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $filename,
            ]);
        }

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');

    }
    public function update(Request $request, $id){
        $data = $request->validate([
            'design_no' => 'required|string|max:40|unique:products,design_no,'.$id,
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'nullable|exists:occasions,id',
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'fabric' => 'nullable|string|max:100',
            'fit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::findOrFail($id);
        $product->update($data);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete existing images
            $existingImages = ProductImage::where('product_id', $id)->get();
            foreach ($existingImages as $existingImage) {
                $imagePath = public_path('uploads/products/' . $existingImage->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $existingImage->delete();
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $image->move($uploadPath, $filename);
            
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $filename,
            ]);
        }

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
    public function trashed()
    {
        $data=Product::onlyTrashed()->get();
        return view('Admin.product.trashed',compact('data'));
    }
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        
        //$data=Product::all();
        return (redirect()->route('admin.products-trashed'))->with('success', 'Product restored successfully!');
    }
    public function permanentlyDelete($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return (redirect()->route('admin.products-trashed'))->with('success', 'Product permanently deleted successfully!');
    }
}
