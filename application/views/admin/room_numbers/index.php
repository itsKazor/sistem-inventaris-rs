<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-door-closed text-primary me-2"></i>Master Data Kamar</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Kelola nomor dan nama tampilan kamar di setiap ruangan.</p>
    </div>
    <button class="btn btn-primary btn-sm fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kamar
    </button>
</div>

<div class="card border mb-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 20%; min-width: 150px;">Ruangan</th>
                    <th style="width: 15%; min-width: 120px;">Nomor Kamar</th>
                    <th style="width: 35%; min-width: 180px;">Nama Tampilan</th>
                    <th style="width: 15%; min-width: 100px;">Status</th>
                    <th style="width: 180px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($room_numbers)): ?>
                    <?php foreach ($room_numbers as $rn): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= html_escape($rn['room_name']) ?></td>
                            <td><?= html_escape($rn['room_number']) ?></td>
                            <td class="fw-semibold"><?= html_escape($rn['display_name']) ?></td>
                            <td>
                                <?php if ($rn['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $rn['id'] ?>" title="Edit Kamar">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/room-numbers/delete/' . $rn['id']) ?>" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Hapus kamar ini?')" title="Hapus Kamar">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $rn['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?= base_url('admin/room-numbers/update/' . $rn['id']) ?>" method="POST">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Kamar</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Pilih Ruangan</label>
                                                <select name="room_id" class="form-select" required>
                                                    <?php foreach ($rooms as $r): ?>
                                                        <option value="<?= $r['id'] ?>" <?= ($rn['room_id'] == $r['id']) ? 'selected' : '' ?>><?= html_escape($r['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Nomor Kode Kamar</label>
                                                <input type="text" name="room_number" class="form-control" value="<?= html_escape($rn['room_number']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">Nama Tampilan Kamar</label>
                                                <input type="text" name="display_name" class="form-control" value="<?= html_escape($rn['display_name']) ?>" required>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeEdit<?= $rn['id'] ?>" <?= $rn['is_active'] ? 'checked' : '' ?>>
                                                <label class="form-check-label small fw-semibold" for="activeEdit<?= $rn['id'] ?>">Status Aktif</label>
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
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data kamar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/room-numbers/store') ?>" method="POST">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tambah Kamar Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilih Ruangan</label>
                        <select name="room_id" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            <?php foreach ($rooms as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= html_escape($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nomor Kode Kamar</label>
                        <input type="text" name="room_number" class="form-control" placeholder="Contoh: 1, 2, A" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Tampilan Kamar</label>
                        <input type="text" name="display_name" class="form-control" placeholder="Contoh: Kamar 1, Kelas 1 Utama A" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCreate" checked>
                        <label class="form-check-label small fw-semibold" for="activeCreate">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
