CREATE TABLE IF NOT EXISTS person (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    nickname VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS person_details (
    person_id INT UNSIGNED NOT NULL,
    street VARCHAR(150) DEFAULT NULL,
    number VARCHAR(20) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    zip_code VARCHAR(20) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    email VARCHAR(150) NOT NULL,
    phone_1 VARCHAR(30) NOT NULL,
    phone_2 VARCHAR(30) DEFAULT NULL,
    PRIMARY KEY (person_id),
    CONSTRAINT fk_person_details_person
        FOREIGN KEY (person_id)
        REFERENCES person(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_person_name ON person (first_name, last_name);
CREATE INDEX idx_details_email ON person_details (email);
CREATE INDEX idx_details_city ON person_details (city);
