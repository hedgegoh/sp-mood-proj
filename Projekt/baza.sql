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
    FOREIGN KEY (user_id) REFERENCES uporabnik(user_id),
    FOREIGN KEY (mood_types_id) REFERENCES mood_types(mood_types_id)
);

CREATE TABLE daily_quotes (
    quote_id INT NOT NULL AUTO_INCREMENT,
    quote TEXT NOT NULL, 
    PRIMARY KEY (quote_id)); 

INSERT INTO daily_quotes (quote) VALUES 
('Vztrajaj, uspeh je tvoj, če si ga boš dovolil doseči. - Oprah Winfrey'),
('Uspeh ni ključ do sreče. Sreča je ključ do uspeha. Če imate radi, kar počnete, boste uspešni. - Albert Schweitzer'),
('Uspeh ni končna postaja, neuspeh pa ni usoden udarec. To je pogum, ki šteje. - Winston Churchill'),
('Uspeh je kombinacija talenta, trdega dela in vztrajnosti. - Colin Powell'),
('Spremeni svoj način razmišljanja in spremeniš svoje življenje. - Louise Hay'),
('Nič ni nemogoče, beseda samo pravi: "I''m possible"! - Audrey Hepburn'),
('Če želiš spremeniti svet, začni pri sebi. - Mahatma Gandhi'),
('Skrivnost uspeha je v tem, da naredimo več kot se od nas pričakuje. - Gary Ryan Blair'),
('Nikoli ne obupaj, tudi če si na najnižji točki. Nekaj velikega se dogaja in morda je to ravno trenutek, ko se stvari začnejo obračati navzgor. - Zig Ziglar'),
('Vse, kar si lahko zamislimo, je resnično. - Pablo Picasso'),
('Motivacija pride in gre, vendar vztrajnost ostane. - Earl Nightingale'),
('Vsak korak, ki ga narediš, te pripelje bližje tvojemu cilju. - Brian Tracy'),
('Ne čakaj, da se zgodi, naredi, da se zgodi. - Laura Schlessinger'),
('Dovolj je samo ena oseba, ki verjame vate - in ta oseba si ti. - Mandy Hale'),
('Največje ovire pri doseganju svojih ciljev so pogosto tvoje lastne misli. - Zig Ziglar'),
('Nikoli ni prepozno, da postaneš, kar bi lahko bil. - George Eliot'),
('Ne čakajte na priložnost, ustvarite jo sami. - George Bernard Shaw'),
('Ni pomembno, koliko napak narediš, pomembno je, da se iz njih nekaj naučiš. - Bill Gates'),
('Verjemite, da lahko naredite več, kot si predstavljate. - Norman Vincent Peale'),
('Največji uspeh se pogosto pojavi tistim, ki se ne bojijo tvegati. - Robert F. Kennedy'),
('Izzivi so tisti, ki nam dajejo smisel in barvo v življenju. - Joshua J. Marine'),
('Ne dovoli, da tvoj strah vpliva na odločitve, ki jih sprejemaš. Namesto tega naj tvoja radovednost prevlada nad strahom. - Michelle Obama'),
('Najboljši način, da napovemo prihodnost, je, da jo ustvarimo sami. - Abraham Lincoln'),
('Največja sreča v življenju je, da veš, da si ljubljen za to, kar si, ali kljub temu. - Victor Hugo'),
('Sreča ni nekaj, kar je že narejeno. Prihaja iz vaših lastnih dejanj. - Dalaj Lama'),
('Neuspeh je priložnost za začetek znova, toda tokrat bolje. - Henry Ford'),
('Vsak nov dan je priložnost za nov začetek. Danes je torej priložnost, ki si jo ne smemo dovoliti zamuditi. - Zig Ziglar'),
('Vsi imamo omejitve, vendar pa, če delamo s tistim, kar imamo, lahko dosežemo vse, kar si želimo. - Conor McGregor'),
('Bodite hvaležni za to, kar imate, medtem ko delate za to, kar želite. - Helen Keller'),
('Najpomembnejša stvar pri komunikaciji je slišati, kaj ni bilo rečeno. - Peter Drucker'),
('Pustite, da vaša radovednost prevlada nad strahom. To je ključ do novih izkušenj in znanj." - Ellen J. Barrier'),
('Cilji so sanje z rokom trajanja. - Diana Scharf Hunt');

 CREATE TABLE dnevnik (
     dnevnik_id INT NOT NULL AUTO_INCREMENT,
     user_id INT NOT NULL,
     user_mood_id INT NOT NULL,
     dnevnik TEXT NOT NULL,
     PRIMARY KEY (dnevnik_id),
     FOREIGN KEY (user_id) REFERENCES uporabnik(user_id),
     FOREIGN KEY (user_mood_id) REFERENCES user_mood(user_mood_id));
