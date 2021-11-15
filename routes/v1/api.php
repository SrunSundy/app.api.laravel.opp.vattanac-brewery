<?php

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\OutletController;
use App\Http\Controllers\API\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware(['localization'])->group(function () {
    Route::group([
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::middleware(['authorization.api'])->group(function () {
            Route::post('/refresh', [AuthController::class, 'refresh']);
        });
        Route::group([
            'prefix' => 'forgot_password',
            'middleware' => 'phone.auth'
        ], function ($router) {
            Route::post('request', [ForgotPasswordController::class, 'requestOtpCode'])->name('forgot_password.request');
            Route::post('verify', [ForgotPasswordController::class, 'verifyOtpCode'])->name('forgot_password.verify');
            Route::post('reset', [ForgotPasswordController::class, 'resetPassword'])->name('forgot_password.reset');
        });
    });


    Route::group(['prefix' => 'outlet'] , function(){
        Route::post("/sign_up" , [OutletController::class, 'store']);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get("/", [CategoryController::class, 'index']);
        Route::get("/{category}", [CategoryController::class, 'show']);
    });

    Route::group(['prefix' => 'brand'], function () {
        Route::get("/", [BrandController::class, 'index']);
        Route::get("/{brand}", [BrandController::class, 'show']);
    });

    Route::group(['prefix' => 'advertisement'], function () {
        Route::get("/", [AdvertisementController::class, 'index']);
        Route::get("/{advertisement}", [AdvertisementController::class, 'show']);
    });
});

//Route::post("/update-order-state", [OrderController::class , 'update_order_state'])->name("order.update_order_state");

Route::post("log", [PaymentController::class, 'logData']);
