<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelJenis">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Jenis</th>
                <th>Jenis Cucian</th>
                <th>Harga</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelJenis').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("cucianmasuk/viewGetJenis") ?>',
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
    $(document).on('click', '.btn-pilihobat', function() {
        var kdjeniscucian = $(this).data('kdjeniscucian');
        var jenis = $(this).data('jenis');
        var harga = $(this).data('harga');
        $('#kdjeniscucian').val(kdjeniscucian);
        $('#jenis').val(jenis);
        $('#harga').val(harga);

        $('#modalObat').modal('hide').on('hidden.bs.modal', function() {
            $('#harga').focus();
            $('#kdsatuan').val('');
            $('#namasatuan').val('');
        });
    });
});
</script>