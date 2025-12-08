<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'username',
        'kata_sandi',
        'peran'
    ];

    protected $hidden = ['kata_sandi'];
}

