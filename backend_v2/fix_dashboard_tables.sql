-- Add missing status_id column to tables
ALTER TABLE hs_hospitals_history ADD COLUMN status_id INT DEFAULT 1;
ALTER TABLE hs_hospitals ADD COLUMN status_id INT DEFAULT 6;

-- Create missing downloads table if it doesn't exist
CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    file_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create signature_domain_completenes table
CREATE TABLE IF NOT EXISTS signature_domain_completenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state_id VARCHAR(10),
    lga_id VARCHAR(10),
    state VARCHAR(255),
    lga VARCHAR(255),
    score INT DEFAULT 0
);

-- Pivot view for LGAs
CREATE OR REPLACE VIEW facility_status_lga_pivot AS
SELECT 
    h.state_id,
    s.name as state,
    h.lga_id,
    l.name as lga,
    SUM(CASE WHEN h.status_id = 1 THEN 1 ELSE 0 END) as New_Facility_Requested,
    SUM(CASE WHEN h.status_id = 8 THEN 1 ELSE 0 END) as Update_Requested,
    SUM(CASE WHEN h.status_id = 15 THEN 1 ELSE 0 END) as Deletion_Requested,
    SUM(CASE WHEN h.status_id = 2 THEN 1 ELSE 0 END) as Request_Verified,
    SUM(CASE WHEN h.status_id = 4 THEN 1 ELSE 0 END) as Request_Validated,
    SUM(CASE WHEN h.status_id = 6 THEN 1 ELSE 0 END) as Facility_Created,
    SUM(CASE WHEN h.status_id = 13 THEN 1 ELSE 0 END) as Facility_Updated,
    SUM(CASE WHEN h.status_id = 20 THEN 1 ELSE 0 END) as Facility_Deleted,
    SUM(CASE WHEN h.status_id = 3 THEN 1 ELSE 0 END) as Verification_Rejected,
    SUM(CASE WHEN h.status_id = 5 THEN 1 ELSE 0 END) as Validation_Rejected,
    SUM(CASE WHEN h.status_id = 7 THEN 1 ELSE 0 END) as Publishing_Rejected
FROM hs_hospitals_history h
JOIN ou_states s ON h.state_id = s.id
JOIN ou_lgas l ON h.lga_id = l.id
GROUP BY h.state_id, s.name, h.lga_id, l.name;

-- Pivot view for States
CREATE OR REPLACE VIEW facility_status_state_pivot AS
SELECT 
    h.state_id,
    s.name as name,
    SUM(CASE WHEN h.status_id = 1 THEN 1 ELSE 0 END) as New_Facility_Requested,
    SUM(CASE WHEN h.status_id = 8 THEN 1 ELSE 0 END) as Update_Requested,
    SUM(CASE WHEN h.status_id = 15 THEN 1 ELSE 0 END) as Deletion_Requested,
    SUM(CASE WHEN h.status_id = 2 THEN 1 ELSE 0 END) as Request_Verified,
    SUM(CASE WHEN h.status_id = 4 THEN 1 ELSE 0 END) as Request_Validated,
    SUM(CASE WHEN h.status_id = 6 THEN 1 ELSE 0 END) as Facility_Created,
    SUM(CASE WHEN h.status_id = 13 THEN 1 ELSE 0 END) as Facility_Updated,
    SUM(CASE WHEN h.status_id = 20 THEN 1 ELSE 0 END) as Facility_Deleted,
    SUM(CASE WHEN h.status_id = 3 THEN 1 ELSE 0 END) as Verification_Rejected,
    SUM(CASE WHEN h.status_id = 5 THEN 1 ELSE 0 END) as Validation_Rejected,
    SUM(CASE WHEN h.status_id = 7 THEN 1 ELSE 0 END) as Publishing_Rejected
FROM hs_hospitals_history h
JOIN ou_states s ON h.state_id = s.id
GROUP BY h.state_id, s.name;

-- Seed dummy data to signature_domain_completenes if empty
INSERT IGNORE INTO signature_domain_completenes (state_id, lga_id, state, lga, score)
SELECT h.state_id, h.lga_id, s.name, l.name, 75
FROM hs_hospitals_history h
JOIN ou_states s ON h.state_id = s.id
JOIN ou_lgas l ON h.lga_id = l.id
GROUP BY h.state_id, h.lga_id, s.name, l.name;
