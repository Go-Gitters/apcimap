DROP TABLE IF EXISTS star;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS property;
DROP TABLE IF EXISTS crime;

CREATE TABLE user (
	userUuid            BINARY(16)   NOT NULL,
	userActivationToken CHAR(32),
	userEmail           VARCHAR(128) NOT NULL,
	userHash            CHAR(97)     NOT NULL,
	userUsername        VARCHAR(32)  NOT NULL,
	UNIQUE (userEmail),
	UNIQUE (userUsername),
	PRIMARY KEY (userUuid)
);

CREATE TABLE property (
	propertyUuid          BINARY(16)     NOT NULL,
	propertyCity          VARCHAR(80)    NOT NULL,
	propertyClass         CHAR(1)        NOT NULL,
	propertyLatitude      DECIMAL(9, 6)  NOT NULL,
	propertyLongitude     DECIMAL(9, 6)  NOT NULL,
	propertyStreetAddress VARCHAR(134)   NOT NULL,
	propertyValue         DECIMAL(15, 2) NOT NULL,
	PRIMARY KEY (propertyUuid)
);

CREATE TABLE crime (
	crimeUuid      BINARY(16)    NOT NULL,
	crimeAddress   VARCHAR(134)  NOT NULL,
	crimeDate      CHAR(13)      NOT NULL,
	crimeLatitude  DECIMAL(9, 6) NOT NULL,
	crimeLongitude DECIMAL(9, 6) NOT NULL,
	crimeType      VARCHAR(134)  NOT NULL,
	PRIMARY KEY (crimeUuid)
);

CREATE TABLE star (
	starPropertyUuid BINARY(16) NOT NULL,
	starUserUuid     BINARY(16) NOT NULL,
	INDEX (starPropertyUuid),
	INDEX (starUserUuid),
	FOREIGN KEY (starPropertyUuid) REFERENCES property(propertyUuid),
	FOREIGN KEY (starUserUuid) REFERENCES user(userUuid),
	PRIMARY KEY (starPropertyUuid, starUserUuid)
);