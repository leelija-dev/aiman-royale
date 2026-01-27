<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\API\BrandController;

Route::prefix('blog')->group(function () {
    Route::get('/posts', [BlogApiController::class, 'posts']);
    Route::get('/posts/{slug}', [BlogApiController::class, 'post']);
    Route::get('/categories', [BlogApiController::class, 'categories']);
    Route::get('/tags', [BlogApiController::class, 'tags']);
});

// Brand related API routes
Route::post('/generate-slug', [BrandController::class, 'generateSlug'])->name('api.generate-slug');
