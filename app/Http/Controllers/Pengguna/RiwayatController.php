<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil transaksi milik user yang sedang login
        // Urutkan dari yang terbaru
        $riwayats = Transaksi::with('paket')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.pengguna.riwayat.index', compact('riwayats'));
    }
}