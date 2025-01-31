-- dockerből automatikusan meghívódik ez a fájl, így az első betöltéskor létrehozza és fel is tölti a táblákat
CREATE DATABASE IF NOT EXISTS movie_rental;
USE movie_rental;

-- movies
-- movies table
CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    release_year INT NOT NULL,
    rating FLOAT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- rentals table
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    rental_date DATE NOT NULL,
    return_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);


-- Tesztadatok hozzáadása
INSERT INTO movies (title, genre, release_year, rating) VALUES
('Star Wars', 'Fantasy', 2000, 7.5),
('The Hateful Eight', 'Comedy', 1987, 7.8),
('Gladiator', 'Thriller', 2004, 8.2),
('Django Unchained', 'Sci-Fi', 2012, 7.5),
('The Revenant', 'Crime', 1997, 6.0),
('Coco', 'Adventure', 2009, 7.4),
('Harry Potter', 'Animation', 1996, 9.2),
('The Grand Budapest Hotel', 'Comedy', 2002, 7.3),
('Avatar', 'Romance', 1998, 6.1),
('Coco', 'Thriller', 1994, 7.7),
('Joker', 'Adventure', 2024, 6.6),
('The Flash', 'Drama', 1986, 8.4),
('Titanic', 'Action', 1995, 8.1),
('Star Wars', 'Animation', 1999, 8.6),
('Star Wars', 'Drama', 2011, 8.7),
('Django Unchained', 'Romance', 2014, 6.7),
('The Matrix', 'Animation', 2022, 6.5),
('Toy Story', 'Action', 1988, 6.4),
('Monsters Inc.', 'Crime', 2019, 6.7),
('The Incredibles', 'Drama', 2001, 7.2),
('Memento', 'Crime', 1991, 8.5),
('Deadpool', 'Romance', 1989, 6.5),
('The Dark Knight', 'Thriller', 1986, 6.5),
('Finding Nemo', 'Drama', 1981, 8.2),
('The Lord of the Rings', 'Adventure', 1980, 8.5),
('Iron Man', 'Action', 1983, 8.5),
('The Incredibles', 'Drama', 1980, 6.8),
('The Matrix', 'Thriller', 1996, 7.0),
('Captain America', 'Thriller', 2000, 8.6),
('The Incredibles', 'Comedy', 1987, 9.0),
('Fight Club', 'Fantasy', 1992, 8.0),
('Harry Potter', 'Fantasy', 2006, 6.1),
('Mad Max: Fury Road', 'Sci-Fi', 2001, 8.3),
('The Flash', 'Adventure', 2015, 6.2),
('Black Panther', 'Comedy', 2019, 8.7),
('The Hateful Eight', 'Comedy', 1997, 7.1),
('The Revenant', 'Fantasy', 1999, 6.4),
('Doctor Strange', 'Thriller', 2003, 7.2),
('Doctor Strange', 'Adventure', 2012, 8.5),
('The Social Network', 'Sci-Fi', 2017, 8.8),
('The Revenant', 'Animation', 1998, 7.1),
('The Revenant', 'Thriller', 2016, 7.6),
('No Country for Old Men', 'Animation', 2011, 9.5),
('Logan', 'Thriller', 1984, 8.2),
('The Avengers', 'Drama', 2004, 8.7),
('Mad Max: Fury Road', 'Fantasy', 2011, 7.6),
('Joker', 'Thriller', 1995, 6.4),
('Black Panther', 'Romance', 2010, 8.8),
('The Prestige', 'Fantasy', 2004, 7.9),
('Mad Max: Fury Road', 'Adventure', 1997, 6.0),
('Logan', 'Drama', 1984, 8.8),
('The Grand Budapest Hotel', 'Thriller', 2017, 8.8),
('Star Wars', 'Crime', 2019, 9.1),
('Avatar', 'Adventure', 2002, 6.8),
('Captain America', 'Drama', 1985, 6.2),
('The Godfather', 'Sci-Fi', 2010, 9.1),
('La La Land', 'Thriller', 2017, 7.2),
('The Departed', 'Action', 1993, 6.7),
('The Avengers', 'Adventure', 2024, 7.6),
('Blade Runner 2049', 'Adventure', 1990, 7.1);


INSERT INTO rentals (movie_id, customer_name, rental_date, return_date) VALUES
(1, 'John Doe', '2024-02-01', NULL),
(2, 'Jane Smith', '2024-02-02', '2024-02-10');
