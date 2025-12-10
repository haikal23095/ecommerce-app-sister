<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Sesuai nama tabel di database Anda

    // Jika tabel transaksi tidak memiliki kolom created_at/updated_at
    public $timestamps = false;

    // Sesuaikan dengan nama kolom di tabel transaksi Anda
    protected $fillable = [
        'user_id', 
        'total_harga',
        'alamat_pengiriman',
        'status', // misal: 'pending', 'dibayar', 'dikirim'
        'tanggal_transaksi'
    ];

    // Cast tanggal_transaksi ke datetime agar ->format() bisa dipanggil di Blade
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    // Relasi ke User (Pembeli)
    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}