<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Inventaris Standar per Kamar (Baseline)</h4>
        <p class="text-muted small mb-0">Atur baseline/jumlah standar barang yang seharusnya tersedia pada masing-masing kamar.</p>
    </div>
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
                        <th class="text-center">Item Standar Terkonfigurasi</th>
                        <th class="text-center">Total Kuantitas Standar</th>
                        <th class="text-end" width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($roomNumbers)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data kamar terdaftar.</td>
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
                                <td class="text-center font-monospace fw-bold">
                                    <?php if ($rNum['total_standards'] > 0): ?>
                                        <span class="badge bg-success-subtle text-success fs-6"><?= $rNum['total_standards'] ?> Item</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger fs-6">Belum Diatur</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center font-monospace fw-bold fs-6">
                                    <?= number_format($rNum['total_items_qty']) ?> unit
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/room-inventories/' . $rNum['id']) ?>" class="btn btn-sm btn-primary shadow-sm fw-bold">
                                        <i class="bi bi-sliders me-1"></i> Atur Standar Kamar
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
