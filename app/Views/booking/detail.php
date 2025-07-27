<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Print-only styles for A4 faktur design -->
<style>
@media print {
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Arial', sans-serif;
        background: white !important;
        color: #000 !important;
    }
    
    .no-print {
        display: none !important;
    }
    
    .print-only {
        display: block !important;
    }
    
    .web-view {
        display: none !important;
    }
    
         .faktur-container {
         width: 210mm;
         max-height: 297mm;
         margin: 0;
         padding: 15mm;
         background: white;
         box-shadow: none;
         overflow: hidden;
     }
    
         .faktur-header {
         background: #20C997 !important;
         color: white !important;
         padding: 15px;
         margin-bottom: 15px;
         border-radius: 8px;
     }
     
     .faktur-title {
         font-size: 20px;
         font-weight: bold;
         margin-bottom: 3px;
     }
     
     .faktur-subtitle {
         font-size: 12px;
         opacity: 0.9;
     }
     
     .info-section {
         margin-bottom: 15px;
         padding-bottom: 10px;
         border-bottom: 1px solid #ddd;
     }
     
     .info-title {
         font-size: 14px;
         font-weight: bold;
         color: #20C997;
         margin-bottom: 8px;
     }
    
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }
    
    .info-item {
        margin-bottom: 8px;
    }
    
    .info-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 2px;
    }
    
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }
    
         .treatment-table {
         width: 100%;
         border-collapse: collapse;
         margin: 10px 0;
     }
     
     .treatment-table th {
         background: #f8f9fa;
         padding: 8px;
         text-align: left;
         font-weight: bold;
         border: 1px solid #ddd;
         font-size: 12px;
     }
     
     .treatment-table td {
         padding: 8px;
         border: 1px solid #ddd;
         font-size: 12px;
     }
     
     .total-section {
         background: #f8f9fa;
         padding: 10px;
         border-radius: 6px;
         text-align: right;
         margin: 10px 0;
     }
     
     .total-amount {
         font-size: 16px;
         font-weight: bold;
         color: #20C997;
     }
     
     .qr-section {
         text-align: center;
         margin: 15px 0;
     }
     
     .signature-section {
         margin-top: 20px;
         display: flex;
         justify-content: space-between;
         align-items: end;
     }
    
    .clinic-info {
        text-align: left;
    }
    
    .signature-area {
        text-align: center;
        min-width: 200px;
    }
    
    
    
    @page {
        size: A4;
        margin: 0;
    }
}

@media screen {
    .print-only {
        display: none;
    }
}

/* Web view modern styling */
.booking-card {
    background: linear-gradient(135deg, #20C997 0%, #17a085 100%);
    border-radius: 20px;
    color: white;
    margin-bottom: 30px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(32, 201, 151, 0.3);
}

.booking-header {
    padding: 30px;
    text-align: center;
    position: relative;
}

.booking-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.booking-id {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
}

.status-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 1;
}

.status-warning {
    background: rgba(255, 193, 7, 0.9);
    color: #333;
}

.status-success {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.status-danger {
    background: rgba(220, 53, 69, 0.9);
    color: white;
}

.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.info-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    border-left: 5px solid #20C997;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.info-card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #20C997;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.info-card-title i {
    margin-right: 10px;
    font-size: 1.4rem;
}

.info-item {
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.info-label {
    font-weight: 600;
    color: #555;
}

.info-value {
    color: #333;
    font-weight: 500;
}

.treatment-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.treatment-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 0 1px #e0e0e0;
}

.treatment-table th {
    background: #20C997;
    color: white;
    padding: 15px;
    font-weight: 600;
    text-align: left;
}

