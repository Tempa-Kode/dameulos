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
        Schema::table('transaksi', function (Blueprint $table) {
            // Change the length of 'subtotal' and 'total' columns to 20
            $table->decimal('subtotal', 15, 2)->change();
            $table->decimal('total', 15, 2)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->change();
            $table->decimal('total', 10, 2)->change();
        });
    }
};
