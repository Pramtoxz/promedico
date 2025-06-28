<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><?= $title ?></span>
    </h4>

    <!-- Alert Area -->
    <div id="alert-container"></div>

    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Tamu</h5>
            <a href="<?= base_url('tamu/create') ?>" class="btn btn-primary">
                <i class="icon-base ri ri-add-line"></i> Tambah Tamu
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" id="tamu-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th class="no-sort" style="width: 80px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus tamu <strong id="delete-tamu-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Tamu Detail Modal -->
<div class="modal fade" id="tamuDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tamuDetailModalTitle">Detail Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tamu-detail-content">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-circle bg-primary" id="tamu-avatar-initial"></span>
                        </div>
                        <h4 class="my-2" id="tamu-name">...</h4>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">NIK</div>
                        <div class="col-8" id="tamu-nik">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Nama</div>
                        <div class="col-8" id="tamu-nama">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">No HP</div>
                        <div class="col-8" id="tamu-nohp">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Jenis Kelamin</div>
                        <div class="col-8" id="tamu-jenkel">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Tanggal Lahir</div>
                        <div class="col-8" id="tamu-tgllahir">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Alamat</div>
                        <div class="col-8" id="tamu-alamat">...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <a href="#" class="btn btn-primary" id="btn-edit-tamu">
                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat User untuk Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Alert untuk error dalam modal -->
                <div id="modal-alert-container"></div>
                
                <form id="createUserForm">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="user-tamu-name" readonly>
                        <input type="hidden" id="user-tamu-nik">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback" id="username-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback" id="email-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback" id="password-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-save-user">Simpan</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<style>
/* CSS untuk mencegah tabel bergoyang */
.action-wrapper {
    min-width: 80px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.dropdown-menu {
    min-width: 10rem;
}
table.dataTable td {
    vertical-align: middle;
}
table.dataTable .action-dropdown {
    display: inline-block;
    margin-right: 0.5rem;
}
</style>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan notifikasi 
    function showNotification(message, type = 'success') {
        // Hapus notifikasi sebelumnya
        $('#alert-container').empty();
        
        // Tambahkan notifikasi baru
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('#alert-container').html(alertHtml);
        
        // Otomatis hilangkan notifikasi setelah 5 detik
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Fungsi untuk menampilkan pesan error di modal
    function showModalAlert(message, type = 'danger') {
        $('#modal-alert-container').html(`
            <div class="alert alert-${type} alert-dismissible mb-3" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    $('#tamu-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= site_url('tamu/viewtamu') ?>",
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'asc']],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-sort"]
        }],
        "drawCallback": function() {
            $('[data-bs-toggle="dropdown"]').dropdown();
        }
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        var tamuId = $(this).data('id');
        var tamuName = $(this).data('name');
        
        $('#delete-tamu-name').text(tamuName);
        $('#deleteModal').modal('show');
        
        $('#confirm-delete').off().on('click', function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('tamu/delete') ?>",
                data: {
                    id: tamuId
                },
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        showNotification(response.message, 'success');
                        $('#tamu-table').DataTable().ajax.reload();
                    } else {
                        showNotification(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    console.error(xhr.responseText);
                    showNotification('Terjadi kesalahan saat menghapus tamu', 'danger');
                }
            });
        });
    });
    
    // Handle detail button click
    $(document).on('click', '.btn-detail', function() {
        var tamuId = $(this).data('id');
        
        // Load tamu details via AJAX
        $.ajax({
            type: "POST",
            url: "<?= site_url('tamu/detail') ?>",
            data: {
                id: tamuId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const tamu = response.data;
                    
                    // Set tamu avatar initial (first letter of name)
                    const nameInitial = tamu.nama ? tamu.nama.charAt(0) : 'T';
                    $('#tamu-avatar-initial').text(nameInitial.toUpperCase());
                    
                    // Fill in tamu details
                    $('#tamu-name').text(tamu.nama || 'Tamu ID ' + tamu.nik);
                    $('#tamu-nik').text(tamu.nik);
                    $('#tamu-nama').text(tamu.nama);
                    $('#tamu-nohp').text(tamu.nohp);
                    $('#tamu-jenkel').text(tamu.jenkel);
                    $('#tamu-tgllahir').text(formatDate(tamu.tgllahir));
                    $('#tamu-alamat').text(tamu.alamat);
                    
                    // Update edit button link
                    $('#btn-edit-tamu').attr('href', '<?= base_url('tamu/edit') ?>/' + tamu.nik);
                    
                    // Show modal
                    $('#tamuDetailModal').modal('show');
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showNotification('Terjadi kesalahan saat memuat detail tamu', 'danger');
            }
        });
    });
    
    // Handle create user button click
    $(document).on('click', '.btn-create-user', function() {
        var tamuId = $(this).data('id');
        var tamuName = $(this).data('name');
        
        $('#user-tamu-name').val(tamuName);
        $('#user-tamu-nik').val(tamuId);
        
        // Reset form
        $('#modal-alert-container').empty();
        $('#createUserForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        
        // Show modal
        $('#createUserModal').modal('show');
    });
    
    // Handle save user button click
    $('#btn-save-user').on('click', function() {
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var tamuNik = $('#user-tamu-nik').val();
        
        // Reset error states
        $('#modal-alert-container').empty();
        $('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            type: "POST",
            url: "<?= site_url('tamu/createUserForTamu') ?>",
            data: {
                nik: tamuNik,
                username: username,
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tutup modal dan tampilkan pesan sukses
                    $('#createUserModal').modal('hide');
                    showNotification(response.message, 'success');
                    $('#tamu-table').DataTable().ajax.reload();
                } else {
                    // Tampilkan error validasi di dalam form
                    if (response.errors) {
                        let errorMessage = '<ul class="mb-0">';
                        
                        if (response.errors.username) {
                            $('#username').addClass('is-invalid');
                            $('#username-feedback').text(response.errors.username);
                            errorMessage += `<li>${response.errors.username}</li>`;
                        }
                        
                        if (response.errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#email-feedback').text(response.errors.email);
                            errorMessage += `<li>${response.errors.email}</li>`;
                        }
                        
                        if (response.errors.password) {
                            $('#password').addClass('is-invalid');
                            $('#password-feedback').text(response.errors.password);
                            errorMessage += `<li>${response.errors.password}</li>`;
                        }
                        
                        errorMessage += '</ul>';
                        showModalAlert(errorMessage);
                    } else {
                        // Tampilkan pesan error umum di dalam modal
                        showModalAlert(response.message || 'Terjadi kesalahan');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showModalAlert('Terjadi kesalahan saat memproses permintaan');
            }
        });
    });
    
    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
});
</script>
<?= $this->endSection() ?> 