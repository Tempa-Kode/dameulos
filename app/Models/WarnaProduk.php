<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarnaProduk extends Model
{
    protected $table = 'warna_produk';

    protected $fillable = [
        'produk_id',
        'kode_warna',
        'warna'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
