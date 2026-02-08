<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index()
    {
        $pakets = Paket::latest()->paginate(10);
        return view('pages.admin.paket.index', compact('pakets'));
    }

    // 2. HALAMAN TAMBAH
    public function create()
    {
        return view('pages.admin.paket.create');
    }

    // 3. PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|string',
        ]);

        Paket::create($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket laundry berhasil ditambahkan!');
    }

    // 4. HALAMAN EDIT
    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('pages.admin.paket.edit', compact('paket'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|string',
        ]);

        $paket->update($request->all());

        return redirect()->route('paket.index')->with('success', 'Data paket berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        
        // Cek apakah paket sedang digunakan di transaksi (biar tidak error)
        if($paket->transaksis()->count() > 0) {
            return back()->with('error', 'Gagal! Paket ini sedang digunakan dalam transaksi.');
        }

        $paket->delete();
        return back()->with('success', 'Paket berhasil dihapus.');
    }
}