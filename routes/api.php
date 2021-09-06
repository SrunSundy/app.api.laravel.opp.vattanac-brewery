<?php

use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'category'], function () {
    Route::get("/", [CategoryController::class , 'index']);
    Route::get("/{id}" , [CategoryController::class , 'show']);
});

Route::group(['prefix' => 'brand'], function () {
    Route::get("/", [BrandController::class , 'index']);
    Route::get("/{id}" , [BrandController::class , 'show']);
});

//Route::post("/update-order-state", [OrderController::class , 'update_order_state'])->name("order.update_order_state");
