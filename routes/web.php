<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PulsaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketdataController;
use App\Http\Controllers\PulsaCustController;
use App\Http\Controllers\ServiceCustController;
use App\Http\Controllers\BayartagihanController;
use App\Http\Controllers\DashboardCustController;
use App\Http\Controllers\PaketdataCustController;
use App\Http\Controllers\BayarTagihanCustController;
use App\Http\Controllers\RiwayatTransaksiController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/customer/dashboard', function () {
    return view('dashboardcust');
})->name('dashboardcust');

Route::post('/forgot-password/process', [LoginController::class, 'SendEmail'])->name('forgot.password');
Route::group(['middleware' => ['role:admin']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/pulsa', [PulsaController::class, 'index'])->name('pulsa.index');
    Route::get('/paket_Data', [PaketdataController::class, 'index'])->name('paket_data.index');
    Route::get('/bayar_tagihan', [BayartagihanController::class, 'index'])->name('bayar_tagihan.index');
    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

    Route::get('/product/add', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/pulsa/add', [PulsaController::class, 'index'])->name('pulsa.create');
    Route::post('/pulsa/store', [PulsaController::class, 'store'])->name('pulsa.store');
    Route::get('/paket_data/add', [PaketdataController::class, 'index'])->name('paket_data.create');
    Route::get('/paket_data/store', [PaketdataController::class, 'index'])->name('paket_data.store');
    Route::get('/bayar_tagihan/store', [BayartagihanController::class, 'index'])->name('bayar_tagihan.store');

    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::get('/product/delete/{id?}', [ProductController::class, 'destroy'])->name('product.delete');
});

#customer
Route::get('/customer/dashboardcust', [DashboardCustController::class, 'index'])->name('dashboardcust.index');
Route::get('/customer/pulsaCust', [PulsaCustController::class, 'index'])->name('pulsaCust.index');
Route::get('/customer/pulsa/add', [PulsaCustController::class, 'index'])->name('pulsaCust.create');
Route::post('/customer/pulsa/store', [PulsaCustController::class, 'index'])->name('pulsaCust.store');
Route::get('/customer/paket_data', [PaketdataCustController::class, 'index'])->name('paket_dataCust.index');
Route::get('/customer/paket_data/add', [PaketdataCustController::class, 'index'])->name('paket_dataCust.create');
Route::get('/customer/paket_data/store', [PaketdataCustController::class, 'store'])->name('paket_dataCust.store');
Route::post('/paket_datacust', [DashboardCustController::class, 'store'])->name('paket_datacust.store');
Route::get('/customer/bayar_tagihan', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihanCust.index');
Route::get('/customer/bayar_tagihan/add', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihanCust.create');
Route::get('/customer/bayar_tagihan/store', [BayarTagihanCustController::class, 'store'])->name('bayar_tagihanCust.store');
Route::get('/bayar_tagihancust', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihancust.index');
Route::get('/customer/service', [ServiceCustController::class, 'index'])->name('serviceCust.index');
Route::get('/customer/serviceCust/add', [ServiceCustController::class, 'index'])->name('serviceCust.create');
Route::get('/customer/serviceCust/store', [ServiceCustController::class, 'store'])->name('serviceCust.store');
Route::get('/serviceCust', [ServiceCustController::class, 'index'])->name('serviceCust.index');
Route::get('/RiwayatTransaksi', [RiwayatTransaksiController::class, 'index'])->name('riwayatTransaksi.index');

Route::get('/admin/register', function () {
    return view('register');
})->name('register');

Route::get('/admin/password', function () {
    return view('password');
})->name('password');