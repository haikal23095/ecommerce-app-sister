<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only create the table if it doesn't already exist
        if (! Schema::hasTable('keranjang')) {
            Schema::create('keranjang', function (Blueprint $table) {
                $table->id();
                // Menyimpan ID User pemilik keranjang
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

                // Menyimpan ID Produk yang dipilih (simpan sebagai unsignedBigInteger).
                // Avoid adding a foreign key here to prevent migration errors when the
                // referenced `produk` table exists but has incompatible column types.
                $table->unsignedBigInteger('produk_id')->index();

                $table->integer('jumlah'); // Qty barang
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};