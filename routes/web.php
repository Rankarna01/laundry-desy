<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\ProsesController;
use App\Http\Controllers\Pengguna\DashboardController as PenggunaDashboard;
use App\Http\Controllers\Pengguna\PesanLaundryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. TAMU (BELUM LOGIN)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');
});

// 3. SUDAH LOGIN (SEMUA ROLE)
Route::middleware(['auth'])->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // DASHBOARD DISPATCHER (PENGARAH)
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        
        return match($role) {
            'admin'    => view('pages.admin.dashboard'),
            'karyawan' => app(KaryawanDashboard::class)->index(),
            'pengguna' => app(PenggunaDashboard::class)->index(),
            default    => abort(403),
        };
    })->name('dashboard');


    // ====================================================
    // AREA ADMIN (Hanya Admin)
    // ====================================================
    Route::middleware(['can:role,"admin"'])->group(function() {
        
        // Transaksi
        Route::controller(TransaksiController::class)->group(function () {
            Route::get('/transaksi', 'index')->name('transaksi.index');
            Route::get('/transaksi/baru', 'create')->name('transaksi.create');
            Route::post('/transaksi', 'store')->name('transaksi.store');
            Route::put('/transaksi/{id}', 'updateStatus')->name('transaksi.update');
            Route::delete('/transaksi/{id}', 'destroy')->name('transaksi.destroy');
        });

        // Pelanggan (Resource)
        Route::resource('pelanggan', PelangganController::class);

        // Paket (Resource)
        Route::resource('paket', PaketController::class);

        // Laporan
        Route::controller(LaporanController::class)->group(function() {
            Route::get('/laporan', 'index')->name('laporan.index');
            Route::get('/laporan/export', 'exportExcel')->name('laporan.export');
        });
    });


    // ====================================================
    // AREA KARYAWAN (Hanya Karyawan)
    // ====================================================
    Route::middleware(['can:role,"karyawan"'])->group(function() {
        
        Route::get('/karyawan/dashboard', [KaryawanDashboard::class, 'index'])->name('karyawan.dashboard');
        Route::put('/karyawan/status-cepat/{id}', [KaryawanDashboard::class, 'updateStatusCepat'])->name('karyawan.status_cepat');

        Route::get('/proses-cucian', [ProsesController::class, 'index'])->name('proses.index');
        Route::put('/proses-cucian/{id}', [ProsesController::class, 'updateStatus'])->name('proses.update');
    });


    // ====================================================
    // AREA PENGGUNA (Hanya Pelanggan)
    // ====================================================
    Route::middleware(['can:role,"pengguna"'])->group(function() {
        
        Route::get('/member/dashboard', [PenggunaDashboard::class, 'index'])->name('member.dashboard');

        // Pesan Laundry
        Route::controller(PesanLaundryController::class)->group(function() {
            Route::get('/pesan-laundry', 'create')->name('pesan.create'); // Kalau file kamu create.blade.php
            // Route::get('/pesan-laundry', 'index')->name('pesan.index'); // Kalau file kamu index.blade.php (pilih satu)
            Route::post('/pesan-laundry', 'store')->name('pesan.store');
        });

        Route::get('/riwayat', [\App\Http\Controllers\Pengguna\RiwayatController::class, 'index'])->name('riwayat.index');
    });

});