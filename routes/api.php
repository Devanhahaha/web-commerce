<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



//login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    // Tambahkan rute yang membutuhkan autentikasi JWT di sini

    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
    Route::post('/notification', [PaymentController::class, 'notification'])->name('notification');

    //pulsa
    Route::get('/pulsa', [PulsaController::class, 'index']);
    Route::post('/pulsa', [PulsaController::class, 'store']);

    //paketdata
    Route::get('/paketdata', [PaketdataController::class, 'index']);
    Route::post('/paketdata', [PaketdataController::class, 'store']);

    //bayartagihan
    Route::get('/bayartagihan', [BayarTagihanController::class, 'index']);
    Route::post('/bayartagihan', [BayarTagihanController::class, 'store']);

    //services
    Route::get('/services', [ServicesController::class, 'index']);
    Route::post('/services', [ServicesController::class, 'store']);

    //productcust
    Route::get('/productcust', [ProductCustController::class, 'index']);

    //transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index']);
});


