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
        // Make id_transaksi nullable since we're using transaksi_id instead
        if (Schema::hasTable('detail_transaksi') && Schema::hasColumn('detail_transaksi', 'id_transaksi')) {
            // Drop the foreign key constraint first
            Schema::table('detail_transaksi', function (Blueprint $table) {
                try {
                    $table->dropForeign('detail_transaksi_ibfk_1');
                } catch (\Exception $e) {
                    // FK may not exist, ignore
                }
            });

            // Now make the column nullable
            Schema::table('detail_transaksi', function (Blueprint $table) {
                $table->unsignedBigInteger('id_transaksi')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detail_transaksi') && Schema::hasColumn('detail_transaksi', 'id_transaksi')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                // Revert to non-nullable if needed
                // $table->unsignedBigInteger('id_transaksi')->nullable(false)->change();
            });
        }
    }
};
