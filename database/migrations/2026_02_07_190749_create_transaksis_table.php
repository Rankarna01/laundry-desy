<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique(); // Contoh: LND-001
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('paket_id')->constrained('pakets');
            
            // --- KOLOM BARU SESUAI GAMBAR ---
            $table->date('tgl_masuk');   // Input manual tanggal masuk
            $table->date('tgl_selesai'); // Estimasi selesai
            
            $table->float('berat');
            $table->integer('total_harga');
            $table->text('catatan')->nullable();
            
            // Status disesuaikan dengan gambar (Dicuci, Diambil, dll)
            $table->enum('status_laundry', ['Pending', 'Dicuci', 'Selesai', 'Diambil'])->default('Pending');
            $table->enum('status_bayar', ['Lunas', 'Belum Bayar', 'DP'])->default('Belum Bayar');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};