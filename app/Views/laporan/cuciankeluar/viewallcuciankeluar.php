<table class="table table-bordered" style="width: 100%; margin: auto; border: 1px solid black;">
    <thead>
        <tr class="text-center" style="border: 1px solid black;">
            <th style="border: 1px solid black;">No</th>
            <th style="border: 1px solid black;">Nomor Faktur</th>
            <th style="border: 1px solid black;">Nama Konsumen</th>
            <th style="border: 1px solid black;">Tanggal Masuk</th>
            <th style="border: 1px solid black;">Tanggal Ambil</th>
            <th style="border: 1px solid black;">Total pembayaran</th>
            <th style="border: 1px solid black;">Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($cuciankeluar as $item) { ?>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;"><?= $no++ ?></td>
                <td style="border: 1px solid black;"><?= $item['nofak'] ?></td>
                <td style="border: 1px solid black;"><?= $item['nama'] ?></td>
                <td style="border: 1px solid black;"><?= date('d-m-Y', strtotime($item['tglmasuk'])) ?></td>
                <td style="border: 1px solid black;"><?= date('d-m-Y', strtotime($item['tglambil'])) ?></td>
                <td style="border: 1px solid black;">Rp <?= number_format($item['grandtotal'], 2, ',', '.') ?></td>
                <td style="border: 1px solid black;"><?= $item['metodbayar'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>