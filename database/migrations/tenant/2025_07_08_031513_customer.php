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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->string('nama');
            $table->string('nama_panggilan')->nullable();
            $table->string('nik')->nullable();
            $table->string('jk')->nullable();
            $table->text('alamat');
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir');
            $table->string('pekerjaan')->nullable();
            $table->string('hp')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('petugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
