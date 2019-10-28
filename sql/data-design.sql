DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS property;
DROP TABLE IF EXISTS crime;
DROP TABLE IF EXISTS star;

CREATE TABLE user (
   userUuid BINARY(16) NOT NULL,
   userActivationToken CHAR(32),
   userEmail VARCHAR(128) NOT NULL,
   userHash CHAR(97) NOT NULL,
   userUsername VARCHAR(32) NOT NULL,
   UNIQUE(userEmail),
   UNIQUE(userUsername),
   PRIMARY KEY (userUuid)
);

CREATE TABLE property (
   propertyUuid BINARY(16) NOT NULL,
   propertyClass CHAR(1) NOT NULL,
   propertyLatitude DECIMAL(17,14) NOT NULL,
   propertyLongitude DECIMAL (17,14) NOT NULL,
   propertySitusCity VARCHAR(80) NOT NULL,
	propertySitusStreetAddress VARCHAR(134) NOT NULL,
	propertyValue DECIMAL(15,2) NOT NULL
);

CREATE TABLE crime (
	crimeUuid BINARY(16) NOT NULL,
	crimeAddress VARCHAR(134) NOT NULL,
	crimeDate CHAR(13) NOT NULL,
	crimeLatitude DECIMAL(17,14) NOT NULL,
	crimeLongitude DECIMAL(17,14) NOT NULL,
	crimeType VARCHAR(134) NOT NULL
);

CREATE TABLE star (
   starPropertyUuid BINARY(16) NOT NULL,
   starUserUuid BINARY(16) NOT NULL,
   INDEX(starPropertyUuid),
   INDEX(starUserUuid),
   FOREIGN KEY(starPropertyUuid) REFERENCES property(propertyUuid),
   FOREIGN KEY(starUserUuid) REFERENCES user(userUuid),
   PRIMARY KEY(starPropertyUuid, starUserUuid)
);