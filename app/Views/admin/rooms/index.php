<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Master Data Ruangan</h4>
        <p class="text-muted small mb-0">Kelola daftar unit/ruang perawatan rumah sakit (e.g. Melati, Flamboyan, PRB, Nusa Indah).</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoomModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Ruang Baru
    </button>
</div>

<div class="card card-stat bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">No.</th>
                        <th>Kode Ruang</th>
                        <th>Nama Ruangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rooms)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data ruangan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rooms as $idx => $room): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td><span class="badge bg-primary-subtle text-primary fw-bold fs-6 font-monospace"><?= esc($room['code']) ?></span></td>
                                <td class="fw-bold text-dark fs-6"><?= esc($room['name']) ?></td>
                                <td class="text-center">
                                    <?php if ($room['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editRoomModal<?= $room['id'] ?>">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= base_url('admin/rooms/delete/' . $room['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ruang ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL EDIT RUANG -->
                            <div class="modal fade" id="editRoomModal<?= $room['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/rooms/update/' . $room['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Ruangan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Kode Ruang (Unik)</label>
                                                    <input type="text" class="form-control" name="code" value="<?= esc($room['code']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Nama Ruangan</label>
                                                    <input type="text" class="form-control" name="name" value="<?= esc($room['name']) ?>" required>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="activeEdit<?= $room['id'] ?>" value="1" <?= $room['is_active'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-bold small" for="activeEdit<?= $room['id'] ?>">Status Aktif</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH RUANG -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/rooms/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Ruangan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Kode Ruang (Unik)</label>
                        <input type="text" class="form-control" name="code" placeholder="Contoh: MLT, FMB, PRB, NSI" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Ruangan</label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: Melati, Flamboyan, PRB" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeAdd" value="1" checked>
                        <label class="form-check-label fw-bold small" for="activeAdd">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Ruang</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
