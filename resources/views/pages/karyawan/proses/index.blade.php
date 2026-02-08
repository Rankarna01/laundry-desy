@extends('layouts.app')

@section('title', 'Proses Cucian')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Proses Cucian</h1>
            <p class="text-slate-500 text-sm">Kelola antrian cucian yang masuk</p>
        </div>
        <div class="flex gap-3">
            <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-full border border-slate-200 shadow-sm">
                <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-slate-600">Pending</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-full border border-slate-200 shadow-sm">
                <div class="w-3 h-3 rounded-full bg-yellow-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-slate-600">Sedang Proses</span>
            </div>
        </div>
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
                        <th class="px-6 py-3">Waktu Masuk</th>
                        <th class="px-6 py-3">Kode / Pelanggan</th>
                        <th class="px-6 py-3">Detail Paket</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $item)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-medium">{{ $item->created_at->format('H:i') }}</div>
                            <div class="text-xs text-slate-400">{{ $item->created_at->format('d M Y') }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $item->kode_transaksi }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->user->name }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-semibold text-blue-600">{{ $item->paket->nama_paket }}</div>
                            <div class="text-xs text-slate-500">Berat: {{ $item->berat }} Kg</div>
                            @if($item->keterangan)
                                <div class="mt-1 text-xs bg-yellow-50 text-yellow-700 p-1 rounded border border-yellow-200 inline-block">
                                    <i class="fa-solid fa-note-sticky mr-1"></i> {{ $item->keterangan }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($item->status_laundry == 'Pending')
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                                    PENDING
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200 animate-pulse">
                                    SEDANG DICUCI
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            
                            @if($item->status_laundry == 'Pending')
                                <form action="{{ route('proses.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Proses">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto w-32">
                                        <i class="fa-solid fa-play"></i> Mulai
                                    </button>
                                </form>
                            @elseif($item->status_laundry == 'Proses')
                                <button onclick="openModal('modalSelesai{{ $item->id }}')" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto w-32">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </button>
                            @endif

                            <x-modal id="modalSelesai{{ $item->id }}" title="Konfirmasi Selesai">
                                <div class="text-center mb-6">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                                        <i class="fa-solid fa-shirt text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Cucian Selesai?</h3>
                                    <p class="text-slate-500 text-sm mt-2">
                                        Pastikan pakaian sudah dicuci, dikeringkan, disetrika, dan dipacking rapi dengan kode 
                                        <span class="font-bold text-slate-800">{{ $item->kode_transaksi }}</span>.
                                    </p>
                                </div>
                                <form action="{{ route('proses.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Selesai">
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeModal('modalSelesai{{ $item->id }}')" class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 font-medium transition">
                                            Batal
                                        </button>
                                        <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium shadow-lg transition">
                                            Ya, Sudah Rapi
                                        </button>
                                    </div>
                                </form>
                            </x-modal>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-slate-300">
                                <i class="fa-solid fa-clipboard-check text-6xl mb-4"></i>
                                <h3 class="text-lg font-semibold text-slate-500">Semua Beres!</h3>
                                <p class="text-sm">Tidak ada antrian cucian yang perlu diproses.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-white border-t border-slate-100">
            {{ $antrian->links() }}
        </div>
    </div>

@endsection