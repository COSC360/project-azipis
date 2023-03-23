CREATE TABLE Community (
  communityid INT NOT NULL, 
  name VARCHAR(30),
  industry VARCHAR(30),
  PRIMARY KEY (communityid)
);

CREATE TABLE Users (
    userid INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    avatarimgpath VARCHAR(255) UNIQUE,
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    PRIMARY KEY (userid)
);

CREATE TABLE Thread (
   tid INT NOT NULL AUTO_INCREMENT,
   title VARCHAR(100),
   communityid INT,
   created DATETIME,
   points INT,
   threadtype INT,
   content VARCHAR(500),
   PRIMARY KEY (tid),
   userid INT,
   FOREIGN KEY (userid) REFERENCES Users(userid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
   FOREIGN KEY (communityid) REFERENCES Community(communityid)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE Comment (
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

-- Healthcare Communities
INSERT INTO COMMUNITY VALUES (1, "Pharma", "Healthcare");
INSERT INTO COMMUNITY VALUES (2, "Health Insurance", "Healthcare");
INSERT INTO COMMUNITY VALUES (3, "Home Care", "Healthcare");
INSERT INTO COMMUNITY VALUES (4, "Hospitals", "Healthcare");
INSERT INTO COMMUNITY VALUES (5, "Other Healthcare", "Healthcare");

-- Government Communities
INSERT INTO COMMUNITY VALUES (6, "Criminal Justice", "Government");
INSERT INTO COMMUNITY VALUES (7, "Law Enforcement", "Government");
INSERT INTO COMMUNITY VALUES (8, "Public Safety", "Government");
INSERT INTO COMMUNITY VALUES (9, "Transporation", "Government");
INSERT INTO COMMUNITY VALUES (10, "Other Government", "Government");

-- Tech Communities
INSERT INTO COMMUNITY VALUES (11, "FAANG", "Tech");
INSERT INTO COMMUNITY VALUES (12, "Startups", "Tech");
INSERT INTO COMMUNITY VALUES (13, "Fintech", "Tech");
INSERT INTO COMMUNITY VALUES (14, "Data science", "Tech");
INSERT INTO COMMUNITY VALUES (15, "Other Tech", "Tech");

-- Engineering Communities
INSERT INTO COMMUNITY VALUES (16, "Civil", "Engineering");
INSERT INTO COMMUNITY VALUES (17, "Electrial", "Engineering");
INSERT INTO COMMUNITY VALUES (18, "Mechanical", "Engineering");
INSERT INTO COMMUNITY VALUES (19, "Industrial", "Engineering");
INSERT INTO COMMUNITY VALUES (20, "Other Engineering", "Engineering");

INSERT INTO Thread (title, communityid, created, points, content, threadtype)
VALUES ('I love big pharma', 1, NOW(), 0, 'Healthcare and big pharma is so cool, 1');

