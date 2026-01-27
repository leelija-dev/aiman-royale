<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Keyword;
use Illuminate\Http\Request;

class AdminKeywordController extends Controller
{
    /**
     * Store a newly created keyword via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Store a newly created keyword via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create or find the keyword with slug
        $keyword = Keyword::firstOrCreate(
            ['name' => $request->name],
            ['slug' => Str::slug($request->name)]
        );

        return response()->json([
            'id' => $keyword->id,
            'text' => $keyword->name
        ]);
    }

    /**
     * Search for keywords.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->input('q');
        
        $keywords = Keyword::when($search, function($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->select('id', 'name as text')
            ->orderBy('name', 'asc')
            ->limit(50) // Limit to 50 results to prevent performance issues
            ->get();

        // If no search term, return all keywords
        if (empty($search)) {
            return response()->json([
                'results' => $keywords,
                'pagination' => [
                    'more' => false
                ]
            ]);
        }

        return response()->json([
            'results' => $keywords,
            'pagination' => [
                'more' => false
            ]
        ]);
    }
}
