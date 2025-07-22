<div class="card shadow-sm">
    <div class="card-header bg-teal text-white">
        <h5 class="card-title mb-0"><i class="fas fa-calendar-check mr-2"></i> Detail Booking #<?= $booking['idbooking'] ?></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td width="30%" class="font-weight-bold">Kode Booking</td>
                        <td width="5%">:</td>
                        <td><?= $booking['idbooking'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Tanggal</td>
                        <td>:</td>
                        <td><?= date('d F Y', strtotime($booking['tanggal'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Waktu</td>
                        <td>:</td>
                        <td><?= $booking['waktu_mulai'] ?> - <?= $booking['waktu_selesai'] ?> (<?= $booking['hari'] ?>)</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Status</td>
                        <td>:</td>
                        <td>
                            <?php 
                            $badgeClass = '';
                            switch($booking['status']) {
                                case 'pending':
                                    $badgeClass = 'badge badge-warning';
                                    break;
                                case 'diterima':
                                    $badgeClass = 'badge badge-success';
                                    break;
                                case 'ditolak':
                                    $badgeClass = 'badge badge-danger';
                                    break;
                                default:
                                    $badgeClass = 'badge badge-secondary';
                            }
                            ?>
                            <span class="<?= $badgeClass ?>"><?= ucfirst($booking['status']) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Pasien</td>
                        <td>:</td>
                        <td><?= $booking['nama_pasien'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Dokter</td>
                        <td>:</td>
                        <td><?= $booking['nama_dokter'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jenis Perawatan</td>
                        <td>:</td>
                        <td><?= $booking['namajenis'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Estimasi Durasi</td>
                        <td>:</td>
                        <td><?= $booking['estimasi'] ?> menit</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Biaya</td>
                        <td>:</td>
                        <td>Rp <?= number_format($booking['harga'], 0, ',', '.') ?></td>
                    </tr>
                    <?php if (!empty($booking['catatan'])) : ?>
                    <tr>
                        <td class="font-weight-bold">Catatan</td>
                        <td>:</td>
                        <td><?= $booking['catatan'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($booking['bukti_bayar'])) : ?>
                    <tr>
                        <td class="font-weight-bold">Bukti Pembayaran</td>
                        <td>:</td>
                        <td>
                            <a href="<?= base_url('uploads/bukti_bayar/' . $booking['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-eye mr-1"></i> Lihat Bukti Pembayaran
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="font-weight-bold">Dibuat pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($booking['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Diperbarui pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($booking['updated_at'])) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>