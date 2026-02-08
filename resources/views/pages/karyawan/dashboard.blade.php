@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Area Kerja Karyawan</h1>
        <p class="text-slate-500 text-sm">Selamat bekerja, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>! Semangat!</p>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <x-card-stat 
            title="Masuk Hari Ini" 
            value="{{ $masukHariIni }}" 
            icon="fa-solid fa-basket-shopping" 
            color="blue" 
            subtext="Orderan baru"
        />

        <x-card-stat 
            title="Antrian Pending" 
            value="{{ $antrianPending }}" 
            icon="fa-solid fa-clock" 
            color="red" 
            subtext="Belum disentuh"
        />

        <x-card-stat 
            title="Sedang Diproses" 
            value="{{ $sedangProses }}" 
            icon="fa-solid fa-shirt" 
            color="yellow" 
            subtext="Mesin berputar"
        />

        <x-card-stat 
            title="Siap Diambil" 
            value="{{ $siapDiambil }}" 
            icon="fa-solid fa-check-double" 
            color="green" 
            subtext="Menunggu pelanggan"
        />
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-500"></i>
                Daftar Cucian yang Harus Diproses
            </h3>
            <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                Prioritas: {{ $tugasCucian->count() }} Item
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-white border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Kode TRX</th>
                        <th class="px-6 py-3">Paket Layanan</th>
                        <th class="px-6 py-3">Berat</th>
                        <th class="px-6 py-3">Waktu Masuk</th>
                        <th class="px-6 py-3 text-center">Status Saat Ini</th>
                        <th class="px-6 py-3 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugasCucian as $tugas)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $tugas->kode_transaksi }}
                            <div class="text-xs font-normal text-slate-400">{{ $tugas->user->name }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs border border-slate-200">
                                {{ $tugas->paket->nama_paket }}
                            </span>
                        </td>

                        <td class="px-6 py-4 font-medium">{{ $tugas->berat }} Kg</td>

                        <td class="px-6 py-4 text-xs">
                            {{ $tugas->created_at->diffForHumans() }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($tugas->status_laundry == 'Pending')
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                    PENDING
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                    PROSES CUCI
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('karyawan.status_cepat', $tugas->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                @if($tugas->status_laundry == 'Pending')
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded shadow-md transition flex items-center justify-center gap-2 w-full">
                                        <i class="fa-solid fa-play"></i> Mulai Kerjakan
                                    </button>
                                @elseif($tugas->status_laundry == 'Proses')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded shadow-md transition flex items-center justify-center gap-2 w-full">
                                        <i class="fa-solid fa-check"></i> Selesai
                                    </button>
                                @endif
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-12">
                            <div class="flex flex-col items-center justify-center text-slate-300">
                                <i class="fa-solid fa-mug-hot text-5xl mb-4"></i>
                                <h3 class="text-lg font-semibold text-slate-500">Pekerjaan Beres!</h3>
                                <p class="text-sm">Tidak ada antrian cucian saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection