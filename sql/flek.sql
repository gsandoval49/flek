-- SQL statements for drop tables
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS hashtag;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS socialLogin;
DROP TABLE IF EXISTS mail;
DROP TABLE IF EXISTS profile;
-- End of SQL statements


-- PROFILE drop table here
CREATE TABLE profile (
  profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  profileName VARCHAR(32) NOT NULL,
  profileEmail VARCHAR(128) NOT NULL,
  profileLocation VARCHAR (32) NOT NULL,
  profileBio VARCHAR (250) NOT NULL,
  profileHash CHAR(128) NOT NULL,
  profileSalt CHAR(64) NOT NULL,
  profileAccessToken VARCHAR(128),
  profileActivationToken CHAR(32),
  UNIQUE (profileEmail),
  PRIMARY KEY (profileId)
);

-- MAIL drop table here

CREATE TABLE mail (
	mailId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	mailSubject VARCHAR(64) NOT NULL,
	/*these were auto_incremented, we took that out */
	mailSenderId INT UNSIGNED NOT NULL,
	mailReceiverId INT UNSIGNED NOT NULL,
	mailGunId INT UNSIGNED NOT NULL,
	mailContent VARCHAR(1000) NOT NULL,
	INDEX (mailSenderId),
	INDEX (mailReceiverId),
	FOREIGN KEY (mailSenderId) REFERENCES profile(profileId),
	FOREIGN KEY (mailReceiverId) REFERENCES profile(profileId),
  -- removed unique mailId because a primary key is already unique, twas redundant
	PRIMARY KEY (mailId)
);


-- SOCIAL LOGIN drop table here
CREATE TABLE socialLogin (
  -- this is primary key
  socialLoginId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  socialLoginName VARCHAR(40) NOT NULL,
  -- index primary key into profile ID
  PRIMARY KEY (socialLoginId)
);

-- IMAGE drop table here
CREATE TABLE image (
	-- this is primary key
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageDescription VARCHAR(128) NOT NULL,
	imageSecureUrl VARCHAR(128) NOT NULL,
	imagePublicId INT UNSIGNED NOT NULL,
	PRIMARY KEY (imageId)
);

-- GENRE drop table here
CREATE TABLE genre (
  genreId INT UNSIGNED NOT NULL,
  genreName VARCHAR(32) NOT NULL,
	genreImageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  PRIMARY KEY (genreId)
);


-- HASHTAG drop table here



-- TAG drop table here



-- FAVORITE drop table here



