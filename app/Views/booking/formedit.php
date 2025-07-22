<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Booking</h3>
                </div>
                <div class="card-body p-4">
                    <?= form_open('booking/updatedata/' . $booking['idbooking'], ['id' => 'formeditbooking', 'enctype' => 'multipart/form-data']) ?>
                    <?= csrf_field() ?>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="idbooking" class="col-sm-3 col-form-label">Kode Booking</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="idbooking" name="idbooking" value="<?= $booking['idbooking'] ?>" readonly>
                                    <div class="invalid-feedback error_idbooking"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="id_pasien" class="col-sm-3 col-form-label">Pasien</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control select2" id="id_pasien" name="id_pasien">
                                            <option value="">Pilih Pasien</option>
                                            <?php foreach ($pasien as $row) : ?>
                                                <option value="<?= $row['id_pasien'] ?>" <?= ($booking['id_pasien'] == $row['id_pasien']) ? 'selected' : ''; ?>>
                                                    <?= $row['id_pasien'] . ' - ' . $row['nama'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback error_id_pasien"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="idjadwal" class="col-sm-3 col-form-label">Jadwal Dokter</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control select2" id="idjadwal" name="idjadwal">
                                            <option value="">Pilih Jadwal</option>
                                            <?php foreach ($jadwal as $row) : ?>
                                                <?php if ($row['is_active'] == 1) : ?>
                                                    <option value="<?= $row['idjadwal'] ?>" data-hari="<?= $row['hari'] ?>" <?= ($booking['idjadwal'] == $row['idjadwal']) ? 'selected' : ''; ?>>
                                                        <?= $row['nama_dokter'] ?> - <?= $row['hari'] ?> (<?= substr($row['waktu_mulai'], 0, 5) ?> - <?= substr($row['waktu_selesai'], 0, 5) ?>)
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback error_idjadwal"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Kunjungan</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $booking['tanggal'] ?>">
                                    <small class="text-muted">Tanggal harus sesuai hari jadwal dokter</small>
                                    <div class="invalid-feedback error_tanggal"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="idjenis" class="col-sm-3 col-form-label">Jenis Perawatan</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" id="idjenis" name="idjenis">
                                        <option value="">Pilih Jenis Perawatan</option>
                                        <?php foreach ($jenis as $row) : ?>
                                            <option value="<?= $row['idjenis'] ?>" data-durasi="<?= $row['estimasi'] ?>" <?= ($booking['idjenis'] == $row['idjenis']) ? 'selected' : ''; ?>>
                                                <?= $row['namajenis'] ?> (Durasi: <?= $row['estimasi'] ?> menit)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback error_idjenis"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai</label>
                                <div class="col-sm-9">
                                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="<?= substr($booking['waktu_mulai'], 0, 5) ?>">
                                    <div class="invalid-feedback error_waktu_mulai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                                <div class="col-sm-9">
                                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" value="<?= substr($booking['waktu_selesai'], 0, 5) ?>">
                                    <div class="invalid-feedback error_waktu_selesai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="status" name="status">
                                        <option value="pending" <?= ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="diterima" <?= ($booking['status'] == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                                        <option value="ditolak" <?= ($booking['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                    <div class="invalid-feedback error_status"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="catatan" class="col-sm-3 col-form-label">Catatan (Opsional)</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"><?= $booking['catatan'] ?></textarea>
                                    <div class="invalid-feedback error_catatan"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="bukti_bayar" class="col-sm-3 col-form-label">Bukti Pembayaran</label>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bukti_bayar" name="bukti_bayar" accept="image/jpeg,image/png,application/pdf">
                                        <label class="custom-file-label" for="bukti_bayar">Pilih file (opsional)</label>
                                        <div class="invalid-feedback error_bukti_bayar"></div>
                                    </div>
                                    <small class="text-muted">Format: JPG, PNG, PDF. Ukuran maks: 2MB</small>
                                    
                                    <?php if (!empty($booking['bukti_bayar'])) : ?>
                                        <div class="mt-2">
                                            <a href="<?= base_url('uploads/bukti_bayar/' . $booking['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat Bukti Pembayaran
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="button" class="btn btn-primary" id="btnCheckSlot">
                                        <i class="fas fa-calendar-check"></i> Periksa Slot Tersedia
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-success" id="tombolSimpan">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="<?= site_url('booking') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('.select2').select2();
    
    // Event saat select jadwal berubah
    $('#idjadwal').on('change', function() {
        validateTanggal();
    });
    
    // Event saat tanggal berubah
    $('#tanggal').on('change', function() {
        validateTanggal();
    });
    
    // Event untuk memeriksa slot yang tersedia
    $('#btnCheckSlot').on('click', function() {
        const idjadwal = $('#idjadwal').val();
        const tanggal = $('#tanggal').val();
        const idjenis = $('#idjenis').val();
        const idbooking = '<?= $booking['idbooking'] ?>';
        
        // Validasi input
        if (!idjadwal || !tanggal || !idjenis) {
            Swal.fire({
                title: 'Perhatian',
                text: 'Harap isi Jadwal Dokter, Tanggal, dan Jenis Perawatan terlebih dahulu!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Memeriksa ketersediaan slot...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Cek ketersediaan slot
        $.ajax({
            url: "<?= site_url('booking/checkSlotAvailability') ?>",
            type: "POST",
            data: {
                idjadwal: idjadwal,
                tanggal: tanggal,
                waktu_mulai: $('#waktu_mulai').val(),
                waktu_selesai: $('#waktu_selesai').val(),
                idbooking: idbooking
            },
            dataType: "json",
            success: function(response) {
                Swal.close();
                if (response.available) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Slot Tersedia',
                        text: 'Waktu yang dipilih tersedia untuk booking',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Slot Tidak Tersedia',
                        text: 'Waktu yang dipilih bentrok dengan booking lain',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memeriksa ketersediaan slot',
                    confirmButtonText: 'OK'
                });
                console.error(xhr.responseText);
            }
        });
    });
    
    // Fungsi untuk validasi tanggal
    function validateTanggal() {
        const selectedJadwal = $('#idjadwal').find('option:selected');
        if (selectedJadwal.val() === '') return;
        
        const hari = selectedJadwal.data('hari');
        const tanggal = new Date($('#tanggal').val());
        
        if (!tanggal || isNaN(tanggal.getTime())) return;
        
        // Map hari dalam bahasa Indonesia ke nomor hari (0 = Minggu, 1 = Senin, dst.)
        const dayMap = {
            'Minggu': 0,
            'Senin': 1,
            'Selasa': 2,
            'Rabu': 3,
            'Kamis': 4,
            'Jumat': 5,
            'Sabtu': 6
        };
        
        const dayNumber = dayMap[hari];
        if (dayNumber === undefined) return;
        
        // Cek apakah hari sesuai
        if (tanggal.getDay() !== dayNumber) {
            Swal.fire({
                title: 'Tanggal Tidak Sesuai',
                html: `Tanggal yang Anda pilih <strong>bukan hari ${hari}</strong>.<br>Silakan pilih tanggal yang jatuh pada hari <strong>${hari}</strong>.`,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            $('#tanggal').val(''); // Reset nilai
        }
    }
    
    // Inisialisasi validasi tanggal saat halaman dimuat
    validateTanggal();
    
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName || 'Pilih file (opsional)');
    });
    
    // Form Submit
    $('#formeditbooking').submit(function(e) {
        e.preventDefault();
        
        // Validasi waktu selesai harus lebih dari waktu mulai
        const waktuMulai = $('#waktu_mulai').val();
        const waktuSelesai = $('#waktu_selesai').val();
        if (waktuMulai && waktuSelesai && waktuSelesai <= waktuMulai) {
            Swal.fire({
                title: 'Error',
                text: 'Waktu selesai harus lebih dari waktu mulai',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                $('#tombolSimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;
                    
                    // Reset semua validasi
                    $('.is-invalid').removeClass('is-invalid');
                    
                    // Tampilkan error
                    if (err.error_id_pasien) {
                        $('#id_pasien').addClass('is-invalid');
                        $('.error_id_pasien').html(err.error_id_pasien);
                    }
                    
                    if (err.error_idjadwal) {
                        $('#idjadwal').addClass('is-invalid');
                        $('.error_idjadwal').html(err.error_idjadwal);
                    }
                    
                    if (err.error_tanggal) {
                        $('#tanggal').addClass('is-invalid');
                        $('.error_tanggal').html(err.error_tanggal);
                    }
                    
                    if (err.error_idjenis) {
                        $('#idjenis').addClass('is-invalid');
                        $('.error_idjenis').html(err.error_idjenis);
                    }
                    
                    if (err.error_waktu_mulai) {
                        $('#waktu_mulai').addClass('is-invalid');
                        $('.error_waktu_mulai').html(err.error_waktu_mulai);
                    }
                    
                    if (err.error_waktu_selesai) {
                        $('#waktu_selesai').addClass('is-invalid');
                        $('.error_waktu_selesai').html(err.error_waktu_selesai);
                    }
                    
                    if (err.error_status) {
                        $('#status').addClass('is-invalid');
                        $('.error_status').html(err.error_status);
                    }
                    
                    if (err.error_jadwal) {
                        Swal.fire({
                            title: 'Jadwal Tidak Tersedia',
                            text: err.error_jadwal,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                    
                    if (err.error_bukti_bayar) {
                        $('#bukti_bayar').addClass('is-invalid');
                        $('.error_bukti_bayar').html(err.error_bukti_bayar);
                    }
                }
                
                if (response.sukses) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = '<?= site_url('booking') ?>';
                    }, 1500);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        
        return false;
    });
});
</script>
<?= $this->endSection() ?>