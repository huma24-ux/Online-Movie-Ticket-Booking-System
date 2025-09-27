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
    theater_img VARCHAR(255) NOT NULL,
    location VARCHAR(150) NOT NULL,
    theater_name VARCHAR(100) NOT NULL
);


CREATE TABLE movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    trailer_url VARCHAR(255),
    release_date DATE,
    duration INT, -- in minutes
    rating DECIMAL(2,1) DEFAULT 0,
    movie_img VARCHAR(255) NOT NULL
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



INSERT INTO theaters (theater_name, location, theater_img)
VALUES 
('Cineplex Mall', 'Karachi, Pakistan', 'cineplex.jpg'),
('Star Cinema', 'Karachi, Pakistan', 'starcinema.png');


INSERT INTO movies (title, description, trailer_url, release_date, duration, rating, movie_img)
VALUES
('The Legend of Maula Jatt', 'A Pakistani action-drama film.', 'https://youtube.com/trailer1', '2022-10-13', 150, 4.5, 'maulajatt.jpg'),
('Avengers: Endgame', 'Final battle of the Avengers against Thanos.', 'https://youtube.com/trailer2', '2019-04-26', 180, 4.8, 'endgame.png'),
('Fast & Furious 10', 'High-speed action and family drama.', 'https://youtube.com/trailer3', '2023-05-19', 160, 4.2, 'fast10.jpg');



INSERT INTO shows (movie_id, theater_id, show_date, show_time)
VALUES
(1, 1, '2025-09-28', '18:00:00'),
(1, 2, '2025-09-28', '21:00:00'),
(2, 1, '2025-09-29', '19:30:00'),
(3, 2, '2025-09-29', '20:00:00');


INSERT INTO seat_classes (class_name, price)
VALUES
('Gold', 800.00),
('Platinum', 1200.00),
('Box', 2000.00);



-- Show Rates

-- (Assign rates for each show + class;
-- suppose show_id = 1 → Maula Jatt at Cineplex, etc.)


INSERT INTO show_rates (show_id, class_id, price)
VALUES
(1, 1, 800.00),   -- Gold
(1, 2, 1200.00),  -- Platinum
(1, 3, 2000.00),  -- Box

(2, 1, 700.00),
(2, 2, 1100.00),
(2, 3, 1800.00),

(3, 1, 900.00),
(3, 2, 1300.00), 
(3, 3, 2100.00),

(4, 1, 850.00),
(4, 2, 1250.00),
(4, 3, 1950.00);
