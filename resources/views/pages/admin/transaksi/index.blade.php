@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Transaksi</h1>
            <p class="text-slate-500 text-sm">Kelola semua transaksi laundry masuk</p>
        </div>
        <a href="{{ route('transaksi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Transaksi Baru
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
                        <th class="px-6 py-3">Kode & Tgl</th>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Paket</th>
                        <th class="px-6 py-3">Berat / Total</th>
                        <th class="px-6 py-3">Status Laundry</th>
                        <th class="px-6 py-3">Pembayaran</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="bg-white border-b hover:bg-slate-50 transition">
                        
                        <td class="px-6 py-4">
                            <span class="block font-bold text-slate-800">{{ $trx->kode_transaksi }}</span>
                            <span class="text-xs text-slate-400">{{ $trx->created_at->format('d M Y H:i') }}</span>
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $trx->user->name ?? 'Guest' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded border border-slate-200">
                                {{ $trx->paket->nama_paket }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-slate-800 font-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500">{{ $trx->berat }} Kg</div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($trx->status_laundry) {
                                    'Pending' => 'bg-slate-100 text-slate-600',
                                    'Proses' => 'bg-yellow-100 text-yellow-700',
                                    'Selesai' => 'bg-blue-100 text-blue-700',
                                    'Diambil' => 'bg-green-100 text-green-700',
                                };
                            @endphp
                            <span class="{{ $statusColor }} px-2.5 py-1 rounded text-xs font-semibold">
                                {{ $trx->status_laundry }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($trx->status_bayar == 'Lunas')
                                <span class="text-green-600 font-bold flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-check-circle"></i> Lunas
                                </span>
                            @else
                                <span class="text-red-500 font-bold flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-circle-xmark"></i> Belum
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModal('modalEdit{{ $trx->id }}')" class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 p-2 rounded transition" title="Update Status">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <a href="#" class="bg-blue-50 text-blue-600 hover:bg-blue-100 p-2 rounded transition" title="Cetak Struk">
                                    <i class="fa-solid fa-print"></i>
                                </a>

                                <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 p-2 rounded transition" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <x-modal id="modalEdit{{ $trx->id }}" title="Update Status: {{ $trx->kode_transaksi }}">
                                <form action="{{ route('transaksi.update', $trx->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4 text-left">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Laundry</label>
                                        <select name="status_laundry" class="w-full border-slate-300 rounded-lg p-2 bg-slate-50">
                                            <option value="Pending" {{ $trx->status_laundry == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Proses" {{ $trx->status_laundry == 'Proses' ? 'selected' : '' }}>Sedang Dicuci</option>
                                            <option value="Selesai" {{ $trx->status_laundry == 'Selesai' ? 'selected' : '' }}>Selesai / Siap</option>
                                            <option value="Diambil" {{ $trx->status_laundry == 'Diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                                        </select>
                                    </div>

                                    <div class="mb-6 text-left">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Pembayaran</label>
                                        <select name="status_bayar" class="w-full border-slate-300 rounded-lg p-2 bg-slate-50">
                                            <option value="Belum Lunas" {{ $trx->status_bayar == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                            <option value="Lunas" {{ $trx->status_bayar == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('modalEdit{{ $trx->id }}')" class="px-4 py-2 bg-slate-200 text-slate-700 rounded hover:bg-slate-300">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </x-modal>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-8 text-slate-400">
                            <i class="fa-solid fa-box-open text-3xl mb-2"></i>
                            <p>Belum ada data transaksi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-white border-t border-slate-100">
            {{ $transaksis->links() }}
        </div>
    </div>

@endsection