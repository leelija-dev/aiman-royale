<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DOMDocument;
use DOMXPath;
use LibXMLError;
use App\Traits\CloudinaryUploadTrait;  // ← Add this line
use Cloudinary\Cloudinary;

class CategoryController extends Controller
{
    use CloudinaryUploadTrait;
    /**
     * Display a listing of the product categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $categoriess = Category::paginate(15);
            return view('Admin.categories.index', compact('categoriess'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@index', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while retrieving product categories.');
        }
    }

    /**
     * Display a listing of the trashed categories.
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        try {
            $categoriess = Category::onlyTrashed()->latest()->paginate(20);
            // dd($categoriess->count());
            return view('Admin.categories.trash', compact('categoriess'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@trash', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while retrieving trashed categories.');
        }
    }

    /**
     * Restore the specified category from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->restore();

            return redirect()->route('admin.categories.trash')
                ->with('success', 'Category has been restored successfully.');
        } catch (\Exception $e) {
            Log::error('Error restoring category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while restoring the category.');
        }
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::latest()->paginate(15);
        return view('Admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created product category in storage.
     *
     * @param  \App\Http\Requests\Admin\CategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        // dd($request); 
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            $data['title'] = $request->title;
            $data['about'] = $request->about;
            // print_r($data); exit;
            if ($request->has('description')) {
                $data['description'] = $this->removeHtmlStyles($request->description);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // CREATE FOLDER IF NOT EXISTS
                $path = public_path('uploads/category');

                // Ensure directory exists with proper permissions
                if (!File::exists($path)) {
                    try {
                        File::makeDirectory($path, 0775, true, true);

                        // Set ownership if possible (for Linux servers)
                        if (function_exists('chown')) {
                            @chown($path, 'www-data');
                            @chgrp($path, 'www-data');
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to create upload directory: ' . $e->getMessage());
                        throw new \Exception('Unable to create upload directory. Please check server permissions.');
                    }
                }

                // Check if directory is writable
                if (!is_writable($path)) {
                    Log::error('Upload directory is not writable: ' . $path);
                    throw new \Exception('Upload directory is not writable. Please check server permissions.');
                }

                // CREATE UNIQUE NAME
                $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();

                // MOVE FILE with error handling
                try {
                    $image->move($path, $filename);
                    Log::info('File uploaded successfully: ' . $filename);
                } catch (\Exception $e) {
                    Log::error('Failed to move uploaded file: ' . $e->getMessage());
                    throw new \Exception('Failed to save uploaded file. Please check server permissions and disk space.');
                }

                $data['image'] = $filename;
            }

            // Create category with error handling
            try {
                $category = Category::create($data);
                Log::info('Category created successfully with ID: ' . $category->id);
            } catch (\Exception $e) {
                Log::error('Failed to create category in database: ' . $e->getMessage());
                throw new \Exception('Failed to save category to database: ' . $e->getMessage());
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Product category created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product category', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all(),
                'upload_path' => public_path('uploads/category'),
                'directory_exists' => File::exists(public_path('uploads/category')),
                'directory_writable' => is_writable(public_path('uploads/category')) ? 'Yes' : 'No'
            ]);

            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified product category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        try {

            Log::info('Editing product category', ['id' => $category->id, 'name' => $category->name]);

            if (!$category) {
                Log::error('Product category not found');
                abort(404);
            }

            $categories = Category::where('id', '!=', $category->id)->latest()->get();

            // Debug: Log categories data
            Log::info('Categories for edit dropdown', [
                'current_category_id' => $category->id,
                'categories_count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);

            return view('Admin.categories.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in CategoryController@edit', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'An error occurred while loading the edit page.');
        }
    }

    /**
     * Update the specified product category in storage.
     *
     * @param  \App\Http\Requests\Admin\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function update(CategoryRequest $request, Category $category)
    // {
    //     // dd($request);
    //     try {
    //         $data = $request->validated();
    //         $data['slug'] = Str::slug($data['name']);
    //         $data['title'] = $request->title;
    //         $data['about'] = $request->about;

    //         if ($request->has('description')) {
    //             $data['description'] = $this->removeHtmlStyles($request->description);
    //         }
    //         // dd($data['image']);
    //         // CHECK IF NEW IMAGE UPLOADED
    //         if ($request->hasFile('image')) {

    //             $image = $request->file('image');

    //             // CREATE FOLDER IF NOT EXISTS
    //             $path = public_path('uploads/category');

    //             if (!File::exists($path)) {
    //                 File::makeDirectory($path, 0777, true, true);
    //             }

    //             // DELETE OLD IMAGE
    //             if ($category->image && File::exists($path . '/' . $category->image)) {
    //                 File::delete($path . '/' . $category->image);
    //             }

    //             // SAVE NEW IMAGE
    //             $filename = time() . rand(100, 999) . '.' . $image->getClientOriginalExtension();

    //             $image->move($path, $filename);

    //             $data['image'] = $filename;
    //         }
    //         if ($data['is_home'] == 0) {
    //             $data['home_position'] = null;
    //         }

    //         $category->update($data);

    //         return redirect()->route('admin.categories.index')
    //             ->with('success', 'Product category updated successfully');
    //     } catch (\Exception $e) {
    //         Log::error('Error updating product category', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return back()->withInput()
    //             ->with('error', 'An error occurred while updating the product category.');
    //     }
    // }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $data = $request->validated();
            $data['slug']  = Str::slug($data['name']);
            $data['title'] = $request->title;
            $data['about'] = $request->about;

            if ($request->has('description')) {
                $data['description'] = $this->removeHtmlStyles($request->description);
            }

            // CHECK IF NEW IMAGE UPLOADED
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // DELETE OLD IMAGE FROM CLOUDINARY
                if ($category->image_public_id) {
                    try {
                        $this->deleteFromCloudinary($category->image_public_id);
                        Log::info('Old category image deleted from Cloudinary', [
                            'category_id' => $category->id,
                            'public_id' => $category->image_public_id
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old image from Cloudinary: ' . $e->getMessage());
                    }
                }

                // UPLOAD NEW IMAGE TO CLOUDINARY
                $uploadResult = $this->uploadToCloudinary($image, 'Thefastbill/categories', [
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
                    Log::info('New category image uploaded to Cloudinary', [
                        'category_id' => $category->id,
                        'public_id' => $uploadResult['public_id'],
                        'path' => $uploadResult['path']
                    ]);
                } else {
                    throw new \Exception('Failed to upload image to Cloudinary');
                }
            }

            // Set home_position to null if is_home is 0
            if ($data['is_home'] == 0) {
                $data['home_position'] = null;
            }

            // Update the category
            $category->update($data);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Product category updated successfully with Cloudinary!');
        } catch (\Exception $e) {
            Log::error('Error updating product category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'category_id' => $category->id
            ]);

            return back()->withInput()
                ->with('error', 'An error occurred while updating the product category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Product category moved to trash successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting product category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while moving the product category to trash.');
        }
    }

    /**
     * Permanently delete the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();

            return redirect()->route('admin.categories.trash')
                ->with('success', 'Category has been permanently deleted.');
        } catch (\Exception $e) {
            Log::error('Error force deleting category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while permanently deleting the category.');
        }
    }

    private function removeHtmlStyles($html)
    {
        if (empty($html)) {
            return $html;
        }

        $dom = new \DOMDocument();
        // Suppress warnings for malformed HTML
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Remove style attributes from all elements
        $xpath = new \DOMXPath($dom);
        $elements = $xpath->query('//*[@style]');

        foreach ($elements as $element) {
            if ($element instanceof \DOMElement) {
                $element->removeAttribute('style');
            }
        }

        // Remove class attributes if you want (optional)
        $elementsWithClass = $xpath->query('//*[@class]');
        foreach ($elementsWithClass as $element) {
            if ($element instanceof \DOMElement) {
                $element->removeAttribute('class');
            }
        }

        // Get the cleaned HTML
        $cleanedHtml = $dom->saveHTML();

        // Remove the outer HTML wrapper if any
        $cleanedHtml = preg_replace('/^<!DOCTYPE.+?>/', '', $cleanedHtml);
        $cleanedHtml = str_replace(['<html>', '</html>', '<body>', '</body>'], '', $cleanedHtml);

        return trim($cleanedHtml);
    }
}
