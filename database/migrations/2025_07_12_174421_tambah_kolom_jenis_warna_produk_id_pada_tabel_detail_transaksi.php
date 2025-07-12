<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->foreignId('jenis_warna_produk_id')
                ->nullable()
                ->constrained('jenis_warna_produk')
                ->onDelete('cascade')
                ->after('produk_id');
            $table->foreignId('ukuran_produk_id')
                ->nullable()
                ->constrained('ukuran_produk')
                ->onDelete('cascade')
                ->after('jenis_warna_produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropForeign(['jenis_warna_produk_id']);
            $table->dropColumn('jenis_warna_produk_id');
            $table->dropForeign(['ukuran_produk_id']);
            $table->dropColumn('ukuran_produk_id');
        });
    }
};
