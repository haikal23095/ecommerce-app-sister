<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\DetailTransaksiApiController;
use App\Http\Controllers\Api\PembayaranApiController;

// Public routes - Bisa diakses tanpa autentikasi
Route::post('/login', [UserApiController::class, 'login']);
Route::post('/register', [UserApiController::class, 'register']);

// Get all products (public access untuk display di frontend)
Route::get('/produk', [ProdukApiController::class, 'index']);
Route::get('/produk/{id}', [ProdukApiController::class, 'show']);

// Protected routes - Memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {

    // User routes
    Route::get('/user', function (Request $request) {
        return response()->json(['success' => true, 'data' => $request->user()]);
    });
    Route::post('/logout', [UserApiController::class, 'logout']);
    Route::get('/users', [UserApiController::class, 'index']);
    Route::get('/users/{id}', [UserApiController::class, 'show']);
    Route::put('/users/{id}', [UserApiController::class, 'update']);
    Route::delete('/users/{id}', [UserApiController::class, 'destroy']);

    // Produk routes (CRUD untuk admin)
    Route::post('/produk', [ProdukApiController::class, 'store']);
    Route::put('/produk/{id}', [ProdukApiController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukApiController::class, 'destroy']);

    // Transaksi routes
    Route::get('/transaksi', [TransaksiApiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiApiController::class, 'show']);
    Route::post('/transaksi', [TransaksiApiController::class, 'store']);
    Route::put('/transaksi/{id}', [TransaksiApiController::class, 'update']);
    Route::delete('/transaksi/{id}', [TransaksiApiController::class, 'destroy']);

    // Detail Transaksi routes
    Route::get('/detail-transaksi', [DetailTransaksiApiController::class, 'index']);
    Route::get('/detail-transaksi/{id}', [DetailTransaksiApiController::class, 'show']);
    Route::get('/transaksi/{transaksi_id}/details', [DetailTransaksiApiController::class, 'getByTransaksi']);
    Route::post('/detail-transaksi', [DetailTransaksiApiController::class, 'store']);
    Route::put('/detail-transaksi/{id}', [DetailTransaksiApiController::class, 'update']);
    Route::delete('/detail-transaksi/{id}', [DetailTransaksiApiController::class, 'destroy']);

    // Pembayaran routes
    Route::get('/pembayaran', [PembayaranApiController::class, 'index']);
    Route::get('/pembayaran/{id}', [PembayaranApiController::class, 'show']);
    Route::post('/pembayaran', [PembayaranApiController::class, 'store']);
    Route::put('/pembayaran/{id}', [PembayaranApiController::class, 'update']);
    Route::delete('/pembayaran/{id}', [PembayaranApiController::class, 'destroy']);
});
