<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Only create the table if it doesn't already exist to avoid errors
    if (! Schema::hasTable('pengguna')) {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama',150);
            $table->string('username',100)->unique();
            $table->string('kata_sandi');
            $table->enum('peran',['admin','pelanggan']);
            $table->timestamps();
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ensure we drop the correct table name
        Schema::dropIfExists('pengguna');
    }
};
