<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    // Pastikan nama tabel di database Anda benar-benar 'pengguna'. 
    // Jika masih default, biasanya namanya 'users'.
    protected $table = 'users'; 

    protected $fillable = [
        'name',      // Menggantikan 'nama'
        'email',     // Menggantikan 'username' (kecuali Anda mau ubah fungsi email jadi username)
        'password',  // Menggantikan 'kata_sandi'
        'peran'      // Kolom ini HARUS ditambahkan ke database dulu!
    ];

    protected $hidden = ['password']; // Sesuaikan juga di sini
}