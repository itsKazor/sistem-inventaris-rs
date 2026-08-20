<!-- Welcome Greeting -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="bi bi-hand-wave text-warning me-1" style="animation: pulseGlow 2s infinite;"></i>
            Selamat <?php
                $h = (int) date('H');
                if ($h < 11) echo 'Pagi';
                elseif ($h < 15) echo 'Siang';
                elseif ($h < 18) echo 'Sore';
                else echo 'Malam';
            ?>, <span class="text-primary"><?= html_escape($this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Admin') ?></span>
        </h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Ringkasan transaksi serah terima inventaris kamar hari ini.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-light text-dark border px-3 py-2 fw-semibold" style="font-size: .82rem;">
            <i class="bi bi-calendar3 me-1 text-primary"></i> <?= date('l, d F Y') ?>
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #fff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;">Hari Ini</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($stats['today']) ?></div>
                    <div style="opacity: .65; font-size: .72rem; font-weight: 500; margin-top: 2px;">transaksi</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: #fff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;">Bulan Ini</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($stats['month']) ?></div>
                    <div style="opacity: .65; font-size: .72rem; font-weight: 500; margin-top: 2px;">transaksi</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calendar3 fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: #fff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;">Belum Ditinjau</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($stats['pending']) ?></div>
                    <div style="opacity: .65; font-size: .72rem; font-weight: 500; margin-top: 2px;">menunggu verifikasi</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #fff;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;">Item Bermasalah</div>
                    <div class="fs-2 fw-bold mt-1"><?= number_format($stats['issues']) ?></div>
                    <div style="opacity: .65; font-size: .72rem; font-weight: 500; margin-top: 2px;">temuan masalah</div>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-4">
    <!-- Serah Terima Terbaru -->
    <div class="col-lg-8">
        <div class="card border shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul text-primary me-2"></i> Serah Terima Terbaru</h6>
                <a href="<?= base_url('admin/handovers') ?>" class="btn btn-sm btn-outline-primary fw-semibold" style="font-size: .78rem;">
                    <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead>
                        <tr class="table-light">
                            <th style="width: 170px;">No. Dokumen</th>
                            <th style="width: 160px;">Ruangan / Kamar</th>
                            <th style="min-width: 120px;">Penyerah</th>
                            <th style="min-width: 120px;">Penerima</th>
                            <th style="width: 110px;" class="text-center">Status</th>
                            <th style="width: 175px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_handovers)): ?>
                            <?php foreach ($recent_handovers as $h): ?>
                                <tr>
                                    <td class="fw-bold text-primary font-monospace"><?= html_escape($h['handover_number']) ?></td>
                                    <td>
                                        <span class="fw-semibold text-dark"><?= html_escape($h['room_name']) ?></span>
                                        <small class="text-muted d-block"><?= html_escape($h['room_number_name']) ?></small>
                                    </td>
                                    <td><?= html_escape($h['sender_name']) ?></td>
                                    <td><?= html_escape($h['receiver_name']) ?></td>
                                    <td class="text-center">
                                        <?php if ($h['status'] === 'reviewed'): ?>
                                            <span class="badge bg-success mb-1"><i class="bi bi-check-all me-1"></i>Diverifikasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark mb-1"><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</span>
                                        <?php endif; ?>

                                        <?php if (!empty($h['checkout_status']) && $h['checkout_status'] === 'has_liability'): ?>
                                            <span class="badge bg-danger d-block" style="font-size: .68rem;"><i class="bi bi-exclamation-triangle me-1"></i>Ada Ganti Rugi</span>
                                        <?php elseif (!empty($h['checkout_status']) && $h['checkout_status'] === 'cleared'): ?>
                                            <span class="badge bg-info text-dark d-block" style="font-size: .68rem;"><i class="bi bi-box-arrow-right me-1"></i>Sudah Check-out</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-secondary border d-block" style="font-size: .68rem;"><i class="bi bi-hospital me-1"></i>Di Kamar</span>
                                        <?php endif; ?>
                                    </td>
                                   <td class="text-center">
    <div class="d-flex justify-content-center align-items-center gap-1">

        <!-- DETAIL -->
        <a href="<?= base_url('admin/handovers/show/' . $h['id']) ?>"
           class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-center"
           style="width: 34px; height: 34px;"
           title="Lihat Detail Transaksi">
            <i class="bi bi-eye"></i>
        </a>

        <?php if (empty($h['checkout_status']) || $h['checkout_status'] === 'none'): ?>

            <!-- CHECKOUT -->
            <a href="<?= base_url('admin/handovers/checkout/' . $h['id']) ?>"
               class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center"
               style="width: 34px; height: 34px;"
               title="Pemeriksaan Check-out Pasien Pulang">
                <i class="bi bi-box-arrow-right"></i>
            </a>

        <?php else: ?>

            <!-- BA PULANG -->
            <a href="<?= base_url('admin/handovers/preview-checkout/' . $h['id']) ?>"
               target="_blank"
               class="btn btn-info text-dark btn-sm d-inline-flex align-items-center justify-content-center"
               style="width: 34px; height: 34px;"
               title="Preview Berita Acara Check-out">
                <i class="bi bi-file-earmark-check"></i>
            </a>

        <?php endif; ?>

        <!-- PREVIEW PDF -->
        <a href="<?= base_url('admin/handovers/preview/' . $h['id']) ?>"
           target="_blank"
           class="btn btn-secondary btn-sm d-inline-flex align-items-center justify-content-center"
           style="width: 34px; height: 34px;"
           title="Pratinjau PDF Serah Terima">
            <i class="bi bi-file-earmark-pdf"></i>
        </a>

        <!-- DELETE -->
        <a href="<?= base_url('admin/handovers/delete/' . $h['id']) ?>"
           class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center"
           style="width: 34px; height: 34px;"
           onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= html_escape($h['handover_number']) ?>?')"
           title="Hapus Transaksi">
            <i class="bi bi-trash"></i>
        </a>

    </div>
</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox display-5 d-block mb-2 text-secondary" style="opacity: .4;"></i>
                                Belum ada transaksi serah terima hari ini.
                            </td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ringkasan Barang Bermasalah -->
    <div class="col-lg-4">
        <div class="card border shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Barang Bermasalah</h6>
                <a href="<?= base_url('admin/reports/issues') ?>" class="btn btn-sm btn-outline-danger fw-semibold" style="font-size: .78rem;">
                    <i class="bi bi-arrow-right me-1"></i> Laporan
                </a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if (!empty($problem_items)): ?>
                        <?php foreach ($problem_items as $pi): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-3">
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.88rem;"><?= html_escape($pi['inventory_name_snapshot']) ?></div>
                                    <?php
                                        $condStatus = $pi['condition_status'];
                                        $condBadge = 'bg-danger';
                                        $condLabel = 'RUSAK';
                                        if ($condStatus === 'need_repair') { $condBadge = 'bg-warning text-dark'; $condLabel = 'PERLU PERBAIKAN'; }
                                        elseif ($condStatus === 'shortage') { $condBadge = 'bg-info text-dark'; $condLabel = 'KURANG'; }
                                        elseif ($condStatus === 'not_available') { $condBadge = 'bg-secondary'; $condLabel = 'TIDAK ADA'; }
                                    ?>
                                    <span class="badge <?= $condBadge ?>" style="font-size: .68rem;"><?= $condLabel ?></span>
                                </div>
                                <span class="badge bg-danger rounded-pill fs-6 px-2"><?= $pi['count'] ?>×</span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-check-circle display-5 d-block mb-2 text-success" style="opacity: .4;"></i>
                            Semua inventaris dalam kondisi baik.
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
