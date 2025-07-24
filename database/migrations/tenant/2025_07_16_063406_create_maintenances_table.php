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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('pairing_id');
            $table->foreignId('installation_id');
            $table->foreignId('product_id')->nullable();
            $table->foreignId('product_variation_id')->nullable();
            $table->date('tgl_maintenance');
            $table->integer('harga');
            $table->integer('jumlah')->nullable();
            $table->integer('total');
            $table->string('status');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
