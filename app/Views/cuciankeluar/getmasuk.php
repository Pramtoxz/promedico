<div class="table-responsive datatable-minimal mt-6">
    <table class="table table-hover" id="tabelObat">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Selesai</th>
                <th>Grandtotal</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelObat').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/cuciankeluar/viewgetmasuk',
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
        var nofak = $(this).data('nofak');
        var tglmasuk = $(this).data('tglmasuk');
        var tglkeluar = $(this).data('tglkeluar');
        var grandtotal = $(this).data('grandtotal');
        $('#nofak').val(nofak);
        $('#tglmasuk').val(tglmasuk);
        $('#tglkeluar').val(tglkeluar);
        $('#grandtotal').val(grandtotal);

        $('#modalObat').modal('hide').on('hidden.bs.modal', function() {
            tampilMasuk();
        });
    });
});
</script>