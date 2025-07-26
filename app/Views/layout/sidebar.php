<?php
// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session()->start();
}
$role = session('role'); // pastikan key 'role' sesuai dengan session aplikasi Anda
?>
<aside class="main-sidebar sidebar-light-teal elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('/') ?>" class="brand-link bg-white">
        <img src="<?= base_url() ?>/assets/img/promedicotp.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span style="display: block; text-align: center;">SI- Klinik Pro Medico</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if ($role == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">Master</li>
                    <li class="nav-item">
                        <a href="<?= base_url('pasien') ?>" class="nav-link <?= (current_url() == base_url('pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dokter') ?>" class="nav-link <?= (current_url() == base_url('dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('jadwal') ?>" class="nav-link <?= (current_url() == base_url('jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('jenis') ?>" class="nav-link <?= (current_url() == base_url('jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Jenis Perawatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('obat') ?>" class="nav-link <?= (current_url() == base_url('obat')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Obat</p>
                        </a>
                    </li>
                    <li class="nav-header">Transaksi</li>
                    <li class="nav-item">
                        <a href="<?= base_url('booking') ?>" class="nav-link <?= (current_url() == base_url('booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-calendar-plus"></i>
                            <p>Booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('perawatan') ?>" class="nav-link <?= (current_url() == base_url('perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>Perawatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('obatmasuk') ?>" class="nav-link <?= (current_url() == base_url('obatmasuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Obat Masuk</p>
                        </a>
                    </li>
                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/pasien') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/dokter') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jadwal') ?>" class="nav-link <?= (current_url() == base_url('laporan-jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Jadwal Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jenis') ?>" class="nav-link <?= (current_url() == base_url('laporan-jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Jenis Perawatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat') || current_url() == base_url('laporan-obat/view')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Obat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat/masuk') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat/masuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Obat Masuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/booking') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/perawatan') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Perawatan</p>
                        </a>
                    </li>
                <?php elseif ($role == 'dokter'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">Menu Dokter</li>
                    <li class="nav-item">
                        <a href="<?= base_url('rdokter/pasien') ?>" class="nav-link <?= (current_url() == base_url('rdokter/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Cek Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('rdokter/perawatan') ?>" class="nav-link <?= (current_url() == base_url('rdokter/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>Cek Perawatan</p>
                        </a>
                    </li>
                <?php elseif ($role == 'pimpinan'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/pasien') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/pasien')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-users/dokter') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/dokter')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jadwal') ?>" class="nav-link <?= (current_url() == base_url('laporan-jadwal')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Jadwal Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-jenis') ?>" class="nav-link <?= (current_url() == base_url('laporan-jenis')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Jenis Perawatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat') || current_url() == base_url('laporan-obat/view')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Obat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-obat/masuk') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat/masuk')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Obat Masuk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/booking') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/booking')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan-transaksi/perawatan') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/perawatan')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-paperclip"></i>
                            <p>Laporan Perawatan</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>