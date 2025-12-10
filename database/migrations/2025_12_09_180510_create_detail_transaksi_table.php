<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only create if it doesn't already exist
        if (! Schema::hasTable('detail_transaksi')) {
            Schema::create('detail_transaksi', function (Blueprint $table) {
                $table->id();

                // Relasi ke tabel Transaksi (store id; avoid strict FK to prevent migration issues)
                $table->unsignedBigInteger('transaksi_id')->index();

                // Relasi ke tabel Produk (store id; avoid strict FK)
                $table->unsignedBigInteger('produk_id')->index();

                $table->integer('jumlah'); // Jumlah barang yang dibeli
                $table->decimal('harga_satuan', 12, 0); // Harga saat beli (snapshot)
                $table->decimal('subtotal', 12, 0); // Jumlah * Harga Satuan

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};