<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">Wisma Citra Sabaleh</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/#home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#about">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#rooms">Kamar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#facilities">Fasilitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#gallery">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#contact">Kontak</a>
                </li>
                <?php if (isset($is_logged_in) && $is_logged_in): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> <?= $username ?? 'User' ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/booking"><i class="fas fa-calendar-check me-2"></i>Booking</a></li>
                            <?php if (isset($role) && ($role == 'admin' || $role == 'manager')): ?>
                                <li><a class="dropdown-item" href="/admin"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="/auth"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 