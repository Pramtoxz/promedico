<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="<?= base_url('tamu') ?>">Data Tamu</a> /</span> Edit Tamu
    </h4>

    <?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Form Edit Tamu</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('tamu/update/' . $tamu['nik']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="nik">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nik" name="nik" 
                                    value="<?= old('nik', $tamu['nik']) ?>" readonly />
                                <div class="form-text">NIK tidak dapat diubah</div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama" 
                                    value="<?= old('nama', $tamu['nama']) ?>" required />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="nohp">No HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nohp" name="nohp" 
                                    value="<?= old('nohp', $tamu['nohp']) ?>" required />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="jenkel">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="jenkel" name="jenkel" required>
                                    <option value="" disabled>Pilih Jenis Kelamin</option>
                                    <option value="L" <?= old('jenkel', $tamu['jenkel']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenkel', $tamu['jenkel']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="tgllahir">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tgllahir" name="tgllahir" 
                                    value="<?= old('tgllahir', $tamu['tgllahir']) ?>" required />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $tamu['alamat']) ?></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <a href="<?= base_url('tamu') ?>" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 