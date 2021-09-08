<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\ProductController;

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
});
