<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelPasien">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Perawatan</th>
                                    <th>Tanggal</th>
                                    <th>ID Pasien</th>
                                    <th>Nama Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Jenis Perawatan</th>
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


<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="modal-header"
                style="background-color: #20C997; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-pills mr-2"></i> Detail Perawatan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detail-content" style="overflow-y: auto;">
                <!-- Detail Perawatan akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelPasien').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/rdokter/viewcekperawatan',
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

    $(document).on('click', '.btn-resep', function() {
    var kode_perawatan = $(this).data('kode_perawatan');
    window.location.href = "<?php echo site_url('rdokter/formresep/'); ?>" + kode_perawatan;
});


function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Tutup modal jika mengklik diluar modal
window.onclick = function(event) {
    var modal = document.getElementById('detailModal');
    if (event.target == modal) {
        modal.classList.add('hidden');
    }
}
});

$(document).on('click', '.btn-detail', function() {
    var kode_perawatan = $(this).data('kode_perawatan');
    $.ajax({
        type: "GET",
        url: "<?= site_url('rdokter/detailperawatan/') ?>" + kode_perawatan,
        dataType: 'html',
        success: function(response) {
            $('#detail-content').html(response);
            $('#detailModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Gagal memuat detail perawatan');
        }
    });

});
</script>
<?= $this->endSection() ?>