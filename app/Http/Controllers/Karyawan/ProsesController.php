<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    // TAMPILKAN DAFTAR CUCIAN (Pending & Proses)
    public function index()
    {
        // Kita ambil data yang statusnya 'Pending' (Masuk) atau 'Proses' (Sedang Dicuci)
        // Yang sudah 'Selesai' atau 'Diambil' tidak perlu muncul di sini agar list bersih.
        $antrian = Transaksi::with(['user', 'paket'])
            ->whereIn('status_laundry', ['Pending', 'Proses'])
            ->orderBy('created_at', 'asc') // Yang lama di atas (FIFO)
            ->paginate(10);

        return view('pages.karyawan.proses.index', compact('antrian'));
    }

    // UPDATE STATUS (Action)
    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Validasi perubahan status agar urut
        if ($request->status == 'Proses' && $transaksi->status_laundry == 'Pending') {
            $transaksi->update(['status_laundry' => 'Proses']);
            $msg = 'Status berhasil diubah: Sedang Dicuci.';
        } 
        elseif ($request->status == 'Selesai' && $transaksi->status_laundry == 'Proses') {
            $transaksi->update(['status_laundry' => 'Selesai']);
            $msg = 'Cucian selesai! Silakan simpan di rak pengambilan.';
        } 
        else {
            return back()->with('error', 'Alur status tidak valid!');
        }

        return back()->with('success', $msg);
    }
}