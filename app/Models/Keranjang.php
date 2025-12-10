<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah'
    ];

    // Relasi ke User (Pemilik keranjang)
    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    // Relasi ke Produk (Barang yang dipilih)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}