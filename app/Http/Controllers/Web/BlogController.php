<?php

// namespace App\Http\Controllers\Web;

// use App\Http\Controllers\Controller;
// use App\Services\Service;
// use Illuminate\Support\Str;
// use App\Models\Post;
// use App\Models\Category;
// use App\Models\Tag;
// use Illuminate\Http\Request;

// class BlogController extends Controller
// {
//     public function index(Request $request)
//     {
//         $lastFourPost = $this->latestPosts(4);
        
//         $postsQuery = Post::published()
//             ->with(['categories', 'tags', 'author']);
            
//         // Only add the where condition if we have posts to exclude
//         if ($lastFourPost->isNotEmpty()) {
//             $postsQuery->where('id', '!=', $lastFourPost[0]['id']);
//         }
        
//         $posts = $postsQuery->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();
            
//         $category1 = $this->latestPosts(6, 'web-development');

//         return view('web.blog.home', compact('lastFourPost', 'posts', 'category1'));
//     }

//     public function show(string $slug)
//     {
//         $post = Post::published()
//             ->where('slug', $slug)
//             ->firstOrFail();
            
//         $relatedPosts = Post::whereHas('categories', function($query) use ($post) {
//                 $query->whereIn('categories.id', $post->categories->pluck('id'));
//             })
//             ->where('id', '!=', $post->id)
//             ->where('status', 'published')
//             ->where(function($query) {
//                 $query->whereNull('published_at')
//                       ->orWhere('published_at', '<=', now());
//             })
//             ->take(3)
//             ->get();
        
//         // Prepare schema data
//         $schema = null;
//         if ($post->schema) {
//             $schema = $post->schema;
//         } else {
//             $author = $post->author;
//             $schemaData = [
//                 'headline' => $post->title,
//                 'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
//                 'author' => [
//                     'name' => $author ? $author->name : 'Admin',
//                     'type' => 'Person'
//                 ],
//                 'publisher' => [
//                     'name' => config('app.name'),
//                     'logo' => [
//                         'url' => asset('images/logo.png')
//                     ]
//                 ],
//                 'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String(),
//                 'dateModified' => $post->updated_at->toIso8601String(),
//                 'mainEntityOfPage' => [
//                     '@type' => 'WebPage',
//                     '@id' => url()->current()
//                 ]
//             ];
//             $schema = Service::generate_schema($schemaData);
//         }
        
//         // Prepare OG meta data
//         $ogMeta = [
//             'title' => $post->meta_title ?? $post->title,
//             'description' => $post->meta_description ?? Str::limit(strip_tags($post->content), 160),
//             'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
//             'type' => 'article',
//             'url' => url()->current(),
//             'locale' => 'en_US',
//             'site_name' => config('app.name'),
//             'publisher' => config('app.url'),
//             'published_time' => $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String(),
//             'modified_time' => $post->updated_at->toIso8601String(),
//             'section' => $post->categories->isNotEmpty() ? $post->categories->first()->name : 'Blog',
//             'tags' => $post->tags->pluck('name')->toArray(),
//             'author' => $post->author ? $post->author->name : 'Admin',
//             'reading_time' => $this->calculateReadingTime($post->content) . ' min read',
//             'image_width' => 1200,
//             'image_height' => 630,
//             'image_type' => 'image/jpeg'
//         ];
            
//         return view('web.blog.show', compact('post', 'relatedPosts', 'schema', 'ogMeta'));
//     }

//     public function category(string $slug)
//     {
//         $category = Category::where('slug', $slug)->firstOrFail();

//         $posts = Post::published()
//             ->whereHas('categories', function ($q) use ($category) {
//                 $q->where('categories.id', $category->id);
//             })
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();

//         return view('web.blog.archive', [
//             'posts' => $posts,
//             'heading' => $category->name,
//         ]);
//     }

//     public function tag(string $slug)
//     {
//         $tag = Tag::where('slug', $slug)->firstOrFail();

//         $posts = Post::published()
//             ->whereHas('tags', function ($q) use ($tag) {
//                 $q->where('tags.id', $tag->id);
//             })
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();

//         return view('web.blog.archive', [
//             'posts' => $posts,
//             'heading' => $tag->name,
//         ]);
//     }

//     public function search(Request $request)
//     {
//         $q = $request->string('q');
//         $posts = Post::published()
//             ->search($q)
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();

//         return view('web.blog.archive', [
//             'posts' => $posts,
//             'heading' => 'Search results',
//         ]);
//     }

//     public function latestPosts(int $limit, string $categorySlug = "")
//     {
//         $query = Post::published()->latest('published_at')->limit($limit);

//         if ($categorySlug) {
//             $query->whereHas('categories', function ($q) use ($categorySlug) {
//                 $q->where('slug', $categorySlug);
//             });
//         }

//         return $query->get();
//     }
    
//     /**
//      * Calculate estimated reading time for content
//      *
//      * @param string $content
//      * @param int $wordsPerMinute
//      * @return int
//      */
//     protected function calculateReadingTime($content, $wordsPerMinute = 200)
//     {
//         // Remove HTML tags and decode HTML entities
//         $content = html_entity_decode(strip_tags($content));
        
//         // Count words
//         $wordCount = str_word_count($content);
        
//         // Calculate minutes (round up)
//         $minutes = (int) ceil($wordCount / $wordsPerMinute);
        
//         // Return at least 1 minute
//         return max(1, $minutes);
//     }
// }
