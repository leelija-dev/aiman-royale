<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('name')->paginate(20);
        return view('Admin.blog.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('Admin.blog.tags.create');
    }

    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        Tag::create($data);
        return redirect()->route('admin.blog.tags.index')->with('success', 'Tag created');
    }

    public function edit(Tag $tag)
    {
        return view('Admin.blog.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->update($data);
        return redirect()->route('admin.blog.tags.index')->with('success', 'Tag updated');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.blog.tags.index')->with('success', 'Tag deleted');
    }

    public function searchStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create or find the tag with slug
        $tag = Tag::firstOrCreate(
            ['name' => $request->name],
            ['slug' => Str::slug($request->name)]
        );

        return response()->json(['id' => $tag->id, 'text' => $tag->name]);
}
}
