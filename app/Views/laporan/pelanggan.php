<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="card card-navy">
        <div class="card-header">
            <h3 class="card-title">Laporan Pelanggan</h3>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="col-10 input-group">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="ViewLaporanSemua()">View Laporan</button> <br>
                                <button class="btn btn-success" onclick="PrintLaporan()"><i class="fas fa-print"></i>Print</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row-sm-12" id="printHalaman">
                <div class="text-center">
                    <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo Promedico" style="height: 100px;">
                    <h4><b>Laporan Pelanggan</b></h4>
                </div>
                <div class="tabelPelanggan">

                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div></div>
                    <?php $tanggal = date('Y-m-d'); ?>
                    <div style="text-align: center;">
                        <p>Padang, <?= $tanggal ?></p>
                        <p style="margin-top: 5rem;">Pimpinan</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>

<script>
    function ViewLaporanSemua() {
        $.ajax({
            type: "get",
            url: "<?= base_url('laporan/viewall-laporanpelanggan') ?>",
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.tabelPelanggan').html(response.data);
                }
            }
        });
    }

    function PrintLaporan() {
        var printContent = document.getElementById('printHalaman');
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function ViewLaporanPertahun() {
        let tahun = $('#tahun1').val();
        if (tahun == '') {
            alert('Tahun Belum Dipilih !!!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('laporan/viewlaporanobatmasuk') ?>",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        $('.tabelperbulan').html(response.data);
                    }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>