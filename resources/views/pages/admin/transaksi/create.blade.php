@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Transaksi Baru</h1>
            <p class="text-slate-500 text-sm">Input data cucian masuk</p>
        </div>
        <a href="{{ route('transaksi.index') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="user_id" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Pelanggan</label>
                        <select name="user_id" id="user_id" required 
                            class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                            <option value="" disabled selected>-- Cari Nama Pelanggan --</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }} ({{ $pelanggan->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-400 mt-1">*Pastikan pelanggan sudah terdaftar.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div>
                            <label for="paket_id" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Paket</label>
                            <select name="paket_id" id="paket_id" required onchange="hitungTotal()"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                                <option value="" disabled selected>-- Pilih Layanan --</option>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_per_kg }}">
                                        {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_per_kg) }}/kg
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="berat" class="block text-sm font-semibold text-slate-700 mb-2">Berat (Kg)</label>
                            <input type="number" name="berat" id="berat" step="0.1" min="1" value="1" required oninput="hitungTotal()"
                                class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                                placeholder="Contoh: 1.5">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                            placeholder="Contoh: Baju putih jangan dicampur, butuh cepat..."></textarea>
                    </div>

                    <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Transaksi
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-6 rounded-lg transition">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-slate-800 text-white rounded-xl shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-semibold border-b border-slate-600 pb-4 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-slate-300 text-sm">
                        <span>Harga Paket /kg</span>
                        <span id="display_harga_paket">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-300 text-sm">
                        <span>Berat Total</span>
                        <span id="display_berat">0 Kg</span>
                    </div>
                    
                    <div class="border-t border-slate-600 pt-4 mt-4">
                        <div class="flex justify-between items-end">
                            <span class="font-semibold text-slate-200">Total Biaya</span>
                            <span class="text-3xl font-bold text-blue-400" id="display_total">Rp 0</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 text-right">*Belum termasuk biaya antar jemput jika ada.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-center opacity-20">
                    <i class="fa-solid fa-calculator text-8xl"></i>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function hitungTotal() {
        // 1. Ambil elemen
        let paketSelect = document.getElementById('paket_id');
        let beratInput = document.getElementById('berat');
        
        // 2. Ambil nilai (Harga diambil dari attribute data-harga)
        let hargaPerKg = 0;
        if(paketSelect.selectedIndex > 0) {
            hargaPerKg = paketSelect.options[paketSelect.selectedIndex].getAttribute('data-harga');
        }

        let berat = parseFloat(beratInput.value) || 0;

        // 3. Kalkulasi
        let total = hargaPerKg * berat;

        // 4. Update Tampilan (Format Rupiah)
        document.getElementById('display_harga_paket').innerText = formatRupiah(hargaPerKg);
        document.getElementById('display_berat').innerText = berat + ' Kg';
        document.getElementById('display_total').innerText = formatRupiah(total);
    }

    // Fungsi Helper Format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }
</script>
@endpush