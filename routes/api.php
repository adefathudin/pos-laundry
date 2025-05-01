<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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
Route::get('/products', [ProductsController::class, 'list'])->name('product.list');
Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product.show');
Route::post('/product/save', [ProductsController::class, 'store'])->name('product.store');
Route::delete('/product/delete', [ProductsController::class, 'destroy'])->name('product.delete');
Route::post('/product/update', [ProductsController::class, 'update'])->name('product.update');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('prodmast', App\Http\Controllers\Api\ProdmastController::class);
Route::apiResource('customer', App\Http\Controllers\Api\CustomerController::class);
Route::apiResource('toko', App\Http\Controllers\Api\TokoController::class);
