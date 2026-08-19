<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape(isset($title) ? $title : 'Admin Portal') ?> - Sistem Inventaris RS</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/image.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

<?php
$_user_role  = $this->session->userdata('admin_role');
$_is_admin   = ($_user_role === 'administrator');
$_role_label = $_is_admin ? 'Administrator' : 'Kepala Ruangan';
?>

<!-- DESKTOP SIDEBAR -->
<aside class="app-sidebar" id="desktopSidebar">
    <div class="sidebar-brand">
        <img src="<?= base_url('assets/images/image.png') ?>" alt="RSU Catharina 1914">
        <div class="sidebar-brand-text">
            <div class="brand-title">INVENTARIS RS</div>
            <div class="brand-sub">RSU Catharina 1914</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <?php if ($_is_admin): ?>
        <div class="sidebar-heading">Master Data</div>
        <a href="<?= base_url('admin/rooms') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'rooms') ? 'active' : '' ?>">
            <i class="bi bi-building"></i> Master Ruang
        </a>
        <a href="<?= base_url('admin/room-numbers') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'room-numbers') ? 'active' : '' ?>">
            <i class="bi bi-door-closed"></i> Master Kamar
        </a>
        <a href="<?= base_url('admin/inventory-items') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'inventory-items') ? 'active' : '' ?>">
            <i class="bi bi-box"></i> Master Inventaris
        </a>

        <div class="sidebar-heading">Inventaris Standar</div>
        <a href="<?= base_url('admin/room-inventories') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'room-inventories') ? 'active' : '' ?>">
            <i class="bi bi-sliders"></i> Inventaris per Kamar
        </a>
        <?php endif; ?>

        <div class="sidebar-heading">Transaksi &amp; Riwayat</div>
        <a href="<?= base_url('admin/handovers') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'handovers') ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text"></i> Transaksi Serah Terima
        </a>

        <?php if ($_is_admin): ?>
        <div class="sidebar-heading">Laporan</div>
        <a href="<?= base_url('admin/reports/issues') ?>" class="nav-link-custom <?= ($this->uri->segment(3) == 'issues') ? 'active' : '' ?>">
            <i class="bi bi-exclamation-triangle-fill"></i> Laporan Masalah
        </a>
        <?php endif; ?>

        <?php if ($_is_admin): ?>
        <div class="sidebar-heading">Pengaturan</div>
        <a href="<?= base_url('admin/users') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
            <i class="bi bi-people-fill"></i> Pengaturan User
        </a>
        <?php endif; ?>

        <a href="<?= base_url('admin/logout') ?>" class="nav-link-custom text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
    <div class="sidebar-footer">
        <span class="version-tag">INVENTARIS RS v1.0 &copy; <?= date('Y') ?></span>
    </div>
</aside>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-wrapper">
    <!-- TOP NAVBAR -->
    <header class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h1 class="navbar-title"><?= html_escape(isset($title) ? $title : ($_is_admin ? 'Dashboard Admin' : 'Dashboard Kepala Ruangan')) ?></h1>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url('serah-terima') ?>" target="_blank" class="btn btn-outline-primary btn-sm d-none d-sm-inline-flex align-items-center gap-1" style="font-size: .8rem;">
                <i class="bi bi-phone"></i> Form Perawat
            </a>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle d-inline-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle text-primary"></i>
                    <span><?= html_escape($this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Admin') ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2">
                    <li><span class="dropdown-item-text text-muted small">Role: <?= html_escape($_role_label) ?></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- MOBILE OFFCANVAS SIDEBAR -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" style="width: var(--rs-sidebar-width);">
        <div class="offcanvas-header border-bottom py-3">
            <div class="d-flex align-items-center gap-2">
                <img src="<?= base_url('assets/images/image.png') ?>" alt="RSU Catharina 1914" style="height: 34px; width: auto; border-radius: 6px;">
                <div class="lh-sm">
                    <div class="fw-bold" style="font-size: .9rem;">INVENTARIS RS</div>
                    <div class="text-muted" style="font-size: .68rem;">RSU Catharina 1914</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-2">
            <nav class="sidebar-menu">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <?php if ($_is_admin): ?>
                <div class="sidebar-heading">Master Data</div>
                <a href="<?= base_url('admin/rooms') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'rooms') ? 'active' : '' ?>">
                    <i class="bi bi-building"></i> Master Ruang
                </a>
                <a href="<?= base_url('admin/room-numbers') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'room-numbers') ? 'active' : '' ?>">
                    <i class="bi bi-door-closed"></i> Master Kamar
                </a>
                <a href="<?= base_url('admin/inventory-items') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'inventory-items') ? 'active' : '' ?>">
                    <i class="bi bi-box"></i> Master Inventaris
                </a>
                <div class="sidebar-heading">Inventaris Standar</div>
                <a href="<?= base_url('admin/room-inventories') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'room-inventories') ? 'active' : '' ?>">
                    <i class="bi bi-sliders"></i> Inventaris per Kamar
                </a>
                <?php endif; ?>

                <div class="sidebar-heading">Transaksi &amp; Riwayat</div>
                <a href="<?= base_url('admin/handovers') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'handovers') ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text"></i> Transaksi Serah Terima
                </a>

                <?php if ($_is_admin): ?>
                <div class="sidebar-heading">Laporan</div>
                <a href="<?= base_url('admin/reports/issues') ?>" class="nav-link-custom <?= ($this->uri->segment(3) == 'issues') ? 'active' : '' ?>">
                    <i class="bi bi-exclamation-triangle-fill"></i> Laporan Masalah
                </a>

                <div class="sidebar-heading">Pengaturan</div>
                <a href="<?= base_url('admin/users') ?>" class="nav-link-custom <?= ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> Pengaturan User
                </a>
                <?php endif; ?>

                <a href="<?= base_url('admin/logout') ?>" class="nav-link-custom text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="main-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 align-middle"></i>
                <span><?= html_escape($this->session->flashdata('success')) ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 align-middle"></i>
                <span><?= html_escape($this->session->flashdata('error')) ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

