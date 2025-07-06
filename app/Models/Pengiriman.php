<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'transaksi_id',
        'nama_penerima',
        'no_resi',
        'ongkir',
        'berat',
        'alamat_pengiriman',
        'alamat_penerima',
        'catatan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
