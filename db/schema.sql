CREATE DATABASE IF NOT EXISTS loja_de_jogos
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE loja_de_jogos;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_id INT,
    title VARCHAR(255),
    release_date VARCHAR(50),
    price DECIMAL(10,2),
    metacritic_score INT,
    user_score FLOAT,
    developer VARCHAR(255),
    publisher VARCHAR(255),
    genre VARCHAR(255),
    head_image TEXT,
    screenshots TEXT,
    movies TEXT
);

CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    UNIQUE (user_id, game_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);
