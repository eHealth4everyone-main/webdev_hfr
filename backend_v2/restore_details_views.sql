
-- Drop existing views to avoid conflicts
DROP VIEW IF EXISTS imaging_details;
DROP VIEW IF EXISTS laboratory_details;
DROP VIEW IF EXISTS pharmacy_details;
DROP VIEW IF EXISTS imaging_count_by_ownership_lga;
DROP VIEW IF EXISTS imaging_count_by_ownership_lga_column;
DROP VIEW IF EXISTS imaging_count_by_ownership_state;
DROP VIEW IF EXISTS imaging_count_by_ownership_state_column;
DROP VIEW IF EXISTS laboratory_count_by_level_lga;
DROP VIEW IF EXISTS laboratory_count_by_level_lga_column;
DROP VIEW IF EXISTS laboratory_count_by_level_state;
DROP VIEW IF EXISTS laboratory_count_by_level_state_column;
DROP VIEW IF EXISTS laboratory_count_by_ownership_lga;
DROP VIEW IF EXISTS laboratory_count_by_ownership_lga_column;
DROP VIEW IF EXISTS laboratory_count_by_ownership_state;
DROP VIEW IF EXISTS pharmacy_count_by_ownership_lga;
DROP VIEW IF EXISTS pharmacy_count_by_ownership_lga_column;
DROP VIEW IF EXISTS pharmacy_count_by_ownership_state;
DROP VIEW IF EXISTS pharmacy_count_by_ownership_state_column;
DROP VIEW IF EXISTS dhis_log_details;

