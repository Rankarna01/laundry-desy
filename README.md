# 🧺 Laundry Desy - Sistem Informasi Manajemen Laundry

Sistem Informasi Manajemen Laundry berbasis web yang dibangun menggunakan **Laravel 10**. Aplikasi ini dirancang untuk mempermudah operasional bisnis laundry mulai dari pencatatan transaksi, pelacakan status cucian oleh pelanggan, hingga laporan keuangan otomatis.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/laravel-v10.x-red)
![Tailwind](https://img.shields.io/badge/tailwind-v3.x-cyan)

## 🚀 Fitur Utama

### 👑 Administrator (Owner)
* **Dashboard Statistik:** Melihat total pendapatan, jumlah transaksi, dan berat cucian secara real-time.
* **Manajemen Transaksi:** CRUD Transaksi lengkap dengan hitung otomatis & input tanggal manual.
* **Cetak Struk:** Fitur cetak struk thermal/kertas biasa per transaksi.
* **Manajemen Data:** Mengelola Data Pelanggan dan Jenis Paket Layanan (Satuan/Kiloan).
* **Laporan Keuangan:** Grafik pendapatan bulanan dan Export laporan ke Excel/PDF.

### 👔 Karyawan (Staff)
* **Workflow Cucian:** Mengelola status cucian dari *Pending* -> *Dicuci* -> *Selesai* -> *Diambil*.
* **Prioritas Kerja:** Notifikasi visual untuk cucian yang mendekati deadline (Estimasi Selesai).
* **Aksi Cepat:** Tombol *One-Click* untuk mengubah status cucian di dashboard.

### 👤 Pelanggan (Member)
* **Registrasi & Login:** Akun member menggunakan Username/Password.
* **Order Online:** Melakukan pemesanan/booking cucian dengan estimasi harga.
* **Riwayat Transaksi:** Melihat status cucian (Tracking) dan rincian biaya.
* **Cek Harga:** Melihat daftar harga paket terbaru.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 10 (PHP 8.1+)
* **Frontend:** Blade Templates
* **Styling:** Tailwind CSS (via CDN)
* **Database:** MySQL
* **Icons:** FontAwesome 6
* **Charts:** Chart.js

---

## 💻 Cara Instalasi (Langkah demi Langkah)

Ikuti langkah ini untuk menjalankan project di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone [https://github.com/username-anda/laundry-desy.git](https://github.com/username-anda/laundry-desy.git)
cd laundry-desy

2. Install DependenciesPastikan Anda sudah menginstall PHP dan Composer.Bashcomposer install
3. Konfigurasi EnvironmentDuplikat file .env.example menjadi .env.Bashcp .env.example .env
Buka file .env dan atur koneksi database Anda:Cuplikan kodeDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry_db  # Pastikan buat database ini di phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=
4. Generate App KeyBashphp artisan key:generate
5. Migrasi Database & Seeder (PENTING!)Perintah ini akan membuat tabel dan mengisi data dummy (Akun Admin, Paket, Transaksi Contoh) agar aplikasi siap pakai.Bashphp artisan migrate:fresh --seed
6. Jalankan ServerBashphp artisan serve
Buka browser dan akses: http://127.0.0.1:8000