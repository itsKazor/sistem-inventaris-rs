<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= esc($title ?? 'Sistem Inventaris & Serah Terima Kamar RS') ?></title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --rs-navy: #0B2F64;
            --rs-header-bg: #0B2F64;
            --rs-blue: #0D3B7A;
            --rs-green: #2E7D32;
            --rs-orange: #E65100;
            --rs-light-blue: #f0f4f9;
            --rs-border: #cbd5e1;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #e2e8f0;
            color: #1e293b;
            padding-top: 20px;
            padding-bottom: 40px;
        }

        .paper-document {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #cbd5e1;
            padding: 30px;
            max-width: 1150px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .paper-document {
                padding: 16px;
                border-radius: 8px;
            }
        }

        .doc-header-title {
            background-color: var(--rs-header-bg);
            color: #ffffff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 20px;
            border-radius: 8px;
            text-align: center;
        }

        .doc-section-title {
            background-color: var(--rs-header-bg);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 8px 14px;
            border-radius: 4px;
            margin-top: 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .doc-table {
            border: 1px solid var(--rs-border);
            width: 100%;
        }

        .doc-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            border: 1px solid var(--rs-border);
            padding: 10px;
            vertical-align: middle;
        }

        .doc-table td {
            border: 1px solid var(--rs-border);
            padding: 8px 10px;
            vertical-align: middle;
            font-size: 0.92rem;
        }

        .alert-warning-hospital {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
            border-radius: 8px;
            padding: 14px;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .signature-box {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            position: relative;
            touch-action: none;
        }

        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--rs-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.15);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="container-fluid px-2 px-sm-3">
    <?= $this->renderSection('content') ?>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
