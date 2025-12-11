<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'metode_bayar',
        'jumlah_bayar'
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
