<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'katalog_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'gambar'
    ];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }

    public function ukuran()
    {
        return $this->hasMany(UkuranProduk::class, 'produk_id', 'id');
    }

    public function warnaProduk()
    {
        return $this->hasMany(WarnaProduk::class, 'produk_id', 'id');
    }

    public function jenisWarnaProduk()
    {
        return $this->hasMany(JenisWarnaProduk::class, 'produk_id', 'id');
    }
}
