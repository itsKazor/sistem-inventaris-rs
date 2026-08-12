<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
        <a href="<?= base_url('admin/room-inventories') ?>" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Kamar
        </a>
        <h4 class="fw-bold text-dark mb-1">Pengaturan Inventaris Standar: <span class="text-primary"><?= esc($roomNumber['room_name']) ?> - <?= esc($roomNumber['display_name']) ?></span></h4>
        <p class="text-muted small mb-0">Tentukan jumlah unit/standar barang yang <strong>seharusnya ada</strong> pada kamar ini.</p>
    </div>
</div>

<form action="<?= base_url('admin/room-inventories/' . $roomNumber['id']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-9">
            <div class="card card-stat bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Daftar Inventaris Kamar (15 Item Standar)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">No.</th>
                                    <th>Nama Inventaris</th>
                                    <th width="120" class="text-center">Satuan</th>
                                    <th width="220" class="text-center">Jumlah Standar Kamar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($groupedMasterItems as $cat): ?>
                                    <?php foreach ($cat['items'] as $item): ?>
                                        <?php 
                                            $itemId = $item['id'];
                                            $currentStd = $standardsMap[$itemId] ?? 0;
                                        ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= $no++ ?></td>
                                            <td class="fw-bold text-dark"><?= esc($item['name']) ?></td>
                                            <td class="text-center"><span class="badge bg-light text-dark border font-monospace"><?= esc($item['unit']) ?></span></td>
                                            <td class="text-center p-2">
                                                <div class="input-group input-group-sm mx-auto" style="max-width: 150px;">
                                                    <input type="number" min="0" class="form-control text-center fw-bold fs-6" name="standards[<?= $itemId ?>]" value="<?= old("standards.{$itemId}", $currentStd) ?>">
                                                    <span class="input-group-text"><?= esc($item['unit']) ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-stat bg-white position-sticky" style="top: 20px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-info-circle me-1 text-info"></i>Petunjuk Admin</h6>
                </div>
                <div class="card-body small text-muted">
                    <p>Isi <strong>Jumlah Standar</strong> dengan kuantitas yang seharusnya ada saat kamar dalam kondisi normal/penuh.</p>
                    <p class="mb-3">Jika item bernilai <code>0</code>, item tersebut dianggap tidak digunakan di kamar ini.</p>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> SIMPAN STANDAR KAMAR
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
