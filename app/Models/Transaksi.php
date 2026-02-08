<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = ['id'];

    // Relasi ke User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
