DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToke CHAR(32),
	profileHandle VARCHAR (32) NOT NULL,
	profileEmail VARCHAR (128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileHandle),
	PRIMARY KEY(profileId)
);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productProfileId INT UNSIGNED NOT NULL,
	productPrice VARCHAR(32),
	INDEX(productProfileId),
	FOREIGN KEY(productProfileId) REFERENCES profile(profileId),
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