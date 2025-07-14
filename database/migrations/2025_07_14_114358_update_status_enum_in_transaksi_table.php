<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom status enum untuk menambahkan nilai baru
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM('pending', 'dibayar', 'dikonfirmasi', 'diproses', 'dikirim', 'dibatalkan') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum asli
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM('pending', 'dikonfirmasi', 'diproses', 'dikirim') DEFAULT 'pending'");
    }
};
