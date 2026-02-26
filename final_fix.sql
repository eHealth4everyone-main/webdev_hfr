-- Final fix for IDs and column names in views
CREATE OR REPLACE VIEW ou_states AS SELECT state_id AS id, state AS name FROM tbl_state;
CREATE OR REPLACE VIEW ou_lgas AS SELECT lga_id AS id, state_id, lga AS name FROM tbl_lga;
CREATE OR REPLACE VIEW ou_wards AS SELECT wd_id AS id, lga_id, ward AS name FROM tbl_ward;

-- Mapping lookup tables
CREATE OR REPLACE VIEW lst_facility_types AS SELECT ft_id AS id, ft_name AS name FROM tbl_fac_type;
CREATE OR REPLACE VIEW lst_level_of_care AS SELECT fl_id AS id, fl_name AS name FROM tbl_fac_level;

-- Main hospital views with id aliasing
CREATE OR REPLACE VIEW hospital_details AS 
SELECT hs_id AS id, h.* FROM hs_hospitals_history h;

CREATE OR REPLACE VIEW hospital_details_history AS 
SELECT hs_id AS id, h.* FROM hs_hospitals_history h;

-- Status tables
CREATE TABLE IF NOT EXISTS lst_oparational_status (id INT PRIMARY KEY, status VARCHAR(255), category VARCHAR(10) DEFAULT '1');
CREATE TABLE IF NOT EXISTS lst_registration_status (id INT PRIMARY KEY, status VARCHAR(255), category VARCHAR(10) DEFAULT '1');
CREATE TABLE IF NOT EXISTS lst_license_status (id INT PRIMARY KEY, status VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_accreditation_status (id INT PRIMARY KEY, status VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_status (id INT PRIMARY KEY, status VARCHAR(255));

-- Populate statuses
INSERT IGNORE INTO lst_oparational_status (id, status, category) VALUES (1, 'Operational', '1'), (2, 'Non-Operational', '1');
INSERT IGNORE INTO lst_registration_status (id, status, category) VALUES (1, 'Registered', '1'), (2, 'Pending', '1');
INSERT IGNORE INTO lst_license_status (id, status) VALUES (1, 'Licensed'), (2, 'Expired');
INSERT IGNORE INTO lst_accreditation_status (id, status) VALUES (1, 'Accredited'), (2, 'Not Accredited');
INSERT IGNORE INTO lst_status (id, status) VALUES (1, 'Active'), (2, 'Inactive');

-- Ensure tbl_ownership exists or bridge it
CREATE TABLE IF NOT EXISTS lst_ownerships (id INT PRIMARY KEY, name VARCHAR(255));
INSERT IGNORE INTO lst_ownerships (id, name) VALUES (1, 'Public'), (2, 'Private'), (3, 'Faith Based'), (4, 'NGO');
