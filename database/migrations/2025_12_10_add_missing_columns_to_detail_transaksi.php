<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add missing columns to detail_transaksi table
        if (Schema::hasTable('detail_transaksi')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                // Add produk_id if it doesn't exist
                if (!Schema::hasColumn('detail_transaksi', 'produk_id')) {
                    $table->unsignedBigInteger('produk_id')->after('transaksi_id')->index();
                }
                
                // Add jumlah if it doesn't exist
                if (!Schema::hasColumn('detail_transaksi', 'jumlah')) {
                    $table->integer('jumlah')->after('produk_id');
                }
                
                // Add harga_satuan if it doesn't exist
                if (!Schema::hasColumn('detail_transaksi', 'harga_satuan')) {
                    $table->decimal('harga_satuan', 12, 0)->after('jumlah');
                }
                
                // Add subtotal if it doesn't exist
                if (!Schema::hasColumn('detail_transaksi', 'subtotal')) {
                    $table->decimal('subtotal', 12, 0)->after('harga_satuan');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detail_transaksi')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                $columns = ['produk_id', 'jumlah', 'harga_satuan', 'subtotal'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('detail_transaksi', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
