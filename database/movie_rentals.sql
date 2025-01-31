CREATE DATABASE IF NOT EXISTS movie_rental;
USE movie_rental;

-- movies tábla létrehozása
CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    release_year INT NOT NULL,
    rating FLOAT NOT NULL
);

-- rentals tábla létrehozása
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    rental_date DATE NOT NULL,
    return_date DATE NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);
