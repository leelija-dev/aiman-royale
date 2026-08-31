<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

            {{-- Home Page --}}
            <url>
                <loc>{{ url('/') }}/</loc>
                <lastmod>2026-08-28T17:43:34.757Z</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>

    {{-- Other URLs --}}
    @foreach($urls as $item)

        @if(
            $item['loc'] !== url('/') &&
            $item['loc'] !== url('/') . '/' &&
            $item['loc'] !== url('/robots.txt')
        )
            <url>
                <loc>{{ $item['loc'] }}</loc>
                <lastmod>{{ $item['lastmod'] }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>
        @endif

    @endforeach

</urlset>