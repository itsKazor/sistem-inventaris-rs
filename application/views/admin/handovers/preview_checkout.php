<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title) ?> - RSU Catharina 1914</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            background-color: #525659;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .pdf-toolbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: #1e293b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .pdf-toolbar .doc-title {
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #e2e8f0;
        }

        .pdf-viewer-container {
            padding-top: 76px;
            padding-bottom: 50px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .a4-paper {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 14mm;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0,0,0,0.45);
            font-family: 'Times New Roman', Times, serif;
            font-size: 10px;
            color: #000;
            line-height: 1.25;
        }

        .kop-logo-centered {
            text-align: center;
            margin-bottom: 2px;
        }

        .kop-logo-centered img {
            height: 65px;
            width: auto;
            filter: grayscale(100%);
        }

        .kop-rule-thick {
            border-top: 2.5px solid #000;
            margin-top: 3px;
        }

        .kop-rule-thin {
            border-top: 0.8px solid #000;
            margin-top: 1.5px;
        }

        .judul-row {
            position: relative;
            text-align: center;
            margin-top: 6px;
            padding-right: 125px;
        }

        .judul-title {
            font-size: 12.5px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .judul-sub {
            font-size: 9px;
            margin-top: 1px;
            font-weight: bold;
            color: #444;
        }

        .judul-no {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            border: 1px solid #000;
            padding: 2px 6px;
            background: #fff;
        }

        .judul-no-label {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .judul-no-value {
            font-size: 10px;
            font-weight: bold;
        }

        .judul-rule {
            border-top: 1.2px solid #000;
            margin: 4px 0 6px;
        }

        .sec-title {
            font-size: 10.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1.2px solid #000;
            padding-bottom: 1px;
            margin: 8px 0 4px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .meta-table td {
            border: 1px solid #000;
            font-size: 9px;
            padding: 3px 5px;
            vertical-align: middle;
        }

        .meta-table .meta-label {
            background: #e5e5e5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8px;
            width: 125px;
        }

        .ftable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .ftable th, .ftable td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
        }

        .ftable th {
            font-size: 8px;
            text-transform: uppercase;
            background: #e5e5e5;
            font-weight: bold;
        }

        .ftable td {
            font-size: 9.5px;
        }

        .ftable tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .ftable .center { text-align: center; }

        .notes-box {
            border: 1px solid #000;
            min-height: 36px;
            padding: 4px 6px;
            font-size: 9.5px;
        }

        .ttd-grid {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 4px;
        }

        .ttd-col {
            width: 200px;
            text-align: center;
        }

        .ttd-role {
            font-weight: bold;
            font-size: 9.5px;
            text-transform: uppercase;
        }

        .ttd-sub {
            font-size: 8px;
            font-style: italic;
        }

        .sig-box {
            border: 1px solid #000;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px 0 1px;
            background: #fff;
        }

        .sig-box img {
            max-height: 44px;
            max-width: 85%;
            filter: grayscale(100%);
        }

        .sig-box .sig-empty {
            color: #9ca3af;
            font-size: 8px;
            font-style: italic;
        }

        .name-line {
            border-top: 1px solid #000;
            padding-top: 2px;
            font-size: 9.5px;
            font-weight: bold;
            min-height: 14px;
        }

        .pernyataan-box {
            border: 1.2px solid #000;
            border-radius: 3px;
            padding: 5px 8px;
            margin: 4px 0 6px;
        }

        .pernyataan-text {
            margin: 0 0 3px;
            font-size: 9.5px;
            text-align: justify;
        }

        .pernyataan-warning {
            margin: 0;
            font-size: 9.5px;
            text-align: justify;
            border-top: 1px dashed #000;
            padding-top: 3px;
        }

        .liability-badge {
            background: #000;
            color: #fff;
            padding: 1px 4px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 2px;
        }

        .footer {
            margin-top: 8px;
            border-top: 1px solid #000;
            padding-top: 3px;
            text-align: center;
            font-size: 7.5px;
            letter-spacing: 0.3px;
        }

        @media print {
            .pdf-toolbar { display: none !important; }

            body {
                background: #fff !important;
                padding: 0 !important;
            }

            .pdf-viewer-container {
                padding: 0 !important;
                min-height: auto !important;
                display: block !important;
            }

            .a4-paper {
                width: 100% !important;
                min-height: auto !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .a4-paper img {
                filter: grayscale(100%) !important;
            }

            @page {
                size: A4 portrait;
                margin: 8mm 10mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <!-- TOOLBAR -->
    <div class="pdf-toolbar">
        <div class="doc-title">
            <i class="bi bi-file-earmark-check-fill text-dark fs-5"></i>
            <span>Berita Acara Check-out: <strong><?= html_escape($handover['handover_number']) ?></strong></span>
            <?php if ($handover['checkout_status'] === 'has_liability'): ?>
                <span class="badge bg-dark"><i class="bi bi-exclamation-triangle-fill me-1"></i>Ada Ganti Rugi</span>
            <?php else: ?>
                <span class="badge bg-secondary"><i class="bi bi-check-circle-fill me-1"></i>Sesuai</span>
            <?php endif; ?>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button onclick="window.print()" class="btn btn-dark btn-sm px-3 fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak / PDF
            </button>
            <a href="<?= base_url('admin/handovers/show/' . $handover['id']) ?>" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button onclick="window.close()" class="btn btn-secondary btn-sm px-2" title="Tutup Tab">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <!-- DOKUMEN -->
    <div class="pdf-viewer-container">
        <div class="a4-paper">

            <!-- KOP SURAT -->
            <div class="kop-logo-centered">
                <img src="<?= base_url('assets/images/logo_rs.png') ?>" alt="RSU Catharina 1914">
            </div>
            <div class="kop-rule-thick"></div>
            <div class="kop-rule-thin"></div>

            <!-- JUDUL -->
            <div class="judul-row">
                <div class="judul-text">
                    <div class="judul-title">Dokumen Rekonsiliasi Inventaris Kamar Pasien Pulang</div>
                    <div class="judul-sub">Hasil Pemeriksaan Inventaris Saat Pasien Masuk dan Pulang</div>
                </div>
                <div class="judul-no">
                    <div class="judul-no-label">No. Transaksi</div>
                    <div class="judul-no-value"><?= html_escape($handover['handover_number']) ?></div>
                </div>
            </div>
            <div class="judul-rule"></div>

            <!-- METADATA -->
            <table class="meta-table">
                <tr>
                    <td class="meta-label">Ruang Perawatan</td>
                    <td><b><?= html_escape($handover['room_name']) ?> (<?= html_escape($handover['room_number_name']) ?>)</b></td>
                    <td class="meta-label">Status Check-out</td>
                    <td>
                        <?php if ($handover['checkout_status'] === 'has_liability'): ?>
                            <b>DITEMUKAN SELISIH / GANTI RUGI</b>
                        <?php else: ?>
                            <b>LENGKAP &amp; SESUAI</b>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="meta-label">Tanggal Masuk</td>
                    <td><?= date('d F Y', strtotime($handover['handover_date'])) ?> <?= html_escape($handover['handover_time']) ?> WIB</td>
                    <td class="meta-label">Tanggal Pulang</td>
                    <td>
                        <?php if (!empty($handover['checkout_date'])): ?>
                            <?= date('d F Y', strtotime($handover['checkout_date'])) ?>
                            <?= !empty($handover['checkout_time']) ? html_escape($handover['checkout_time']) . ' WIB' : '' ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="meta-label">Pemeriksa</td>
                    <td><b><?= html_escape($handover['checkout_officer_name'] ?: '-') ?></b></td>
                    <td></td>
                    <td><b><?= html_escape($handover['checkout_head_name'] ?? '-') ?></b></td>
                </tr>
            </table>

            <!-- 1. KOMPARASI INVENTARIS -->
            <?php
            $condLabels = array(
                'good'          => 'Baik',
                'damaged'       => 'Rusak',
                'need_repair'   => 'Perbaikan',
                'shortage'      => 'Kurang/Hilang',
                'not_available' => 'Tidak Ada'
            );
            $hasIssues = false;
            ?>
            <div class="sec-title">1. Komparasi Fisik Inventaris: Masuk dan Pulang</div>
            <table class="ftable">
                <thead>
                    <tr>
                        <th class="center" width="20" rowspan="2">No</th>
                        <th rowspan="2">Uraian Fasilitas / Inventaris</th>
                        <th class="center" width="42" rowspan="2">Standar</th>
                        <th colspan="2" class="center">Saat Masuk</th>
                        <th colspan="2" class="center">Saat Keluar</th>
                        <th class="center" width="50" rowspan="2">Selisih</th>
                        <th class="center" width="70" rowspan="2">Ganti Rugi</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="center" width="32">Qty</th>
                        <th class="center" width="48">Kondisi</th>
                        <th class="center" width="32">Qty</th>
                        <th class="center" width="48">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $idx => $it): ?>
                            <?php
                            $chkQty = isset($it['checkout_actual_qty']) && $it['checkout_actual_qty'] !== null ? (int)$it['checkout_actual_qty'] : (int)$it['actual_quantity'];
                            $chkCond = isset($it['checkout_condition']) && $it['checkout_condition'] !== null ? $it['checkout_condition'] : 'good';
                            $diff = $chkQty - (int)$it['actual_quantity'];
                            $isLiab = isset($it['is_liability']) && (int)$it['is_liability'] === 1;
                            if ($isLiab) $hasIssues = true;
                            ?>
                            <tr>
                                <td class="center"><?= $idx + 1 ?></td>
                                <td><b><?= html_escape($it['inventory_name_snapshot']) ?></b></td>
                                <td class="center"><?= $it['standard_quantity_snapshot'] ?> <?= html_escape($it['inventory_unit_snapshot']) ?></td>
                                <td class="center"><?= $it['actual_quantity'] ?></td>
                                <td class="center"><?= isset($condLabels[$it['condition_status']]) ? $condLabels[$it['condition_status']] : $it['condition_status'] ?></td>
                                <td class="center"><b><?= $chkQty ?></b></td>
                                <td class="center"><?= isset($condLabels[$chkCond]) ? $condLabels[$chkCond] : $chkCond ?></td>
                                <td class="center">
                                    <?php if ($diff === 0): ?>
                                        0 (Pas)
                                    <?php elseif ($diff < 0): ?>
                                        <b>Kurang <?= abs($diff) ?></b>
                                    <?php else: ?>
                                        Lebih +<?= $diff ?>
                                    <?php endif; ?>
                                </td>
                                <td class="center">
                                    <?php if ($isLiab): ?>
                                        <span class="">WAJIB GANTI</span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= !empty($it['checkout_notes']) ? html_escape($it['checkout_notes']) : (!empty($it['notes']) ? html_escape($it['notes']) : '&nbsp;') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- 2. CATATAN -->
            <div class="sec-title">2. Catatan &amp; Instruksi Billing</div>
            <div class="notes-box">
                <?php if (!empty($handover['checkout_notes'])): ?>
                    <?= html_escape($handover['checkout_notes']) ?>
                <?php else: ?>
                    <?= $hasIssues ? 'Terdapat fasilitas kamar yang rusak atau hilang. Pasien/keluarga bersedia menanggung biaya penggantian.' : 'Seluruh inventaris kamar dalam kondisi lengkap dan baik. Tidak ada ganti rugi.' ?>
                <?php endif; ?>
            </div>

            <!-- 3. TANDA TANGAN -->
            <div class="sec-title">3. Tanda Tangan</div>
            <div class="ttd-grid">
                <div class="ttd-col">
                    <div class="ttd-role">Kepala Ruangan</div>
                    <div class="ttd-sub">(Mengetahui)</div>
                    <div class="sig-box">
                        <?php if (!empty($handover['checkout_head_signature_path']) && file_exists(FCPATH . ltrim($handover['checkout_head_signature_path'], '/\\'))): ?>
                            <img src="<?= base_url('admin/media/signature/' . $handover['id'] . '/checkout_head') ?>" alt="TTD Kepala Ruangan">
                        <?php else: ?>
                            <span class="sig-empty">Belum ada tanda tangan</span>
                        <?php endif; ?>
                    </div>
                    <div class="name-line"><?= html_escape($handover['checkout_head_name'] ?? '') ?></div>
                </div>
            </div>

            <!-- 4. PERNYATAAN -->
            <div class="sec-title">4. Pernyataan &amp; Ketentuan Penggantian</div>
            <div class="pernyataan-box">
                <p class="pernyataan-text">Kami menyatakan bahwa hasil pemeriksaan fisik fasilitas kamar di atas benar dan telah disepakati kedua belah pihak pada saat pasien pulang.</p>
                <p class="pernyataan-warning">Apabila terdapat fasilitas inventaris yang <b>hilang atau rusak</b> sebagaimana tercatat pada kolom ganti rugi, biaya penggantian dibebankan pada rincian billing kepulangan pasien.</p>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                Dokumen ini diterbitkan resmi oleh Sistem Inventaris &amp; Serah Terima Kamar RSU CATHARINA 1914 &nbsp;|&nbsp; Dicetak: <?= date('d/m/Y H:i') ?> WIB
            </div>

        </div>
    </div>

</body>
</html>