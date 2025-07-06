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
        'ukuran',
        'warna',
        'gambar'
    ];

    protected $casts = [
        'ukuran' => 'array',
        'warna' => 'array'
    ];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }
}
