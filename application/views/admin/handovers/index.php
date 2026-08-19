<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-text text-primary me-2"></i>Daftar Transaksi Serah Terima</h4>
        <p class="text-muted mb-0">Riwayat seluruh transaksi serah terima kamar yang telah disubmit.</p>
    </div>
</div>

<!-- FILTER & SEARCH CARD -->
<div class="card border mb-4 shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/handovers') ?>" method="get" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Cari Nomor / Penyerah / Penerima</label>
                <input type="text" class="form-control form-control-sm" name="search" value="<?= html_escape(isset($filters['search']) ? $filters['search'] : '') ?>" placeholder="STR-... / nama penyerah / penerima">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date" class="form-control form-control-sm" name="date_from" value="<?= html_escape(isset($filters['date_from']) ? $filters['date_from'] : '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tanggal Selesai</label>
                <input type="date" class="form-control form-control-sm" name="date_to" value="<?= html_escape(isset($filters['date_to']) ? $filters['date_to'] : '') ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Ruangan</label>
                <select class="form-select form-select-sm" name="room_id">
                    <option value="">-- Semua Ruang --</option>
                    <?php foreach ($rooms as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= (isset($filters['room_id']) && $filters['room_id'] == $r['id']) ? 'selected' : '' ?>><?= html_escape($r['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select class="form-select form-select-sm" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="submitted" <?= (isset($filters['status']) && $filters['status'] == 'submitted') ? 'selected' : '' ?>>Submitted (Belum Review)</option>
                    <option value="reviewed" <?= (isset($filters['status']) && $filters['status'] == 'reviewed') ? 'selected' : '' ?>>Reviewed (Sudah Verifikasi)</option>
                </select>
            </div>

            <div class="col-md-1 d-flex align-items-end">
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
                        <th style="width: 180px;">Nomor Serah Terima</th>
                        <th style="width: 150px;">Tanggal & Waktu</th>
                        <th style="width: 180px;">Ruang & Kamar</th>
                        <th style="min-width: 180px;">Penyerah ➔ Penerima</th>
                        <th style="width: 140px;" class="text-center">Temuan Masalah</th>
                        <th style="width: 120px;" class="text-center">Status</th>
                        <th style="width: 220px;" class="text-end">Aksi Dokumen</th>
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
                                        <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i> Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($h['status'] === 'reviewed'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Reviewed</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Submitted</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- DETAIL BUTTON -->
                                        <a href="<?= base_url('admin/handovers/show/' . $h['id']) ?>" class="btn btn-primary fw-semibold" title="Lihat Detail">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>

                                        <!-- PREVIEW BUTTON -->
                                        <a href="<?= base_url('admin/handovers/preview/' . $h['id']) ?>" target="_blank" class="btn btn-secondary fw-semibold" title="Pratinjau Full Page PDF">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Preview
                                        </a>

                                        <!-- PRINT BUTTON -->
                                        <a href="<?= base_url('admin/handovers/preview/' . $h['id']) ?>?print=1" target="_blank" class="btn btn-dark fw-semibold" title="Cetak Dokumen A4">
                                            <i class="bi bi-printer me-1"></i> Print
                                        </a>

                                        <!-- DELETE BUTTON -->
                                        <a href="<?= base_url('admin/handovers/delete/' . $h['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= html_escape($h['handover_number']) ?>?')" title="Hapus">
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
