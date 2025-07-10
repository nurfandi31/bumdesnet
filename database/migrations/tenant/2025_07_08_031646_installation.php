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
        Schema::create('installations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->string('kode_instalasi');
            $table->bigInteger('customer_id');
            $table->bigInteger('cater_id');
            $table->bigInteger('package_id');
            $table->string('harga_paket');
            $table->string('koordinate');
            $table->string('desa');
            $table->string('alamat');
            $table->string('rw');
            $table->string('rt');
            $table->string('status');
            $table->string('status_tunggakan');
            $table->string('biaya_instalasi');
            $table->string('abodemen');
            $table->date('order');
            $table->date('pasang');
            $table->date('aktif');
            $table->date('blokir');
            $table->date('cabut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installatins');
    }
};
