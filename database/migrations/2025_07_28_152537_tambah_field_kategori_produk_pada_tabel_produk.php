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
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'kategori_produk_id')) {
                $table->unsignedBigInteger('kategori_produk_id')->nullable()->after('katalog_id');
                $table->foreign('kategori_produk_id')
                    ->references('id')
                    ->on('kategori_produk')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['kategori_produk_id']);
            $table->dropColumn('kategori_produk_id');
        });
    }
};
