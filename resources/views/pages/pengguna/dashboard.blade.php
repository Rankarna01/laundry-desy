@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-slate-500 text-sm">Selamat datang di Laundry Desy Member Area</p>
        </div>
        <a href="{{ route('pesan.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2 transform hover:-translate-y-1">
            <i class="fa-solid fa-plus-circle text-lg"></i>
            <span class="font-semibold">Pesan Laundry Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <x-card-stat 
            title="Total Transaksi Saya" 
            value="{{ $totalTransaksi }}" 
            icon="fa-solid fa-receipt" 
            color="indigo" 
            subtext="Semua riwayat cucian"
        />

        <x-card-stat 
            title="Sedang Diproses" 
            value="{{ $sedangDiproses }}" 
            icon="fa-solid fa-spinner" 
            color="yellow" 
            subtext="Menunggu selesai"
        />

        <x-card-stat 
            title="Siap Diambil" 
            value="{{ $siapDiambil }}" 
            icon="fa-solid fa-check-circle" 
            color="green" 
            subtext="Silakan datang ke outlet"
        />

        <x-card-stat 
            title="Total Pengeluaran" 
            value="Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}" 
            icon="fa-solid fa-wallet" 
            color="blue" 
            subtext="Akumulasi biaya"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Cucian Terakhir Saya</h3>
                <a href="{{ route('riwayat.index') }}" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th class="px-6 py-3">Tgl / Kode</th>
                            <th class="px-6 py-3">Paket</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatTerbaru as $trx)
                        <tr class="bg-white border-b hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $trx->kode_transaksi }}</div>
                                <div class="text-xs text-slate-400">{{ $trx->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $trx->paket->nama_paket }}
                                <div class="text-xs text-slate-400">{{ $trx->berat }} Kg</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($trx->status_laundry) {
                                        'Pending' => 'bg-slate-100 text-slate-600',
                                        'Proses' => 'bg-yellow-100 text-yellow-700 animate-pulse',
                                        'Selesai' => 'bg-blue-100 text-blue-700',
                                        'Diambil' => 'bg-green-100 text-green-700',
                                    };
                                @endphp
                                <span class="{{ $statusClass }} px-2.5 py-1 rounded text-xs font-bold">
                                    {{ $trx->status_laundry }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-slate-800">
                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-8 text-slate-400">
                                <i class="fa-solid fa-basket-shopping text-3xl mb-2"></i>
                                <p>Belum ada riwayat cucian.</p>
                                <a href="{{ route('pesan.create') }}" class="text-blue-500 text-xs mt-2 hover:underline">Yuk pesan sekarang!</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-slate-800 text-white rounded-xl shadow-lg p-6 bg-gradient-to-br from-slate-800 to-slate-900">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Status Outlet</p>
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            Buka Sekarang
                        </h3>
                    </div>
                    <i class="fa-solid fa-store text-2xl text-slate-600"></i>
                </div>
                <div class="text-sm text-slate-300 space-y-2 border-t border-slate-700 pt-4">
                    <div class="flex justify-between">
                        <span>Jam Buka:</span>
                        <span class="font-semibold text-white">08:00 - 21:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimasi Reguler:</span>
                        <span class="font-semibold text-white">2 Hari</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimasi Kilat:</span>
                        <span class="font-semibold text-white">6 Jam</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h4 class="font-bold text-slate-700 mb-2">Butuh Bantuan?</h4>
                <p class="text-sm text-slate-500 mb-4">Hubungi admin kami jika ada kendala pesanan.</p>
                <a href="#" class="block w-full text-center py-2 rounded-lg border border-green-500 text-green-600 hover:bg-green-50 transition">
                    <i class="fa-brands fa-whatsapp mr-2"></i> Chat Admin
                </a>
            </div>

        </div>

    </div>

@endsection