<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/pembayaran
     */
    public function index(Request $request)
    {
        try {
            $query = Pembayaran::with('transaksi');

            if ($request->has('id_transaksi')) {
                $query->where('id_transaksi', $request->id_transaksi);
            }
            $pembayaran = $query->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data pembayaran berhasil diambil',
                'data' => $pembayaran
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/pembayaran
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_transaksi' => 'required|exists:transaksi,id',
                'metode_bayar' => 'required|in:tunai,transfer,qris',
                'jumlah_bayar' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pembayaran = Pembayaran::create([
                'id_transaksi' => $request->id_transaksi,
                'metode_bayar' => $request->metode_bayar,
                'jumlah_bayar' => $request->jumlah_bayar
            ]);

            $pembayaran->load('transaksi');

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dibuat',
                'data' => $pembayaran
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/pembayaran/{id}
     */
    public function show($id)
    {
        try {
            $pembayaran = Pembayaran::with('transaksi')->find($id);

            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail pembayaran berhasil diambil',
                'data' => $pembayaran
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/pembayaran/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'metode_bayar' => 'sometimes|in:tunai,transfer,qris',
                'jumlah_bayar' => 'sometimes|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pembayaran->update($request->all());
            $pembayaran->load('transaksi');

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diupdate',
                'data' => $pembayaran
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/pembayaran/{id}
     */
    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak ditemukan'
                ], 404);
            }

            $pembayaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
