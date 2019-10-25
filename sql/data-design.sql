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
   propertyGeoLocation DECIMAL(6,6),
   propertySitusCity VARCHAR()
);

CREATE TABLE crime (

);

CREATE TABLE star (

);