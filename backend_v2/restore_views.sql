
-- Drop existing views to avoid conflicts
DROP VIEW IF EXISTS facility_status_lga;
DROP VIEW IF EXISTS facility_status_lga_pivot;
DROP VIEW IF EXISTS facility_status_state_pivot;
DROP VIEW IF EXISTS hospital_details;
DROP VIEW IF EXISTS hospital_details_history;
DROP VIEW IF EXISTS hospital_offered_services;
DROP VIEW IF EXISTS hospital_status_tracking;
DROP VIEW IF EXISTS hospitals_count_by_level_lga;
DROP VIEW IF EXISTS hospitals_count_by_level_lga_column;
DROP VIEW IF EXISTS hospitals_count_by_level_state;
DROP VIEW IF EXISTS hospitals_count_by_level_state_column;
DROP VIEW IF EXISTS hospitals_count_by_ownership_state;
DROP VIEW IF EXISTS hospitals_count_by_ownership_state_column;
DROP VIEW IF EXISTS imaging_count_by_ownership_lga;
DROP VIEW IF EXISTS imaging_count_by_ownership_lga_column;
DROP VIEW IF EXISTS imaging_count_by_ownership_state;
DROP VIEW IF EXISTS imaging_count_by_ownership_state_column;
DROP VIEW IF EXISTS hospitals_count_by_ownership_level_lga;
DROP VIEW IF EXISTS hospitals_count_by_ownership_level_lga_column;
DROP VIEW IF EXISTS hospitals_count_by_ownership_level_state;
DROP VIEW IF EXISTS hospitals_count_by_ownership_level_state_column;
DROP VIEW IF EXISTS hospitals_count_by_ownership_lga;
DROP VIEW IF EXISTS hospitals_count_by_ownership_lga_column;

-- Create missing lookup tables if they don't exist
CREATE TABLE IF NOT EXISTS lst_status (id INT PRIMARY KEY, status VARCHAR(255));
INSERT IGNORE INTO lst_status (id, status) VALUES 
(1, 'New Facility Requested'), (2, 'Request Verified'), (3, 'Verification Rejected'),
(4, 'Request Validated'), (5, 'Validation Rejected'), (6, 'Facility Created'),
(7, 'Publishing Rejected'), (8, 'Update Requested'), (9, 'Request Verified (Update)'),
(10, 'Verification Rejected (Update)'), (11, 'Request Validated (Update)'),
(12, 'Validation Rejected (Update)'), (13, 'Facility Updated'), (14, 'Publishing Rejected (Update)'),
(15, 'Deletion Requested'), (16, 'Request Verified (Delete)'), (17, 'Verification Rejected (Delete)'),
(18, 'Request Validated (Delete)'), (19, 'Validation Rejected (Delete)'),
(20, 'Facility Deleted'), (21, 'Publishing Rejected (Delete)');

CREATE TABLE IF NOT EXISTS lst_level_of_care (id INT PRIMARY KEY, name VARCHAR(255));
INSERT IGNORE INTO lst_level_of_care (id, name) VALUES (1, 'primary'), (2, 'secondary'), (3, 'tertiary');

CREATE TABLE IF NOT EXISTS lst_ownerships (id INT PRIMARY KEY, name VARCHAR(255));
INSERT IGNORE INTO lst_ownerships (id, name) VALUES (1, 'Public'), (2, 'Private');

-- View Creation
CREATE OR REPLACE VIEW facility_status_lga AS
SELECT
    h.state_id,
    s.name AS state,
    h.lga_id,
    l.name AS lga,
    h.status_id,
    st.status AS status,
    COUNT(*) AS count
FROM hs_hospitals_history h
JOIN ou_states s ON h.state_id = s.id
JOIN ou_lgas l ON h.lga_id = l.id
LEFT JOIN lst_status st ON h.status_id = st.id
GROUP BY h.state_id, s.name, h.lga_id, l.name, h.status_id, st.status;

CREATE OR REPLACE VIEW hospital_details AS
SELECT
    h.*,
    s.name AS state,
    l.name AS lga,
    lc.name AS facility_level,
    o.name AS ownership,
    w.name AS ward,
    '' AS phone_number,
    '' AS email_address,
    '' AS physical_location
FROM hs_hospitals_history h
LEFT JOIN ou_states s ON h.state_id = s.id
LEFT JOIN ou_lgas l ON h.lga_id = l.id
LEFT JOIN ou_wards w ON h.ward_id = w.id
LEFT JOIN lst_level_of_care lc ON h.facility_level_id = lc.id
LEFT JOIN lst_ownerships o ON h.ownership_id = o.id;

CREATE OR REPLACE VIEW hospital_details_history AS
SELECT * FROM hospital_details;

CREATE OR REPLACE VIEW hospitals_count_by_level_lga_column AS
SELECT
    l.state_id,
    s.name AS state,
    l.id AS lga_id,
    l.name AS lga,
    SUM(CASE WHEN fl.name = 'primary' THEN 1 ELSE 0 END) AS `Primary`,
    SUM(CASE WHEN fl.name = 'secondary' THEN 1 ELSE 0 END) AS `Secondary`,
    SUM(CASE WHEN fl.name = 'tertiary' THEN 1 ELSE 0 END) AS `Tertiary`
FROM hs_hospitals_history h
JOIN ou_lgas l ON h.lga_id = l.id
JOIN ou_states s ON l.state_id = s.id
LEFT JOIN lst_level_of_care fl ON h.facility_level_id = fl.id
GROUP BY l.id, l.state_id, s.name, l.name;
