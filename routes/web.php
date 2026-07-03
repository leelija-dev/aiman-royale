<?php

use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\FalseReviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\SingleProductController;
use App\Http\Controllers\Web\OccasionController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\Profile;
use App\Http\Controllers\Web\AddressController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\CustomDimensionController;
use App\Http\Controllers\Web\ContactUsController;
use App\Models\NewsLetter;
use App\Http\Controllers\Api\ReturnOrderController;
use App\Http\Controllers\Web\RefundController;

// Public routes (accessible without authentication)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('page.login');
    Route::post('/login', [AuthController::class, 'login'])->name('web.login');
    Route::view('/register', 'web.register')->name('page.register');
    Route::post('/register/send-otp', [AuthController::class, 'sendOTP'])->name('web.register.send-otp');
    Route::view('/verify-otp', 'web.verify-otp')->name('web.register.verify-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('web.register.verify-otp');
    Route::post('/register/resend-otp', [AuthController::class, 'resendOTP'])->name('web.register.resend-otp');
    Route::view('/set-password', 'web.set-password')->name('web.register.set-password');
    Route::post('/set-password', [AuthController::class, 'setPassword'])->name('web.register.set-password');
    
    // Forgot password routes
    Route::view('/forgot-password', 'web.forgot-password')->name('page.forgot-password');
    Route::post('/forgot-password/send-otp', [AuthController::class, 'sendForgotPasswordOTP'])->name('web.forgot-password.send-otp');
    Route::view('/forgot-password/verify-otp', 'web.forgot-password-verify-otp')->name('web.forgot-password.verify-otp');
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyForgotPasswordOTP'])->name('web.forgot-password.verify-otp');
    Route::post('/forgot-password/resend-otp', [AuthController::class, 'resendForgotPasswordOTP'])->name('web.forgot-password.resend-otp');
    Route::view('/forgot-password/reset', 'web.forgot-password-reset')->name('web.forgot-password.reset');
    Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])->name('web.forgot-password.reset');
    
    // Legacy routes (keep for backward compatibility)
    Route::post('/register/add', [AuthController::class, 'register'])->name('web.register.add');
    Route::view('/verify-email', 'web.verify-email')->name('page.verify-email');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('web.verify-email');
    Route::post('/resend-otp', [AuthController::class, 'resendOTP'])->name('web.resend-otp');
    
    // JWT API routes
    Route::post('/api/auth/me', [AuthController::class, 'me'])->name('api.auth.me');
    Route::post('/api/auth/refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');
});

Route::view('/addresses', 'web.addresses');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [Profile::class, 'profile'])->name('web.profile');
    Route::post('/profile', [Profile::class, 'update'])->name('web.profile.update');

    Route::post('/refund/{orderId}', [ReturnOrderController::class, 'store'])
        ->name('web.return.order');
});

// Authenticated routes (require login)
Route::get('/', [HomeController::class, 'home'])->name('page.index');
Route::view('/custome-design', 'web.custome-design')->name('page.custom-design');
Route::view('/appointment', 'web.appointment')->name('page.appointment');

Route::get('/contact-us', [ContactUsController::class, 'index'])->name('page.contact-us');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');
Route::view('/about-us', 'web.about-us')->name('page.about-us');
Route::view('/privacy-policy', 'web.privacy-policy')->name('page.privacy-policy');
Route::view('/terms-condition', 'web.terms-condition')->name('page.terms-condition');
Route::view('/return-refund-policy', 'web.refund-cancelation-policy')->name('page.refund-cancelation-policy');

// Category Routes
Route::get('/collections/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/collections', [CategoryController::class, 'collection'])->name('category.collection');
Route::get('/category/{slug}/filter', [CategoryController::class, 'filter'])->name('category.filter');

// Product Routes
Route::get('/products/{slug}', [HomeController::class, 'ShowSingleProduct'])->name('page.single-product');
Route::get('/products', [HomeController::class, 'ShowAllProduct'])->name('page.multi-product');
Route::get('/banner-filter', [HomeController::class, 'BannerFilter'])->name('page.banner-filter');

// Test route
Route::get('/test-occasion', function () {
    return 'Test route is working!';
});

