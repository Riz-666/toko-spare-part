<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Produk → Kategori
        Schema::table('produk', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });

        // Keranjang → User
        Schema::table('keranjang', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });

        // Keranjang Item → Keranjang & Produk
        Schema::table('keranjang_item', function (Blueprint $table) {
            $table->foreign('keranjang_id')->references('id')->on('keranjang')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });

        // Pesanan → User
        Schema::table('pesanan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });

        // Pesanan Item → Pesanan & Produk
        Schema::table('pesanan_item', function (Blueprint $table) {
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });

        // Pembayaran → Pesanan
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
        });

        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('keranjang_item', function (Blueprint $table) {
            $table->dropForeign(['keranjang_id']);
            $table->dropForeign(['produk_id']);
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('pesanan_item', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
            $table->dropForeign(['produk_id']);
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
        });
    }
};

