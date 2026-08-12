<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Master Data Kamar</h4>
        <p class="text-muted small mb-0">Kelola kamar/tempat tidur pada masing-masing unit ruangan perawatan.</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoomNumberModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kamar Baru
    </button>
</div>

<div class="card card-stat bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">No.</th>
                        <th>Ruang Perawatan</th>
                        <th>Nama Kamar</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" width="260">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($roomNumbers)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data kamar terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($roomNumbers as $idx => $rNum): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="fw-bold text-dark"><?= esc($rNum['room_name']) ?></span>
                                    <small class="text-muted"> (<?= esc($rNum['room_code']) ?>)</small>
                                </td>
                                <td><span class="fw-extrabold text-primary fs-6"><?= esc($rNum['display_name']) ?></span></td>
                                <td class="text-center">
                                    <?php if ($rNum['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/room-numbers/' . $rNum['id'] . '/history') ?>" class="btn btn-sm btn-outline-info me-1" title="Lihat Riwayat Kondisi">
                                        <i class="bi bi-clock-history"></i> Riwayat
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editRoomNumberModal<?= $rNum['id'] ?>">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= base_url('admin/room-numbers/delete/' . $rNum['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL EDIT KAMAR -->
                            <div class="modal fade" id="editRoomNumberModal<?= $rNum['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/room-numbers/update/' . $rNum['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Kamar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Pilih Ruangan</label>
                                                    <select class="form-select" name="room_id" required>
                                                        <?php foreach ($rooms as $rm): ?>
                                                            <option value="<?= $rm['id'] ?>" <?= $rNum['room_id'] == $rm['id'] ? 'selected' : '' ?>><?= esc($rm['name']) ?> (<?= esc($rm['code']) ?>)</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Nama Tampilan Kamar</label>
                                                    <input type="text" class="form-control" name="display_name" value="<?= esc($rNum['display_name']) ?>" required>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="activeEditNum<?= $rNum['id'] ?>" value="1" <?= $rNum['is_active'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-bold small" for="activeEditNum<?= $rNum['id'] ?>">Status Aktif</label>
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

<!-- MODAL TAMBAH KAMAR -->
<div class="modal fade" id="addRoomNumberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/room-numbers/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kamar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Ruangan</label>
                        <select class="form-select" name="room_id" required>
                            <option value="">-- Pilih Ruang --</option>
                            <?php foreach ($rooms as $rm): ?>
                                <option value="<?= $rm['id'] ?>"><?= esc($rm['name']) ?> (<?= esc($rm['code']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Tampilan Kamar</label>
                        <input type="text" class="form-control" name="display_name" placeholder="Contoh: Kamar 1, Kamar 7, Bed 101" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeAddNum" value="1" checked>
                        <label class="form-check-label fw-bold small" for="activeAddNum">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
