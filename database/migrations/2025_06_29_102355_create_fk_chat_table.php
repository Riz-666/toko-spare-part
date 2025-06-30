<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        

        //live chat
        Schema::table('chat', function (Blueprint $table) {
            $table->foreign('from_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        

        Schema::table('chat', function (Blueprint $table) {
            $table->dropForeign(['from_id']);
            $table->dropForeign(['to_id']);
        });
    }
};

