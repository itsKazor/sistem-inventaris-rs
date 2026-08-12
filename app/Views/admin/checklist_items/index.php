<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold text-dark mb-0">Item Checklist</h4>
        <small class="text-muted">Kelola daftar item pemeriksaan fasilitas, barang, dan inventaris</small>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Item Baru
        </button>
    </div>
</div>

<div class="card card-stat">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Nama Item</th>
                        <th class="text-center">Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data item checklist.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $index => $item): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $index + 1 ?></td>
                                <td><span class="badge bg-info text-dark"><?= esc($item['category_name']) ?></span></td>
                                <td><span class="badge bg-secondary"><?= $item['sort_order'] ?></span></td>
                                <td class="fw-bold text-dark"><?= esc($item['name']) ?></td>
                                <td class="text-center">
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editItemModal<?= $item['id'] ?>" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/checklist-items/delete/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editItemModal<?= $item['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/checklist-items/update/' . $item['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Item Checklist</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Pilih Kategori</label>
                                                    <select name="category_id" class="form-select" required>
                                                        <?php foreach ($categories as $cat): ?>
                                                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $item['category_id'] ? 'selected' : '' ?>>
                                                                <?= esc($cat['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nama Item</label>
                                                    <input type="text" name="name" class="form-control" value="<?= esc($item['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Urutan Tampilan</label>
                                                    <input type="number" name="sort_order" class="form-control" value="<?= $item['sort_order'] ?>">
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="editItemActive<?= $item['id'] ?>" <?= $item['is_active'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-semibold" for="editItemActive<?= $item['id'] ?>">Status Aktif</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

<!-- Add Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/checklist-items/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Item Checklist Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Item</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Tempat Tidur, AC, Wastafel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampilan</label>
                        <input type="number" name="sort_order" class="form-control" value="1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="addItemActive" checked>
                        <label class="form-check-label fw-semibold" for="addItemActive">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
