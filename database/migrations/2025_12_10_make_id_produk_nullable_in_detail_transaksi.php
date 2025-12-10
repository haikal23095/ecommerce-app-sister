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
        // Make id_produk nullable since we're using produk_id instead
        if (Schema::hasTable('detail_transaksi') && Schema::hasColumn('detail_transaksi', 'id_produk')) {
            // Drop any foreign key constraint first if it exists
            Schema::table('detail_transaksi', function (Blueprint $table) {
                try {
                    $table->dropForeign('detail_transaksi_ibfk_2');
                } catch (\Exception $e) {
                    // FK may not exist, ignore
                }
            });

            // Now make the column nullable
            Schema::table('detail_transaksi', function (Blueprint $table) {
                $table->unsignedBigInteger('id_produk')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detail_transaksi') && Schema::hasColumn('detail_transaksi', 'id_produk')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                // Revert if needed
            });
        }
    }
};
