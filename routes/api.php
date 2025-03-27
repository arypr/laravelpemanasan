<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountReceivableController;

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
// Routes untuk Produk
Route::get('/product/{id}', [ProductController::class, 'getProductByID']);
Route::post('/product', [ProductController::class, 'addProduct']);
Route::put('/product/{id}', [ProductController::class, 'updateProduct']);
Route::post('/product/{id}/add-quantity', [ProductController::class, 'addQuantityProduct']);
Route::post('/product/{id}/deduct-quantity', [ProductController::class, 'deductQuantityProduct']);

// Routes untuk Account Receivable
Route::get('/receivables', [AccountReceivableController::class, 'index']);
Route::post('/receivables', [AccountReceivableController::class, 'store']);
Route::put('/receivables/{id}', [AccountReceivableController::class, 'update']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

