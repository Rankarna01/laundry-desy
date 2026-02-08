@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pesan Laundry Baru</h1>
            <p class="text-slate-500 text-sm">Isi detail cucianmu di bawah ini</p>
        </div>
        <a href="{{ route('member.dashboard') }}" class="text-slate-500 hover:text-blue-600 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded text-sm text-blue-700 flex items-start gap-3">
                    <i class="fa-solid fa-circle-info mt-1"></i>
                    <div>
                        <p class="font-bold">Informasi Penting:</p>
                        <p>Berat yang Anda masukkan adalah <strong>Estimasi</strong>. Berat akurat dan harga final akan dikonfirmasi ulang oleh petugas saat penimbangan di outlet.</p>
                    </div>
                </div>

                <form action="{{ route('pesan.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Layanan Paket</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($pakets as $paket)
                            <label class="cursor-pointer">
                                <input type="radio" name="paket_id" value="{{ $paket->id }}" class="peer sr-only" 
                                    data-harga="{{ $paket->harga_per_kg }}" 
                                    data-waktu="{{ $paket->estimasi_waktu }}"
                                    onchange="hitungEstimasi()" required>
                                
                                <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-blue-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex justify-between items-center mb-1">
                                        <h4 class="font-bold text-slate-800">{{ $paket->nama_paket }}</h4>
                                        <i class="fa-solid fa-check-circle text-blue-600 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 mb-2">Estimasi: {{ $paket->estimasi_waktu }}</p>
                                    <p class="font-bold text-blue-600">Rp {{ number_format($paket->harga_per_kg) }} /kg</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="berat" class="block text-sm font-semibold text-slate-700 mb-2">Perkiraan Berat (Kg)</label>
                        <div class="relative">
                            <input type="number" name="berat" id="berat" step="0.1" min="1" value="1" required oninput="hitungEstimasi()"
                                class="w-full pl-4 pr-12 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition text-lg font-bold text-slate-700">
                            <span class="absolute right-4 top-3.5 text-slate-400 font-semibold">Kg</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">*Minimal 1 Kg.</p>
                    </div>

                    <div class="mb-6">
                        <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Catatan / Alamat Jemput (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Contoh: Tolong jemput di alamat saya jam 10 pagi, atau pakaian putih dipisah..."
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5">
                        Buat Pesanan Sekarang
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-slate-800 text-white rounded-xl shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold border-b border-slate-600 pb-4 mb-4">Ringkasan Estimasi</h3>
                
                <div class="space-y-4 text-sm text-slate-300">
                    <div class="flex justify-between">
                        <span>Layanan</span>
                        <span class="font-semibold text-white" id="summary_paket">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Harga per Kg</span>
                        <span class="font-semibold text-white" id="summary_harga">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Berat</span>
                        <span class="font-semibold text-white" id="summary_berat">0 Kg</span>
                    </div>
                </div>

                <div class="border-t border-slate-600 pt-4 mt-6">
                    <p class="text-xs text-slate-400 mb-1">Total Estimasi Biaya</p>
                    <h2 class="text-3xl font-bold text-blue-400" id="summary_total">Rp 0</h2>
                </div>

                <div class="mt-6 bg-slate-700/50 p-3 rounded-lg text-xs text-slate-400 flex gap-2">
                    <i class="fa-solid fa-shield-halved mt-0.5"></i>
                    <p>Pembayaran dapat dilakukan tunai saat penyerahan barang atau pengambilan.</p>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function hitungEstimasi() {
        // 1. Ambil Paket yang Dipilih (Radio Button)
        let paketRadio = document.querySelector('input[name="paket_id"]:checked');
        let beratInput = document.getElementById('berat');
        
        let hargaPerKg = 0;
        let namaPaket = '-';

        if(paketRadio) {
            hargaPerKg = parseFloat(paketRadio.getAttribute('data-harga'));
            namaPaket = paketRadio.parentElement.querySelector('h4').innerText;
        }

        let berat = parseFloat(beratInput.value) || 0;
        let total = hargaPerKg * berat;

        // 2. Update Tampilan Ringkasan
        document.getElementById('summary_paket').innerText = namaPaket;
        document.getElementById('summary_harga').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(hargaPerKg);
        document.getElementById('summary_berat').innerText = berat + ' Kg';
        document.getElementById('summary_total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush