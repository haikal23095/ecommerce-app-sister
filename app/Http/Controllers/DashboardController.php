<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;  // Model User Anda
use App\Models\Produk;    // Model Produk Baru
use App\Models\Transaksi; // Model Transaksi Baru
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil Statistik Data
        $totalUser = Pengguna::where('peran', 'user')->count();
        $totalProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        
        // Menghitung Pendapatan (Asumsi kolom 'total_harga' ada di tabel transaksi)
        // Pastikan status transaksi sudah 'selesai' atau 'dibayar' jika ingin akurat
        $pendapatan = Transaksi::sum('total_harga'); 

        // 2. Mengambil 5 Transaksi Terbaru untuk Tabel
        // Choose an available column to order by to avoid "unknown column" errors.
        if (Schema::hasColumn('transaksi', 'tanggal_transaksi')) {
            $orderCol = 'tanggal_transaksi';
        } elseif (Schema::hasColumn('transaksi', 'created_at')) {
            $orderCol = 'created_at';
        } else {
            $orderCol = 'id';
        }

        $transaksiTerbaru = Transaksi::with('user')
                            ->orderBy($orderCol, 'desc')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalUser', 
            'totalProduk', 
            'totalTransaksi', 
            'pendapatan',
            'transaksiTerbaru'
        ));
    }
}