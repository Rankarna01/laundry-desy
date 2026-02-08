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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique(); // TRX-001
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pelanggan
        $table->foreignId('paket_id')->constrained('pakets'); // Jenis Layanan
        $table->float('berat'); // Bisa desimal (misal 1.5 kg)
        $table->integer('total_harga');
        $table->enum('status_laundry', ['Pending', 'Proses', 'Selesai', 'Diambil'])->default('Pending');
        $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
