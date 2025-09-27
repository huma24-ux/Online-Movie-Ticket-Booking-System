-- Database Requirements (MySQL, Normalized)
-- Key Entities:
-- Users – Registered user details.
-- Movies – Movie info, trailers, description, rating.
-- Theaters – Theater details.
-- Shows – Movie show timings, linked to movies & theaters.
-- Seats / Classes – Gold, Platinum, Box with rates.
-- Bookings – Tickets purchased by users.
-- Reviews – Ratings & comments by users.
-- Admin – Credentials for managing the portal.

create database movies-ticketing-system;
use movies_ticketing_system;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE theaters (
    theater_id INT AUTO_INCREMENT PRIMARY KEY,
    theater_name VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL
);


CREATE TABLE movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    trailer_url VARCHAR(255),
    release_date DATE,
    duration INT, -- in minutes
    rating DECIMAL(2,1) DEFAULT 0
);

CREATE TABLE shows (
    show_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    theater_id INT,
    show_date DATE NOT NULL,
    show_time TIME NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE,
    FOREIGN KEY (theater_id) REFERENCES theaters(theater_id) ON DELETE CASCADE
);

CREATE TABLE seat_classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name ENUM('Gold', 'Platinum', 'Box') NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE show_rates (
    rate_id INT AUTO_INCREMENT PRIMARY KEY,
    show_id INT,
    class_id INT,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (show_id) REFERENCES shows(show_id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES seat_classes(class_id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    show_id INT,
    class_id INT,
    seats INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(show_id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES seat_classes(class_id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    movie_id INT,
    rating INT CHECK(rating BETWEEN 1 AND 5),
    comment TEXT,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);
