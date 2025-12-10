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
        // Make id_pelanggan nullable (since we're using user_id instead)
        if (Schema::hasTable('transaksi') && Schema::hasColumn('transaksi', 'id_pelanggan')) {
            Schema::table('transaksi', function (Blueprint $table) {
                // Drop the foreign key constraint first if it exists
                try {
                    $table->dropForeign('transaksi_ibfk_1');
                } catch (\Exception $e) {
                    // Foreign key may not exist, ignore
                }
            });

            // Now make the column nullable
            Schema::table('transaksi', function (Blueprint $table) {
                $table->unsignedBigInteger('id_pelanggan')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transaksi') && Schema::hasColumn('transaksi', 'id_pelanggan')) {
            Schema::table('transaksi', function (Blueprint $table) {
                // Revert to non-nullable (if you want to restore the original constraint)
                // Note: this may fail if there are NULL values
                // $table->unsignedBigInteger('id_pelanggan')->nullable(false)->change();
            });
        }
    }
};
