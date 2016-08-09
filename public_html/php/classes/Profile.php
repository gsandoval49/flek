<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");

/**
 * This profile class will be offered to users who would like to create a landing page with their information and
 * communicate with others.
 *
 * @author Chrisitna Sosa <csosa4@cnm.edu>
 *
 * @version 1.0.0
**/

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
	 * @var string $profileAccessToken
	 **/
	private profileAccessToken;

	/**
	 *profile activation token hex
	 * @var string $profileActivationToken
	 **/
	private profileActivationToken;

	/**
	 * constructor for profile
	 * @param int|null $newProfileId of the profile or null if new profile
	 * @param string $newProfileName string containing actual profile full name
	 * @param string $newProfileEmail string containing profile email
	 * @param string $newProfileLocation string containing profile physical location
	 * @param string $newProfileBio string containing profile bio summary
	 * @param string $newProfileHash string containing actual profile password hash
	 * @param string $newProfileSalt string containing actual profile password salt
	 * @param string $newProfileAccessToken string with profile permission
	 * @param string $newProfileActivationToken string with profile token
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 **/
	public function __construct(int $newProfileId = null, string $newProfileName, string $newProfileLocation, string
	$newProfileBio, string $newProfileHash, string $newProfileSalt, string $newProfileAccessToken, string
	$newProfileActivationToken) {
			try {
					$this->setProfileId($newProfileId);
					$this->setProfileName($newProfileName);
					$this->setProfileLocation($newProfileLocation);
					$this->setProfileBio($newProfileBio);
					$this->setProfileHash($newProfileHash);
					$this->setProfileSalt($newProfileSalt);
					$this->setProfileAccessToken($newProfileAccessToken);
					$this->setProfileActivationToken($newProfileActivationToken);
			} catch (\InvalidArgumentException $invalidArgument) {
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
	}

/**
 * accessor method for profile id
 *
 * @return int|null value of profile id
 **/
public function getProfileId() {
		return ($this->profileId);
}

/**
 * mutator method for profile id
 *
 * @param int|null $newProfileId new value of profile id
 * @throws \RangeException if newProfileId is not positive
 * @throws \TypeError if $newProfileId is not an integer
 **/
public function setProfileId(int $newProfileId = null) {
		//base case: if the profile id is null, this is a new profile without a mySQL assigned it (yet)
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		//verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("Profile id must be a positive number."));
		}

		//convert and store the profile id
		$this->profileId = $newProfileId;
}

/**
 * accessor method for profile name
 * @return string value of profileName
 **/
public function getProfileName() {
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
public function setProfileName(string $newProfileName) {
		//verify the profile's name is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("Profile name content is empty or insecure"));
		}

		//verify the profile name content will fit in the database
		if(strlen($newProfileName) > 128) {
			throw(new \RangeException("Name content too large"));
		}

		//convert and store the profile name
		$this->profileName = $newProfileName;
}

/**
 * accessor method for profile email
 * @return string value of profileEmail
 **/
public function getProfileEmail() {
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
public function setProfileEmail(string $newProfileEmail) {
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

		//convert and store the profile's email
		$this->profileEmail = $newProfileEmail;
}

/**
 * accessor method for profile location
 * @return string value of profileLocation
 **/
public function getProfileLocation() {
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
public function setProfileLocation(string $newProfileLocation) {
		//verify the profile's location content is secure
		$newProfileLocation = trim($newProfileLocation);
		$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING);
		if(empty($newProfileLocation) === true) {
			throw (new \InvalidArgumentException("profile location is empty of insecure"));
		}

		//verify the email will fit in the database
		if(strlen($newProfileLocation) > 64) {
			throw (new \RangeException("profile location field is greater than 64 characters"));
		}

		//convert and store the profile's location
		$this->profileLocation = $newProfileLocation;
}

/**
 * accessor method for profileBio
 * @return string value of profileBio
 **/
public function getProfileBio() {
		return ($this->profileBio);
}

/**
 * mutator method for profileBio
 *
 * @param string $newProfileBio new value of profile location
 * @throws \InvalidArgumentException if $newProfileBio is not a string or is insecure
 * @throws \RangeException if $newProfileBio is > 255 characters
 * @throws \TypeError if $newProfileBio is not a string
 **/
public function setProfileBio(string $newProfileBio) {
		//verify the profile bio content is secure
		$newProfileBio = trim($newProfileBio);
		$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING);
		if(empty($newProfileBio) === true) {
			throw (new \InvalidArgumentException("profile description is empty or insecure"));
		}

		//verify the profile bio will fit in the database
		if(strlen($newProfileBio) > 255) {
			throw (new \RangeException("profile bio is greater than 255 characters"));
		}

		//convert and store the profile bio content
		$this->profileBio = $newProfileBio;
}

