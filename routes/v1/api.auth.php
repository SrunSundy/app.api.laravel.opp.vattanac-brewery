<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OutletController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;

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

Route::group(['prefix' => 'product'], function(){
    Route::get('/', [ProductController::class, 'index']); 
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::get('/{product}/review', [ProductController::class, 'review']);
    Route::post('/review/store', [ProductController::class, 'storeReview']);
    Route::post('/review/update/{id}', [ProductController::class , 'updateReview']);
});

Route::group(['prefix' => 'me'], function(){
    Route::get('/wishlist', [OutletController::class , 'wishlist']);
    Route::post('/wishlist/store', [OutletController::class , 'storeWishlist']);
    Route::post('/wishlist/remove', [OutletController::class , 'removeWishlist']);
    Route::get('/cart', [CartController::class , 'index']);
    Route::post('/cart/store', [CartController::class , 'store']);
});

Route::group(['prefix' => 'order'], function(){
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::post('/store', [OrderController::class , 'store']);
});

Route::group(['prefix' => 'outlet'], function(){
    Route::post('/feedback_app', [OutletController::class, 'sendAppFeedback']);
    Route::post('/feedback_agent', [OutletController::class, 'sendAgentFeedback']); 
});