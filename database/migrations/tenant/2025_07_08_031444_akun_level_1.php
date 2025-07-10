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
        Schema::create('akun_level_1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lev1');
            $table->string('lev2');
            $table->string('lev3');
            $table->string('lev4');
            $table->string('kode_akun');
            $table->string('nama_akun');
            $table->string('jenis_mutasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_level_1');
    }
};
