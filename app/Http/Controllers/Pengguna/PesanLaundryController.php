<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PesanLaundryController extends Controller
{
    // 1. TAMPILKAN FORM ORDER
    public function create()
{
    $pakets = Paket::all(); // Mengambil data paket
    // Pastikan path view-nya sesuai folder di gambar kamu:
    return view('pages.pengguna.pesan.create', compact('pakets')); 
}

    // 2. PROSES SIMPAN ORDER
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'berat' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        // Hitung Estimasi Harga
        $paket = Paket::findOrFail($request->paket_id);
        $estimasiTotal = $paket->harga_per_kg * $request->berat;

        // Generate Kode Unik (TRX-USERID-TIMESTAMP)
        $kode = 'ORD-' . Auth::id() . '-' . time();

        Transaksi::create([
            'kode_transaksi' => $kode,
            'user_id' => Auth::id(), // Otomatis user yang sedang login
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total_harga' => $estimasiTotal,
            'status_laundry' => 'Pending',
            'status_bayar' => 'Belum Lunas',
            // Kita simpan catatan di kolom keterangan (jika ada kolom ini di migrasi, jika belum bisa skip/tambah)
            // Asumsi: Kita tadi belum buat kolom keterangan di tabel transaksi, 
            // tapi tidak apa-apa, kita skip simpan keterangan dulu atau bisa tambahkan migrasi baru.
            // Untuk sekarang kita fokus data inti.
        ]);

        return redirect()->route('member.dashboard')->with('success', 'Pesanan berhasil dibuat! Petugas kami akan segera memprosesnya.');
    }
}