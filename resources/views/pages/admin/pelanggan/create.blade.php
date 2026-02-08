@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Pelanggan Baru</h1>
            <p class="text-slate-500 text-sm">Isi form di bawah ini</p>
        </div>
        <a href="{{ route('pelanggan.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-2xl mx-auto">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp / HP</label>
                    <input type="number" name="no_hp" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Default</label>
                <input type="text" name="password" value="12345678" required class="w-full px-4 py-2 bg-slate-100 border rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-slate-500">
                <p class="text-xs text-slate-400 mt-1">*Bisa diganti user nanti. Default: 12345678</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                Simpan Pelanggan
            </button>
        </form>
    </div>

@endsection