<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-person-gear text-primary me-2"></i>Pengaturan Akun & Profil Admin</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Kelola nama akun, username, dan ubah kata sandi akun Anda.</p>
    </div>
</div>

<div class="row g-4">
    <!-- LEFT FORM COLUMN -->
    <div class="col-lg-8">
        <form action="<?= base_url('admin/profile/update') ?>" method="POST">
            <!-- 1. INFORMASI AKUN -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-person-vcard text-primary me-2"></i>Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama Lengkap Petugas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                                <input type="text" name="name" class="form-control" value="<?= html_escape($user['name']) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Username Login <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-at text-secondary"></i></span>
                                <input type="text" name="username" class="form-control" value="<?= html_escape($user['username']) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. GANTI PASSWORD -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-key-fill text-warning me-2"></i>Ubah Password Akun</h6>
                    <span class="badge bg-light text-muted border">Opsional</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-info py-2 px-3 mb-3 small">
                        <i class="bi bi-info-circle me-1"></i> Biarkan kolom di bawah ini kosong jika Anda <strong>tidak ingin mengubah password</strong>.
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock text-secondary"></i></span>
                                <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini untuk verifikasi">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-shield-plus text-secondary"></i></span>
                                <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-check2-circle text-secondary"></i></span>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Ketik ulang password baru">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light border px-4 fw-semibold">Batal / Reset</button>
                <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT SUMMARY COLUMN -->
    <div class="col-lg-4">
        <div class="card border shadow-sm text-center p-4">
            <div class="mb-3 position-relative d-inline-block mx-auto">
                <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.2rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-2" title="Akun Aktif"></span>
            </div>

            <h5 class="fw-bold mb-1 text-dark"><?= html_escape($user['name']) ?></h5>
            <p class="text-muted small mb-2"><i class="bi bi-at me-1"></i><?= html_escape($user['username']) ?></p>

            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 mx-auto mb-3" style="font-size: .8rem;">
                <i class="bi bi-shield-check me-1"></i> <?= html_escape(strtoupper($user['role'])) ?>
            </span>

            <hr class="my-3">

            <div class="text-start small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status Akun:</span>
                    <span class="fw-bold text-success"><i class="bi bi-check-circle-fill me-1"></i> Aktif</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Terdaftar Sejak:</span>
                    <span class="fw-semibold text-dark"><?= !empty($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-' ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
