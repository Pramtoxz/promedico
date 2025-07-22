<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Tambah Cucian Masuk</h3>
            </div>

            <div class="card-body">
                <?= form_open('/cucianmasuk/update', ['id' => 'formeditcucianmasuk', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nofak">NO FAKTUR</label>
                            <input type="text" id="nofak" name="nofak" class="form-control"
                                value="<?= $cucianmasuk['nofak'] ?>" readonly>
                            <div class="invalid-feedback error_nofak"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tglmasuk">Tanggal Masuk</label>
                            <input type="date" id="tglmasuk" name="tglmasuk" class="form-control"
                                value="<?= $cucianmasuk['tglmasuk'] ?>">
                            <div class="invalid-feedback error_tglmasuk"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tglkeluar">Tanggal Keluar</label>
                            <input type="date" id="tglkeluar" name="tglkeluar" class="form-control"
                                value="<?= $cucianmasuk['tglkeluar'] ?>">
                            <div class="invalid-feedback error_tglkeluar"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jenis">Jenis Cucian</label>
                            <div class="input-group">
                                <input type="hidden" id="kdjeniscucian" name="kdjeniscucian" class="form-control"
                                    readonly>
                                <input type="text" id="jenis" name="jenis" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal"
                                        data-target="#modalObat">Cari</button>
                                </div>
                                <div class="invalid-feedback error_jenis"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <div class="input-group">
                                <input type="hidden" id="kdsatuan" name="kdsatuan" class="form-control" readonly>
                                <input type="text" id="namasatuan" name="namasatuan" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal"
                                        data-target="#modalSatuan">Cari</button>
                                </div>
                                <div class="invalid-feedback error_namasatuan"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" class="form-control" readonly>
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="berat">Berat</label>
                            <input type="number" id="berat" name="berat" class="form-control">
                            <div class="invalid-feedback error_berat"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="number" id="total" name="total" class="form-control">
                            <div class="invalid-feedback error_total"></div>
                        </div>
                    </div>
                    <div class="col-sm-1" style="margin-top: 30px;">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="addTemp">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="idkonsumen">Pelanggan</label>
                            <select id="idkonsumen" name="idkonsumen" class="form-control select2bs4">
                                <option value="<?= $cucianmasuk['idkonsumen'] ?>"><?= $cucianmasuk['idkonsumen'] ?> -
                                    <?= $namaKonsumen ?></option>
                                <?php foreach ($konsumen as $s) : ?>
                                <option value="<?= $s['idkonsumen'] ?>"><?= $s['idkonsumen'] ?> - <?= $s['nama'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_idkonsumen"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header" style="display: flex; justify-content: space-between;">
                                <h3 class="card-title" style="font-size: x-large;" id="displayTotal"></h3>
                                <input type="hidden" name="grandtotal" id="grandtotal">
                                <div style="margin-left: auto;">
                                    <button type="button" class="btn btn-danger btn-sm" id="clearAll">
                                        <i class="fas fa-trash"></i> Kosongkan Semua
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tempTabel" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis</th>
                                                <th>Satuan</th>
                                                <th>Berat</th>
                                                <th>Harga</th>
                                                <th class="no-short">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card">
                            <div class="form-group d-flex justify-content-between">
                                <div class="row" style="margin-left: 20px;">
                                    <div class="col-md-10">
                                        <label for="grandtotal">Total</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input type="text" id="grandtotal" name="grandtotal" class="form-control"
                                                readonly>
                                            <div class="invalid-feedback error_grandtotal"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="card">
                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a class="btn btn-secondary" href="<?= base_url() ?>cucianmasuk">Kembali</a>
                    </div>

                </div>
            </div>
        </div>

        <?= form_close() ?>
        <!-- modal cari barang -->
        <div class="modal fade" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="modalObatLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalObatLabel">Pilih Jenis</h5>
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

        <div class="modal fade" id="modalSatuan" tabindex="-1" role="dialog" aria-labelledby="modalSatuanLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSatuanLabel">Pilih Satuan</h5>
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
    $('#formeditcucianmasuk').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: {
                nofak: $('#nofak').val(),
                tglmasuk: $('#tglmasuk').val(),
                tglkeluar: $('#tglkeluar').val(),
                idkonsumen: $('#idkonsumen').val(),
                grandtotal: $('#grandtotal').val(),
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

                    if (err.error_nofak) {
                        $('#nofak').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nofak').html(err.error_nofak);
                    } else {
                        $('#nofak').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nofak').html('');
                    }
                    if (err.error_tglmasuk) {
                        $('#tglmasuk').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tglmasuk').html(err.error_tglmasuk);
                    } else {
                        $('#tglmasuk').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tglmasuk').html('');
                    }

                    if (err.error_tglkeluar) {
                        $('#tglkeluar').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tglkeluar').html(err.error_tglkeluar);
                    } else {
                        $('#tglkeluar').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tglkeluar').html('');
                    }

                    if (err.error_idkonsumen) {
                        $('#idkonsumen').addClass('is-invalid').removeClass('is-valid');
                        $('.error_idkonsumen').html(err.error_idkonsumen);
                    } else {
                        $('#idkonsumen').removeClass('is-invalid').addClass('is-valid');
                        $('.error_idkonsumen').html('');
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
                            '<?= site_url('/cucianmasuk') ?>';
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
        $.get('<?= base_url() ?>/cucianmasuk/getjenis', function(data) {
            $('#modalObat .modal-body').html(data);
        });
    });


    $('#modalSatuan').on('show.bs.modal', function(e) {
        var loader =
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Load data here from the server
        $.get('<?= base_url() ?>/cucianmasuk/getsatuan', function(data) {
            $('#modalSatuan .modal-body').html(data);
        });
    });


    $('#berat').on('input', function() {
        var harga = $('#harga').val();
        var berat = $(this).val();
        var total = harga * berat;
        $('#total').val(total);
    });

    $('#addTemp').on('click', function() {
        $.ajax({
            type: "POST",
            url: '/cucianmasuk/addtemp',
            data: {
                kdjeniscucian: $('#kdjeniscucian').val(),
                kdsatuan: $('#kdsatuan').val(),
                berat: $('#berat').val(),
                total: $('#total').val(),
            },
            dataType: "json",
            beforeSend: function() {
                $('#addTemp').html('<i class="fas fa-spin fa-spinner"></i>');
                $('#addTemp').prop('disabled', true);
            },
            complete: function() {
                $('#addTemp').html('<i class="fas fa-plus"></i>');
                $('#addTemp').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;
                    if (err.error_berat) {
                        $('#berat').addClass('is-invalid').removeClass(
                            'is-valid');
                        $('.error_berat').html(err.error_berat);
                    } else {
                        $('#berat').removeClass('is-invalid').addClass(
                            'is-valid');
                        $('.error_berat').html('');
                    }
                }

                if (response.sukses) {
                    $('#berat').removeClass('is-invalid');
                    $('.error_berat').html('');
                    $('#tempTabel').DataTable().ajax.reload();
                    $('#kdjeniscucian').val('');
                    $('#kdsatuan').val('');
                    $('#berat').val('');
                    $('#total').val('');
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "<?php echo route_to('cucianmasuk.deletetemp'); ?>",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.sukses) {
                    $('#tempTabel').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menghapus data',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal menghapus data',
                    icon: 'error'
                });
            }
        });

    });

    $(document).on('click', '#clearAll', function() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin mengosongkan semua?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo route_to('cucianmasuk.deletealltemp'); ?>",

                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.sukses,
                                icon: 'success'
                            });
                            // Refresh DataTable
                            $('#tempTabel').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });


});

$(document).ready(function() {
    var table = $('#tempTabel').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/cucianmasuk/viewtemp',
        info: false,
        ordering: false,
        paging: false,
        searching: false,
        responsive: true, // Menambahkan opsi responsive
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });
    table.on('draw', function() {
        var total = 0;
        table.column(4, {
            search: 'applied'
        }).data().each(function(value, index) {
            total += parseFloat(
                value); // Memastikan bahwa kolom total adalah kolom ke-5 (index 4)
        });

        var formattedTotal = 'Rp ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        $('#displayTotal').text(
            formattedTotal
        ); // Menampilkan total di elemen dengan id 'displayTotal' dengan format Rupiah
        $('#grandtotal').val(
            total); // Memasukkan total yang sudah diformat ke dalam input dengan id 'grandtotal'
    });


});
</script>
<?= $this->endSection() ?>