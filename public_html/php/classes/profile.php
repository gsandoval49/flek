<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");

class Profile implements \JsonSerializable {

	/**
	 * id for the profile is the primary key
	 * @var int $profileId
	 **/
private profileId;

	/**
	 * name of profile
	 * @var string $profileName
	 **/
private profileName;

	/**
	 * email of profile
	 * @var string $profileEmail
	 **/
private profileEmail;

	/**
	 * name of city where profile user is located
	 * @var string $profileLocation
	 **/
private profileLocation;

	/**
	 * content in biography that profile will have
	 * @var string $profileBio
	 **/
private profileBio;

	/**
	 * name of userHash
	 * @var string $userHash
	 **/
private profileHash;

	/**
	 * name of userSalt
	 * @var string $userSalt
	 **/
private profileSalt;

	/**
	 * profile access token
	 * @var int $profileAccessToken
	 **/
private profileAccessToken

	/**
	 *user activation token hex
	 * @var string $profileActivationToken
	 **/
private profileActivationToken

/**
 * constructor for this profile
 *
 *
 **/
}
