DROP TABLE IF EXISTS star;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS property;
DROP TABLE IF EXISTS crime;

CREATE TABLE `user` (
	userId            BINARY(16)   NOT NULL,
	userActivationToken CHAR(32),
	userEmail           VARCHAR(128) NOT NULL,
	userHash            CHAR(97)     NOT NULL,
	userUsername        VARCHAR(32)  NOT NULL,
	UNIQUE (userEmail),
	UNIQUE (userUsername),
	PRIMARY KEY (userId)
);

CREATE TABLE property (
	propertyId          BINARY(16)     NOT NULL,
	propertyCity          VARCHAR(80)    NOT NULL,
	propertyClass         CHAR(1)        NOT NULL,
	propertyLatitude      DECIMAL(9, 6)  NOT NULL,
	propertyLongitude     DECIMAL(9, 6)  NOT NULL,
	propertyStreetAddress VARCHAR(134)   NOT NULL,
	propertyValue         DECIMAL(15, 2) NOT NULL,
	PRIMARY KEY (propertyId)
);

CREATE TABLE crime (
	crimeId      BINARY(16)    NOT NULL,
	crimeAddress   VARCHAR(134)  NOT NULL,
	crimeDate      DATETIME      NOT NULL,
	crimeLatitude  DECIMAL(9, 6) NOT NULL,
	crimeLongitude DECIMAL(9, 6) NOT NULL,
	crimeType      VARCHAR(134)  NOT NULL,
	PRIMARY KEY (crimeId)
);

CREATE TABLE star (
	starPropertyId BINARY(16) NOT NULL,
	starUserId     BINARY(16) NOT NULL,
	INDEX (starPropertyId),
	INDEX (starUserId),
	FOREIGN KEY (starPropertyId) REFERENCES property(propertyId),
	FOREIGN KEY (starUserId) REFERENCES user(userId),
	PRIMARY KEY (starPropertyId, starUserId)
);

-- drop the procedure if already defined
DROP FUNCTION IF EXISTS haversine;

-- procedure to calculate the distance between two points
-- @param FLOAT $originX point of origin, x coordinate
-- @param FLOAT $originY point of origin, y coordinate
-- @param FLOAT $destinationX point heading out, x coordinate
-- @param FLOAT $destinationY point heading out, y coordinate
-- @return FLOAT distance between the points, in miles
CREATE FUNCTION haversine(originX FLOAT, originY FLOAT, destinationX FLOAT, destinationY FLOAT) RETURNS FLOAT
BEGIN;
	-- first, declare all variables; I don't think you can declare later
	DECLARE radius FLOAT;
	DECLARE latitudeAngle1 FLOAT;
	DECLARE latitudeAngle2 FLOAT;
	DECLARE latitudePhase FLOAT;
	DECLARE longitudePhase FLOAT;
	DECLARE alpha FLOAT;
	DECLARE corner FLOAT;
	DECLARE distance FLOAT;

-- assign the variables that were declared & use them
	SET radius = 3958.7613; -- radius of the earth in miles
	SET latitudeAngle1 = RADIANS(originY);
	SET latitudeAngle2 = RADIANS(destinationY);
	SET latitudePhase = RADIANS(destinationY - originY);
	SET longitudePhase = RADIANS(destinationX - originX);

	SET alpha = POW(SIN(latitudePhase / 2), 2)
		+ POW(SIN(longitudePhase / 2), 2)
						* COS(latitudeAngle1) * COS(latitudeAngle2);
	SET corner = 2 * ASIN(SQRT(alpha));
	SET distance = radius * corner;

	RETURN distance;
END;