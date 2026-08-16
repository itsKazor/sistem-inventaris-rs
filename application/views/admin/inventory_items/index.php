<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-box text-primary me-2"></i>Master Data Barang Inventaris</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Kelola daftar barang inventaris yang tersedia di rumah sakit.</p>
    </div>
    <button class="btn btn-primary btn-sm fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
        <i class="bi bi-plus-circle me-1"></i> Tambah Barang
    </button>
</div>

<div class="card border mb-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;" class="text-center">Urutan</th>
                    <th style="width: 45%; min-width: 200px;">Nama Barang</th>
                    <th style="width: 20%; min-width: 120px;">Satuan</th>
                    <th style="width: 15%; min-width: 100px;">Status</th>
                    <th style="width: 180px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $item['sort_order'] ?></td>
                            <td class="fw-semibold text-dark"><?= html_escape($item['name']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= html_escape($item['unit']) ?></span></td>
                            <td>
                                <?php if ($item['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $item['id'] ?>" title="Edit Barang">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/inventory-items/delete/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Hapus barang ini?')" title="Hapus Barang">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $item['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?= base_url('admin/inventory-items/update/' . $item['id']) ?>" method="POST">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Barang Inventaris</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Nama Barang</label>
                                                <input type="text" name="name" class="form-control" value="<?= html_escape($item['name']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Satuan (Unit / Buah / Set)</label>
                                                <input type="text" name="unit" class="form-control" value="<?= html_escape($item['unit']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Urutan Tampilan</label>
                                                <input type="number" name="sort_order" class="form-control" value="<?= $item['sort_order'] ?>">
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeEdit<?= $item['id'] ?>" <?= $item['is_active'] ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="activeEdit<?= $item['id'] ?>">Status Aktif</label>
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
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data barang.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/inventory-items/store') ?>" method="POST">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tambah Barang Inventaris</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Barang</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: AC, TV, Dispenser" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Satuan (Unit / Buah / Set)</label>
                        <input type="text" name="unit" class="form-control" placeholder="unit" value="unit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Urutan Tampilan</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCreate" checked>
                        <label class="form-check-label small fw-semibold" for="activeCreate">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
