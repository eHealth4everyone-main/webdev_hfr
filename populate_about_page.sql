-- Populate origins table (without timestamps)
INSERT INTO origins (title, content) VALUES 
('The Origin', '<p>The Nigeria Health Facility Registry (HFR) was developed in 2017 as part of effort to dynamically manage the Master Health Facility List (MFL) in the country.</p><p>The MFL is a complete listing of health facilities in a country (both public and private) and is comprised of a set of identification items for each facility (signature domain) and basic information on the service capacity of each facility (service domain).</p>');

-- Populate processes table (without timestamps)
INSERT INTO processes (title, content) VALUES 
('The Process', '<p>The development of the HFR followed a consultative process among the different stakeholders working within the Federal Ministry of Health, its agencies and development partners.</p>');

-- Populate process_items table (without timestamps)
INSERT INTO process_items (title) VALUES 
('Stakeholder Consultation'),
('System Design & Development'),
('Data Collection & Verification'),
('Launch & Dissemination');
