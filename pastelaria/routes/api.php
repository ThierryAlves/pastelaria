<?php

use App\Http\Controllers\CostumerController;
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
    Route::controller(CostumerController::class)->prefix('/costumer')->group(function() {
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'get');
        Route::get('/list/', 'list');
        Route::delete('/delete/{id}', 'delete');
    });
});

