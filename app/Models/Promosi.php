<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    protected $table = 'promosi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];
}
