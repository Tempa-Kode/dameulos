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
        Schema::create('keluhan_balasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluhan_id')->constrained('keluhans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('pesan');
            $table->enum('dari', ['pelanggan', 'admin']);
            $table->boolean('is_internal')->default(false); // untuk catatan internal admin
            $table->json('lampiran')->nullable();
            $table->timestamps();

            $table->index(['keluhan_id', 'created_at']);
            $table->index(['user_id', 'dari']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan_balasans');
    }
};
