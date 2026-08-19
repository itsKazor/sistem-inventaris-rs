<div class="paper-document text-center py-5">
    <div class="mb-3 text-success">
        <i class="bi bi-check-circle-fill display-1"></i>
    </div>

    <h2 class="fw-bold mb-1 text-dark">Serah Terima Berhasil Disimpan</h2>
    <p class="text-muted mb-4">Dokumen transaksi serah terima inventaris telah tercatat resmi di database.</p>

    <div class="card border bg-light mx-auto text-start mb-4 p-3" style="max-width: 650px;">
        <div class="row g-3">
            <div class="col-sm-6">
                <small class="text-muted d-block">Nomor Serah Terima</small>
                <span class="fw-bold font-monospace fs-5 text-primary"><?= html_escape($handover['handover_number']) ?></span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Tanggal & Waktu</small>
                <span class="fw-semibold text-dark"><?= date('d F Y', strtotime($handover['handover_date'])) ?> — <?= html_escape($handover['handover_time']) ?> WIB</span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Ruang & Kamar</small>
                <span class="fw-semibold text-dark"><?= html_escape($handover['room_name']) ?> (<?= html_escape($handover['room_number_name']) ?>)</span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Penyerah &amp; Penerima</small>
                <span class="fw-semibold text-dark"><?= html_escape($handover['sender_name']) ?> ➔ <?= html_escape($handover['receiver_name']) ?></span>
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <!-- PREVIEW BUTTON -->
        <a href="<?= base_url('admin/handovers/preview/' . $handover['id']) ?>" target="_blank" class="btn btn-secondary btn-lg px-4 py-3 fw-bold shadow">
            <i class="bi bi-file-earmark-pdf me-2 fs-5 align-middle text-warning"></i> Preview Dokumen PDF
        </a>

        <!-- PRINT BUTTON -->
        <a href="<?= base_url('admin/handovers/preview/' . $handover['id']) ?>?print=1" target="_blank" class="btn btn-dark btn-lg px-4 py-3 fw-bold shadow">
            <i class="bi bi-printer me-2 fs-5 align-middle"></i> Cetak / Print Bukti A4
        </a>

        <!-- NEW HANDOVER BUTTON -->
        <a href="<?= base_url('serah-terima') ?>" class="btn btn-primary btn-lg px-4 py-3 fw-bold shadow">
            <i class="bi bi-plus-circle me-2 fs-5 align-middle"></i> Buat Serah Terima Baru
        </a>
    </div>
</div>
