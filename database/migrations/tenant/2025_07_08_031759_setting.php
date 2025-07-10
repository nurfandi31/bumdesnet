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
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->integer('swit_tombol');
            $table->integer('swit_tombol_trx');
            $table->string('block');
            $table->string('abodemen');
            $table->string('pasang_baru');
            $table->string('denda');
            $table->integer('tanggal_toleransi');
            $table->integer('tanggal_hitung');
            $table->integer('batas_tagihan');
            $table->text('pesan_tagihan');
            $table->text('pesan_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
