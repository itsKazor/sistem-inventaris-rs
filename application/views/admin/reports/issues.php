<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Laporan Barang Bermasalah</h4>
        <p class="text-muted mb-0" style="font-size: .88rem;">Daftar inventaris yang tercatat rusak, hilang, kurang, atau perlu perbaikan.</p>
    </div>
</div>

<?php if (!empty($problem_items)): ?>
    <div class="row g-3 mb-4">
        <?php
            $totalIssues = 0;
            foreach ($problem_items as $pi) $totalIssues += $pi['count'];
        ?>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #fff;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase;">Total Temuan</div>
                        <div class="fs-2 fw-bold mt-1"><?= number_format($totalIssues) ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: #fff;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <div style="opacity: .75; font-size: .72rem; font-weight: 700; text-transform: uppercase;">Jenis Barang</div>
                        <div class="fs-2 fw-bold mt-1"><?= count($problem_items) ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="card border shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold"><i class="bi bi-list-check text-danger me-2"></i>Detail Temuan</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: .9rem;">
            <thead>
                <tr class="table-light">
                    <th style="width: 60px;" class="text-center">No.</th>
                    <th style="width: 50%; min-width: 220px;">Nama Barang</th>
                    <th style="width: 25%; min-width: 160px;">Status / Kondisi</th>
                    <th style="width: 180px;" class="text-center">Jumlah Temuan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($problem_items)): ?>
                    <?php foreach ($problem_items as $idx => $pi): ?>
                        <tr>
                            <td class="text-center fw-semibold text-muted"><?= $idx + 1 ?></td>
                            <td class="fw-bold text-dark"><?= html_escape($pi['inventory_name_snapshot']) ?></td>
                            <td>
                                <?php
                                    $cond = $pi['condition_status'];
                                    $badge = 'bg-danger';
                                    $icon = 'bi-exclamation-octagon';
                                    $label = 'RUSAK';
                                    if ($cond === 'need_repair') { $badge = 'bg-warning text-dark'; $icon = 'bi-wrench'; $label = 'PERLU PERBAIKAN'; }
                                    elseif ($cond === 'shortage') { $badge = 'bg-info text-dark'; $icon = 'bi-dash-circle'; $label = 'KURANG'; }
                                    elseif ($cond === 'not_available') { $badge = 'bg-secondary'; $icon = 'bi-x-lg'; $label = 'TIDAK ADA'; }
                                ?>
                                <span class="badge <?= $badge ?>"><i class="bi <?= $icon ?> me-1"></i><?= $label ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger rounded-pill px-3 py-2 fs-6"><?= $pi['count'] ?>× kejadian</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-check-circle display-4 d-block mb-2 text-success" style="opacity: .4;"></i>
                        Semua barang inventaris dalam kondisi baik. Tidak ada masalah ditemukan.
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
