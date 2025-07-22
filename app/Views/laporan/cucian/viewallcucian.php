<table class="table table-bordered" style="border: 1px solid black; width: 80%; margin: auto;">
    <thead>
        <tr class="text-center" style="border: 1px solid black;">
            <th style="width: 5%; border: 1px solid black;">No</th>
            <th style="width: 20%; border: 1px solid black;">Kode</th>
            <th style="width: 50%; border: 1px solid black;">Cucian</th>
            <th style="width: 25%; border: 1px solid black;">Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($paket as $item) { ?>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;"><?= $no++ ?></td>
                <td style="border: 1px solid black;"><?= $item['kdjeniscucian'] ?? $item['kdsatuan'] ?></td>
                <td style="border: 1px solid black;"><?= $item['jenis'] ?? $item['namasatuan'] ?></td>
                <td style="border: 1px solid black;">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>