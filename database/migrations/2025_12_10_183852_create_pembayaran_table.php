<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->string('metode_pembayaran'); // Transfer Bank, COD, E-Wallet, dll
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('status_pembayaran')->default('pending'); // pending, success, failed
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable(); // path ke file bukti transfer

            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
