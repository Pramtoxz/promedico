<?php
// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session()->start();
}
$role = session('role'); // pastikan key 'role' sesuai dengan session aplikasi Anda
?>

<!-- Tailwind CSS for Sidebar (if not already included) -->
<style>
    /* Custom CSS untuk sidebar modern */
    .sidebar-white {
        background: #ffffff;
        border-right: 1px solid rgba(32, 201, 151, 0.1);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
    }
    
    .sidebar-brand {
        background: #ffffff;
        border-bottom: 1px solid rgba(32, 201, 151, 0.1);
    }
    
    .nav-link-custom {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        margin: 2px 8px;
        color: #374151;
    }
    
    .nav-link-custom:hover {
        background: rgba(32, 201, 151, 0.08);
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(32, 201, 151, 0.1);
        color: #1f2937;
        text-decoration: none;
    }
    
    .nav-link-custom.active,
    .nav-link-custom.active:hover,
    .nav-link-custom.active:focus {
        background: linear-gradient(135deg, rgba(32, 201, 151, 0.2), rgba(27, 166, 140, 0.15)) !important;
        border-left: 4px solid #20C997 !important;
        font-weight: 600 !important;
        color: #20C997 !important;
        box-shadow: 0 2px 8px rgba(32, 201, 151, 0.15) !important;
    }
    
    /* Override Bootstrap/AdminLTE active styles */
    .nav-sidebar .nav-item .nav-link.active {
        background-color: rgba(32, 201, 151, 0.15) !important;
        color: #20C997 !important;
    }
    
    /* Force override semua kemungkinan style aktif */
    .main-sidebar .nav-sidebar .nav-item .nav-link.active,
    .main-sidebar .nav-sidebar .nav-item .nav-link.active:hover,
    .main-sidebar .nav-sidebar .nav-item .nav-link.active:focus,
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
    .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active,
    .nav-pills .nav-link.active {
        background-color: rgba(32, 201, 151, 0.15) !important;
        background: linear-gradient(135deg, rgba(32, 201, 151, 0.2), rgba(27, 166, 140, 0.15)) !important;
        color: #20C997 !important;
        border-left: 4px solid #20C997 !important;
        box-shadow: 0 2px 8px rgba(32, 201, 151, 0.15) !important;
    }
    
    .nav-header-custom {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px 8px;
        margin-top: 16px;
        border-bottom: 1px solid rgba(32, 201, 151, 0.1);
    }
    
    .search-white {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }
    
    .search-white input {
        background: transparent;
        color: #374151;
        border: none;
    }
    
    .search-white input::placeholder {
        color: #9ca3af;
    }
    
    .search-white button {
        background: #f3f4f6;
        border: none;
        color: #6b7280;
        border-radius: 0 12px 12px 0;
    }
    
    .search-white button:hover {
        background: #e5e7eb;
        color: #20C997;
    }
    
    /* Custom scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 4px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: #f9fafb;
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 2px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<aside class="main-sidebar sidebar-white elevation-4 fixed left-0 top-0 h-full z-40">
    <!-- Brand Logo -->
    <a href="<?= base_url('/') ?>" class="brand-link sidebar-brand flex items-center p-4 text-decoration-none hover:opacity-90 transition-opacity duration-300">
        <img src="<?= base_url() ?>/assets/img/promedicotp.png" 
             alt="Pro Medico Logo" 
             class="w-10 h-10 rounded-full border-2 border-promedico shadow-lg mr-3">
        <div class="text-center flex-1">
            <span class="text-promedico font-bold text-lg tracking-wide">SI-Klinik Pro Medico</span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar overflow-y-auto h-full pb-20">
        <!-- SidebarSearch Form -->
        <div class="p-4">
                         <div class="search-white flex rounded-lg overflow-hidden">
                <input class="flex-1 px-4 py-2 text-sm focus:outline-none" 
                       type="search" 
                       placeholder="Cari menu..." 
                       aria-label="Search">
                <button class="px-4 py-2 transition-colors duration-300">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="pb-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if ($role == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home w-5 mr-3"></i>
                            <p class="font-medium">Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-header nav-header-custom">
                        <i class="fas fa-database mr-2"></i>Master Data
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('pasien') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users w-5 mr-3"></i>
                            <p class="font-medium">Pasien</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('dokter') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-md w-5 mr-3"></i>
                            <p class="font-medium">Dokter</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('jadwal') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-alt w-5 mr-3"></i>
                            <p class="font-medium">Jadwal</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('jenis') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-stethoscope w-5 mr-3"></i>
                            <p class="font-medium">Jenis Perawatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('obat') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('obat')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-pills w-5 mr-3"></i>
                            <p class="font-medium">Obat</p>
                        </a>
                    </li>
                    
                    <li class="nav-header nav-header-custom">
                        <i class="fas fa-exchange-alt mr-2"></i>Transaksi
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('booking') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-plus w-5 mr-3"></i>
                            <p class="font-medium">Booking</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('perawatan') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-notes-medical w-5 mr-3"></i>
                            <p class="font-medium">Perawatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('obatmasuk') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('obatmasuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck w-5 mr-3"></i>
                            <p class="font-medium">Obat Masuk</p>
                        </a>
                    </li>
                    
                    <li class="nav-header nav-header-custom">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/pasien') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-users/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-medical w-5 mr-3"></i>
                            <p class="font-medium">Laporan Pasien</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/dokter') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-users/dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-medical w-5 mr-3"></i>
                            <p class="font-medium">Laporan Dokter</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jadwal') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-check w-5 mr-3"></i>
                            <p class="font-medium">Laporan Jadwal Dokter</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jenis') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-list w-5 mr-3"></i>
                            <p class="font-medium">Laporan Jenis Perawatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-obat') || current_url() == base_url('laporan-obat/view')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-capsules w-5 mr-3"></i>
                            <p class="font-medium">Laporan Obat</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat/masuk') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-obat/masuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck-loading w-5 mr-3"></i>
                            <p class="font-medium">Laporan Obat Masuk</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/booking') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-transaksi/booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-day w-5 mr-3"></i>
                            <p class="font-medium">Laporan Booking</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/perawatan') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-transaksi/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-procedures w-5 mr-3"></i>
                            <p class="font-medium">Laporan Perawatan</p>
                        </a>
                    </li>
                    
                <?php elseif ($role == 'dokter'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home w-5 mr-3"></i>
                            <p class="font-medium">Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-header nav-header-custom">
                        <i class="fas fa-user-md mr-2"></i>Menu Dokter
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('rdokter/pasien') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('rdokter/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users w-5 mr-3"></i>
                            <p class="font-medium">Cek Pasien</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('rdokter/perawatan') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('rdokter/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-notes-medical w-5 mr-3"></i>
                            <p class="font-medium">Cek Perawatan</p>
                        </a>
                    </li>
                    
                <?php elseif ($role == 'pimpinan'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home w-5 mr-3"></i>
                            <p class="font-medium">Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-header nav-header-custom">
                        <i class="fas fa-chart-line mr-2"></i>Laporan Eksekutif
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/pasien') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-users/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-medical w-5 mr-3"></i>
                            <p class="font-medium">Laporan Pasien</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/dokter') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-users/dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-medical w-5 mr-3"></i>
                            <p class="font-medium">Laporan Dokter</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jadwal') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-check w-5 mr-3"></i>
                            <p class="font-medium">Laporan Jadwal Dokter</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jenis') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-list w-5 mr-3"></i>
                            <p class="font-medium">Laporan Jenis Perawatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-obat') || current_url() == base_url('laporan-obat/view')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-capsules w-5 mr-3"></i>
                            <p class="font-medium">Laporan Obat</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat/masuk') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-obat/masuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck-loading w-5 mr-3"></i>
                            <p class="font-medium">Laporan Obat Masuk</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/booking') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-transaksi/booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-day w-5 mr-3"></i>
                            <p class="font-medium">Laporan Booking</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/perawatan') ?>" class="nav-link nav-link-custom flex items-center py-3 px-4 <?= (current_url() == base_url('laporan-transaksi/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-procedures w-5 mr-3"></i>
                            <p class="font-medium">Laporan Perawatan</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>