<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Daftar Transaksi Serah Terima</h4>
        <p class="text-muted small mb-0">Riwayat seluruh transaksi serah terima kamar yang telah disubmit petugas.</p>
    </div>
</div>

<!-- FILTER & SEARCH CARD -->
<div class="card card-stat bg-white mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/handovers') ?>" method="get" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Cari Nomor / Petugas</label>
                <input type="text" class="form-control form-control-sm" name="search" value="<?= esc($filters['search'] ?? '') ?>" placeholder="STR-... / nama perawat">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Tanggal Mulai</label>
                <input type="date" class="form-control form-control-sm" name="start_date" value="<?= esc($filters['start_date'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Tanggal Selesai</label>
                <input type="date" class="form-control form-control-sm" name="end_date" value="<?= esc($filters['end_date'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Ruangan</label>
                <select class="form-select form-select-sm" name="room_id">
                    <option value="">-- Semua Ruang --</option>
                    <?php foreach ($rooms as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= ($filters['room_id'] ?? '') == $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="submitted" <?= ($filters['status'] ?? '') == 'submitted' ? 'selected' : '' ?>>Submitted (Belum Review)</option>
                    <option value="reviewed" <?= ($filters['status'] ?? '') == 'reviewed' ? 'selected' : '' ?>>Reviewed (Sudah Verifikasi)</option>
                </select>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- HANDOVERS TABLE -->
<div class="card card-stat bg-white mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="text-center">No.</th>
                        <th>Nomor Serah Terima</th>
                        <th>Tanggal & Waktu</th>
                        <th>Ruang & Kamar</th>
                        <th>Penyerah ➔ Penerima</th>
                        <th class="text-center">Temuan Masalah</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($handovers)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Tidak ada data serah terima ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($handovers as $idx => $h): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td class="font-monospace fw-bold text-primary"><?= esc($h['handover_number']) ?></td>
                                <td class="small">
                                    <div class="fw-bold text-dark"><?= date('d/m/Y', strtotime($h['handover_date'])) ?></div>
                                    <span class="text-muted"><?= esc($h['handover_time']) ?> WIB</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($h['room_name']) ?></div>
                                    <small class="text-muted"><?= esc($h['room_number_name']) ?></small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= esc($h['sender_name']) ?></span>
                                    <span class="text-muted mx-1">➔</span>
                                    <span class="fw-bold text-dark"><?= esc($h['receiver_name']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($h['issue_count'] > 0): ?>
                                        <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i> <?= $h['issue_count'] ?> Masalah</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i> Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($h['status'] === 'reviewed'): ?>
                                        <span class="badge bg-success" title="Direview oleh <?= esc($h['reviewer_name'] ?? 'Admin') ?>"><i class="bi bi-check-all me-1"></i> Reviewed</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Submitted</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/handovers/' . $h['id']) ?>" class="btn btn-sm btn-outline-primary fw-bold me-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="<?= base_url('admin/handovers/delete/' . $h['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi serah terima <?= esc($h['handover_number']) ?>? Seluruh snapshot, foto, dan tanda tangan akan dihapus permanen.')" title="Hapus Transaksi">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="d-flex justify-content-end">
    <?= $pager->links() ?>
</div>
<?= $this->endSection() ?>
