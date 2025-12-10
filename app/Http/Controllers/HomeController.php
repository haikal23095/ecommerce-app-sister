<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class HomeController extends Controller
{
    /**
     * Show the application homepage with product listing.
     */
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Use id ordering to avoid relying on created_at
        $produk = $query->orderBy('id', 'desc')->paginate(8);

        return view('user.home', compact('produk'));
    }
    
    public function show($id)
    {
        // Cari produk berdasarkan ID, jika tidak ketemu akan otomatis 404
        $produk = Produk::findOrFail($id);

        // The detail view is placed under resources/views/user/detail.blade.php
        return view('user.detail', compact('produk'));
    }
}