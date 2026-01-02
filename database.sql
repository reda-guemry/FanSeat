
CREATE database fan_seat ;

use fan_seat ;


create table users (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    first_name VARCHAR(100) NOT NULL ,
    last_name VARCHAR(100) NOT NULL , 
    email VARCHAR (100) NOT NULL ,
    password VARCHAR(255) NOT NULL ,
    role ENUM('user', 'organizer', 'admin') NOT NULL ,
    phone VARCHAR(20) NOT NULL ,
    status TINYINT UNSIGNED NOT NULL DEFAULT 1 ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
) ;

CREATE TABLE macthes (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    organizateur_id INT NOT NULL ,
    team1_name VARCHAR(100) NOT NULL , 
    team1_logo VARCHAR(255) NOT NULL ,
    team2_name VARCHAR(100) NOT NULL , 
    team2_logo VARCHAR(255) NOT NULL ,
    match_date DATETIME NOT NULL , 
    status ENUM('pending', 'published', 'rejected', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    FOREIGN KEY (organizateur_id) REFERENCES users(id) ON DELETE CASCADE 
) ;

