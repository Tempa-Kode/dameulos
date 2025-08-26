<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Keluhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tiket',
        'user_id',
        'transaksi_id',
        'subjek',
        'pesan',
        'kategori',
        'prioritas',
        'status',
        'last_response_at',
        'last_response_by',
        'lampiran'
    ];

    protected $casts = [
        'lampiran' => 'array',
        'last_response_at' => 'datetime'
    ];

    // Status constants
    const STATUS_BUKA = 'buka';
    const STATUS_DALAM_PROSES = 'dalam_proses';
    const STATUS_MENUNGGU_PELANGGAN = 'menunggu_pelanggan';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITUTUP = 'ditutup';

    // Priority constants
    const PRIORITY_RENDAH = 'rendah';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_TINGGI = 'tinggi';
    const PRIORITY_URGENT = 'urgent';

    // Category constants
    const CATEGORY_PRODUK = 'produk';
    const CATEGORY_PENGIRIMAN = 'pengiriman';
    const CATEGORY_PEMBAYARAN = 'pembayaran';
    const CATEGORY_LAYANAN = 'layanan';
    const CATEGORY_LAINNYA = 'lainnya';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($keluhan) {
            if (empty($keluhan->kode_tiket)) {
                $keluhan->kode_tiket = self::generateKodeTicket();
            }
        });
    }

    public static function generateKodeTicket()
    {
        do {
            $kode = 'TK-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('kode_tiket', $kode)->exists());

        return $kode;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function balasans()
    {
        return $this->hasMany(KeluhanBalasan::class)->orderBy('created_at', 'asc');
    }

    // Accessor untuk status yang lebih readable
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_BUKA => 'Buka',
            self::STATUS_DALAM_PROSES => 'Dalam Proses',
            self::STATUS_MENUNGGU_PELANGGAN => 'Menunggu Pelanggan',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITUTUP => 'Ditutup'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_BUKA => 'badge-primary',
            self::STATUS_DALAM_PROSES => 'badge-warning',
            self::STATUS_MENUNGGU_PELANGGAN => 'badge-info',
            self::STATUS_SELESAI => 'badge-success',
            self::STATUS_DITUTUP => 'badge-secondary'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getPrioritasLabelAttribute()
    {
        $labels = [
            self::PRIORITY_RENDAH => 'Rendah',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_TINGGI => 'Tinggi',
            self::PRIORITY_URGENT => 'Urgent'
        ];

        return $labels[$this->prioritas] ?? $this->prioritas;
    }

    public function getPrioritasBadgeAttribute()
    {
        $badges = [
            self::PRIORITY_RENDAH => 'badge-secondary',
            self::PRIORITY_NORMAL => 'badge-primary',
            self::PRIORITY_TINGGI => 'badge-warning',
            self::PRIORITY_URGENT => 'badge-danger'
        ];

        return $badges[$this->prioritas] ?? 'badge-secondary';
    }

    public function getKategoriLabelAttribute()
    {
        $labels = [
            self::CATEGORY_PRODUK => 'Produk',
            self::CATEGORY_PENGIRIMAN => 'Pengiriman',
            self::CATEGORY_PEMBAYARAN => 'Pembayaran',
            self::CATEGORY_LAYANAN => 'Layanan Pelanggan',
            self::CATEGORY_LAINNYA => 'Lainnya'
        ];

        return $labels[$this->kategori] ?? $this->kategori;
    }

    // Helper methods
    public function canBeReplied()
    {
        return !in_array($this->status, [self::STATUS_SELESAI, self::STATUS_DITUTUP]);
    }

    public function needsAttention()
    {
        // Keluhan yang perlu perhatian (lebih dari 24 jam tanpa respon)
        if ($this->status === self::STATUS_BUKA) {
            return $this->created_at->diffInHours(now()) > 24;
        }

        if ($this->status === self::STATUS_MENUNGGU_PELANGGAN) {
            return false; // Sedang menunggu pelanggan
        }

        return $this->last_response_at &&
               $this->last_response_by === 'user' &&
               $this->last_response_at->diffInHours(now()) > 24;
    }
}
