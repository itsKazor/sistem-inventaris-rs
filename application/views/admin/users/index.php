<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Pengaturan User</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Kelola akun pengguna sistem inventaris RS.</p>
    </div>
    <button class="btn btn-primary fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah User
    </button>
</div>

<div class="card border shadow-sm">
    <div class="card-header py-3 bg-light border-bottom">
        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-table me-2 text-secondary"></i>Daftar Pengguna</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" style="font-size: .9rem;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:40px;">#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= html_escape($u['name']) ?></td>
                        <td><code><?= html_escape($u['username']) ?></code></td>
                        <td>
                            <?php if ($u['role'] === 'administrator'): ?>
                                <span class="badge bg-primary">Administrator</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark">Kepala Ruangan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['is_active']): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" title="Edit"
                                data-bs-toggle="modal" data-bs-target="#modalEditUser"
                                data-id="<?= $u['id'] ?>"
                                data-name="<?= html_escape($u['name']) ?>"
                                data-username="<?= html_escape($u['username']) ?>"
                                data-role="<?= $u['role'] ?>"
                                data-is_active="<?= $u['is_active'] ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary me-1" title="Reset Password"
                                data-bs-toggle="modal" data-bs-target="#modalResetPassword"
                                data-id="<?= $u['id'] ?>"
                                data-name="<?= html_escape($u['name']) ?>">
                                <i class="bi bi-key-fill"></i>
                            </button>
                            <?php if ($u['id'] != $this->session->userdata('admin_id')): ?>
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"
                                data-bs-toggle="modal" data-bs-target="#modalHapusUser"
                                data-id="<?= $u['id'] ?>"
                                data-name="<?= html_escape($u['name']) ?>">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-danger opacity-25" disabled title="Tidak bisa hapus akun sendiri">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/users/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap pengguna" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="administrator">Administrator</option>
                            <option value="kepala_ruangan">Kepala Ruangan</option>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="tambahIsActive" checked>
                        <label class="form-check-label small" for="tambahIsActive">Aktifkan akun ini</label>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-fill me-2 text-warning"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditUser" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="editUsername" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" id="editRole" class="form-select" required>
                            <option value="administrator">Administrator</option>
                            <option value="kepala_ruangan">Kepala Ruangan</option>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editIsActive">
                        <label class="form-check-label small" for="editIsActive">Aktifkan akun ini</label>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold px-4"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="modalResetPassword" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bi bi-key-fill me-2 text-secondary"></i>Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formResetPassword" action="" method="POST">
                <div class="modal-body">
                    <p class="text-muted small mb-3">Reset password untuk: <strong id="resetUserName"></strong></p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary fw-semibold px-4"><i class="bi bi-key me-1"></i>Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus User -->
<div class="modal fade" id="modalHapusUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom border-danger-subtle">
                <h5 class="modal-title fw-bold text-danger"><i class="bi bi-trash3-fill me-2"></i>Hapus User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Anda yakin ingin menghapus user:</p>
                <p class="fw-bold fs-6" id="hapusUserName"></p>
                <p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle-fill me-1"></i>Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusUser" action="" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-danger fw-semibold px-4"><i class="bi bi-trash3-fill me-1"></i>Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Isi modal Edit
document.getElementById('modalEditUser').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('formEditUser').action = '<?= base_url('admin/users/update/') ?>' + btn.dataset.id;
    document.getElementById('editName').value     = btn.dataset.name;
    document.getElementById('editUsername').value = btn.dataset.username;
    document.getElementById('editRole').value     = btn.dataset.role;
    document.getElementById('editIsActive').checked = btn.dataset.is_active == '1';
});

// Isi modal Reset Password
document.getElementById('modalResetPassword').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('formResetPassword').action = '<?= base_url('admin/users/reset_password/') ?>' + btn.dataset.id;
    document.getElementById('resetUserName').textContent = btn.dataset.name;
});

// Isi modal Hapus
document.getElementById('modalHapusUser').addEventListener('show.bs.modal', function(e) {
    var btn = e.relatedTarget;
    document.getElementById('formHapusUser').action = '<?= base_url('admin/users/delete/') ?>' + btn.dataset.id;
    document.getElementById('hapusUserName').textContent = btn.dataset.name;
});
</script>
