<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'status',
        'subtotal',
        'ongkir',
        'total',
        'preorder',
        'catatan',
        'alamat_pengiriman',
    ];

    public function scopeStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function requestWarna()
    {
        return $this->hasOne(RequestWarna::class);
    }

    public function pengembalianDana()
    {
        return $this->hasOne(PengembalianDana::class);
    }

    /**
     * Cek apakah transaksi dapat diedit ukuran dan warnanya
     * Hanya bisa diedit jika status dibayar atau dikonfirmasi (belum diproses)
     */
    public function canEditDetails()
    {
        return in_array($this->status, ['dibayar', 'dikonfirmasi']);
    }

    /**
     * Cek apakah transaksi dapat dibatalkan
     * Hanya bisa dibatalkan jika status pending atau dibayar
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'dibayar']);
    }
}
