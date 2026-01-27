<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the product categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $categories = Category::latest()->paginate(15);
            return view('Admin.categories.index', compact('categories'));
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
            $categories = Category::onlyTrashed()->latest()->paginate(20);
            return view('Admin.categories.trash', compact('categories'));
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


        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);

            Category::create($data);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Product category created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'An error occurred while creating the product category.');
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
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);

            $category->update($data);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Product category updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating product category', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'An error occurred while updating the product category.');
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
}
