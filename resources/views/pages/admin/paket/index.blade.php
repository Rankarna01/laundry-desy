@extends('layouts.app')

@section('title', 'Daftar Paket Laundry')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Jenis Layanan & Harga</h1>
            <p class="text-slate-500 text-sm">Atur harga per kilogram di sini</p>
        </div>
        <a href="{{ route('paket.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Paket
        </a>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    
    @if(session('error'))
        <x-alert type="danger" :message="session('error')" />
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Nama Paket</th>
                        <th class="px-6 py-3">Harga / Kg</th>
                        <th class="px-6 py-3">Estimasi Waktu</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $paket)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <i class="fa-solid fa-box-archive text-blue-400 mr-2"></i>
                            {{ $paket->nama_paket }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">
                                Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <i class="fa-regular fa-clock text-slate-400 mr-1"></i>
                            {{ $paket->estimasi_waktu }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('paket.edit', $paket->id) }}" class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 p-2 rounded transition" title="Edit Harga">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <form action="{{ route('paket.destroy', $paket->id) }}" method="POST" onsubmit="return confirm('Yakin hapus paket ini? Transaksi lama mungkin akan kehilangan referensi nama paket.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 p-2 rounded transition" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center p-8 text-slate-400">
                            <i class="fa-solid fa-tags text-3xl mb-2"></i>
                            <p>Belum ada paket layanan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-white border-t border-slate-100">
            {{ $pakets->links() }}
        </div>
    </div>

@endsection