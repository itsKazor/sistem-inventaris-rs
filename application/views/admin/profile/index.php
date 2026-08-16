<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-key-fill text-warning me-2"></i>Ganti Password Admin</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Ubah kata sandi akun untuk menjaga keamanan sistem.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card border shadow-sm">
            <div class="card-header py-3 bg-light border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock me-2 text-primary"></i>Form Ubah Password</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/profile/update') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock text-secondary"></i></span>
                            <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-shield-plus text-secondary"></i></span>
                            <input type="password" name="new_password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-check2-circle text-secondary"></i></span>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Ketik ulang password baru" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-light border px-3 fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
