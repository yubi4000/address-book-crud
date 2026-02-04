INSERT INTO person (first_name, last_name, nickname) VALUES
('Ana', 'Kovacic', 'Ani'),
('Marko', 'Petrovic', 'Maki'),
('Jelena', 'Ilic', 'Jeca');

INSERT INTO person_details (person_id, street, number, city, zip_code, country, email, phone_1, phone_2) VALUES
(1, 'Nemanjina', '12', 'Belgrade', '11000', 'Serbia', 'ana.kovacic@example.com', '061123456', ''),
(2, 'Bulevar Oslobodjenja', '45', 'Novi Sad', '21000', 'Serbia', 'marko.petrovic@example.com', '062987654', '064555444'),
(3, 'Knez Mihailova', '5', 'Belgrade', '11000', 'Serbia', 'jelena.ilic@example.com', '063222333', '');
