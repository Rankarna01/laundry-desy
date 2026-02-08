@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')

    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Area Kerja Karyawan</h1>
            <p class="text-slate-500 text-sm">Halo, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>! Semangat bekerja.</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-xs text-slate-400">Tanggal Hari Ini</p>
            <p class="font-bold text-slate-700">{{ date('d F Y') }}</p>
        </div>
    </div>

    @if(session('success')) <x-alert type="success" :message="session('success')" /> @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-card-stat title="Masuk Hari Ini" value="{{ $masukHariIni }}" icon="fa-solid fa-basket-shopping" color="blue" subtext="Orderan baru" />
        <x-card-stat title="Antrian Pending" value="{{ $antrianPending }}" icon="fa-solid fa-clock" color="red" subtext="Belum dicuci" />
        <x-card-stat title="Sedang Dicuci" value="{{ $sedangProses }}" icon="fa-solid fa-shirt" color="yellow" subtext="Mesin berputar" />
        <x-card-stat title="Siap Diambil" value="{{ $siapDiambil }}" icon="fa-solid fa-check-double" color="green" subtext="Rak pengambilan" />
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-500"></i>
                Antrian Prioritas (Deadline Terdekat)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-white border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">ID & Pelanggan</th>
                        <th class="px-6 py-3">Paket & Berat</th>
                        <th class="px-6 py-3">Estimasi Selesai</th> <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugasCucian as $tugas)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">#{{ $tugas->kode_transaksi }}</div>
                            <div class="text-xs text-slate-500">{{ $tugas->user->name }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="block font-medium text-slate-700">{{ $tugas->paket->nama_paket }}</span>
                            <span class="text-xs text-slate-400">{{ $tugas->berat }} Kg</span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-medium">
                                <i class="fa-regular fa-calendar-check mr-1"></i>
                                {{ $tugas->tgl_selesai->format('d M Y') }}
                            </div>
                            @if($tugas->tgl_selesai->isToday())
                                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold">DEADLINE HARI INI!</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($tugas->status_laundry == 'Pending')
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-red-100">
                                    PENDING
                                </span>
                            @else
                                <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-yellow-100 animate-pulse">
                                    DICUCI
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('karyawan.status_cepat', $tugas->id) }}" method="POST">
                                @csrf @method('PUT')
                                
                                @if($tugas->status_laundry == 'Pending')
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-md transition w-full flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-play"></i> Mulai Cuci
                                    </button>
                                @elseif($tugas->status_laundry == 'Dicuci')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-md transition w-full flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-check"></i> Selesai
                                    </button>
                                @endif
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-8 text-slate-400">
                            <i class="fa-solid fa-mug-hot text-3xl mb-2"></i>
                            <p>Tidak ada antrian cucian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection