<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageSeo;

class PageSeoController extends Controller
{
    public function index()
    {
        $pages = PageSeo::all();
        return view('Admin.seo.pages', compact('pages'));
    }

    public function create()
    {
        return view('Admin.seo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|string|max:100|unique:page_seo,slug',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_tags' => 'nullable|string|max:255',
            'schema_markup' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Set default value for is_active if not provided
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        PageSeo::create($data);

        return redirect()->route('seo.pages.index')
            ->with('success', 'Page SEO created successfully!');
    }

    public function edit($slug)
    {
        $page = PageSeo::where('slug', $slug)->firstOrFail();
        return view('Admin.seo.page-edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $page = PageSeo::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_tags' => 'nullable|string|max:255',
            'schema_markup' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Set default value for is_active if not provided
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $page->update($data);

        return redirect()->route('seo.pages.index')
            ->with('success', 'SEO data updated successfully!');
    }

    public function destroy($id)
    {
        $page = PageSeo::findOrFail($id);
        $page->delete();

        return redirect()->route('seo.pages.index')
            ->with('success', 'Page SEO deleted successfully!');
    }
}
