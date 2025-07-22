<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Edit Data Cucian Keluar</h3>
            </div>

            <div class="card-body">
                <?= form_open('cuciankeluar/update', ['id' => 'formcuciankeluaredit', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nofak">Nomor Faktur</label>
                            <input type="text" id="nofak" name="nofak" class="form-control"
                                value="<?= $cuciankeluar['nofak'] ?>" readonly>
                            <input type="hidden" id="idcuciankeluar" name="idcuciankeluar" class="form-control"
                                value="<?= $cuciankeluar['idcuciankeluar'] ?>" readonly>
                            <div class="invalid-feedback error_idcuciankeluar"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Konsumen</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                value="<?= $cucianmasuk['nama'] ?>" readonly>
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglmasuk">Tanggal Masuk</label>
                            <input type="date" id="tglmasuk" name="tglmasuk" class="form-control"
                                value="<?= $cucianmasuk['tglmasuk'] ?>" readonly>
                            <div class="invalid-feedback error_tglmasuk"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglkeluar">Tanggal Selesai</label>
                            <input type="date" id="tglkeluar" name="tglkeluar" class="form-control"
                                value="<?= $cucianmasuk['tglkeluar'] ?>" readonly>
                            <div class="invalid-feedback error_tglkeluar"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="grandtotal">Grand Total</label>
                            <input type="text" id="displayGrandtotal" class="form-control"
                                value="<?= 'Rp ' . number_format($cucianmasuk['grandtotal'], 2, ',', '.') ?>" readonly>
                            <input type="hidden" id="grandtotal" name="grandtotal"
                                value="<?= $cucianmasuk['grandtotal'] ?>">
                            <div class="invalid-feedback error_grandtotal"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglambil">Tanggal Penjemputan</label>
                            <input type="date" id="tglambil" name="tglambil" class="form-control"
                                value="<?= $cuciankeluar['tglambil'] ?>" required
                                oninput="validateTanggalPenjemputan()">
                            <div class="invalid-feedback error_tglambil">Tanggal penjemputan harus diisi.</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="bayargrandtotal">Jumlah Pembayaran</label>
                            <input type="number" id="bayargrandtotal" name="bayargrandtotal" class="form-control"
                                value="" placeholder="Masukkan jumlah pembayaran" oninput="updateDisplayAndKembalian()">
                            <div class="invalid-feedback error_bayargrandtotal"></div>
                        </div>
                        <div class="form-group">
                            <label for="totalpembayaran">Kembalian</label>
                            <input type="text" id="totalpembayaran" name="totalpembayaran"
                                class="form-control form-control-lg" readonly
                                style="font-size: 24px; height: auto; padding: 20px;">
                            <div class="invalid-feedback error_totalpembayaran"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="metodbayar">Metode Pembayaran</label>
                        <select id="metodbayar" name="metodbayar" class="form-control" required
                            onchange="validatePaymentMethod()">
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="1">Tunai</option>
                            <option value="2">QRIS</option>
                            <option value="3">Transfer Bank</option>
                        </select>
                        <div class="invalid-feedback error_metodbayar">Harus memilih salah satu metode pembayaran.</div>
                    </div>
                </div>
                <div class="form-group" style="text-align: right;">
                    <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url('cuciankeluar') ?>">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card"
        style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">

    </div>
</div>
<!-- Card Preview -->
<?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formcuciankeluaredit').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: {
                idcuciankeluar: $('#idcuciankeluar').val(),
                tglambil: $('#tglambil').val(),
                metodbayar: $('#metodbayar').val(),
            },

            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html(
                    '<i class="fas fa-spin fa-spinner"></i> Tunggu');
                $('#tombolSimpan').prop('disabled', true);
            },

            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_tglambil) {
                        $('#tglambil').addClass('is-invalid').removeClass(
                            'is-valid');
                        $('.error_tglambil').html(err.error_tglambil);
                    } else {
                        $('#tglambil').removeClass('is-invalid').addClass(
                            'is-valid');
                        $('.error_tglambil').html('');
                    }
                    if (err.error_metodbayar) {
                        $('#metodbayar').addClass('is-invalid').removeClass('is-valid');
                        $('.error_metodbayar').html(err.error_metodbayar);
                    } else {
                        $('#metodbayar').removeClass('is-invalid').addClass('is-valid');
                        $('.error_metodbayar').html('');
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = '<?= site_url('cuciankeluar') ?>';
                    }, 1500);
                }
            },

            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });

        return false;
    });
});

function validateTanggalPenjemputan() {
    var tglambil = document.getElementById('tglambil').value;
    if (!tglambil) {
        document.querySelector('.error_tglambil').style.display = 'block';
    } else {
        document.querySelector('.error_tglambil').style.display = 'none';
    }
}

function validatePaymentMethod() {
    var paymentMethod = document.getElementById('metodbayar').value;
    if (paymentMethod !== '1' && paymentMethod !== '2' && paymentMethod !== '3') {
        document.querySelector('.error_metodbayar').style.display = 'block';
    } else {
        document.querySelector('.error_metodbayar').style.display = 'none';
    }
}

function updateDisplayAndKembalian() {
    var grandTotal = parseFloat($('#grandtotal').val());
    var bayar = parseFloat($('#bayargrandtotal').val());
    var kembalian = bayar - grandTotal;
    $('#totalpembayaran').val(kembalian > 0 ? 'Rp ' + kembalian.toFixed(2).replace('.', ',')
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.') :
        'Rp 0,00');
    $('#displayTotal').text(kembalian > 0 ? 'Rp ' + kembalian.toFixed(2).replace('.', ',').replace(
            /\B(?=(\d{3})+(?!\d))/g, '.') :
        'Rp 0,00');
}
</script>
<?= $this->endSection() ?>