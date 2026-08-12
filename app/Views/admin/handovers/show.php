<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row mb-3 align-items-center">
    <div class="col">
        <a href="<?= base_url('admin/handovers') ?>" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Transaksi
        </a>
        <h4 class="fw-bold text-dark mb-0">Detail Serah Terima: <span class="font-monospace text-primary"><?= esc($handover['handover_number']) ?></span></h4>
    </div>
    <div class="col-auto d-flex align-items-center gap-2">
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak / Print
        </button>
        <?php if ($handover['status'] === 'submitted'): ?>
            <form action="<?= base_url('admin/handovers/' . $handover['id'] . '/review') ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success btn-sm shadow-sm" onclick="return confirm('Tandai data ini sebagai sudah direview?')">
                    <i class="bi bi-check-all me-1"></i> Tandai Sudah Direview
                </button>
            </form>
        <?php else: ?>
            <span class="badge bg-success fs-6 py-2 px-3"><i class="bi bi-check-circle-fill me-1"></i> Telah Direview oleh <?= esc($handover['reviewer_name'] ?? 'Admin') ?></span>
        <?php endif; ?>
        <a href="<?= base_url('admin/handovers/delete/' . $handover['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi serah terima <?= esc($handover['handover_number']) ?> ini secara permanen?')">
            <i class="bi bi-trash me-1"></i> Hapus Transaksi
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- LEFT MAIN COLUMN -->
    <div class="col-lg-8">
        <!-- A. INFORMASI INFORMASI -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-info-circle text-primary me-2"></i>A. Informasi Umum</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Ruang Perawatan</small>
                        <span class="fw-bold fs-5 text-dark"><?= esc($handover['room_name']) ?> (<?= esc($handover['room_code']) ?>)</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Nomor Kamar</small>
                        <span class="fw-bold fs-5 text-dark"><?= esc($handover['room_number_name']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Tanggal & Waktu Serah Terima</small>
                        <span class="fw-bold text-dark"><?= date('d F Y', strtotime($handover['handover_date'])) ?> — <?= esc($handover['handover_time']) ?> WIB</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Status Verifikasi Admin</small>
                        <?php if ($handover['status'] === 'reviewed'): ?>
                            <span class="badge bg-success"><i class="bi bi-check-all me-1"></i> Reviewed</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Submitted (Menunggu Review)</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6 border-top pt-2">
                        <small class="text-muted d-block">Pihak Menyerahkan</small>
                        <span class="fw-bold text-dark"><i class="bi bi-person-up me-1 text-primary"></i> <?= esc($handover['sender_name']) ?></span>
                        <?php if (!empty($handover['sender_position'])): ?>
                            <small class="text-muted d-block">(<?= esc($handover['sender_position']) ?>)</small>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6 border-top pt-2">
                        <small class="text-muted d-block">Pihak Menerima</small>
                        <span class="fw-bold text-dark"><i class="bi bi-person-down me-1 text-success"></i> <?= esc($handover['receiver_name']) ?></span>
                        <?php if (!empty($handover['receiver_position'])): ?>
                            <small class="text-muted d-block">(<?= esc($handover['receiver_position']) ?>)</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- B. INVENTARIS STANDAR VS AKTUAL (SNAPSHOT TABLE) -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-ui-checks text-success me-2"></i>B. Checklist Inventaris Kamar (Hasil Snapshot)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40" class="text-center">No.</th>
                                <th>Inventaris</th>
                                <th width="80" class="text-center">Standar</th>
                                <th width="80" class="text-center">Aktual</th>
                                <th width="90" class="text-center">Selisih</th>
                                <th width="140" class="text-center">Kondisi</th>
                                <th>Keterangan / Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $idx => $it): ?>
                                <?php $isProblem = in_array($it['condition_status'], ['damaged', 'need_repair', 'shortage', 'not_available']); ?>
                                <tr class="<?= $isProblem ? 'table-warning' : '' ?>">
                                    <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                    <td class="fw-bold text-dark"><?= esc($it['inventory_name_snapshot']) ?></td>
                                    <td class="text-center font-monospace"><span class="badge bg-light text-dark border"><?= $it['standard_quantity_snapshot'] ?> <?= esc($it['inventory_unit_snapshot']) ?></span></td>
                                    <td class="text-center font-monospace fw-bold"><?= $it['actual_quantity'] ?></td>
                                    <td class="text-center">
                                        <?php if ($it['difference_quantity'] == 0): ?>
                                            <span class="badge bg-success-subtle text-success">0 (Pas)</span>
                                        <?php elseif ($it['difference_quantity'] < 0): ?>
                                            <span class="badge bg-danger">Kurang <?= Math.abs($it['difference_quantity']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">Lebih +<?= $it['difference_quantity'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php switch ($it['condition_status']) {
                                            case 'good':
                                                echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Baik</span>';
                                                break;
                                            case 'damaged':
                                                echo '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Rusak</span>';
                                                break;
                                            case 'need_repair':
                                                echo '<span class="badge bg-warning text-dark"><i class="bi bi-wrench me-1"></i> Perbaikan</span>';
                                                break;
                                            case 'shortage':
                                                echo '<span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i> Kurang</span>';
                                                break;
                                            case 'not_available':
                                                echo '<span class="badge bg-dark"><i class="bi bi-x-lg me-1"></i> Tidak Ada</span>';
                                                break;
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($it['notes'])): ?>
                                            <span class="text-danger fw-semibold"><i class="bi bi-chat-left-text me-1"></i> <?= esc($it['notes']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDEBAR (PHOTOS, NOTES, SIGNATURES) -->
    <div class="col-lg-4">
        <!-- C. FOTO PASIEN (SECURE PROTECTED) -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-bounding-box text-info me-2"></i>Foto Pasien</h5>
                <span class="badge bg-danger small"><i class="bi bi-shield-lock me-1"></i> Rahasia</span>
            </div>
            <div class="card-body text-center">
                <?php if (!empty($handover['patient_photo_path'])): ?>
                    <a href="<?= base_url('admin/media/patient/' . $handover['id']) ?>" target="_blank">
                        <img src="<?= base_url('admin/media/patient/' . $handover['id']) ?>" alt="Foto Pasien" class="img-fluid rounded-3 border shadow-sm" style="max-height: 200px;">
                    </a>
                    <small class="text-muted d-block mt-2"><i class="bi bi-zoom-in me-1"></i> Klik untuk melihat ukuran penuh</small>
                <?php else: ?>
                    <p class="text-muted mb-0 py-3"><i class="bi bi-camera-video-off fs-3 d-block text-secondary mb-1"></i> Tidak ada foto pasien diunggah.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- D. FOTO RUANGAN -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-images text-primary me-2"></i>D. Foto Kondisi Ruangan</h5>
            </div>
            <div class="card-body">
                <?php if (empty($roomPhotos)): ?>
                    <p class="text-muted mb-0 text-center py-3"><i class="bi bi-image fs-3 d-block text-secondary mb-1"></i> Tidak ada foto terlampir.</p>
                <?php else: ?>
                    <div class="row g-2">
                        <?php foreach ($roomPhotos as $p): ?>
                            <div class="col-6">
                                <div class="border rounded p-1 text-center bg-light">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#roomPhotoModal<?= $p['id'] ?>">
                                        <img src="<?= base_url('admin/media/room-photo/' . $p['id']) ?>" alt="Foto Ruang" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                    </a>
                                    <?php if (!empty($p['caption'])): ?>
                                        <small class="text-dark fw-semibold d-block text-truncate mt-1 px-1" title="<?= esc($p['caption']) ?>"><?= esc($p['caption']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- MODAL PHOTO PREVIEW -->
                            <div class="modal fade" id="roomPhotoModal<?= $p['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Foto Bukti Kondisi Ruangan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="<?= base_url('admin/media/room-photo/' . $p['id']) ?>" alt="Foto Ruang Large" class="img-fluid rounded">
                                            <?php if (!empty($p['caption'])): ?>
                                                <p class="mt-3 fw-bold text-dark mb-0"><?= esc($p['caption']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- D. CATATAN -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-journal-text me-2"></i>D. Catatan Operasional</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($handover['notes'])): ?>
                    <p class="text-dark bg-light p-3 rounded border mb-0" style="white-space: pre-line;"><?= esc($handover['notes']) ?></p>
                <?php else: ?>
                    <p class="text-muted mb-0">Tidak ada catatan khusus.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- E. TANDA TANGAN DIGITAL -->
        <div class="card card-stat bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-pen-fill me-2"></i>E. Tanda Tangan Digital</h5>
            </div>
            <div class="card-body">
                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div class="border rounded p-2 bg-light h-100">
                            <div class="fw-bold text-dark mb-1 small">Menyerahkan</div>
                            <?php if (!empty($handover['sender_signature_path'])): ?>
                                <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/sender') ?>" alt="TTD Sender" class="img-fluid border rounded bg-white p-1" style="max-height: 90px;">
                            <?php else: ?>
                                <p class="text-muted small mb-0">-</p>
                            <?php endif; ?>
                            <div class="mt-1 text-muted small">( <?= esc($handover['sender_name']) ?> )</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="border rounded p-2 bg-light h-100">
                            <div class="fw-bold text-dark mb-1 small">Menerima</div>
                            <?php if (!empty($handover['receiver_signature_path'])): ?>
                                <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/receiver') ?>" alt="TTD Receiver" class="img-fluid border rounded bg-white p-1" style="max-height: 90px;">
                            <?php else: ?>
                                <p class="text-muted small mb-0">-</p>
                            <?php endif; ?>
                            <div class="mt-1 text-muted small">( <?= esc($handover['receiver_name']) ?> )</div>
                        </div>
                    </div>

                    <?php if (!empty($handover['acknowledgement_signature_path'])): ?>
                        <div class="col-12 mt-2">
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-bold text-dark mb-1 small">Mengetahui / Supervisor</div>
                                <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/acknowledgement') ?>" alt="TTD Head" class="img-fluid border rounded bg-white p-1" style="max-height: 90px;">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
