<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <div class="page-title">
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Booking</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="<?= site_url('booking/' . $booking['idbooking']) ?>" method="post" id="form-edit-booking">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="idbooking">ID Booking</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="idbooking" class="form-control" name="idbooking" value="<?= $booking['idbooking'] ?>" readonly>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="id_pasien">Pasien</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <div class="input-group">
                                    <input type="hidden" id="id_pasien" name="id_pasien" value="<?= $booking['id_pasien'] ?>" required>
                                    <?php
                                    $pasienName = '';
                                    foreach ($pasien as $p) {
                                        if ($p['id_pasien'] == $booking['id_pasien']) {
                                            $pasienName = $p['nama'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <input type="text" id="nama_pasien" class="form-control" value="<?= $pasienName ?>" readonly required>
                                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#pasienModal">
                                        <i class="bi bi-search"></i> Pilih Pasien
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="idjadwal">Jadwal Dokter</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <div class="input-group">
                                    <input type="hidden" id="idjadwal" name="idjadwal" value="<?= $booking['idjadwal'] ?>" required>
                                    <?php
                                    $jadwalInfo = '';
                                    foreach ($jadwal as $j) {
                                        if ($j['idjadwal'] == $booking['idjadwal']) {
                                            $jadwalInfo = $j['nama_dokter'] . ' - ' . $j['hari'] . ' (' . 
                                                         substr($j['waktu_mulai'], 0, 5) . ' - ' . 
                                                         substr($j['waktu_selesai'], 0, 5) . ')';
                                            break;
                                        }
                                    }
                                    ?>
                                    <input type="text" id="info_jadwal" class="form-control" value="<?= $jadwalInfo ?>" readonly required>
                                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#dokterModal">
                                        <i class="bi bi-search"></i> Pilih Jadwal
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="error-jadwal"></div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tanggal">Tanggal Kunjungan</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="date" id="tanggal" class="form-control" name="tanggal" value="<?= $booking['tanggal'] ?>" required min="<?= date('Y-m-d') ?>">
                                <small class="text-muted">Pilih tanggal mulai hari ini (tanggal harus sesuai hari jadwal dokter)</small>
                                <div id="jadwal-info" class="alert alert-light-info mt-2">
                                    <i class="bi bi-info-circle"></i> Jadwal Dokter: <span id="dokter-hari"><?= $booking['hari'] ?></span>. Pilih tanggal yang sesuai.
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="idjenis">Jenis Perawatan</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="idjenis" name="idjenis" required>
                                    <option value="" disabled>Pilih Jenis Perawatan</option>
                                    <?php foreach ($jenis as $row) : ?>
                                        <option value="<?= $row['idjenis'] ?>" data-durasi="<?= $row['estimasi'] ?>" <?= ($booking['idjenis'] == $row['idjenis']) ? 'selected' : '' ?>>
                                            <?= $row['namajenis'] ?> (Durasi: <?= $row['estimasi'] ?> menit)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="waktu_estimasi">Estimasi Waktu</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <div id="estimasi-waktu-container" class="alert alert-light-primary">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <div>
                                            <div><strong>Estimasi waktu kedatangan:</strong> <span id="estimasi-waktu" class="fw-bold"><?= date('h:i A', strtotime($booking['waktu_mulai'])) ?></span></div>
                                            <div><strong>Durasi perawatan:</strong> <span id="durasi-perawatan">
                                            <?php
                                                foreach ($jenis as $j) {
                                                    if ($j['idjenis'] == $booking['idjenis']) {
                                                        echo $j['estimasi'];
                                                        break;
                                                    }
                                                }
                                            ?>
                                            </span> menit</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="no-slot-message" class="d-none alert alert-light-danger">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Tidak ada slot waktu tersedia pada jadwal yang dipilih
                                </div>
                                <button type="button" id="check-slot" class="btn btn-sm btn-info mb-2">
                                    <i class="bi bi-calendar-check"></i> Cek Ketersediaan Slot
                                </button>
                                <!-- Hidden input untuk menyimpan waktu yang dihitung -->
                                <input type="hidden" id="waktu_mulai_hidden" name="waktu_mulai" value="<?= $booking['waktu_mulai'] ?>">
                                <input type="hidden" id="waktu_selesai_hidden" name="waktu_selesai" value="<?= $booking['waktu_selesai'] ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="status" name="status" required>
                                    <?php foreach ($status as $s) : ?>
                                        <option value="<?= $s ?>" <?= ($booking['status'] == $s) ? 'selected' : '' ?>>
                                            <?= ucfirst($s) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="catatan">Catatan (Opsional)</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"><?= $booking['catatan'] ?></textarea>
                            </div>
                            
                            <div class="col-12 d-flex justify-content-end">
                                <a href="<?= site_url('booking') ?>" class="btn btn-secondary me-1 mb-1">Batal</a>
                                <button type="submit" class="btn btn-primary me-1 mb-1" id="btn-submit">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Include modals -->
<?= $this->include('booking/getPasien') ?>
<?= $this->include('booking/getDokter') ?>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('errors')) : ?>
            Swal.fire({
                title: 'Periksa Entrian Form',
                html: `<ul style="text-align: left;">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>`,
                icon: 'error',
                confirmButtonText: 'Baik'
            });
        <?php endif ?>
        
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                confirmButtonText: 'Baik'
            });
        <?php endif ?>
        
        // =================================================================
        // Inisialisasi Modal Pasien
        // =================================================================
        let pasienTable;
        
        // Event ketika modal pasien ditampilkan
        $('#pasienModal').on('shown.bs.modal', function() {
            $('#pasien-loading').removeClass('d-none');
            $('#pasien-error').addClass('d-none');
            
            // Inisialisasi atau reload DataTable
            if ($.fn.DataTable.isDataTable('#table-pasien')) {
                pasienTable.ajax.reload();
            } else {
                try {
                    pasienTable = $('#table-pasien').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "<?= site_url('pasien/datatables') ?>",
                            dataSrc: function(json) {
                                $('#pasien-loading').addClass('d-none');
                                return json.data || [];
                            },
                            error: function(xhr, error, thrown) {
                                $('#pasien-loading').addClass('d-none');
                                $('#pasien-error').removeClass('d-none');
                            }
                        },
                        columns: [
                            {data: 'id_pasien'},
                            {data: 'nama'},
                            {data: 'nohp'},
                            {data: 'alamat'},
                            {
                                data: null,
                                render: function(data) {
                                    return `<button type="button" class="btn btn-sm btn-primary btn-pilih-pasien" 
                                            data-id="${data.id_pasien}" data-nama="${data.nama}">
                                            <i class="bi bi-check-circle"></i> Pilih
                                            </button>`;
                                }
                            }
                        ],
                        language: {
                            zeroRecords: "Tidak ada data pasien ditemukan",
                            processing: "Memuat data...",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            infoEmpty: "Tidak ada data yang ditampilkan",
                            search: "Cari:",
                            paginate: {
                                first: "Pertama",
                                last: "Terakhir",
                                next: "Selanjutnya",
                                previous: "Sebelumnya"
                            }
                        }
                    });
                } catch (e) {
                    $('#pasien-loading').addClass('d-none');
                    $('#pasien-error').removeClass('d-none');
                }
            }
        });
        
        // Event handler untuk tombol pilih pasien
        $(document).on('click', '.btn-pilih-pasien', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            
            // Set nilai ke form
            $('#id_pasien').val(id);
            $('#nama_pasien').val(nama);
            
            // Tutup modal
            $('#pasienModal').modal('hide');
        });

        // =================================================================
        // Inisialisasi Modal Dokter/Jadwal
        // =================================================================
        let dokterTable;
        
        // Event ketika modal dokter ditampilkan
        $('#dokterModal').on('shown.bs.modal', function() {
            $('#jadwal-loading').removeClass('d-none');
            $('#jadwal-error').addClass('d-none');
            
            // Inisialisasi atau reload DataTable
            if ($.fn.DataTable.isDataTable('#table-jadwal')) {
                dokterTable.ajax.reload();
            } else {
                try {
                    dokterTable = $('#table-jadwal').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "<?= site_url('jadwal/datatables') ?>",
                            dataSrc: function(json) {
                                $('#jadwal-loading').addClass('d-none');
                                return json.data || [];
                            },
                            error: function(xhr, error, thrown) {
                                $('#jadwal-loading').addClass('d-none');
                                $('#jadwal-error').removeClass('d-none');
                                console.error('DataTable error:', error, thrown);
                            }
                        },
                        columns: [
                            {data: 'idjadwal'},
                            {data: 'nama_dokter'},
                            {data: 'hari'},
                            {
                                data: null,
                                render: function(data) {
                                    return data.waktu_mulai.substr(0, 5) + ' - ' + data.waktu_selesai.substr(0, 5);
                                }
                            },
                            {
                                data: null,
                                render: function(data) {
                                    if (data.is_active == '1') {
                                        return '<span class="badge bg-success">Aktif</span>';
                                    } else {
                                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                                    }
                                }
                            },
                            {
                                data: null,
                                render: function(data) {
                                    return `<button type="button" class="btn btn-sm btn-primary btn-pilih-jadwal" 
                                            data-id="${data.idjadwal}" data-dokter="${data.nama_dokter}" 
                                            data-hari="${data.hari}" data-waktu="${data.waktu_mulai.substr(0, 5)} - ${data.waktu_selesai.substr(0, 5)}">
                                            <i class="bi bi-check-circle"></i> Pilih
                                            </button>`;
                                }
                            }
                        ],
                        language: {
                            zeroRecords: "Tidak ada jadwal dokter ditemukan",
                            processing: "Memuat data...",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            infoEmpty: "Tidak ada data yang ditampilkan",
                            search: "Cari:",
                            paginate: {
                                first: "Pertama",
                                last: "Terakhir",
                                next: "Selanjutnya",
                                previous: "Sebelumnya"
                            }
                        }
                    });
                } catch (e) {
                    $('#jadwal-loading').addClass('d-none');
                    $('#jadwal-error').removeClass('d-none');
                    console.error('DataTable initialization error:', e);
                }
            }
        });
        
        // Event handler untuk tombol pilih jadwal
        $(document).on('click', '.btn-pilih-jadwal', function() {
            const id = $(this).data('id');
            const dokter = $(this).data('dokter');
            const hari = $(this).data('hari');
            const waktu = $(this).data('waktu');
            
            // Set nilai ke form
            $('#idjadwal').val(id);
            $('#info_jadwal').val(dokter + ' - ' + hari + ' (' + waktu + ')');
            $('#dokter-hari').text(hari);
            
            // Reset dan aktifkan field tanggal
            $('#tanggal').val('').prop('disabled', false);
            $('#jadwal-info').removeClass('d-none');
            
            // Reset estimasi waktu
            $('#estimasi-waktu-container').addClass('d-none');
            $('#no-slot-message').addClass('d-none');
            $('#btn-submit').prop('disabled', true);
            
            // Tutup modal
            $('#dokterModal').modal('hide');
        });

        // Validasi tanggal sesuai dengan hari jadwal
        $('#tanggal').on('change', function() {
            validateDate();
        });

        function validateDate() {
            const selectedDate = $('#tanggal').val();
            const selectedDay = new Date(selectedDate).getDay();
            const dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][selectedDay];
            const jadwalDay = $('#dokter-hari').text();
            
            if (dayName !== jadwalDay) {
                $('#error-jadwal').text(`Tanggal ${selectedDate} bukan hari ${jadwalDay}. Silakan pilih tanggal yang sesuai.`).show();
                $('#tanggal').addClass('is-invalid');
                return false;
            } else {
                $('#error-jadwal').hide();
                $('#tanggal').removeClass('is-invalid');
                return true;
            }
        }

        // Event untuk cek ketersediaan slot
        $('#check-slot').on('click', function() {
            const idjadwal = $('#idjadwal').val();
            const tanggal = $('#tanggal').val();
            const idjenis = $('#idjenis').val();
            
            if (!idjadwal || !tanggal || !idjenis) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Silakan pilih jadwal dokter, tanggal, dan jenis perawatan terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'Baik'
                });
                return;
            }
            
            if (!validateDate()) {
                return;
            }
            
            // Tampilkan loading
            $('#check-slot').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengecek...').prop('disabled', true);
            
            // Kirim permintaan AJAX
            $.ajax({
                url: "<?= site_url('booking/available-slot') ?>",
                type: "GET",
                data: {
                    idjadwal: idjadwal,
                    tanggal: tanggal,
                    idjenis: idjenis,
                    is_walk_in: true
                },
                dataType: "json",
                success: function(response) {
                    $('#check-slot').html('<i class="bi bi-calendar-check"></i> Cek Ketersediaan Slot').prop('disabled', false);
                    
                    if (response.status === 'success') {
                        // Tampilkan estimasi waktu
                        $('#estimasi-waktu-container').removeClass('d-none');
                        $('#no-slot-message').addClass('d-none');
                        $('#btn-submit').prop('disabled', false);
                        
                        // Konversi waktu ke format 12 jam
                        const waktuMulai = new Date('2000-01-01T' + response.data.waktu_mulai);
                        const formattedTime = waktuMulai.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                        
                        // Update tampilan dan hidden inputs
                        $('#estimasi-waktu').text(formattedTime);
                        $('#durasi-perawatan').text(response.data.durasi);
                        $('#waktu_mulai_hidden').val(response.data.waktu_mulai);
                        $('#waktu_selesai_hidden').val(response.data.waktu_selesai);
                    } else {
                        // Tampilkan pesan error
                        $('#estimasi-waktu-container').addClass('d-none');
                        $('#no-slot-message').removeClass('d-none').text(response.message);
                        $('#btn-submit').prop('disabled', true);
                    }
                },
                error: function() {
                    $('#check-slot').html('<i class="bi bi-calendar-check"></i> Cek Ketersediaan Slot').prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengecek ketersediaan slot',
                        icon: 'error',
                        confirmButtonText: 'Baik'
                    });
                }
            });
        });

        // Inisialisasi validasi tanggal jika sudah ada
        if ($('#tanggal').val()) {
            validateDate();
        }
    });
</script>
<?= $this->endSection() ?> 