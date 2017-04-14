DROP TABLE IF EXIST favorite;
DROP TABLE IF EXIST product;
DROP TABLE IF EXIST profile;

CREATE TABLE  profile (

	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToke CHAR(32),
	profileHandle VARCHAR (32),
	ProfileEmail VARCHAR (128) UNIQUE NOT NULL,
	profileHash  CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileHandle),
	PRIMARY KEY (profileId)
);