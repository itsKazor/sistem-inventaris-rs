<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title) ?> - RSU Catharina 1914</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #525659;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        /* Top PDF Toolbar */
        .pdf-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #2b2e31;
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

        .pdf-toolbar .doc-title .badge {
            font-size: 0.72rem;
            letter-spacing: 0.5px;
        }

        .pdf-viewer-container {
            padding-top: 76px;
            padding-bottom: 50px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* A4 Paper Sheet Simulation */
        .a4-paper {
            width: 210mm;
            min-height: 297mm;
            padding: 12mm 15mm;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.45);
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5px;
            color: #000;
            line-height: 1.3;
            position: relative;
        }

        /* Kop Surat */
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

        /* Judul Dokumen */
        .judul-row {
            position: relative;
            text-align: center;
            margin-top: 10px;
            padding-right: 120px;
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
            background: #fff;
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
            padding: 3px 5px;
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

        .ftable tbody tr:nth-child(even) td {
            background: #fafafa;
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
            min-height: 40px;
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

        .sig-box .sig-empty {
            color: #9ca3af;
            font-size: 8px;
            font-style: italic;
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
            font-size: 10px;
            text-align: justify;
        }

        .pernyataan-warning {
            margin: 0;
            font-size: 10px;
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

        /* PRINT STYLES */
        @media print {
            .pdf-toolbar {
                display: none !important;
            }

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

            @page {
                size: A4 portrait;
                margin: 7mm 8mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <!-- TOP TOOLBAR -->
    <div class="pdf-toolbar">
        <div class="doc-title">
            <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
            <span>Preview Dokumen: <strong><?= html_escape($handover['handover_number']) ?></strong></span>
            <?php if ($handover['status'] === 'reviewed'): ?>
                <span class="badge bg-success"><i class="bi bi-check-all me-1"></i>Diverifikasi</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</span>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- PRINT / DOWNLOAD PDF BUTTON -->
            <button onclick="window.print()" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
            </button>

            <!-- BACK / CLOSE BUTTON -->
            <a href="<?= base_url('admin/handovers/show/' . $handover['id']) ?>" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i> Detail Transaksi
            </a>

            <button onclick="window.close()" class="btn btn-secondary btn-sm px-2" title="Tutup Tab">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <!-- VIEWER CONTAINER -->
    <div class="pdf-viewer-container">
        <div class="a4-paper">

            <!-- KOP SURAT LOGO -->
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

            <!-- METADATA -->
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
                <tr>
                    <td class="meta-label">Status Dokumen</td>
                    <td class="meta-value"><?= $handover['status'] === 'reviewed' ? 'Telah Diverifikasi' : 'Menunggu Verifikasi' ?></td>
                    <td class="meta-label">Verifikator</td>
                    <td class="meta-value"><?= !empty($handover['reviewer_name']) ? html_escape($handover['reviewer_name']) : '-' ?></td>
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
                        <div class="field-label">Jabatan</div>
                        <div class="field-value"><?= html_escape($handover['sender_position']) ?: '-' ?></div>
                    </td>
                    <td>
                        <div class="field-label">Nama Lengkap Penerima</div>
                        <div class="field-value"><?= html_escape($handover['receiver_name']) ?></div>
                        <div class="field-label">Jabatan</div>
                        <div class="field-value"><?= html_escape($handover['receiver_position']) ?: '-' ?></div>
                    </td>
                </tr>
            </table>

            <!-- 2. CHECKLIST -->
            <?php
            $condLabels = array(
                'good'          => 'Baik',
                'damaged'       => 'Rusak',
                'need_repair'   => 'Perlu Perbaikan',
                'shortage'      => 'Kurang',
                'not_available' => 'Tidak Ada'
            );
            ?>
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
                    <?php if (!empty($items)): ?>
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
                    <?php else: ?>
                        <tr><td colspan="7" class="center text-muted">Tidak ada item inventaris.</td></tr>
                    <?php endif; ?>
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
                        <?php else: ?>
                            <span class="sig-empty">Belum ada tanda tangan</span>
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
                        <?php else: ?>
                            <span class="sig-empty">Belum ada tanda tangan</span>
                        <?php endif; ?>
                    </div>
                    <div class="name-line"><?= html_escape($handover['receiver_name']) ?></div>
                    <div class="pos-line"><?= html_escape($handover['receiver_position']) ?></div>
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

    <?php if (isset($_GET['print']) && $_GET['print'] == 1): ?>
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 300);
        });
    </script>
    <?php endif; ?>

</body>
</html>
