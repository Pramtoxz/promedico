<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Manajemen User
    </h4>

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
            <h5 class="mb-0">Daftar User</h5>
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                <i class="icon-base ri ri-add-line"></i> Tambah User
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" id="users-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th class="no-sort">Actions</th>
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
                <p>Apakah Anda yakin ingin menghapus user <strong id="delete-user-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalTitle">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="user-detail-content">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-circle bg-primary" id="user-avatar-initial"></span>
                        </div>
                        <h4 class="my-2" id="user-name">...</h4>
                        <div id="user-role-badge"></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Username</div>
                        <div class="col-8" id="user-username">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Email</div>
                        <div class="col-8" id="user-email">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Status</div>
                        <div class="col-8" id="user-status">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Created At</div>
                        <div class="col-8" id="user-created-at">...</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 fw-medium">Updated At</div>
                        <div class="col-8" id="user-updated-at">...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <a href="#" class="btn btn-primary" id="btn-edit-user">
                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
$(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= site_url('admin/users/datatable') ?>",
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'asc']],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-sort"]
        }],
        "drawCallback": function() {
            // Initialize Bootstrap dropdowns after table is drawn/redrawn
            $('[data-bs-toggle="dropdown"]').dropdown();
        }
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        var userId = $(this).data('id');
        var userName = $(this).data('name');
        
        $('#delete-user-name').text(userName);
        $('#deleteModal').modal('show');
        
        $('#confirm-delete').off().on('click', function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('admin/users/delete') ?>",
                data: {
                    id: userId
                },
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        // Show success message
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        $('.container-xxl').prepend(alertHtml);
                        
                        // Reload datatable
                        $('#users-table').DataTable().ajax.reload();
                    } else {
                        // Show error message
                        const alertHtml = `
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        $('.container-xxl').prepend(alertHtml);
                    }
                },
                error: function(xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    console.error(xhr.responseText);
                    const alertHtml = `
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            Terjadi kesalahan saat menghapus user
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('.container-xxl').prepend(alertHtml);
                }
            });
        });
    });
    
    // Handle detail button click
    $(document).on('click', '.btn-detail', function() {
        var userId = $(this).data('id');
        
        // Load user details via AJAX
        $.ajax({
            type: "POST",
            url: "<?= site_url('admin/users/detail') ?>",
            data: {
                id: userId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const user = response.data;
                    
                    // Set user avatar initial (first letter of name or username)
                    const nameInitial = user.name ? user.name.charAt(0) : user.username.charAt(0);
                    $('#user-avatar-initial').text(nameInitial.toUpperCase());
                    
                    // Fill in user details
                    $('#user-name').text(user.name || 'User ID ' + user.id);
                    $('#user-role-badge').html(response.role_badge);
                    $('#user-username').text(user.username);
                    $('#user-email').text(user.email);
                    $('#user-status').html(response.status_badge);
                    
                    // Format dates if they exist
                    $('#user-created-at').text(user.created_at ? formatDate(user.created_at) : '-');
                    $('#user-updated-at').text(user.updated_at ? formatDate(user.updated_at) : '-');
                    
                    // Update edit button link
                    $('#btn-edit-user').attr('href', '<?= base_url('admin/users/edit') ?>/' + user.id);
                    
                    // Show modal
                    $('#userDetailModal').modal('show');
                } else {
                    // Show error message
                    const alertHtml = `
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('.container-xxl').prepend(alertHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        Terjadi kesalahan saat memuat detail user
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.container-xxl').prepend(alertHtml);
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
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});
</script>
<?= $this->endSection() ?> 