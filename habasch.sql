CREATE DATABASE habasch;

USE habasch;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  profile_image_url VARCHAR(255) NOT NULL
);
