<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Service;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Calculate estimated reading time for content
     *
     * @param string $content
     * @param int $wordsPerMinute
     * @return int
     */
    // protected function calculateReadingTime($content, $wordsPerMinute = 200)
    // {
    //     // Remove HTML tags and decode HTML entities
    //     $content = html_entity_decode(strip_tags($content));

    //     // Count words
    //     $wordCount = str_word_count($content);

    //     // Calculate minutes (round up)
    //     $minutes = (int) ceil($wordCount / $wordsPerMinute);

    //     // Return at least 1 minute
    //     return max(1, $minutes);
    // }

    public function index(Request $request)
    {
        $query = Post::query()->with(['author', 'categories', 'tags']);

        if ($request->filled('search')) {
            $query->search($request->string('search'));
        }

        $posts = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('Admin.blog.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $keywords = Keyword::orderBy('name')->get();
        return view('Admin.blog.posts.create', compact('categories', 'tags', 'keywords'));
    }

    public function store(PostRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        // dd($data);
        // Set author and timestamps
        $data['author_id'] = auth('admin')->id();
        $data['published_at'] = now();

        // Slug fallback
        // $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        if (empty($data['slug'])) {
            $slugService = new \App\Services\Service();
            $data['slug'] = $slugService->generate_slug($data['title']);
        }

        // Featured image
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = 'blog-' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure the directories exist
            $blogDir = 'blog';
            $featuredImgDir = 'blog/featured_img';
            
            // Check and create blog directory if it doesn't exist
            if (!Storage::disk('public')->exists($blogDir)) {
                Storage::disk('public')->makeDirectory($blogDir, 755);
            }
            
            // Check and create featured_img directory inside blog directory if it doesn't exist
            if (!Storage::disk('public')->exists($featuredImgDir)) {
                Storage::disk('public')->makeDirectory($featuredImgDir, 755);
            }
            
            $directory = $featuredImgDir; // Keep the original directory variable for the storeAs method
            
            $path = $file->storeAs($directory, $filename, 'public');
            $data['featured_image'] = $path;
        }
        // $data['meta_keyword'] = $request->meta_keyword;

        // OG image
        if ($request->hasFile('og_image')) {
            $file = $request->file('og_image');
            $filename = 'og-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');
            $data['og_image'] = $path;
        }

        if (empty($data['schema'])) {
            $session = session()->all();
            $data['author'] = $session['login_admin_59ba36addc2b2f9401580f014c7f58ea4e30989d'] ?? 'admin';
            $slugService = new \App\Services\Service();
            $schema = $slugService->generate_schema($data);
            $data['schema'] = $schema;
            // dd($schema);
        }
        // Generate schema if not provided

        $post = Post::create($data);

        // Sync relations
        $post->categories()->sync($request->input('categories', []));
        $post->tags()->sync($request->input('tags', []));
        $post->keywords()->sync($request->input('keywords', []));

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $post->load(['categories', 'tags']);
        return view('Admin.blog.posts.edit', compact('post', 'categories', 'tags'));
    }

    // public function update(PostRequest $request, Post $post)
    // {
    //     $data = $request->validated();

    //     // Handle featured image update
    //     if ($request->hasFile('featured_image')) {
    //         // Delete old featured image if exists
    //         if ($post->featured_image) {
    //             Storage::disk('public')->delete($post->featured_image);
    //         }

    //         $file = $request->file('featured_image');
    //         $filename = 'blog-' . time() . '.' . $file->getClientOriginalExtension();
    //         $path = $file->storeAs('blog/featured_img', $filename, 'public');
    //         $data['featured_image'] = $path;
    //     }

    //     // Handle OG image update
    //     if ($request->hasFile('og_image')) {
    //         // Delete old OG image if exists
    //         if ($post->og_image) {
    //             Storage::disk('public')->delete($post->og_image);
    //         }

    //         $file = $request->file('og_image');
    //         $filename = 'og-' . time() . '.' . $file->getClientOriginalExtension();
    //         $path = $file->storeAs('blog', $filename, 'public');
    //         $data['og_image'] = $path;
    //     }

    //     // Always update schema and OG meta data when post is updated
    //     $author = auth('admin')->user();
    //     $publishedAt = $post->published_at ?? now();
    //     $readingTime = $this->calculateReadingTime($data['content'] ?? '');

    //     // Prepare schema data
    //     $schemaData = [
    //         'headline' => $data['title'],
    //         'image' => $data['featured_image'] ? asset('storage/' . $data['featured_image']) : null,
    //         'author' => [
    //             'name' => $author->name ?? 'Admin',
    //             'type' => 'Person'
    //         ],
    //         'publisher' => [
    //             'name' => config('app.name'),
    //             'logo' => [
    //                 'url' => asset('images/logo.png') // Update this with your logo path
    //             ]
    //         ],
    //         'datePublished' => $publishedAt->toIso8601String(),
    //         'dateModified' => now()->toIso8601String(),
    //         'mainEntityOfPage' => [
    //             '@type' => 'WebPage',
    //             '@id' => url()->current()
    //         ]
    //     ];

    //     // Generate FAQ schema if questions exist
    //     if (isset($data['faq_questions']) && is_array($data['faq_questions'])) {
    //         $faqItems = [];
    //         foreach ($data['faq_questions'] as $index => $question) {
    //             if (!empty($question['question']) && !empty($question['answer'])) {
    //                 $faqItems[] = [
    //                     '@type' => 'Question',
    //                     'name' => $question['question'],
    //                     'acceptedAnswer' => [
    //                         '@type' => 'Answer',
    //                         'text' => $question['answer']
    //                     ]
    //                 ];
    //             }
    //         }

    //         if (!empty($faqItems)) {
    //             $schemaData['mainEntity'] = $faqItems;
    //         }
    //     }

    //     $data['schema'] = Service::generate_schema($schemaData);

    //     // Update OG meta data
    //     $data['og_meta'] = [
    //         'title' => $data['meta_title'] ?? $data['title'],
    //         'description' => $data['meta_description'] ?? Str::limit(strip_tags($data['content']), 160),
    //         'image' => $data['featured_image'] ? asset('storage/' . $data['featured_image']) : null,
    //         'type' => 'article',
    //         'url' => url()->current(),
    //         'locale' => 'en_US',
    //         'site_name' => config('app.name'),
    //         'publisher' => config('app.url'),
    //         'published_time' => $publishedAt->toIso8601String(),
    //         'modified_time' => now()->toIso8601String(),
    //         'section' => $data['category_id'] ? ($category = Category::find($data['category_id'])) ? $category->name : 'Blog' : 'Blog',
    //         'tags' => isset($data['tags']) ? Tag::whereIn('id', $data['tags'])->pluck('name')->toArray() : [],
    //         'author' => $author->name ?? 'Admin',
    //         'reading_time' => $readingTime . ' min read',
    //         'image_width' => 1200,
    //         'image_height' => 630,
    //         'image_type' => 'image/jpeg'
    //     ];

    //     // Keep existing images if not replaced
    //     if (!$request->hasFile('featured_image') && !isset($data['featured_image'])) {
    //         unset($data['featured_image']);
    //     }

    //     // Update the post
    //     // Update the post
    //     $post->update($data);

    //     // Sync relations
    //     $post->categories()->sync($request->input('categories', []));
    //     $post->tags()->sync($request->input('tags', []));
    //     $post->keywords()->sync($request->input('keywords', []));

    //     return redirect()
    //         ->route('admin.blog.posts.index')
    //         ->with('success', 'Post updated successfully!');
    // }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();

        // Keep existing images if not replaced
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
            $file = $request->file('featured_image');
            $filename = 'blog-' . time() . '.' . $file->getClientOriginalExtension();
            $data['featured_image'] = $file->storeAs('blog/featured_img', $filename, 'public');
        } else {
            unset($data['featured_image']);
        }

        if ($request->hasFile('og_image')) {
            if ($post->og_image) Storage::disk('public')->delete($post->og_image);
            $data['og_image'] = $request->file('og_image')->store('blog', 'public');
        } else {
            unset($data['og_image']);
        }
        // $data['meta_keyword'] = $request->meta_keyword;

        $post->update($data);
        $post->categories()->sync($request->input('categories', []));
        $post->tags()->sync($request->input('tags', []));
        $post->keywords()->sync($request->input('keywords', []));

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
        if ($post->og_image) Storage::disk('public')->delete($post->og_image);
        $post->delete();
        return redirect()->route('admin.blog.posts.index')->with('success', 'Post deleted');
    }
}
