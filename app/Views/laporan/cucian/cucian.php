<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="card card-navy">
        <div class="card-header">
            <h3 class="card-title">Laporan Cucian</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <div class="col-10 input-group">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="ViewLaporanSemua()">View Semua</button>
                                <button class="btn btn-primary" onclick="ViewLaporanJenis()">Jenis Cucian</button>
                                <button class="btn btn-primary" onclick="ViewLaporanSatuan()">Satuan</button>
                                <button class="btn btn-success" onclick="PrintLaporan()"><i class="fas fa-print"></i>
                                    Print</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="printHalaman" style="font-size: 13px;">
                <div class="text-center">
                    <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo Promedico" style="height: 100px;">
                    <h4><b>Laporan Cucian</b></h4>
                </div>
                <div class="tabelViewAllWedding"></div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                    <div></div>
                    <div>
                        <?php $tanggal = date('Y-m-d'); ?>
                        <p>Padang, <?= $tanggal ?></p>
                        <p style="margin-top: 80px;">Pimpinan</p>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->endSection() ?>
        <?= $this->section('script') ?>

        <script>
            function ViewLaporanSemua() {
                $.ajax({
                    type: "get",
                    url: "<?= base_url('laporan/viewall-laporancucian') ?>",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.data) {
                            $('.tabelViewAllWedding').html(response.data);
                        }
                    }
                });
            }

            function ViewLaporanJenis() {
                $.ajax({
                    type: "get",
                    url: "<?= base_url('laporan/viewall-laporanjenis') ?>",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.data) {
                            $('.tabelViewAllWedding').html(response.data);
                        }
                    }
                });
            }

            function ViewLaporanSatuan() {
                $.ajax({
                    type: "get",
                    url: "<?= base_url('laporan/viewall-laporansatuan') ?>",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.data) {
                            $('.tabelViewAllWedding').html(response.data);
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
        </script>
        <?= $this->endSection() ?>