<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ERP\OrderController;


Route::group(['prefix' => 'order'], function () {
    Route::post("/status/update", [OrderController::class , 'updateStatus']);
});