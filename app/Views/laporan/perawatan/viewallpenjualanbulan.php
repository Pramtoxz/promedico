<text>Bulan :</text> <b><?= $bulan ?></b>
<text>Tahun :</text> <b><?= $tahun ?></b>
<br><br>
<table class="table table-bordered" style="border: 1px solid; font-size: 13px;">
    <thead>
        <tr class="text-center">
            <th style="width: 15px;">No</th>
            <th>Kode Penjualan</th>
            <th>Pelanggan</th>
            <th>Tanggal Penjualan</th>
            <th>Kode Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $prev_kdpenjualan = null;
        $total_grandtotal = 0; ?>
        <?php foreach ($penjualan as $item) { ?>
            <tr>
                <?php if ($prev_kdpenjualan != $item['kdpenjualan']) { ?>
                    <td rowspan="<?= count(array_filter($penjualan, function ($v) use ($item) {
                                        return $v['kdpenjualan'] == $item['kdpenjualan'];
                                    })) ?>"><?= $no ?></td>
                    <td rowspan="<?= count(array_filter($penjualan, function ($v) use ($item) {
                                        return $v['kdpenjualan'] == $item['kdpenjualan'];
                                    })) ?>"><?= $item['kdpenjualan'] ?></td>
                    <td rowspan="<?= count(array_filter($penjualan, function ($v) use ($item) {
                                        return $v['kdpenjualan'] == $item['kdpenjualan'];
                                    })) ?>"><?= $item['nama'] ?></td>
                    <td rowspan="<?= count(array_filter($penjualan, function ($v) use ($item) {
                                        return $v['kdpenjualan'] == $item['kdpenjualan'];
                                    })) ?>"><?= $item['tglpenjualan'] ?></td>
                <?php } ?>
                <td><?= $item['kdbarang'] ?></td>
                <td><?= "Rp " . number_format($item['hargajual'], 2, ',', '.') ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td><?= "Rp " . number_format($item['totalharga'], 2, ',', '.') ?></td>
                <?php if ($prev_kdpenjualan != $item['kdpenjualan']) { ?>
                    <td rowspan="<?= count(array_filter($penjualan, function ($v) use ($item) {
                                        return $v['kdpenjualan'] == $item['kdpenjualan'];
                                    })) ?>"><?= "Rp " . number_format($item['grandtotal'], 2, ',', '.') ?></td>
                <?php } ?>
            </tr>
            <?php if ($prev_kdpenjualan != $item['kdpenjualan']) {
                $no++;
                $total_grandtotal += $item['grandtotal'];
                $prev_kdpenjualan = $item['kdpenjualan'];
            } ?>
        <?php } ?>
        <tr>
            <td colspan="8" class="text-right"><strong>Total Keseluruhan:</strong></td>
            <td><strong><?= "Rp " . number_format($total_grandtotal, 2, ',', '.') ?></strong></td>
        </tr>
    </tbody>
</table>