<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="<?= base_url('admin/users') ?>">Manajemen User</a> /</span> Edit User
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
                    <h5 class="mb-0">Form Edit User</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="username">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" 
                                    value="<?= old('username', $user['username']) ?>" required />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="<?= old('email', $user['email']) ?>" required />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password" />
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="role">Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" disabled>Pilih Role</option>
                                    <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="manager" <?= old('role', $user['role']) == 'manager' ? 'selected' : '' ?>>Manager</option>
                                    <option value="user" <?= old('role', $user['role']) == 'user' ? 'selected' : '' ?>>User</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="active" <?= old('status', $user['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= old('status', $user['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary me-2">Batal</a>
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