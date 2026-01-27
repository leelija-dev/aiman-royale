<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminKeywordController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\Admin\ContactController;
use App\Models\Job;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewApplicationController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\admin\NotificationController;
use App\Http\Controllers\Admin\NewsLetterController;
// use App\Http\Controllers\Admin\ProductPackageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OccasionController as AdminOccasionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockController;

use App\Http\Controllers\Admin\ServicesController;
use App\Models\NewsLetter;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\PrintBillController;
// use App\Http\Controllers\ShopController;


Route::middleware(['web'])->prefix('admin')->group(function () {
    Route::view('/login', 'Admin.login')->name('login')->middleware(['guest.admin','prevent.back.history']);
    //Route::get('/login', [AuthController::class, 'showLoginForm'])->name('Admin.showLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('Admin.login')->middleware('guest.admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:admin');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('Admin.showform');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register');



    Route::get('/dashboard', [HomeController::class, 'home'])->name('Admin.dashboard')->middleware('auth:admin');
    Route::get('/dashboard/data', [HomeController::class, 'getDashboardData'])->name('admin.dashboard.data')->middleware('auth:admin');
    Route::fallback(function () { abort(404); });

        // Product Categories

        Route::middleware(['auth:admin'])->group(function () {
        Route::resource('product-categories', 'App\Http\Controllers\Admin\CategoryController', [
            'parameters' => ['product-categories' => 'category:id'],
            'names' => [
                'index' => 'admin.categories.index',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.destroy'
            ]
        ])->except(['show']);

        // Trash routes
        Route::get('product-categories/trash', 'App\Http\Controllers\Admin\CategoryController@trash')
            ->name('admin.categories.trash');

        Route::put('product-categories/{category}/restore', 'App\Http\Controllers\Admin\CategoryController@restore')
            ->name('admin.categories.restore');

        Route::delete('product-categories/{category}/force-delete', 'App\Http\Controllers\Admin\CategoryController@forceDelete')
            ->name('admin.categories.force-delete');

        Route::post('product-categories/updateStatus', 'App\Http\Controllers\Admin\CategoryController@updateStatus')
            ->name('admin.categories.updateStatus');

        // Occasions
        Route::resource('occasions', AdminOccasionController::class, [
            'parameters' => ['occasions' => 'occasion:id'],
            'names' => [
                'index' => 'admin.occasions.index',
                'create' => 'admin.occasions.create',
                'store' => 'admin.occasions.store',
                'edit' => 'admin.occasions.edit',
                'update' => 'admin.occasions.update',
                'destroy' => 'admin.occasions.destroy'
            ]
        ])->except(['show']);
        //   Route::get('occasions', [AdminOccasionController::class, 'index'])
        //     ->name('admin.occasions.index');

        // Occasion Trash routes
        Route::get('occasions/trash', [AdminOccasionController::class, 'trash'])
            ->name('admin.occasions.trash');

        Route::put('occasions/{occasion}/restore', [AdminOccasionController::class, 'restore'])
            ->name('admin.occasions.restore');

        Route::delete('occasions/{occasion}/force-delete', [AdminOccasionController::class, 'forceDelete'])
            ->name('admin.occasions.force-delete');

        // Colors
        Route::resource('colors', ColorController::class, [
            'names' => [
                'index' => 'admin.colors',
                'create' => 'admin.colors.create',
                'store' => 'admin.colors.store',
                'edit' => 'admin.colors.edit',
                'update' => 'admin.colors.update',
                'destroy' => 'admin.colors.delete'
            ]
        ])->except(['show']);

        // Sizes
        Route::resource('sizes', SizeController::class, [
            'names' => [
                'index' => 'admin.sizes',
                'create' => 'admin.sizes.create',
                'store' => 'admin.sizes.store',
                'edit' => 'admin.sizes.edit',
                'update' => 'admin.sizes.update',
                'destroy' => 'admin.sizes.delete'
            ]
        ])->except(['show']);

        // Product Variants
        Route::resource('product-variants', ProductVariantController::class, [
            'names' => [
                'index' => 'admin.product-variants',
                'create' => 'admin.product-variants.create',
                'store' => 'admin.product-variants.store',
                'edit' => 'admin.product-variants.edit',
                'update' => 'admin.product-variants.update',
                'destroy' => 'admin.product-variants.destroy'
            ]
        ])->except(['show']);

        // Stock Update
        Route::post('/stock/update', [StockController::class, 'updateVariantStock'])->name('admin.stock.update');

        // Products
        Route::resource('products', AdminProductController::class, [
            'parameters' => ['products' => 'product:id'],
            'names' => [
                'index' => 'admin.products',
                'create' => 'admin.products.create',
                'store' => 'admin.products.store',
                'edit' => 'admin.products.edit',
                'update' => 'admin.products.update'
            ]
        ])->except(['show', 'destroy']);

        // Custom delete route to use delete method
        Route::delete('products/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');

        // Product Trashed Routes
        Route::get('products/trashed', [AdminProductController::class, 'trashed'])->name('admin.products-trashed');
        Route::patch('products/{id}/restore', [AdminProductController::class, 'restore'])->name('admin.products.restore');
        Route::delete('products/{id}/force-delete', [AdminProductController::class, 'permanentlyDelete'])->name('admin.products.force-delete');

        // Backward compatibility route alias
        Route::get('add-product', [AdminProductController::class, 'create'])->name('admin.add-product');

        // ProductPackage routes (commented out - controller doesn't exist)
        // Route::get('/product-package/trashed',[ProductPackageController::class,'trashed'])->name('admin.product-package.trashed');
        // Route::patch('/trashed-product-package/{id}/restore',[ProductPackageController::class,'restore'])->name('admin.product-package.restore');
        // Route::delete('/trashed-product-package/{id}/force-delete',[ProductPackageController::class,'permanentlyDelete'])->name('admin.product-package.force-delete');


        Route::prefix('permissions')->group(function () {

        Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions');
        Route::get('/create/', [PermissionController::class, 'create'])->name('admin.create');
        Route::post('/create/', [PermissionController::class, 'store'])->name('admin.store');
        Route::get('/edit-permission/{id}', [PermissionController::class, 'edit'])->name('admin.edit-permission');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('/delete-permission/{id}', [PermissionController::class, 'delete'])->name('admin.delete-permission');
    });

    Route::prefix('roles')->group(function () {

        Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
        Route::get('/create/', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/create/', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/edit-role/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit-role');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/delete-role/{id}', [RoleController::class, 'delete'])->name('admin.delete-role');
    });


    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('admin.users.show');
        Route::get('/create/', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/create/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/edit-user/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
        Route::get('/change-password/{id}', [UserController::class, 'editPassword'])->name('admin.users.edit-password');
        Route::post('/update-password/{id}', [UserController::class, 'updatePassword'])->name('admin.users.update-password');

    });


    Route::prefix('unit')->group(function () {
        Route::get('/',[UnitController::class,'index'])->name('admin.unit');
        Route::get('/add-unit',[UnitController::class,'create'])->name('admin.add-unit');
        Route::post('/add-unit',[UnitController::class,'store'])->name('admin.unit.store');
        Route::delete('/unit/{id}', [UnitController::class, 'delete'])->name('unit.delete');
        Route::get('/update-unit/{id}',[UnitController::class,'update'])->name('admin.unit.update');
        Route::post('/edit-unit/{id}',[UnitController::class,'edit'])->name('admin.unit.edit');
    });
    // Brand Routes
    Route::prefix('brands')->group(function () {
        Route::get('/', [AdminBrandController::class, 'index'])->name('admin.brands.index');
        Route::get('/create', [AdminBrandController::class, 'create'])->name('admin.brands.create');
        Route::post('/', [AdminBrandController::class, 'store'])->name('admin.brands.store');
        Route::get('/{brand}', [AdminBrandController::class, 'show'])->name('admin.brands.show');
        Route::get('/{brand}/edit', [AdminBrandController::class, 'edit'])->name('admin.brands.edit');
        Route::put('/{brand}', [AdminBrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('/{brand}', [AdminBrandController::class, 'destroy'])->name('admin.brands.destroy');

        // Trash related routes
        Route::get('/trashed/list', [AdminBrandController::class, 'trashed'])->name('admin.brands.trashed');
        Route::patch('/trashed/{id}/restore', [AdminBrandController::class, 'restore'])->name('admin.brands.restore');
        Route::delete('/trashed/{id}/force-delete', [AdminBrandController::class, 'forceDelete'])->name('admin.brands.force-delete');

        // AJAX route for slug generation
        Route::post('/generate-slug', function (\Illuminate\Http\Request $request) {
            $slug = \Illuminate\Support\Str::slug($request->name);
            return response()->json(['slug' => $slug]);
        })->name('admin.brands.generate-slug');
    });


    // Bill Routes
    Route::get('/new-bill', [BillController::class, 'index'])->name('admin.new-bill')->middleware('auth:admin');
    Route::post('/bill/save', [BillController::class, 'store'])->name('admin.bill.save')->middleware('auth:admin');

    // Print Bill Routes
    Route::prefix('print-bill')->group(function() {
        Route::get('/', [\App\Http\Controllers\Admin\PrintBillController::class, 'index'])->name('admin.print-bill');
        Route::get('/{id}', [\App\Http\Controllers\Admin\PrintBillController::class, 'getInvoice'])->name('admin.print-bill.get');
    });
    // ProductPackage routes (commented out - controller doesn't exist)
    // Route::prefix('product-package')->group(function(){
    //     Route::get('/',[ProductPackageController::class,'index'])->name('admin.product-package.index');
    //     Route::get('/create',[ProductPackageController::class,'create'])->name('admin.product-package.create');
    //     Route::post('/create',[ProductPackageController::class,'store'])->name('admin.product-package.store');
    //     Route::get('/edit/{id}',[ProductPackageController::class,'edit'])->name('admin.product-package.edit');
    //     Route::post('/update/{id}',[ProductPackageController::class,'update'])->name('admin.product-package.update');
    //     Route::delete('/{id}', [ProductPackageController::class, 'delete'])->name('admin.product-package.delete');
    // });


    // Shop Routes (commented out - controller doesn't exist)
    /*
    Route::prefix('shops')->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('shops.index');
        Route::get('/create', [ShopController::class, 'create'])->name('shops.create');
        Route::post('/', [ShopController::class, 'store'])->name('shops.store');
        Route::get('/{shop}', [ShopController::class, 'show'])->name('shops.show');
        Route::get('/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
        Route::put('/{shop}', [ShopController::class, 'update'])->name('shops.update');
        Route::put('/{shop}/update-due-amount', [ShopController::class, 'updateDueAmount'])->name('shops.update-due-amount');
        Route::delete('/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');
       //trashed shop
        Route::get('/trashed/shops', [ShopController::class, 'trashed'])->name('shops.trashed');
        Route::patch('/trashed/{id}/restore', [ShopController::class, 'restore'])->name('shops.restore');
        Route::delete('/trashed/{id}/force-delete', [ShopController::class, 'deletePermanently'])->name('shops.force-delete');
    });
    */

    // Stock Management Routes
    Route::prefix('stocks')->name('stocks.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/', [StockController::class, 'store'])->name('store');
        Route::get('/{stock}/edit', [StockController::class, 'edit'])->name('edit');
        Route::put('/{stock}', [StockController::class, 'update'])->name('update');
        Route::delete('/{stock}', [StockController::class, 'destroy'])->name('destroy');

        // Stock operations
        Route::post('/{stock}/add-stock', [StockController::class, 'addStock'])->name('add-stock');
        Route::post('/{stock}/deduct-stock', [StockController::class, 'deductStock'])->name('deduct-stock');
    });


     // Route::middleware(['auth:admin'])->prefix('cms')->group(function () {

    //     Route::get('/pages', [ContentController::class, 'index'])->name('admin.pages');
    //     Route::get('/add-page', [ContentController::class, 'showCreateForm'])->name('admin.page.add');
    //     Route::post('/add-page', [ContentController::class, 'create'])->name('admin.page.store');
    //     Route::get('/edit-page/{id}', [ContentController::class, 'showEditForm'])->name('admin.page.edit-page');
    //     Route::post('/edit-page/{id}', [ContentController::class, 'edit'])->name('admin.page.update');
    //     Route::delete('/delete-page/{id}', [ContentController::class, 'delete'])->name('admin.page.delete-page');
    //     Route::delete('/delete-component/{id}', [ContentController::class, 'componentDelete'])->name('admin.page.delete-component');

        // Route::prefix('faqs')->group(function () {
        //     Route::get('/', [FaqsController::class, 'index'])->name('faq.list');
        //     Route::get('create', [FaqsController::class, 'showFAQs'])->name('faq.add');
        //     Route::post('add', [FaqsController::class, 'addFAQs'])->name('faq.store');
        //     Route::get('page-wise-question/{page_id}', [FaqsController::class, 'pagewiseQuestions'])->name('faq.all-question');
        //     Route::get('question-answer/{id}', [FaqsController::class, 'show'])->name('faq.question-answer');
        //     Route::post('edit/{id}', [FaqsController::class, 'editQuestion'])->name('faq.edit');
        //     Route::post('delete/{id}', [FaqsController::class, 'deleteQuestion'])->name('faq.delete-question');
        // });

        // Route::prefix('testimonial')->group(function () {
        //     Route::get('/',[TestimonialController::class,'index'])->name('testimonial.list');
        //     Route::get('add-testimonial',[TestimonialController::class,'addTestimonial'])->name('testimonial.add');
        //     Route::post('create-testimonial',[TestimonialController::class,'saveTestimonial'])->name('testimonial.store');
        //     Route::get('single-page/{name}',[TestimonialController::class,'singlePage'])->name('testimonial.single');
        //     Route::get('view-page/{id}',[TestimonialController::class,'viewPage'])->name('testimonial.show');
        //     Route::post('edit-page/{id}',[TestimonialController::class,'editPage'])->name('testimonial.edit');
        // });

        // Blog CMS
        // Route::prefix('blog')->name('admin.blog.')->group(function () {
        //     // Posts
        //     Route::get('posts', [AdminPostController::class, 'index'])->name('posts.index');
        //     Route::get('posts/create', [AdminPostController::class, 'create'])->name('posts.create');
        //     Route::post('posts', [AdminPostController::class, 'store'])->name('posts.store');
        //     Route::get('posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
        //     Route::put('posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
        //     Route::delete('posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
        // });


        // Tags
        //     Route::get('tags', [AdminTagController::class, 'index'])->name('tags.index');
        //     Route::get('tags/create', [AdminTagController::class, 'create'])->name('tags.create');
        //     Route::post('tags', [AdminTagController::class, 'store'])->name('tags.store');
        //     Route::get('tags/{tag}/edit', [AdminTagController::class, 'edit'])->name('tags.edit');
        //     Route::put('tags/{tag}', [AdminTagController::class, 'update'])->name('tags.update');
        //     Route::delete('tags/{tag}', [AdminTagController::class, 'destroy'])->name('tags.destroy');
        //     Route::post('tags/stores', [AdminTagController::class, 'searchStore'])->name('tags.stores');

        //     // Keywords
        //     Route::prefix('keywords')->name('keywords.')->group(function () {
        //         Route::match(['get', 'post'], 'search', [AdminKeywordController::class, 'search'])->name('search');
        //         Route::post('store', [AdminKeywordController::class, 'searchStore'])->name('store');
        //     });
        // });
    // });

    // Route::middleware(['auth:admin'])->prefix('career')->group(function () {

    //     Route::get('/vacancies', [CareerController::class, 'index'])->name('admin.vacancies');
    //     Route::get('/add-vacancy', [CareerController::class, 'showCreateForm'])->name('admin.add-vacancy');
    //     Route::get('/edit-vacancy/{id}', [CareerController::class, 'showCreateForm'])->name('admin.edit-vacancy');
    //     Route::get('/delete-vacancy/{id}', [CareerController::class, 'showCreateForm'])->name('admin.delete-vacancy');

    //     Route::post('/applications', [CareerController::class, 'create'])->name('admin.applications');
    //     Route::get('/application/{id}', [CareerController::class, 'showEditForm'])->name('admin.application');
    // });
    // Route::middleware(['auth:admin'])->prefix('job')->group(function () {

    //     Route::get('jobvacancyform', [JobVacancyController::class, 'showInsertForm'])->name('jobvacancyform');
    //     Route::post('job', [JobVacancyController::class, 'JobVacancyFun'])->name('admin.job');
    //     Route::get('showjobvacancy', [JobVacancyController::class, 'ShowJobVacancy'])->name('showjobvacancy');
    //     Route::get('deletevacancy/{id}', [JobVacancyController::class, 'deleteVacancy'])->name('deletevacancy');
    //     Route::post('updatevacancy/{id}', [JobVacancyController::class, 'updateVacancy'])->name('updatevacancy');
    //     Route::get('editvacancy/{id}', [JobVacancyController::class, 'editVacancy'])->name('editvacancy');
    //     Route::get('show-vacancy/{id}', [JobVacancyController::class, 'ShowVacancy'])->name('show-vacancy');
    // });
    //Route::get('show/{id}',[JobVacancyController::class,'ShowJob'])->name('show');
    // Route::get('jobvacancyform', [JobVacancyController::class, 'showInsertForm'])->name('jobvacancyform');
    // Route::post('job', [JobVacancyController::class, 'JobVacancyfun'])->name('job');


    // Route::get('application', [NewApplicationController::class, 'newApplication'])->name('application');
    // Route::post('user_application', [NewApplicationController::class, 'addNewApplication'])->name('user_application');
    // Route::get('show-application', [NewApplicationController::class, 'ShowApplication'])->name('show-application');
    // Route::get('deleteapplication/{id}', [NewApplicationController::class, 'deleteApplication'])->name('deleteapplication');
    // Route::get('single-application/{id}', [NewApplicationController::class, 'singleApplication'])->name('single-application');

    // Route::middleware(['auth:admin'])->prefix('contacts')->group(function () {

    //     Route::get('/', [ContactController::class, 'index'])->name('admin.contacts');
    //     Route::get('/sendmail/{id}', [ContactController::class, 'mail'])->name('admin.sendmail');
    //     Route::post('/sendmail/{id}', [ContactController::class, 'Sendmail'])->name('admin.sendmail.send');
    //     // Route::post('/insert-contact', [ContactController::class, 'insertContact'])->name('admin.insert-contact');
    //     //  Route::get('contact', [ContactController::class, 'showForm'])->name('admin.contact');
    //     Route::get('single-contact/{id}', [ContactController::class, 'showContact'])->name('admin.show-contact');
    //     Route::get('edit-contact/{id}', [ContactController::class, 'editContact'])->name('admin.edit-contact');
    //     Route::post('update-contact/{id}', [ContactController::class, 'updateStatus'])->name('admin.update-contact');
    //     Route::post('reply-contact/{id}', [ContactController::class, 'Reply'])->name('admin.reply-contact');
    //     Route::post('delete-contact/{id}', [ContactController::class, 'deleteContact'])->name('admin.delete-contact');
    // });




});
});
