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
        // Expand the status column to hold longer strings like 'pending', 'dibayar', 'dikirim', etc.
        if (Schema::hasTable('transaksi') && Schema::hasColumn('transaksi', 'status')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->string('status', 50)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transaksi') && Schema::hasColumn('transaksi', 'status')) {
            Schema::table('transaksi', function (Blueprint $table) {
                // Revert to smaller size (optional)
                // $table->char('status', 1)->change();
            });
        }
    }
};