.treatment-table td {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.treatment-table tbody tr:last-child td {
    border-bottom: none;
}

.treatment-table tbody tr:hover {
    background: #f8f9fa;
}



.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-modern {
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-print {
    background: linear-gradient(135deg, #20C997, #17a085);
    color: white;
}

.btn-print:hover {
    background: linear-gradient(135deg, #17a085, #138f75);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(32, 201, 151, 0.4);
}

.btn-back {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.btn-back:hover {
    background: linear-gradient(135deg, #5a6268, #495057);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
}

.notes-card {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border: none;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
}

.notes-title {
    color: #1976d2;
    font-weight: 700;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.notes-title i {
    margin-right: 10px;
}

.notes-content {
    color: #1565c0;
    line-height: 1.6;
}
</style>

<!-- Web View -->
<div class="web-view">
    <!-- Booking Header Card -->
    <div class="booking-card">
        <div class="booking-header">
            <h1 class="booking-id">#<?= $booking['idbooking'] ?></h1>
            <p style="font-size: 1.1rem; margin-bottom: 15px; opacity: 0.9; position: relative; z-index: 1;">Booking Receipt</p>
            <span class="status-badge status-<?= ($booking['status'] == 'diproses') ? 'warning' : (($booking['status'] == 'diterima') ? 'success' : 'danger') ?>">
                        <?= ucfirst($booking['status']) ?>
                    </span>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="info-cards">
        <!-- Clinic Information -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-hospital"></i>
                Clinic Information
            </h3>
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value">Promedico Dental</span>
            </div>
            <div class="info-item">
                <span class="info-label">Address:</span>
                <span class="info-value">Jl. Maransi Aie Pacah Padang</span>
            </div>
            <div class="info-item">
                <span class="info-label">City:</span>
                <span class="info-value">Kota Padang, Sumatera Barat</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <span class="info-value">081234567890</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">promedico@gmail.com</span>
            </div>
        </div>

        <!-- Appointment Details -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-calendar-check"></i>
                Appointment Details
            </h3>
            <div class="info-item">
                <span class="info-label">Date:</span>
                <span class="info-value"><?= date('d F Y', strtotime($booking['tanggal'])) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Time:</span>
                <span class="info-value"><?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Day:</span>
                <span class="info-value"><?= $booking['hari'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Treatment:</span>
                <span class="info-value"><?= $booking['namajenis'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Duration:</span>
                <span class="info-value"><?= $booking['estimasi'] ?> minutes</span>
            </div>
            <div class="info-item">
                <span class="info-label">Doctor:</span>
                <span class="info-value"><?= $booking['nama_dokter'] ?></span>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-user"></i>
                Patient Information
            </h3>
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value"><?= $booking['nama_pasien'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Address:</span>
                <span class="info-value"><?= isset($booking['alamat']) ? $booking['alamat'] : 'Address not provided' ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <span class="info-value"><?= isset($booking['nohp']) ? $booking['nohp'] : 'Phone not provided' ?></span>
            </div>
        </div>
    </div>

    <!-- Treatment Details -->
    <div class="treatment-card">
        <h3 class="info-card-title">
            <i class="fas fa-tooth"></i>
            Treatment Details
        </h3>
        <table class="treatment-table">
            <thead>
                <tr>
                    <th>Treatment</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong><?= $booking['namajenis'] ?></strong></td>
                    <td>Dental treatment with Dr. <?= $booking['nama_dokter'] ?></td>
                    <td><?= $booking['estimasi'] ?> minutes</td>
                    <td><strong>Rp <?= number_format($booking['harga'], 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    
    
    <!-- Notes Section -->
    <?php if (isset($booking['catatan']) && !empty($booking['catatan'])): ?>
    <div class="notes-card">
        <h3 class="notes-title">
            <i class="fas fa-sticky-note"></i>
            Notes
        </h3>
        <div class="notes-content">
            <?= $booking['catatan'] ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="action-buttons no-print">
        <button onclick="printFaktur()" class="btn-modern btn-print">
            <i class="fas fa-print"></i>
            Print Faktur
        </button>
        <a href="<?= base_url() ?>/booking" class="btn-modern btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Booking
        </a>
    </div>
</div>

<!-- Print-only Faktur Design -->
<div class="print-only">
    <div class="faktur-container">
        <!-- Faktur Header -->
        <div class="faktur-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="faktur-title">FAKTUR PEMBAYARAN</div>
                    <div class="faktur-subtitle">Klinik Gigi Pro Medico</div>
                </div>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-tooth" style="font-size: 24px; margin-right: 10px;"></i>
                    <span style="font-size: 20px; font-weight: bold;">ProMedico</span>
                </div>
            </div>
        </div>

                 <!-- Patient & Invoice Info -->
         <div class="info-section">
             <div style="display: flex; justify-content: space-between; align-items: start;">
                 <div style="flex: 1;">
                     <div class="info-label">Faktur untuk:</div>
                     <div class="info-value" style="font-size: 16px; font-weight: bold; margin-bottom: 3px;"><?= $booking['nama_pasien'] ?></div>
                     <div class="info-value" style="font-size: 11px;"><?= isset($booking['alamat']) ? $booking['alamat'] : 'Address not provided' ?></div>
                     <div class="info-value" style="font-size: 11px;"><?= isset($booking['nohp']) ? $booking['nohp'] : 'Phone not provided' ?></div>
                 </div>
                 <div style="text-align: right; flex: 1;">
                     <div style="margin-bottom: 5px;">
                         <span class="info-label">No. Faktur: </span>
                         <span class="info-value" style="font-weight: bold;">INV-<?= $booking['idbooking'] ?></span>
                     </div>
                     <div style="margin-bottom: 5px;">
                         <span class="info-label">Tanggal: </span>
                         <span class="info-value" style="font-weight: bold;"><?= date('d F Y') ?></span>
                     </div>
                     <div>
                         <span class="info-label">Status: </span>
                         <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;">LUNAS</span>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Booking Details - Compact -->
         <div class="info-section">
             <div class="info-title">Detail Booking & Appointment</div>
             <div style="background: #f8f9fa; padding: 10px; border-radius: 6px;">
                 <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 10px; font-size: 11px;">
                     <div><strong>ID:</strong> <?= $booking['idbooking'] ?></div>
                     <div><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($booking['tanggal'])) ?></div>
                     <div><strong>Hari:</strong> <?= $booking['hari'] ?></div>
                     <div><strong>Waktu:</strong> <?= substr($booking['waktu_mulai'], 0, 5) ?>-<?= substr($booking['waktu_selesai'], 0, 5) ?></div>
                     <div style="grid-column: 1/3;"><strong>Dokter:</strong> <?= $booking['nama_dokter'] ?></div>
                     <div style="grid-column: 3/5;"><strong>Treatment:</strong> <?= $booking['namajenis'] ?> (<?= $booking['estimasi'] ?> menit)</div>
                 </div>
             </div>
         </div>

        <!-- Treatment & Cost -->
        <div class="info-section">
            <div class="info-title">Rincian Biaya</div>
            <table class="treatment-table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th style="text-align: right; width: 25%;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div style="font-weight: bold; margin-bottom: 5px;"><?= $booking['namajenis'] ?></div>
                            <div style="font-size: 12px; color: #666;">Perawatan gigi dengan Dr. <?= $booking['nama_dokter'] ?></div>
                        </td>
                        <td style="text-align: right; font-weight: bold;">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="total-section">
                <div style="font-size: 16px; margin-bottom: 5px;">Total Pembayaran</div>
                <div class="total-amount">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></div>
            </div>
        </div>

                 <!-- Payment Status & Notes - Compact -->
         <div class="info-section">
             <div style="display: flex; gap: 15px;">
                 <div style="flex: 2;">
                     <div class="info-title">Status Pembayaran</div>
                     <div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 8px; border-radius: 6px; margin-bottom: 10px;">
                         <div style="display: flex; align-items: center;">
                             <i class="fas fa-check-circle" style="color: #28a745; font-size: 16px; margin-right: 8px;"></i>
                             <div>
                                 <div style="font-weight: bold; color: #155724; font-size: 12px;">Pembayaran telah dikonfirmasi</div>
                                 <div style="color: #155724; font-size: 10px;">Silakan datang sesuai jadwal yang telah ditentukan.</div>
                             </div>
                         </div>
                     </div>
                     <div class="info-title">Catatan Penting</div>
                     <ul style="font-size: 10px; color: #333; line-height: 1.4; margin: 0; padding-left: 15px;">
                         <li>Datang 15 menit sebelum jadwal</li>
                         <li>Tunjukkan faktur kepada resepsionis</li>
                         <li>Faktur sebagai bukti pembayaran sah</li>
                         <?php if (isset($booking['catatan']) && !empty($booking['catatan'])): ?>
                         <li>Catatan: <?= $booking['catatan'] ?></li>
                         <?php endif; ?>
                     </ul>
                 </div>
                 <div style="flex: 1; text-align: center;">
                     <div class="info-title">QR Check-in</div>
                     <img src="<?= $qrCodeImage ?>" alt="QR Code" style="width: 100px; height: 100px;">
                     <div style="font-size: 9px; color: #666; margin-top: 5px;">Scan saat tiba di klinik</div>
                 </div>
             </div>
         </div>

                 <!-- Signature -->
         <div class="signature-section">
             <div class="clinic-info">
                 <div style="font-weight: bold; font-size: 12px;">Klinik Gigi Pro Medico</div>
                 <div style="font-size: 10px; color: #666;">Jl. Maransi Aie Pacah Padang, Kota Padang</div>
                 <div style="font-size: 10px; color: #666;">Sumatera Barat • Telp: 081234567890</div>
             </div>
             <div class="signature-area">
                 <div style="text-align: center; margin-bottom: 5px; font-size: 10px;">Padang, <?= date('d F Y') ?></div>
                 <div style="border-bottom: 1px solid #333; margin-bottom: 5px; height: 40px;"></div>
                 <div style="font-weight: bold; font-size: 11px;">Admin Klinik</div>
                 <div style="font-size: 9px; color: #666;">Promedico Dental</div>
             </div>
         </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function printFaktur() {
    // Show the print-specific design
    document.querySelector('.web-view').style.display = 'none';
    document.querySelector('.print-only').style.display = 'block';
    
    // Trigger print
    window.print();
    
    // Restore web view after printing
    setTimeout(function() {
        document.querySelector('.web-view').style.display = 'block';
        document.querySelector('.print-only').style.display = 'none';
    }, 1000);
}

// Handle browser print button
window.addEventListener('beforeprint', function() {
    document.querySelector('.web-view').style.display = 'none';
    document.querySelector('.print-only').style.display = 'block';
});

window.addEventListener('afterprint', function() {
    document.querySelector('.web-view').style.display = 'block';
    document.querySelector('.print-only').style.display = 'none';
    });
</script>
<?= $this->endSection() ?>