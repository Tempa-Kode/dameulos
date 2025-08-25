<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengembalianDana extends Model
{
    use SoftDeletes;

    protected $table = 'pengembalian_dana';

    protected $fillable = [
        'transaksi_id',
        'user_id',
        'kode_pengembalian',
        'jumlah_pengembalian',
        'alasan_pembatalan',
        'metode_pengembalian',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'bank',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_diproses',
        'tanggal_selesai',
        'bukti_transfer',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_diproses' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    const METODE_TRANSFER_BANK = 'transfer_bank';
    const METODE_EWALLET = 'ewallet';
    const METODE_CASH = 'cash';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate kode pengembalian unik
     */
    public static function generateKodePengembalian()
    {
        $prefix = 'REF';
        $date = date('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        
        return $prefix . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Accessor untuk status dalam bahasa Indonesia
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
            default => 'Unknown'
        };
    }

    /**
     * Accessor untuk metode pengembalian dalam bahasa Indonesia
     */
    public function getMetodePengembalianTextAttribute()
    {
        return match($this->metode_pengembalian) {
            self::METODE_TRANSFER_BANK => 'Transfer Bank',
            self::METODE_EWALLET => 'E-Wallet',
            self::METODE_CASH => 'Tunai',
            default => 'Unknown'
        };
    }
}
