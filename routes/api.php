<?php


use App\Http\Controllers\Api\V1\Admin\RefundController;
use App\Http\Controllers\Api\V1\SearchController;
use Illuminate\Support\Facades\Route;

Route::pattern('id','[0-9]+');
Route::pattern('sku','[0-9]+');
Route::pattern('order','[0-9]+');
Route::pattern('slug','[A-Za-z0-9\-]+');

use App\Http\Controllers\HealthController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\V1\ProductController  as PublicProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CouponController   as PublicCouponController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\PublicReportController;
use App\Http\Controllers\Api\V1\ReviewController;

use App\Http\Controllers\Api\V1\Account\AddressController as AccountAddressController;
use App\Http\Controllers\Api\V1\Account\OrderController   as AccountOrderController;

use App\Http\Controllers\Api\V1\Admin\BrandController        as AdminBrandController;
use App\Http\Controllers\Api\V1\Admin\CategoryController     as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController      as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\SkuController          as AdminSkuController;
use App\Http\Controllers\Api\V1\Admin\CouponController       as AdminCouponController;
use App\Http\Controllers\Api\V1\Admin\OrderController        as AdminOrderController;
use App\Http\Controllers\Api\V1\Admin\ReviewController       as AdminReviewController;
use App\Http\Controllers\Api\V1\Admin\ReportController       as AdminReportController;
use App\Http\Controllers\Api\V1\Admin\MediaController        as AdminMediaController;

use App\Http\Controllers\Webhooks\StripeWebhookController;
use App\Http\Controllers\Webhooks\IyzicoWebhookController;

