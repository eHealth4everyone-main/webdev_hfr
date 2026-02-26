-- Drop existing views
DROP VIEW IF EXISTS hospital_details;
DROP VIEW IF EXISTS hospital_details_history;

-- Recreate hospital_details view with all necessary joined columns
CREATE OR REPLACE VIEW hospital_details AS
SELECT
    h.*,
    s.name AS state,
    l.name AS lga,
    lc.name AS facility_level,
    o.name AS ownership
FROM hs_hospitals_history h
LEFT JOIN ou_states s ON h.state_id = s.id
LEFT JOIN ou_lgas l ON h.lga_id = l.id
LEFT JOIN lst_level_of_care lc ON h.facility_level_id = lc.id
LEFT JOIN lst_ownerships o ON h.ownership_id = o.id;

-- Create hospital_details_history as an alias
CREATE OR REPLACE VIEW hospital_details_history AS
SELECT * FROM hospital_details;
