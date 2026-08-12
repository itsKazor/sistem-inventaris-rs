<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="paper-document text-center py-5">
    <div class="mb-3 text-success">
        <i class="bi bi-check-circle-fill display-1"></i>
    </div>

    <h2 class="fw-extrabold text-dark mb-1">SERAH TERIMA BERHASIL DISIMPAN</h2>
    <p class="text-muted mb-4">Dokumen transaksi serah terima inventaris telah tercatat resmi di database.</p>

    <div class="card card-stat bg-light border max-w-600 mx-auto text-start mb-4 p-3" style="max-width: 650px;">
        <div class="row g-3">
            <div class="col-sm-6">
                <small class="text-muted d-block">Nomor Serah Terima</small>
                <span class="fw-bold font-monospace fs-5 text-primary"><?= esc($handover['handover_number']) ?></span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Tanggal & Waktu</small>
                <span class="fw-bold text-dark"><?= date('d F Y', strtotime($handover['handover_date'])) ?> — <?= esc($handover['handover_time']) ?> WIB</span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Ruang & Kamar</small>
                <span class="fw-bold text-dark"><?= esc($handover['room_name']) ?> (<?= esc($handover['room_number_name']) ?>)</span>
            </div>
            <div class="col-sm-6">
                <small class="text-muted d-block">Petugas Involved</small>
                <span class="fw-bold text-dark"><?= esc($handover['sender_name']) ?> ➔ <?= esc($handover['receiver_name']) ?></span>
            </div>
        </div>
    </div>

    <div class="row g-2 justify-content-center max-w-600 mx-auto mb-4" style="max-width: 650px;">
        <div class="col-6 col-sm-3">
            <div class="border rounded p-2 bg-white text-center">
                <small class="text-muted d-block small">Baik</small>
                <span class="fs-4 fw-bold text-success"><?= $summary['good'] ?></span>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="border rounded p-2 bg-white text-center">
                <small class="text-muted d-block small">Rusak</small>
                <span class="fs-4 fw-bold text-danger"><?= $summary['damaged'] ?></span>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="border rounded p-2 bg-white text-center">
                <small class="text-muted d-block small">Perlu Perbaikan</small>
                <span class="fs-4 fw-bold text-warning"><?= $summary['need_repair'] ?></span>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="border rounded p-2 bg-white text-center">
                <small class="text-muted d-block small">Kurang</small>
                <span class="fs-4 fw-bold text-secondary"><?= $summary['shortage'] ?></span>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-center">
        <a href="<?= base_url('serah-terima') ?>" class="btn btn-primary btn-lg px-4 py-3 fw-bold shadow">
            <i class="bi bi-plus-circle me-2"></i> Buat Serah Terima Baru
        </a>
    </div>
</div>
<?= $this->endSection() ?>
