<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class RobotsController extends Controller
{
   

public function index()
{
    $robotsPath = public_path('robots.txt');

    $robotsFile = null;

    if (file_exists($robotsPath)) {
        $robotsFile = [
            'name' => 'robots.txt',
            'size' => filesize($robotsPath),
            'updated_at' => filemtime($robotsPath),
        ];
    }

    return view('Admin.robots.index', compact('robotsFile'));
}

public function store(Request $request)
{
    $request->validate([
        'robots_file' => [
            'required',
            'file',
            'max:1024',
        ],
    ]);

    $file = $request->file('robots_file');

    // Only allow robots.txt
    if (strtolower($file->getClientOriginalName()) !== 'robots.txt') {
        return back()->withErrors([
            'robots_file' => 'Please upload a file named robots.txt.'
        ]);
    }

    // Store/replace public/robots.txt
    $file->move(public_path(), 'robots.txt');

    return redirect()
        ->route('robots.index')
        ->with('success', 'robots.txt uploaded successfully.');
}

  public function generate()
    {
        $urls = [];

        foreach (Route::getRoutes() as $route) {

            // Only GET/HEAD routes
            if (!in_array('GET', $route->methods())) {
                continue;
            }

            $uri = $route->uri();

            // Skip Laravel/system routes
            if (
                str_contains($uri, '{') ||
                str_starts_with($uri, 'admin') ||
                str_starts_with($uri, 'api') ||
                in_array($uri, [
                    'login',
                    'register',
                    'logout',
                    'cart',
                    'checkout',
                    'checkout/cancel',
                    'checkout/success',
                    'checkout/payment',
                    'purchase',
                    'sitemap.xml',
                ])
            ) {
                continue;
            }

            // Generate URL
            $url = url($uri);

            $urls[] = [
                'loc' => $url,
                'lastmod' => now()->toAtomString(),
            ];
        }

        // Remove duplicate URLs
        $urls = collect($urls)
            ->unique('loc')
            ->values();

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
