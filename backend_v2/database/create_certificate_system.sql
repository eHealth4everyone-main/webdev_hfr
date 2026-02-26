-- Create Facility Certificates Table
CREATE TABLE IF NOT EXISTS `hs_facility_certificates` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `hospital_id` INT NOT NULL,
    `certificate_no` VARCHAR(100) UNIQUE NOT NULL,
    `issue_date` DATE NOT NULL,
    `expiry_date` DATE NULL,
    `issued_by` INT NOT NULL,
    `status` ENUM('valid', 'expired', 'revoked') DEFAULT 'valid',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`hospital_id`) REFERENCES `hs_hospitals`(`id`) ON DELETE CASCADE
);

-- Add column to hospitals to store calculated level if we want to cache it, 
-- but it's better to just use the existing facility_level_id.

-- Seed some sample certificates if needed for testing (Optional)
