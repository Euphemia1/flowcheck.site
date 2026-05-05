-- ============================================================
-- FlowCheck.ai - Complete Database Schema
-- Generated from Laravel migrations
-- Import this file in phpMyAdmin to create all tables
-- ============================================================

CREATE DATABASE IF NOT EXISTS `flowcheck`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `flowcheck`;

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. plans
-- ============================================================
CREATE TABLE IF NOT EXISTS `plans` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `price_monthly` DECIMAL(10,2) DEFAULT NULL,
  `max_users` INT DEFAULT NULL,
  `max_vendors` INT DEFAULT NULL,
  `features` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. organisations
-- ============================================================
CREATE TABLE IF NOT EXISTS `organisations` (
  `id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `plan_id` BIGINT UNSIGNED NOT NULL,
  `industry` ENUM('mining','construction','manufacturing','other') NOT NULL DEFAULT 'other',
  `country` VARCHAR(2) NOT NULL DEFAULT 'ZM',
  `currency` VARCHAR(3) NOT NULL DEFAULT 'ZMW',
  `settings` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisations_slug_unique` (`slug`),
  KEY `organisations_plan_id_foreign` (`plan_id`),
  CONSTRAINT `organisations_plan_id_foreign`
    FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. users
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  `mfa_secret` VARCHAR(255) DEFAULT NULL,
  `mfa_enabled` TINYINT(1) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_organisation_id_foreign` (`organisation_id`),
  CONSTRAINT `users_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. departments
-- ============================================================
CREATE TABLE IF NOT EXISTS `departments` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `budget_allocated` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `budget_used` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `manager_id` CHAR(36) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_organisation_id_foreign` (`organisation_id`),
  KEY `departments_manager_id_foreign` (`manager_id`),
  CONSTRAINT `departments_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `departments_manager_id_foreign`
    FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. vendors
-- ============================================================
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `contact_person` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(255) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `tax_pin` VARCHAR(255) DEFAULT NULL,
  `payment_terms` VARCHAR(255) DEFAULT NULL,
  `bank_details` JSON DEFAULT NULL,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 0,
  `performance_score` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendors_organisation_id_foreign` (`organisation_id`),
  CONSTRAINT `vendors_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. purchase_requests
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_requests` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `department_id` CHAR(36) DEFAULT NULL,
  `requested_by` CHAR(36) NOT NULL,
  `pr_number` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `justification` TEXT DEFAULT NULL,
  `status` ENUM('draft','submitted','under_review','approved','rejected','cancelled','converted_to_po') NOT NULL DEFAULT 'draft',
  `priority` ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  `required_by_date` DATE DEFAULT NULL,
  `total_estimated_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `current_approver_id` CHAR(36) DEFAULT NULL,
  `approval_step` INT NOT NULL DEFAULT 0,
  `attachments` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_requests_pr_number_unique` (`pr_number`),
  KEY `purchase_requests_organisation_id_foreign` (`organisation_id`),
  KEY `purchase_requests_department_id_foreign` (`department_id`),
  KEY `purchase_requests_requested_by_foreign` (`requested_by`),
  KEY `purchase_requests_current_approver_id_foreign` (`current_approver_id`),
  CONSTRAINT `purchase_requests_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_requests_department_id_foreign`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `purchase_requests_requested_by_foreign`
    FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_requests_current_approver_id_foreign`
    FOREIGN KEY (`current_approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. purchase_request_items
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_request_items` (
  `id` CHAR(36) NOT NULL,
  `purchase_request_id` CHAR(36) NOT NULL,
  `description` TEXT NOT NULL,
  `unit_of_measure` VARCHAR(255) NOT NULL,
  `quantity_requested` DECIMAL(15,2) NOT NULL,
  `unit_price_estimated` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `total_estimated` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `category` VARCHAR(255) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_request_items_pr_id_foreign` (`purchase_request_id`),
  CONSTRAINT `purchase_request_items_pr_id_foreign`
    FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. approval_workflows
-- ============================================================
CREATE TABLE IF NOT EXISTS `approval_workflows` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `department_id` CHAR(36) DEFAULT NULL,
  `min_amount` DECIMAL(15,2) DEFAULT NULL,
  `max_amount` DECIMAL(15,2) DEFAULT NULL,
  `steps` JSON NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approval_workflows_organisation_id_foreign` (`organisation_id`),
  KEY `approval_workflows_department_id_foreign` (`department_id`),
  CONSTRAINT `approval_workflows_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `approval_workflows_department_id_foreign`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. approval_logs
-- ============================================================
CREATE TABLE IF NOT EXISTS `approval_logs` (
  `id` CHAR(36) NOT NULL,
  `purchase_request_id` CHAR(36) NOT NULL,
  `step_number` INT NOT NULL,
  `approver_id` CHAR(36) NOT NULL,
  `action` ENUM('approved','rejected','returned','delegated') NOT NULL,
  `comments` TEXT DEFAULT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `approval_logs_pr_id_foreign` (`purchase_request_id`),
  KEY `approval_logs_approver_id_foreign` (`approver_id`),
  CONSTRAINT `approval_logs_pr_id_foreign`
    FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `approval_logs_approver_id_foreign`
    FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 10. rfqs
-- ============================================================
CREATE TABLE IF NOT EXISTS `rfqs` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `purchase_request_id` CHAR(36) DEFAULT NULL,
  `rfq_number` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `deadline` DATETIME NOT NULL,
  `status` ENUM('draft','sent','closed','awarded') NOT NULL DEFAULT 'draft',
  `created_by` CHAR(36) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rfqs_rfq_number_unique` (`rfq_number`),
  KEY `rfqs_organisation_id_foreign` (`organisation_id`),
  KEY `rfqs_purchase_request_id_foreign` (`purchase_request_id`),
  KEY `rfqs_created_by_foreign` (`created_by`),
  CONSTRAINT `rfqs_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rfqs_purchase_request_id_foreign`
    FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rfqs_created_by_foreign`
    FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 11. rfq_vendors (pivot)
-- ============================================================
CREATE TABLE IF NOT EXISTS `rfq_vendors` (
  `rfq_id` CHAR(36) NOT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `sent_at` TIMESTAMP NULL DEFAULT NULL,
  `responded_at` TIMESTAMP NULL DEFAULT NULL,
  `response_file_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`rfq_id`, `vendor_id`),
  KEY `rfq_vendors_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `rfq_vendors_rfq_id_foreign`
    FOREIGN KEY (`rfq_id`) REFERENCES `rfqs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rfq_vendors_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 12. vendor_quotes
-- ============================================================
CREATE TABLE IF NOT EXISTS `vendor_quotes` (
  `id` CHAR(36) NOT NULL,
  `rfq_id` CHAR(36) NOT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `total_amount` DECIMAL(15,2) NOT NULL,
  `line_items` JSON DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `validity_date` DATE DEFAULT NULL,
  `is_awarded` TINYINT(1) NOT NULL DEFAULT 0,
  `awarded_by` CHAR(36) DEFAULT NULL,
  `awarded_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_quotes_rfq_id_foreign` (`rfq_id`),
  KEY `vendor_quotes_vendor_id_foreign` (`vendor_id`),
  KEY `vendor_quotes_awarded_by_foreign` (`awarded_by`),
  CONSTRAINT `vendor_quotes_rfq_id_foreign`
    FOREIGN KEY (`rfq_id`) REFERENCES `rfqs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendor_quotes_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendor_quotes_awarded_by_foreign`
    FOREIGN KEY (`awarded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 13. purchase_orders
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `purchase_request_id` CHAR(36) DEFAULT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `po_number` VARCHAR(255) NOT NULL,
  `status` ENUM('draft','sent','acknowledged','partially_received','received','closed','cancelled') NOT NULL DEFAULT 'draft',
  `payment_terms` VARCHAR(255) DEFAULT NULL,
  `delivery_address` TEXT DEFAULT NULL,
  `expected_delivery_date` DATE DEFAULT NULL,
  `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `approved_by` CHAR(36) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  KEY `purchase_orders_organisation_id_foreign` (`organisation_id`),
  KEY `purchase_orders_purchase_request_id_foreign` (`purchase_request_id`),
  KEY `purchase_orders_vendor_id_foreign` (`vendor_id`),
  KEY `purchase_orders_approved_by_foreign` (`approved_by`),
  CONSTRAINT `purchase_orders_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_orders_purchase_request_id_foreign`
    FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE SET NULL,
  CONSTRAINT `purchase_orders_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_orders_approved_by_foreign`
    FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 14. purchase_order_items
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_order_items` (
  `id` CHAR(36) NOT NULL,
  `purchase_order_id` CHAR(36) NOT NULL,
  `description` TEXT NOT NULL,
  `unit_of_measure` VARCHAR(255) NOT NULL,
  `quantity_ordered` DECIMAL(15,2) NOT NULL,
  `unit_price` DECIMAL(15,2) NOT NULL,
  `total` DECIMAL(15,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_items_po_id_foreign` (`purchase_order_id`),
  CONSTRAINT `purchase_order_items_po_id_foreign`
    FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 15. goods_receipt_notes
-- ============================================================
CREATE TABLE IF NOT EXISTS `goods_receipt_notes` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `purchase_order_id` CHAR(36) NOT NULL,
  `grn_number` VARCHAR(255) NOT NULL,
  `received_by` CHAR(36) NOT NULL,
  `received_at` DATETIME NOT NULL,
  `status` ENUM('draft','complete','partial') NOT NULL DEFAULT 'draft',
  `notes` TEXT DEFAULT NULL,
  `attachments` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_receipt_notes_grn_number_unique` (`grn_number`),
  KEY `grn_organisation_id_foreign` (`organisation_id`),
  KEY `grn_purchase_order_id_foreign` (`purchase_order_id`),
  KEY `grn_received_by_foreign` (`received_by`),
  CONSTRAINT `grn_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grn_purchase_order_id_foreign`
    FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grn_received_by_foreign`
    FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 16. grn_items
-- ============================================================
CREATE TABLE IF NOT EXISTS `grn_items` (
  `id` CHAR(36) NOT NULL,
  `grn_id` CHAR(36) NOT NULL,
  `po_item_id` CHAR(36) NOT NULL,
  `quantity_received` DECIMAL(15,2) NOT NULL,
  `condition` ENUM('good','damaged','rejected') NOT NULL DEFAULT 'good',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grn_items_grn_id_foreign` (`grn_id`),
  KEY `grn_items_po_item_id_foreign` (`po_item_id`),
  CONSTRAINT `grn_items_grn_id_foreign`
    FOREIGN KEY (`grn_id`) REFERENCES `goods_receipt_notes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grn_items_po_item_id_foreign`
    FOREIGN KEY (`po_item_id`) REFERENCES `purchase_order_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 17. invoices
-- ============================================================
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `purchase_order_id` CHAR(36) DEFAULT NULL,
  `invoice_number` VARCHAR(255) DEFAULT NULL,
  `internal_invoice_number` VARCHAR(255) NOT NULL,
  `invoice_date` DATE DEFAULT NULL,
  `due_date` DATE DEFAULT NULL,
  `total_amount` DECIMAL(15,2) NOT NULL,
  `status` ENUM('received','pending_matching','matched','discrepancy','approved_for_payment','paid','disputed') NOT NULL DEFAULT 'received',
  `matching_status` ENUM('unmatched','partial','matched','failed') NOT NULL DEFAULT 'unmatched',
  `file_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_internal_invoice_number_unique` (`internal_invoice_number`),
  KEY `invoices_organisation_id_foreign` (`organisation_id`),
  KEY `invoices_vendor_id_foreign` (`vendor_id`),
  KEY `invoices_purchase_order_id_foreign` (`purchase_order_id`),
  CONSTRAINT `invoices_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_purchase_order_id_foreign`
    FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 18. invoice_matching_results
-- ============================================================
CREATE TABLE IF NOT EXISTS `invoice_matching_results` (
  `id` CHAR(36) NOT NULL,
  `invoice_id` CHAR(36) NOT NULL,
  `po_id` CHAR(36) DEFAULT NULL,
  `grn_id` CHAR(36) DEFAULT NULL,
  `qty_invoiced` DECIMAL(15,2) NOT NULL,
  `qty_ordered` DECIMAL(15,2) DEFAULT NULL,
  `qty_received` DECIMAL(15,2) DEFAULT NULL,
  `price_invoiced` DECIMAL(15,2) NOT NULL,
  `price_po` DECIMAL(15,2) DEFAULT NULL,
  `qty_match` TINYINT(1) NOT NULL DEFAULT 0,
  `price_match` TINYINT(1) NOT NULL DEFAULT 0,
  `notes` TEXT DEFAULT NULL,
  `checked_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `imr_invoice_id_foreign` (`invoice_id`),
  KEY `imr_po_id_foreign` (`po_id`),
  KEY `imr_grn_id_foreign` (`grn_id`),
  CONSTRAINT `imr_invoice_id_foreign`
    FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `imr_po_id_foreign`
    FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `imr_grn_id_foreign`
    FOREIGN KEY (`grn_id`) REFERENCES `goods_receipt_notes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 19. contracts
-- ============================================================
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `contract_number` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('fixed_price','rate_contract','framework') NOT NULL DEFAULT 'fixed_price',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `value` DECIMAL(15,2) DEFAULT NULL,
  `status` ENUM('draft','active','expiring_soon','expired','terminated') NOT NULL DEFAULT 'draft',
  `document_path` VARCHAR(255) DEFAULT NULL,
  `created_by` CHAR(36) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contracts_contract_number_unique` (`contract_number`),
  KEY `contracts_organisation_id_foreign` (`organisation_id`),
  KEY `contracts_vendor_id_foreign` (`vendor_id`),
  KEY `contracts_created_by_foreign` (`created_by`),
  CONSTRAINT `contracts_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contracts_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contracts_created_by_foreign`
    FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 20. boqs (Bills of Quantities)
-- ============================================================
CREATE TABLE IF NOT EXISTS `boqs` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `project_name` VARCHAR(255) NOT NULL,
  `boq_number` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `total_estimated_value` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('draft','approved','tendered','awarded') NOT NULL DEFAULT 'draft',
  `created_by` CHAR(36) NOT NULL,
  `attachments` JSON DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `boqs_boq_number_unique` (`boq_number`),
  KEY `boqs_organisation_id_foreign` (`organisation_id`),
  KEY `boqs_created_by_foreign` (`created_by`),
  CONSTRAINT `boqs_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `boqs_created_by_foreign`
    FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 21. boq_items
-- ============================================================
CREATE TABLE IF NOT EXISTS `boq_items` (
  `id` CHAR(36) NOT NULL,
  `boq_id` CHAR(36) NOT NULL,
  `item_code` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `unit` VARCHAR(255) NOT NULL,
  `quantity` DECIMAL(15,2) NOT NULL,
  `unit_rate` DECIMAL(15,2) NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boq_items_boq_id_foreign` (`boq_id`),
  CONSTRAINT `boq_items_boq_id_foreign`
    FOREIGN KEY (`boq_id`) REFERENCES `boqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 22. tenders
-- ============================================================
CREATE TABLE IF NOT EXISTS `tenders` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `boq_id` CHAR(36) DEFAULT NULL,
  `tender_number` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('open','restricted','direct') NOT NULL DEFAULT 'open',
  `publication_date` DATE DEFAULT NULL,
  `closing_date` DATE NOT NULL,
  `status` ENUM('draft','published','closed','evaluated','awarded') NOT NULL DEFAULT 'draft',
  `created_by` CHAR(36) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenders_tender_number_unique` (`tender_number`),
  KEY `tenders_organisation_id_foreign` (`organisation_id`),
  KEY `tenders_boq_id_foreign` (`boq_id`),
  KEY `tenders_created_by_foreign` (`created_by`),
  CONSTRAINT `tenders_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tenders_boq_id_foreign`
    FOREIGN KEY (`boq_id`) REFERENCES `boqs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tenders_created_by_foreign`
    FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 23. tender_submissions
-- ============================================================
CREATE TABLE IF NOT EXISTS `tender_submissions` (
  `id` CHAR(36) NOT NULL,
  `tender_id` CHAR(36) NOT NULL,
  `vendor_id` CHAR(36) NOT NULL,
  `submitted_at` TIMESTAMP NOT NULL,
  `technical_score` DECIMAL(5,2) DEFAULT NULL,
  `financial_score` DECIMAL(5,2) DEFAULT NULL,
  `total_score` DECIMAL(5,2) DEFAULT NULL,
  `document_paths` JSON DEFAULT NULL,
  `is_awarded` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tender_submissions_tender_id_foreign` (`tender_id`),
  KEY `tender_submissions_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `tender_submissions_tender_id_foreign`
    FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tender_submissions_vendor_id_foreign`
    FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 24. audit_logs
-- ============================================================
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `user_id` CHAR(36) DEFAULT NULL,
  `action` VARCHAR(255) NOT NULL,
  `model_type` VARCHAR(255) DEFAULT NULL,
  `model_id` CHAR(36) DEFAULT NULL,
  `old_values` JSON DEFAULT NULL,
  `new_values` JSON DEFAULT NULL,
  `ip_address` VARCHAR(255) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audit_logs_organisation_id_foreign` (`organisation_id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_created_at_index` (`created_at`),
  KEY `audit_logs_model_type_index` (`model_type`),
  CONSTRAINT `audit_logs_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `audit_logs_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 25. budget_lines
-- ============================================================
CREATE TABLE IF NOT EXISTS `budget_lines` (
  `id` CHAR(36) NOT NULL,
  `organisation_id` CHAR(36) NOT NULL,
  `department_id` CHAR(36) NOT NULL,
  `fiscal_year` VARCHAR(255) NOT NULL,
  `category` VARCHAR(255) NOT NULL,
  `allocated_amount` DECIMAL(15,2) NOT NULL,
  `committed_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `spent_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budget_lines_organisation_id_foreign` (`organisation_id`),
  KEY `budget_lines_department_id_foreign` (`department_id`),
  CONSTRAINT `budget_lines_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `budget_lines_department_id_foreign`
    FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 26. document_sequences
-- ============================================================
CREATE TABLE IF NOT EXISTS `document_sequences` (
  `organisation_id` CHAR(36) NOT NULL,
  `pr_sequence` INT NOT NULL DEFAULT 1,
  `po_sequence` INT NOT NULL DEFAULT 1,
  `rfq_sequence` INT NOT NULL DEFAULT 1,
  `grn_sequence` INT NOT NULL DEFAULT 1,
  `invoice_sequence` INT NOT NULL DEFAULT 1,
  `boq_sequence` INT NOT NULL DEFAULT 1,
  `tender_sequence` INT NOT NULL DEFAULT 1,
  `contract_sequence` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`organisation_id`),
  CONSTRAINT `document_sequences_organisation_id_foreign`
    FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Spatie Laravel Permission tables (required by the app)
-- ============================================================
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `guard_name` VARCHAR(255) NOT NULL DEFAULT 'web',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `guard_name` VARCHAR(255) NOT NULL DEFAULT 'web',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `model_type` VARCHAR(255) NOT NULL,
  `model_id` CHAR(36) NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`, `model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign`
    FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` BIGINT UNSIGNED NOT NULL,
  `model_type` VARCHAR(255) NOT NULL,
  `model_id` CHAR(36) NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`, `model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign`
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` BIGINT UNSIGNED NOT NULL,
  `role_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign`
    FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign`
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Standard Laravel tables
-- ============================================================
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` CHAR(36) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- Done! 26 app tables + permissions + Laravel system tables
-- ============================================================
