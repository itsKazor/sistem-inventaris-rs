<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-building text-primary me-2"></i>Master Data Ruangan</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Kelola data ruang perawatan rumah sakit.</p>
    </div>
    <button class="btn btn-primary btn-sm fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
        <i class="bi bi-plus-circle me-1"></i> Tambah Ruangan
    </button>
</div>

<div class="card border mb-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Ruangan</th>
                    <th>Nama Ruangan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $r): ?>
                        <tr>
                            <td class="fw-bold"><?= html_escape($r['code']) ?></td>
                            <td><?= html_escape($r['name']) ?></td>
                            <td>
                                <?php if ($r['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $r['id'] ?>" title="Edit Ruangan">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/rooms/delete/' . $r['id']) ?>" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Hapus ruangan ini?')" title="Hapus Ruangan">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $r['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?= base_url('admin/rooms/update/' . $r['id']) ?>" method="POST">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Ruangan</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Kode Ruangan</label>
                                                <input type="text" name="code" class="form-control" value="<?= html_escape($r['code']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Nama Ruangan</label>
                                                <input type="text" name="name" class="form-control" value="<?= html_escape($r['name']) ?>" required>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeEdit<?= $r['id'] ?>" <?= $r['is_active'] ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="activeEdit<?= $r['id'] ?>">Status Aktif</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm fw-bold"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data ruangan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/rooms/store') ?>" method="POST">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tambah Ruangan Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kode Ruangan</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: VIP, K1P" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Ruangan</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Kelas I (PRB)" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCreate" checked>
                        <label class="form-check-label small fw-semibold" for="activeCreate">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>
