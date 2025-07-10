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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->date('tgl_transaksi');
            $table->bigInteger('rekening_debit');
            $table->bigInteger('rekening_kredit');
            $table->bigInteger('user_id');
            $table->bigInteger('usage_id');
            $table->bigInteger('installation_id');
            $table->string('total');
            $table->string('transaction_id');
            $table->string('relasi');
            $table->string('keterangan');
            $table->bigInteger('urutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
