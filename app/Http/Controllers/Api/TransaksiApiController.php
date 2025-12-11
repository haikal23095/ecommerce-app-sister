<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/transaksi
     */
    public function index(Request $request)
    {
        try {
            // Bisa filter by user_id jika diperlukan
            $query = Transaksi::with(['user', 'details.produk']);

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $transaksi = $query->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil diambil',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/transaksi
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'total_harga' => 'required|numeric|min:0',
                'alamat_pengiriman' => 'required|string',
                'status' => 'nullable|string',
                'details' => 'required|array|min:1',
                'details.*.produk_id' => 'required|exists:produk,id',
                'details.*.jumlah' => 'required|integer|min:1',
                'details.*.harga_satuan' => 'required|numeric|min:0',
                'details.*.subtotal' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create transaksi
            $transaksi = Transaksi::create([
                'user_id' => $request->user_id,
                'total_harga' => $request->total_harga,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'status' => $request->status ?? 'pending'
            ]);

            // Create detail transaksi
            foreach ($request->details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $detail['produk_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga_satuan' => $detail['harga_satuan'],
                    'subtotal' => $detail['subtotal']
                ]);
            }

            DB::commit();

            // Load relationships
            $transaksi->load(['details.produk', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaksi
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/transaksi/{id}
     */
    public function show($id)
    {
        try {
            $transaksi = Transaksi::with(['user', 'details.produk'])->find($id);

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil diambil',
                'data' => $transaksi
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
     * PUT /api/transaksi/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::find($id);

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'sometimes|string',
                'alamat_pengiriman' => 'sometimes|string',
                'total_harga' => 'sometimes|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $transaksi->update($request->only(['status', 'alamat_pengiriman', 'total_harga']));

            $transaksi->load(['details.produk', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diupdate',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/transaksi/{id}
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::find($id);

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            // Delete detail transaksi first
            DetailTransaksi::where('transaksi_id', $id)->delete();

            // Delete transaksi
            $transaksi->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
