<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat 1 Akun User Tetap (Untuk Testing Manual)
        DB::table('users')->insert([
            'name' => 'Budi Santoso',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'), // Password sama: password123
            'peran' => 'user', // Role USER, bukan admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. (Opsional) Buat 5 User Acak Tambahan
        // Berguna untuk melihat tampilan tabel user di Dashboard Admin
        // Un-comment baris di bawah ini jika ingin generate user acak
        /*
        \App\Models\Pengguna::factory(5)->create([
             'peran' => 'user'
        ]);
        */
    }
}