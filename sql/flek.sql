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
  profileAccessToken NULL, -- keep as int unsigned null?--
  profileActivationToken NULL, -- keep as char (32)?
	UNIQUE (profileEmail),
  PRIMARY KEY (profileId)
);

-- MAIL drop table here


-- SOCIAL LOGIN drop table here


-- IMAGE drop table here


-- GENRE drop table here
CREATE TABLE genre (
  genreId INT UNSIGNED NOT NULL,
  genreName VARCHAR(32) NOT NULL,
  UNIQUE (genreId),
  PRIMARY KEY (genreId)
);


-- HASHTAG drop table here



-- TAG drop table here



-- FAVORITE drop table here



