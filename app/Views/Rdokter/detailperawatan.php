<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-8">
        <div class="card shadow-lg h-100">
            <div class="card-header bg-teal text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i> Informasi Perawatan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Kode Perawatan</div>
                    <div class="col-md-8"><?= $perawatan['kode_perawatan'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Tanggal</div>
                    <div class="col-md-8"><?= $perawatan['tanggal'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nama Pasien</div>
                    <div class="col-md-8"><?= $perawatan['nama_pasien'] ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Jenis Perawatan</div>
                    <div class="col-md-8"><?= $perawatan['nama_jenis'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Catatan</div>
                    <div class="col-md-8"><?= $perawatan['catatan'] ?></div>
                </div>
                <div class="row">
                    <div class="col-md-4 font-weight-bold">Resep</div>
                    <div class="col-md-8"><?= $perawatan['resep'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>