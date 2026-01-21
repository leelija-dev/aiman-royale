<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if(request()->getHttpHost() === 'leelija.projectshub.net'): ?>
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="googlebot-news" content="noindex, nofollow">
    <meta name="googlebot-image" content="noindex, nofollow">
    <meta name="googlebot-video" content="noindex, nofollow">
    <?php endif; ?>

    <title><?php echo e($pageMeta->meta_title ?? ''); ?></title>
    <meta name="description" content="<?php echo e($pageMeta->meta_description ?? ''); ?>">
    <meta name="keywords" content="<?php echo e($pageMeta->meta_keyword ?? ''); ?>">
    <meta name="tag" content="<?php echo e($pageMeta->meta_tags ?? ''); ?>">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- PWA Manifest - FIXED PATH -->
    <link rel="manifest" href="/manifest.json" />

    <link rel="icon" type="image/png" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/site-img/apple-touch-icon.png')); ?>" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldContent('styles'); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Font Awesome in  project -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


    <!-- <link rel="stylesheet" href="web/css/staging.css"> -->

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <link rel="stylesheet" href="<?php echo e(asset('web/css/custom.css')); ?>">
    <!-- build css -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/css/main2.css')); ?>">

    <?php if(isset($ogMeta)): ?>
    <?php if (isset($component)) { $__componentOriginal625ebeaa62c486f475f42d1574057a18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal625ebeaa62c486f475f42d1574057a18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.og-tags','data' => ['title' => $ogMeta['title'] ?? '','description' => $ogMeta['description'] ?? '','keywords' => $ogMeta['keywords'] ?? [],'image' => $ogMeta['image'] ?? null,'type' => $ogMeta['type'] ?? 'website','url' => $ogMeta['url'] ?? url()->current(),'locale' => $ogMeta['locale'] ?? 'en_US','siteName' => $ogMeta['site_name'] ?? config('app.name'),'publisher' => $ogMeta['publisher'] ?? config('app.name'),'publishedTime' => $ogMeta['published_time'] ?? null,'modifiedTime' => $ogMeta['modified_time'] ?? null,'section' => $ogMeta['section'] ?? 'Blog','tags' => $ogMeta['tags'] ?? [],'author' => $ogMeta['author'] ?? 'Admin','readingTime' => $ogMeta['reading_time'] ?? null,'imageWidth' => $ogMeta['image_width'] ?? 1200,'imageHeight' => $ogMeta['image_height'] ?? 630,'imageType' => $ogMeta['image_type'] ?? 'image/jpeg','schema' => $ogMeta['schema'] ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.og-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['title'] ?? ''),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['description'] ?? ''),'keywords' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['keywords'] ?? []),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['image'] ?? null),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['type'] ?? 'website'),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['url'] ?? url()->current()),'locale' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['locale'] ?? 'en_US'),'siteName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['site_name'] ?? config('app.name')),'publisher' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['publisher'] ?? config('app.name')),'publishedTime' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['published_time'] ?? null),'modifiedTime' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['modified_time'] ?? null),'section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['section'] ?? 'Blog'),'tags' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['tags'] ?? []),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['author'] ?? 'Admin'),'readingTime' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['reading_time'] ?? null),'imageWidth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['image_width'] ?? 1200),'imageHeight' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['image_height'] ?? 630),'imageType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['image_type'] ?? 'image/jpeg'),'schema' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogMeta['schema'] ?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal625ebeaa62c486f475f42d1574057a18)): ?>
<?php $attributes = $__attributesOriginal625ebeaa62c486f475f42d1574057a18; ?>
<?php unset($__attributesOriginal625ebeaa62c486f475f42d1574057a18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal625ebeaa62c486f475f42d1574057a18)): ?>
<?php $component = $__componentOriginal625ebeaa62c486f475f42d1574057a18; ?>
<?php unset($__componentOriginal625ebeaa62c486f475f42d1574057a18); ?>
<?php endif; ?>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('web/css/app-popup.css')); ?>">
</head>

<body class="overflow-x-hidden ">
    <?php if (isset($component)) { $__componentOriginalbbf74f5d9c011a8254fdccabf1ea56ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbbf74f5d9c011a8254fdccabf1ea56ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.web.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbbf74f5d9c011a8254fdccabf1ea56ac)): ?>
<?php $attributes = $__attributesOriginalbbf74f5d9c011a8254fdccabf1ea56ac; ?>
<?php unset($__attributesOriginalbbf74f5d9c011a8254fdccabf1ea56ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbbf74f5d9c011a8254fdccabf1ea56ac)): ?>
<?php $component = $__componentOriginalbbf74f5d9c011a8254fdccabf1ea56ac; ?>
<?php unset($__componentOriginalbbf74f5d9c011a8254fdccabf1ea56ac); ?>
<?php endif; ?>

    <main class="">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if (isset($component)) { $__componentOriginal20d90b51c541c707c0abda6b84690e20 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal20d90b51c541c707c0abda6b84690e20 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.web.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal20d90b51c541c707c0abda6b84690e20)): ?>
<?php $attributes = $__attributesOriginal20d90b51c541c707c0abda6b84690e20; ?>
<?php unset($__attributesOriginal20d90b51c541c707c0abda6b84690e20); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal20d90b51c541c707c0abda6b84690e20)): ?>
<?php $component = $__componentOriginal20d90b51c541c707c0abda6b84690e20; ?>
<?php unset($__componentOriginal20d90b51c541c707c0abda6b84690e20); ?>
<?php endif; ?>
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

    <?php echo $__env->yieldContent('scripts'); ?>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- PWA Installation Popup Script - IMPROVED INSTALLATION -->
    <script src="<?php echo e(asset('web/js/pwa-installation.js')); ?>"></script>
    

    <!-- common js  -->
    <script src="<?php echo e(asset('web/js/main.js')); ?>"></script>
</body>

</html><?php /**PATH F:\aiman-royal\aiman-royale\resources\views/layout/web/main-layout.blade.php ENDPATH**/ ?>