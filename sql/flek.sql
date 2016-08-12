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
	mailDateTime DATETIME NOT NULL,
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

-- IMAGE drop table here
CREATE TABLE image (
	-- this is primary key
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageDescription VARCHAR(128) NOT NULL,
	imageSecureUrl VARCHAR(128) NOT NULL,
	imagePublicId VARCHAR(32) NOT NULL,
	imageGenreId INT UNSIGNED NOT NULL,
	PRIMARY KEY (imageId)
);



-- GENRE drop table here
CREATE TABLE genre (
  genreId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  genreName VARCHAR(32) NOT NULL,
  PRIMARY KEY (genreId)
);


-- HASHTAG drop table here
CREATE TABLE hashtag (
  hashtagId INT UNSIGNED NOT NULL,
  hashtagName VARCHAR(32),
  PRIMARY KEY (hashtagId)
);


-- TAG drop table here
CREATE TABLE tag (
	tagImageId INT UNSIGNED NOT NULL,
	tagHashtagId INT UNSIGNED NOT NULL,
	INDEX (tagImageId),
	INDEX (tagHashtagId),
	FOREIGN KEY (tagImageId) REFERENCES image(imageId),
	FOREIGN KEY (tagHashtagId) REFERENCES hashtag(hashtagId),
	PRIMARY KEY (tagImageId, tagHashtagId)
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