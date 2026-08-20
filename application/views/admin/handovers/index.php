<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-text text-primary me-2"></i>Daftar Transaksi Serah Terima</h4>
        <p class="text-muted mb-0">Riwayat seluruh transaksi serah terima kamar. <?php if (isset($total_rows) && $total_rows > 0): ?><span class="text-muted fw-semibold">Total <?= number_format($total_rows) ?> transaksi.</span><?php endif; ?></p>
    </div>
</div>

<!-- FILTER & SEARCH CARD -->
<div class="card border mb-4 shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/handovers') ?>" method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Cari Nomor / Penyerah / Penerima</label>
                <input type="text" class="form-control form-control-sm" name="search" value="<?= html_escape(isset($filters['search']) ? $filters['search'] : '') ?>" placeholder="STR-... / nama penyerah / penerima">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Tanggal Mulai</label>
                <input type="date" class="form-control form-control-sm" name="date_from" value="<?= html_escape(isset($filters['date_from']) ? $filters['date_from'] : '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Tanggal Selesai</label>
                <input type="date" class="form-control form-control-sm" name="date_to" value="<?= html_escape(isset($filters['date_to']) ? $filters['date_to'] : '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Ruangan</label>
                <select class="form-select form-select-sm" name="room_id">
                    <option value="">-- Semua Ruang --</option>
                    <?php foreach ($rooms as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= (isset($filters['room_id']) && $filters['room_id'] == $r['id']) ? 'selected' : '' ?>><?= html_escape($r['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="submitted" <?= (isset($filters['status']) && $filters['status'] == 'submitted') ? 'selected' : '' ?>>Belum Diverifikasi</option>
                    <option value="reviewed" <?= (isset($filters['status']) && $filters['status'] == 'reviewed') ? 'selected' : '' ?>>Sudah Diverifikasi</option>
                </select>
            </div>

            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- HANDOVERS TABLE -->
<div class="card border mb-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: .92rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">No.</th>
                        <th style="width: 170px;">Nomor Serah Terima</th>
                        <th style="width: 140px;">Tanggal & Waktu</th>
                        <th style="width: 170px;">Ruang & Kamar</th>
                        <th style="min-width: 170px;">Penyerah ➔ Penerima</th>
                        <th style="width: 140px;" class="text-center">Temuan Masalah</th>
                        <th style="width: 120px;" class="text-center">Status</th>
                        <th style="width: 180px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($handovers)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-text display-4 d-block mb-2 text-secondary"></i>
                                Tidak ada data serah terima ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($handovers as $idx => $h): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= (isset($current_page) ? ($current_page - 1) * 20 : 0) + $idx + 1 ?></td>
                                <td class="font-monospace fw-bold text-primary"><?= html_escape($h['handover_number']) ?></td>
                                <td class="small">
                                    <div class="fw-semibold text-dark"><?= date('d/m/Y', strtotime($h['handover_date'])) ?></div>
                                    <span class="text-muted"><?= html_escape($h['handover_time']) ?> WIB</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= html_escape($h['room_name']) ?></div>
                                    <small class="text-muted"><?= html_escape($h['room_number_name']) ?></small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark"><?= html_escape($h['sender_name']) ?></span>
                                    <span class="text-muted mx-1">➔</span>
                                    <span class="fw-semibold text-dark"><?= html_escape($h['receiver_name']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($h['issue_count'] > 0): ?>
                                        <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i> <?= $h['issue_count'] ?> Masalah</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i> Tidak Ada Masalah</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <?php if ($h['status'] === 'reviewed'): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Diverifikasi</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi</span>
                                        <?php endif; ?>

                                        <?php if (!empty($h['checkout_status']) && $h['checkout_status'] === 'has_liability'): ?>
                                            <span class="badge bg-danger" style="font-size: .7rem;"><i class="bi bi-exclamation-triangle me-1"></i>Ganti Rugi</span>
                                        <?php elseif (!empty($h['checkout_status']) && $h['checkout_status'] === 'cleared'): ?>
                                            <span class="badge bg-info text-dark" style="font-size: .7rem;"><i class="bi bi-box-arrow-right me-1"></i>Sudah Check-out</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-secondary border" style="font-size: .7rem;"><i class="bi bi-hospital me-1"></i>Di Kamar</span>
                                        <?php endif; ?>
                                    </div>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<?php if (isset($total_pages) && $total_pages > 1): ?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm justify-content-end mb-0">
        <?php
        $qs = $_GET;
        $base = base_url('admin/handovers');
        ?>
        <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
            <?php $qs['page'] = $current_page - 1; ?>
            <a class="page-link" href="<?= $base . '?' . http_build_query($qs) ?>"><i class="bi bi-chevron-left"></i></a>
        </li>
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <?php if ($p == 1 || $p == $total_pages || abs($p - $current_page) <= 1): ?>
                <li class="page-item <?= ($p == $current_page) ? 'active' : '' ?>">
                    <?php $qs['page'] = $p; ?>
                    <a class="page-link" href="<?= $base . '?' . http_build_query($qs) ?>"><?= $p ?></a>
                </li>
            <?php elseif (abs($p - $current_page) == 2): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php endif; ?>
        <?php endfor; ?>
        <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
            <?php $qs['page'] = $current_page + 1; ?>
            <a class="page-link" href="<?= $base . '?' . http_build_query($qs) ?>"><i class="bi bi-chevron-right"></i></a>
        </li>
    </ul>
</nav>
<?php endif; ?>
