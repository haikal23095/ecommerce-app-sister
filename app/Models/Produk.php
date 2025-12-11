<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk'; // Sesuai nama tabel di database Anda

    // Jika tabel produk tidak memiliki kolom created_at/updated_at
    public $timestamps = false;

    // Sesuaikan dengan nama kolom di tabel produk Anda
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'gambar'
    ];
}