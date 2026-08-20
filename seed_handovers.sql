-- ============================================================
-- SEEDER: 5 Transaksi Serah Terima Kamar (Contoh/Data Uji)
-- Penerima = pasien | Jabatan penerima dikosongkan
-- Tanggal divariasikan (hari ini, bulan ini, bulan lalu, dll)
-- Jalankan: mysql -u root < seed_handovers.sql
-- ============================================================

USE sistem_serah_terima_rs;

-- Hapus dulu agar aman dijalankan ulang
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM handover_inventory_items;
DELETE FROM handovers;
SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------
-- 1. Transaksi #1 - Kelas I (PRB) / Kelas 1 Utama C - HARI INI
--    Status: submitted | Check-out: none (masih dirawat)
-- ------------------------------------------------------------
INSERT INTO handovers
(id, handover_number, room_id, room_number_id, handover_date, handover_time,
 sender_name, sender_position, receiver_name, receiver_position, notes,
 statement_confirmed, checkout_status, status, reviewed_by, reviewed_at,
 created_at, updated_at)
VALUES
(1, 'STR-20260820-00001', 1, 1, '2026-08-20', '07:30',
 'Siti Aminah', 'Shift Pagi', 'Ani Wijaya', NULL,
 'Pasien nyaman, tidak ada keluhan khusus.',
 1, 'none', 'submitted', NULL, NULL,
 '2026-08-20 07:30:00', '2026-08-20 07:30:00');

INSERT INTO handover_inventory_items
(handover_id, inventory_item_id, inventory_name_snapshot, inventory_unit_snapshot,
 standard_quantity_snapshot, actual_quantity, difference_quantity, condition_status, notes, created_at, updated_at)
