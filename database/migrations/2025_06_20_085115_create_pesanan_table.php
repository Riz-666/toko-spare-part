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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // FK nanti
            $table->string('kode_pesanan', 50)->unique();
            $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'selesai', 'dibatalkan']);
            $table->enum('metode_pembayaran', ['qris', 'kartu_kredit', 'dana', 'cod']);
            $table->decimal('total', 15, 2);
            $table->text('alamat_pengiriman');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
