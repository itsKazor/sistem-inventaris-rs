<?php
$condLabels = array(
    'good'          => 'Baik',
    'damaged'       => 'Rusak',
    'need_repair'   => 'Perlu Perbaikan',
    'shortage'      => 'Kurang',
    'not_available' => 'Tidak Ada'
);
?>

<style>
    .print-only {
        display: none;
    }

    @media print {
        @page {
            size: A4;
            margin: 7mm 8mm;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-sizing: border-box;
        }

        body {
            background: #fff !important;
            padding: 0 !important;
        }

        .screen-only, .app-sidebar, .top-navbar, .offcanvas {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        .main-wrapper, .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .kertas-form {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5px;
            color: #000;
            line-height: 1.3;
        }

        .kop-logo-centered {
            text-align: center;
            margin-bottom: 4px;
        }

        .kop-logo-centered img {
            height: 70px;
            width: auto;
        }

        .kop-rule-thick {
            border-top: 2.5px solid #000;
            margin-top: 5px;
        }

        .kop-rule-thin {
            border-top: 0.8px solid #000;
            margin-top: 1.5px;
        }

        .judul-row {
            position: relative;
            text-align: center;
            margin-top: 8px;
            padding-right: 112px;
        }

        .judul-title {
            font-size: 13.5px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .judul-sub {
            font-size: 9.5px;
            margin-top: 1px;
        }

        .judul-no {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            border: 1px solid #000;
            padding: 2px 8px;
        }

        .judul-no-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .judul-no-value {
            font-size: 10.5px;
            font-weight: bold;
        }

        .judul-rule {
            border-top: 1.2px solid #000;
            margin: 5px 0 7px;
        }

        .sec-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1.5px solid #000;
            padding-bottom: 1px;
            margin: 7px 0 3px;
        }

        .ftable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .ftable th, .ftable td {
            border: 1px solid #000;
            padding: 2px 5px;
            vertical-align: middle;
        }

        .ftable th {
            font-size: 8.5px;
            text-transform: uppercase;
            background: #efefef;
            font-weight: bold;
        }

        .ftable td {
            font-size: 10px;
        }

        .ftable .center {
            text-align: center;
        }

        .meta-table td {
            font-size: 9.5px;
            padding: 2px 5px;
        }

        .meta-table .meta-label {
            background: #f7f7f7;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
            width: 118px;
        }

        .field-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #333;
            margin-top: 2px;
        }

        .field-value {
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 1px;
            min-height: 14px;
        }

        .notes-box {
            border: 1px solid #000;
            min-height: 44px;
            padding: 4px 6px;
            font-size: 10px;
        }

        .ttd-grid {
            display: flex;
            gap: 8px;
            margin-top: 4px;
        }

        .ttd-col {
            flex: 1;
            text-align: center;
        }

        .ttd-role {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .ttd-sub {
            font-size: 8.5px;
            font-style: italic;
        }

        .sig-box {
            border: 1px solid #000;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px 0 1px;
            background: #fff;
        }

        .sig-box img {
            max-height: 48px;
            max-width: 85%;
        }

        .name-line {
            border-top: 1px solid #000;
            width: 92%;
            margin: 0 auto;
            padding-top: 1px;
            font-size: 10px;
            font-weight: bold;
            min-height: 15px;
        }

        .pos-line {
            font-size: 8.5px;
            font-style: italic;
            min-height: 12px;
        }

        .pernyataan-box {
            border: 1.2px solid #000;
            border-radius: 4px;
            padding: 6px 10px;
            margin: 3px 0 4px;
        }

        .pernyataan-text {
            margin: 0 0 4px;
            font-size: 10.5px;
            text-align: justify;
        }

        .pernyataan-warning {
            margin: 0;
            font-size: 10.5px;
            text-align: justify;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .footer {
            margin-top: 8px;
            border-top: 1px solid #000;
            padding-top: 3px;
            text-align: center;
            font-size: 8px;
            letter-spacing: 0.3px;
        }
    }
</style>

<!-- ============================================================
     PRINT-ONLY DOCUMENT (Form Kertas Resmi A4)
     ============================================================ -->
<div class="print-only">
    <div class="kertas-form">

        <!-- LOGO -->
        <div class="kop-logo-centered">
            <img src="<?= base_url('assets/images/logo_rs.png') ?>" alt="RSU Catharina 1914">
        </div>
        <div class="kop-rule-thick"></div>
        <div class="kop-rule-thin"></div>

        <!-- JUDUL DOKUMEN -->
        <div class="judul-row">
            <div class="judul-text">
                <div class="judul-title">FORM SERAH TERIMA &amp; INVENTARIS KAMAR</div>
                <div class="judul-sub">BUKTI SERAH TERIMA INVENTARIS ANTAR SHIFT PERAWAT</div>
            </div>
            <div class="judul-no">
                <div class="judul-no-label">No. Transaksi</div>
                <div class="judul-no-value"><?= html_escape($handover['handover_number']) ?></div>
            </div>
        </div>
        <div class="judul-rule"></div>

        <!-- META DATA -->
        <table class="ftable meta-table">
            <tr>
                <td class="meta-label">Ruang Perawatan</td>
                <td class="meta-value"><b><?= html_escape($handover['room_name']) ?></b></td>
                <td class="meta-label">Nomor Kamar</td>
                <td class="meta-value"><b><?= html_escape($handover['room_number_name']) ?></b></td>
            </tr>
            <tr>
                <td class="meta-label">Tanggal Serah Terima</td>
                <td class="meta-value"><?= date('d F Y', strtotime($handover['handover_date'])) ?></td>
                <td class="meta-label">Waktu</td>
                <td class="meta-value"><?= html_escape($handover['handover_time']) ?> WIB</td>
            </tr>
        </table>

        <!-- 1. IDENTITAS -->
        <div class="sec-title">1. Identitas Serah Terima</div>
        <table class="ftable">
            <tr>
                <th class="center" width="50%">Pihak yang Menyerahkan</th>
                <th class="center" width="50%">Pihak yang Menerima</th>
            </tr>
            <tr>
                <td>
                    <div class="field-label">Nama Lengkap Penyerah</div>
                    <div class="field-value"><?= html_escape($handover['sender_name']) ?></div>
                    <div class="field-label">Jabatan / Role</div>
                    <div class="field-value"><?= html_escape($handover['sender_position']) ?: '-' ?></div>
                </td>
                <td>
                    <div class="field-label">Nama Lengkap Penerima</div>
                    <div class="field-value"><?= html_escape($handover['receiver_name']) ?></div>
                    <div class="field-label">Jabatan / Role</div>
                    <div class="field-value"><?= html_escape($handover['receiver_position']) ?: '-' ?></div>
                </td>
            </tr>
        </table>

        <!-- 2. CHECKLIST -->
        <div class="sec-title">2. Checklist Inventaris Kamar &amp; Kondisi Aktual</div>
        <table class="ftable">
            <thead>
                <tr>
                    <th class="center" width="24">No</th>
                    <th>Uraian Inventaris</th>
                    <th class="center" width="52">Standar</th>
                    <th class="center" width="48">Aktual</th>
                    <th class="center" width="64">Selisih</th>
                    <th class="center" width="76">Kondisi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $idx => $it): ?>
                    <tr>
                        <td class="center"><?= $idx + 1 ?></td>
                        <td><?= html_escape($it['inventory_name_snapshot']) ?></td>
                        <td class="center"><?= $it['standard_quantity_snapshot'] ?> <?= html_escape($it['inventory_unit_snapshot']) ?></td>
                        <td class="center"><b><?= $it['actual_quantity'] ?></b></td>
                        <td class="center">
                            <?php if ($it['difference_quantity'] == 0): ?>
                                0 (Pas)
                            <?php elseif ($it['difference_quantity'] < 0): ?>
                                Kurang <?= abs($it['difference_quantity']) ?>
                            <?php else: ?>
                                Lebih +<?= $it['difference_quantity'] ?>
                            <?php endif; ?>
                        </td>
                        <td class="center"><?= isset($condLabels[$it['condition_status']]) ? $condLabels[$it['condition_status']] : html_escape($it['condition_status']) ?></td>
                        <td><?= !empty($it['notes']) ? html_escape($it['notes']) : '&nbsp;' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- 3. CATATAN -->
        <div class="sec-title">3. Catatan / Hal Penting</div>
        <div class="notes-box">
            <?= !empty($handover['notes']) ? html_escape($handover['notes']) : 'Tidak ada catatan khusus.' ?>
        </div>

        <!-- 4. TANDA TANGAN -->
        <div class="sec-title">4. Tanda Tangan Digital</div>
        <div class="ttd-grid">
            <div class="ttd-col">
                <div class="ttd-role">Pihak Menyerahkan</div>
                <div class="ttd-sub">(Penyerah)</div>
                <div class="sig-box">
                    <?php if (!empty($handover['sender_signature_path']) && file_exists(FCPATH . ltrim($handover['sender_signature_path'], '/\\'))): ?>
                        <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/sender') ?>" alt="TTD Sender">
                    <?php endif; ?>
                </div>
                <div class="name-line"><?= html_escape($handover['sender_name']) ?></div>
                <div class="pos-line"><?= html_escape($handover['sender_position']) ?></div>
            </div>
            <div class="ttd-col">
                <div class="ttd-role">Pihak Menerima</div>
                <div class="ttd-sub">(Penerima)</div>
                <div class="sig-box">
                    <?php if (!empty($handover['receiver_signature_path']) && file_exists(FCPATH . ltrim($handover['receiver_signature_path'], '/\\'))): ?>
                        <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/receiver') ?>" alt="TTD Receiver">
                    <?php endif; ?>
                </div>
                <div class="name-line"><?= html_escape($handover['receiver_name']) ?></div>
                <div class="pos-line"><?= html_escape($handover['receiver_position']) ?></div>
            </div>
            <div class="ttd-col">
                <div class="ttd-role">Mengetahui</div>
                <div class="ttd-sub">(Kepala Ruangan / Supervisor)</div>
                <div class="sig-box">
                    <?php if (!empty($handover['acknowledgement_signature_path']) && file_exists(FCPATH . ltrim($handover['acknowledgement_signature_path'], '/\\'))): ?>
                        <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/head') ?>" alt="TTD Head">
                    <?php endif; ?>
                </div>
                <div class="name-line"></div>
                <div class="pos-line"></div>
            </div>
        </div>

        <!-- 5. PERNYATAAN -->
        <div class="sec-title">5. Pernyataan</div>
        <div class="pernyataan-box">
            <p class="pernyataan-text">Dengan ini kami menyatakan bahwa serah terima ruang ini telah dilakukan dengan kondisi sebagaimana tercantum di atas.</p>
            <p class="pernyataan-warning">Apabila terjadi kehilangan atau kerusakan terhadap fasilitas yang ada di ruangan, <b>pasien wajib mengganti</b>.</p>
        </div>

        <div class="footer">
            Dokumen ini dicetak otomatis dari Sistem Inventaris &amp; Serah Terima Kamar RSU CATHARINA 1914 &nbsp;|&nbsp; Dicetak: <?= date('d/m/Y H:i') ?>
        </div>
    </div>
</div>

<!-- ============================================================
     SCREEN-ONLY ADMIN VIEW
     ============================================================ -->
<div class="screen-only container-fluid px-3 py-2">
    <div class="mb-4">
        <a href="<?= base_url('admin/handovers') ?>" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Transaksi
        </a>
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap bg-white p-3 rounded border shadow-sm">
            <div>
                <span class="badge bg-primary mb-1">DOKUMEN RESMI</span>
                <h4 class="fw-bold mb-0">Nomor Transaksi: <span class="font-monospace text-primary"><?= html_escape($handover['handover_number']) ?></span></h4>
            </div>
            
            <!-- PROMINENT ACTION BUTTONS -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- PREVIEW PDF BUTTON -->
                <a href="<?= base_url('admin/handovers/preview/' . $handover['id']) ?>" target="_blank" class="btn btn-secondary btn-md px-3 py-2 fw-bold shadow-sm">
                    <i class="bi bi-file-earmark-pdf-fill me-1 fs-5 align-middle text-warning"></i> Preview PDF
                </a>

                <!-- PRINT BUTTON -->
                <button onclick="window.print()" class="btn btn-dark btn-md px-3 py-2 fw-bold shadow-sm">
                    <i class="bi bi-printer-fill me-2 fs-5 align-middle"></i> Cetak / Print Dokumen A4
                </button>

                <?php if ($handover['status'] === 'submitted'): ?>
                    <a href="<?= base_url('admin/handovers/review/' . $handover['id']) ?>" class="btn btn-success btn-md px-3 py-2 fw-bold shadow-sm" onclick="return confirm('Tandai data ini sebagai sudah direview?')">
                        <i class="bi bi-check-all me-1 fs-5 align-middle"></i> Verifikasi / Review
                    </a>
                <?php else: ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle py-2 px-3 fs-6">
                        <i class="bi bi-check-circle-fill me-1"></i> Telah Verifikasi (<?= html_escape(isset($handover['reviewer_name']) ? $handover['reviewer_name'] : 'Admin') ?>)
                    </span>
                <?php endif; ?>

                <a href="<?= base_url('admin/handovers/delete/' . $handover['id']) ?>" class="btn btn-outline-danger btn-md px-3 py-2 fw-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                    <i class="bi bi-trash me-1"></i> Hapus
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
            <!-- A. INFORMASI UMUM -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-info-circle-fill text-primary me-2"></i>A. Informasi General</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Ruang Perawatan</small>
                            <span class="fw-bold fs-5 text-dark"><?= html_escape($handover['room_name']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Nomor Kamar</small>
                            <span class="fw-bold fs-5 text-dark"><?= html_escape($handover['room_number_name']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Tanggal & Waktu Serah Terima</small>
                            <span class="fw-semibold text-dark"><?= date('d F Y', strtotime($handover['handover_date'])) ?> — <?= html_escape($handover['handover_time']) ?> WIB</span>
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
                            <span class="fw-bold text-dark"><i class="bi bi-person-up me-1 text-primary"></i> <?= html_escape($handover['sender_name']) ?></span>
                            <?php if (!empty($handover['sender_position'])): ?>
                                <small class="text-muted d-block">(<?= html_escape($handover['sender_position']) ?>)</small>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 border-top pt-2">
                            <small class="text-muted d-block">Pihak Menerima</small>
                            <span class="fw-bold text-dark"><i class="bi bi-person-down me-1 text-success"></i> <?= html_escape($handover['receiver_name']) ?></span>
                            <?php if (!empty($handover['receiver_position'])): ?>
                                <small class="text-muted d-block">(<?= html_escape($handover['receiver_position']) ?>)</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- B. INVENTARIS STANDAR VS AKTUAL TABLE -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-ui-checks text-success me-2"></i>B. Checklist Inventaris Kamar & Kondisi Fisik</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="font-size: .92rem;">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Inventaris</th>
                                    <th width="80" class="text-center">Standar</th>
                                    <th width="80" class="text-center">Aktual</th>
                                    <th width="90" class="text-center">Selisih</th>
                                    <th width="140" class="text-center">Kondisi</th>
                                    <th>Catatan Masalah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $idx => $it): ?>
                                    <?php $isProblem = in_array($it['condition_status'], array('damaged', 'need_repair', 'shortage', 'not_available')); ?>
                                    <tr class="<?= $isProblem ? 'table-warning' : '' ?>">
                                        <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                        <td class="fw-semibold text-dark"><?= html_escape($it['inventory_name_snapshot']) ?></td>
                                        <td class="text-center font-monospace"><span class="badge bg-light text-dark border"><?= $it['standard_quantity_snapshot'] ?> <?= html_escape($it['inventory_unit_snapshot']) ?></span></td>
                                        <td class="text-center font-monospace fw-bold fs-6"><?= $it['actual_quantity'] ?></td>
                                        <td class="text-center">
                                            <?php if ($it['difference_quantity'] == 0): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">0 (Sesuai)</span>
                                            <?php elseif ($it['difference_quantity'] < 0): ?>
                                                <span class="badge bg-danger">Kurang <?= abs($it['difference_quantity']) ?></span>
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
                                                default:
                                                    echo '<span class="badge bg-dark"><i class="bi bi-x-lg me-1"></i> Tidak Ada</span>';
                                                    break;
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($it['notes'])): ?>
                                                <span class="text-danger fw-semibold"><i class="bi bi-chat-left-text me-1"></i> <?= html_escape($it['notes']) ?></span>
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

        <!-- RIGHT COLUMN (PHOTOS & SIGNATURES) -->
        <div class="col-lg-4">
            <!-- FOTO PASIEN -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-bounding-box text-info me-2"></i>Foto Pasien</h5>
                    <span class="badge bg-danger"><i class="bi bi-shield-lock me-1"></i> Rahasia</span>
                </div>
                <div class="card-body text-center">
                    <?php if (!empty($handover['patient_photo_path']) && file_exists(FCPATH . ltrim($handover['patient_photo_path'], '/\\'))): ?>
                        <a href="<?= base_url('admin/media/patient/' . $handover['id']) ?>" target="_blank">
                            <img src="<?= base_url('admin/media/patient/' . $handover['id']) ?>" alt="Foto Pasien" class="img-fluid rounded border shadow-sm" style="max-height: 250px;">
                        </a>
                        <small class="text-muted d-block mt-2"><i class="bi bi-zoom-in me-1"></i> Klik untuk ukuran penuh</small>
                    <?php else: ?>
                        <div class="py-4 text-muted">
                            <i class="bi bi-camera-video-off display-4 d-block mb-2 text-secondary"></i>
                            <p class="mb-0">Tidak ada foto pasien diunggah.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CATATAN -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text text-primary me-2"></i>Catatan Tambahan</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($handover['notes'])): ?>
                        <p class="text-dark bg-light p-3 rounded border mb-0" style="white-space: pre-line; font-size: .92rem;"><?= html_escape($handover['notes']) ?></p>
                    <?php else: ?>
                        <p class="text-muted mb-0 text-center py-2">Tidak ada catatan khusus.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TANDA TANGAN DIGITAL -->
            <div class="card border mb-4 shadow-sm">
                <div class="card-header py-3 bg-light border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pen-fill text-primary me-2"></i>Tanda Tangan Digital</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-dark mb-1 small">Penyerah</div>
                                <?php if (!empty($handover['sender_signature_path']) && file_exists(FCPATH . ltrim($handover['sender_signature_path'], '/\\'))): ?>
                                    <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/sender') ?>" alt="TTD Penyerah" class="img-fluid border rounded bg-white p-1" style="max-height: 80px;">
                                <?php else: ?>
                                    <p class="text-muted small mb-0">-</p>
                                <?php endif; ?>
                                <div class="mt-1 text-dark fw-bold small"><?= html_escape($handover['sender_name']) ?></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="border rounded p-2 bg-light">
                                <div class="fw-semibold text-dark mb-1 small">Penerima</div>
                                <?php if (!empty($handover['receiver_signature_path']) && file_exists(FCPATH . $handover['receiver_signature_path'])): ?>
                                    <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/receiver') ?>" alt="TTD Penerima" class="img-fluid border rounded bg-white p-1" style="max-height: 80px;">
                                <?php else: ?>
                                    <p class="text-muted small mb-0">-</p>
                                <?php endif; ?>
                                <div class="mt-1 text-dark fw-bold small"><?= html_escape($handover['receiver_name']) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['print']) && $_GET['print'] == 1): ?>
<script>
    window.addEventListener('load', function() {
        window.print();
    });
</script>
<?php endif; ?>