VALUES
(1, 22, 'Tempat Tidur Pasien (+ Lemari)', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 27, 'TV', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 1, 'AC', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 3, 'Brangkas / Lemari', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 5, 'Dispenser', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 14, 'Meja Makan / Meja Makan Pasien', 'unit', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 6, 'Gayung', 'buah', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 17, 'Remote AC', 'buah', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00'),
(1, 26, 'Tong Sampah', 'buah', 1, 1, 0, 'good', NULL, '2026-08-20 07:30:00', '2026-08-20 07:30:00');

-- ------------------------------------------------------------
-- 2. Transaksi #2 - Kelas I (Nusa Indah) / Kamar 1 - 12 AGUSTUS
--    Status: reviewed | Check-out: cleared (sudah pulang, lengkap)
-- ------------------------------------------------------------
INSERT INTO handovers
(id, handover_number, room_id, room_number_id, handover_date, handover_time,
 sender_name, sender_position, receiver_name, receiver_position, notes,
 statement_confirmed, checkout_status, status, reviewed_by, reviewed_at,
 checkout_date, checkout_time, checkout_officer_name, checkout_patient_rep,
 checkout_notes, checkout_head_name, checkout_completed_at,
 created_at, updated_at)
VALUES
(2, 'STR-20260812-00001', 2, 8, '2026-08-12', '06:45',
 'Rudi Hartono', 'Shift Malam', 'Budi Santoso', NULL,
 'AC terasa kurang dingin, diminta pengecekan.',
 1, 'cleared', 'reviewed', 1, '2026-08-12 09:10:00',
 '2026-08-14', '11:30', 'Hadi Suryandi', 'Bpk. Santoso (ayah pasien)',
 'Seluruh inventaris lengkap dan sesuai. Tidak ada ganti rugi.',
 'Hadi Suryandi', '2026-08-14 11:30:00',
 '2026-08-12 06:45:00', '2026-08-14 11:30:00');

INSERT INTO handover_inventory_items
(handover_id, inventory_item_id, inventory_name_snapshot, inventory_unit_snapshot,
 standard_quantity_snapshot, actual_quantity, difference_quantity, condition_status, notes,
 checkout_actual_qty, checkout_difference_qty, checkout_condition, checkout_notes, is_liability,
 created_at, updated_at)
VALUES
(2, 22, 'Tempat Tidur Pasien (+ Lemari)', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 27, 'TV', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 1, 'AC', 'unit', 1, 1, 0, 'good', 'AC kurang dingin', 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 3, 'Brangkas / Lemari', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 5, 'Dispenser', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 14, 'Meja Makan / Meja Makan Pasien', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 17, 'Remote AC', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 26, 'Tong Sampah', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00'),
(2, 11, 'Kursi Plastik', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-08-12 06:45:00', '2026-08-14 11:30:00');
-- ------------------------------------------------------------
-- 3. Transaksi #3 - Kelas II (Nusa Indah) / Kamar 3 - 3 AGUSTUS
--    Status: submitted | Check-out: none (masih dirawat)
-- ------------------------------------------------------------
INSERT INTO handovers
(id, handover_number, room_id, room_number_id, handover_date, handover_time,
 sender_name, sender_position, receiver_name, receiver_position, notes,
 statement_confirmed, checkout_status, status, reviewed_by, reviewed_at,
 created_at, updated_at)
VALUES
(3, 'STR-20260803-00001', 3, 10, '2026-08-03', '08:15',
 'Agus Salim', 'Shift Pagi', 'Citra Lestari', NULL,
 'TV sempat tidak menyala, sudah dicoba kembali dan normal.',
 1, 'none', 'submitted', NULL, NULL,
 '2026-08-03 08:15:00', '2026-08-03 08:15:00');

INSERT INTO handover_inventory_items
(handover_id, inventory_item_id, inventory_name_snapshot, inventory_unit_snapshot,
 standard_quantity_snapshot, actual_quantity, difference_quantity, condition_status, notes, created_at, updated_at)
VALUES
(3, 22, 'Tempat Tidur Pasien (+ Lemari)', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 27, 'TV', 'unit', 1, 1, 0, 'good', 'TV sempat mati, normal kembali', '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 4, 'Digital (TV Box)', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 1, 'AC', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 5, 'Dispenser', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 9, 'Kipas Angin', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 14, 'Meja Makan / Meja Makan Pasien', 'unit', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00'),
(3, 6, 'Gayung', 'buah', 1, 1, 0, 'good', NULL, '2026-08-03 08:15:00', '2026-08-03 08:15:00');

-- ------------------------------------------------------------
-- 4. Transaksi #4 - Kelas III (Melati) / Kamar 1 - 18 JULI
--    Status: reviewed | Check-out: has_liability (remote AC hilang)
-- ------------------------------------------------------------
INSERT INTO handovers
(id, handover_number, room_id, room_number_id, handover_date, handover_time,
 sender_name, sender_position, receiver_name, receiver_position, notes,
 statement_confirmed, checkout_status, status, reviewed_by, reviewed_at,
 checkout_date, checkout_time, checkout_officer_name, checkout_patient_rep,
 checkout_notes, checkout_head_name, checkout_completed_at,
 created_at, updated_at)
VALUES
(4, 'STR-20260718-00001', 4, 18, '2026-07-18', '09:00',
 'Bambang Irawan', 'Shift Malam', 'Dedi Hermawan', NULL,
 'Remote AC sudah tidak ada sejak pasien masuk.',
 1, 'has_liability', 'reviewed', 1, '2026-07-18 09:40:00',
 '2026-07-22', '10:15', 'Hadi Suryandi', 'Ibu Nurjannah (keluarga pasien)',
 'Remote AC hilang, keluarga pasien bersedia mengganti Rp 150.000.',
 'Hadi Suryandi', '2026-07-22 10:15:00',
 '2026-07-18 09:00:00', '2026-07-22 10:15:00');

INSERT INTO handover_inventory_items
(handover_id, inventory_item_id, inventory_name_snapshot, inventory_unit_snapshot,
 standard_quantity_snapshot, actual_quantity, difference_quantity, condition_status, notes,
 checkout_actual_qty, checkout_difference_qty, checkout_condition, checkout_notes, is_liability,
 created_at, updated_at)
VALUES
(4, 22, 'Tempat Tidur Pasien (+ Lemari)', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 27, 'TV', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 1, 'AC', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 17, 'Remote AC', 'buah', 1, 0, -1, 'shortage', 'Remote AC tidak ada', 0, -1, 'shortage', 'Remote AC hilang, ganti rugi', 1, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 5, 'Dispenser', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 3, 'Brangkas / Lemari', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 6, 'Gayung', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00'),
(4, 26, 'Tong Sampah', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-07-18 09:00:00', '2026-07-22 10:15:00');

-- ------------------------------------------------------------
-- 5. Transaksi #5 - VIP / VIP A - 25 JUNI
--    Status: reviewed | Check-out: cleared (lengkap & sesuai)
-- ------------------------------------------------------------
INSERT INTO handovers
(id, handover_number, room_id, room_number_id, handover_date, handover_time,
 sender_name, sender_position, receiver_name, receiver_position, notes,
 statement_confirmed, checkout_status, status, reviewed_by, reviewed_at,
 checkout_date, checkout_time, checkout_officer_name, checkout_patient_rep,
 checkout_notes, checkout_head_name, checkout_completed_at,
 created_at, updated_at)
VALUES
(5, 'STR-20260625-00001', 6, 35, '2026-06-25', '14:00',
 'Nurhalimah', 'Shift Sore', 'Eko Prasetyo', NULL,
 'Pasien VIP, seluruh fasilitas kamar lengkap.',
 1, 'cleared', 'reviewed', 1, '2026-06-25 15:00:00',
 '2026-06-28', '09:00', 'Hadi Suryandi', 'Bpk. H. Abdullah (pasien)',
 'Tidak ada catatan khusus. Inventaris lengkap.',
 'Hadi Suryandi', '2026-06-28 09:00:00',
 '2026-06-25 14:00:00', '2026-06-28 09:00:00');

INSERT INTO handover_inventory_items
(handover_id, inventory_item_id, inventory_name_snapshot, inventory_unit_snapshot,
 standard_quantity_snapshot, actual_quantity, difference_quantity, condition_status, notes,
 checkout_actual_qty, checkout_difference_qty, checkout_condition, checkout_notes, is_liability,
 created_at, updated_at)
VALUES
(5, 22, 'Tempat Tidur Pasien (+ Lemari)', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 27, 'TV', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 1, 'AC', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 3, 'Brangkas / Lemari', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 5, 'Dispenser', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 14, 'Meja Makan / Meja Makan Pasien', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 10, 'Kursi', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 7, 'Jam Dinding', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 17, 'Remote AC', 'buah', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00'),
(5, 24, 'Tilam', 'unit', 1, 1, 0, 'good', NULL, 1, 0, 'good', NULL, 0, '2026-06-25 14:00:00', '2026-06-28 09:00:00');
