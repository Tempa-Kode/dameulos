<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'katalog_id',
        'kategori_produk_id',
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

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id', 'id');
    }

    public function fotoProduk()
    {
        return $this->hasMany(FotoProduk::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id', 'id');
    }

    public function videoProduk()
    {
        return $this->hasMany(VideoProduk::class, 'produk_id', 'id');
    }

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['cari'])) {
            $query->where('nama', 'like', '%' . $filters['cari'] . '%');
        }
        if (!empty($filters['kategori'])) {
            $query->where('kategori_produk_id', $filters['kategori']);
        }
        return $query;
    }

    public function scopeFilterPenjualan($query, $penjualan)
    {
        if ($penjualan == 'terlaris') {
            return $query->withCount([
                'detailTransaksi as jumlah_terjual' => function ($q) {
                    $q->select(DB::raw('COALESCE(SUM(jumlah),0)'));
                }
            ])->orderByDesc('jumlah_terjual');
        } elseif ($penjualan == 'terendah') {
            return $query->withCount([
                'detailTransaksi as jumlah_terjual' => function ($q) {
                    $q->select(DB::raw('COALESCE(SUM(jumlah),0)'));
                }
            ])->orderBy('jumlah_terjual', 'asc');
        } elseif ($penjualan == 'stok') {
            return $query->where('stok', 0);
        }
        return $query;
    }
}
