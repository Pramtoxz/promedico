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
            <h5 class="mb-0">Daftar Kamar</h5>
            <a href="<?= base_url('kamar/create') ?>" class="btn btn-primary">
                <i class="icon-base ri ri-add-line"></i> Tambah Kamar
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" id="kamar-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Kamar</th>
                        <th>Nama Kamar</th>
                        <th>Harga</th>
                        <th>Status</th>
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
                <p>Apakah Anda yakin ingin menghapus kamar <strong id="delete-kamar-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Kamar Detail Modal -->
<div class="modal fade" id="kamarDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kamarDetailModalTitle">Detail Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="kamar-detail-content">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-circle bg-primary" id="kamar-avatar-initial"></span>
                        </div>
                        <h4 class="my-2" id="kamar-name">...</h4>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">ID Kamar</div>
                        <div class="col-8" id="kamar-id">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Nama Kamar</div>
                        <div class="col-8" id="kamar-nama">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Harga</div>
                        <div class="col-8" id="kamar-harga">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Status Kamar</div>
                        <div class="col-8" id="kamar-status">...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <a href="#" class="btn btn-primary" id="btn-edit-kamar">
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
                <h5 class="modal-title">Buat User untuk kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Alert untuk error dalam modal -->
                <div id="modal-alert-container"></div>
                
                <form id="createUserForm">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="user-kamar-name" readonly>
                        <input type="hidden" id="user-kamar-nik">
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
<!-- <style>
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
</style> -->

<script>
$(document).ready(function() {
    function showNotification(message, type = 'success') {
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

    $('#kamar-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= site_url('kamar/viewkamar') ?>",
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
        var kamarId = $(this).data('id');
        var kamarName = $(this).data('name');
        
        $('#delete-kamar-name').text(kamarName);
        $('#deleteModal').modal('show');
        
        $('#confirm-delete').off().on('click', function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('kamar/delete') ?>",
                data: {
                    id: kamarId
                },
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        showNotification(response.message, 'success');
                        $('#kamar-table').DataTable().ajax.reload();
                    } else {
                        showNotification(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    console.error(xhr.responseText);
                    showNotification('Terjadi kesalahan saat menghapus kamar', 'danger');
                }
            });
        });
    });
    
    // Handle detail button click
    $(document).on('click', '.btn-detail', function() {
        var kamarId = $(this).data('id');
        
        // Load kamar details via AJAX
        $.ajax({
            type: "POST",
            url: "<?= site_url('kamar/detail') ?>",
            data: {
                id: kamarId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const kamar = response.data;
                    
                    // Set kamar avatar initial (first letter of name)
                    const nameInitial = kamar.nama ? kamar.nama.charAt(0) : 'T';
                    $('#kamar-avatar-initial').text(nameInitial.toUpperCase());
                    
                    // Fill in kamar details
                    $('#kamar-name').text(kamar.nama || 'kamar ID ' + kamar.nik);
                    $('#kamar-nik').text(kamar.nik);
                    $('#kamar-nama').text(kamar.nama);
                    $('#kamar-nohp').text(kamar.nohp);
                    $('#kamar-jenkel').text(kamar.jenkel);
                    $('#kamar-tgllahir').text(formatDate(kamar.tgllahir));
                    $('#kamar-alamat').text(kamar.alamat);
                    
                    // Update edit button link
                    $('#btn-edit-kamar').attr('href', '<?= base_url('kamar/edit') ?>/' + kamar.nik);
                    
                    // Show modal
                    $('#kamarDetailModal').modal('show');
                } else {
                    showNotification(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showNotification('Terjadi kesalahan saat memuat detail kamar', 'danger');
            }
        });
    });
    
    // Handle create user button click
    $(document).on('click', '.btn-create-user', function() {
        var kamarId = $(this).data('id');
        var kamarName = $(this).data('name');
        
        $('#user-kamar-name').val(kamarName);
        $('#user-kamar-nik').val(kamarId);
        
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
        var kamarNik = $('#user-kamar-nik').val();
        
        // Reset error states
        $('#modal-alert-container').empty();
        $('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            type: "POST",
            url: "<?= site_url('kamar/createUserForkamar') ?>",
            data: {
                nik: kamarNik,
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
                    $('#kamar-table').DataTable().ajax.reload();
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