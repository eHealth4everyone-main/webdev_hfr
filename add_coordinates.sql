ALTER TABLE hs_hospitals ADD COLUMN latitude DECIMAL(10, 8) NULL;
ALTER TABLE hs_hospitals ADD COLUMN longitude DECIMAL(10, 8) NULL;

ALTER TABLE hs_hospitals_history ADD COLUMN latitude DECIMAL(10, 8) NULL;
ALTER TABLE hs_hospitals_history ADD COLUMN longitude DECIMAL(10, 8) NULL;

-- Fix the data for one record to demonstrate functionality
UPDATE hs_hospitals_history 
SET 
    facility_name = 'Federal Medical Center, Abuja',
    latitude = 9.0765,
    longitude = 7.3986,
    state_id = 37 -- Assuming 37 is FCT from count
WHERE id = 1;

UPDATE hs_hospitals
SET 
    facility_name = 'Federal Medical Center, Abuja',
    latitude = 9.0765,
    longitude = 7.3986
WHERE id = 1;
