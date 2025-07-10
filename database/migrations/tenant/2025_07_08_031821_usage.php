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
        Schema::create('usages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->date('tgl_pemakaian');
            $table->bigInteger('id_instalasi');
            $table->string('kode_instalasi');
            $table->string('customer');
            $table->string('awal');
            $table->string('akhir');
            $table->string('jumlah');
            $table->string('nominal');
            $table->date('tgl_akhir');
            $table->bigInteger('cater');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usages');
    }
};
