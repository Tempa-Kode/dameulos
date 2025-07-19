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
        Schema::create('kode_warna_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_warna_id')->constrained('request_warna')->onDelete('cascade');
            $table->string('kode_warna', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_warna_request');
    }
};
