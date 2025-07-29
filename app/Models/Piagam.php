<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piagam extends Model
{
    protected $table = 'piagam';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];

}
