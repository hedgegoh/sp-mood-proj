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

INSERT INTO mood_types VALUES (1,'Bes'),(2,'Jeza'),(3,'Depresivnost'),(4,'Dolgčas'),(5,'Dvom'),(6,'Frustracija'),(7,'Negotovost'),(8,'Moč'),(9,'Krivda'),(10,'Zaljubljenost'),(11,'Nezadovoljstvo'),(12,'Nepotrpežljivost'),(13,'Sram'),(14,'Sreča'),(15,'Stiska'),(16,'Strah'),(17,'Strast'),(18,'Tesnoba'),(19,'Upanje'),(20,'Umirjenost'),(21,'Užaljenost'),(22,'Veselje'),(23,'Zadovoljstvo'),(24,'Žalost'),(25,'Obup'),(26,'Pogum'),(27,'Samozavest'),(28,'Sovraštvo'),(29,'Razočaranje'),(30,'Sproščenost');

CREATE TABLE user_mood (
    user_mood_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    mood_types_id INT NOT NULL,
    user_mood_date DATE NOT NULL,
    PRIMARY KEY (user_mood_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (mood_types_id) REFERENCES mood_types(mood_types_id)
);
