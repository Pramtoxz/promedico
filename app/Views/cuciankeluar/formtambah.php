<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Tambah Cucian Keluar</h3>
            </div>

            <div class="card-body">
                <?= form_open('cuciankeluar/save', ['id' => 'formcuciankeluar', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nofak">No Faktur</label>
                            <div class="input-group">
                                <input type="text" id="nofak" name="nofak" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal" data-target="#modalObat">Cari</button>
                                </div>
                                <div class="invalid-feedback error_nama"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tglmasuk">Tanggal Masuk</label>
                            <input type="date" id="tglmasuk" name="tglmasuk" class="form-control" readonly>
                            <div class="invalid-feedback error_tglmasuk"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tglkeluar">Tanggal Selesai</label>
                            <input type="date" id="tglkeluar" name="tglkeluar" class="form-control" readonly>
                            <div class="invalid-feedback error_tglkeluar"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tglambil">Tanggal Pengambilan</label>
                            <input type="date" id="tglambil" name="tglambil" class="form-control">
                            <div class="invalid-feedback error_tglambil"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="grandtotal">Grand Total</label>
                            <input type="text" id="grandtotal" name="grandtotal" class="form-control" readonly onfocus="this.blur()">
                            <div class="invalid-feedback error_grandtotal"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="metodbayar">Metode Bayar</label>
                            <select id="metodbayar" name="metodbayar" class="form-control">
                                <option value="1">Tunai</option>
                                <option value="2">QRIS</option>
                                <option value="3">Bank</option>
                            </select>
                            <div class="invalid-feedback error_metodbayar"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header" style="display: flex; justify-content: space-between;">
                                <h3 class="card-title" style="font-size: x-large;" id="displayTotal"></h3>
                                <input type="hidden" for="grandtotal" name="grandtotal" id="grandtotal">
                                <div style="margin-left: auto;">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tempTabel" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Cucian</th>
                                                <th>Satuan</th>
                                                <th>berat</th>
                                                <th>total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a class="btn btn-secondary" href="<?= base_url() ?>cuciankeluar">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <?= form_close() ?>
        <!-- modal cari barang -->
        <div class="modal fade" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="modalObatLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalObatLabel">Pilih Cucian Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formcuciankeluar').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idcuciankeluar: $('#idcuciankeluar').val(),
                    nofak: $('#nofak').val(),
                    tglambil: $('#tglambil').val(),
                    metodbayar: $('#metodbayar').val(),
                },

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

                        if (err.error_tglambil) {
                            $('#tglambil').addClass('is-invalid').removeClass(
                                'is-valid');
                            $('.error_tglambil').html(err.error_tglambil);
                        } else {
                            $('#tglambil').removeClass('is-invalid').addClass(
                                'is-valid');
                            $('.error_tglambil').html('');
                        }
                        if (err.error_metodbayar) {
                            $('#metodbayar').addClass('is-invalid').removeClass('is-valid');
                            $('.error_metodbayar').html(err.error_metodbayar);
                        } else {
                            $('#metodbayar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_metodbayar').html('');
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
                            window.location.href =
                                '<?= site_url('/cuciankeluar') ?>';
                        }, 1500);
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });

            return false;
        });

        $('#modalObat').on('show.bs.modal', function(e) {
            var loader =
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/cuciankeluar/getmasuk', function(data) {
                $('#modalObat .modal-body').html(data);
            });
        });

    });

    function tampilMasuk() {
        let nofak = $('#nofak').val();
        if (nofak == '') {
            alert('Pilih Peminjaman Terlebih Dahulu !!!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('cuciankeluar/viewmasuk') ?>",
                data: {
                    nofak: nofak,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        $('#tempTabel').html(response.data);
                    }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>