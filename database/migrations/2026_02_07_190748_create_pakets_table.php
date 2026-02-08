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
    Schema::create('pakets', function (Blueprint $table) {
        $table->id();
        $table->string('nama_paket'); // Misal: Cuci Komplit, Cuci Kering
        $table->integer('harga_per_kg');
        $table->string('estimasi_waktu')->nullable(); // Misal: 2 Hari
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
