-- 1. Create hs_facility_certificates table
CREATE TABLE IF NOT EXISTS `hs_facility_certificates` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `hospital_id` VARCHAR(255) NOT NULL,
    `certificate_no` VARCHAR(255) UNIQUE NOT NULL,
    `issue_date` DATE NOT NULL,
    `expiry_date` DATE NOT NULL,
    `status` ENUM('Valid', 'Expired', 'Revoked') DEFAULT 'Valid',
    `issued_by` BIGINT UNSIGNED,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (hospital_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Add ambulance_services column to hospital tables (if not exists)
ALTER TABLE `hs_hospitals_history` ADD COLUMN IF NOT EXISTS `ambulance_services` VARCHAR(255) NULL AFTER `status_id`;
ALTER TABLE `hs_hospitals` ADD COLUMN IF NOT EXISTS `ambulance_services` VARCHAR(255) NULL AFTER `status_id`;

-- 3. Initial criteria for Facility Level (for reference in FacilityLevelService.php)
/*
| Level     | Criteria                                                                    |
|-----------|-----------------------------------------------------------------------------|
| Tertiary  | > 20 Doctors AND > 100 Beds AND (Surgery OR ICU OR Onsite-Imaging)          |
| Secondary | 5-20 Doctors AND 30-100 Beds AND (Maternity OR Lab OR ambulance_services)  |
| Primary   | < 5 Doctors AND < 30 Beds AND basic health services                         |
*/
