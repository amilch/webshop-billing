<?php

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

Route::get('/orders', '\App\Http\Controllers\GetOrdersController');
Route::post('/orders', '\App\Http\Controllers\CreateOrderController');
Route::patch('/orders', '\App\Http\Controllers\UpdateOrderController');
Route::post('/total', '\App\Http\Controllers\GetTotalController');

Route::group(['middleware' => ['auth:api', 'can:admin']], function() {

});

