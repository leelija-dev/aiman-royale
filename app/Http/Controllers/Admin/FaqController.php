<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')
            ->latest()
            ->paginate(10);

        $categoriess = FaqCategory::where('is_active', true)->pluck('category_name', 'id');
        
        return view('Admin.faqs.index', compact('faqs', 'categoriess'));
    }

    public function create()
    {
        $categories = FaqCategory::where('is_active', true)->pluck('category_name', 'id');
        return view('Admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category_id' => 'required|exists:faq_category,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $faq = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully!');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::where('is_active', true)->pluck('category_name', 'id');
        
        return view('Admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category_id' => 'required|exists:faq_category,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully!');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully!');
    }
}
