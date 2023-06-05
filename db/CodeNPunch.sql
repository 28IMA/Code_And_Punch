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
CREATE TABLE homework(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255),
    filename VARCHAR(255),
    submit INT
)