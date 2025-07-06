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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                ->constrained('transaksi')
                ->onDelete('cascade');
            $table->string('nama_penerima', 50);
            $table->string('no_resi', 50)->unique();
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->integer('berat')->default(0);
            $table->text('alamat_pengiriman');
            $table->text('alamat_penerima');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
