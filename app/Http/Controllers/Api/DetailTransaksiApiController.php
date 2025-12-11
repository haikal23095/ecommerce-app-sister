<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailTransaksiApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/detail-transaksi
     */
    public function index()
    {
        try {
            $details = DetailTransaksi::with(['transaksi', 'produk'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Data detail transaksi berhasil diambil',
                'data' => $details
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get details by transaksi_id
     * GET /api/transaksi/{transaksi_id}/details
     */
    public function getByTransaksi($transaksi_id)
    {
        try {
            $details = DetailTransaksi::with(['produk'])
                ->where('transaksi_id', $transaksi_id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data detail transaksi berhasil diambil',
                'data' => $details
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/detail-transaksi
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transaksi_id' => 'required|exists:transaksi,id',
                'produk_id' => 'required|exists:produk,id',
                'jumlah' => 'required|integer|min:1',
                'harga_satuan' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $detail = DetailTransaksi::create($request->all());
            $detail->load(['transaksi', 'produk']);

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil ditambahkan',
                'data' => $detail
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/detail-transaksi/{id}
     */
    public function show($id)
    {
        try {
            $detail = DetailTransaksi::with(['transaksi', 'produk'])->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail transaksi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil diambil',
                'data' => $detail
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/detail-transaksi/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $detail = DetailTransaksi::find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail transaksi tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'produk_id' => 'sometimes|exists:produk,id',
                'jumlah' => 'sometimes|integer|min:1',
                'harga_satuan' => 'sometimes|numeric|min:0',
                'subtotal' => 'sometimes|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $detail->update($request->all());
            $detail->load(['transaksi', 'produk']);

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil diupdate',
                'data' => $detail
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/detail-transaksi/{id}
     */
    public function destroy($id)
    {
        try {
            $detail = DetailTransaksi::find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail transaksi tidak ditemukan'
                ], 404);
            }

            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
