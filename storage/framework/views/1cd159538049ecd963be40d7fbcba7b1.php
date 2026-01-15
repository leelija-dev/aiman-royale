<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if(request()->getHttpHost() === 'leelija.projectshub.net'): ?>
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="googlebot-news" content="noindex, nofollow">
    <meta name="googlebot-image" content="noindex, nofollow">
    <meta name="googlebot-video" content="noindex, nofollow">
    <?php endif; ?>



    <title> <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/site-img/apple-touch-icon.png')); ?>" />
    <link rel="manifest" href="<?php echo e(asset('images/site-img/site.webmanifest')); ?>" />

    <!-- Google Font: Source Sans Pro -->
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">





    <!-- Ionicons -->
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo e(asset('Admin/css/soft-ui-dashboard.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('Admin/css/nucleo-icons.css')); ?>">
    <link href="<?php echo e(asset('Admin/css/nucleo-svg.css')); ?>">

    <link href="<?php echo e(asset('Admin/css/leelija-admin.css')); ?>">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <!-- Font Awesome CDN -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />



    <?php echo $__env->yieldPushContent('styles'); ?>



    <link rel="stylesheet" href="<?php echo e(asset('web/css/app-popup.css')); ?>">
</head>

<body class="g-sidenav-show  bg-gray-100">



    <?php if (isset($component)) { $__componentOriginalbebe114f3ccde4b38d7462a3136be045 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbebe114f3ccde4b38d7462a3136be045 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $attributes = $__attributesOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $component = $__componentOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__componentOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-auto ">

        <?php if (isset($component)) { $__componentOriginalf818c67b6eb448edb731318e48f2e69b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf818c67b6eb448edb731318e48f2e69b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf818c67b6eb448edb731318e48f2e69b)): ?>
<?php $attributes = $__attributesOriginalf818c67b6eb448edb731318e48f2e69b; ?>
<?php unset($__attributesOriginalf818c67b6eb448edb731318e48f2e69b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf818c67b6eb448edb731318e48f2e69b)): ?>
<?php $component = $__componentOriginalf818c67b6eb448edb731318e48f2e69b; ?>
<?php unset($__componentOriginalf818c67b6eb448edb731318e48f2e69b); ?>
<?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
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

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- PWA Installation Popup Script - IMPROVED INSTALLATION -->
    <script src="<?php echo e(asset('web/js/pwa-installation.js')); ?>"></script>



    <script src="<?php echo e(asset('/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/perfect-scrollbar.min.js')); ?>"></script>


    <script src="<?php echo e(asset('Admin/js/soft-ui-dashboard.js')); ?>"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>


    <?php echo $__env->yieldPushContent('scripts'); ?>

    <?php if(session('success') || session('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "<?php echo e(session('success') ? 'success' : 'error'); ?>",
                title: "<?php echo e(session('success') ?? session('error')); ?>",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        });
    </script>
    <?php endif; ?>




    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\aiman\resources\views/Admin/layouts/master.blade.php ENDPATH**/ ?>