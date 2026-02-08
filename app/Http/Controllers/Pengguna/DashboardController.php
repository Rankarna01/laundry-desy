<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. STATISTIK (Khusus User Ini)
        $totalTransaksi   = Transaksi::where('user_id', $userId)->count();
        
        // Status Pending & Proses kita gabung jadi "Sedang Diproses"
        $sedangDiproses   = Transaksi::where('user_id', $userId)
                                     ->whereIn('status_laundry', ['Pending', 'Proses'])
                                     ->count();
                                     
        $siapDiambil      = Transaksi::where('user_id', $userId)
                                     ->where('status_laundry', 'Selesai')
                                     ->count();

        $totalPengeluaran = Transaksi::where('user_id', $userId)->sum('total_harga');

        // 2. RIWAYAT TERBARU (Ambil 5 data terakhir saja)
        $riwayatTerbaru   = Transaksi::with('paket')
                                     ->where('user_id', $userId)
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('pages.pengguna.dashboard', compact(
            'totalTransaksi', 
            'sedangDiproses', 
            'siapDiambil', 
            'totalPengeluaran',
            'riwayatTerbaru'
        ));
    }
}