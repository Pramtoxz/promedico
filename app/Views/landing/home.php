<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center hero-content" data-aos="fade-up">
                <h1 class="hero-title">Selamat Datang di Wisma Citra Sabaleh</h1>
                <p class="hero-text mx-auto">Tempat penginapan nyaman dengan fasilitas terbaik untuk kenyamanan Anda. Rasakan pengalaman menginap yang tak terlupakan bersama kami.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/booking" class="btn btn-primary btn-lg"><i class="fas fa-calendar-check me-2"></i>Booking Sekarang</a>
                    <a href="#about" class="btn btn-outline-light btn-lg"><i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="<?= base_url('assets/img/layouts/home.jpg') ?>" alt="About Wisma" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title">Tentang Wisma Citra Sabaleh</h2>
                <p>Wisma Citra Sabaleh adalah tempat penginapan yang berada di Kota Padang, Sumatera Barat. Wisma ini menyediakan kenyamanan dan keamanan bagi setiap tamu. Berlokasi strategis di pusat kota, Wisma menawarkan akses mudah ke berbagai destinasi wisata populer yang ada di Kota Padang.</p>
                <p>Kami menyediakan berbagai tipe kamar dengan fasilitas lengkap untuk memenuhi kebutuhan tamu. Dilengkapi dengan staf yang ramah dan profesional, kami siap memberikan pelayanan terbaik untuk kenyamanan Anda.</p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Kamar Nyaman</h5>
                                <p class="mb-0 text-muted">Berbagai tipe kamar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success text-white rounded-circle p-3 me-3">
                                <i class="fas fa-wifi"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Wifi Gratis</h5>
                                <p class="mb-0 text-muted">Koneksi cepat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning text-white rounded-circle p-3 me-3">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Restaurant</h5>
                                <p class="mb-0 text-muted">Makanan lezat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-info text-white rounded-circle p-3 me-3">
                                <i class="fas fa-parking"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Parkir Luas</h5>
                                <p class="mb-0 text-muted">Aman dan nyaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rooms Section -->
