@extends('layouts.app')

@section('title', 'Proses Cucian')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Workflow Cucian</h1>
            <p class="text-slate-500 text-sm">Kelola antrian dari Masuk sampai Selesai</p>
        </div>
        <div class="flex gap-3">
            <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-full border border-slate-200">
                <div class="w-2 h-2 rounded-full bg-red-500"></div><span class="text-xs font-bold text-slate-600">Pending</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-full border border-slate-200">
                <div class="w-2 h-2 rounded-full bg-yellow-500"></div><span class="text-xs font-bold text-slate-600">Dicuci</span>
            </div>
        </div>
    </div>

    @if(session('success')) <x-alert type="success" :message="session('success')" /> @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Deadline</th>
                        <th class="px-6 py-3">ID / Pelanggan</th>
                        <th class="px-6 py-3">Detail Paket</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $item)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-bold">{{ $item->tgl_selesai->format('d M') }}</div>
                            <div class="text-xs text-slate-400">{{ $item->tgl_selesai->format('Y') }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">#{{ $item->kode_transaksi }}</div>
                            <div class="text-xs text-slate-500">{{ $item->user->name }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-medium">{{ $item->paket->nama_paket }}</div>
                            <div class="text-xs text-slate-400">{{ $item->berat }} Kg</div>
                            @if($item->catatan)
                                <div class="mt-1 inline-block bg-orange-50 text-orange-600 px-2 py-0.5 rounded text-[10px] border border-orange-100">
                                    <i class="fa-solid fa-note-sticky mr-1"></i> {{ $item->catatan }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($item->status_laundry == 'Pending')
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-red-100">PENDING</span>
                            @else
                                <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-yellow-100 animate-pulse">SEDANG DICUCI</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            
                            @if($item->status_laundry == 'Pending')
                                <form action="{{ route('proses.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Dicuci"> <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition flex items-center justify-center gap-2 mx-auto w-32">
                                        <i class="fa-solid fa-play"></i> Mulai
                                    </button>
                                </form>
                            @elseif($item->status_laundry == 'Dicuci')
                                <button onclick="openModal('modalSelesai{{ $item->id }}')" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition flex items-center justify-center gap-2 mx-auto w-32">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </button>
                            @endif

                            <x-modal id="modalSelesai{{ $item->id }}" title="Konfirmasi Selesai">
                                <div class="text-center mb-6">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                                        <i class="fa-solid fa-shirt text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Cucian Selesai?</h3>
                                    <p class="text-slate-500 text-sm mt-2">Pastikan cucian #{{ $item->kode_transaksi }} sudah rapi dan siap diambil.</p>
                                </div>
                                <form action="{{ route('proses.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Selesai">
                                    <div class="flex gap-3">
                                        <button type="button" onclick="closeModal('modalSelesai{{ $item->id }}')" class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-lg font-medium">Batal</button>
                                        <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-lg font-medium shadow-lg hover:bg-green-700">Ya, Selesai</button>
                                    </div>
                                </form>
                            </x-modal>

                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-12 text-slate-400">Pekerjaan beres! Tidak ada antrian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-white border-t border-slate-100">{{ $antrian->links() }}</div>
    </div>

@endsection