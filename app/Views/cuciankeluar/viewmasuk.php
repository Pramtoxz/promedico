<table class="table-cucianmasuk">
    <thead class="thead-cucianmasuk">
        <tr class="tr-head-cucianmasuk">
            <th>No</th>
            <th>Jenis Cucian</th>
            <th>Satuan</th>
            <th>Berat</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody class="tbody-cucianmasuk">
        <?php $no = 1; ?>
        <?php foreach ($cucianmasuk as $cucian) : ?>
        <tr class="tr-body-cucianmasuk">
            <td><?= $no++ ?></td>
            <td><?= $cucian['jenis'] ?></td>
            <td><?= $cucian['namasatuan'] ?></td>
            <td><?= $cucian['berat'] ?></td>
            <td><?= $cucian['total'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>