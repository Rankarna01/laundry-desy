@extends('layouts.app')

@section('title', 'Form Transaksi Baru')

@section('content')

    <h1 class="text-xl font-bold text-slate-700 mb-6">Form Transaksi Baru</h1>

    <div class="bg-white p-6 rounded shadow-sm border border-slate-200">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Pelanggan</label>
                        <select name="user_id" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->username }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Layanan</label>
                        <select name="paket_id" id="paket_id" onchange="hitung()" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                            <option value="">Pilih Jenis Layanan</option>
                            @foreach($pakets as $paket)
                                <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_per_kg }}">{{ $paket->nama_paket }} - Rp {{ $paket->harga_per_kg }}/kg</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Estimasi Selesai</label>
                        <input type="date" name="tgl_selesai" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Berat (kg)</label>
                        <input type="number" name="berat" id="berat" step="0.01" value="0" oninput="hitung()" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Pembayaran</label>
                        <select name="status_bayar" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500">
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="DP">DP (Down Payment)</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Harga</label>
                <input type="text" id="display_total" value="Rp 0" readonly class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded text-sm font-bold text-slate-700">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan</label>
                <textarea name="catatan" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded text-sm focus:outline-none focus:border-slate-500" placeholder="Catatan tambahan (opsional)"></textarea>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 rounded hover:bg-slate-900 transition">
                [SIMPAN] Simpan Transaksi
            </button>
        </form>
    </div>

    <script>
        function hitung() {
            let paket = document.getElementById('paket_id');
            let berat = document.getElementById('berat').value;
            let harga = 0;

            if(paket.selectedIndex > 0) {
                harga = paket.options[paket.selectedIndex].getAttribute('data-harga');
            }

            let total = harga * berat;
            document.getElementById('display_total').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>

@endsection