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
        Schema::create('jenis_laporan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('urut');
            $table->string('nama_laporan');
            $table->string('file');
            $table->string('awal_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_laporan');
    }
};
