<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'keranjang_id',
        'total_harga',
        'status',
        'alamat_pengiriman',
        'tanggal_transaksi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
