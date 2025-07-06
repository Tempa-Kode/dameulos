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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('kode_transaksi', 50)->unique();
            $table->enum('status', ['pending', 'dikonfirmasi', 'diproses', 'dikirim'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('catatan')->nullable();
            $table->text('alamat_pengiriman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
