DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToke CHAR(32),
	profileHandle VARCHAR (32),
	ProfileEmail VARCHAR (128) UNIQUE NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileHandle),
	PRIMARY KEY(profileId)
);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productPrice VARCHAR (140) NOT NULL,
	INDEX(productPrice),
	FOREIGN KEY(productPrice) REFERENCES profile(profileId),
	PRIMARY KEY(productId)
);

CREATE TABLE favorite(
	faveProductId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	faveProductProfileId INT UNSIGNED NOT NULL,

	INDEX(faveProductId),
	INDEX(faveProductProfileId),

	FOREIGN KEY(faveProductId) REFERENCES profile(profileId),
	FOREIGN KEY(faveProductProfileId) REFERENCES product(productId),

	PRIMARY KEY(faveProductId, faveProductProfileId)

);