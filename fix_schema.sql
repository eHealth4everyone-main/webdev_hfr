-- Fix Missing Columns in hs_hospitals_history
ALTER TABLE hs_hospitals_history 
ADD COLUMN IF NOT EXISTS action VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS verified_id INT NULL,
ADD COLUMN IF NOT EXISTS verified_by INT NULL,
ADD COLUMN IF NOT EXISTS verified_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS verified_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS verified_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS verify_note TEXT NULL,
ADD COLUMN IF NOT EXISTS validated_id INT NULL,
ADD COLUMN IF NOT EXISTS validated_by INT NULL,
ADD COLUMN IF NOT EXISTS validated_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS validated_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS validated_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS validate_note TEXT NULL,
ADD COLUMN IF NOT EXISTS published_id INT NULL,
ADD COLUMN IF NOT EXISTS published_by INT NULL,
ADD COLUMN IF NOT EXISTS published_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS published_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS published_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS publish_note TEXT NULL;

-- Fix Missing Columns in hs_hospitals (just in case)
ALTER TABLE hs_hospitals 
ADD COLUMN IF NOT EXISTS action VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS verified_id INT NULL,
ADD COLUMN IF NOT EXISTS verified_by INT NULL,
ADD COLUMN IF NOT EXISTS verified_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS verified_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS verified_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS verify_note TEXT NULL,
ADD COLUMN IF NOT EXISTS validated_id INT NULL,
ADD COLUMN IF NOT EXISTS validated_by INT NULL,
ADD COLUMN IF NOT EXISTS validated_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS validated_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS validated_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS validate_note TEXT NULL,
ADD COLUMN IF NOT EXISTS published_id INT NULL,
ADD COLUMN IF NOT EXISTS published_by INT NULL,
ADD COLUMN IF NOT EXISTS published_email VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS published_mobile VARCHAR(20) NULL,
ADD COLUMN IF NOT EXISTS published_at DATETIME NULL,
ADD COLUMN IF NOT EXISTS publish_note TEXT NULL;

-- Create hs_status_tracking table
CREATE TABLE IF NOT EXISTS hs_status_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT NOT NULL,
    user_id INT NOT NULL,
    status_id INT NOT NULL,
    note TEXT NULL,
    created_at DATETIME NOT NULL
);

-- Create missing lookup views or tables
CREATE OR REPLACE VIEW lst_facility_types AS
SELECT ft_id AS id, ft_name AS name FROM tbl_fac_type;

-- Recreate Views from README.md / restore_views.sql
DROP VIEW IF EXISTS hospital_details;
CREATE OR REPLACE VIEW hospital_details AS SELECT * FROM hs_hospitals_history;

DROP VIEW IF EXISTS hospital_details_history;
CREATE OR REPLACE VIEW hospital_details_history AS SELECT * FROM hs_hospitals_history;

DROP VIEW IF EXISTS hospital_status_tracking;
CREATE OR REPLACE VIEW hospital_status_tracking AS
SELECT
    h.hs_id AS hospital_id,
    h.state_id,
    hs.status_id,
    h.action,
    st.status,
    hs.created_at,
    hs.note,
    hs.user_id,
    CONCAT(u.firstname, ' ', u.lastname) AS user,
    u.mobile,
    u.email,
    u.job_title
FROM hs_status_tracking hs
JOIN hs_hospitals_history h ON hs.hospital_id = h.hs_id
LEFT JOIN lst_status st ON hs.status_id = st.id
LEFT JOIN users u ON hs.user_id = u.id;

-- Ensure lookup tables are populated
INSERT IGNORE INTO lst_status (id, status) VALUES 
(1, 'New Facility Requested'), (2, 'Request Verified'), (3, 'Verification Rejected'),
(4, 'Request Validated'), (5, 'Validation Rejected'), (6, 'Facility Created'),
(7, 'Publishing Rejected'), (8, 'Update Requested'), (9, 'Request Verified (Update)'),
(10, 'Verification Rejected (Update)'), (11, 'Request Validated (Update)'),
(12, 'Validation Rejected (Update)'), (13, 'Facility Updated'), (14, 'Publishing Rejected (Update)'),
(15, 'Deletion Requested'), (16, 'Request Verified (Delete)'), (17, 'Verification Rejected (Delete)'),
(18, 'Request Validated (Delete)'), (19, 'Validation Rejected (Delete)'),
(20, 'Facility Deleted'), (21, 'Publishing Rejected (Delete)');

INSERT IGNORE INTO lst_level_of_care (id, name) VALUES (1, 'primary'), (2, 'secondary'), (3, 'tertiary');
INSERT IGNORE INTO lst_ownerships (id, name) VALUES (1, 'Public'), (2, 'Private');
