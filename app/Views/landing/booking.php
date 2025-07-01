<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid bg-primary py-5 mb-5" style="margin-top: 80px;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="text-white display-4" data-aos="fade-up">Booking Kamar</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="/">Beranda</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-4">Formulir Booking</h3>
                    
                    <form id="bookingForm">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
                            </div>
                            <div class="col-md-6">
                                <label for="identity" class="form-label">Nomor Identitas (KTP/Passport)</label>
                                <input type="text" class="form-control" id="identity" name="identity" placeholder="Masukkan nomor identitas" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="check_in" class="form-label">Tanggal Check-in</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Tanggal Check-out</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="room_type" class="form-label">Tipe Kamar</label>
                                <select class="form-select" id="room_type" name="room_type" required>
                                    <option value="" selected disabled>Pilih tipe kamar</option>
                                    <option value="standard">Standard Room - Rp 500.000/malam</option>
                                    <option value="deluxe">Deluxe Room - Rp 750.000/malam</option>
                                    <option value="suite">Suite Room - Rp 1.200.000/malam</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="guests" class="form-label">Jumlah Tamu</label>
                                <select class="form-select" id="guests" name="guests" required>
                                    <option value="1">1 Orang</option>
                                    <option value="2" selected>2 Orang</option>
                                    <option value="3">3 Orang</option>
                                    <option value="4">4 Orang</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Permintaan Khusus (Opsional)</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Masukkan permintaan khusus (jika ada)"></textarea>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Saya menyetujui syarat dan ketentuan yang berlaku</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">Proses Booking</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-left">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-3">Ringkasan Booking</h3>
                    <div id="bookingSummary">
                        <p class="text-center text-muted">Silakan isi formulir booking untuk melihat ringkasan</p>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-3">Informasi</h3>
                    <ul class="list-unstyled">
                        <li class="d-flex mb-3">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <p class="mb-0">Check-in: 14:00, Check-out: 12:00</p>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <p class="mb-0">Deposit dibayarkan saat check-in</p>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <p class="mb-0">Pembatalan gratis hingga 24 jam sebelum check-in</p>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <p class="mb-0">Sarapan tersedia dengan biaya tambahan</p>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-3">Butuh Bantuan?</h3>
                    <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi customer service kami:</p>
                    <ul class="list-unstyled">
                        <li class="d-flex mb-3">
                            <i class="fas fa-phone-alt text-primary me-3 mt-1"></i>
                            <p class="mb-0">+62 812 3456 7890</p>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                            <p class="mb-0">booking@wisma.com</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const roomTypeSelect = document.getElementById('room_type');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const guestsSelect = document.getElementById('guests');
    const bookingSummary = document.getElementById('bookingSummary');
    
    const roomPrices = {
        'standard': 500000,
        'deluxe': 750000,
        'suite': 1200000
    };
    
    const roomNames = {
        'standard': 'Standard Room',
        'deluxe': 'Deluxe Room',
        'suite': 'Suite Room'
    };
    
    // Set minimum date for check-in and check-out
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const formatDate = date => {
        return date.toISOString().split('T')[0];
    };
    
    checkInInput.min = formatDate(today);
    checkOutInput.min = formatDate(tomorrow);
    
    // Default check-in to today and check-out to tomorrow
    checkInInput.value = formatDate(today);
    checkOutInput.value = formatDate(tomorrow);
    
    // Calculate number of nights
    function calculateNights() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);
        
        if (checkIn && checkOut) {
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }
        
        return 0;
    }
    
    // Update booking summary
    function updateBookingSummary() {
        const roomType = roomTypeSelect.value;
        const nights = calculateNights();
        
        if (roomType && nights > 0) {
            const roomPrice = roomPrices[roomType];
            const totalPrice = roomPrice * nights;
            
            bookingSummary.innerHTML = `
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tipe Kamar:</span>
                        <span>${roomNames[roomType]}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Check-in:</span>
                        <span>${checkInInput.value}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Check-out:</span>
                        <span>${checkOutInput.value}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Durasi:</span>
                        <span>${nights} malam</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Jumlah Tamu:</span>
                        <span>${guestsSelect.value} orang</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga per malam:</span>
                        <span>Rp ${roomPrice.toLocaleString('id-ID')}</span>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-0">
                    <h5>Total Harga:</h5>
                    <h5>Rp ${totalPrice.toLocaleString('id-ID')}</h5>
                </div>
            `;
        } else {
            bookingSummary.innerHTML = `<p class="text-center text-muted">Silakan isi formulir booking untuk melihat ringkasan</p>`;
        }
    }
    
    // Event listeners
    roomTypeSelect.addEventListener('change', updateBookingSummary);
    checkInInput.addEventListener('change', function() {
        // Ensure check-out date is after check-in date
        const checkIn = new Date(this.value);
        const checkOut = new Date(checkOutInput.value);
        
        if (checkIn >= checkOut) {
            const newCheckOut = new Date(checkIn);
            newCheckOut.setDate(newCheckOut.getDate() + 1);
            checkOutInput.value = formatDate(newCheckOut);
        }
        
        updateBookingSummary();
    });
    
    checkOutInput.addEventListener('change', function() {
        // Ensure check-out date is after check-in date
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(this.value);
        
        if (checkOut <= checkIn) {
            const newCheckIn = new Date(checkOut);
            newCheckIn.setDate(newCheckIn.getDate() - 1);
            checkInInput.value = formatDate(newCheckIn);
        }
        
        updateBookingSummary();
    });
    
    guestsSelect.addEventListener('change', updateBookingSummary);
    
    // Form submission
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add your AJAX or form submission logic here
        
        // For demo purpose, show success message
        Swal.fire({
            title: 'Booking Berhasil!',
            text: 'Terima kasih telah melakukan booking. Detail booking telah dikirim ke email Anda.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4e73df'
        });
    });
    
    // Initialize Swal (SweetAlert2)
    if (typeof Swal === 'undefined') {
        // Load SweetAlert2 if not available
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        document.head.appendChild(script);
    }
});
</script>
<?= $this->endSection() ?> 