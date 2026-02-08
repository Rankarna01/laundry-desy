<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Filter Tanggal (Default: 1 Bulan Terakhir)
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // 2. Query Transaksi Berdasarkan Tanggal & Status Selesai/Diambil (Pendapatan Valid)
        // Kita anggap pendapatan sah jika status bayar = 'Lunas'
        $query = Transaksi::with(['user', 'paket'])
            ->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])
            ->where('status_bayar', 'Lunas');

        $transaksis = $query->latest()->get();

        // 3. Hitung KPI (Key Performance Indicators)
        $totalPendapatan = $transaksis->sum('total_harga');
        $totalTransaksi  = $transaksis->count();
        $totalBerat      = $transaksis->sum('berat');

        // 4. Siapkan Data Grafik (Pendapatan per Hari)
        // Grouping data by Date
        $grafikData = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d M'); // Format: 01 Jan
        });

        $labels = [];
        $data   = [];

        foreach ($grafikData as $key => $values) {
            $labels[] = $key;
            $data[]   = $values->sum('total_harga');
        }

        return view('pages.admin.laporan.index', compact(
            'transaksis', 'startDate', 'endDate', 
            'totalPendapatan', 'totalTransaksi', 'totalBerat',
            'labels', 'data'
        ));
    }

    // Export ke Excel (CSV Stream - Tanpa Library Tambahan)
    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $fileName  = 'laporan_laundry_' . $startDate . '_sd_' . $endDate . '.csv';

        $transaksis = Transaksi::with(['user', 'paket'])
            ->whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
            ->where('status_bayar', 'Lunas')
            ->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Tanggal', 'Kode Transaksi', 'Pelanggan', 'Paket', 'Berat (Kg)', 'Total Harga');

        $callback = function() use($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transaksis as $trx) {
                $row['Tanggal']        = $trx->created_at->format('d-m-Y');
                $row['Kode']           = $trx->kode_transaksi;
                $row['Pelanggan']      = $trx->user->name;
                $row['Paket']          = $trx->paket->nama_paket;
                $row['Berat']          = $trx->berat;
                $row['Total']          = $trx->total_harga;

                fputcsv($file, array($row['Tanggal'], $row['Kode'], $row['Pelanggan'], $row['Paket'], $row['Berat'], $row['Total']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}