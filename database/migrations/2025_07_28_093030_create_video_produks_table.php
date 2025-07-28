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
        Schema::create('video_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->onDelete('cascade');
            $table->string('link_video')
                ->comment('Link video produk, bisa dari YouTube atau platform lain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_produk');
    }
};
