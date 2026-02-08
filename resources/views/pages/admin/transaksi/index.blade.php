@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Transaksi</h1>
            <p class="text-slate-500 text-sm">Kelola semua transaksi laundry</p>
        </div>
        <a href="{{ route('transaksi.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition flex items-center gap-2 transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i>
            <span>Transaksi Baru</span>
        </a>
    </div>

    @if(session('success')) <x-alert type="success" :message="session('success')" /> @endif

    <div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Layanan</th>
                        <th class="px-6 py-4">Tagihan</th>
                        <th class="px-6 py-4 text-center">Status Laundry</th>
                        <th class="px-6 py-4 text-center">Pembayaran</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transaksis as $trx)
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">#{{ $trx->kode_transaksi }}</div>
                            <div class="text-xs text-slate-400 mt-1">
                                <i class="fa-regular fa-calendar-days mr-1"></i>
                                {{ $trx->tgl_masuk->format('d M Y') }}
                            </div>
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $trx->user->name }}
                            <div class="text-xs text-slate-400 font-normal">{{ $trx->user->no_hp ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-slate-700 font-medium">{{ $trx->paket->nama_paket }}</span>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $trx->berat }} Kg</div>
                        </td>

                        <td class="px-6 py-4 font-bold text-slate-800">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $badgeClass = match($trx->status_laundry) {
                                    'Selesai' => 'bg-green-100 text-green-700 ring-1 ring-green-200',
                                    'Diambil' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                    'Dicuci'  => 'bg-yellow-100 text-yellow-700 ring-1 ring-yellow-200 animate-pulse',
                                    default   => 'bg-red-50 text-red-600 ring-1 ring-red-100' // Pending
                                };
                                $icon = match($trx->status_laundry) {
                                    'Selesai' => 'fa-check',
                                    'Diambil' => 'fa-bag-shopping',
                                    'Dicuci'  => 'fa-spin fa-spinner',
                                    default   => 'fa-clock'
                                };
                            @endphp
                            <span class="{{ $badgeClass }} px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5">
                                <i class="fa-solid {{ $icon }}"></i> {{ $trx->status_laundry }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $bayarClass = match($trx->status_bayar) {
                                    'Lunas' => 'text-green-600 bg-green-50 border border-green-100',
                                    'DP'    => 'text-orange-600 bg-orange-50 border border-orange-100',
                                    default => 'text-red-600 bg-red-50 border border-red-100'
                                };
                            @endphp
                            <span class="{{ $bayarClass }} px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wide">
                                {{ $trx->status_bayar }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                <a href="{{ route('transaksi.cetak', $trx->id) }}" target="_blank" 
                                   class="group relative w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm border border-indigo-100" 
                                   title="Cetak Struk">
                                    <i class="fa-solid fa-receipt"></i>
                                </a>

                                <button onclick="openModal('modalEdit{{ $trx->id }}')" 
                                    class="group relative w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-500 hover:text-white transition-all duration-200 shadow-sm border border-amber-100" 
                                    title="Update Status">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="group relative w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200 shadow-sm border border-red-100" 
                                        title="Hapus Data">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>

                            <x-modal id="modalEdit{{ $trx->id }}" title="Update #{{ $trx->kode_transaksi }}">
                                <form action="{{ route('transaksi.update', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    
                                    <div class="mb-4 text-left">
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Cucian</label>
                                        <select name="status_laundry" class="w-full border-slate-200 rounded-lg p-2.5 bg-slate-50 focus:ring-2 focus:ring-blue-100 outline-none">
                                            <option value="Pending" {{ $trx->status_laundry == 'Pending' ? 'selected' : '' }}>Pending (Baru Masuk)</option>
                                            <option value="Dicuci" {{ $trx->status_laundry == 'Dicuci' ? 'selected' : '' }}>Sedang Dicuci</option>
                                            <option value="Selesai" {{ $trx->status_laundry == 'Selesai' ? 'selected' : '' }}>Selesai (Siap Diambil)</option>
                                            <option value="Diambil" {{ $trx->status_laundry == 'Diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-6 text-left">
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pembayaran</label>
                                        <select name="status_bayar" class="w-full border-slate-200 rounded-lg p-2.5 bg-slate-50 focus:ring-2 focus:ring-blue-100 outline-none">
                                            <option value="Belum Bayar" {{ $trx->status_bayar == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                            <option value="DP" {{ $trx->status_bayar == 'DP' ? 'selected' : '' }}>DP (Down Payment)</option>
                                            <option value="Lunas" {{ $trx->status_bayar == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('modalEdit{{ $trx->id }}')" class="px-4 py-2 text-slate-500 hover:bg-slate-100 rounded-lg transition">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center p-8 text-slate-400">Belum ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-white border-t border-slate-100">{{ $transaksis->links() }}</div>
    </div>

@endsection