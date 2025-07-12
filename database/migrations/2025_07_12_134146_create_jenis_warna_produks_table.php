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
        Schema::create('jenis_warna_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->onDelete('cascade');
            $table->string('warna', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_warna_produk');
    }
};
