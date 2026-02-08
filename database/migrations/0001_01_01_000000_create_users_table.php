<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Lengkap
            $table->string('username')->unique(); // UNTUK LOGIN
            $table->string('password');
            $table->string('no_hp')->nullable(); // No Telepon
            $table->string('email')->unique()->nullable(); // Email (Opsional buat login, tapi ada di data)
            $table->text('alamat')->nullable(); // Alamat
            $table->enum('role', ['admin', 'karyawan', 'pengguna'])->default('pengguna');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};