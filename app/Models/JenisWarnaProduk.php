<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisWarnaProduk extends Model
{
    protected $table = 'jenis_warna_produk';

    protected $fillable = [
        'produk_id',
        'warna'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
