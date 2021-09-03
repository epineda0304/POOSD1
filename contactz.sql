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
    email VARCHAR(225),
    date_added VARCHAR(10),
    PRIMARY KEY (ID),
    FOREIGN KEY (User_ID) REFERENCES users(id)
);

INSERT INTO users (Username, Pwd) VALUES ("em764", "a234");
INSERT INTO users (Username, Pwd) VALUES ("me467", "b321");
INSERT INTO users (Username, Pwd) VALUES ("hd777", "c678");
INSERT INTO users (Username, Pwd) VALUES ("dh111", "d765");
INSERT INTO users (Username, Pwd) VALUES ("aa741", "e101");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Manny", "Pineda", "4072624058", 1, "a@gmail.com", "9/1/2021");
INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Milo", "Belloso", "4072624048", 1, "b@gmail.com", "9/1/2021");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Emmanuel", "Zeleya", "3472624058", 2, "c@gmail.com", "9/2/2021");
INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Milo", "Belloso", "4072623471", 2, "d@gmail.com", "9/1/2021");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Vanessa", "Hernandez", "3475554058", 3, "e@gmail.com", "9/2/2021");
INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Juan", "Carlos", "3477773471", 3, "f@gmail.com", "9/2/2021");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Maria", "Hernandez", "3475553028", 4, "g@gmail.com", "9/3/2021");
INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Maria", "Pineda", "4077783471", 4, "h@gmail.com", "9/1/2021");

INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Antonia", "Urbina", "3473189856", 5, "i@gmail.com", "9/4/2021");
INSERT INTO people (First_name, Last_name, Phone_num, User_ID, email, date_added)
VALUES ("Mike", "Richards", "8007783471", 5, "j@gmail.com", "9/1/2021");
