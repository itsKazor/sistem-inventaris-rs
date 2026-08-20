<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= html_escape(isset($title) ? $title : 'Sistem Inventaris & Serah Terima Kamar RS') ?></title>
    <!-- built by itsKazor : https://github.com/itsKazor -->

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/image.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">

    <style>
        :root {
            --rs-blue: #2563eb;
            --rs-border: #e2e8f0;
        }

        body {
            background: radial-gradient(700px circle at 50% -10%, rgba(37, 99, 235, .08), transparent 60%), #eef1f6;
            padding: 16px 0 40px;
        }

        /* Responsive Paper Document - Optimized for Tablet / iPad Full Width */
        .paper-document {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 12px 32px rgba(15, 23, 42, .08);
            border: 1px solid var(--rs-border);
            padding: 32px;
            max-width: 1320px;
            width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 1199.98px) {
            body {
                padding: 10px 0 24px;
            }

            .paper-document {
                padding: 24px 20px;
                border-radius: 14px;
                max-width: 100%;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 6px 0 20px;
            }

            .paper-document {
                padding: 16px 12px;
                border-radius: 12px;
            }
        }

        .doc-header-title {
            background: linear-gradient(120deg, #2563eb 0%, #1e40af 100%);
            color: #ffffff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 16px 20px;
            border-radius: 12px;
            text-align: center;
            font-size: 1.05rem;
            line-height: 1.5;
        }

        .doc-section-title {
            background-color: #f1f5f9;
            color: #0f172a;
            font-size: .88rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 16px;
            border-radius: 10px;
            border-left: 4px solid var(--rs-blue);
            margin-top: 24px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
        }

        .doc-section-title i {
            color: var(--rs-blue);
        }

        .doc-table {
            border: 1px solid var(--rs-border);
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .doc-table th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 700;
            font-size: .8rem;
            text-transform: uppercase;
            border-bottom: 1px solid var(--rs-border);
            padding: 12px;
            vertical-align: middle;
        }

        .doc-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 12px;
            vertical-align: middle;
            font-size: .92rem;
        }

        .doc-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .alert-warning-hospital {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            font-size: .92rem;
        }

        .signature-box {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            position: relative;
            touch-action: none;
        }

        /* Touch Friendly Form Controls for Tablet/iPad */
        .form-control, .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .95rem;
            min-height: 44px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--rs-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .status-btn-group {
            display: flex;
            flex-wrap: nowrap;
            gap: 3px;
            width: 100%;
        }

        .status-btn-group .btn {
            font-size: .75rem;
            font-weight: 600;
            padding: 5px 6px;
            border-radius: 6px;
            white-space: nowrap;
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .status-btn-group .btn-check:checked + .btn-outline-success {
            background-color: #16a34a !important; color: #fff !important;
        }
        .status-btn-group .btn-check:checked + .btn-outline-danger {
            background-color: #dc2626 !important; color: #fff !important;
        }
        .status-btn-group .btn-check:checked + .btn-outline-warning {
            background-color: #d97706 !important; color: #fff !important;
        }
        .status-btn-group .btn-check:checked + .btn-outline-secondary {
            background-color: #475569 !important; color: #fff !important;
        }
        .status-btn-group .btn-check:checked + .btn-outline-dark {
            background-color: #1e293b !important; color: #fff !important;
        }

        .alert-danger-hospital {
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #991b1b;
            border-radius: 12px;
            padding: 20px;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .statement-text {
            font-size: .95rem;
            font-weight: 500;
            color: #334155;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="container-fluid px-1 px-md-3">