/**
 * accessor method for profileHash
 * @return string $newProfileHash new value of profile hash
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
public function setProfileHash(string $newProfileHash) {
		//verification that $profileHash is secure
		$newProfileHash = strtolower(trim($newProfileHash));
		$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING);
		if(empty($newProfileHash) === true) {
				throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}
		//verify the profile hash will fit into the database
		if(strlen($newProfileHash) >128) {
			throw(new \RangeException("profile hash too large"));
		}

		//convert and store profile hash
		$this->profileHash = $newProfileHash;
}

/**
 * accessor method for profileSalt
 * @return string value of profileSalt
 **/
public function getProfileSalt() {
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
public function setProfileSalt(string $newProfileSalt) {
		$newProfileSalt = strtolower(trim($newProfileSalt));
		//verification that $profileSalt is secure
		if(empty($newProfileSalt) === true) {
		throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}
		//make sure profile salt = 64
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile has has to be 64"));
		}
		//convert and store profile salt
		$this->profileSalt = $newProfileSalt;
}

/**
 * accessor method for profileAccessToken
 * @return string value of profile access token
 **/
public function getProfileAccessToken() {
		return ($this->profileAccessToken);
}

/**
 * mutator method for profileAccessToken
 *
 * @param string $profileAccessToken new value of profile id
 * @throws \InvalidArgumentException if $newProfileAccessToken is not a string or insecure
 * @throws \TypeError if $newProfileAccessToken is not a string
 **/
public function setProfileAccessToken(string $newProfileAccessToken) {
		//verify the profile Access Token is secure
		$newProfileAccessToken = trim($newProfileAccessToken);
		$newProfileAccessToken = filter_var($newProfileAccessToken, FILTER_SANITIZE_STRING);
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
		return ($this->profileActivationToken);
}

/**
 * mutator method for profileActivationToken
 *
 * @param string $newProfileActivationToken
 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
 * @throws \TypeError if $newProfileActivationToken is not a string
 **/
public function setProfileActivationToken(string $newProfileActivationToken = null) {
		//verify the profile activation token is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("Activation Token is empty or secure"));
		}

		//make sure profile activation token = 32
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("profile activation token has to be 32"));
		}

		//convert and store profile activation token
		$this->profileActivationToken = $newProfileActivationToken;
}

