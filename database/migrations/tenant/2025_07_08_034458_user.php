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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->string('telpon');
            $table->string('jabatan');
            $table->string('foto');
            $table->string('username');
            $table->string('password');
            $table->string('remember_token');
            $table->string('auth_token');
            $table->string('akses_menu');
            $table->string('akses_tombol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
