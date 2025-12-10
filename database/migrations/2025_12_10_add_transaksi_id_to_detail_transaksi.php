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
        // Add transaksi_id column if it doesn't exist
        if (Schema::hasTable('detail_transaksi') && !Schema::hasColumn('detail_transaksi', 'transaksi_id')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                $table->unsignedBigInteger('transaksi_id')->after('id')->index();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detail_transaksi') && Schema::hasColumn('detail_transaksi', 'transaksi_id')) {
            Schema::table('detail_transaksi', function (Blueprint $table) {
                $table->dropIndex(['transaksi_id']);
                $table->dropColumn('transaksi_id');
            });
        }
    }
};