/**
 * inserts this profile in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related error occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $PDO) {
	//enforce the profileId id null (i.e., don't insert a profile that already exists)
	if($this->profileId !== null) {
		throw(new \PDOException("not a new profile"));
	}

	//create query template
	$query = "INSERT INTO profile(profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, 
			profileSalt, profileAccessToken, profileActivationToken) VALUES (:profileId, :profileName, :profileEmail, 
			:profileLocation, :profileBio, :profileHash, :profileSalt, :profileAccessToken, :profileActivationToken)";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holders in the template
	$parameters = ["profileName" => $this->profileName, "profileEmail" => $this->profileEmail, "profileLocation" => $this->profileLocation, "profileBio" => $this->profileBio, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt, "profileAccessToken" => $this->profileAccessToken, "profileActivationToken" => $this->profileActivationToken];
	$statement->execute($parameters);

	//update the null profileId with what mySQL just gave us
	$this->profileId = intval($PDO->lastInsertId());
}

/**
 * deletes the profile from mySQL
 *
 * @param \PDO $pdo PDO connecton object
 * @param \PDOException when mySQL related error occurs
 * @param \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) {
	//enforce the profileId is not null (don't insert a profile that is not inserted)
	if($this->profileId === null) {
		throw(new \PDOException("unable to delete a profile that does not exist"));
	}
	//create a query template
	$query = "DELETE FROM profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holder in the template
	$parameters = ["profileId" => $this->profileId];
	$statement->execute($parameters);
}

/**
 * updates this profile in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related error occurs
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) {
	//enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
	if($this->profileId === null) {
		throw(new \PDOException("unable to update a profile that does not exist"));
	}

	//create query template
	$query = "UPDATE profile SET profileId = :profileId, profileName = :profileName, profileEmail = :profileEmail, profileLocation = :profileLocation, profileBio = :profileBio, profileHash = :profileHash, profileSalt = :profileSalt, profileAccessToken = :profileAccessToken, profileActivationToken = :profileActivationToken WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holders in the template
	$parameters = ["profileName" => $this->profileName, "profileEmail" => $this->profileEmail, "profileLocation" => $this->profileLocation, "profileBio" => $this->profileBio, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt, "profileAccessToken" => $this->profileAccessToken, "profileActivationToken" => $this->profileActivationToken];
	$statement->execute($parameters);
}

/**
 * gets profile by profileId
 *
 * @param \PDO $pdo PDO connection object
 * @param int $profileId profile id to search for
 * @return profile|null profile found or null if not found
 * @throws \PDOException when mySQL related errors occurs
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
	//sanitize the profileId before searching
	if($profileId <= 0) {
		throw(new \RangeException("profile id must be positive"));
	}

	//create query template
	$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	//bind the profileId to the place holder in the template
	$parameters = ["profileId" => $profileId];
	$statement->execute($parameters);

	//build an array of profiles
	$profiles = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while (($row = $statement->fetch()) !== false); {
		try {
			$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
			$profiles[$tweets->key()] = $profile;
			$tweets->next();
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($profile);
}

/**
 * gets profile by profileName
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileName profile name to search for
 * @return \SplFixedArray SplFixedArray of profiles found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getProfileByProfileName(\PDO $pdo, string $profileId) {
		//sanitize the name before searching
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING);
		if(empty($profileName) === true) {
			throw(new \PDOException("profile name is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, 
		profileAccessToken, profileActivationToken FROM profile WHERE profileName LIKE :profileName";
		$statement = $pdo->prepare($query);

		//bind the profile name to the place holder in the template
		$profileName = "%$profileName%";
		$parameters = ["profileName" => $profileName];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($profiles);
	}
/**
 * gets profile by profileEmail
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileEmail profile email to search for
 * @return \SplFixedArray SplFixedArray of profiles found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail) {
		//sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("profile email is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileEmail LIKE :profileEmail";
		$statement = $pdo->prepare($query);

		//bind the profile email to the place holder in the template
		$profileEmail = "%$profileEmail%";
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($profiles);
	}

	/**
	 * gets profile by profileLocation
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileLocation profile location to search for
	 * @return \SplFixedArray SplFixedArray of profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
public static function getProfileByProfileLocation(\PDO $pdo, string $profileLocation) {
		//sanitize the location before searching
		$profileLocation = trim($profileLocation);
		$profileLocation = filter_var($profileLocation, FILTER_SANITIZE_STRING);
		if(empty($profileLocation) === true) {
			throw(new \PDOException("profile location is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileLocation LIKE :profileLocation";
		$statement = $pdo->prepare($query);

		//bind the profile location to the place holder in the template
		$profileLocation = "%$profileLocation%";
		$parameters = ["profileLocation" => $profileLocation];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return ($profiles);
	}

		/**
		 * gets profile by profileBio
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $profileBio profile bio to search for
		 * @return \SplFixedArray SplFixedArray of profiles found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
public static function getProfileByProfileBio(\PDO $pdo, string $profileBio) {
		//sanitize the bio before searching
		$profileBio = trim($profileBio);
		$profileBio = filter_var($profileBio, FILTER_SANITIZE_STRING);
		if(empty($profileBio) === true) {
			throw(new \PDOException("profile bio is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileBio LIKE :profileBio";
		$statement = $pdo->prepare($query);

		//bind the profile bio to the place holder in the template
		$profileBio = "%$profileBio%";
		$parameters = ["profileBio" => $profileBio];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

			/**
			 * gets profile by profileHash
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param string $profileHash profile hash to search for
			 * @return \SplFixedArray SplFixedArray of profiles found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
public static function getProfileByProfileHash(\PDO $pdo, string $profileHash) {
		//sanitize the Hash before searching
		$profileHash = trim($profileHash);
		$profileHash = filter_var($profileHash, FILTER_SANITIZE_STRING);
		if(empty($profileHash) === true) {
			throw(new \PDOException("profile hash is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileHash LIKE :profileHash";
		$statement = $pdo->prepare($query);

		//bind the profile hash to the place holder in the template
		$profileHash = "%$profileHash%";
		$parameters = ["profileHash" => $profileHash];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

			/**
			 * gets profile by profileSalt
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param string $profileSalt profile salt to search for
			 * @return \SplFixedArray SplFixedArray of profiles found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
public static function getProfileByProfileSalt(\PDO $pdo, string $profileSalt) {
		//sanitize the salt before searching
		$profileSalt = trim($profileSalt);
		$profileSalt = filter_var($profileSalt, FILTER_SANITIZE_STRING);
		if(empty($profileSalt) === true) {
			throw(new \PDOException("profile salt is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileSalt LIKE :profileSalt";
		$statement = $pdo->prepare($query);

		//bind the profile salt to the place holder in the template
		$profileSalt = "%$profileSalt%";
		$parameters = ["profileSalt" => $profileSalt];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

/**
 * gets profile by profileAccessToken
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileAccessToken profile access token to search for
 * @return \SplFixedArray SplFixedArray of profiles found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getProfileByProfileAccessToken(\PDO $pdo, string $profileAccessToken) {
		//sanitize the access token before searching
		$profileAccessToken = trim($profileAccessToken);
		$profileAccessToken = filter_var($profileAccessToken, FILTER_SANITIZE_STRING);
		if(empty($profileAccessToken) === true) {
			throw(new \PDOException("profile access token is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileAccessToken LIKE :profileAccessToken";
		$statement = $pdo->prepare($query);

		//bind the profile access token to the place holder in the template
		$profileAccessToken = "%$profileAccessToken%";
		$parameters = ["profileAccessToken" => $profileAccessToken];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

/**
 * gets profile by profileActivationToken
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileActivationToken profile activation token to search for
 * @return \SplFixedArray SplFixedArray of profiles found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) {
		//sanitize the activation token before searching
		$profileActivationToken = trim($profileActivationToken);
		$profileActivationToken = filter_var($profileActivationToken, FILTER_SANITIZE_STRING);
		if(empty($profileActivationToken) === true) {
			throw(new \PDOException("profile activation token is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile WHERE profileAccessToken LIKE :profileAccessToken";
		$statement = $pdo->prepare($query);

		//bind the profile activation token to the place holder in the template
		$profileActivationToken = "%$profileActivationToken%";
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

/**
 * gets all profiles
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of profiles found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getsAllProfiles(\PDO $pdo){
			//create query template
			$query = "SELECT profileId, profileName, profileEmail, profileLocation, profileBio, profileHash, profileSalt, profileAccessToken, profileActivationToken FROM profile";
			$statement = $pdo->prepare($query);
			$statement->execute();

			//build an array of profiles
			$profiles = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileLocation"], $row["profileBio"], $row["profileHash"], $row["profileSalt"], $row["profileAccessToken"], $row["profileActivationToken"]);
					$profiles[$profiles->key()] = $profile;
					$profiles->next();
				} catch(\Exception $exception) {
					//if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
         return ($profile);
 }
/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
**/
public function jsonSerialize () {
	$fields = get_object_vars($this);
	unset ($fields["profileHash"]);
	unset ($fields["profileSalt"]);
	return ($fields);
	}

}