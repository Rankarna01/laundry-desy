@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pelanggan</h1>
            <p class="text-slate-500 text-sm">Data pengguna jasa laundry</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Kontak (Email/HP)</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $user)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-900 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-700">{{ $user->email }}</div>
                            <div class="text-xs text-slate-400">{{ $user->no_hp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 truncate max-w-xs">
                            {{ $user->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pelanggan.edit', $user->id) }}" class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 p-2 rounded transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
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
                        <td colspan="4" class="text-center p-8 text-slate-400">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-white border-t border-slate-100">
            {{ $pelanggans->links() }}
        </div>
    </div>

@endsection