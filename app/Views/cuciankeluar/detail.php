<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="invoice p-3 mb-3" style="background-color: #f4f6f9; color: #333;">
    <!-- title row -->
    <div class="row">
        <div class="col-12 text-center">
            <h4>
                <i class="fas"></i>
            </h4>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <img src="<?= base_url() ?>/assets/img/logo.png" alt="Farhan Laundry" style="width:150px; height:auto; margin:10px 0; background-color: #f4f6f9;">
                <h2 style="font-weight: bold;">FARHAN LAUNDRY</h2>
                <b style="font-size: 18px;">Nomor Faktur #<?= $cucianmasuk->nofak ?></b><br><br>
                <small class="float-left"><strong>Tanggal Masuk:</strong>
                    <?= date('d F Y', strtotime($cucianmasuk->tglmasuk)) ?></small><br>
                <small class="float-left"><strong>Tanggal Selesai:</strong>
                    <?= date('d F Y', strtotime($cucianmasuk->tglkeluar)) ?></small>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Farhan Laundry</strong><br>
                Jl. Maransi Aie Pacah Padang, Kota Padang, Sumatera Barat<br>
                Phone: 081234567890<br>
                Email: farhanlaundry@gmail.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 offset-sm-4 invoice-col" style="text-align: right;">
            To
            <address>
                <strong><?= $cucianmasuk->nama ?></strong><br>
                <?= $cucianmasuk->alamat ?><br>
                NoHp: <?= $cucianmasuk->nohp ?><br>
            </address>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped" style="background-color: #ffffff;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Cucian</th>
                        <th>Satuan</th>
                        <th>Berat</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail as $item) : ?>
                        <tr>
                            <td><?= $item['nomor'] ?></td>
                            <td><?= $item['jenis'] ?></td>
                            <td><?= $item['namasatuan'] ?></td>
                            <td><?= $item['berat'] ?></td>
                            <td>Rp <?= number_format($item['total'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
        </div>
        <!-- /.col -->
        <div class="col-6">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Total Pembayaran:</th>
                        <td>Rp <?= number_format($cucianmasuk->grandtotal, 2) ?></td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran:</th>
                        <td>
                            <?php
                            switch ($cucianmasuk->metodbayar) {
                                case 1:
                                    echo '<span class="badge badge-success">Tunai</span>';
                                    break;
                                case 2:
                                    echo '<span class="badge badge-danger">QRIS</span>';
                                    break;
                                case 3:
                                    echo '<span class="badge badge-primary">Transfer Bank</span>';
                                    break;
                                default:
                                    echo '<span class="badge badge-warning">Metode Pembayaran Tidak Diketahui</span>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="#" onclick="window.print();" class="btn btn-default" style="background-color: #4a5c68; color: white;">
                <i class="fas fa-print"></i> Print
            </a>
            <a href="<?= base_url() ?>/cucianmasuk" class="btn btn-primary float-right" style="margin-right: 5px; background-color: #2a3f54; border-color: #2a3f54;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <!-- <button type="button" class="btn btn-primary float-right" onclick="generatePDF()"
                style="margin-right: 5px; background-color: #2a3f54; border_color: #2a3f54;">
                <i class="fas fa-download"></i> Generate PDF
            </button> -->
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script>
        function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            doc.text('Hello world!', 10, 10);
            doc.save('example.pdf');
        }
    </script>
    <!-- isi konten end -->
    <?= $this->endSection() ?>
    <?= $this->section('script') ?>
    <?= $this->endSection() ?>