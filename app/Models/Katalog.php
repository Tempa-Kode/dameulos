<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    protected $table = 'katalog';

    protected $fillable = [
        'nama',
        'slug',
        'link_katalog'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
