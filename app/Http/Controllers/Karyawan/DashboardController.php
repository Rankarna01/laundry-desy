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
        // 1. STATISTIK KARTU
        $masukHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
        $sedangProses = Transaksi::where('status_laundry', 'Proses')->count();
        $siapDiambil  = Transaksi::where('status_laundry', 'Selesai')->count();
        
        // Menunggu Diambil = Status 'Selesai' (Sama dengan Siap Diambil)
        // Atau kita bisa ganti jadi 'Antrian Pending' agar lebih informatif
        $antrianPending = Transaksi::where('status_laundry', 'Pending')->count();

        // 2. TABEL DAFTAR TUGAS (Cucian yang HARUS diproses)
        // Kita ambil yang statusnya 'Pending' atau 'Proses'
        // Diurutkan dari yang paling lama (Priority First)
        $tugasCucian = Transaksi::with(['user', 'paket'])
            ->whereIn('status_laundry', ['Pending', 'Proses'])
            ->orderBy('created_at', 'asc') 
            ->get();

        return view('pages.karyawan.dashboard', compact(
            'masukHariIni', 'sedangProses', 'siapDiambil', 'antrianPending', 'tugasCucian'
        ));
    }

    // Fitur Update Status Cepat dari Dashboard
    public function updateStatusCepat(Request $request, $id)
    {
        $trx = Transaksi::findOrFail($id);
        
        // Logika Tombol Cepat:
        // Jika Pending -> Ubah ke Proses
        // Jika Proses  -> Ubah ke Selesai
        
        if ($trx->status_laundry == 'Pending') {
            $trx->update(['status_laundry' => 'Proses']);
            $pesan = 'Status berubah menjadi SEDANG DIPROSES.';
        } elseif ($trx->status_laundry == 'Proses') {
            $trx->update(['status_laundry' => 'Selesai']);
            $pesan = 'Cucian SELESAI dan Siap Diambil.';
        } else {
            return back(); // Tidak melakukan apa-apa jika status lain
        }

        return back()->with('success', $pesan);
    }
}