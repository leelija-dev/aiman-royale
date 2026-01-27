{{-- <!-- <link href="../plugins/bootstrap-5.2.0/css/bootstrap.css" rel='stylesheet' type='text/css' /> --> --}}
{{-- <link href="../plugins/fontawesome-6.1.1/css/all.css" rel='stylesheet' type='text/css' /> --}}
@php
$user = auth('admin')->user(); // or auth('admin')->user() if using custom guard

$userId = $user['user_id'];

use App\Models\Admin;
$roles = $user->getRoleNames();

$admin = Admin::find($userId);

$productAndUnit = request()->routeIs('admin.categories.*', 'admin.products.*', 'admin.unit.*', 'admin.brands.*', 'admin.colors.*', 'admin.sizes.*', 'admin.product-variants.*','admin.categories.create') ? true : false;
$isNewsletterActive = false;
$isEmailActive = false;
@endphp



<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main" style="background: white !important;">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="{{route('Admin.dashboard')}}">
            <div class="d-flex align-items-center" style="font-size: 27px;"><strong><span class="text-success">Aiman</span><span class="text-info"> Royale</span></strong>
            </div>
            {{-- <img src="{{ asset('web/images/amarmaa-text.webp') }}" alt="logo" class="pe-md-4"> --}}
            {{-- <img src="{{ asset('images/site-img/logo.png') }}" alt="logo" class="pe-md-4"> --}}
            {{-- <img src="< ?php echo LOGO_WITH_PATH; ?>" alt="logo" class="pe-md-4"> --}}
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav" id="menu-accordion">
            <li class="nav-item ">
                <a class="nav-link {{ request()->routeIs('Admin.dashboard') ? 'active' : '' }}" href="{{ route('Admin.dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- @if ($admin->hasPermissionTo('view services') || $roles[0] == 'superadmin')
                
                @php 
                     // Use your status routes 
                    $isServiceActive = request()->routeIs('admin.show-service', 'admin.add-service-form','admin.single_service','admin.update_service','add_service', 'admin.insert_service', 'edit_service');
                @endphp 
                                        
                <li class="nav-item">
                    <a class="nav-link {{ $isServiceActive ? 'active' : '' }}"
            href="{{ route('admin.show-service') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <span class="nav-link-text ms-1">Service</span>
            </a>
            </li>
            @endif --}}

            {{-- @if ($admin->hasPermissionTo('view page') || $roles[0] == 'superadmin')
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">CMS</h6>
              </li>
            @php
            // Define active states for menu items
            $isPagesActive = request()->routeIs('admin.pages');
            $isFaqsActive = request()->routeIs('faq*');
            $isTestimonialActive = request()->routeIs('testimonial*');

            $isBlogActive = request()->routeIs('admin.blog.*');
            $isBlogPostsActive = request()->routeIs('admin.blog.posts.*');
            $isBlogCategoriesActive = request()->routeIs('admin.blog.categories.*');
            $isBlogTagsActive = request()->routeIs('admin.blog.tags.*');
            @endphp --}}

            {{-- Blog Menu Items --}}
            {{-- @if ($admin->hasPermissionTo('view page') || $roles[0] == 'superadmin')
            <li class="nav-item has-submenu">
                <a class="nav-link submenu-toggle {{ $isBlogActive ? 'active' : '' }}"
            href="#" data-bs-toggle="collapse" data-bs-target="#cms-menu"
            aria-expanded="{{ $isBlogActive ? 'true' : 'false' }}"
            aria-controls="cms-menu">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-table"></i>
            </div>
            <span class="nav-link-text ms-1">Blog</span>
            </a>
            <div id="cms-menu" class="collapse submenu {{ $isBlogActive ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                <ul class="submenu-list list-unstyled">
                    <li class="submenu-item">
                        <a class="submenu-link {{ $isBlogPostsActive ? 'active' : '' }}" href="{{ route('admin.blog.posts.index') }}">
                            Blog Posts
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a class="submenu-link {{ $isBlogCategoriesActive ? 'active' : '' }}" href="{{ route('admin.blog.categories.index') }}">
                            Blog Categories
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a class="submenu-link {{ $isBlogTagsActive ? 'active' : '' }}" href="{{ route('admin.blog.tags.index') }}">
                            Blog Tags
                        </a>
                    </li>
                </ul>
            </div>
            </li>
            @endif --}}
            {{-- End Blog Menu Items --}}


            {{-- Pages Section --}}
            {{-- <li class="nav-item ">
                <a class="nav-link {{ $isPagesActive ? 'active' : '' }}" href="{{ route('admin.pages') }}">
            <div
                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-home" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Pages</span>
            </a>
            </li> --}}
            {{-- End Pages Section --}}

            {{-- Pages Section --}}
            {{-- <li class="nav-item ">
                <a class="nav-link {{ $isFaqsActive ? 'active' : '' }}" href="{{ route('faq.list') }}">
            <div
                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-home" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">FAQs</span>
            </a>
            </li> --}}
            {{-- End Pages Section --}}

            {{-- Pages Section --}}
            {{-- <li class="nav-item ">
                <a class="nav-link {{ $isTestimonialActive ? 'active' : '' }}" href="{{ route('testimonial.list') }}">
            <div
                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-home" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Testimonials</span>
            </a>
            </li> --}}
            {{-- End Pages Section --}}
            {{-- @endif --}}

            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Marketing</h6>
            </li> --}}

            {{-- @if ($admin->hasPermissionTo('view contact') || $roles[0] == 'superadmin')
                
                @php 
                     // Use your status routes 
                   
                    $isContactActive = request()->routeIs('admin.contacts','admin.show-contact', 'admin.update-contact','admin.insert-contact',  'admin.delete-contact');
                @endphp
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle {{ $isContactActive ? 'active' : '' }}"
            href="#" data-bs-toggle="collapse" data-bs-target="#submenu-contact"
            aria-expanded="{{ $isContactActive ? 'true' : 'false' }}"
            aria-controls="submenu-contact">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <span class="nav-link-text ms-1">Lead Management</span>
            </a>
            <div id="submenu-contact" class="collapse submenu {{ $isContactActive ? 'show' : '' }}"
                data-bs-parent="#menu-accordion">
                <ul class="submenu-list list-unstyled">
                    <li class="submenu-item">
                        <a class="submenu-link {{ request()->routeIs('admin.contacts') ? 'active' : '' }}"
                            href="{{ route('admin.contacts') }}">
                            Contact Details
                        </a>
                    </li>

                </ul>
            </div>
            </li>
            @endif --}}

            {{-- @if($admin->hasPermissionTo('view newsletter')|| $roles[0]=='superadmin') --}}
            {{-- @php 
            // $isMarketingActive = str_contains(request()->path(), 'newsletter') || request()->routeIs();
            // $isNewsletterActive=request()->routeIs('admin.news-letter');
            // $isEmailActive=request()->routeIs('admin.email-group');
           
            $isMarketingActive = str_contains(request()->path(), 'marketing-tool') || request()->routeIs('admin.news-letter', 'admin.email-group');
            $isNewsletterActive = request()->routeIs('admin.news-letter');
            $isEmailActive = request()->routeIs('admin.email-group');


            @endphp
                   <li class="nav-item has-submenu">
                <a class="nav-link  submenu-toggle {{$isMarketingActive ? 'active' : ''}}"
            href="#" href="#" data-bs-toggle="collapse" data-bs-target="#marketing-menu"
            aria-expanded="{{$isMarketingActive ? 'true' :'false'}}"
            aria-controls="marketing-menu">
            <div
                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-cart-arrow-down"></i>
            </div>
            <span class="nav-link-text ms-1">Markerting Tools</span>
            </a>
            <div id="marketing-menu"
                class="collapse submenu {{$isMarketingActive ? 'show' : ''}} "
                data-bs-parent="#menu-accordion">
                <ul class="submenu-list list-unstyled">
                    <li class="submenu-item"><a
                            class="submenu-link {{ $isNewsletterActive ? 'active' : '' }} "
                            href="{{route('admin.news-letter')}}">News Letter</a></li> --}}
                    {{-- </ul> --}}
                    {{-- </div> --}}
                    {{-- <div id="marketing-menu"
                    class="collapse submenu marketing-menu {{$isEmailActive ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion"> --}}
                    {{-- <ul class="submenu-list list-unstyled"> --}}
                    {{-- <li class="submenu-item"><a
                                class="submenu-link {{ $isEmailActive ? 'active' : '' }}"
                    href="{{route('admin.email-group')}}">E-mail Group</a></li>
                </ul>
            </div>
            </li> --}}
            {{-- @endif --}}
            {{-- <li class="nav-item ">
                <a class="nav-link {{ request()->routeIs('admin.new-bill') ? 'active' : '' }}" href="{{ route('admin.new-bill') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Generate Bill</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item ">
                <a class="nav-link {{ request()->routeIs('admin.print-bill') ? 'active' : '' }}" href="{{ route('admin.print-bill') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bill History</span>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('stocks.*') ? 'active' : '' }}" href="{{ route('stocks.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span class="nav-link-text ms-1">Stock Management</span>
                </a>
            </li> --}}

            <li class="nav-item has-submenu">
                <a class="nav-link  submenu-toggle {{$productAndUnit ? 'active' : ''}}"
                    href="#" href="#" data-bs-toggle="collapse" data-bs-target="#marketing-menu"
                    aria-expanded="{{$productAndUnit ? 'true' :'false'}}"
                    aria-controls="marketing-menu">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <span class="nav-link-text ms-1">Product & Units</span>
                </a>
                <div id="marketing-menu"
                    class="collapse submenu {{$productAndUnit ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                href="{{ route('admin.products') }}">Products</a>
                        </li>
                    </ul>
                </div>
                <div id="marketing-menu"
                    class="collapse submenu {{$productAndUnit ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} "
                                href="{{ route('admin.categories.index') }}">Categories</a>
                        </li>
                    </ul>
                </div>
                <div id="marketing-menu"
                    class="collapse submenu {{$productAndUnit ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }} "
                                href="{{ route('admin.brands.index') }}">Brands</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.colors.*') ? 'active' : '' }} "
                                href="{{ route('admin.colors') }}">Colors</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }} "
                                href="{{ route('admin.sizes') }}">Sizes</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.product-variants.*','admin.categories.create') ? 'active' : '' }} "
                                href="{{ route('admin.product-variants') }}">Product Variants</a>
                        </li>
                    </ul>
                </div>

                <div id="marketing-menu"
                    class="collapse submenu {{$productAndUnit ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.unit','admin.add-unit','admin.unit.update') ? 'active' : '' }} "
                                href="{{ route('admin.unit') }}">Units</a>
                        </li>
                    </ul>
                </div>
                
                {{-- <div id="marketing-menu"
                    class="collapse submenu {{$productAndUnit ? 'show' : ''}} "
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->routeIs('admin.product-package.*') ? 'active' : '' }} "
                                href="{{ route('admin.product-package.index') }}">Package Units</a>
                        </li>
                    </ul>
                </div> --}}
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('shops.*') ? 'active' : '' }}" href="{{ route('shops.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-store"></i>
                    </div>
                    <span class="nav-link-text ms-1">Shops</span>
                </a>
            </li> --}}

            {{-- <li class="nav-item ">
                <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}" href="{{ route('Admin.dashboard') }}">
            <div
                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Categorie</span>
            </a>
            </li>--}}

            @if ($admin->hasPermissionTo('view reports') || $admin->hasPermissionTo('view roles') || $admin->hasPermissionTo('view page') || $roles[0] == 'superadmin')
            @php
            $isUserManagement = request()->routeIs('admin.roles*','admin.roles.edit-role', 'admin.users*', "admin.permissions*");

            $isRolesActive=request()->routeIs('admin.roles','admin.roles.create','admin.roles.edit-role');
            $isUserActive=request()->routeIs('admin.users*');
            $ispermissionActive = request()->routeIs('admin.permissions', 'admin.create','admin.edit-permission');
            @endphp

            <li class="nav-item has-submenu ">
                <a class="nav-link  submenu-toggle {{$isUserManagement ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#users-items-menu" aria-expanded="{{$isUserManagement ? 'true' : 'false'}}" aria-controls="users-items-menu">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-line"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>

                <div id="users-items-menu" class="collapse submenu users-items-menu {{$isUserManagement ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ $isUserActive ?  'active' : ''}}"
                                href="{{ route('admin.users.show') }}">Users</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--
                @if ($admin->hasPermissionTo('view roles') || $roles[0] == 'superadmin')
                    <div id="users-items-menu" class="collapse submenu users-items-menu {{$isUserManagement ? 'show' : ''}}" data-bs-parent="#menu-accordion">
            <ul class="submenu-list list-unstyled">
                <li class="submenu-item">
                    <a class="submenu-link {{request()->routeIs('admin.roles') ? 'active' : ''}}"
                        href="{{ route('admin.roles') }}">Roles</a>
                </li>
            </ul>
    </div>
    @endif

    @if ($admin->hasPermissionTo('view page') || $roles[0] == 'superadmin' )

    <div id="users-items-menu" class="collapse submenu users-items-menu {{ $isUserManagement ? 'show' : '' }}"
        data-bs-parent="#menu-accordion">
        <ul class="submenu-list list-unstyled">
            <li class="submenu-item">
                <a class="submenu-link {{ request()->routeIs('admin.permissions') ? 'active' : '' }}"
                    href="{{ route('admin.permissions') }}">Permissions</a>
            </li>

        </ul>
    </div>
    @endif
    </li> --}}
    @endif

    {{-- <li class="nav-item has-submenu">
                <a class="nav-link  submenu-toggle"
                    href="#" data-bs-toggle="collapse" data-bs-target="#submenu-2" aria-expanded="" aria-controls="submenu-2">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-line"></i>
                    </div>
                    <span class="nav-link-text ms-1">Employees Section</span>
                </a>
                <div id="submenu-2"
                    class="collapse submenu submenu-2"
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link"
                                href="#">Employees</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link"
                                href="#">Add New Employee</a>
                        </li>
                    </ul>
                </div>
            </li> --}}

    {{-- <li class="nav-item has-submenu">
                <a class="nav-link  submenu-toggle "
                    href="#" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-5"
                    aria-expanded="" aria-controls="submenu-5">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gears"></i>
                    </div>
                    <span class="nav-link-text ms-1">Setup Tools</span>
                </a>
                <div id="submenu-5"
                    class="collapse submenu submenu-5"
                    data-bs-parent="#menu-accordion">
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item"><a
                                class="submenu-link "
                                href="#">Admin Users</a></li>
                        <li class="submenu-item"><a
                                class="submenu-link "
                                href="#">Database Backup</a>
                        </li>
                    </ul>
                </div>
            </li>  --}}


    {{-- Careers Menu --}}
    {{-- @if ($admin->hasPermissionTo('view job') || $roles[0] == 'superadmin')
                @php
                    // Active if the path includes 'career/' prefix or matching direct routes
                    $isCareersActive = str_contains(request()->path(), 'career') || request()->routeIs('show-application','application', 'show-vacancy','editvacancy','showjobvacancy','single-application','jobvacancyform','user_application');
                    $isApplicationActive = request()->routeIs('show-application','application','user_application','single-application');
                    $isVacancyActive = request()->routeIs('showjobvacancy','jobvacancyform','show-vacancy','editvacancy');
                @endphp

                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle {{ $isCareersActive ? 'active' : '' }}"
    href="#" data-bs-toggle="collapse" data-bs-target="#submenu-careers"
    aria-expanded="{{ $isCareersActive ? 'true' : 'false' }}"
    aria-controls="submenu-careers">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="fas fa-cart-arrow-down"></i>
    </div>
    <span class="nav-link-text ms-1">Careers</span>
    </a>
    <div id="submenu-careers" class="collapse submenu {{ $isCareersActive ? 'show' : '' }}"
        data-bs-parent="#menu-accordion">
        <ul class="submenu-list list-unstyled">
            <li class="submenu-item">
                <a class="submenu-link {{ $isApplicationActive ? 'active' : '' }}"
                    href="{{ route('show-application') }}">
                    Applications
                </a>
            </li>
            <li class="submenu-item">
                <a class="submenu-link {{ $isVacancyActive ? 'active' : '' }}"
                    href="{{ route('showjobvacancy') }}">
                    New Vacancy
                </a>
            </li>
        </ul>
    </div>
    </li>
    @endif --}}


    {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
             --}}


    {{-- @if ($admin->hasPermissionTo('view reports') || $admin->hasPermissionTo('view roles') || $admin->hasPermissionTo('view page') || $roles[0] == 'superadmin') --}}
    {{-- @php        
                    $isSetupManagement = request()->routeIs('admin.setup.status*');
                    
                    $isStatusActive = request()->routeIs('admin.setup.status*');
                @endphp

                <li class="nav-item has-submenu ">
                    <a class="nav-link  submenu-toggle {{$isSetupManagement ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#setup-menu" aria-expanded="{{$isSetupManagement ? 'true' : 'false'}}" aria-controls="setup-menu">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
        <i class="fa-solid fa-gears"></i>
    </div>
    <span class="nav-link-text ms-1">Setup Tools</span>
    </a>

    <div id="setup-menu" class="collapse submenu setup-menu {{$isSetupManagement ? 'show' : '' }}" data-bs-parent="#menu-accordion">
        <ul class="submenu-list list-unstyled">
            <li class="submenu-item">
                <a class="submenu-link {{ request()->routeIs('admin.setup.status.show') ? 'active' : '' }}"
                    href="{{ route('admin.setup.status.show') }}">Set Status</a>
            </li>
        </ul>
    </div>

    <div id="setup-menu" class="collapse submenu setup-menu {{$isSetupManagement ? 'show' : ''}}" data-bs-parent="#menu-accordion">
        <ul class="submenu-list list-unstyled">
            <li class="submenu-item">
                <a class="submenu-link {{request()->routeIs('admin.roles') ? 'active' : ''}}"
                    href="#">Admin Users</a>
            </li>
        </ul>
    </div>


    <div id="setup-menu" class="collapse submenu setup-menu {{ $isSetupManagement ? 'show' : '' }}"
        data-bs-parent="#menu-accordion">
        <ul class="submenu-list list-unstyled">
            <li class="submenu-item">
                <a class="submenu-link {{ request()->routeIs('admin.permissions') ? 'active' : '' }}"
                    href="{{ route('backup.index') }}">Database Backup</a>
            </li>

        </ul>
    </div>
    </li> --}}
    {{-- @endif --}}

    

    </ul>
    </div>
    <li class="nav-item d-lg-none d-flex align-items-center  justify-content-center position-absolute w-100 se-log-butn" style="bottom:10px;">
        <form method="POST" action="{{ route('logout') }}" class="w-100 px-2">
            @csrf
            <button type="submit" class="nav-link text-white font-weight-bold btn btn-sm btn-secondary px-5 py-2 mt-3 w-100">
                 <i class="fa-solid fa-power-off me-2" style="font-size: 14px !important;"></i>  
                 <!-- <i class="fa fa-sign-out me-2" style="font-size: 14px !important;"></i>   -->
                Logout
                <!-- <span class="d-sm-inline d-none">Sign In</span> -->
            </button>
        </form>
    </li>
</aside>