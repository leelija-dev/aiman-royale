<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if(request()->getHttpHost() === 'leelija.projectshub.net')
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="googlebot-news" content="noindex, nofollow">
    <meta name="googlebot-image" content="noindex, nofollow">
    <meta name="googlebot-video" content="noindex, nofollow">
    @endif

    <title>{{$pageMeta->meta_title ?? ''}}</title>
    <meta name="description" content="{{$pageMeta->meta_description ?? ''}}">
    <meta name="keywords" content="{{$pageMeta->meta_keyword ?? ''}}">
    <meta name="tag" content="{{$pageMeta->meta_tags ?? ''}}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Manifest - FIXED PATH -->
    <link rel="manifest" href="/manifest.json" />

    <link rel="icon" type="image/png" href="{{asset('web/images/amarmaa-logo.webp')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{asset('web/images/amarmaa-logo.webp')}}" />
    <link rel="shortcut icon" href="{{asset('web/images/amarmaa-logo.webp')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/site-img/apple-touch-icon.png')}}" />

   
    @yield('styles')

    @stack('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&family=Montserrat:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500&display=swap"
      rel="stylesheet"
    />

    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <!-- Font Awesome in  project -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" /> -->


    <!-- <link rel="stylesheet" href="web/css/staging.css"> -->

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <link rel="stylesheet" href="{{asset('web/css/custom.css')}}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(isset($ogMeta))
    <x-blog.og-tags
        :title="$ogMeta['title'] ?? ''"
        :description="$ogMeta['description'] ?? ''"
        :keywords="$ogMeta['keywords'] ?? []"
        :image="$ogMeta['image'] ?? null"
        :type="$ogMeta['type'] ?? 'website'"
        :url="$ogMeta['url'] ?? url()->current()"
        :locale="$ogMeta['locale'] ?? 'en_US'"
        :siteName="$ogMeta['site_name'] ?? config('app.name')"
        :publisher="$ogMeta['publisher'] ?? config('app.name')"
        :publishedTime="$ogMeta['published_time'] ?? null"
        :modifiedTime="$ogMeta['modified_time'] ?? null"
        :section="$ogMeta['section'] ?? 'Blog'"
        :tags="$ogMeta['tags'] ?? []"
        :author="$ogMeta['author'] ?? 'Admin'"
        :readingTime="$ogMeta['reading_time'] ?? null"
        :imageWidth="$ogMeta['image_width'] ?? 1200"
        :imageHeight="$ogMeta['image_height'] ?? 630"
        :imageType="$ogMeta['image_type'] ?? 'image/jpeg'"
        :schema="$ogMeta['schema'] ?? null" />
    @endif

    <link rel="stylesheet" href="{{asset('web/css/app-popup.css')}}">
</head>

<body class="overflow-x-hidden ">
    <x-web.navbar />

    <main class="">
        @yield('content')
    </main>

    <x-web.footer />
    <!-- Add this temporarily for testing -->
    <!-- <button onclick="localStorage.clear(); location.reload();" 
        style="position: fixed; top: 10px; right: 10px; z-index: 10000; background: red; color: white; padding: 5px;display:none;">
    Reset Popup
</button> -->

    <!-- PWA Installation Popup -->
    <div class="pwa-popup-overlay" id="pwaPopupOverlay"></div>
    <div class="pwa-install-popup" id="pwaInstallPopup">
        <button class="pwa-close-btn" id="pwaCloseBtn">
            <i class="fas fa-times"></i>
        </button>
        <div class="pwa-popup-content">
            <div class="pwa-popup-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="pwa-popup-text">
                <h3>Install App</h3>
                <p>Add this website to your home screen for quick access</p>
            </div>
        </div>
        <div class="pwa-popup-actions">
            <button class="pwa-later-btn" id="pwaLaterBtn">Maybe Later</button>
            <button class="pwa-install-btn" id="pwaInstallBtn">
                <span class="btn-text">Install</span>
            </button>
        </div>
    </div>

    <!-- PWA Installation Instructions -->
    <div class="pwa-instructions" id="pwaInstructions">
        <h3>How to Install</h3>
        <p>Follow these steps to install our app:</p>
        <ol>
            <!-- This will be dynamically replaced based on browser -->
            <li>Tap the <strong>Menu</strong> button <i class="fas fa-ellipsis-vertical"></i> in your browser</li>
            <li>Select <strong>"Install app"</strong> or <strong>"Add to Home screen"</strong></li>
            <li>Confirm by tapping <strong>"Install"</strong></li>
        </ol>
        <button class="pwa-instructions-close" id="pwaInstructionsClose">Got It</button>
    </div>

    @yield('scripts')

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- PWA Installation Popup Script - IMPROVED INSTALLATION -->
    <script src="{{asset('web/js/pwa-installation.js')}}"></script>
    

    <!-- common js  -->
    <script src="{{asset('web/js/main.js')}}"></script>
</body>

</html>