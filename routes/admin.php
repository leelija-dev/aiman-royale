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
use App\Http\Controllers\Admin\CategoryOccasionContentController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OccasionController as AdminOccasionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\FalseReviewsController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PickupRequestController;
use App\Http\Controllers\Admin\DelhiveryController;
use App\Http\Controllers\Admin\ShippingLabelController;
use App\Http\Controllers\Admin\ReturnOrder;
// use App\Http\Controllers\Admin\OrderController;


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
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\CustomDimensionController;
use App\Http\Controllers\Admin\BannerDetailsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreController;

// use App\Http\Controllers\ShopController;


Route::middleware(['web'])->prefix('admin')->group(function () {  //middleware(['web'])->
    Route::view('/login', 'Admin.login')->name('login')->middleware(['guest.admin', 'prevent.back.history']);
    //Route::get('/login', [AuthController::class, 'showLoginForm'])->name('Admin.showLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('Admin.login')->middleware('guest.admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:admin');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('Admin.showform');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register');



    Route::get('/dashboard', [HomeController::class, 'home'])->name('admin.dashboard')->middleware('auth:admin');
    Route::get('/dashboard/data', [HomeController::class, 'getDashboardData'])->name('admin.dashboard.data')->middleware('auth:admin');
    Route::fallback(function () {
        abort(404);
    });

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

        // Banners
        Route::resource('banners', BannerController::class, [
            'names' => [
                'index' => 'banners.index',
                'create' => 'banners.create',
                'store' => 'banners.store',
                'edit' => 'banners.edit',
                'update' => 'banners.update',
                'destroy' => 'banners.destroy'
            ]
        ])->except(['show']);

        Route::resource('faq-categories', FaqCategoryController::class, [
            'names' => [
                'index' => 'faqCategory.index',
                'create' => 'faqCategory.create',
                'store' => 'faqCategory.store',
                'edit' => 'faqCategory.edit',
                'update' => 'faqCategory.update',
                'destroy' => 'faqCategory.destroy'
            ]
        ])->except(['show']);

        Route::resource('faqs', FaqController::class, [
            'names' => [
                'index' => 'faqs.index',
                'create' => 'faqs.create',
                'store' => 'faqs.store',
                'edit' => 'faqs.edit',
                'update' => 'faqs.update',
                'destroy' => 'faqs.destroy'
            ]
        ])->except(['show']);

        // Sales
        Route::resource('sales', SaleController::class, [
            'names' => [
                'index' => 'admin.sales.index',
                'create' => 'admin.sales.create',
                'store' => 'admin.sales.store',
                'edit' => 'admin.sales.edit',
                'update' => 'admin.sales.update',
                'destroy' => 'admin.sales.destroy'
            ]
        ])->except(['show']);

        Route::post('sales/{sale}/toggle-status', [SaleController::class, 'toggleStatus'])
            ->name('admin.sales.toggle-status');

        Route::get('products/{productId}/variants', [SaleController::class, 'getProductVariants'])
            ->name('admin.products.variants');

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

        // Category Occasion Content
        Route::resource('category-occasion-content', CategoryOccasionContentController::class, [
            'names' => [
                'index' => 'admin.category-occasion-content.index',
                'create' => 'admin.category-occasion-content.create',
                'store' => 'admin.category-occasion-content.store',
                'show' => 'admin.category-occasion-content.show',
                'edit' => 'admin.category-occasion-content.edit',
                'update' => 'admin.category-occasion-content.update',
                'destroy' => 'admin.category-occasion-content.destroy',
            ]
        ]);

        // Category Occasion Content AJAX
        Route::get('category-occasion-content/get', [CategoryOccasionContentController::class, 'getContent'])
            ->name('admin.category-occasion-content.get');

        // Colors
        Route::resource('colors', ColorController::class, [
            'names' => [
                'index' => 'admin.colors.index',
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
                'index' => 'admin.sizes.index',
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

        // Product Parts API
        Route::get('products/{productId}/parts', [AdminProductController::class, 'getParts'])->name('admin.products.parts');

        // Custom delete route to use delete method
        Route::delete('products/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');

        // Product Trashed Routes
        Route::get('products/trashed', [AdminProductController::class, 'trashed'])->name('admin.products-trashed');
        Route::patch('products/{id}/restore', [AdminProductController::class, 'restore'])->name('admin.products.restore');
        Route::delete('products/{id}/force-delete', [AdminProductController::class, 'permanentlyDelete'])->name('admin.products.trashed');

        // Backward compatibility route alias
        Route::get('add-product', [AdminProductController::class, 'create'])->name('admin.add-product');


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

        Route::prefix('false-reviews')->group(function () {
            Route::get('/', [FalseReviewsController::class, 'index'])->name('reviews.index');
            Route::get('/create', [FalseReviewsController::class, 'create'])->name('reviews.create');
            Route::post('/create', [FalseReviewsController::class, 'store'])->name('reviews.store');
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
        Route::prefix('customers')->group(function () {

            Route::get('/', [UserController::class, 'customer'])->name('admin.customers.show');
        });


        Route::prefix('unit')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('admin.unit');
            Route::get('/add-unit', [UnitController::class, 'create'])->name('admin.add-unit');
            Route::post('/add-unit', [UnitController::class, 'store'])->name('admin.unit.store');
            Route::delete('/unit/{id}', [UnitController::class, 'delete'])->name('unit.delete');
            Route::get('/update-unit/{id}', [UnitController::class, 'update'])->name('admin.unit.update');
            Route::post('/edit-unit/{id}', [UnitController::class, 'edit'])->name('admin.unit.edit');
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

        Route::middleware(['auth:admin'])->prefix('contacts')->group(function () {

            Route::get('/', [ContactController::class, 'index'])->name('admin.contact');
            Route::get('/{id}', [ContactController::class, 'show'])->name('admin.contact.show');
        });


        // Bill Routes
        Route::get('/new-bill', [BillController::class, 'index'])->name('admin.new-bill')->middleware('auth:admin');
        Route::post('/bill/save', [BillController::class, 'store'])->name('admin.bill.save')->middleware('auth:admin');

        // Print Bill Routes
        Route::prefix('print-bill')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PrintBillController::class, 'index'])->name('admin.print-bill');
            Route::get('/{id}', [\App\Http\Controllers\Admin\PrintBillController::class, 'getInvoice'])->name('admin.print-bill.get');
        });

        Route::get('/newsletter', [NewsLetterController::class, 'ShowNewsLetter'])->name('admin.newsletter.index')->middleware('auth:admin');


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





        // routes/admin.php
        Route::prefix('seo')->group(function () {
            Route::get('/', [PageSeoController::class, 'index'])->name('seo.pages.index');
        });

        // Bill Routes
        Route::get('/new-bill', [BillController::class, 'index'])->name('admin.new-bill')->middleware('auth:admin');
        Route::post('/bill/save', [BillController::class, 'store'])->name('admin.bill.save')->middleware('auth:admin');

        // Print Bill Routes
        Route::prefix('print-bill')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PrintBillController::class, 'index'])->name('admin.print-bill');
            Route::get('/{id}', [\App\Http\Controllers\Admin\PrintBillController::class, 'getInvoice'])->name('admin.print-bill.get');
        });

        Route::get('/newsletter', [NewsLetterController::class, 'ShowNewsLetter'])->name('admin.newsletter.index')->middleware('auth:admin');




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

        // routes/web.php


        // Delhivery Packing Slip Routes
        Route::prefix('admin/delhivery')->group(function () {
            // Generate packing slip (JSON response)
            Route::get('/packing-slip/{waybill}', [DelhiveryController::class, 'generatePackingSlip'])
                ->name('delhivery.packing-slip');

            // Generate packing slip with PDF option
            Route::get('/packing-slip/{waybill}/pdf', [DelhiveryController::class, 'generatePackingSlip'])
                ->name('delhivery.packing-slip.pdf')
                ->defaults('pdf', true);

            // Download packing slip as PDF
            Route::get('/packing-slip/{waybill}/download', [DelhiveryController::class, 'downloadPackingSlip'])
                ->name('delhivery.packing-slip.download');

            // View packing slip in browser
            Route::get('/packing-slip/{waybill}/view', [DelhiveryController::class, 'viewPackingSlip'])
                ->name('delhivery.packing-slip.view');

            // Print packing slip
            Route::get('/packing-slip/{waybill}/print', [DelhiveryController::class, 'printPackingSlip'])
                ->name('delhivery.packing-slip.print');

            // Bulk generate packing slips
            Route::post('/packing-slip/bulk', [DelhiveryController::class, 'generateBulkPackingSlips'])
                ->name('delhivery.packing-slip.bulk');
        });

        // Custom Dimensions Management Routes
        Route::get('/custom-dimensions', [CustomDimensionController::class, 'index'])->name('admin.custom-dimensions.index');
        Route::post('/custom-dimensions/{id}/status', [CustomDimensionController::class, 'updateStatus'])->name('admin.custom-dimensions.update-status');
        Route::post('/custom-dimensions/{id}/price', [CustomDimensionController::class, 'updatePrice'])->name('admin.custom-dimensions.update-price');

        // SEO Management Routes
        Route::prefix('seo')->group(function () {
            Route::get('/', [PageSeoController::class, 'index'])->name('seo.pages.index');
            Route::get('/create', [PageSeoController::class, 'create'])->name('seo.pages.create');
            Route::post('/', [PageSeoController::class, 'store'])->name('seo.pages.store');
            Route::get('{slug}/edit', [PageSeoController::class, 'edit'])->name('seo.pages.edit');
            Route::put('{slug}', [PageSeoController::class, 'update'])->name('seo.pages.update');
            Route::delete('{id}', [PageSeoController::class, 'destroy'])->name('seo.pages.destroy');
        });

        // False Reviews Management Routes
        Route::resource('reviews', FalseReviewsController::class, [
            'names' => [
                'index' => 'admin.reviews.index',
                'create' => 'admin.reviews.create',
                'store' => 'admin.reviews.store',
                'show' => 'admin.reviews.show',
                'edit' => 'admin.reviews.edit',
                'update' => 'admin.reviews.update',
                'destroy' => 'admin.reviews.destroy'
            ]
        ]);

        Route::post('reviews/bulk-action', [FalseReviewsController::class, 'bulkAction'])->name('reviews.bulk-action');
        Route::post('reviews/{review}/toggle-status', [FalseReviewsController::class, 'toggleStatus'])->name('reviews.toggle-status');
        Route::post('reviews/{review}/toggle-featured', [FalseReviewsController::class, 'toggleFeatured'])->name('reviews.toggle-featured');
        Route::post('reviews/{review}/toggle-verified', [FalseReviewsController::class, 'toggleVerified'])->name('reviews.toggle-verified');

        // Orders Management Routes
        Route::resource('orders', OrderManagementController::class, [
            'names' => [
                'index' => 'admin.orders.index',
                'create' => 'admin.orders.create',
                'store' => 'admin.orders.store',
                'show' => 'admin.orders.show',
                'destroy' => 'admin.orders.destroy'
            ]
        ]);

        Route::post('orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::post('orders/{order}/tracking', [OrderManagementController::class, 'updateTracking'])->name('admin.orders.update-tracking');
        Route::post('orders/bulk-update', [OrderManagementController::class, 'bulkUpdateStatus'])->name('admin.orders.bulk-update');
        Route::get('orders/stats', [OrderManagementController::class, 'getStats'])->name('admin.orders.stats');


        Route::get('pickup', [PickupRequestController::class, 'index'])->name('pickup.index');
        Route::post('/pickup/create', [PickupRequestController::class, 'createPickupRequest'])->name('pickup.create');
        // Route::get('/pickup', [PickupRequestController::class, 'index'])->name('pickup.index');
        Route::get('/pickup/requested', [PickupRequestController::class, 'requestedPickup'])->name('pickup.requested');
        Route::get(
            '/admin/orders/{order}/shipping-label',
            [PickupRequestController::class, 'generateShippingLabel']
        )
            ->name('admin.orders.shipping-label');
    });

    // Shipping Label Routes
    Route::get('/shipping-label', [ShippingLabelController::class, 'index'])->name('shipping-label.index');
    Route::get('/shipping-label/generate', [ShippingLabelController::class, 'generateLabel'])->name('shipping-label.generate');
    Route::get('/shipping-label/bulk', [ShippingLabelController::class, 'generateBulkLabels'])->name('shipping-label.bulk');
    Route::get('/shipping-label/download', [ShippingLabelController::class, 'downloadPdf'])->name('shipping-label.download');
    Route::get('/shipping-label/preview', [ShippingLabelController::class, 'previewLabel'])->name('shipping-label.preview');
    Route::get('/shipping-label/debug', [ShippingLabelController::class, 'debugApi'])->name('shipping-label.debug');
    Route::get('/shipping-label/direct/{waybill}', [ShippingLabelController::class, 'getPdfDirect'])->name('shipping-label.direct');

    Route::prefix('return-orders')->group(function () {
        // List all return orders
        Route::get('/', [ReturnOrder::class, 'index'])->name('return-orders.index');

        // Create return request
        Route::post('/create', [ReturnOrder::class, 'create'])->name('return-orders.create');

        // Process refund
        Route::post('/refund', [ReturnOrder::class, 'refund'])->name('return-orders.refund');

        // Process bulk refund
        Route::post('/bulk-refund', [ReturnOrder::class, 'bulkRefund'])->name('return-orders.bulk-refund');

        // Get return details
        Route::get('/details', [ReturnOrder::class, 'details'])->name('return-orders.details');

        // Update return status (webhook)
        Route::post('/webhook', [ReturnOrder::class, 'webhook'])->name('return-orders.webhook');
    });
    //Hero Section
    Route::prefix('hero-section')->group(function () {
        Route::get('/', [BannerDetailsController::class, 'index'])->name('hero-section.index');
        Route::get('/create', [BannerDetailsController::class, 'create'])->name('hero-section.create');
        Route::post('/store', [BannerDetailsController::class, 'store'])->name('hero-section.store');
        Route::get('/edit/{id}', [BannerDetailsController::class, 'edit'])->name('hero-section.edit');
        Route::post('/update/{id}', [BannerDetailsController::class, 'update'])->name('hero-section.update');
        Route::delete('/delete/{id}', [BannerDetailsController::class, 'delete'])->name('hero-section.delete');
    });

    Route::prefix('store')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('store.index');
        Route::get('/create', [StoreController::class, 'create'])->name('store.create');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store');
        Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('store.edit');
        Route::post('/update/{id}', [StoreController::class, 'update'])->name('store.update');
        Route::delete('/delete/{id}', [StoreController::class, 'delete'])->name('store.delete');
    });
    Route::prefix('coupon')->group(function (){
        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::post('/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('/delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete');
    });

    Route::prefix('offer')->group(function (){
        Route::get('/',[OfferController::class,'index'])->name('offer.index');
        Route::get('/create', [OfferController::class, 'create'])->name('offer.create');
        Route::post('/store', [OfferController::class, 'store'])->name('offer.store');
        Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
        Route::post('/update/{id}', [OfferController::class, 'update'])->name('offer.update');
        Route::delete('/delete/{id}', [OfferController::class, 'delete'])->name('offer.delete');
    });

   // Invoice Routes
Route::get('/orders/{order}/invoice', [OrderManagementController::class, 'viewInvoice'])->name('admin.orders.invoice');
Route::get('/orders/{order}/invoice/download', [OrderManagementController::class, 'downloadInvoice'])->name('admin.orders.invoice.download');
});
