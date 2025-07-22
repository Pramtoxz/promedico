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
                        <a href="<?= site_url('cucianmasuk/tambah') ?>" class="btn" style="background-color: #131842; color: white;">
                            <span class="d-none d-md-inline">Tambah Data</span>
                            <span class="d-inline d-md-none"><i class="fas fa-plus"></i></span>
                        </a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="produkTabel" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Faktur</th>
                                    <th>Konsumen</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
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
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var table = $('#produkTabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url("cucianmasuk/view") ?>',
            info: true,
            ordering: true,
            paging: true,
            responsive: true, // Menambahkan opsi responsive
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }],
        });

        // Fungsi untuk membuat DataTable responsif ketika sidebar di-hide
        $('#sidebarToggle').on('click', function() {
            table.columns.adjust().responsive.recalc();
        });

        $(document).on('click', '.btn-delete', function() {
            var nofak = $(this).data('nofak');

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
                        url: "<?= route_to('nofak.delete') ?>",
                        data: {
                            nofak: nofak
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#produkTabel').DataTable().ajax.reload();
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
        $(document).on('click', '.btn-status', function() {
            var nofak = $(this).data('nofak');

            Swal.fire({
                title: 'Apakah Anda yakin ingin Mengubah Status ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ganti Status!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('/cucianmasuk/ubahstatus'); ?>",
                        data: {
                            nofak: nofak
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#produkTabel').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal mengubah status',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal mengubah status',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.btn-edit', function() {
        var nofak = $(this).data('nofak');
        window.location.href = "<?= site_url('cucianmasuk/edit/') ?>" + nofak;
    });


    $(document).on('click', '.btn-detail', function() {
        var nofak = $(this).data('nofak');
        window.location.href = "<?= site_url('cucianmasuk/detail/') ?>" + nofak;
    });
</script>
<?= $this->endSection() ?>