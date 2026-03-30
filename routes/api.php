<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\FaqController;

Route::prefix('blog')->group(function () {
    Route::get('/posts', [BlogApiController::class, 'posts']);
    Route::get('/posts/{slug}', [BlogApiController::class, 'post']);
    Route::get('/categories', [BlogApiController::class, 'categories']);
    Route::get('/tags', [BlogApiController::class, 'tags']);
});

// Brand related API routes
Route::post('/generate-slug', [BrandController::class, 'generateSlug'])->name('api.generate-slug');

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
});

Route::prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'getAllFaqs']);
    Route::get('/category/{categoryId}', [FaqController::class, 'getFaqUsingCategory']);
    Route::get('/{faqId}', [FaqController::class, 'getFaqsUsingId']);
});

// Review related API routes
Route::prefix('reviews')->group(function () {
    Route::post('/', [ReviewController::class, 'store'])->name('api.reviews.store');
});