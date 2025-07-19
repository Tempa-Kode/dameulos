<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeWarnaRequest extends Model
{
    protected $table = 'kode_warna_request';

    protected $fillable = [
        'request_warna_id',
        'kode_warna',
    ];

    public function requestWarna()
    {
        return $this->belongsTo(RequestWarna::class);
    }
}
