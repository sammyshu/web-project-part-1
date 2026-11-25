
CREATE DATABASE IF NOT EXISTS matchfit;
USE matchfit;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);
INSERT INTO users (username, password_hash) VALUES
('admin', '$2y$10$NrwbRJA8jZpK4d5neDqvn.Tab3qS5a07rtEn1GcN4RUKtBTFc3W/i'),
('manager', '$2y$10$UdKWVkZtAmy7L1u7mxhm7.PGo6rHiU1TJjPt8x0eOqhOVHEnCWwua'); --Theres no need to create new users in the project brief or anything, so I just put them all here.