-- Create lookup tables if missing
CREATE TABLE IF NOT EXISTS lst_premises_type (id INT PRIMARY KEY, name VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_accreditation_status (id INT PRIMARY KEY, status VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_outlet_category (id INT PRIMARY KEY, name VARCHAR(255));
CREATE TABLE IF NOT EXISTS lst_ownership_types (id INT PRIMARY KEY, type VARCHAR(255));

-- imaging_details
CREATE OR REPLACE VIEW imaging_details AS
SELECT
    i.id,
    i.unique_id,
    i.registration_no,
    i.radiographers_reg_number,
    i.start_date,
    i.facility_name,
    i.alt_facility_name,
    s.id AS state_id,
    s.name AS state,
    l.id AS lga_id,
    l.name AS lga,
    w.id AS ward_id,
    w.name AS ward,
    o.id AS ownership_id,
    o.name AS ownership,
    ot.id AS ownership_type_id,
    ot.type AS ownership_type,
    i.ownership_details,
    i.house_no,
    i.street_name,
    i.longitude,
    i.latitude,
    i.postal_address,
    i.phone_number,
    i.email_address,
    i.website,
    i.operational_days,
    i.operational_hours,
    ops.id AS operational_status_id,
    ops.status AS operational_status,
    rs.id AS registration_status_id,
    rs.status AS registration_status,
    ls.id AS license_status_id,
    ls.status AS license_status,
    i.radiologists,
    i.radiographers,
    i.radiography_tech,
    pt.id AS premises_type_id,
    pt.name AS premises_type,
    i.created_at,
    i.updated_at
FROM im_imagings i
LEFT JOIN ou_states s ON i.state_id = s.id
LEFT JOIN ou_lgas l ON i.lga_id = l.id
LEFT JOIN ou_wards w ON i.ward_id = w.id
LEFT JOIN lst_ownerships o ON i.ownership_id = o.id
LEFT JOIN lst_ownership_types ot ON i.ownership_type_id = ot.id
LEFT JOIN lst_oparational_status ops ON i.operational_status_id = ops.id
LEFT JOIN lst_registration_status rs ON i.registration_status_id = rs.id
LEFT JOIN lst_license_status ls ON i.license_status_id = ls.id
LEFT JOIN lst_premises_type pt ON i.premises_type_id = pt.id;

-- laboratory_details
CREATE OR REPLACE VIEW laboratory_details AS
SELECT
    lab.id,
    lab.unique_id,
    lab.registration_no,
    lab.medical_laboratory_number,
    lab.start_date,
    lab.facility_name,
    lab.alt_facility_name,
    s.id AS state_id,
    s.name AS state,
    l.id AS lga_id,
    l.name AS lga,
    w.id AS ward_id,
    w.name AS ward,
    o.id AS ownership_id,
    o.name AS ownership,
    ot.id AS ownership_type_id,
    ot.type AS ownership_type,
    lab.ownership_details,
    fl.id AS facility_level_id,
    fl.name AS facility_level,
    lab.house_no,
    lab.street_name,
    lab.longitude,
    lab.latitude,
    lab.postal_address,
    lab.phone_number,
    lab.email_address,
    lab.website,
    lab.operational_days,
    lab.operational_hours,
    os.id AS operational_status_id,
    os.status AS operation_status,
    rs.id AS registration_status_id,
    rs.status AS registration_status,
    ac.id AS accreditation_status_id,
    ac.status AS accreditation_status,
    ls.id AS license_status_id,
    ls.status AS license_status,
    lab.laboratory_scientists,
    lab.laboratory_technicians,
    lab.quality_assurance,
    pt.id AS premises_type_id,
    pt.name AS premises_type,
    lab.created_at,
    lab.updated_at
FROM lb_laboratories lab
LEFT JOIN ou_states s ON lab.state_id = s.id
LEFT JOIN ou_lgas l ON lab.lga_id = l.id
LEFT JOIN ou_wards w ON lab.ward_id = w.id
LEFT JOIN lst_ownerships o ON lab.ownership_id = o.id
LEFT JOIN lst_ownership_types ot ON lab.ownership_type_id = ot.id
LEFT JOIN lst_level_of_care fl ON lab.facility_level_id = fl.id
LEFT JOIN lst_oparational_status os ON lab.operational_status_id = os.id
LEFT JOIN lst_registration_status rs ON lab.registration_status_id = rs.id
LEFT JOIN lst_accreditation_status ac ON lab.accreditation_status_id = ac.id
LEFT JOIN lst_license_status ls ON lab.license_status_id = ls.id
LEFT JOIN lst_premises_type pt ON lab.premises_type_id = pt.id;

-- pharmacy_details
CREATE OR REPLACE VIEW pharmacy_details AS
SELECT
    p.id,
    p.unique_id,
    p.registration_no,
    p.pharmacists_reg_number,
    p.start_date,
    p.facility_name,
    p.alt_facility_name,
    s.id AS state_id,
    s.name AS state,
    l.id AS lga_id,
    l.name AS lga,
    w.id AS ward_id,
    w.name AS ward,
    o.id AS ownership_id,
    o.name AS ownership,
    ot.id AS ownership_type_id,
    ot.type AS ownership_type,
    p.ownership_details,
    p.house_no,
    p.street_name,
    p.longitude,
    p.latitude,
    p.postal_address,
    p.phone_number,
    p.email_address,
    p.website,
    p.operational_days,
    p.operational_hours,
    os.id AS operational_status_id,
    os.status AS operational_status,
    rs.id AS registration_status_id,
    rs.status AS registration_status,
    ls.id AS license_status_id,
    ls.status AS license_status,
    pt.id AS premises_type_id,
    pt.name AS premises_type,
    oc.id AS outlet_category_id,
    oc.name AS outlet_category,
    p.pharmacists,
    p.pharmacy_technicians,
    p.created_at,
    p.updated_at
FROM pharmacies p
LEFT JOIN ou_lgas l ON p.lga_id = l.id
LEFT JOIN ou_states s ON l.state_id = s.id
LEFT JOIN ou_wards w ON p.ward_id = w.id
LEFT JOIN lst_ownerships o ON p.ownership_id = o.id
LEFT JOIN lst_ownership_types ot ON p.ownership_type_id = ot.id
LEFT JOIN lst_oparational_status os ON p.operational_status_id = os.id
LEFT JOIN lst_registration_status rs ON p.registration_status_id = rs.id
LEFT JOIN lst_license_status ls ON p.license_status_id = ls.id
LEFT JOIN lst_premises_type pt ON p.premises_type_id = pt.id
LEFT JOIN lst_outlet_category oc ON p.outlet_category_id = oc.id;
