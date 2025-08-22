USE meeting_scheduler;

-- Create default admin
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@example.com', 'admin123', 'admin');


-- Add members
INSERT INTO members(name) VALUES
('Sanjeev Rathore'),
('Sanjeev Rajeev'),
('Sovesh Rathore'),
('Shivam Rathore'),
('Sanjay Rathore'),
('Harsh Rathore'),
('Dilbar Raj'),
('Suman Singh'),
('Sanjeevni Rathore'),
('Sanju Maurya');

-- Add availability slots
INSERT INTO availability(member_id,available_from,available_to) VALUES
(1,'13:30:00','16:30:00'),
(2,'13:00:00','16:00:00'),
(3,'14:30:00','16:30:00'),
(4,'13:30:00','16:30:00'),
(5,'13:00:00','15:30:00'),
(6,'12:30:00','15:30:00'),
(7,'13:30:00','17:30:00'),
(8,'14:30:00','16:30:00'),
(9,'13:30:00','16:30:00'),
(10,'13:30:00','16:30:00');
