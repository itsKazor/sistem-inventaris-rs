<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape(isset($title) ? $title : 'Login Admin') ?> - Sistem Inventaris RS</title>
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
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background:
                radial-gradient(800px circle at 20% 20%, rgba(37, 99, 235, .08), transparent 50%),
                radial-gradient(600px circle at 80% 80%, rgba(37, 99, 235, .06), transparent 50%),
                #f4f6f9;
            position: relative;
            overflow: hidden;
        }

        /* Background decorative circles */
        body::before {
            content: '';
            position: fixed;
            top: -200px;
            right: -150px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(37, 99, 235, .04), rgba(37, 99, 235, .01));
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -250px;
            left: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(37, 99, 235, .03), transparent);
            pointer-events: none;
        }

        .login-wrap {
            width: 100%;
            max-width: 430px;
            position: relative;
            z-index: 1;
            animation: fadeInUp .5s cubic-bezier(.2, .9, .3, 1);
        }

        .login-card {
            background: #ffffff;
            border: 1px solid var(--rs-border);
            border-radius: 20px;
            box-shadow:
                0 1px 3px rgba(15, 23, 42, .04),
                0 12px 40px rgba(15, 23, 42, .08);
            padding: 44px 40px 36px;
        }

        .login-logo {
            height: 56px;
            width: auto;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .login-title {
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: .3px;
            color: var(--rs-text);
            background: linear-gradient(135deg, var(--rs-primary) 0%, var(--rs-primary-darker) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-sub {
            color: var(--rs-text-muted);
            font-size: .85rem;
            line-height: 1.5;
        }

        .input-group-text {
            border-color: var(--rs-border-strong);
            background: #f8fafc;
            border-radius: 10px 0 0 10px !important;
            color: var(--rs-text-faint);
            transition: all .2s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--rs-primary);
            color: var(--rs-primary);
            background: var(--rs-primary-soft);
        }

        .form-control {
            border-radius: 0 10px 10px 0 !important;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--rs-primary) 0%, var(--rs-primary-dark) 100%);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: .02em;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .25);
            transition: all .2s ease;
        }

        .btn-login:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
            transform: translateY(-2px);
            background: linear-gradient(135deg, var(--rs-primary-dark) 0%, var(--rs-primary-darker) 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            opacity: .7;
            transition: opacity .2s;
        }

        .login-footer:hover {
            opacity: 1;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="login-wrap">
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/images/image.png') ?>" alt="RSU Catharina 1914" class="login-logo">
            <h1 class="login-title mb-1">PORTAL ADMIN</h1>
            <p class="login-sub mb-0">Sistem Inventaris & Serah Terima Kamar<br>RSU Catharina 1914</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 small" role="alert">
                <i class="bi bi-exclamation-circle-fill me-1"></i> <?= html_escape($this->session->flashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 small" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> <?= html_escape($this->session->flashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="post">

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold" style="font-size: .82rem;">Username atau Email</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Masukkan username/email" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold" style="font-size: .82rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 py-2" style="padding-block: .7rem;">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Dashboard
            </button>
        </form>
    </div>

    <div class="text-center mt-4 login-footer">
        <a href="<?= base_url('serah-terima') ?>" class="text-decoration-none small text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Form Perawat
        </a>
    </div>

    <div class="text-center mt-2">
        <span class="text-muted" style="font-size: .7rem; opacity: .5;">&copy; <?= date('Y') ?> RSU Catharina 1914</span>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
