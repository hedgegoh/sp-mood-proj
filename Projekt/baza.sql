CREATE DATABASE moodapp;

use moodapp;

CREATE TABLE users (
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
    mood_types_color TEXT NOT NULL, 
    user_mood_date DATE NOT NULL,
    PRIMARY KEY (user_mood_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (mood_types_id) REFERENCES mood_types(mood_types_id)
);

CREATE TABLE daily_quotes (
    quote_id INT NOT NULL AUTO_INCREMENT,
    quote TEXT NOT NULL, 
    PRIMARY KEY (quote_id)); 

INSERT INTO daily_quotes (quote) VALUES 
('Lajf je borba.'),
('Pot do uspeha ni enostavna, toda vredna je truda.'),
('If you cannot make it good, at least make it look good. - Bill Gates'),
('Uspeh je kombinacija talenta, trdega dela in vztrajnosti. - Colin Powell'),
('You miss 100% of the shots you do not take." - Wayne Gretzky'),
('I have not failed. I have just found 10,000 ways that will not work." - Thomas Edison'),
('If at first, you do not succeed, then skydiving is not for you.'),
('Cilji so sanje z rokom trajanja. - Diana Scharf Hunt');

 CREATE TABLE diary (
     diary_id INT NOT NULL AUTO_INCREMENT,
     user_id INT NOT NULL,
     user_mood_id INT NOT NULL,
     diary TEXT NOT NULL,
     PRIMARY KEY (diary_id),
     FOREIGN KEY (user_id) REFERENCES users(user_id),
     FOREIGN KEY (user_mood_id) REFERENCES user_mood(user_mood_id));
