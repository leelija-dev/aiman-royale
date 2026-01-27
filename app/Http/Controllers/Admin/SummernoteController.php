<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SummernoteController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'blog-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');
            
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }
        
        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
