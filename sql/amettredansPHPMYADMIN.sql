CREATE DATABASE livredor;

USE livredor;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    color VARCHAR(7) DEFAULT '#000000';
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    reset_token VARCHAR(255) DEFAULT NULL;
    reset_expiry DATETIME DEFAULT NULL;
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Allez à http://localhost/phpmyadmin/ , créez une nouvelle base de donnée et copiez-coller ce code dans la rubrique SQL.
