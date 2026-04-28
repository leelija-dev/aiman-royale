<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryOccasionContent;
use App\Models\Category;
use App\Models\Occasion;
use Illuminate\Http\Request;

class CategoryOccasionContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CategoryOccasionContent::with(['category', 'occasion']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by occasion
        if ($request->filled('occasion_id')) {
            $query->where('occasion_id', $request->occasion_id);
        }

        // Search by content
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('occasion', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->orderBy('category_id')->orderBy('occasion_id')->paginate(10);
        
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $occasions = Occasion::select('id', 'name')->orderBy('name')->get();

        return view('admin.category-occasion-content.index', compact('data', 'categories', 'occasions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $occasions = Occasion::select('id', 'name')->orderBy('name')->get();

        return view('admin.category-occasion-content.create', compact('categories', 'occasions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'required|exists:ocassions,id',
            'content' => 'nullable|string|max:10000',
        ]);

        // Check if this combination already exists
        $existing = CategoryOccasionContent::where('category_id', $data['category_id'])
                                          ->where('occasion_id', $data['occasion_id'])
                                          ->first();

        if ($existing) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'This category and occasion combination already exists.');
        }

        CategoryOccasionContent::create($data);

        return redirect()->route('admin.category-occasion-content.index')
                        ->with('success', 'Category occasion content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryOccasionContent $categoryOccasionContent)
    {
        $categoryOccasionContent->load(['category', 'occasion']);
        
        return view('admin.category-occasion-content.show', compact('categoryOccasionContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryOccasionContent $categoryOccasionContent)
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $occasions = Occasion::select('id', 'name')->orderBy('name')->get();

        return view('admin.category-occasion-content.edit', compact('categoryOccasionContent', 'categories', 'occasions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryOccasionContent $categoryOccasionContent)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'required|exists:ocassions,id',
            'content' => 'nullable|string|max:10000',
        ]);

        // Check if this combination already exists (excluding current record)
        $existing = CategoryOccasionContent::where('category_id', $data['category_id'])
                                          ->where('occasion_id', $data['occasion_id'])
                                          ->where('id', '!=', $categoryOccasionContent->id)
                                          ->first();

        if ($existing) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'This category and occasion combination already exists.');
        }

        $categoryOccasionContent->update($data);

        return redirect()->route('admin.category-occasion-content.index')
                        ->with('success', 'Category occasion content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryOccasionContent $categoryOccasionContent)
    {
        $categoryOccasionContent->delete();

        return redirect()->route('admin.category-occasion-content.index')
                        ->with('success', 'Category occasion content deleted successfully.');
    }

    /**
     * Get content for specific category and occasion (AJAX endpoint).
     */
    public function getContent(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'occasion_id' => 'required|exists:ocassions,id',
        ]);

        $content = CategoryOccasionContent::where('category_id', $request->category_id)
                                         ->where('occasion_id', $request->occasion_id)
                                         ->first();

        return response()->json([
            'success' => true,
            'content' => $content ? $content->content : null,
        ]);
    }
}
