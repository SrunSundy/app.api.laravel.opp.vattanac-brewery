<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OutletController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;

Route::middleware(['localization'])->group(function () {
    Route::group([
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group([
        'prefix' => 'me'
    ], function ($router) {
        Route::get('/profile', [AuthController::class, 'userProfile']);
        Route::group([
            'prefix' => 'update'
        ], function ($router) {
            Route::post('/password', [AuthController::class, 'updatePassword']);
        });
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
        Route::get('/{product}/review', [ProductController::class, 'review']);
        Route::post('/review/store', [ProductController::class, 'storeReview']);
        Route::post('/review/update/{id}', [ProductController::class, 'updateReview']);
    });

    Route::group(['prefix' => 'me'], function () {
        Route::get('/wishlist', [OutletController::class, 'wishlist']);
        Route::post('/wishlist/store', [OutletController::class, 'storeWishlist']);
        Route::post('/wishlist/remove', [OutletController::class, 'removeWishlist']);
        Route::get('/agent', [OutletController::class, 'agent']);
        Route::get('/cart', [CartController::class, 'index']);
        Route::get('/cart/count', [CartController::class, 'cartCount']);
        Route::post('/cart/store', [CartController::class, 'store']);
        Route::post('/cart/reorder', [CartController::class, 'reorder']);
        Route::post('/cart/remove', [CartController::class, 'remove']);
        Route::post('/cart/remove_all', [CartController::class, 'removeAll']);
        Route::get('/notifications', [NotificationController::class, 'index']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::post('/store', [OrderController::class, 'store']);
        Route::post('/cancel', [OrderController::class, 'cancel']);
    });

    Route::group(['prefix' => 'outlet'], function () {
        Route::post('/feedback_app', [OutletController::class, 'sendAppFeedback']);
        Route::post('/feedback_agent', [OutletController::class, 'sendAgentFeedback']);
    });


    Route::group(['prefix' => 'payment'], function () {
        Route::get('/account', [PaymentController::class, 'getPaymentAccount'])->middleware('log.telegram');
        Route::post('/', [PaymentController::class, 'store'])->middleware('log.telegram');
        Route::put('/', [PaymentController::class, 'update'])->middleware('log.telegram');
    });
});
