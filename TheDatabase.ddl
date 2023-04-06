SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE community (
  communityid INT NOT NULL, 
  name VARCHAR(30),
  industry VARCHAR(30),
  PRIMARY KEY (communityid)
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
   communityid INT,
   created DATETIME,
   threadtype INT,
   content VARCHAR(500),
   PRIMARY KEY (tid),
   userid INT,
   FOREIGN KEY (userid) REFERENCES users(userid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
   FOREIGN KEY (communityid) REFERENCES community(communityid)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE comment (
   commentid INT NOT NULL AUTO_INCREMENT,
   comment VARCHAR(1000),
   created DATETIME,
   userid INT,
   tid INT,
   PRIMARY KEY (commentid),
   FOREIGN KEY (userid) REFERENCES users(userid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
   FOREIGN KEY (tid) REFERENCES thread(tid)
    ON DELETE SET NULL 
    ON UPDATE CASCADE
);

CREATE TABLE thread_votes (
  userid INT,
  tid INT,
  vote INT,
  PRIMARY KEY (userid, tid),
  FOREIGN KEY (userid) REFERENCES users(userid)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (tid) REFERENCES thread(tid)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE comment_votes (
  userid INT,
  commentid INT,
  vote INT,
  PRIMARY KEY (userid, commentid),
  FOREIGN KEY (userid) REFERENCES users(userid)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (commentid) REFERENCES comment(commentid)
    ON DELETE CASCADE
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

INSERT INTO thread (title, communityid, created, content, threadtype)
VALUES ('I love big pharma', 1, NOW(), 'Healthcare and big pharma is so cool', 1);

SET FOREIGN_KEY_CHECKS = 1;