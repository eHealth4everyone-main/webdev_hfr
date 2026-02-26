-- Seed basic data for the homepage
INSERT IGNORE INTO sliders (title, sub_title, image_url, status) VALUES 
('Welcome to HFR', 'Health Facility Registry for Nigeria', 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=2000', 1),
('Find Facilities', 'Search for hospitals and clinics near you', 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=2000', 1);

INSERT IGNORE INTO origins (id, title, content) VALUES 
(1, 'Our Origin', 'The Health Facility Registry (HFR) was established to provide a comprehensive database of health facilities in Nigeria.');

INSERT IGNORE INTO processes (id, title, content) VALUES 
(1, 'How it Works', 'Our process involves collecting, verifying, and publishing data about health facilities.');

INSERT IGNORE INTO process_items (title, status) VALUES 
('Registration', 1),
('Verification', 1),
('Validation', 1),
('Publication', 1);
