<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function() {
    Route::controller(CustomerController::class)->prefix('/customer')->group(function() {
        Route::post('/create', 'create');
        Route::get('/get/{customer}', 'get');
        Route::patch('/update/{customer}', 'update');
        Route::delete('/delete/{customer}', 'delete');
        Route::get('/list/', 'list');
    });

    Route::controller(ProductController::class)->prefix('/product')->group(function() {
        Route::post('/create', 'create');
        Route::get('/get/{product}', 'get');
        Route::patch('/update/{product}', 'update');
        Route::delete('/delete/{product}', 'delete');
        Route::get('/list/', 'list');
    });

    Route::controller(OrderController::class)->prefix('/order')->group(function() {
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'get');
        Route::delete('/delete/{id}', 'delete');
        Route::get('/list/', 'list');
        Route::prefix('/update/{id}')->group(function () {
            Route::put('/changeProducts', 'changeProducts');
        });
    });
});

