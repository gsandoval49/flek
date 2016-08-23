<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/flek-mysql/encrypted-config.php");

use Edu\Cnm\Flek\(Profile);

/**
 * api for Profile class
 *
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptMySQL("/etc/apache2/flek-mysql/profile.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$name = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$email = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$location = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	// DO WE ALSO GET PASSWORD ?

	//make sure the primary key is valid for methods that require it
	if($method === "GET" || $method === "PUT") && (empty($id) === true || $id < 0) {
		throw(new InvalidArgumentException(("id cannot be empty or negative", 405));
	}

	//make sure the profile name is valid for methods that require it
	if($method === "GET" || $method === "PUT") && (empty($profile) === true || $profile < 0) {
		throw(new InvalidArgumentException(("profile cannot be empty or negative", 405));
	}

	//make sure the email is valid for methods that require it
	if($method === "GET" || $method === "PUT") && (empty($email) === true || $location < 0) {
		throw(new InvalidArgumentException(("location cannot be empty or negative", 405));
	}

	//----------------------GET---------------------------------
	elseif((empty($_SESSION["profile"]) === false) && (($_SESSION["profile"]->getProfileId()) === $id));

	//Get profile by profile id then update it
	if(empty($id) === false) {
		$profile = Flek\profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profiles;
			}
	//Get profile by Name then update it
	if(empty($name) === false) {
		$name = Flek\profile::getProfileByProfileName($pdo, $name);
		if($profile !== null) {
			$reply->data = $profiles;
		}

		//Get profile by Email and then update it
		if(empty($email) === false) {
			$email = Flek\profile::getProfileByProfileEmail($pdo, $email);
			if($profile !== null) {
				$reply->data = $profiles;
			}

			//Get All profiles then update it
		} else {
			$profiles = Flek\Profile::getAllProfiles($pdo);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		}
		//----------------------PUT---------------------------------
	elseif
		((empty($_SESSION["profile"]) === false) && (($_SESSION["profile"]->getProfileId()) === $id));
	}
	else if ($method === "PUT") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");

		$requestObject = json_decode($requestContent);

		//make sure name of the profile is available
		if(empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("No profile name for Profile", 405));
		}

		//make sure profile id is available
		if(empty($requestObject->profileId) === true) {
			throw(new \InvalidArgumentException("No profile id for Profile", 405));
	}

		// Retrieve the profile that will be updated in this PUT.
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("The profile does not exist", 404));
		}
		//put Profile attributes into the profile and update
		$profile->setProfileId($requestObject->profileId);
		$profile->setProfileName($requestObject->profileName);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->update($pdo);

		//update reply
		$reply->message = "Profile updated ok";







		// make sure profile name is available
		if(empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("No profile name for Profile", 405));
	}






