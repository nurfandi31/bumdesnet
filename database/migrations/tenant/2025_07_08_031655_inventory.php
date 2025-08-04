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
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->string('nama_barang');
            $table->date('tgl_beli');
            $table->string('unit');
            $table->string('harsat');
            $table->string('umur_ekonomis');
            $table->bigInteger('jenis');
            $table->bigInteger('kategori');
            $table->string('status');
            $table->date('tgl_validasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
