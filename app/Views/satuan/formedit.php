<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-8">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Edit Data Satuan</h3>
            </div>

            <div class="card-body">
                <?= form_open('satuan/update', ['id' => 'formeditsatuan', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="kdsatuan">Kode Satuan</label>
                            <input type="text" id="kdsatuan" name="kdsatuan" class="form-control"
                                value="<?= $satuan['kdsatuan'] ?>" readonly>
                            <div class="invalid-feedback error_kdsatuan"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="namasatuan">Nama Satuan</label>
                            <input type="text" id="namasatuan" name="namasatuan" class="form-control"
                                value="<?= $satuan['namasatuan'] ?>">
                            <div class="invalid-feedback error_namasatuan"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" class="form-control"
                                value="<?= $satuan['harga'] ?>">
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn" style="background-color: navy; color: white;" id="tombolSimpan"
            style="margin-right: 1rem;">
            <i class="fas fa-save"></i> Update
        </button>
        <a class="btn btn-secondary" href="<?= base_url('satuan') ?>">Kembali</a>
    </div>
    <?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditsatuan').submit(function(e) {
        e.preventDefault();

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

                    if (err.error_kdsatuan) {
                        $('#kdsatuan').addClass('is-invalid').removeClass('is-valid');
                        $('.error_kdsatuan').html(err.error_kdsatuan);
                    } else {
                        $('#kdsatuan').removeClass('is-invalid').addClass('is-valid');
                        $('.error_kdsatuan').html('');
                    }
                    if (err.error_namasatuan) {
                        $('#namasatuan').addClass('is-invalid').removeClass('is-valid');
                        $('.error_namasatuan').html(err.error_namasatuan);
                    } else {
                        $('#namasatuan').removeClass('is-invalid').addClass('is-valid');
                        $('.error_namasatuan').html('');
                    }
                    if (err.error_harga) {
                        $('#harga').addClass('is-invalid').removeClass('is-valid');
                        $('.error_harga').html(err.error_harga);
                    } else {
                        $('#harga').removeClass('is-invalid').addClass('is-valid');
                        $('.error_harga').html('');
                    }

                }

                if (response.sukses) {
                    Swal.fire({
                        title: "Update Data Berhasil!",
                        html: "Tunggu Sebentar.",
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = '<?= site_url('satuan') ?>';
                        }
                    });
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