<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
    id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 m-0">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    
                    <?php echo $__env->yieldContent('source', 'Dashboard'); ?>
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">
                
                <?php echo $__env->yieldContent('page-title', 'Index'); ?>

            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-lg-0 me-0  w-auto d-flex justify-content-end" id="navbar">
            <!-- <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div> -->
            <ul class="navbar-nav  justify-content-end gap-2 w-auto">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <!-- <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li> -->
                <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="position-relative d-inline-block" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell me-sm-1 "></i>
                        <?php if($notifications->count()): ?>
                        <span class="position-absolute top-0 start-50 
                                            bg-primary border border-white rounded-circle"
                            style="width: 10px; height: 10px;">
                            
                        </span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4 "
                        aria-labelledby="dropdownMenuButton">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md"
                                href="<?php echo e(route('notifications.read', $notification->id)); ?>">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <?php echo e($notification->message); ?>

                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            <?php echo e($notification->created_at->diffForHumans()); ?>

                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="dropdown-item text-center">No new notifications</li>
                        <?php endif; ?>

                    </ul>
                </li> -->






                
                
                
                <li class="nav-item d-lg-flex d-none align-items-center ">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa-solid fa-power-off me-sm-1"></i>
                            
                            <!-- <span class="d-sm-inline d-none">Sign In</span> -->
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav><?php /**PATH C:\project\aiman-royale\resources\views/components/admin/navbar.blade.php ENDPATH**/ ?>