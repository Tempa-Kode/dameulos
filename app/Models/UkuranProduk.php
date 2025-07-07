<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkuranProduk extends Model
{
    protected $table = 'ukuran_produk';

    protected $fillable = [
        'produk_id',
        'ukuran'
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
