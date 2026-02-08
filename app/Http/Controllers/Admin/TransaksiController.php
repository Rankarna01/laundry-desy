<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    // 1. TAMPILKAN DATA (READ)
    public function index()
    {
        // Ambil data transaksi terbaru dengan relasi user & paket
        $transaksis = Transaksi::with(['user', 'paket'])->latest()->paginate(10);
        
        return view('pages.admin.transaksi.index', compact('transaksis'));
    }

    // 2. HALAMAN TAMBAH (CREATE VIEW)
    public function create()
    {
        $pelanggans = User::where('role', 'pengguna')->get();
        $pakets = Paket::all();
        
        return view('pages.admin.transaksi.create', compact('pelanggans', 'pakets'));
    }

    // 3. PROSES SIMPAN (STORE)
    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'paket_id' => 'required|exists:pakets,id',
            'berat' => 'required|numeric|min:1',
        ]);

        // Ambil info paket untuk hitung harga
        $paket = Paket::findOrFail($request->paket_id);
        $total = $paket->harga_per_kg * $request->berat;

        // Generate Kode Unik (TRX + TIMESTAMP acak)
        $kode = 'TRX-' . time(); 

        Transaksi::create([
            'kode_transaksi' => $kode,
            'user_id' => $request->user_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total_harga' => $total, // Total hasil hitungan server (lebih aman)
            'status_laundry' => 'Pending',
            'status_bayar' => 'Belum Lunas',
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
    }
// UPDATE STATUS (EDIT via Modal)
    public function updateStatus(Request $request, $id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->update([
            'status_laundry' => $request->status_laundry,
            'status_bayar' => $request->status_bayar
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui!');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->delete();

        return back()->with('success', 'Data transaksi telah dihapus permanen.');
    }
}