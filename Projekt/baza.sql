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
('Vztrajaj, uspeh je tvoj polona, če si ga boš dovolil doseči. - Oprah Winfrey'),
('Uspeh ni ključ do sreče. Sreča je ključ do uspeha. Če imate radi, kar počnete, boste uspešni. - Albert Schweitzer'),
('Uspeh ni končna postaja, neuspeh pa ni usoden udarec. To je pogum, ki šteje. - Winston Churchill'),
('Uspeh je kombinacija talenta, trdega dela in vztrajnosti. - Colin Powell'),
('Najpomembnejša stvar pri komunikaciji je slišati, kaj ni bilo rečeno. - Peter Drucker'),
('Pustite, da vaša radovednost prevlada nad strahom. To je ključ do novih izkušenj in znanj." - Ellen J. Barrier'),
('Cilji so sanje z rokom trajanja. - Diana Scharf Hunt');

 CREATE TABLE diary (
     diary_id INT NOT NULL AUTO_INCREMENT,
     user_id INT NOT NULL,
     user_mood_id INT NOT NULL,
     diary TEXT NOT NULL,
     PRIMARY KEY (diary_id),
     FOREIGN KEY (user_id) REFERENCES users(user_id),
     FOREIGN KEY (user_mood_id) REFERENCES user_mood(user_mood_id));
