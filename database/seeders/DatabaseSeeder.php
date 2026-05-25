<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Kurikulum;
use App\Models\Eservice;
use App\Models\Keunggulan;
use App\Models\Kontak;
use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean seeding
        Schema::disableForeignKeyConstraints();

        // 1. Seed User
        User::truncate();
        User::create([
            'nama'     => 'Admin Konfigin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // 2. Seed Settings
        Setting::truncate();
        $settings = [
            'hero_title'         => 'Solusi Aplikasi Seminggu Jadi Untuk Corporate & Pemerintahan',
            'hero_subtitle'      => 'Konfigin IT Solutions menghadirkan pengembangan aplikasi kustom premium dan instalasi jaringan handal berlisensi sekali putus—kepemilikan penuh selamanya tanpa biaya langganan bulanan.',
            'profil_text'        => "Konfigin IT Solutions berdiri dengan visi untuk menjadi mitra teknologi andalan bagi sekolah, bisnis, dan institusi. Kami berfokus pada penyediaan solusi infrastruktur jaringan yang aman dan andal, serta pengembangan produk perangkat lunak custom yang efisien.\n\nDengan tim ahli bersertifikasi industri, kami berkomitmen menghadirkan layanan berkualitas tinggi tanpa biaya langganan bulanan yang membingungkan. Skema lisensi sekali putus kami memastikan Anda memiliki kepemilikan penuh atas sistem IT Anda secara permanen.",
            'instagram_username' => 'konfigin.it',
            'site_name'          => 'Konfigin IT Solutions',
            'site_tagline'       => 'Smart Network & Premium Custom Web Development',
            'site_logo'          => 'assets/img/konfigin-logo.png',
            'theme_primary_color'   => '#0072ff',
            'theme_secondary_color' => '#00c6ff',
            'theme_border_radius'   => '20px',
            'client_logos'          => 'INDOMARET, PERTAMINA, KAI, PLN, BRI, TELKOM, BCA',
            'tech_stacks'           => 'html5, css3-alt, js, php, laravel, database, git-alt, node-js',
            'stat_about_1_num'      => '100+',
            'stat_about_1_lbl'      => 'Sukses Instalasi Jaringan',
            'stat_about_2_num'      => '100%',
            'stat_about_2_lbl'      => 'Kepemilikan Permanen (Sekali Putus)',
            'stat_about_3_num'      => '50+',
            'stat_about_3_lbl'      => 'Aplikasi Custom & Sistem',
            'stat_keunggulan_1_num' => '98%',
            'stat_keunggulan_1_lbl' => 'Kepuasan Klien Korporasi',
            'stat_keunggulan_2_num' => '99.9%',
            'stat_keunggulan_2_lbl' => 'Uptime Server & Jaringan',
            'stat_keunggulan_3_num' => '24/7',
            'stat_keunggulan_3_lbl' => 'Respon Cepat Tim Support',
            'comparison_rows'       => "Lisensi Kepemilikan | Sekali Putus (Lifetime) | Sekali Putus (Lifetime) | Sekali Putus (Lifetime) | Sekali Putus (Lifetime)\nJumlah Database User | 1 User | Unlimited Users | Unlimited Users | Unlimited Users\nFitur Inventaris & Stok | Dasar | Lengkap | Multi-Outlet | Custom Advanced\nLaporan Transaksi | check | check | check | check\nAbsensi & Payroll Karyawan | times | times | check | check\nIntegrasi Pembayaran (Midtrans) | times | times | times | check\nSource Code / Repositori | times | times | check | check\nSupport Teknis Purna Jual | 1 Bulan | 6 Bulan | 12 Bulan | Lifetime Prioritas\nHarga Lisensi Sekali Putus | Rp 2.000.000 | Rp 5.000.000 | Rp 10.000.000 | Custom Quote",
        ];
        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Seed Kurikulum (Repurposed for 4-Column Pricing Cards)
        Kurikulum::truncate();
        Kurikulum::create([
            'nama_mapel'  => 'Lisensi Personal',
            'modul_url'   => 'https://demo.konfigin.com/personal',
            'roadmap_url' => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20Paket%20Personal',
            'harga'       => 'Rp 2Jt',
            'badge'       => null,
            'fitur'       => "1 Database User\nFitur POS Kasir Dasar\nLaporan Bulanan Ringkas\nUpdate Sistem 1 Bulan\n- Integrasi Printer Thermal",
            'urutan'      => 1,
            'aktif'       => 1,
        ]);
        Kurikulum::create([
            'nama_mapel'  => 'Lisensi UKM / Startup',
            'modul_url'   => 'https://demo.konfigin.com/ukm',
            'roadmap_url' => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20Paket%20UKM%20Populer',
            'harga'       => 'Rp 5Jt',
            'badge'       => 'Populer',
            'fitur'       => "Unlimited Users\nFitur POS Kasir Lengkap\nIntegrasi Printer Thermal\nManajemen Inventaris UKM\nUpdate Sistem 6 Bulan",
            'urutan'      => 2,
            'aktif'       => 1,
        ]);
        Kurikulum::create([
            'nama_mapel'  => 'Lisensi Business',
            'modul_url'   => 'https://demo.konfigin.com/business',
            'roadmap_url' => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20Paket%20Business',
            'harga'       => 'Rp 10Jt',
            'badge'       => null,
            'fitur'       => "Sistem Multi-Outlet / Cabang\nFitur HRIS & Payroll Karyawan\nLaporan Pajak & Keuangan\nEnkripsi Database SSL\nUpdate Sistem 12 Bulan",
            'urutan'      => 3,
            'aktif'       => 1,
        ]);
        Kurikulum::create([
            'nama_mapel'  => 'Lisensi Enterprise',
            'modul_url'   => 'https://demo.konfigin.com/enterprise',
            'roadmap_url' => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20Paket%20Enterprise',
            'harga'       => 'Custom',
            'badge'       => null,
            'fitur'       => "Kustomisasi Fitur Total\nIntegrasi API Pihak Ketiga\nGaransi Sistem Lifetime\nPendampingan Server Fisik\nSupport Prioritas 24/7",
            'urutan'      => 4,
            'aktif'       => 1,
        ]);

        // 4. Seed Eservice (6 Services)
        Eservice::truncate();
        Eservice::create([
            'nama'      => 'Instalasi Jaringan Kabel & Fiber Optik',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20ingin%20tanya%20layanan%20Instalasi%20Jaringan',
            'deskripsi' => 'Pemasangan kabel terstruktur CAT6, fiber optik antar-gedung, serta merapikan rack server sekolah atau kantor Anda.',
            'icon'      => 'fas fa-network-wired',
            'warna'     => '#0072ff',
            'urutan'    => 1,
            'aktif'     => 1,
        ]);
        Eservice::create([
            'nama'      => 'Custom Web & Core System Development',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20ingin%20tanya%20layanan%20Custom%20Web',
            'deskripsi' => 'Pengembangan core system, SaaS, ERP, CRM, portal akademik, hingga web korporat yang disesuaikan dengan alur bisnis Anda.',
            'icon'      => 'fas fa-code',
            'warna'     => '#00c6ff',
            'urutan'    => 2,
            'aktif'     => 1,
        ]);
        Eservice::create([
            'nama'      => 'Setup & Konfigurasi Mikrotik / Cisco',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20ingin%20tanya%20layanan%20Setup%20Router',
            'deskripsi' => 'Manajemen bandwidth, failover multi-ISP, VPN inter-koneksi, routing dinamis, dan sistem voucher internet hotspot.',
            'icon'      => 'fas fa-server',
            'warna'     => '#3b82f6',
            'urutan'    => 3,
            'aktif'     => 1,
        ]);
        Eservice::create([
            'nama'      => 'Sistem Keamanan & Cyber Security',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20ingin%20tanya%20layanan%20Keamanan%20Jaringan',
            'deskripsi' => 'Audit celah keamanan, konfigurasi firewall terpusat, mitigasi serangan DDoS, serta SSL/TLS certificate enforcement.',
            'icon'      => 'fas fa-shield-alt',
            'warna'     => '#ef4444',
            'urutan'    => 4,
            'aktif'     => 1,
        ]);
        Eservice::create([
            'nama'      => 'Integrasi API & Payment Gateway',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20ingin%20tanya%20layanan%20Integrasi%20API',
            'deskripsi' => 'Integrasi sistem billing dengan Midtrans/Xendit, pengiriman notifikasi otomatis via WhatsApp API, serta sinkronisasi data.',
            'icon'      => 'fas fa-credit-card',
            'warna'     => '#10b981',
            'urutan'    => 5,
            'aktif'     => 1,
        ]);
        Eservice::create([
            'nama'      => 'Lisensi Software Sekali Putus (Lifetime)',
            'url'       => 'https://wa.me/6281234567890?text=Halo%20Konfigin,%20saya%20tertarik%20membeli%20software%20sekali%20putus',
            'deskripsi' => 'Sistem POS kasir, HRIS, absensi, atau aplikasi kustom dengan kepemilikan penuh selamanya tanpa tagihan bulanan.',
            'icon'      => 'fas fa-key',
            'warna'     => '#f59e0b',
            'urutan'    => 6,
            'aktif'     => 1,
        ]);

        // 5. Seed Keunggulan (8 Advantages)
        Keunggulan::truncate();
        Keunggulan::create([
            'icon'      => 'fas fa-wallet',
            'judul'     => 'Lisensi Sekali Putus',
            'deskripsi' => 'Sekali bayar untuk selamanya. Tidak ada biaya langganan bulanan tersembunyi yang memberatkan finansial bisnis Anda.',
            'urutan'    => 1,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-user-check',
            'judul'     => 'Tim Ahli Bersertifikasi',
            'deskripsi' => 'Dikerjakan oleh profesional bersertifikasi industri (MikroTik MTCNA/MTCRE, Cisco CCNA, Senior Developer).',
            'urutan'    => 2,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-project-diagram',
            'judul'     => 'Instalasi Terstandarisasi',
            'deskripsi' => 'Struktur pengkabelan, dokumentasi jaringan, dan penataan server dilakukan secara rapi dengan standar industri.',
            'urutan'    => 3,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-bolt',
            'judul'     => 'Pengerjaan Cepat (Seminggu Jadi)',
            'deskripsi' => 'Metodologi agile development kami memungkinkan sistem dasar atau prototipe siap digunakan hanya dalam waktu seminggu.',
            'urutan'    => 4,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-lock',
            'judul'     => 'Keamanan Enkripsi Tinggi',
            'deskripsi' => 'Proteksi berlapis pada database dan lalu lintas enkripsi SSL/TLS tingkat tinggi untuk menjamin keamanan data klien.',
            'urutan'    => 5,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-shield-alt',
            'judul'     => 'Garansi Sistem 100%',
            'deskripsi' => 'Kami menjamin kelancaran operasional IT Anda dengan garansi perbaikan sistem tanpa tambahan biaya purna jual.',
            'urutan'    => 6,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-file-alt',
            'judul'     => 'Dokumentasi Lengkap',
            'deskripsi' => 'Anda akan mendapatkan topologi jaringan resmi, manual book, dan repository kode sumber untuk kepemilikan penuh.',
            'urutan'    => 7,
            'aktif'     => 1,
        ]);
        Keunggulan::create([
            'icon'      => 'fas fa-headset',
            'judul'     => 'Layanan Purna Jual Cepat',
            'deskripsi' => 'Layanan bantuan teknis dan konsultasi pengembangan pasca-instalasi yang sigap menangani pertanyaan Anda.',
            'urutan'    => 8,
            'aktif'     => 1,
        ]);

        // 6. Seed Kontak
        Kontak::truncate();
        Kontak::create([
            'email'       => 'info@konfigin.com',
            'whatsapp'    => '0812-3456-7890',
            'website'     => 'www.konfigin.com',
            'alamat'      => 'Jalan IT Solutions No. 42, Kota Digital, Indonesia',
            'maps_embed'  => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126743.58585978184!2d107.5731165!3d-6.9034443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a50b0efdd48a5!2sBandung%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);

        // 7. Seed Galeri (Portfolio)
        Galeri::truncate();
        Galeri::create([
            'judul'         => 'Konfigin POS & Inventory System',
            'foto_url'      => 'uploads/img_69ce1fccafb99.png',
            'instagram_url' => 'Custom Web Application',
            'urutan'        => 1,
            'aktif'         => 1,
        ]);
        Galeri::create([
            'judul'         => 'Konfigin HRIS & Payroll Automation',
            'foto_url'      => 'uploads/img_69ce27df3c174.png',
            'instagram_url' => 'Core Business System',
            'urutan'        => 2,
            'aktif'         => 1,
        ]);
        Galeri::create([
            'judul'         => 'Pemasangan Fiber Optik & Hotspot Mikrotik',
            'foto_url'      => 'uploads/img_69ce1fccafb99.png',
            'instagram_url' => 'Network Infrastructure',
            'urutan'        => 3,
            'aktif'         => 1,
        ]);
        Galeri::create([
            'judul'         => 'Sistem Administrasi Keuangan Pemerintah',
            'foto_url'      => 'uploads/img_69ce27df3c174.png',
            'instagram_url' => 'Corporate Portal',
            'urutan'        => 4,
            'aktif'         => 1,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
