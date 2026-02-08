@extends('layouts.app')

@section('title', 'Tambah Paket')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Buat Paket Baru</h1>
            <p class="text-slate-500 text-sm">Tambahkan jenis layanan laundry baru</p>
        </div>
        <a href="{{ route('paket.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-xl mx-auto">
        <form action="{{ route('paket.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Paket</label>
                <input type="text" name="nama_paket" required placeholder="Contoh: Cuci Komplit (Cuci + Setrika)" 
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga per Kg (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-400">Rp</span>
                        <input type="number" name="harga_per_kg" required placeholder="7000" 
                            class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Estimasi Waktu</label>
                    <input type="text" name="estimasi_waktu" required placeholder="Contoh: 2 Hari" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-md">
                Simpan Paket
            </button>
        </form>
    </div>

@endsection