@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Cucian</h1>
            <p class="text-slate-500 text-sm">Lacak semua pesanan laundry Anda di sini</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pesan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-2 text-sm">
                <i class="fa-solid fa-plus"></i> Pesan Baru
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Tanggal & Kode</th>
                        <th class="px-6 py-3">Layanan Paket</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Total Biaya</th>
                        <th class="px-6 py-3 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $trx)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $trx->kode_transaksi }}</div>
                            <div class="text-xs text-slate-400 flex items-center gap-1 mt-1">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-semibold text-blue-600">{{ $trx->paket->nama_paket }}</div>
                            <div class="text-xs text-slate-500">{{ $trx->berat }} Kg</div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClass = match($trx->status_laundry) {
                                    'Pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    'Proses' => 'bg-yellow-100 text-yellow-700 border-yellow-200 animate-pulse',
                                    'Selesai' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'Diambil' => 'bg-green-100 text-green-700 border-green-200',
                                };
                                $icon = match($trx->status_laundry) {
                                    'Pending' => 'fa-clock',
                                    'Proses' => 'fa-spinner fa-spin',
                                    'Selesai' => 'fa-check-circle',
                                    'Diambil' => 'fa-bag-shopping',
                                };
                            @endphp
                            <span class="{{ $statusClass }} border px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-2">
                                <i class="fa-solid {{ $icon }}"></i>
                                {{ $trx->status_laundry }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="font-bold text-slate-800">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                            @if($trx->status_bayar == 'Lunas')
                                <span class="text-[10px] text-green-600 font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-check"></i> Lunas
                                </span>
                            @else
                                <span class="text-[10px] text-red-500 font-bold uppercase tracking-wide">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button onclick="openModal('modalDetail{{ $trx->id }}')" class="text-slate-400 hover:text-blue-600 transition p-2 rounded-full hover:bg-blue-50">
                                <i class="fa-solid fa-circle-info text-xl"></i>
                            </button>

                            <x-modal id="modalDetail{{ $trx->id }}" title="Detail Pesanan">
                                <div class="text-left space-y-4">
                                    
                                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                        <div>
                                            <p class="text-xs text-slate-400 uppercase">Kode Transaksi</p>
                                            <p class="font-bold text-slate-800">{{ $trx->kode_transaksi }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-slate-400 uppercase">Tanggal</p>
                                            <p class="font-bold text-slate-800">{{ $trx->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-slate-50 p-4 rounded-lg space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Paket Layanan</span>
                                            <span class="font-semibold">{{ $trx->paket->nama_paket }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Harga per Kg</span>
                                            <span>Rp {{ number_format($trx->paket->harga_per_kg) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Berat Cucian</span>
                                            <span>{{ $trx->berat }} Kg</span>
                                        </div>
                                        <div class="border-t border-slate-200 pt-2 flex justify-between items-center mt-2">
                                            <span class="font-bold text-slate-800">Total Tagihan</span>
                                            <span class="font-bold text-blue-600 text-lg">Rp {{ number_format($trx->total_harga) }}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400 uppercase mb-2">Status Pesanan</p>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-slate-100 h-2 rounded-full overflow-hidden">
                                                @php
                                                    $width = match($trx->status_laundry) {
                                                        'Pending' => '25%',
                                                        'Proses' => '50%',
                                                        'Selesai' => '75%',
                                                        'Diambil' => '100%',
                                                    };
                                                    $color = match($trx->status_laundry) {
                                                        'Pending' => 'bg-slate-400',
                                                        'Proses' => 'bg-yellow-400',
                                                        'Selesai' => 'bg-blue-500',
                                                        'Diambil' => 'bg-green-500',
                                                    };
                                                @endphp
                                                <div class="h-full {{ $color }}" style="width: {{ $width }}"></div>
                                            </div>
                                            <span class="text-xs font-bold text-slate-700">{{ $trx->status_laundry }}</span>
                                        </div>
                                        @if($trx->status_laundry == 'Selesai')
                                            <p class="text-xs text-green-600 mt-2 bg-green-50 p-2 rounded border border-green-100">
                                                <i class="fa-solid fa-bell"></i> Hore! Cucian sudah bersih dan wangi. Silakan diambil di outlet.
                                            </p>
                                        @endif
                                    </div>

                                    @if($trx->keterangan)
                                    <div class="border-t border-slate-100 pt-3">
                                        <p class="text-xs text-slate-400 uppercase">Catatan Anda</p>
                                        <p class="text-sm text-slate-600 italic">"{{ $trx->keterangan }}"</p>
                                    </div>
                                    @endif
                                    
                                </div>
                                
                                <x-slot name="footer">
                                    <button onclick="closeModal('modalDetail{{ $trx->id }}')" class="w-full py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium">
                                        Tutup
                                    </button>
                                </x-slot>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-12">
                            <div class="flex flex-col items-center justify-center text-slate-300">
                                <i class="fa-solid fa-clock-rotate-left text-5xl mb-4"></i>
                                <h3 class="text-lg font-semibold text-slate-500">Belum Ada Riwayat</h3>
                                <p class="text-sm mb-4">Anda belum pernah melakukan pesanan laundry.</p>
                                <a href="{{ route('pesan.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition shadow-md">
                                    Mulai Pesan Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-white border-t border-slate-100">
            {{ $riwayats->links() }}
        </div>
    </div>

@endsection