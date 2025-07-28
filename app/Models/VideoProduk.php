<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoProduk extends Model
{
    protected $table = 'video_produk';

    protected $fillable = [
        'produk_id',
        'link_video',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
