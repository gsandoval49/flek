-- SQL statements for drop tables
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS imageTag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS socialLogin;
DROP TABLE IF EXISTS mail;
DROP TABLE IF EXISTS profile;
-- End of SQL statements


-- PROFILE drop table here
CREATE TABLE profile (
  	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  	profileName VARCHAR(128) NOT NULL,
  	profileEmail VARCHAR(128) NOT NULL,
  	profileLocation VARCHAR (64) NOT NULL,
  	profileBio VARCHAR (255) NOT NULL,
  	profileHash CHAR(128) NOT NULL,
  	profileSalt CHAR(64) NOT NULL,
  	profileAccessToken VARCHAR(128),
  	profileActivationToken CHAR(32),
  	UNIQUE (profileEmail),
  	PRIMARY KEY (profileId)
);

-- MAIL drop table here

CREATE TABLE mail (
	/*this is the primary key, etc. etc.*/
	mailId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	mailSubject VARCHAR(128) NOT NULL,
	/*these were auto_incremented, we took that out */
	mailSenderId INT UNSIGNED NOT NULL,
	mailReceiverId INT UNSIGNED NOT NULL,
	mailGunId VARCHAR(64) NOT NULL,
	mailContent VARCHAR(1000) NOT NULL,
/*	mailDateTime DATETIME NOT NULL,*/
	INDEX (mailSenderId),
	INDEX (mailReceiverId),
	FOREIGN KEY (mailSenderId) REFERENCES profile(profileId),
	FOREIGN KEY (mailReceiverId) REFERENCES profile(profileId),
	PRIMARY KEY (mailId)
);


-- SOCIAL LOGIN drop table here
CREATE TABLE socialLogin (
  -- this is primary key
  socialLoginId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  socialLoginName VARCHAR(32) NOT NULL,
  -- index primary key into profile ID
  PRIMARY KEY (socialLoginId)
);


-- GENRE drop table here
CREATE TABLE genre (
  genreId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  genreName VARCHAR(32) NOT NULL,
  PRIMARY KEY (genreId)
);


-- IMAGE drop table here
CREATE TABLE image (
	-- this is primary key
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageGenreId INT UNSIGNED NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageDescription VARCHAR(128) NOT NULL,
	imageSecureUrl VARCHAR(128) NOT NULL,
	imagePublicId VARCHAR(32) NOT NULL,
	FOREIGN KEY (imageGenreId) REFERENCES genre(genreId),
	PRIMARY KEY (imageId)
);


-- TAG drop table here
CREATE TABLE tag (
	tagId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	tagName VARCHAR(32),
	PRIMARY KEY (tagId)
);


-- IMAGE TAG drop table here
CREATE TABLE imageTag (
	imageTagImageId INT UNSIGNED NOT NULL,
	imageTagTagId INT UNSIGNED NOT NULL,
	INDEX (imageTagImageId),
	INDEX (imageTagTagId),
	FOREIGN KEY (imageTagImageId) REFERENCES image(imageId),
	FOREIGN KEY (imageTagTagId) REFERENCES tag(tagId),
	PRIMARY KEY (imageTagImageId, imageTagTagId)
);

-- FAVORITE drop table here
CREATE TABLE favorite (
	favoriteeId INT UNSIGNED NOT NULL,
	favoriterId INT UNSIGNED NOT NULL,
	INDEX (favoriteeId),
	INDEX (favoriterId),
	FOREIGN KEY (favoriteeId) REFERENCES profile(profileId),
	FOREIGN KEY (favoriterId) REFERENCES profile(profileId),
	PRIMARY KEY (favoriteeId, favoriterId)
);
