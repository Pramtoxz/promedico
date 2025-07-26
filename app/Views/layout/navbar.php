<!-- Tailwind CSS CDN (jika belum ada di main layout) -->
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

<!-- Custom CSS untuk animasi navbar -->
<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .slide-down { animation: slideDown 0.3s ease-out; }
    
    .navbar-glass {
        backdrop-filter: blur(10px);
        background: linear-gradient(135deg, #20C997, #1BA68C);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .dropdown-glass {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(32, 201, 151, 0.98), rgba(27, 166, 140, 0.95));
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<nav class="navbar-glass shadow-xl border-0 sticky top-0 z-50">
    <div class="flex items-center justify-between w-full px-4 py-2">
        <!-- Left navbar links -->
        <div class="flex items-center space-x-4">
            <button class="text-white hover:text-gray-200 transition-colors duration-300 p-2 rounded-lg hover:bg-white/10" 
                    data-widget="pushmenu" role="button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Search Button -->
            <button class="text-white hover:text-gray-200 transition-colors duration-300 p-2 rounded-lg hover:bg-white/10" 
                    data-widget="navbar-search" role="button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Center Title -->
        <div class="hidden md:block">
            <h1 class="text-white font-bold text-lg tracking-wide">
                SI-Klinik Pro Medico Dashboard
            </h1>
        </div>

        <!-- Right navbar links -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative text-white hover:text-gray-200 transition-colors duration-300 p-2 rounded-lg hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.5-3.5c-.293-.293-.293-.768 0-1.061L20 8.939V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2.939l3.5 3.5c.293.293.293.768 0 1.061L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
            </button>

            <!-- User Profile Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-3 text-white hover:text-gray-200 transition-all duration-300 p-2 rounded-lg hover:bg-white/10 focus:outline-none" 
                        id="userMenuButton">
                    <img src="<?= base_url() ?>assets/img/dokter.png" 
                         class="w-8 h-8 rounded-full border-2 border-white/30 shadow-lg" 
                         alt="User Image">
                    <div class="hidden md:block text-left">
                        <p class="font-semibold text-sm"><?= session('username') ?? 'Admin' ?></p>
                        <p class="text-xs text-gray-200"><?= ucfirst(session('role') ?? 'admin') ?></p>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-56 dropdown-glass rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50">
                    <div class="p-4 border-b border-white/20">
                        <p class="text-white font-semibold">Halo, <?= session('username') ?? 'Admin' ?>! 👋</p>
                        <p class="text-gray-200 text-sm"><?= ucfirst(session('role') ?? 'admin') ?></p>
                    </div>
                    
                    <div class="py-2">
                        <button onclick="openProfileModal()" 
                                class="flex items-center w-full px-4 py-3 text-white hover:bg-white/10 transition-colors duration-300 group/item">
                            <svg class="w-5 h-5 mr-3 group-hover/item:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </button>
                        
                        <button onclick="openSettingsModal()" 
                                class="flex items-center w-full px-4 py-3 text-white hover:bg-white/10 transition-colors duration-300 group/item">
                            <svg class="w-5 h-5 mr-3 group-hover/item:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </button>
                    </div>
                    
                    <div class="border-t border-white/20 pt-2 pb-2">
                        <a href="<?= base_url('auth/logout') ?>" 
                           class="flex items-center w-full px-4 py-3 text-red-300 hover:text-red-200 hover:bg-red-500/20 transition-colors duration-300 font-semibold group/logout">
                            <svg class="w-5 h-5 mr-3 group-hover/logout:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar (Hidden by default) -->
    <div class="navbar-search-block hidden w-full px-4 pb-3">
        <form class="relative">
            <input class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white/90 backdrop-blur-sm rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent" 
                   type="search" placeholder="Cari di sistem..." aria-label="Search">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                <button type="submit" class="text-promedico hover:text-promedico-dark transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button type="button" data-widget="navbar-search" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</nav>

<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" onclick="closeProfileModal()"></div>
        
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-promedico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </h3>
                <button onclick="closeProfileModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-center mb-6">
                    <img src="<?= base_url() ?>assets/img/dokter.png" class="w-24 h-24 rounded-full border-4 border-promedico shadow-lg" alt="Profile">
                </div>
                
                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <label class="text-sm font-medium text-gray-600">Nama</label>
                        <p class="text-gray-800 font-semibold"><?= session('username') ?? 'Admin' ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <label class="text-sm font-medium text-gray-600">Role</label>
                        <p class="text-gray-800 font-semibold"><?= ucfirst(session('role') ?? 'admin') ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-800"><?= session('email') ?? 'admin@promedico.com' ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <label class="text-sm font-medium text-gray-600">Last Login</label>
                        <p class="text-gray-800"><?= date('d F Y, H:i') ?></p>
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button class="flex-1 bg-gradient-to-r from-promedico to-promedico-dark text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all duration-300 font-medium">
                        Edit Profile
                    </button>
                    <button onclick="closeProfileModal()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div id="settingsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
        
        <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-promedico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </h3>
                <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Theme Settings -->
                <div class="border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Tema & Tampilan</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-gray-700">Mode Gelap</label>
                            <button class="w-12 h-6 bg-gray-300 rounded-full relative transition-colors duration-300" onclick="toggleDarkMode()">
                                <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 left-0.5 transition-transform duration-300"></div>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <label class="text-gray-700">Notifikasi Desktop</label>
                            <button class="w-12 h-6 bg-promedico rounded-full relative transition-colors duration-300" onclick="toggleNotifications()">
                                <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 right-0.5 transition-transform duration-300"></div>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Security Settings -->
                <div class="border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Keamanan</h4>
                    <div class="space-y-3">
                        <button class="w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="text-gray-700">Ganti Password</span>
                            </div>
                        </button>
                        
                        <button class="w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-gray-700">Aktivitas Login</span>
                            </div>
                        </button>
                    </div>
                </div>
                
                <!-- System Info -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Informasi Sistem</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>Versi Sistem: v3.0.1</p>
                        <p>Last Update: <?= date('d F Y') ?></p>
                        <p>Status: <span class="text-green-600 font-semibold">Aktif</span></p>
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-8">
                    <button class="flex-1 bg-gradient-to-r from-promedico to-promedico-dark text-white py-2 px-4 rounded-lg hover:shadow-lg transition-all duration-300 font-medium">
                        Simpan Pengaturan
                    </button>
                    <button onclick="closeSettingsModal()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal Functions
function openProfileModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openSettingsModal() {
    document.getElementById('settingsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSettingsModal() {
    document.getElementById('settingsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Toggle Functions
function toggleDarkMode() {
    // Implementation for dark mode toggle
    console.log('Dark mode toggled');
}

function toggleNotifications() {
    // Implementation for notifications toggle
    console.log('Notifications toggled');
}

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProfileModal();
        closeSettingsModal();
    }
});
</script>