<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Laporan Rekapitulasi Masalah Inventaris</h4>
        <p class="text-muted small mb-0">Rekapitulasi seluruh temuan barang rusak, perlu perbaikan, maupun kurang/hilang dari kamar.</p>
    </div>
</div>

<!-- FILTER CARD -->
<div class="card card-stat bg-white mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/reports/issues') ?>" method="get" class="row g-3">
            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Status Masalah</label>
                <select class="form-select form-select-sm" name="condition_status">
                    <option value="all" <?= ($filters['condition_status'] ?? '') == 'all' ? 'selected' : '' ?>>-- Semua Masalah --</option>
                    <option value="damaged" <?= ($filters['condition_status'] ?? '') == 'damaged' ? 'selected' : '' ?>>Rusak</option>
                    <option value="need_repair" <?= ($filters['condition_status'] ?? '') == 'need_repair' ? 'selected' : '' ?>>Perlu Perbaikan</option>
                    <option value="shortage" <?= ($filters['condition_status'] ?? '') == 'shortage' ? 'selected' : '' ?>>Kurang / Hilang</option>
                </select>
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

            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Jenis Inventaris</label>
                <select class="form-select form-select-sm" name="inventory_id">
                    <option value="">-- Semua Item Inventaris --</option>
                    <?php foreach ($inventoryItems as $item): ?>
                        <option value="<?= $item['id'] ?>" <?= ($filters['inventory_id'] ?? '') == $item['id'] ? 'selected' : '' ?>><?= esc($item['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Tanggal Mulai</label>
                <input type="date" class="form-control form-control-sm" name="start_date" value="<?= esc($filters['start_date'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small text-muted">Tanggal Selesai</label>
                <input type="date" class="form-control form-control-sm" name="end_date" value="<?= esc($filters['end_date'] ?? '') ?>">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ISSUES TABLE -->
<div class="card card-stat bg-white mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="text-center">No.</th>
                        <th>Tanggal Check</th>
                        <th>Ruang & Kamar</th>
                        <th>Nama Inventaris</th>
                        <th class="text-center">Standar vs Aktual</th>
                        <th class="text-center">Kondisi</th>
                        <th>Keterangan Kerusakan / Penyebab</th>
                        <th>Petugas Checked</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($issues)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Tidak ada temuan masalah inventaris pada kriteria filter ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($issues as $idx => $is): ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td class="small">
                                    <div class="fw-bold text-dark"><?= date('d/m/Y', strtotime($is['handover_date'])) ?></div>
                                    <span class="text-muted font-monospace"><?= esc($is['handover_number']) ?></span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($is['room_name']) ?></div>
                                    <small class="text-muted"><?= esc($is['room_number_name']) ?></small>
                                </td>
                                <td class="fw-bold text-dark fs-6"><?= esc($is['inventory_name_snapshot']) ?></td>
                                <td class="text-center font-monospace">
                                    <span class="badge bg-light text-dark border">
                                        Standar: <?= $is['standard_quantity_snapshot'] ?> | Aktual: <?= $is['actual_quantity'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php switch ($is['condition_status']) {
                                        case 'damaged':
                                            echo '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Rusak</span>';
                                            break;
                                        case 'need_repair':
                                            echo '<span class="badge bg-warning text-dark"><i class="bi bi-wrench me-1"></i> Perlu Perbaikan</span>';
                                            break;
                                        case 'shortage':
                                            echo '<span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i> Kurang (' . Math.abs($is['difference_quantity']) . ')</span>';
                                            break;
                                        case 'not_available':
                                            echo '<span class="badge bg-dark"><i class="bi bi-x-lg me-1"></i> Tidak Ada</span>';
                                            break;
                                    } ?>
                                </td>
                                <td>
                                    <?php if (!empty($is['notes'])): ?>
                                        <span class="text-danger fw-semibold"><i class="bi bi-chat-left-text me-1"></i> <?= esc($is['notes']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <span class="fw-bold text-dark"><?= esc($is['sender_name']) ?></span> /
                                    <span class="text-muted"><?= esc($is['receiver_name']) ?></span>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/handovers/' . $is['handover_id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
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
<?= $this->endSection() ?>
