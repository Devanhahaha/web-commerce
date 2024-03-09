<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () { 
    return view('login');
})->name('login');

Route::post('/login/process', [LoginController::class, 'checkAuth'])->name('login.process');
Route::post('/register/process', [LoginController::class, 'store'])->name('register.process');
Route::post('/forgot-password/process', [LoginController::class, 'SendEmail'])->name('forgot.password');
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');

    Route::get('/product/add', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update', [ProductController::class, 'update'])->name('product.update');

    Route::get('/product/delete/{id?}', [ProductController::class, 'destroy'])->name('product.delete');
});



Route::get('/admin/register', function () {
    return view('register');
})->name('register');

Route::get('/admin/password', function () {
    return view('password');
})->name('password');