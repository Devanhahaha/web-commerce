<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PulsaController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketdataController;
use App\Http\Controllers\PulsaCustController;
use App\Http\Controllers\ProductCustController;
use App\Http\Controllers\ServiceCustController;
use App\Http\Controllers\BayartagihanController;
use App\Http\Controllers\LaporanPulsaController;
use App\Http\Controllers\DashboardCustController;
use App\Http\Controllers\PaketdataCustController;
use App\Http\Controllers\LaporanServicesController;
use App\Http\Controllers\BayarTagihanCustController;
use App\Http\Controllers\LaporanPaketDataController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\LaporanBayarTagihanController;
use App\Http\Controllers\RiwayatTransaksiPulsaController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\LaporanPemesananProductController;
use App\Http\Controllers\RiwayatTransaksiProductController;
use App\Http\Controllers\RiwayatTransaksiServicesController;
use App\Http\Controllers\RiwayatTransaksiPaketDataController;
use App\Http\Controllers\RiwayatTransaksiBayarTagihanController;

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
Route::get('/logout/process', [LoginController::class, 'logout'])->name('logout');

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
    Route::get('/laporanpulsa', [LaporanPulsaController::class, 'index'])->name('laporanpulsa.index');
    Route::get('/laporanpaketdata', [LaporanPaketDataController::class, 'index'])->name('laporanpaketdata.index');
    Route::get('/laporanbayartagihan', [LaporanBayarTagihanController::class, 'index'])->name('laporanbayartagihan.index');
    Route::get('/laporanservices', [LaporanServicesController::class, 'index'])->name('laporanservices.index');
    Route::get('/laporanpemesananproduct', [LaporanPemesananProductController::class, 'index'])->name('laporanpemesananproduct.index');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/pulsa', [PulsaController::class, 'index'])->name('pulsa.index');
    Route::get('/paket_Data', [PaketdataController::class, 'index'])->name('paket_data.index');
    Route::get('/bayar_tagihan', [BayartagihanController::class, 'index'])->name('bayar_tagihan.index');
    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

    Route::get('/product/add', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/pulsa/add', [PulsaController::class, 'index'])->name('pulsa.create');
    Route::post('/pulsa/store', [PulsaController::class, 'store'])->name('pulsa.store');
    Route::get('/paket_data/add', [PaketdataController::class, 'index'])->name('paket_data.create');
    Route::post('/paket_data/store', [PaketdataController::class, 'store'])->name('paket_data.store');
    Route::get('/services/add', [ServicesController::class, 'create'])->name('services.create');
    Route::post('/services/store', [ServicesController::class, 'store'])->name('services.store');
    Route::post('/bayar_tagihan/store', [BayartagihanController::class, 'store'])->name('bayar_tagihan.store');
    Route::get('/bayar_tagihan/add', [BayartagihanController::class, 'index'])->name('bayar_tagihan.create');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::get('/product/delete/{id?}', [ProductController::class, 'destroy'])->name('product.delete');
    
    Route::post('/update-nominal', [ServicesController::class, 'updateNominal'])->name('update.nominal');

});

Route::post('/orders/{id}/ship', [OrderController::class, 'ship'])->name('orders.ship');
Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
Route::post('/orders/cancel_request/{id}', [OrderController::class, 'requestCancel'])->name('orders.cancel_request');
Route::post('/orders/cancel/{id}', [OrderController::class, 'confirmCancel'])->name('orders.cancel');

Route::get('/getProvinsi', [AlamatController::class, 'getProvinsi']);
Route::get('/getKabupaten/{provinsi_id}', [AlamatController::class, 'getKabupaten']);
Route::post('/getOngkir', [AlamatController::class, 'getOngkir']);

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

Route::post('/checkout/cart', [ProductCustController::class, 'checkoutCart'])->name('productCust.checkoutCart');
Route::post('/checkout/selected', [ProductCustController::class, 'checkoutSelected'])->name('productCust.checkoutSelected');


#customer
Route::group(['middleware' => ['role:customer']], function () {

Route::get('/customer/dashboardcust', [DashboardCustController::class, 'index'])->name('dashboardcust.index');
Route::get('/customer/pulsaCust', [PulsaCustController::class, 'index'])->name('pulsaCust.index');
Route::get('/customer/productCust', [ProductCustController::class, 'index'])->name('productCust.index');
Route::get('/customer/productCust', [ProductCustController::class, 'index'])->name('productCust.index');
Route::get('/customer/pulsa/add', [PulsaCustController::class, 'index'])->name('pulsaCust.create');
Route::post('/customer/pulsa/store', [PulsaCustController::class, 'store'])->name('pulsaCust.store');
Route::get('/customer/paket_data', [PaketdataCustController::class, 'index'])->name('paket_dataCust.index');
Route::get('/customer/paket_data/add', [PaketdataCustController::class, 'index'])->name('paket_dataCust.create');
Route::post('/customer/paket_data/store', [PaketdataCustController::class, 'store'])->name('paket_dataCust.store');
Route::post('/paket_datacust', [DashboardCustController::class, 'store'])->name('paket_datacust.store');
Route::get('/customer/bayar_tagihan', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihanCust.index');
Route::get('/customer/bayar_tagihan/add', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihanCust.create');
Route::post('/customer/bayar_tagihan/store', [BayarTagihanCustController::class, 'store'])->name('bayar_tagihanCust.store');
Route::get('/bayar_tagihancust', [BayarTagihanCustController::class, 'index'])->name('bayar_tagihancust.index');
Route::get('/customer/service', [ServiceCustController::class, 'index'])->name('serviceCust.index');
Route::get('/customer/serviceCust/add', [ServiceCustController::class, 'index'])->name('serviceCust.create');
Route::post('/customer/serviceCust/store', [ServiceCustController::class, 'store'])->name('serviceCust.store');
Route::get('/serviceCust', [ServiceCustController::class, 'index'])->name('serviceCust.index');
Route::get('/RiwayatTransaksi', [RiwayatTransaksiController::class, 'index'])->name('riwayatTransaksi.index');
Route::get('/RiwayatTransaksiPulsa', [RiwayatTransaksiPulsaController::class, 'index'])->name('riwayatTransaksiPulsa.index');
Route::get('/RiwayatTransaksiPaketData', [RiwayatTransaksiPaketDataController::class, 'index'])->name('riwayatTransaksiPaketData.index');
Route::get('/RiwayatTransaksiBayarTagihan', [RiwayatTransaksiBayarTagihanController::class, 'index'])->name('riwayatTransaksiBayarTagihan.index');
Route::get('/RiwayatTransaksiProduct', [RiwayatTransaksiProductController::class, 'index'])->name('riwayatTransaksiProduct.index');
Route::get('/RiwayatTransaksiServices', [RiwayatTransaksiServicesController::class, 'index'])->name('riwayatTransaksiServices.index');

Route::get('/customer/payment', [PaymentController::class, 'createTransaction']);
Route::post('/customer/payment', [PaymentController::class, 'createTransaction']);
Route::get('/customer/payment/success', [PaymentController::class, 'success']);

Route::post('/customer/checkout/{id}', [ProductCustController::class, 'checkout'])->name('productCust.checkout');
Route::get('/checkout/{id}', [ProductCustController::class, 'showCheckout'])->name('checkout');

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('orders.show');


Route::post('/pulsa/token', [PulsaCustController::class, 'token'])->name('pulsaCust.token');



});

Route::get('/admin/register', function () {
    return view('register');
})->name('register');

Route::get('/admin/password', function () {
    return view('password');
})->name('password');