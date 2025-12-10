<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Menampilkan isi keranjang User
    public function index()
    {
        // Ambil data keranjang milik user yang sedang login, beserta data produknya
        $cartItems = Keranjang::with('produk')
                        ->where('user_id', Auth::id())
                        ->get();

        // Hitung Total Bayar
        $totalBayar = 0;
        foreach ($cartItems as $item) {
            $totalBayar += ($item->produk->harga * $item->jumlah);
        }

        // The cart view lives under resources/views/user/cart.blade.php
        return view('user.cart', compact('cartItems', 'totalBayar'));
    }

    // 2. Menambahkan barang ke keranjang
    public function addToCart(Request $request, $id)
    {
        // Pastikan user login (sebenarnya sudah dijaga middleware, tapi untuk keamanan ganda)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu untuk belanja');
        }

        $produk = Produk::findOrFail($id);
        $jumlah = $request->jumlah > 0 ? $request->jumlah : 1;

        // Validasi Stok
        if ($produk->stok < $jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Cek apakah barang ini SUDAH ADA di keranjang user?
        $cekKeranjang = Keranjang::where('user_id', Auth::id())
                            ->where('produk_id', $id)
                            ->first();

        if ($cekKeranjang) {
            // Jika ada, tambahkan jumlahnya saja
            $cekKeranjang->jumlah += $jumlah;
            $cekKeranjang->save();
        } else {
            // Jika belum ada, buat baris baru
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $id,
                'jumlah' => $jumlah
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil masuk keranjang!');
    }

    // 3. Update Jumlah (Saat user mengubah qty di halaman keranjang)
    public function updateCart(Request $request, $id)
    {
        $cartItem = Keranjang::findOrFail($id);

        // Pastikan ini keranjang milik dia sendiri
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        // Cek stok lagi
        if ($cartItem->produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok produk kurang dari permintaan Anda');
        }

        $cartItem->jumlah = $request->jumlah;
        $cartItem->save();

        return back()->with('success', 'Jumlah berhasil diubah');
    }

    // 4. Hapus Item dari keranjang
    public function deleteCart($id)
    {
        $cartItem = Keranjang::findOrFail($id);
        
        // Pastikan milik sendiri
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $cartItem->delete();
        return back()->with('success', 'Item dihapus dari keranjang');
    }
}