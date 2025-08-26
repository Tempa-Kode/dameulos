<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanBalasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'keluhan_id',
        'user_id',
        'pesan',
        'dari',
        'is_internal',
        'lampiran'
    ];

    protected $casts = [
        'lampiran' => 'array',
        'is_internal' => 'boolean'
    ];

    // Relationships
    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isFromAdmin()
    {
        return $this->dari === 'admin';
    }

    public function isFromPelanggan()
    {
        return $this->dari === 'pelanggan';
    }

    public function isInternal()
    {
        return $this->is_internal;
    }
}
