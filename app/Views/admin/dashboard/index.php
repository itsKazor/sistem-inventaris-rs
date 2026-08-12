<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- WELCOME BANNER -->
<div class="card border-0 bg-primary text-white mb-4 shadow-sm" style="background: linear-gradient(135deg, #1d4ed8 0%, #0f2c59 100%);">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-1"><i class="bi bi-hospital-fill me-2"></i>Sistem Inventaris & Serah Terima Kamar</h4>
                <p class="mb-0 text-white-50">Monitoring kondisi aktual, inventaris standar, dan riwayat kerusakan barang kamar rumah sakit secara real-time.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="<?= base_url('admin/reports/issues') ?>" class="btn btn-warning text-dark fw-bold rounded-pill shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Lihat Rekap Masalah
                </a>
            </div>
        </div>
    </div>
</div>

<!-- STAT CARDS ROW -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-stat bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted fw-bold d-block text-uppercase">Total Ruang</small>
                    <span class="fs-3 fw-extrabold text-dark"><?= number_format($totalRooms) ?></span>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                    <i class="bi bi-building fs-4"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted"><?= number_format($totalRoomNums) ?> Kamar Terdaftar</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-stat bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted fw-bold d-block text-uppercase">Serah Terima Hari Ini</small>
                    <span class="fs-3 fw-extrabold text-success"><?= number_format($handoversToday) ?></span>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-circle">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted"><?= number_format($handoversMonth) ?> Bulan Ini</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-stat bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted fw-bold d-block text-uppercase">Belum Direview</small>
                    <span class="fs-3 fw-extrabold text-warning"><?= number_format($pendingReview) ?></span>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">Perlu Verifikasi Admin</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-stat bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="text-muted fw-bold d-block text-uppercase">Item Bermasalah</small>
                    <span class="fs-3 fw-extrabold text-danger"><?= number_format($damagedCount + $needRepairCount + $shortageCount) ?></span>
                </div>
                <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                    <i class="bi bi-tools fs-4"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">
                <span class="text-danger fw-bold"><?= $damagedCount ?> Rusak</span> •
                <span class="text-warning fw-bold"><?= $shortageCount ?> Kurang</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- LEFT: RECENT HANDOVERS -->
    <div class="col-lg-7">
        <div class="card card-stat bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-primary me-2"></i>Serah Terima Terbaru</h6>
                <a href="<?= base_url('admin/handovers') ?>" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentHandovers)): ?>
                    <p class="text-muted p-4 text-center mb-0">Belum ada transaksi serah terima yang tercatat.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Ruang & Kamar</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentHandovers as $h): ?>
                                    <tr>
                                        <td class="font-monospace fw-bold text-primary"><?= esc($h['handover_number']) ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= esc($h['room_name']) ?></div>
                                            <small class="text-muted"><?= esc($h['room_number_name']) ?></small>
                                        </td>
                                        <td class="small">
                                            <?= date('d/m/Y', strtotime($h['handover_date'])) ?><br>
                                            <span class="text-muted"><?= esc($h['handover_time']) ?> WIB</span>
                                        </td>
                                        <td>
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
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- RIGHT: PROBLEM SUMMARY -->
    <div class="col-lg-5">
        <div class="card card-stat bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-exclamation-octagon text-danger me-2"></i>Ringkasan Temuan Masalah</h6>
                <span class="badge bg-danger small">Top 5 Item</span>
            </div>
            <div class="card-body">
                <?php if (empty($issueSummary)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-shield-check display-5 d-block text-success mb-2"></i>
                        <p class="mb-0">Seluruh inventaris ruangan terpantau dalam kondisi baik.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($issueSummary as $issue): ?>
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark"><?= esc($issue['inventory_name_snapshot']) ?></span>
                                    <span class="badge bg-light text-dark border">
                                        Total <?= $issue['damaged_cnt'] + $issue['need_repair_cnt'] + $issue['shortage_cnt'] ?> Kasus
                                    </span>
                                </div>
                                <div class="d-flex gap-2">
                                    <?php if ($issue['damaged_cnt'] > 0): ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Rusak: <?= $issue['damaged_cnt'] ?></span>
                                    <?php endif; ?>
                                    <?php if ($issue['need_repair_cnt'] > 0): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-wrench me-1"></i> Perbaikan: <?= $issue['need_repair_cnt'] ?></span>
                                    <?php endif; ?>
                                    <?php if ($issue['shortage_cnt'] > 0): ?>
                                        <span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i> Kurang: <?= $issue['shortage_cnt'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
