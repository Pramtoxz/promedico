 <aside class="main-sidebar sidebar-light-teal elevation-4">
     <!-- Brand Logo -->
     <a href="<?= base_url('/') ?>" class="brand-link bg-white">
         <img src="<?= base_url() ?>/assets/img/logo.png" alt="AdminLTELogo" style="display: block; margin: auto;" height="60" width="200"> <br>
         <span style="display: block; text-align: center;"></span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <!-- SidebarSearch Form -->
         <div class="form-inline" style="margin-top: 1rem;">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" aria-label="Search" text-dark>
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

                     <li class="nav-item">
                         <a href="<?php base_url() ?>/admin" class="nav-link">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">Master</li>

                     <li class="nav-item">
                         <a href="<?php base_url() ?>/pasien" class="nav-link">
                             <i class="nav-icon fas fa-users"></i>
                             <p>
                                 Pasien
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/dokter" class="nav-link">
                             <i class="nav-icon fas fa-user-md"></i>
                             <p>
                                 Dokter
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/jadwal" class="nav-link">
                             <i class="nav-icon fas fa-calendar-alt"></i>
                             <p>
                                 Jadwal
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/jenis" class="nav-link">
                             <i class="nav-icon fas fa-stethoscope"></i>
                             <p>
                                 Jenis Perawatan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/obat" class="nav-link">
                             <i class="nav-icon fas fa-pills"></i>
                             <p>
                                 Obat
                             </p>
                         </a>
                     </li>

                     <li class="nav-header">Transaksi</li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/booking" class="nav-link">
                             <i class="nav-icon fas fa-calendar-plus"></i>
                             <p>
                                 Booking
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/perawatan" class="nav-link">
                             <i class="nav-icon fas fa-notes-medical"></i>
                             <p>
                                 Perawatan
                             </p>
                         </a>
                     </li>

                     <li class="nav-header">Laporan</li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan-pelanggan" class="nav-link">
                             <i class="nav-icon fas fa-chart-bar"></i>
                             <p>
                                 Laporan Pelanggan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan-cucian" class="nav-link <?= (current_url() == base_url('laporan-cucian')) ? 'active' : '' ?>
                         <?= (current_url() == base_url('laporan-cucian/add')) ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-chart-bar"></i>
                             <p>
                                 Laporan Kategori Cucian
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan-cucianmasuk" class="nav-link <?= (current_url() == base_url('laporan-cucianmasuk')) ? 'active' : '' ?>
                         <?= (current_url() == base_url('/laporan-cucianmasuk')) ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-chart-bar"></i>
                             <p>
                                 Laporan Cucian Masuk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan-cuciankeluar" class="nav-link <?= (current_url() == base_url('laporancuciankeluar')) ? 'active' : '' ?>
                         <?= (current_url() == base_url('laporancuciankeluar/add')) ? 'active' : '' ?>">
                             <i class="nav-icon fas fa-chart-bar"></i>
                             <p>
                                 Laporan Cucian Keluar
                             </p>
                         </a>
                     </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>