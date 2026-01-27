<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\SingleProductController;


// use App\Http\Controllers\Web\PageController;
// use App\Http\Controllers\Web\ContactController;
// use App\Http\Controllers\Web\AboutController;
// use App\Http\Controllers\Web\BlogController;
// use App\Http\Controllers\Web\CareerController;
// use App\Http\Controllers\Web\ServiceController;
// use App\Http\Controllers\Web\ApplicationController;

// use App\Http\Controllers\Web\DigitalM☻arketing;
// use App\Http\Controllers\Web\BestSeo;
// use App\Http\Controllers\Web\Ecommerce;


// Route::get('/l1', function () {
//     return view('web.L1');
// });
// Route::get('/l2', function () {
//     return view('web.L2');
// });
// Route::get('/l3', function () {
//     return view('web.L3');
// });


Route::get('/', [HomeController::class, 'home'])->name('page.index');

// Category Routes
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/single-product/{id}', [HomeController::class, 'ShowSingleProduct'])->name('page.single-product');
Route::get('/all-product', [HomeController::class, 'ShowAllProduct'])->name('page.multi-product');
Route::view('/login', 'web.login')->name('page.login');
Route::post('/login', [AuthController::class, 'login'])->name('web.login');
Route::view('/register', 'web.register')->name('page.register');
Route::post('/register/add', [AuthController::class, 'register'])->name('web.register.add');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');

Route::fallback(function () { abort(404); });

//Checkout route

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout/success', [CheckoutController::class, 'paymentSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'paymentCancel'])->name('checkout.cancel');
Route::get('/order-success', [CheckoutController::class, 'orderSuccess'])->name('order.success');

// Route::get('/career', [CareerController::class, 'index'])->name('page.career');
// Route::get('/contact-us', [ContactController::class, 'index'])->name('page.contact');
// Route::post('/insert-contact', [ContactController::class, 'store'])->name('page.insert-contact');  //add
// Route::get('/about', [AboutController::class, 'index'])->name('page.about');
// Route::post('/email', [ContactController::class, 'Email'])->name('page.email');
// Route::post('/apply', [ApplicationController::class, 'Apply'])->name('page.apply');
// Route::get('successfull', [ApplicationController::class, 'Thanks'])->name('page.successfull');


// Route::prefix('blog')->group(function () {
//     Route::get('/', [BlogController::class, 'index'])->name('blog.home');
//     Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
//     Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
//     Route::get('/search', [BlogController::class, 'search'])->name('blog.search');
//     // Keep this last to prevent conflicts
//     Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.single-post');
// });


// Route::get('/privacy-policy', function () {
//     return view('web.privacy');
// })->name('page.privacy');
// Route::get('/term-and-conditions', function () {
//     return view('web.terms');
// })->name('page.terms');
// Route::get('/thank-you', function () {
//     return view('web.thank-you');
// })->name('page.thank-you');
// Route::get('/coming-soon', function () {
//     return view('web.coming-soon');
// })->name('page.coming-soon');


// Route::prefix('page')->group(function () {
    // Route::get('/web-development', fn() => redirect()->route('page.coming-soon'))->name('page.web-development');
    // Route::get('/web-design', fn() => redirect()->route('page.coming-soon'))->name('page.web-design');
    // Route::get('/guest-post-services', fn() => redirect()->route('page.coming-soon'))->name('page.guest-post-services');
    // Route::get('/content-marketing', fn() => redirect()->route('page.coming-soon'))->name('page.content-marketing');
    // Route::get('/seo-services', fn() => redirect()->route('page.coming-soon'))->name('page.seo-services');
    // Route::get('/branding-services', fn() => redirect()->route('page.coming-soon'))->name('page.branding-services');
    // Route::get('/web-design', fn() => redirect()->route('page.coming-soon'))->name('page.web-design');
// });

// Route::get('/{slug}', [PageController::class, 'sub_pages'])->name('Page.view');
// Route::post('/{slug}', [PageController::class, 'sub_pages'])->name('Page.view');

// Route::get('/{slug}', [ServiceController::class, 'showService'])->name('Service.view');

// Route::get('/digital-marketing', [DigitalMarketing::class, 'index'])->name('page.digital-marketing');
// Route::get('/best-seo', [BestSeo::class, 'index'])->name('Page.best-seo');
// Route::get('/best-ecommerce', [Ecommerce::class, 'index'])->name('Page.best-ecommerce');