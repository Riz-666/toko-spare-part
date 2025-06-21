<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id'); // FK nanti
            $table->enum('metode', ['transfer_bank', 'cod', 'e-wallet']);
            $table->enum('status', ['belum dibayar', 'menunggu verifikasi', 'berhasil', 'gagal']);
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
