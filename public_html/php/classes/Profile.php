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
public function getProfileEmail () {
			return ($this->profileEmail);
}

/**
 * mutator method for profileEmail
 *
 * @param string $newProfileEmail new value of profileEmail
 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
 * @throws \RangeException if $newProfileEmail is > 128 characters
 * @throws \TypeError if $newProfileEmail is not a string
 **/
public function setProfileEmail (string $newProfileEmail) {
			//verify the profile's email content is secure
			$newProfileEmail = trim($newProfileEmail);
			$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
			if(empty($newProfileEmail) === true) {
					throw(new \InvalidArgumentException("Profile's email content is empty or insecure"));
         }

         //verify the email will fit in the database
			if(strlen($newProfileEmail) > 128) {
					throw(new \RangeException("Email too large"));
			}

			//store the profile's email
			$this->profileEmail = $newProfileEmail;
}

/**
 * accessor method for profile location
 * @return string value of profileLocation
 **/
public function getProfileLocation () {
			return ($this->profileLocation);
}

/**
 * mutator method for profileLocation
 *
 * @param string $newProfileLocation new value of profile location
 * @throws \InvalidArgumentException if $newProfileLocation is not a string or is insecure
 * @throws \RangeException if $newProfileLocation is > 64 characters
 * @throws \TypeError if $newProfileLocation is not a string
 **/
public function setProfileLocation (string $newProfileLocation) {
			//verify the profile's location content is secure
			$newProfileLocation = trim($newProfileLocation);
			$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileLocation) === true) {
					throw (new \InvalidArgumentException("profile location is empty of insecure"));
			}
			if(strlen($newProfileLocation) >64) {
					throw (new \RangeException("profile location field is greater than 64 characters"));
			}

			//store the profile's location
			$this->profileLocation = $newProfileLocation;
}

/**
 * accessor method for profileBio
 * @return string value of profileBio
 **/
public function getProfileBio () {
			return ($this->profileBio)
}

/**
 * mutator method for profileBio
 *
 * @param string $newProfileBio new value of profile location
 * @throws \InvalidArgumentException if $newProfileBio is not a string or is insecure
 * @throws \RangeException if $newProfileBio is > 255 characters
 **/
public function setProfileBio($newProfileBio) {
			//verify the profile bio content is secure
			$newProfileBio = trim($newProfileBio);
			$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING);
			if(empty($newProfileBio) === true) {
					throw (new \InvalidArgumentException("profile description is empty or insecure"));
			}
			if(strlen($newProfileBio) > 255) {
					throw (new \RangeException("profile bio is greater than 255 characters"));
			}
			//store the profile bio content
			$this->profileBio = $newProfileBio;
}

/**
 * accessor method for profileHash
 * @return int|null for $newProfileHash
 **/
public function getProfileHash() {
			return ($this->profileHash);
}

/**
 * mutator method for profileHash
 *
 * @param string $newProfileHash string of profile hash
 * @param \InvalidArgumentException if $newProfileHash is not a string
 * @param \RangeException if $newProfileHash = 128
 * @param \TypeError if $newProfileHash is not a string
 **/
public function setProfileHash (string $newProfileHash) {
			//verification that $profileHash is secure
			$newProfileHash = strtolower(trim($newProfileHash));
			//make sure that profile hash cannot be null
			if(ctype_xdigit($newProfileHash) === false) {
					throw(new \RangeException("profile hash cannot be null"));
			}
			//make sure profile hash = 128
			if(strlen($newProfileHash) !== 128) {
					throw(new \RangeException("profile hash has to be 128"));
			}
			//convert and store profile hash
			$this->profileHash = $newProfileHash;
}

/**
 * accessor method for profileSalt
 * @return string value of profileSalt
 **/
public function getProfileSalt () {
			return ($this->profileSalt);
}

/**
 * mutator method for profileSalt
 *
 * @param string $newProfileSalt new value of profileSalt
 * @throws \InvalidArgumentException if $newProfileSalt is not a string or insecure
 * @throws \RangeException if $newProfileSalt is > 64 characters
 * @throws \TypeError if $newProfileSalt is not a string
 **/
public function setProfileSalt (string $newProfileSalt) {
			$newProfileSalt = strtolower(trim($newProfileSalt));
			//verification that $profileSalt is secure
			if(ctype_xdigit($newProfileSalt) === false) {
				throw(new \RangeException("profile salt cannot be null"));
			}
			//make sure profile salt = 64
			if(strlen($newProfileSalt) !== 64) {
					throw(new \RangeException("profile has has to be 64"));
			}
			//convert and store user salt
			$this->profileSalt = $newProfileSalt;
}

/**
 * accessor method for profileAccessToken
 * @return string value of profile access token
 **/
public function getProfileAccessToken () {
			return ($this->profileAccessToken)
}

/**
 * mutator method for profileAccessToken
 *
 * @param string $profileAccessToken new value of profile id
 * @throws \InvalidArgumentException if $newProfileAccessToken is not a string or insecure
 * @throws \TypeError if $newProfileAccessToken is not a string
 **/
public function setProfileAccessToken (string $newProfileAccessToken) {
		//verify the profile Access Token is secure
		$newProfileAccessToken = trim($newProfileAccessToken);
		$newProfileAccessToken = filter_var($newProfileAccessToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAccessToken) === true) {
			throw(new \InvalidArgumentException("Profile access token content is empty or insecure"));
		}

		//convert store the profile Access Token
		$this->profileAccessToken = $newProfileAccessToken;
	}


/**
 * accessor method for profileActivationToken
 * @return string value of profile activation token
 **/
public function getProfileActivationToken() {
			return($this->profileActivationToken);
}

/**
 * mutator method for profileActivationToken
 *
 * @param string $newProfileActivationToken
 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
 * @throws \TypeError if $newProfileActivationToken is not a string
 **/
public function setProfileActivationToken (string $newProfileActivationToken = null) {
			//verify the profile activation token is secure
			if($newProfileActivationToken ===null){
					$this->profileActivationToken = null;
					return;
			}

			$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
			if(ctype_xdigit($newProfileActivationToken) === false) {
					throw(new \RangeException("profile activation token cannot be null"));
			}
			//make sure profile activation token = 32
			if(strlen($newProfileActivationToken) !== 32) {
					throw(new\RangeException("profile activation token has to be 32"));
			}

			$this->profileActivationToken = $newProfileActivationToken;
}

/**
 * updates this profile in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related error occur
 * @throws \TypeErrorif $pdo is not a PDO connection object
 **/


} //does this curly go on line 101?