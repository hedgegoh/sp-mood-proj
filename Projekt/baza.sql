CREATE DATABASE moodapp;

CREATE TABLE uporabnik (
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    username VARCHAR(50) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL
);

CREATE TABLE mood_types (
    mood_types_id INT PRIMARY KEY,
    mood_name VARCHAR(20) NOT NULL
);

INSERT INTO mood_types VALUES (1,'Jeza'),(2,'Dolgčas'),(3,'Zaljubljenost'),(4,'Sreča'),(5,'Strah'),(6,'Tesnoba'),(7,'Veselje'),(8,'Žalost');

CREATE TABLE user_mood (
    user_mood_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    mood_types_id INT NOT NULL,
    user_mood_date DATE NOT NULL,
    PRIMARY KEY (user_mood_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (mood_types_id) REFERENCES mood_types(mood_types_id)
);
