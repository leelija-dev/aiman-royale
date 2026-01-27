{{-- @props([
    'title' => null,
    'description' => null,
    'schema' => null,
    'keywords' => null,
    'image' => null,
    'type' => 'website',
    'url' => null,
    'publishedTime' => null,
    'modifiedTime' => null,
    'section' => 'Blog',
    'tags' => [],
    'locale' => 'en_US',
    'publisher' => null,
    'creator' => null,
    'imageWidth' => null,
    'imageHeight' => null,
    'imageType' => null,
    'readingTime' => null,
    'authorName' => null
])

@php
    $siteName = config('app.name');
    $currentUrl = $url ?? url()->current();
    
    // Handle keywords - can be string (comma-separated) or array
    $keywordArray = [];
    if (isset($keywords)) {
        $keywordArray = is_string($keywords) ? array_map('trim', explode(',', $keywords)) : (is_array($keywords) ? $keywords : []);
        $keywordArray = array_filter($keywordArray);
    }
    
    // Handle tags - ensure it's an array
    $tagArray = is_array($tags) ? $tags : [];
    
    // Default publisher
    $publisher = $publisher ?? config('app.name');
    
    // Default creator
    $creator = $creator ?? config('app.name');
    
    // Format dates
    $publishedTime = $publishedTime ? (is_string($publishedTime) ? $publishedTime : $publishedTime->toIso8601String()) : null;
    $modifiedTime = $modifiedTime ? (is_string($modifiedTime) ? $modifiedTime : $modifiedTime->toIso8601String()) : null;
    
    // Default image metadata
    $imageWidth = $imageWidth ?? 1200;
    $imageHeight = $imageHeight ?? 630;
    $imageType = $imageType ?? 'image/jpeg';
    
    // Author name fallback
    $authorName = $authorName ?? ($authorName ?? 'Admin');
    
    // Parse schema if it's a JSON string
    $schemaData = null;
    if (!empty($schema)) {
        if (is_string($schema)) {
            try {
                $schemaData = json_decode($schema, false, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                // If not valid JSON, treat as raw HTML
                $schemaData = $schema;
            }
        } else {
            $schemaData = $schema;
        }
    }
@endphp

<!-- Primary Meta Tags -->
@if($title)
    <meta name="title" content="{!! htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false) !!}">
@endif

@if($description)
    <meta name="description" content="{!! htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false) !!}">
@endif

@foreach($keywordArray as $keyword)
    @if(!empty(trim($keyword)))
        <meta name="keywords" content="{{ trim($keyword) }}">
    @endif
@endforeach

<!-- Open Graph / Facebook -->
<meta property="og:locale" content="{{ $locale }}" />
<meta property="og:type" content="{{ $type === 'article' ? 'article' : 'website' }}" />
@if($title)
    <meta property="og:title" content="{!! htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false) !!}" />
@endif
@if($description)
    <meta property="og:description" content="{!! htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false) !!}" />
@endif
<meta property="og:url" content="{{ $currentUrl }}" />
<meta property="og:site_name" content="{{ $siteName }}" />
@if($publisher)
    <meta property="article:publisher" content="{{ $publisher }}" />
@endif
@if($image)
    <meta property="og:image" content="{{ $image }}" />
    <meta property="og:image:secure_url" content="{{ str_replace('http://', 'https://', $image) }}" />
    <meta property="og:image:width" content="{{ $imageWidth }}" />
    <meta property="og:image:height" content="{{ $imageHeight }}" />
    <meta property="og:image:alt" content="{!! htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8', false) !!}" />
    <meta property="og:image:type" content="{{ $imageType }}" />
@endif
@if($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}" />
@endif
@if($modifiedTime)
    <meta property="article:modified_time" content="{{ $modifiedTime }}" />
@endif
@if($section)
    <meta property="article:section" content="{{ $section }}" />
@endif

@foreach($tagArray as $tag)
    <meta property="article:tag" content="{{ $tag }}" />
@endforeach

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
@if($title)
    <meta name="twitter:title" content="{!! htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false) !!}" />
@endif
@if($description)
    <meta name="twitter:description" content="{!! htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false) !!}" />
@endif
@if($image)
    <meta name="twitter:image" content="{{ $image }}" />
@endif
@if($authorName)
    <meta name="twitter:site" content="{{ Str::slug($authorName) }}" />
    <meta name="twitter:creator" content="{{ Str::slug($authorName) }}" />
@elseif(isset($creator))
    <meta name="twitter:site" content="{{ Str::slug($creator) }}" />
    <meta name="twitter:creator" content="{{ Str::slug($creator) }}" />
@endif
@if($authorName)
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="{{ $authorName }}" />
@endif
@if($readingTime)
    <meta name="twitter:label2" content="Time to read" />
    <meta name="twitter:data2" content="{{ $readingTime }}" />
@endif

@if(!empty($schemaData))
<script type="application/ld+json">
           {!! $schemaData !!}
        </script>
    <!-- @if(is_string($schemaData))
        {!! $schemaData !!}
    @else
        <script type="application/ld+json">
            @json($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        </script>
    @endif -->
@endif --}}
