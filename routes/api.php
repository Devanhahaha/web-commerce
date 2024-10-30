<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\PulsaController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\PaketdataController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\ProductCustController;
use App\Http\Controllers\Api\BayarTagihanController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product', [ProductController::class, 'index']);
Route::post('/store', [ProductController::class, 'store']);
Route::put('/update/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);
Route::post('/notification', [PaymentController::class, 'notification'])->name('notification');

//pulsa
Route::get('/pulsa', [PulsaController::class, 'index']);

//paketdata
Route::get('/paketdata', [PaketdataController::class, 'index']);

//bayartagihan
Route::get('/bayartagihan', [BayarTagihanController::class, 'index']);

//services
Route::get('/services', [ServicesController::class, 'index']);

//productcust
Route::get('/productcust', [ProductCustController::class, 'index']);

//transaksi
Route::get('/transaksi', [TransaksiController::class, 'index']);