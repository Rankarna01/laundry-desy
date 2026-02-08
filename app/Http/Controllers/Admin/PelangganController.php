<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    // 1. DAFTAR PELANGGAN
    public function index()
    {
        // Hanya ambil user dengan role 'pengguna'
        $pelanggans = User::where('role', 'pengguna')->latest()->paginate(10);
        return view('pages.admin.pelanggan.index', compact('pelanggans'));
    }

    // 2. HALAMAN TAMBAH
    public function create()
    {
        return view('pages.admin.pelanggan.create');
    }

    // 3. PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna', // Paksa role jadi pengguna
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // 4. HALAMAN EDIT
    public function edit($id)
    {
        $pelanggan = User::findOrFail($id);
        return view('pages.admin.pelanggan.edit', compact('pelanggan'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $pelanggan = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'no_hp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan diperbarui!');
    }

    // 6. HAPUS
    public function destroy($id)
    {
        $pelanggan = User::findOrFail($id);
        
        // Cek apakah pelanggan punya transaksi (opsional, biar data aman)
        // if($pelanggan->transaksis()->count() > 0) {
        //    return back()->with('error', 'Gagal! Pelanggan ini memiliki riwayat transaksi.');
        // }

        $pelanggan->delete();
        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}