<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Tambah Data Obat</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('rdokter/saveresep', ['id' => 'formresep']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="kode_perawatan" class="col-sm-3 col-form-label">Kode Perawatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode_perawatan" name="kode_perawatan" value="<?= $kode_perawatan ?>" readonly>
                                    <div class="invalid-feedback error_kode_perawatan"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="nama_pasien" class="col-sm-3 col-form-label">Nama Pasien</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $perawatan['nama_pasien'] ?>" readonly>
                                    <div class="invalid-feedback error_nama_pasien"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $perawatan['tanggal'] ?>" readonly>
                                    <div class="invalid-feedback error_tanggal"></div>
                                </div>
                            </div>  
                            <div class="form-group row mb-4">
                                <label for="nama_jenis" class="col-sm-3 col-form-label">Jenis Perawatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="<?= $perawatan['nama_jenis'] ?>" readonly>
                                    <div class="invalid-feedback error_nama_jenis"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="resep" class="col-sm-3 col-form-label">Resep</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="resep" name="resep" rows="4"><?= isset($perawatan['resep']) ? $perawatan['resep'] : '' ?></textarea>
                                    <div class="invalid-feedback error_resep"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('rdokter/perawatan') ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> KEMBALI
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
    $('#formresep').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
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
                    if(err.error_kode_perawatan) {
                        $('#kode_perawatan').addClass('is-invalid').removeClass('is-valid');
                        $('.error_kode_perawatan').html(err.error_kode_perawatan);
                    } else {
                        $('#kode_perawatan').removeClass('is-invalid').addClass('is-valid');
                        $('.error_kode_perawatan').html('');
                    }
                    if (err.error_resep) {
                        $('#resep').addClass('is-invalid').removeClass('is-valid');
                        $('.error_resep').html(err.error_resep);
                    } else {
                        $('#resep').removeClass('is-invalid').addClass('is-valid');
                        $('.error_resep').html('');
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
                        window.location.href = '<?= site_url('rdokter/perawatan') ?>';
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