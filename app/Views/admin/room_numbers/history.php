<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
        <a href="<?= base_url('admin/room-numbers') ?>" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Master Kamar
        </a>
        <h4 class="fw-bold text-dark mb-1">Riwayat Kondisi Kamar: <span class="text-primary"><?= esc($roomNumber['room_name']) ?> - <?= esc($roomNumber['display_name']) ?></span></h4>
        <p class="text-muted small mb-0">Jejak riwayat pemeriksaan fisik dan serah terima kamar dari waktu ke waktu.</p>
    </div>
    <a href="<?= base_url('admin/room-inventories/' . $roomNumber['id']) ?>" class="btn btn-outline-primary btn-sm fw-bold">
        <i class="bi bi-sliders me-1"></i> Lihat Inventaris Standar Kamar Ini
    </a>
</div>

<div class="card card-stat bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40" class="text-center">No.</th>
                        <th>Nomor Serah Terima</th>
                        <th>Tanggal & Waktu</th>
                        <th>Petugas Penyerah ➔ Penerima</th>
                        <th class="text-center">Ringkasan Kondisi Fisik</th>
                        <th class="text-center">Status Review</th>
                        <th class="text-end" width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($handovers)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat serah terima untuk kamar ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($handovers as $idx => $h): ?>
                            <?php $sum = $h['summary']; ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                <td class="font-monospace fw-bold text-primary"><?= esc($h['handover_number']) ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= date('d F Y', strtotime($h['handover_date'])) ?></div>
                                    <small class="text-muted"><?= esc($h['handover_time']) ?> WIB</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= esc($h['sender_name']) ?></span>
                                    <span class="text-muted mx-1">➔</span>
                                    <span class="fw-bold text-dark"><?= esc($h['receiver_name']) ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <span class="badge bg-success" title="Baik"><i class="bi bi-check-circle me-1"></i> <?= $sum['good'] ?></span>
                                        <?php if ($sum['damaged'] > 0): ?>
                                            <span class="badge bg-danger" title="Rusak"><i class="bi bi-x-circle me-1"></i> <?= $sum['damaged'] ?></span>
                                        <?php endif; ?>
                                        <?php if ($sum['need_repair'] > 0): ?>
                                            <span class="badge bg-warning text-dark" title="Perlu Perbaikan"><i class="bi bi-wrench me-1"></i> <?= $sum['need_repair'] ?></span>
                                        <?php endif; ?>
                                        <?php if ($sum['shortage'] > 0 || $sum['not_available'] > 0): ?>
                                            <span class="badge bg-secondary" title="Kurang"><i class="bi bi-dash-circle me-1"></i> <?= $sum['shortage'] + $sum['not_available'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if ($h['status'] === 'reviewed'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Reviewed</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Submitted</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/handovers/' . $h['id']) ?>" class="btn btn-sm btn-outline-primary">
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
