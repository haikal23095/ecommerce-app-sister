<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Wajib import ini untuk Transaction

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        $cartItems = Keranjang::with('produk')->where('user_id', Auth::id())->get();

        // Jika keranjang kosong, tendang balik
        if($cartItems->isEmpty()){
            return redirect()->route('home')->with('error', 'Keranjang Anda masih kosong');
        }

        // Hitung Total
        $totalBayar = 0;
        foreach ($cartItems as $item) {
            $totalBayar += ($item->produk->harga * $item->jumlah);
        }

        // The checkout view lives under resources/views/user/checkout.blade.php
        return view('user.checkout', compact('cartItems', 'totalBayar'));
    }

    // 2. Proses Simpan Transaksi
    public function process(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:255',
        ]);

        // Gunakan DB Transaction agar data aman
        // Jika ada error di tengah proses, semua perubahan akan dibatalkan (rollback)
        DB::transaction(function () use ($request) {
            
            $user = Auth::user();
            $cartItems = Keranjang::with('produk')->where('user_id', $user->id)->get();
            
            // Hitung ulang total (untuk keamanan backend)
            $totalHarga = 0;
            foreach ($cartItems as $item) {
                $totalHarga += ($item->produk->harga * $item->jumlah);
                
                // Cek Stok lagi sebelum deal
                if ($item->jumlah > $item->produk->stok) {
                    throw new \Exception("Stok untuk produk {$item->produk->nama_produk} tidak mencukupi.");
                }
            }

            // A. Buat Transaksi Baru (Nota Utama)
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'status' => 'pending', // Status awal
            ]);

            // B. Pindahkan Item Keranjang ke Detail Transaksi
            foreach ($cartItems as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item->produk_id,
                    'jumlah'       => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal'     => $item->produk->harga * $item->jumlah
                ]);

                // C. Kurangi Stok Produk
                $produk = Produk::find($item->produk_id);
                $produk->decrement('stok', $item->jumlah);
            }

            // D. Kosongkan Keranjang User
            Keranjang::where('user_id', $user->id)->delete();

        });

        $newTransaction = Transaksi::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        return redirect()->route('payment.show', $newTransaction->id);
    }
}