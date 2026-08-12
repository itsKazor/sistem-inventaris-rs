<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Master Inventaris Barang</h4>
        <p class="text-muted small mb-0">Kelola 15 item barang inventaris standar rumah sakit (Tempat Tidur, Tilam, Bantal, Lemari, AC, TV, dll).</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Item Baru
    </button>
</div>

<div class="card card-stat bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">No.</th>
                        <th>Nama Inventaris</th>
                        <th class="text-center">Satuan / Unit</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada item inventaris terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $idx => $item): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td class="fw-bold text-dark fs-6"><?= esc($item['name']) ?></td>
                                <td class="text-center"><span class="badge bg-secondary-subtle text-secondary font-monospace fs-6"><?= esc($item['unit']) ?></span></td>
                                <td class="text-center">
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editItemModal<?= $item['id'] ?>">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <a href="<?= base_url('admin/inventory-items/delete/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item inventaris ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL EDIT ITEM -->
                            <div class="modal fade" id="editItemModal<?= $item['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/inventory-items/update/' . $item['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Item Inventaris</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Nama Inventaris</label>
                                                    <input type="text" class="form-control" name="name" value="<?= esc($item['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Satuan / Unit</label>
                                                    <input type="text" class="form-control" name="unit" value="<?= esc($item['unit']) ?>" placeholder="unit, buah, set, lembar, titik" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Urutan Tampil (Sort Order)</label>
                                                    <input type="number" class="form-control" name="sort_order" value="<?= $item['sort_order'] ?>" required>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="activeEditItem<?= $item['id'] ?>" value="1" <?= $item['is_active'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-bold small" for="activeEditItem<?= $item['id'] ?>">Status Aktif</label>
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

<!-- MODAL TAMBAH ITEM -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/inventory-items/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Master Inventaris Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Inventaris</label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: Tempat Tidur, Tilam, AC, TV" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Satuan / Unit</label>
                        <input type="text" class="form-control" name="unit" placeholder="unit, buah, set, lembar, titik" value="unit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Urutan Tampil (Sort Order)</label>
                        <input type="number" class="form-control" name="sort_order" value="1" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeAddItem" value="1" checked>
                        <label class="form-check-label fw-bold small" for="activeAddItem">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
