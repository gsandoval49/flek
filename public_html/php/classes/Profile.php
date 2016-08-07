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
	 * name of city where profile is located
	 * @var string $profileLocation
	 **/
private profileLocation;

	/**
	 * content in biography that profile will have
	 * @var string $profileBio
	 **/
private profileBio;

	/**
	 * name of profileHash
	 * @var string $profileHash
	 **/
private profileHash;

	/**
	 * name of profileSalt
	 * @var string $profileSalt
	 **/
private profileSalt;

	/**
	 * profile access token
	 * @var int $profileAccessToken
	 **/
private profileAccessToken

	/**
	 *profile activation token hex
	 * @var string $profileActivationToken
	 **/
private profileActivationToken

	/**
	 * constructor for profile
	 * @param int|null $newProfileId of the profil or null if new profile
	 * @param string $newProfileName string containing actual profile full name
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
	public function __construct(int $newProfileId = null, int $newProfileAccessToken, string $newProfileActivation)
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
public function getProfileId() {
			return($this->profileId);
}

/**
 * mutator method for profile id
 *
 * @param int|null $newProfileId new value of profile id
 * @throws \RangeException if newProfileId is not positive
 * @throws \TypeError if $newProfileId is not an integer
 **/
public function setProfileId (int $newProfileId = null) {
			//base case: if the profile id is null, this is a new profile without a mySQL assigned it (yet)
			if($newProfileId ===null) {
					$this->profileId = null;
					return;
			}

			//verify the profile id is positive
			if($newProfileId <= 0) {
				throw(new \RangeException("Profile id must be a positive number."));
			}

			//convert and store the profile id
			$this->profileId = intval($newProfileId);
}

/**
 * accessor method for profile name
 * @return string value of profileName
 **/
public function getProfileName () {
			return ($this->profileName);
}

/**
 * mutator method for profileName
 *
 * @param string $newProfileName new value of profileName
 * @throws \InvalidArgumentException if $newProfileName is not a string
 * @throws \RangeException if $newProfileName is > 128
 * @throws \TypeError if $newProfileName is not a string
 **/
public function setProfileName (string $newProfileName) {
			//verify the profile's name is secure
			$newProfileName = trim($newProfileName);
			$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileName) === true) {
					throw(new \InvalidArgumentException("Profile name content is empty or insecure"));
			}

			//verify the profile name content will fit in the database
			if(strlen($newProfileName) > 128) {
					throw(new \RangeException("Name content too large"));
			}

			//store the profile name
			$this->profileName = $newProfileName;
}

/**
 * accessor method for profile email
 * @return string value of profileEmail
 **/


} //does this curly go on line 101?