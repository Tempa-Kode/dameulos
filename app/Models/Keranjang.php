<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
        'ukuran_produk_id',
        'jenis_warna_produk_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function ukuranProduk()
    {
        return $this->belongsTo(UkuranProduk::class, 'ukuran_produk_id');
    }

    public function jenisWarnaProduk()
    {
        return $this->belongsTo(JenisWarnaProduk::class, 'jenis_warna_produk_id');
    }
}
