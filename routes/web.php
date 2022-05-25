<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'detail'])->where('id', '[0-9]+');
    Route::get('marketPrice', [ProductController::class, 'getMarketPrice']);
    Route::get('pendingOrder', [ProductController::class, 'getPendingOrder']);
    Route::post('pendingOrder', [ProductController::class, 'pendingOrder']);
});
