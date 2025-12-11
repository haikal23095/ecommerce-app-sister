<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/produk
     */
    public function index()
    {
        try {
            $produk = Produk::all();
            return response()->json([
                'success' => true,
                'message' => 'Data produk berhasil diambil',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/produk
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'gambar' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $produk = Produk::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/produk/{id}
     */
    public function show($id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail produk berhasil diambil',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/produk/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama_produk' => 'sometimes|string|max:255',
                'harga' => 'sometimes|numeric|min:0',
                'stok' => 'sometimes|integer|min:0',
                'gambar' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $produk->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/produk/{id}
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