// Auth Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('web.logout');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('check.login');
Route::post('/cart/update/', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::post('/cart/check', [CartController::class, 'checkVariantInCart'])->name('cart.check');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add')->middleware('check.login');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('check.login');
Route::post('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');

// Checkout route
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/payment/session', [CheckoutController::class, 'createPaymentSession'])->name('checkout.payment.session');
Route::post('/checkout/cod/process', [CheckoutController::class, 'processCOD'])->name('checkout.cod.process');
Route::get('/checkout/success', [CheckoutController::class, 'paymentSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'paymentCancel'])->name('checkout.cancel');
Route::get('/order-success', [CheckoutController::class, 'orderSuccess'])->name('order.success');

// Cashfree Webhook Route
Route::post('/checkout/webhook/cashfree', [CheckoutController::class, 'webhook'])->name('checkout.webhook');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [Profile::class, 'profile'])->name('web.profile');
    Route::post('/profile/update', [Profile::class, 'update'])->name('profile.update');

    // Address Routes
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

    // Admin Routes
    Route::get('/user/order-history/{id}', [UserController::class, 'orderHistory'])->name('user.order-history');
    Route::post('/cancel-order/{orderId}', [UserController::class, 'cancelOrder'])->name('order.cancel');

    // Custom Dimensions Routes
    Route::get('/custom-request', [CustomDimensionController::class, 'index'])->name('web.custom-request');
    Route::post('/custom-dimensions', [CustomDimensionController::class, 'store'])->name('custom-dimensions.store');
    Route::get('/custom-dimensions/{productId}', [CustomDimensionController::class, 'show'])->name('custom-dimensions.show');
    Route::delete('/custom-dimensions/{productId}', [CustomDimensionController::class, 'destroy'])->name('custom-dimensions.destroy');
    Route::post('/custom-dimensions/{id}/cancel', [CustomDimensionController::class, 'cancel'])->name('custom-dimensions.cancel');
    Route::get('/pay-custom-order/{id}', [CustomDimensionController::class, 'payment'])->name('custom-order.payment');
});

Route::post('/newsletter', [NewsLetterController::class, 'store'])->name('newsletter.store');

// Pincode check (AJAX)
Route::post('/check-pincode', [CheckoutController::class, 'checkPincode'])->name('check.pincode')->middleware('auth');

// Order tracking
Route::get('/track-order/{orderId}', [CheckoutController::class, 'trackOrder'])->name('track.order')->middleware('auth');

// Direct waybill tracking for staging/test Delhivery
Route::get('/track-waybill/{waybill}', [CheckoutController::class, 'trackWaybill'])->name('track.waybill');

// Public tracking page
Route::view('/track', 'web.track')->name('track.page');

// Delhivery webhook (no auth, called by Delhivery)
Route::post('/delhivery-webhook', [CheckoutController::class, 'delhiveryWebhook']);

// Combined Category + Occasion Routes - Must be at the end to avoid conflicts
Route::get('/{categorySlug}/{occasionSlug}', [CategoryController::class, 'showWithOccasion'])
    ->name('category.occasion.show')
    ->where('categorySlug', '[a-zA-Z0-9-]+');

Route::get('/{categorySlug}/{occasionSlug}/filter', [CategoryController::class, 'filterWithOccasion'])
    ->name('category.occasion.filter')
    ->where('categorySlug', '[a-zA-Z0-9-]+');

// Test WhatsApp route
Route::get('/test-whatsapp', function () {
    $whatsapp = new \App\Services\WhatsAppService();
    
    \Illuminate\Support\Facades\Log::info('Testing WhatsApp send');
    
    $result = $whatsapp->sendOrderConfirmation(
        '6295351230',
        'Pavan',
        'ORD-' . date('YmdHis')
    );
    
    return [
        'success' => $result,
        'message_id' => $whatsapp->getLastMessageId(),
        'phone_number_id' => config('services.whatsapp.phone_number_id')
    ];
});

// Order details route
Route::get('/orders/{id}', function ($id) {
    $order = DB::table('orders')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->first();
    
    if (!$order) {
        abort(404);
    }
    
    return view('orders.show', compact('order'));
})->name('orders.show')->middleware('auth');

Route::middleware(['auth'])->prefix('refunds')->group(function () {
    // Process refund
    Route::post('/orders/{orderId}', [RefundController::class, 'refund'])->name('refunds.process');
    
    // Full refund
    Route::post('/order/{orderId}/full', [RefundController::class, 'fullRefund'])->name('refunds.full');
    
    // Partial refund
    Route::post('/order/{orderId}/partial', [RefundController::class, 'partialRefund'])->name('refunds.partial');
    
    // Get order refunds
    Route::get('/order/{orderId}', [RefundController::class, 'orderRefunds'])->name('refunds.order');
    
    // Get refund status
    Route::get('/order/{orderId}/refund/{refundId}', [RefundController::class, 'refundStatus'])->name('refunds.status');
    
    // Cancel refund
    Route::post('/order/{orderId}/refund/{refundId}/cancel', [RefundController::class, 'cancelRefund'])->name('refunds.cancel');
    
    // Refund statistics
    Route::get('/statistics', [RefundController::class, 'statistics'])->name('refunds.statistics');
});
// Refund Routes
// Route::post('/refund/{orderId}', [RefundController::class, 'refund'])->name('refund.process');
// Route::post('/webhook/refund', [RefundController::class, 'handleWebhook'])->name('refund.webhook');