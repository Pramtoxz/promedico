<table class="table table-bordered" style="width: 100%; margin: auto;">
    <thead>
        <tr class="text-center">
            <th>No</th>
            <th>Nomor Faktur</th>
            <th>Nama Konsumen</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Ambil</th>
            <th>Total pembayaran</th>
            <th>Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($cuciankeluar as $item) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $item['nofak'] ?></td>
                <td><?= $item['nama'] ?></td>
                <td><?= date('d-m-Y', strtotime($item['tglmasuk'])) ?></td>
                <td><?= date('d-m-Y', strtotime($item['tglambil'])) ?></td>
                <td>Rp <?= number_format($item['grandtotal'], 2, ',', '.') ?></td>
                <td><?= $item['metodbayar'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>