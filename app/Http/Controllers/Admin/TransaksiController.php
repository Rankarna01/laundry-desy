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
    // ... method index dll ...

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'paket_id' => 'required',
            'berat' => 'required|numeric|min:1',
            'tgl_masuk' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_masuk',
            'status_bayar' => 'required',
        ]);

        // Hitung Total
        $paket = Paket::find($request->paket_id);
        $total_harga = $paket->harga_per_kg * $request->berat;

        // Generate Kode: LND + Random Angka (Contoh: LND8392)
        $kode = 'LND' . rand(1000, 9999);

        Transaksi::create([
            'kode_transaksi' => $kode,
            'user_id' => $request->user_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'tgl_masuk' => $request->tgl_masuk,     // Input dari form
            'tgl_selesai' => $request->tgl_selesai, // Input dari form
            'total_harga' => $total_harga,
            'status_laundry' => 'Pending',          // Default awal
            'status_bayar' => $request->status_bayar,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
    }

    // ... method updateStatus dan destroy tetap sama ...
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

    public function cetakStruk($id)
    {
        $trx = Transaksi::with(['user', 'paket'])->findOrFail($id);
        return view('pages.admin.transaksi.struk', compact('trx'));
    }
}