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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksi')->onDelete('set null');
            $table->string('subjek');
            $table->text('pesan');
            $table->enum('kategori', ['produk', 'pengiriman', 'pembayaran', 'layanan', 'lainnya']);
            $table->enum('prioritas', ['rendah', 'normal', 'tinggi', 'urgent'])->default('normal');
            $table->enum('status', ['buka', 'dalam_proses', 'menunggu_pelanggan', 'selesai', 'ditutup'])->default('buka');
            $table->timestamp('last_response_at')->nullable();
            $table->enum('last_response_by', ['user', 'admin'])->nullable();
            $table->json('lampiran')->nullable(); // untuk menyimpan file attachment
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['kategori', 'prioritas']);
            $table->index('kode_tiket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};
