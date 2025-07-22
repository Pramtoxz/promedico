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
        <div class="col-12">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="font-weight: bold; text-align: right;">Total Pembayaran:</th>
                        <td style="font-weight: bold; text-align: right;">Rp
                            <?= number_format($cucianmasuk->grandtotal, 2) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="text-center">
                <p><strong>Silakan scan kode QR berikut untuk melacak status cucian Anda:</strong></p>
                <img src="<?= $qrCodeImage ?>" alt="Kode QR" style="width: 110px; margin-top: 20px;">
            </div>
        </div>
        <div class="col-6">
            <div class="text-center">
                <p><strong>Padang, <?= date('d F Y') ?></strong></p>
                <img src="<?= base_url() ?>/assets/img/logo.png" alt="Tanda Tangan" style="width: 150px; margin-top: 20px;">
                <p><strong>Pimpinan</strong></p>
                <p></p>
            </div>
        </div>
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
    <?= $this->endSection() ?>
    <?= $this->section('script') ?>
    <!-- Script tambahan jika ada -->
    <?= $this->endSection() ?>