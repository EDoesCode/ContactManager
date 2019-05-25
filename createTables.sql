CREATE TABLE Accounts ( 
    AccountID      INT NOT NULL AUTO_INCREMENT,
    AccountName    VARCHAR(50) NOT NULL,
    FirstName      VARCHAR(50) NOT NULL,
    LastName       VARCHAR(50) NOT NULL,
    Password       VARCHAR(200) NOT NULL,
    LastLoginDate  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CreateDate     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(AccountID)
) ENGINE=INNODB;

CREATE TABLE Contacts (
    ContactID       INT NOT NULL AUTO_INCREMENT,
    FirstName       VARCHAR(50),
    LastName        VARCHAR(50),
    Address1        VARCHAR(60),
    Address2        VARCHAR(60),
    City            VARCHAR(20),
    State           VARCHAR(2),
    Zip             VARCHAR(10),
    Email           VARCHAR(150),
    Phone           VARCHAR(20),
    AccountID       INT(11),    
    PRIMARY KEY(ContactID)
) ENGINE=INNODB;