<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Portal') ?> - Sistem Inventaris RS</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --rs-navy: #0B2F64;
            --rs-blue: #0D3B7A;
            --rs-light-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--rs-light-bg);
            color: #1e293b;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--rs-navy);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 16px 20px;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-menu {
            padding: 15px 10px;
        }

        .sidebar-heading {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            padding: 12px 14px 6px 14px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.92rem;
            margin-bottom: 4px;
            transition: all 0.2s;
        }

        .nav-link-custom i {
            font-size: 1.1rem;
            margin-right: 12px;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .nav-link-custom.active {
            font-weight: 700;
            background-color: #0D3B7A;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }

        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 24px;
        }

        .main-content {
            padding: 24px;
            flex: 1;
        }

        .card-stat {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- DESKTOP SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-2">
        <img src="<?= base_url('assets/images/image.png') ?>" alt="RSU Catharina 1914" style="height: 42px; width: auto; background: #fff; padding: 4px; border-radius: 6px;">
        <div>
            <div style="line-height: 1.2; font-size: 0.9rem; font-weight: 800;">INVENTARIS RS</div>
            <div class="small fw-normal text-white-50" style="font-size: 0.7rem;">RSU Catharina 1914</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link-custom <?= url_is('admin/dashboard*') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-heading">Master Data</div>
        <a href="<?= base_url('admin/rooms') ?>" class="nav-link-custom <?= url_is('admin/rooms*') ? 'active' : '' ?>">
            <i class="bi bi-building"></i> Master Ruang
        </a>
        <a href="<?= base_url('admin/room-numbers') ?>" class="nav-link-custom <?= url_is('admin/room-numbers*') && !url_is('admin/room-numbers/*/history') ? 'active' : '' ?>">
            <i class="bi bi-door-closed"></i> Master Kamar
        </a>

        <a href="<?= base_url('admin/inventory-items') ?>" class="nav-link-custom <?= url_is('admin/inventory-items*') ? 'active' : '' ?>">
            <i class="bi bi-box"></i> Master Inventaris
        </a>

        <div class="sidebar-heading">Inventaris Standar</div>
        <a href="<?= base_url('admin/room-inventories') ?>" class="nav-link-custom <?= url_is('admin/room-inventories*') ? 'active' : '' ?>">
            <i class="bi bi-sliders"></i> Inventaris per Kamar
        </a>

        <div class="sidebar-heading">Transaksi & Riwayat</div>
        <a href="<?= base_url('admin/handovers') ?>" class="nav-link-custom <?= url_is('admin/handovers*') ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text"></i> Transaksi Serah Terima
        </a>

        <div class="sidebar-heading">Laporan</div>
        <a href="<?= base_url('admin/reports/issues') ?>" class="nav-link-custom <?= url_is('admin/reports/issues*') ? 'active' : '' ?>">
            <i class="bi bi-exclamation-triangle-fill text-warning"></i> Laporan Masalah
        </a>

        <div class="sidebar-heading">Akun</div>
        <a href="<?= base_url('admin/logout') ?>" class="nav-link-custom text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</aside>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-wrapper">
    <!-- TOP NAVBAR -->
    <header class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <!-- Mobile Toggle Button -->
            <button class="btn btn-light d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h5 class="fw-bold mb-0 text-dark"><?= esc($title ?? 'Dashboard Admin') ?></h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('serah-terima') ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-phone me-1"></i> Form Perawat (Tablet)
            </a>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle fw-semibold rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1 text-primary"></i> <?= esc(session()->get('name') ?? 'Admin') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><span class="dropdown-item-text text-muted small">Role: Administrator</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- MOBILE OFFCANVAS SIDEBAR -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" style="width: 280px;">
        <div class="offcanvas-header border-bottom border-secondary py-3">
            <h5 class="offcanvas-title fw-bold text-white"><i class="bi bi-hospital-fill me-2 text-primary"></i> INVENTARIS RS</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-2">
            <div class="sidebar-menu">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="<?= base_url('admin/rooms') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-building"></i> Master Ruang
                </a>
                <a href="<?= base_url('admin/room-numbers') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-door-closed"></i> Master Kamar
                </a>

                <a href="<?= base_url('admin/inventory-items') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-box"></i> Master Inventaris
                </a>
                <a href="<?= base_url('admin/room-inventories') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-sliders"></i> Inventaris per Kamar
                </a>
                <a href="<?= base_url('admin/handovers') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-file-earmark-text"></i> Transaksi Serah Terima
                </a>
                <a href="<?= base_url('admin/reports/issues') ?>" class="nav-link-custom text-white">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Laporan Masalah
                </a>
                <a href="<?= base_url('admin/logout') ?>" class="nav-link-custom text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="main-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                <span><?= session()->getFlashdata('success') ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                <span><?= session()->getFlashdata('error') ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
