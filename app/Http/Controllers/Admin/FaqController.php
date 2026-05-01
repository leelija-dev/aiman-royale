<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{
    public function index()
    {
        // Load FAQs with relationships - use eager loading with proper handling
        $faqs = Faq::with(['category', 'product'])
            ->latest()
            ->paginate(10);

            // dd($faqs);

        // Get categories and products for filters
        $categoriess = Category::where('is_active', true)->pluck('name', 'id');
        $products = Product::where('status', 'active')->pluck('name', 'id');
        
        
        
        return view('Admin.faqs.index', compact('faqs', 'categoriess', 'products'));
    }

    public function create()
    {
        $categoriess = Category::where('is_active', true)->pluck('name', 'id');
        $products = Product::where('status', 'active')->pluck('name', 'id');
        return view('Admin.faqs.create', compact('categoriess', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'product_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            // 'category_id' => 'required|exists:faq_category,id',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);
// dd($request);
        $faq = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
            'heading' => $request->heading ?? '',
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully!');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categoriess = Category::where('is_active', true)->pluck('name', 'id');
        $products = Product::where('status', 'active')->pluck('name', 'id');
        
        return view('Admin.faqs.edit', compact('faq', 'categoriess', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'heading' => $request->heading ?? '',
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
