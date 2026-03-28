<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $faqCategories = FaqCategory::latest()->paginate(10);
        return view('Admin.faqCategory.index', compact('faqCategories'));
    }

    public function create()
    {
        return view('Admin.faqCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:faq_category,category_name',
            'is_active' => 'boolean'
        ]);

        $faqCategory = FaqCategory::create([
            'category_name' => $request->category_name,
            'is_active' => $request->boolean('is_active', false)
        ]);

        return redirect()->route('faqCategory.index')->with('success', 'FAQ Category created successfully!');
    }

    public function edit($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        return view('Admin.faqCategory.edit', compact('faqCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:faq_category,category_name,' . $id,
            'is_active' => 'boolean'
        ]);

        $faqCategory = FaqCategory::findOrFail($id);
        $faqCategory->update([
            'category_name' => $request->category_name,
            'is_active' => $request->boolean('is_active', false)
        ]);

        return redirect()->route('faqCategory.index')->with('success', 'FAQ Category updated successfully!');
    }

    public function destroy($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        $faqCategory->delete();

        return redirect()->route('faqCategory.index')->with('success', 'FAQ Category deleted successfully!');
    }
}
