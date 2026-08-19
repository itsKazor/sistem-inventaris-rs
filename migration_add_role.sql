-- ============================================================
-- MIGRATION: Update Role kepala_ruangan
-- File ini sudah dieksekusi otomatis oleh sistem.
-- Jalankan HANYA jika database belum diupdate.
-- ============================================================

-- 1. Ubah ENUM role menjadi administrator dan kepala_ruangan
ALTER TABLE `users`
    MODIFY COLUMN `role` ENUM('administrator','kepala_ruangan') NOT NULL DEFAULT 'administrator';

-- 2. Update nilai lama 'admin' menjadi 'administrator'
UPDATE `users` SET `role` = 'administrator' WHERE `role` = 'admin';

-- 3. Contoh insert user kepala ruangan (password: kepala123)
INSERT INTO `users` (`name`, `username`, `email`, `password`, `role`, `is_active`, `created_at`, `updated_at`)
VALUES (
    'Kepala Ruangan 1',
    'kepala1',
    'kepala1@rs.local',
    '$2y$10$mlUjzsNieZEfC4RBbTvrCuD73wSrgDs21OB6HNnbqLJYV/7YzZnO6',
    'kepala_ruangan',
    1,
    NOW(),
    NOW()
);
