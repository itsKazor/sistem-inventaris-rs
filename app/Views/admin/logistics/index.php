<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold text-dark mb-0">Master Persediaan & Logistik</h4>
        <small class="text-muted">Kelola jenis barang/perbekalan logistik yang bisa dicatat perawat</small>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addLogisticModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Item Logistik Baru
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
                        <th>Urutan</th>
                        <th>Nama Item Logistik</th>
                        <th class="text-center">Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logistics)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data item logistik.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logistics as $index => $log): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= $index + 1 ?></td>
                                <td><span class="badge bg-secondary"><?= $log['sort_order'] ?></span></td>
                                <td class="fw-bold text-dark"><?= esc($log['name']) ?></td>
                                <td class="text-center">
                                    <?php if ($log['is_active']): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editLogisticModal<?= $log['id'] ?>" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/logistics/delete/' . $log['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item logistik ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editLogisticModal<?= $log['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/logistics/update/' . $log['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Item Logistik</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nama Item Logistik</label>
                                                    <input type="text" name="name" class="form-control" value="<?= esc($log['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Urutan Tampilan</label>
                                                    <input type="number" name="sort_order" class="form-control" value="<?= $log['sort_order'] ?>">
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="editLogActive<?= $log['id'] ?>" <?= $log['is_active'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-semibold" for="editLogActive<?= $log['id'] ?>">Status Aktif</label>
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
<div class="modal fade" id="addLogisticModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/logistics/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Item Logistik Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Item Logistik</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Obat-obatan, Alkes, Linen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampilan</label>
                        <input type="number" name="sort_order" class="form-control" value="1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="addLogActive" checked>
                        <label class="form-check-label fw-semibold" for="addLogActive">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Logistik</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
