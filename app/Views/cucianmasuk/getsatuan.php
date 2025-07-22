<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelSatuan">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Satuan</th>
                <th>Nama Satuan</th>
                <th>Harga</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelSatuan').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("cucianmasuk/viewGetSatuan") ?>',
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

$(document).ready(function() {
    $(document).on('click', '.btn-pilihsatuan', function() {
        var kdsatuan = $(this).data('kdsatuan');
        var namasatuan = $(this).data('namasatuan');
        var harga = $(this).data('harga');
        $('#kdsatuan').val(kdsatuan);
        $('#namasatuan').val(namasatuan);
        $('#harga').val(harga);

        $('#modalSatuan').modal('hide').on('hidden.bs.modal', function() {
            $('#harga').focus();
            $('#kdjeniscucian').val('');
            $('#jenis').val('');
        });
    });
});
</script>