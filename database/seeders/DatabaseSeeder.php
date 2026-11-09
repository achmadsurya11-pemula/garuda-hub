<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Dummy Users (1 Admin, 3 Klien, 4 Developer)
        $defaultPassword = Hash::make('password123'); // Password demo untuk login

        $users = [
            ['id' => 1, 'nama' => 'Admin Garuda',    'email' => 'admin@example.com',  'password' => $defaultPassword, 'role' => 'admin',     'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Budi Santoso',    'email' => 'budi@example.com',   'password' => $defaultPassword, 'role' => 'klien',     'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Siti Rahayu',     'email' => 'siti@example.com',   'password' => $defaultPassword, 'role' => 'klien',     'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Agus Wijaya',     'email' => 'agus@example.com',   'password' => $defaultPassword, 'role' => 'klien',     'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'Dewi Lestari',    'email' => 'dewi@example.com',   'password' => $defaultPassword, 'role' => 'developer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nama' => 'Eko Prasetyo',     'email' => 'eko@example.com',    'password' => $defaultPassword, 'role' => 'developer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'nama' => 'Fitri Handayani', 'email' => 'fitri@example.com',  'password' => $defaultPassword, 'role' => 'developer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'nama' => 'Gilang Ramadhan', 'email' => 'gilang@example.com', 'password' => $defaultPassword, 'role' => 'developer', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('users')->insert($users);

        // 2. Data Dummy Projects (8 Proyek)
        $projects = [
            ['id' => 1, 'client_id' => 2, 'judul' => 'Website Toko Batik Online', 'deskripsi' => 'Membutuhkan toko online dengan katalog produk, keranjang, dan halaman kontak. Desain responsif.', 'kategori' => 'Web', 'budget_min' => 5000000, 'budget_max' => 10000000, 'batas_lelang' => '2027-12-31', 'status' => 'terbuka', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'client_id' => 2, 'judul' => 'Aplikasi Kasir Android', 'deskripsi' => 'Aplikasi kasir sederhana untuk warung: catat transaksi, laporan harian, cetak struk via Bluetooth.', 'kategori' => 'Mobile', 'budget_min' => 8000000, 'budget_max' => 15000000, 'batas_lelang' => '2027-11-30', 'status' => 'terbuka', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'client_id' => 3, 'judul' => 'Redesain Logo dan UI Kit', 'deskripsi' => 'Redesain identitas visual startup kuliner beserta UI kit untuk aplikasi pemesanan.', 'kategori' => 'Desain', 'budget_min' => 2000000, 'budget_max' => 4000000, 'batas_lelang' => '2026-09-01', 'status' => 'ditutup', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'client_id' => 3, 'judul' => 'Dashboard Analitik Penjualan', 'deskripsi' => 'Dashboard grafik penjualan bulanan dari file CSV, dengan filter per cabang dan ekspor laporan.', 'kategori' => 'Data', 'budget_min' => 6000000, 'budget_max' => 12000000, 'batas_lelang' => '2027-10-15', 'status' => 'terbuka', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'client_id' => 4, 'judul' => 'Chatbot Layanan Pelanggan', 'deskripsi' => 'Chatbot FAQ untuk situs sekolah, dapat dijawab dalam bahasa Indonesia.', 'kategori' => 'AI', 'budget_min' => 4000000, 'budget_max' => 8000000, 'batas_lelang' => '2026-08-20', 'status' => 'terbuka', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'client_id' => 4, 'judul' => 'Sistem Absensi Sekolah', 'deskripsi' => 'Sistem absensi siswa berbasis web dengan rekap per kelas dan laporan bulanan untuk wali kelas.', 'kategori' => 'Web', 'budget_min' => 7000000, 'budget_max' => 14000000, 'batas_lelang' => '2026-07-10', 'status' => 'ditutup', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'client_id' => 2, 'judul' => 'Migrasi Database ke MySQL', 'deskripsi' => 'Memindahkan data inventaris dari spreadsheet ke MySQL dan membuat skrip impor.', 'kategori' => 'Data', 'budget_min' => 3000000, 'budget_max' => 6000000, 'batas_lelang' => '2026-06-30', 'status' => 'ditutup', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'client_id' => 3, 'judul' => 'Landing Page Event Kampus', 'deskripsi' => 'Satu halaman informasi acara seminar teknologi dengan formulir pendaftaran sederhana.', 'kategori' => 'Web', 'budget_min' => 1500000, 'budget_max' => 3000000, 'batas_lelang' => '2027-09-01', 'status' => 'terbuka', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('projects')->insert($projects);

        // 3. Data Dummy Bids (15 Penawaran)
        $bids = [
            ['id' => 1,  'project_id' => 1, 'developer_id' => 5, 'harga' => 8500000,  'durasi' => 30, 'proposal' => 'Saya akan membangun dengan PHP dan MySQL, lengkap dengan panel admin produk.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,  'project_id' => 1, 'developer_id' => 6, 'harga' => 7000000,  'durasi' => 40, 'proposal' => 'Pengalaman 3 tahun membuat toko online. Termasuk pelatihan penggunaan.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3,  'project_id' => 1, 'developer_id' => 7, 'harga' => 9500000,  'durasi' => 25, 'proposal' => 'Desain premium bernuansa batik, dukungan perawatan 3 bulan.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4,  'project_id' => 2, 'developer_id' => 5, 'harga' => 12000000, 'durasi' => 45, 'proposal' => 'Aplikasi native Kotlin, dukungan printer Bluetooth termasuk.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5,  'project_id' => 2, 'developer_id' => 8, 'harga' => 10000000, 'durasi' => 50, 'proposal' => 'Memakai Flutter agar bisa juga dipakai di iOS nanti.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6,  'project_id' => 3, 'developer_id' => 6, 'harga' => 3000000,  'durasi' => 14, 'proposal' => 'Tiga konsep logo dan UI kit lengkap di Figma.', 'is_winner' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7,  'project_id' => 3, 'developer_id' => 7, 'harga' => 3500000,  'durasi' => 10, 'proposal' => 'Revisi tak terbatas selama 2 minggu.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8,  'project_id' => 4, 'developer_id' => 8, 'harga' => 9000000,  'durasi' => 35, 'proposal' => 'Dashboard dengan Chart dan ekspor PDF.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9,  'project_id' => 4, 'developer_id' => 5, 'harga' => 11000000, 'durasi' => 30, 'proposal' => 'Termasuk modul impor CSV otomatis.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'project_id' => 4, 'developer_id' => 6, 'harga' => 7500000,  'durasi' => 45, 'proposal' => 'Fokus pada grafik interaktif dan filter cabang.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'project_id' => 5, 'developer_id' => 7, 'harga' => 6000000,  'durasi' => 30, 'proposal' => 'Chatbot berbasis aturan dengan basis pengetahuan FAQ sekolah.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'project_id' => 6, 'developer_id' => 8, 'harga' => 11000000, 'durasi' => 40, 'proposal' => 'Sistem lengkap dengan rekap otomatis dan ekspor Excel.', 'is_winner' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'project_id' => 6, 'developer_id' => 5, 'harga' => 13000000, 'durasi' => 35, 'proposal' => 'Termasuk aplikasi pemindai kode QR untuk absensi.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'project_id' => 7, 'developer_id' => 6, 'harga' => 4500000,  'durasi' => 15, 'proposal' => 'Skrip impor dengan validasi data dan laporan galat.', 'is_winner' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'project_id' => 7, 'developer_id' => 7, 'harga' => 5000000,  'durasi' => 12, 'proposal' => 'Termasuk dokumentasi skema dan pelatihan singkat.', 'is_winner' => 0, 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('bids')->insert($bids);
    }
}
