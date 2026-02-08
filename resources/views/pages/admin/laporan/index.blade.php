@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')

    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-100 print:hidden">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            
            <div class="w-full md:w-auto">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 outline-none text-slate-600">
            </div>

            <div class="w-full md:w-auto">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-100 outline-none text-slate-600">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition shadow-md">
                <i class="fa-solid fa-filter mr-2"></i> Tampilkan
            </button>
            
            <div class="flex-1 text-right gap-2 flex justify-end">
                <a href="{{ route('laporan.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition shadow-md">
                    <i class="fa-solid fa-file-excel mr-2"></i> Excel
                </a>
                
                <button onclick="window.print()" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg transition shadow-md">
                    <i class="fa-solid fa-print mr-2"></i> Cetak / PDF
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Pendapatan</p>
            <h4 class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
            <p class="text-xs text-green-600 mt-1"><i class="fa-solid fa-arrow-up"></i> Periode ini</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Transaksi Lunas</p>
            <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalTransaksi }}</h4>
            <p class="text-xs text-slate-400 mt-1">Transaksi selesai</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
            <p class="text-xs font-semibold text-slate-400 uppercase">Total Berat Cucian</p>
            <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalBerat }} Kg</h4>
            <p class="text-xs text-slate-400 mt-1">Total kilogram diproses</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 mb-8 print:break-inside-avoid">
        <h3 class="font-bold text-slate-700 mb-4">Grafik Pendapatan Harian</h3>
        <div class="relative h-72 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden print:shadow-none print:border-none">
        <div class="p-6 border-b border-slate-100 print:hidden">
            <h3 class="font-bold text-slate-700">Rincian Transaksi</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100 print:bg-white">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">No. Transaksi</th>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Paket</th>
                        <th class="px-6 py-3 text-right">Berat</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="bg-white border-b hover:bg-slate-50 print:border-slate-200">
                        <td class="px-6 py-3">{{ $trx->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3 font-bold text-slate-800">{{ $trx->kode_transaksi }}</td>
                        <td class="px-6 py-3">{{ $trx->user->name }}</td>
                        <td class="px-6 py-3">{{ $trx->paket->nama_paket }}</td>
                        <td class="px-6 py-3 text-right">{{ $trx->berat }} Kg</td>
                        <td class="px-6 py-3 text-right font-bold text-slate-800">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-8 text-slate-400">Tidak ada data transaksi lunas pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transaksis->count() > 0)
                <tfoot class="bg-slate-50 font-bold text-slate-800 print:bg-white">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right uppercase">Grand Total</td>
                        <td class="px-6 py-3 text-right">{{ $totalBerat }} Kg</td>
                        <td class="px-6 py-3 text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="hidden print:block text-center mt-8 text-xs text-slate-400">
        Dicetak pada: {{ date('d M Y H:i') }} oleh Administrator Sistem Laundry Desy.
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Konfigurasi Grafik
    const ctx = document.getElementById('revenueChart');

    // Data dari Controller (Blade directive)
    const labels = @json($labels);
    const dataValues = @json($data);

    new Chart(ctx, {
        type: 'line', // Jenis grafik: Line Chart
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dataValues,
                borderWidth: 2,
                borderColor: '#3b82f6', // Warna Garis (Blue-500)
                backgroundColor: 'rgba(59, 130, 246, 0.1)', // Warna Arsiran bawah garis
                pointBackgroundColor: '#1e293b',
                pointBorderColor: '#fff',
                fill: true,
                tension: 0.3 // Kelengkungan garis
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        // Format Rupiah di Sumbu Y
                        callback: function(value, index, values) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Sembunyikan legenda default
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>

<style>
    @media print {
        /* Sembunyikan Sidebar, Navbar, dan Filter saat Print */
        aside, header, form, .no-print {
            display: none !important;
        }
        /* Lebarkan konten utama */
        main {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        /* Hapus background warna */
        body {
            background: white !important;
        }
        /* Pastikan grafik tercetak */
        canvas {
            max-height: 300px !important;
        }
    }
</style>
@endpush