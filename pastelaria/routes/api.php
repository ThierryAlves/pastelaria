<?php

use App\Http\Controllers\CustomerController;
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
        Route::get('/get/{id}', 'get');
        Route::patch('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
        Route::get('/list/', 'list');
    });

    Route::controller(ProductController::class)->prefix('/product')->group(function() {
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'get');
        Route::patch('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
        Route::get('/list/', 'list');
    });
});

