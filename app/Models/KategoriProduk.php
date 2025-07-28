<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'keterangan',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('nama_kategori')) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_produk_id');
    }
}
