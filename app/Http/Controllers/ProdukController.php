<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produks = Produk::orderBy('id', 'desc')->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('admin.produk.create');
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload Gambar
        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imageName = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $imageName
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan detail produk
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }

    // Menampilkan form edit
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    // Update produk yang sudah ada
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['nama_produk','harga','stok']);

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus produk
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}