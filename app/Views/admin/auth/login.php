<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login Admin') ?> - Sistem Inventaris RS</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f2c59 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }

        .login-header {
            background-color: #0f2c59;
            color: #ffffff;
            padding: 32px 24px;
            text-align: center;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }

        .form-control:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.15);
        }

        .btn-login {
            background-color: #1d4ed8;
            color: #ffffff;
            font-weight: 700;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background-color: #1e40af;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="mb-3 mx-auto" style="max-width: 320px;">
            <img src="<?= base_url('assets/images/image.png') ?>" alt="RSU Catharina 1914" style="height: 55px; width: auto; object-fit: contain;">
        </div>
        <h4 class="fw-bold mb-1">PORTAL ADMIN INVENTARIS</h4>
        <p class="mb-0 text-white-50 small">RSU Catharina 1914</p>
    </div>

    <div class="p-4 p-sm-5">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 small" role="alert">
                <i class="bi bi-exclamation-circle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 small" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="login" class="form-label fw-bold text-dark small">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                    <input type="text" class="form-control border-start-0" id="login" name="login" value="<?= old('login') ?>" placeholder="Masukkan username/email" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold text-dark small">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                    <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i> MASUK ADMIN
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <a href="<?= base_url('serah-terima') ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Form Tablet Perawat
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
