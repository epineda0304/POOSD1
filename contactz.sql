CREATE DATABASE contacts;
USE contacts;

CREATE TABLE users
(
	ID INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR (15) NOT NULL,
    Pwd VARCHAR (15) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE people
(
	ID INT NOT NULL AUTO_INCREMENT,
    First_name VARCHAR (15) NOT NULL,
    Last_name VARCHAR (15) NOT NULL,
    Phone_num VARCHAR (10) NOT NULL,
    User_ID INT NOT NULL DEFAULT '0',
    PRIMARY KEY (ID),
    FOREIGN KEY (User_ID) REFERENCES users(id)
);

INSERT INTO users (Username, Pwd) VALUES ("em764", "a234");
INSERT INTO users (Username, Pwd) VALUES ("me467", "b321");
INSERT INTO users (Username, Pwd) VALUES ("hd777", "c678");
INSERT INTO users (Username, Pwd) VALUES ("dh111", "d765");
INSERT INTO users (Username, Pwd) VALUES ("aa741", "e101");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Manny", "Pineda", "4072624058", 1);
INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Milo", "Belloso", "4072624048", 1);

INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Emmanuel", "Zeleya", "3472624058", 2);
INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Milo", "Belloso", "4072623471", 2);

INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Vanessa", "Hernandez", "3475554058", 3);
INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Juan", "Carlos", "3477773471", 3);

INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Maria", "Hernandez", "3475553028", 4);
INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Maria", "Pineda", "4077783471", 4);

INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Antonia", "Urbina", "3473189856", 5);
INSERT INTO people (First_name, Last_name, Phone_num, User_ID)
VALUES ("Mike", "Richards", "8007783471", 5);