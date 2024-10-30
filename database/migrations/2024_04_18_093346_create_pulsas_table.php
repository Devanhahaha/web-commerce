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
        Schema::create('pulsas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained();
            $table->string('nama');
            $table->string('no_telp');
            $table->string('tipe_kartu');
            $table->integer('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pulsas');
    }
};
