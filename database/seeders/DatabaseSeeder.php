<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Paket;
use App\Models\Transaksi;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. BUAT USER UTAMA (Login pakai Username)
        // ==========================================
        
        // ID: 1 - Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin', 
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890',
            'alamat' => 'Kantor Pusat Laundry',
            'email' => 'admin@laundry.com'
        ]);

        // ID: 2 - Karyawan
        User::create([
            'name' => 'Karyawan Satu',
            'username' => 'karyawan', 
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'no_hp' => '089876543210',
            'alamat' => 'Mess Karyawan No. 2',
            'email' => 'staff@laundry.com'
        ]);

        // ID: 3 - Pelanggan Utama
        $pengguna = User::create([
            'name' => 'Randy Pelanggan',
            'username' => 'randy123', 
            'password' => Hash::make('password'),
            'role' => 'pengguna',
            'no_hp' => '085678901234',
            'alamat' => 'Jl. Mawar No. 10',
            'email' => 'randy@gmail.com'
        ]);

        // ID: 4 s/d 8 - Buat 5 Pelanggan Dummy Tambahan
        // Kita buat manual agar tidak error jika Factory belum diupdate
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Pelanggan Dummy ' . $i,
                'username' => 'user' . $i, // user1, user2, dst
                'password' => Hash::make('password'),
                'role' => 'pengguna',
                'no_hp' => '08123456700' . $i,
                'alamat' => 'Jl. Contoh No. ' . $i,
                'email' => 'user' . $i . '@example.com'
            ]);
        }


        // ==========================================
        // 2. BUAT PAKET LAUNDRY
        // ==========================================
        $p1 = Paket::create(['nama_paket' => 'Cuci Komplit (Reguler)', 'harga_per_kg' => 7000, 'estimasi_waktu' => '2 Hari']);
        $p2 = Paket::create(['nama_paket' => 'Cuci Kering (Setrika Saja)', 'harga_per_kg' => 5000, 'estimasi_waktu' => '1 Hari']);
        $p3 = Paket::create(['nama_paket' => 'Cuci Kilat (Express)', 'harga_per_kg' => 12000, 'estimasi_waktu' => '6 Jam']);
        $p4 = Paket::create(['nama_paket' => 'Bed Cover (Satuan)', 'harga_per_kg' => 25000, 'estimasi_waktu' => '3 Hari']);


        // ==========================================
        // 3. BUAT TRANSAKSI DUMMY
        // ==========================================
        
        // Transaksi 1: Selesai & Lunas
        Transaksi::create([
            'kode_transaksi' => 'LND001',
            'user_id' => $pengguna->id, // ID 3
            'paket_id' => $p1->id,
            'tgl_masuk' => Carbon::now()->subDays(2),
            'tgl_selesai' => Carbon::now(),
            'berat' => 3,
            'total_harga' => 21000,
            'status_laundry' => 'Selesai',
            'status_bayar' => 'Lunas',
            'catatan' => 'Wangi vanilla, lipat rapi',
        ]);

        // Transaksi 2: Sedang Dicuci & Belum Bayar
        Transaksi::create([
            'kode_transaksi' => 'LND002',
            'user_id' => $pengguna->id, // ID 3
            'paket_id' => $p3->id,
            'tgl_masuk' => Carbon::now()->subDay(),
            'tgl_selesai' => Carbon::now()->addDay(),
            'berat' => 2,
            'total_harga' => 24000,
            'status_laundry' => 'Dicuci',
            'status_bayar' => 'Belum Bayar',
            'catatan' => 'Butuh cepat besok pagi',
        ]);

        // Transaksi 3: Loop Acak (ID 4-8)
        for ($i = 4; $i <= 10; $i++) { 
            $randomPaket = rand(1, 4);
            $harga = match($randomPaket) {
                1 => 7000,
                2 => 5000,
                3 => 12000,
                4 => 25000,
            };
            
            $berat = rand(2, 5);
            $tglMasuk = Carbon::now()->subDays(rand(1, 10));
            
            Transaksi::create([
                'kode_transaksi' => 'LND00' . $i, // Format LND004, LND005, dst
                'user_id' => rand(4, 8), // Mengambil user dummy yg kita buat di atas
                'paket_id' => $randomPaket,
                'tgl_masuk' => $tglMasuk,
                'tgl_selesai' => $tglMasuk->copy()->addDays(2), // Estimasi 2 hari setelah masuk
                'berat' => $berat,
                'total_harga' => $berat * $harga,
                'status_laundry' => 'Selesai', // Default dummy selesai biar grafik bagus
                'status_bayar' => 'Lunas',
                'catatan' => '-',
            ]);
        }
    }
}