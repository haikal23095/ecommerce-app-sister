<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    // Disable timestamps since detail_transaksi table doesn't have created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    // Relasi ke Induk Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relasi ke Produk (Untuk tahu nama & gambar barangnya nanti)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}