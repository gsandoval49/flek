<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Flek\Profile;

/**
 * api for signin
 *
 * @author Christina Sosa <csosa4@cnm.edu>
**/
//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//perform the post
	if($method === "POST") {
		//verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check that the necessary fields have been sent and filter
		if(empty($requestObject->profileEmail) === true) {
			throw(new InvalidArgumentException("Invalid email address."));
		} else {
			$email = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new InvalidArgumentException("Must enter a password."));
		} else {
			$password = filter_var($requestObject->profilePassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		//create a profile $profile = Profile::getProfileByProfileEmail($pdo, $email);
		if(empty($profile)) {
			throw(new InvalidArgumentException("Invalid Email"));
		}
		//hash for $password
		$hash = hash_pbkdf2("sha512", "abc123", $this->$salt, 262144);
		//verify hash is correct
		if($hash !== $profile->getProfileHash()) {
			throw(new \InvalidArgumentException("Password or email is incorrect."));
		}

	}
}