Route::prefix('v1')->as('api.v1.')->group(function () {
    Route::get('health', HealthController::class);

    Route::get('search/products', [SearchController::class,'products'])
        ->middleware('throttle:search')
        ->name('search.products');

    Route::get('checkout/shipping-options', [CheckoutController::class,'shippingOptions'])
        ->middleware('throttle:api')
        ->name('checkout.shipping_options');

    // Auth
    Route::post('auth/register', [AuthController::class,'register'])->middleware('throttle:auth')->name('auth.register');
    Route::post('auth/login',    [AuthController::class,'login'])->middleware('throttle:auth')->name('auth.login');
    Route::post('auth/forgot-password', [\App\Http\Controllers\Api\V1\PasswordController::class,'sendResetLink'])->middleware('throttle:auth');
    Route::post('auth/reset-password',  [\App\Http\Controllers\Api\V1\PasswordController::class,'reset'])->middleware('throttle:auth');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class,'logout'])->name('auth.logout');
        Route::get('auth/me',      [AuthController::class,'me'])->name('auth.me');
        Route::post('auth/email/verification-notification', [\App\Http\Controllers\Api\V1\EmailVerificationController::class,'send'])->middleware('throttle:auth');

        // Account
        Route::get('account/addresses',           [AccountAddressController::class,'index'])->name('account.addresses.index');
        Route::post('account/addresses',          [AccountAddressController::class,'store'])->name('account.addresses.store');
        Route::patch('account/addresses/{id}',    [AccountAddressController::class,'update'])->name('account.addresses.update');
        Route::delete('account/addresses/{id}',   [AccountAddressController::class,'destroy'])->name('account.addresses.destroy');

        Route::get('account/orders',              [AccountOrderController::class,'index'])->name('account.orders.index');
        Route::get('account/orders/{order}',      [AccountOrderController::class,'show'])->name('account.orders.show');

        // Reviews (user)
        Route::post('reviews',                    [ReviewController::class,'store'])->middleware('throttle:reviews')->name('reviews.store');
        Route::patch('reviews/{id}',              [ReviewController::class,'update'])->middleware('throttle:reviews')->name('reviews.update');
        Route::delete('reviews/{id}',             [ReviewController::class,'destroy'])->middleware('throttle:reviews')->name('reviews.destroy');
    });
    Route::get('auth/verify-email/{id}/{hash}', [\App\Http\Controllers\Api\V1\EmailVerificationController::class,'verify'])
        ->middleware(['signed','throttle:auth'])->name('verification.verify');

    // Public reports
    Route::get('reports/public/sales-snapshot', [PublicReportController::class,'snapshot'])->name('reports.public.snapshot');

    // Catalog (public)
    Route::get('categories',        [PublicCategoryController::class,'index'])->name('categories.index');
    Route::get('categories/{slug}', [PublicCategoryController::class,'show'])->name('categories.show');
    Route::get('products',          [PublicProductController::class,'index'])->name('products.index');
    Route::get('products/{slug}',   [PublicProductController::class,'show'])->name('products.show');

    // Cart + Coupon
    Route::get('cart',               [CartController::class,'show'])->name('cart.show');
    Route::post('cart/items',        [CartController::class,'add'])->middleware(['throttle:cart','idem:60'])->name('cart.items.add');
    Route::patch('cart/items/{id}',  [CartController::class,'update'])->middleware(['throttle:cart','idem:60'])->name('cart.items.update');
    Route::delete('cart/items/{id}', [CartController::class,'remove'])->middleware('throttle:cart')->name('cart.items.remove');

    Route::post('cart/apply-coupon', [PublicCouponController::class,'apply'])->middleware('throttle:cart')->name('cart.coupon.apply');
    Route::delete('cart/coupon',     [PublicCouponController::class,'remove'])->middleware('throttle:cart')->name('cart.coupon.remove');

    // Checkout
    Route::post('checkout/address',        [CheckoutController::class,'address'])->name('checkout.address');
    Route::post('checkout/shipping',       [CheckoutController::class,'shipping'])->name('checkout.shipping');
    Route::post('checkout/payment-intent', [CheckoutController::class,'paymentIntent'])->middleware('idem:120')->name('checkout.intent');
    Route::post('checkout/confirm',        [CheckoutController::class,'confirm'])->middleware(['auth:sanctum','idem:300'])->name('checkout.confirm');

    // Admin
    Route::prefix('admin')->middleware(['auth:sanctum','role:admin','throttle:admin'])->as('admin.')->group(function () {
        Route::post('media',   [AdminMediaController::class,'store'])->name('media.store');
        Route::delete('media', [AdminMediaController::class,'destroy'])->name('media.destroy');

        Route::post('orders/{order}/refunds', [RefundController::class,'store'])
            ->middleware(['idem:300'])
            ->name('orders.refunds.store');

        Route::apiResource('brands',     AdminBrandController::class)->except('show');
        Route::apiResource('categories', AdminCategoryController::class)->except('show');
        Route::apiResource('products',   AdminProductController::class);
        Route::post('products/{product}/skus', [AdminSkuController::class,'store'])->name('products.skus.store');
        Route::patch('skus/{sku}',        [AdminSkuController::class,'update'])->name('skus.update');
        Route::delete('skus/{sku}',       [AdminSkuController::class,'destroy'])->name('skus.destroy');

        Route::apiResource('coupons', AdminCouponController::class)->except('show');

        Route::get('orders',                 [AdminOrderController::class,'index'])->name('orders.index');
        Route::get('orders/{order}',         [AdminOrderController::class,'show'])->name('orders.show');
        Route::patch('orders/{order}/status',[AdminOrderController::class,'updateStatus'])->name('orders.status');

        Route::patch('reviews/{id}/moderate', [AdminReviewController::class,'moderate'])->name('reviews.moderate');

        Route::get('reports/sales',          [AdminReportController::class,'sales'])->name('reports.sales');
        Route::get('reports/top-products',   [AdminReportController::class,'topProducts'])->name('reports.top');
        Route::get('reports/stock-alerts',   [AdminReportController::class,'stockAlerts'])->name('reports.stock');
        Route::get('reports/coupons',        [AdminReportController::class,'coupons'])->name('reports.coupons');
        Route::get('reports/sales-snapshot', [AdminReportController::class,'snapshot'])->name('reports.snapshot');
    });

    // Webhooks
    Route::post('webhooks/stripe', [StripeWebhookController::class,'__invoke'])->middleware(['whsig:stripe','throttle:webhooks']);
    Route::post('webhooks/iyzico', [IyzicoWebhookController::class,'__invoke'])->middleware(['whsig:iyzico','throttle:webhooks']);
});

Route::fallback(fn() => response()->json(['success'=>false,'error'=>'not_found'], 404));
