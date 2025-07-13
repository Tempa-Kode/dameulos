<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'ukuran_produk_id',
        'jenis_warna_produk_id',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
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
