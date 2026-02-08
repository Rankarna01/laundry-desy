@extends('layouts.app')

@section('title', 'Dashboard Admin - Laundry Desy')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Overview</h1>
            <p class="text-slate-500 text-sm">Selamat Datang, <span class="text-blue-600 font-semibold">{{ Auth::user()->name ?? 'Administrator' }}</span>!</p>
        </div>
        
        <div class="flex gap-2">
            <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm hover:bg-slate-50 transition shadow-sm">
                <i class="fa-solid fa-download mr-1"></i> Unduh Laporan
            </button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition shadow-md">
                <i class="fa-solid fa-plus mr-1"></i> Transaksi Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <x-card-stat 
            title="Total Transaksi" 
            value="0" 
            icon="fa-solid fa-clipboard-list" 
            color="blue" 
            subtext="Transaksi masuk hari ini"
        />

        <x-card-stat 
            title="Cucian Selesai" 
            value="3" 
            icon="fa-solid fa-check-circle" 
            color="green" 
            subtext="Siap untuk diambil"
        />

        <x-card-stat 
            title="Dalam Proses" 
            value="2" 
            icon="fa-solid fa-spinner" 
            color="yellow" 
            subtext="Sedang dikerjakan"
        />

        <x-card-stat 
            title="Pendapatan" 
            value="Rp 0" 
            icon="fa-solid fa-wallet" 
            color="indigo" 
            subtext="Estimasi pendapatan hari ini"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Transaksi Terbaru</h3>
                <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Berat</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">Budi Santoso</td>
                            <td class="px-6 py-4">3 Kg</td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Proses</span>
                            </td>
                            <td class="px-6 py-4">Rp 15.000</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-900">Siti Aminah</td>
                            <td class="px-6 py-4">5 Kg</td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                            </td>
                            <td class="px-6 py-4">Rp 25.000</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                <i class="fa-solid fa-box-open text-2xl mb-2"></i>
                                <p>Belum ada transaksi hari ini</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-700 mb-4">Status Outlet</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-sm text-slate-600">Sistem Online</span>
                    </div>
                    <i class="fa-solid fa-wifi text-slate-300"></i>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-users text-blue-500"></i>
                        <span class="text-sm text-slate-600">Total Pelanggan</span>
                    </div>
                    <span class="font-bold text-slate-800">128</span>
                </div>

                <div class="mt-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-3">Pintasan</h4>
                    <button onclick="openModal('modalCetak')" class="w-full text-left flex items-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded transition">
                        <i class="fa-solid fa-print w-5 text-center"></i> Cetak Laporan Harian
                    </button>
                    <button class="w-full text-left flex items-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded transition">
                        <i class="fa-solid fa-user-plus w-5 text-center"></i> Tambah Pelanggan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-modal id="modalCetak" title="Cetak Laporan">
        <p class="text-slate-600 mb-4">Apakah Anda ingin mencetak laporan transaksi untuk hari ini?</p>
        <x-slot name="footer">
            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                Cetak PDF
            </button>
            <button type="button" onclick="closeModal('modalCetak')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Batal
            </button>
        </x-slot>
    </x-modal>

@endsection