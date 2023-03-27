SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE community (
  Communityid INT NOT NULL, 
  name VARCHAR(30),
  industry VARCHAR(30),
  PRIMARY KEY (Communityid)
);

CREATE TABLE users (
    userid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    avatarimgpath VARCHAR(255) UNIQUE,
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    isAdmin BOOLEAN,
    PRIMARY KEY (userid)
);

CREATE TABLE thread (
   tid INT NOT NULL AUTO_INCREMENT,
   title VARCHAR(100),
   Communityid INT,
   created DATETIME,
   points INT,
   threadtype INT,
   content VARCHAR(500),
   PRIMARY KEY (tid),
   userid INT,
   FOREIGN KEY (userid) REFERENCES Users(userid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
   FOREIGN KEY (Communityid) REFERENCES Community(Communityid)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE comment (
   commentid INT NOT NULL AUTO_INCREMENT,
   comment VARCHAR(1000),
   created DATETIME,
   points INT,
   userid INT,
   tid INT,
   PRIMARY KEY (commentid),
   FOREIGN KEY (userid) REFERENCES Users(userid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
   FOREIGN KEY (tid) REFERENCES Thread(tid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE
);

CREATE TABLE ban (
  banid INT NOT NULL AUTO_INCREMENT,
  userid INT,
  adminid INT,
  bandate DATETIME,
  expiredate DATETIME,
  banreason VARCHAR(1000),
  PRIMARY KEY (banid),
  FOREIGN KEY (userid) REFERENCES users(userid)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  FOREIGN KEY (adminid) REFERENCES users(userid)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE passwordreset ( 
  email VARCHAR(250) NOT NULL, 
  resettoken VARCHAR(250) NOT NULL, 
  resettokenexp DATETIME NOT NULL,
  PRIMARY KEY (email) 
  PRIMARY KEY (email)
);

-- Healthcare Communities
INSERT INTO community VALUES (1, "Pharma", "Healthcare");
INSERT INTO community VALUES (2, "Health Insurance", "Healthcare");
INSERT INTO community VALUES (3, "Home Care", "Healthcare");
INSERT INTO community VALUES (4, "Hospitals", "Healthcare");
INSERT INTO community VALUES (5, "Other Healthcare", "Healthcare");

-- Government Communities
INSERT INTO community VALUES (6, "Criminal Justice", "Government");
INSERT INTO community VALUES (7, "Law Enforcement", "Government");
INSERT INTO community VALUES (8, "Public Safety", "Government");
INSERT INTO community VALUES (9, "Transporation", "Government");
INSERT INTO community VALUES (10, "Other Government", "Government");

-- Tech Communities
INSERT INTO community VALUES (11, "FAANG", "Tech");
INSERT INTO community VALUES (12, "Startups", "Tech");
INSERT INTO community VALUES (13, "Fintech", "Tech");
INSERT INTO community VALUES (14, "Data science", "Tech");
INSERT INTO community VALUES (15, "Other Tech", "Tech");

-- Engineering Communities
INSERT INTO community VALUES (16, "Civil", "Engineering");
INSERT INTO community VALUES (17, "Electrial", "Engineering");
INSERT INTO community VALUES (18, "Mechanical", "Engineering");
INSERT INTO community VALUES (19, "Industrial", "Engineering");
INSERT INTO community VALUES (20, "Other Engineering", "Engineering");

INSERT INTO thread (title, communityid, created, points, content, threadtype)
VALUES ('I love big pharma', 1, NOW(), 0, 'Healthcare and big pharma is so cool', 1);

SET FOREIGN_KEY_CHECKS = 1;