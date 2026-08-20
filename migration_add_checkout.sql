-- ============================================================
-- MIGRATION: Add Checkout & Inventory Comparison Fields
-- ============================================================

ALTER TABLE `handovers`
    ADD COLUMN `checkout_date` DATE NULL AFTER `statement_confirmed`,
    ADD COLUMN `checkout_time` TIME NULL AFTER `checkout_date`,
    ADD COLUMN `checkout_officer_name` VARCHAR(100) NULL AFTER `checkout_time`,
    ADD COLUMN `checkout_patient_rep` VARCHAR(100) NULL AFTER `checkout_officer_name`,
    ADD COLUMN `checkout_notes` TEXT NULL AFTER `checkout_patient_rep`,
    ADD COLUMN `checkout_status` ENUM('none', 'cleared', 'has_liability') NOT NULL DEFAULT 'none' AFTER `checkout_notes`,
    ADD COLUMN `checkout_officer_signature_path` VARCHAR(255) NULL AFTER `checkout_status`,
    ADD COLUMN `checkout_patient_signature_path` VARCHAR(255) NULL AFTER `checkout_officer_signature_path`,
    ADD COLUMN `checkout_completed_at` DATETIME NULL AFTER `checkout_patient_signature_path`;

ALTER TABLE `handover_inventory_items`
    ADD COLUMN `checkout_actual_qty` INT NULL AFTER `notes`,
    ADD COLUMN `checkout_difference_qty` INT NULL AFTER `checkout_actual_qty`,
    ADD COLUMN `checkout_condition` ENUM('good', 'damaged', 'need_repair', 'shortage', 'not_available') NULL AFTER `checkout_difference_qty`,
    ADD COLUMN `checkout_notes` TEXT NULL AFTER `checkout_condition`,
    ADD COLUMN `is_liability` TINYINT(1) NOT NULL DEFAULT 0 AFTER `checkout_notes`;
