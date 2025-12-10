<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transaksis = Transaksi::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    // Menampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    // Menampilkan form edit
    public function edit(Transaksi $transaksi)
    {
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    // Update status transaksi
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:pending,dibayar,dikirim,selesai,batal'
        ]);

        $transaksi->update([
            'status' => $request->status
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Status transaksi berhasil diperbarui');
    }

    // Hapus transaksi
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }

    //user
    // Method KHUSUS USER melihat riwayat pesanannya sendiri
    public function indexUser()
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();

        return view('user.transaksi', compact('transaksi'));
    }
}