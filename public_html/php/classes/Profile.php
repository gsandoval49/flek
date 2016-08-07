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
	 * constructor for profile
	 * @param int|null $newProfileId of the profiler user or null if new profile
	 * @param string $newProfileName string containing actual profile user full name
	 * @param string $newProfileEmail string containing profile email
	 * @param string $newProfileLocation string containing profile physical location
	 * @param string $newProfileBio string containing profile bio summary
	 * @param string $newProfileHash string containing actual profile password hash
	 * @param string $newProfileSalt string containing actual profile password salt
	 * @param int $newProfileAccessToken
	 * @param string $newProfileActivationToken string with profile token
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 **/
	public function __construct (int $newProfileId = null, int $newProfileAccessToken, string $newProfileActivation)
		try {
				$this->setProfileId($newProfileId);
				$this->setProfileName($newProfileId);
				$this->setProfileLocation($newProfileLocation);
				$this->setProfileBio($newProfileBio);
				$this->setProfileHash($newProfileHash);
				$this->setProfileSalt($newProfileSalt);
				$this->setProfileAccessToken($newProfileAccessToken);
				$this->setProfileActivationToken($newProfileActivationToken);
	} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	} catch(\RangeException $range) {
			//rethrow exception to caller
			throw(new \RangeException($range->getMessage(), 0, $range));
	} catch(\TypeError $typeError) {
			//rethrow exception to caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
	} catch(\Exception $exception) {
			//rethrow regular exception to caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
	}
	//}

/**
 * accessor method for profile id
 *
 * @return int|null value of profile id
 **/

} //does this curly go on line 101?