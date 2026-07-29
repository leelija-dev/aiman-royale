<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ReturnOrderController;
use App\Http\Controllers\Api\WebhookController;


// Brand related API routes
// Route::post('/generate-slug', [BrandController::class, 'generateSlug'])->name('api.generate-slug');

// Category related API routes
Route::prefix('categories')->group(function () {
    Route::get('/{categoryId}', [CategoryController::class, 'getChildCategories'])->name('api.categories.children');
    Route::get('/{categoryId}/occasions', [CategoryController::class, 'getOccassionByCategoryId'])->name('api.categories.occasions');
    Route::get('/all-with-children', [CategoryController::class, 'getAllCategoriesWithChildren'])->name('api.categories.all-with-children');
    Route::get('/{categoryId}/with-children', [CategoryController::class, 'getCategoryWithChildren'])->name('api.categories.with-children');
});

// Product related API routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getAllProduct']);
    Route::get('/filter', [ProductController::class, 'filterProducts']);
    Route::get('/filter-options', [ProductController::class, 'getFilterOptions']);
    Route::get('/search', [ProductController::class, 'searchProducts']);
    Route::get('/latest/{productSlug}', [ProductController::class, 'getLatestProductUsingProductSlug']);
    Route::get('/shipped', [ProductController::class, 'getShippedProducts']);
    Route::get('/delivered', [ProductController::class, 'getDeliveredProducts']);
    Route::get('/cancelled', [ProductController::class, 'getCancelledProducts']);
});

Route::prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'getAllFaqs']);
    Route::get('/category/{categoryId}', [FaqController::class, 'getFaqUsingCategory']);
    Route::get('/{faqId}', [FaqController::class, 'getFaqsUsingId']);
    Route::get('/products/{productSlug}', [FaqController::class, 'getFaqsUsingproductId']);
});

Route::prefix('returns')->group(function () {
    Route::post('/', [ReturnOrderController::class, 'store'])->name('api.returns.store');
    Route::get('/{reverseOrder}', [ReturnOrderController::class, 'show'])->name('api.returns.show');
});
// Route::get('/return-orders/details', [ReturnOrderController::class, 'getDetails'])->name('return-orders.details');

Route::get('/return-orders/details', [ReturnOrderController::class, 'getDetails']);
Route::post('/return-orders/refund', [ReturnOrderController::class, 'processRefund']);
Route::post('/return-orders/bulk-refund', [ReturnOrderController::class, 'bulkRefund']);

// Review related API routes
Route::prefix('reviews')->group(function () {
    Route::post('/', [ReviewController::class, 'store'])->name('api.reviews.store');
    Route::get('/products/{productSlug}', [ReviewController::class, 'getProductReviews'])->name('api.reviewsRoutr.product');
});

Route::get('/category/filter-options/{slug}', [CategoryController::class, 'getFilterOptions'])->name('category.filter.options');

// Route::get('', [WebhookController::class, 'handle'])->name('webhook');
Route::post('/delhivery/webhook', [WebhookController::class, 'handle']);