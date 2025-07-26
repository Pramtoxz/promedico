<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'promedico': '#20C997',
                    'promedico-dark': '#1BA68C',
                    'promedico-light': '#7EDCC6'
                }
            }
        }
    }
</script>

<!-- Custom CSS untuk animasi -->
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .float { animation: float 3s ease-in-out infinite; }
    
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .slide-in-up { animation: slideInUp 0.6s ease-out; }
    
    @keyframes pulse-custom {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .pulse-custom { animation: pulse-custom 2s infinite; }
</style>

<section class="content min-h-screen" style="background: linear-gradient(135deg, #20C997 0%, #7EDCC6 50%, #ffffff 100%);">
    <div class="container-fluid px-4 py-6">
        
        <!-- Header Welcome Section -->
        <div class="slide-in-up mb-8">
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-center md:text-left mb-6 md:mb-0">
                        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-promedico to-promedico-dark bg-clip-text text-transparent mb-2">
                            Selamat Datang! 👋
                        </h1>
                        <p class="text-xl text-gray-600 mb-1">Halo, <span class="font-semibold text-promedico"><?= $user_name ?></span></p>
                        <p class="text-gray-500">Role: <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-promedico text-white"><?= ucfirst($role) ?></span></p>
                        <p class="text-sm text-gray-400 mt-2"><?= date('l, d F Y - H:i') ?></p>
                    </div>
                    <div class="float">
                        <img src="<?= base_url() ?>/assets/img/dashboard.png" alt="Logo Promedico" 
                             class="w-32 h-32 md:w-40 md:h-40 object-contain drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>

        <?php if ($role === 'admin' || $role === 'pimpinan'): ?>
        <!-- Admin/Pimpinan Dashboard -->
        
        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pasien -->
            <div class="slide-in-up bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Pasien</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['total_pasien']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Dokter -->
            <div class="slide-in-up bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Dokter</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['total_dokter']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Booking -->
            <div class="slide-in-up bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Booking</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['total_booking']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 7h12v9H4V7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="slide-in-up bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Pendapatan</p>
                        <p class="text-2xl font-bold">Rp <?= number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Hari Ini -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Booking Hari Ini -->
            <div class="slide-in-up bg-gradient-to-br from-promedico to-promedico-dark rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Booking Hari Ini</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['booking_hari_ini']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl pulse-custom">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Perawatan Hari Ini -->
            <div class="slide-in-up bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-sm font-medium">Perawatan Hari Ini</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['perawatan_hari_ini']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Booking Pending -->
            <div class="slide-in-up bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Booking Pending</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['booking_pending']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Obat Stok Rendah -->
            <div class="slide-in-up bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Obat Stok Rendah</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['obat_stok_rendah']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-4-8a4 4 0 012.031-3.488l.003-.002 1.266-.733a4 4 0 014.4 0l1.266.733.003.002A4 4 0 0116 10a4 4 0 01-1.031 2.687l-.003.002-1.266.733a4 4 0 01-4.4 0l-1.266-.733-.003-.002A4 4 0 014 10z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Menu -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="/dokter" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Dokter</h3>
                        <p class="text-gray-600 text-sm">Pengelolaan Dokter</p>
                    </div>
                    <div class="bg-gradient-to-br from-promedico to-promedico-dark p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="/pasien" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Pasien</h3>
                        <p class="text-gray-600 text-sm">Pengelolaan Pasien</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="/jenis" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Jenis</h3>
                        <p class="text-gray-600 text-sm">Pengelolaan Jenis Perawatan</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="/jadwal" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Jadwal</h3>
                        <p class="text-gray-600 text-sm">Pengelolaan Jadwal Dokter</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 7h12v9H4V7z"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Activities -->
        <?php if (isset($recent_bookings) && !empty($recent_bookings)): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Bookings -->
            <div class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-promedico" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 7h12v9H4V7z"></path>
                    </svg>
                    Booking Terbaru
                </h3>
                <div class="space-y-3">
                    <?php foreach (array_slice($recent_bookings, 0, 5) as $booking): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div>
                            <p class="font-medium text-gray-800"><?= $booking['nama_pasien'] ?></p>
                            <p class="text-sm text-gray-600"><?= date('d/m/Y H:i', strtotime($booking['tanggal'])) ?></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            <?= $booking['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($booking['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Upcoming Schedule -->
            <?php if (isset($upcoming_jadwal) && !empty($upcoming_jadwal)): ?>
            <div class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-promedico" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                    </svg>
                    Jadwal Dokter Aktif
                </h3>
                <div class="space-y-3">
                    <?php foreach (array_slice($upcoming_jadwal, 0, 5) as $jadwal): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800"><?= $jadwal['nama_dokter'] ?></p>
                            <p class="text-sm text-gray-600"><?= ucfirst($jadwal['hari']) ?> • <?= substr($jadwal['waktu_mulai'], 0, 5) ?>-<?= substr($jadwal['waktu_selesai'], 0, 5) ?></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php elseif ($role === 'dokter'): ?>
        <!-- Dokter Dashboard -->
        
        <!-- Statistik Dokter -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pasien Hari Ini -->
            <div class="slide-in-up bg-gradient-to-br from-promedico to-promedico-dark rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Pasien Hari Ini</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['total_pasien_today']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl pulse-custom">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Perawatan Hari Ini -->
            <div class="slide-in-up bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Perawatan Hari Ini</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['total_perawatan_today']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Jadwal Saya -->
            <div class="slide-in-up bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Jadwal Saya</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['my_jadwal']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 7h12v9H4V7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Booking Menunggu -->
            <div class="slide-in-up bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Booking Menunggu</p>
                        <p class="text-3xl font-bold"><?= number_format($stats['pending_booking']) ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Dokter -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="/rdokter/pasien" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Cek Pasien</h3>
                        <p class="text-gray-600 text-sm">Lihat daftar pasien Anda</p>
                    </div>
                    <div class="bg-gradient-to-br from-promedico to-promedico-dark p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="/rdokter/perawatan" class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-promedico transition-colors">Cek Perawatan</h3>
                        <p class="text-gray-600 text-sm">Lihat riwayat perawatan</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Patients for Doctor -->
        <?php if (isset($recent_patients) && !empty($recent_patients)): ?>
        <div class="slide-in-up bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-promedico" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pasien Terbaru
            </h3>
            <div class="space-y-3">
                <?php foreach (array_slice($recent_patients, 0, 5) as $patient): ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div>
                        <p class="font-medium text-gray-800"><?= $patient['nama_pasien'] ?></p>
                        <p class="text-sm text-gray-600"><?= $patient['namajenis'] ?> • <?= date('d/m/Y', strtotime($patient['tanggal'])) ?></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        <?= $patient['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($patient['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') ?>">
                        <?= ucfirst($patient['status']) ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>