<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', function(){
    return "Selamat datang!";
})->middleware('auth');
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    
    // URL: /admin/dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/produk', ProdukController::class);
    Route::resource('/transaksi', TransaksiController::class)->except(['create', 'store']);
    // Nanti tambahkan route resource lain di sini, contoh:
    // Route::resource('/produk', ProdukController::class);
    // Route::resource('/transaksi', TransaksiController::class);
});

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', function() {
    return redirect('/');
}); // Redirect POST to / back to GET

Route::get('/produk/{id}', [HomeController::class, 'show'])->name('produk.detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    
    // Aksi Tambah ke Keranjang
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    
    // Aksi Update & Hapus
Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/pesanan-saya', [TransaksiController::class, 'indexUser'])->name('transaksi.index_user');

// HALAMAN PEMBAYARAN
Route::get('/pembayaran/{id}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/pembayaran/{id}', [PaymentController::class, 'process'])->name('payment.process');
Route::put('/pembayaran/{id}', [PaymentController::class, 'process']); // Fallback untuk browser cache