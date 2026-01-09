CREATE database fan_seat;

use fan_seat;

create table users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'organizer', 'admin') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    status TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id INT NOT NULL,
    team1_name VARCHAR(100) NOT NULL,
    team1_short VARCHAR(10),
    team1_logo VARCHAR(255) NOT NULL,
    team2_name VARCHAR(100) NOT NULL,
    team2_short VARCHAR(10),
    team2_logo VARCHAR(255) NOT NULL,
    match_datetime DATETIME NOT NULL,
    duration INT DEFAULT 90,
    stadium_name VARCHAR(150) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    total_places INT NOT NULL,
    status ENUM(
        'pending',
        'approved',
        'rejected',
        'completed'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users (id)
);

CREATE TABLE match_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255),
    price DECIMAL(8, 2) NOT NULL,
    total_places INT NOT NULL,
    FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE
);

create table tickete (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    user_id INT NOT NULL,
    ticket_code VARCHAR(50) UNIQUE NOT NULL,
    pdf_path VARCHAR(255),
    FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

SELECT t.*, m.*, mg.*
FROM
    tickets t
    inner join matches m on m.id = t.match_id
    inner join match_categories mg on mg.id = t.cetrgorie_id;


SELECT * FROM matches where organizer_id = 35