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
        Schema::create('master_arus_kas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_akun')->nullable();
            $table->string('debit')->nullable();
            $table->string('kredit')->nullable();
            $table->bigInteger('parent_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_arus_kas');
    }
};
