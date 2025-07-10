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
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('describe');
            $table->string('desa');
            $table->text('alamat');
            $table->string('telpon');
            $table->string('nomor_bh');
            $table->string('email');
            $table->string('domain');
            $table->date('tgl_pakai');
            $table->string('logo');
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
