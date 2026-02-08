<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';
    
    protected $fillable = [
        'nama_paket',
        'harga_per_kg',
        'estimasi_waktu', // Misal: "2 Hari", "6 Jam"
    ];

    // Relasi ke Transaksi (Opsional, untuk cek sebelum hapus)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}