<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK (Sesuaikan enum baru: 'Dicuci')
        $masukHariIni = Transaksi::whereDate('tgl_masuk', Carbon::today())->count();
        $sedangProses = Transaksi::where('status_laundry', 'Dicuci')->count(); // GANTI 'Proses' jadi 'Dicuci'
        $siapDiambil  = Transaksi::where('status_laundry', 'Selesai')->count();
        $antrianPending = Transaksi::where('status_laundry', 'Pending')->count();

        // 2. TABEL TUGAS (Pending & Dicuci)
        $tugasCucian = Transaksi::with(['user', 'paket'])
            ->whereIn('status_laundry', ['Pending', 'Dicuci']) // GANTI
            ->orderBy('tgl_masuk', 'asc') // Urutkan berdasarkan tgl_masuk
            ->get();

        return view('pages.karyawan.dashboard', compact(
            'masukHariIni', 'sedangProses', 'siapDiambil', 'antrianPending', 'tugasCucian'
        ));
    }

    public function updateStatusCepat(Request $request, $id)
    {
        $trx = Transaksi::findOrFail($id);
        
        // LOGIKA BARU: Pending -> Dicuci -> Selesai
        if ($trx->status_laundry == 'Pending') {
            $trx->update(['status_laundry' => 'Dicuci']); // Update status jadi Dicuci
            $pesan = 'Status berubah: SEDANG DICUCI.';
        } elseif ($trx->status_laundry == 'Dicuci') {
            $trx->update(['status_laundry' => 'Selesai']);
            $pesan = 'Cucian SELESAI dan Siap Diambil.';
        } else {
            return back(); 
        }

        return back()->with('success', $pesan);
    }
}