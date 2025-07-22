<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-navy">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('cuciankeluar/tambah') ?>" class="btn"
                            style="background-color: #131842; color: white;">
                            <span class="d-none d-md-inline">Tambah Data</span>
                            <span class="d-inline d-md-none"><i class="fas fa-plus"></i></span>
                        </a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-12">
                        <table class="table table-hover" id="tabelPengembalian">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Faktur</th>
                                    <th>Nama Konsumen</th>
                                    <th>Tgl Ambil</th>
                                    <th>Grand Total</th>
                                    <th>Metode Bayar</th>
                                    <th class="no-short">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Cucian Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Detail cucian keluar akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelPengembalian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/cuciankeluar/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    $(document).on('click', '.btn-delete', function() {
        var idcuciankeluar = $(this).data('idcuciankeluar');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data ini?',
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
                    url: "<?php echo route_to('cuciankeluar.delete'); ?>",
                    data: {
                        idcuciankeluar: idcuciankeluar
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.success,
                                icon: 'success'
                            });
                            // Refresh DataTable
                            $('#tabelPengembalian').DataTable().ajax.reload();
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

$(document).on('click', '.btn-edit', function() {
    var idcuciankeluar = $(this).data('idcuciankeluar');
    window.location.href = "<?php echo site_url('cuciankeluar/edit/'); ?>" + idcuciankeluar;
});

$(document).on('click', '.btn-detail', function() {
    var idcuciankeluar = $(this).data('idcuciankeluar');
    window.location.href = "<?php echo site_url('cuciankeluar/detail/'); ?>" + idcuciankeluar;
});
</script>
<?= $this->endSection() ?>