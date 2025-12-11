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
        'id_pelanggan',
        'total_harga',
        'alamat_pengiriman',
        'status' // misal: 'pending', 'dibayar', 'dikirim'
    ];

    // Cast dibuat_pada ke datetime
    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    // Relasi ke User (Pembeli)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Pengguna (untuk kompatibilitas dengan web app)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi');
    }
}