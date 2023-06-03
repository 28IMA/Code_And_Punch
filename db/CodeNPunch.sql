CREATE DATABASE CodeNPunch;
USE CodeNPunch;

CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(32),
    password VARCHAR(32),
    fullname VARCHAR(50),
    email VARCHAR(100),
    phone VARCHAR(10),
    role VARCHAR(10)
);