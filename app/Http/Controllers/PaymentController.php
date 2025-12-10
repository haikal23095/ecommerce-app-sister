<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // 1. Tampilkan Halaman Pembayaran
    public function show($id)
    {
        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Keamanan: Pastikan yang mau bayar adalah pemilik transaksi
        if ($transaksi->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        // Jika status bukan pending, berarti sudah dibayar/batal
        if ($transaksi->status != 'pending') {
            return redirect()->route('transaksi.index_user')
                ->with('error', 'Transaksi ini sudah diproses atau dibatalkan.');
        }

        return view('user.payment', compact('transaksi'));
    }

    // 2. Proses Konfirmasi Pembayaran (Simulasi Sukses)
    public function process(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Validasi Metode Pembayaran
        $request->validate([
            'metode_pembayaran' => 'required|string',
        ]);

        // --- DISINI LOGIKA PEMBAYARAN ASLI BIASANYA ---
        // Kalau pakai Midtrans, disini kita request API Midtrans.
        // Tapi untuk simulasi, kita langsung anggap SUKSES.

        $transaksi->update([
            'status' => 'dibayar', // Ubah status jadi DIBAYAR
            // Anda bisa tambah kolom 'metode_pembayaran' di database jika mau mencatatnya
        ]);

        return redirect()->route('transaksi.index_user')
            ->with('success', 'Pembayaran Berhasil! Pesanan Anda sedang diproses.');
    }
}