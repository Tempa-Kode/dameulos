<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'transaksi_id',
        'kode_transaksi',
        'total_pembayaran',
        'status',
        'bukti_transfer',
        'snap_token',
        'tanggal_pembayaran',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
