<?php

// namespace App\Http\Controllers\Web;

// use App\Http\Controllers\Controller;
// use App\Models\Post;
// use App\Models\Category;
// use App\Models\Tag;
// use Illuminate\Http\Request;

// class BlogController extends Controller
// {
//     public function index(Request $request)
//     {
//         // Get the latest post for the hero section
//         $lastOnePost = Post::published()
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(1)
//             ->withQueryString();

//         // Get all posts except the one already shown in hero
//         $posts = Post::published()
//             ->where('id', '!=', $lastOnePost->first()->id) // Exclude the latest post
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();

//         return view('web.blog.home', compact('posts', 'lastOnePost'));
//     }

//     public function show(string $slug)
//     {
//         $post = Post::published()
//             ->where('slug', $slug)
//             ->with(['categories', 'tags', 'author'])
//             ->firstOrFail();

//         return view('web.blog.show', compact('post'));
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
//             ->paginate(10);

//         return view('web.blog.category', compact('category', 'posts'));
//     }

//     public function tag(string $slug)
//     {
//         $tag = Tag::where('slug', $slug)->firstOrFail();

//         $posts = $tag->posts()
//             ->published()
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10);

//         return view('web.blog.tag', compact('tag', 'posts'));
//     }

//     public function search(Request $request)
//     {
//         $query = $request->input('q');

//         $posts = Post::published()
//             ->where('title', 'like', "%{$query}%")
//             ->orWhere('content', 'like', "%{$query}%")
//             ->with(['categories', 'tags', 'author'])
//             ->latest('published_at')
//             ->paginate(10)
//             ->withQueryString();

//         return view('web.blog.search', compact('posts', 'query'));
//     }
// }