<section id="rooms" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <h2 class="section-title text-center">Tipe Kamar</h2>
                <p class="lead">Kami menyediakan berbagai tipe kamar dengan fasilitas lengkap untuk memenuhi kebutuhan Anda.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 d-flex flex-column">
                    <img src="<?= base_url('assets/img/elements/4.png') ?>" class="card-img-top" alt="Standard Room">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">Standard Room</h5>
                            <span class="badge bg-primary">Rp 500.000/malam</span>
                        </div>
                        <p class="card-text">Kamar nyaman dengan fasilitas dasar untuk kebutuhan penginapan Anda.</p>
                        <ul class="list-unstyled flex-grow-1">
                            <li><i class="fas fa-check-circle text-success me-2"></i>1 Tempat Tidur Queen Size</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>TV LED 32"</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>AC</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Kamar Mandi Dalam</li>
                        </ul>
                        <a href="/booking" class="btn btn-primary w-100 mt-3">Booking Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 d-flex flex-column">
                    <img src="<?= base_url('assets/img/elements/3.png') ?>" class="card-img-top" alt="Deluxe Room">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">Deluxe Room</h5>
                            <span class="badge bg-primary">Rp 750.000/malam</span>
                        </div>
                        <p class="card-text">Kamar yang lebih luas dengan fasilitas yang lebih lengkap untuk kenyamanan Anda.</p>
                        <ul class="list-unstyled flex-grow-1">
                            <li><i class="fas fa-check-circle text-success me-2"></i>1 Tempat Tidur King Size</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>TV LED 42"</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>AC</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Kamar Mandi dengan Bathtub</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Mini Bar</li>
                        </ul>
                        <a href="/booking" class="btn btn-primary w-100 mt-3">Booking Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 d-flex flex-column">
                    <img src="<?= base_url('assets/img/elements/2.png') ?>" class="card-img-top" alt="Suite Room">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">Suite Room</h5>
                            <span class="badge bg-primary">Rp 1.200.000/malam</span>
                        </div>
                        <p class="card-text">Kamar mewah dengan fasilitas premium untuk pengalaman menginap yang tak terlupakan.</p>
                        <ul class="list-unstyled flex-grow-1">
                            <li><i class="fas fa-check-circle text-success me-2"></i>1 Tempat Tidur King Size</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Ruang Tamu Terpisah</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>TV LED 55"</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>AC</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Kamar Mandi Mewah dengan Jacuzzi</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Mini Bar & Coffee Maker</li>
                        </ul>
                        <a href="/booking" class="btn btn-primary w-100 mt-3">Booking Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section id="facilities" class="py-5 my-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <h2 class="section-title text-center">Fasilitas</h2>
                <p class="lead">Kami menyediakan berbagai fasilitas untuk memenuhi kebutuhan dan kenyamanan Anda selama menginap.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-primary text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-swimming-pool fa-2x"></i>
                    </div>
                    <h4>Kolam Renang</h4>
                    <p class="text-muted">Kolam renang outdoor dengan pemandangan kota yang indah.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-success text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-dumbbell fa-2x"></i>
                    </div>
                    <h4>Fitness Center</h4>
                    <p class="text-muted">Ruang fitness dengan peralatan modern dan lengkap.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-warning text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-utensils fa-2x"></i>
                    </div>
                    <h4>Restaurant</h4>
                    <p class="text-muted">Restaurant dengan menu lokal dan internasional.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-info text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-wifi fa-2x"></i>
                    </div>
                    <h4>Wifi Gratis</h4>
                    <p class="text-muted">Koneksi internet cepat di seluruh area wisma.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-danger text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-spa fa-2x"></i>
                    </div>
                    <h4>Spa</h4>
                    <p class="text-muted">Layanan spa untuk relaksasi dan kesegaran tubuh.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-secondary text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-parking fa-2x"></i>
                    </div>
                    <h4>Parkir</h4>
                    <p class="text-muted">Area parkir luas dan aman untuk kendaraan Anda.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-dark text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-concierge-bell fa-2x"></i>
                    </div>
                    <h4>Room Service</h4>
                    <p class="text-muted">Layanan kamar 24 jam untuk kenyamanan Anda.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                <div class="text-center">
                    <div class="icon-box mx-auto bg-primary text-white rounded-circle p-4 mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-shuttle-van fa-2x"></i>
                    </div>
                    <h4>Shuttle</h4>
                    <p class="text-muted">Layanan antar jemput dari dan ke bandara.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <h2 class="section-title text-center">Galeri</h2>
                <p class="lead">Lihat suasana dan fasilitas Wisma melalui galeri foto kami.</p>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/1.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/5.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/7.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/8.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/10.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
                <div class="gallery-item">
                    <img src="<?= base_url('assets/img/elements/19.png') ?>" alt="Gallery Image" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <h2 class="section-title text-center">Testimonial</h2>
                <p class="lead">Apa kata mereka tentang pengalaman menginap di Wisma.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 p-4">
                    <div class="d-flex mb-4">
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="card-text">"Pelayanan sangat baik, kamar bersih dan nyaman. Fasilitas lengkap dan lokasi strategis dekat dengan tempat wisata. Sangat direkomendasikan!"</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="<?= base_url('assets/img/avatars/1.png') ?>" alt="User" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">Ahmad Rizki</h6>
                            <small class="text-muted">Jakarta</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 p-4">
                    <div class="d-flex mb-4">
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="card-text">"Saya sangat puas dengan pengalaman menginap di Wisma. Kamar luas, bersih, dan fasilitas yang disediakan sangat lengkap. Staff juga sangat ramah dan membantu."</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="<?= base_url('assets/img/avatars/2.png') ?>" alt="User" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">Siti Nurhayati</h6>
                            <small class="text-muted">Bandung</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 p-4">
                    <div class="d-flex mb-4">
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="card-text">"Lokasi strategis, dekat dengan pusat perbelanjaan dan kuliner. Kamar nyaman dengan pemandangan kota yang indah. Sarapan pagi juga enak dengan menu yang bervariasi."</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="<?= base_url('assets/img/avatars/3.png') ?>" alt="User" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">Budi Santoso</h6>
                            <small class="text-muted">Surabaya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="mb-4">Jika Anda memiliki pertanyaan atau ingin melakukan reservasi, silakan hubungi kami melalui form berikut atau langsung melalui kontak yang tersedia.</p>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subject" placeholder="Masukkan subjek pesan">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Masukkan pesan Anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="map-container rounded overflow-hidden h-100 mt-4 mt-lg-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7978.545779963713!2d100.35738!3d-0.9474049999999999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b949d8575ff1%3A0xbce8689c2e4f0c44!2sWisma%20Citra%20Sabaleh!5e0!3m2!1sid!2sus!4v1751357858446!5m2!1sid!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<!-- <section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="fw-bold mb-2">Siap untuk pengalaman menginap yang nyaman?</h2>
                <p class="mb-0">Booking sekarang dan dapatkan diskon spesial untuk pengalaman menginap yang tak terlupakan!</p>
            </div>
            <div class="col-lg-3 text-lg-end" data-aos="fade-left">
                <a href="/booking" class="btn btn-light btn-lg px-4"><i class="fas fa-calendar-check me-2"></i>Booking Sekarang</a>
            </div>
        </div>
    </div>
</section> -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Animated counter for stats
    document.addEventListener('DOMContentLoaded', function() {
        // Additional scripts for the landing page if needed
    });
</script>
<?= $this->endSection() ?> 