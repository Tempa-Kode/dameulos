<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestWarna extends Model
{
    protected $table = 'request_warna';

    protected $fillable = [
        'transaksi_id',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function kodeWarnaRequests()
    {
        return $this->hasMany(KodeWarnaRequest::class);
    }
}
