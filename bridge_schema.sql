-- Create bridging views for naming consistency
CREATE OR REPLACE VIEW ou_states AS SELECT state_id AS id, state AS name FROM tbl_state;
CREATE OR REPLACE VIEW ou_lgas AS SELECT lga_id AS id, state_id, lga AS name FROM tbl_lga;
CREATE OR REPLACE VIEW ou_wards AS SELECT wd_id AS id, lga_id, ward AS name FROM tbl_ward;

-- Mapping lookup tables
CREATE OR REPLACE VIEW lst_facility_types AS SELECT ft_id AS id, ft_name AS name FROM tbl_fac_type;
CREATE OR REPLACE VIEW lst_level_of_care AS SELECT fl_id AS id, fl_name AS name FROM tbl_fac_level;

-- Create missing lookup tables instead of views if naming is inconsistent
CREATE TABLE IF NOT EXISTS lst_ownerships (id INT PRIMARY KEY, name VARCHAR(255));
INSERT IGNORE INTO lst_ownerships (id, name) VALUES (1, 'Public'), (2, 'Private'), (3, 'Faith Based'), (4, 'NGO');

-- Mapping statuses (dummy if missing)
CREATE TABLE IF NOT EXISTS lst_oparational_status (id INT PRIMARY KEY, status VARCHAR(255), category VARCHAR(10) DEFAULT '1');
CREATE TABLE IF NOT EXISTS lst_registration_status (id INT PRIMARY KEY, status VARCHAR(255), category VARCHAR(10) DEFAULT '1');
CREATE TABLE IF NOT EXISTS lst_license_status (id INT PRIMARY KEY, status VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_accreditation_status (id INT PRIMARY KEY, status VARCHAR(255));

-- Other tables used in searchHospitals3
CREATE TABLE IF NOT EXISTS lst_status (id INT PRIMARY KEY, status VARCHAR(255));

-- Create dummy data for statuses if empty
INSERT IGNORE INTO lst_oparational_status (id, status) VALUES (1, 'Operational'), (2, 'Non-Operational');
INSERT IGNORE INTO lst_registration_status (id, status) VALUES (1, 'Registered'), (2, 'Pending');
INSERT IGNORE INTO lst_license_status (id, status) VALUES (1, 'Licensed'), (2, 'Expired');
INSERT IGNORE INTO lst_accreditation_status (id, status) VALUES (1, 'Accredited'), (2, 'Not Accredited');
