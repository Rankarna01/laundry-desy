<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function index()
    {
        // Ambil antrian Pending & Dicuci
        $antrian = Transaksi::with(['user', 'paket'])
            ->whereIn('status_laundry', ['Pending', 'Dicuci'])
            ->orderBy('tgl_masuk', 'asc')
            ->paginate(10);

        return view('pages.karyawan.proses.index', compact('antrian'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Validasi Alur: Pending -> Dicuci -> Selesai
        if ($request->status == 'Dicuci' && $transaksi->status_laundry == 'Pending') {
            $transaksi->update(['status_laundry' => 'Dicuci']);
            $msg = 'Mulai mencuci... Semangat!';
        } 
        elseif ($request->status == 'Selesai' && $transaksi->status_laundry == 'Dicuci') {
            $transaksi->update(['status_laundry' => 'Selesai']);
            $msg = 'Cucian selesai! Pindahkan ke rak pengambilan.';
        } 
        else {
            return back()->with('error', 'Alur status tidak valid!');
        }

        return back()->with('success', $msg);
    }
}