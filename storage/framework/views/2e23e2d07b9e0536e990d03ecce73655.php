

<?php
$user = auth('admin')->user(); // or auth('admin')->user() if using custom guard

$userId = $user['user_id'];

use App\Models\Admin;
$roles = $user->getRoleNames();

$admin = Admin::find($userId);

$productAndUnit = request()->routeIs('admin.categories.*', 'admin.products.*', 'admin.unit.*', 'admin.brands.*', 'admin.colors.*', 'admin.sizes.*', 'admin.product-variants.*','admin.categories.create') ? true : false;
$isNewsletterActive = false;
$isEmailActive = false;
?>



<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main" style="background: white !important;">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="<?php echo e(route('Admin.dashboard')); ?>">
            <div class="d-flex align-items-center" style="font-size: 27px;"><strong><span class="text-success">Aiman</span><span class="text-info"> Royale</span></strong>
            </div>
            
            
            
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav" id="menu-accordion">
            <li class="nav-item ">
                <a class="nav-link <?php echo e(request()->routeIs('Admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('Admin.dashboard')); ?>">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            

            

            
            
            


            
            
            

            
            
            

            
            
            
            

            

            

            
            
                    
                    
                    
                    
                    
            
            
            

            

            <li class="nav-item has-submenu">
                <a class="nav-link  submenu-toggle <?php echo e($productAndUnit ? 'active' : ''); ?>"
                    href="#" href="#" data-bs-toggle="collapse" data-bs-target="#marketing-menu"
                    aria-expanded="<?php echo e($productAndUnit ? 'true' :'false'); ?>"
                    aria-controls="marketing-menu">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <span class="nav-link-text ms-1">Product & Units</span>
                </a>
                <div id="marketing-menu"
                    class="collapse submenu <?php echo e($productAndUnit ? 'show' : ''); ?> "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('admin.products')); ?>">Products</a>
                        </li>
                    </ul>
                </div>
                <div id="marketing-menu"
                    class="collapse submenu <?php echo e($productAndUnit ? 'show' : ''); ?> "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.categories.index')); ?>">Categories</a>
                        </li>
                    </ul>
                </div>
                <div id="marketing-menu"
                    class="collapse submenu <?php echo e($productAndUnit ? 'show' : ''); ?> "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.brands.index')); ?>">Brands</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.colors.*') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.colors')); ?>">Colors</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.sizes.*') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.sizes')); ?>">Sizes</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.product-variants.*','admin.categories.create') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.product-variants')); ?>">Product Variants</a>
                        </li>
                    </ul>
                </div>

                <div id="marketing-menu"
                    class="collapse submenu <?php echo e($productAndUnit ? 'show' : ''); ?> "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e(request()->routeIs('admin.unit','admin.add-unit','admin.unit.update') ? 'active' : ''); ?> "
                                href="<?php echo e(route('admin.unit')); ?>">Units</a>
                        </li>
                    </ul>
                </div>
                
                
            </li>

            

            

            <?php if($admin->hasPermissionTo('view reports') || $admin->hasPermissionTo('view roles') || $admin->hasPermissionTo('view page') || $roles[0] == 'superadmin'): ?>
            <?php
            $isUserManagement = request()->routeIs('admin.roles*','admin.roles.edit-role', 'admin.users*', "admin.permissions*");

            $isRolesActive=request()->routeIs('admin.roles','admin.roles.create','admin.roles.edit-role');
            $isUserActive=request()->routeIs('admin.users*');
            $ispermissionActive = request()->routeIs('admin.permissions', 'admin.create','admin.edit-permission');
            ?>

            <li class="nav-item has-submenu ">
                <a class="nav-link  submenu-toggle <?php echo e($isUserManagement ? 'active' : ''); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#users-items-menu" aria-expanded="<?php echo e($isUserManagement ? 'true' : 'false'); ?>" aria-controls="users-items-menu">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-line"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>

                <div id="users-items-menu" class="collapse submenu users-items-menu <?php echo e($isUserManagement ? 'show' : ''); ?>" data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link <?php echo e($isUserActive ?  'active' : ''); ?>"
                                href="<?php echo e(route('admin.users.show')); ?>">Users</a>
                        </li>
                    </ul>
                </div>
            </li>
            
    <?php endif; ?>

    

    


    
    


    


    
    
    

    

    </ul>
    </div>
    <li class="nav-item d-lg-none d-flex align-items-center  justify-content-center position-absolute w-100 se-log-butn" style="bottom:10px;">
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-100 px-2">
            <?php echo csrf_field(); ?>
            <button type="submit" class="nav-link text-white font-weight-bold btn btn-sm btn-secondary px-5 py-2 mt-3 w-100">
                 <i class="fa-solid fa-power-off me-2" style="font-size: 14px !important;"></i>  
                 <!-- <i class="fa fa-sign-out me-2" style="font-size: 14px !important;"></i>   -->
                Logout
                <!-- <span class="d-sm-inline d-none">Sign In</span> -->
            </button>
        </form>
    </li>
</aside><?php /**PATH C:\project\aiman-royale\resources\views/components/admin/sidebar.blade.php ENDPATH**/ ?>