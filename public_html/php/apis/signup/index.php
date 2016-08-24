<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Profile;

/**
 * api for signup
 *
 * @author Christina Sosa <csosa4@cnm.edu>; referenced Derek Mauldin <derek.e.mauldin@gmail.com>
**/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER
	["REQUEST_METHOD"];
	$reply->method = $method;
	if($method === "POST") {
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check that the user fields that are required have been sent
		if(empty($requestObject->profileName) === true) {
			throw(new InvalidArgumentException("Must fill in first and last name."));
		} else {
			$profileName = filter_var($requestObject->profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		if(empty($requestObject->profileEmail) === true) {
			throw(new InvalidArgumentException("Must fill in email address."));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		if(empty($requestObject->profileLocation) ===true) {
			throw(new InvalidArgumentException("Must fill in location."));
		} else {
			$profileLocation = filter_var($requestObject->profileLocation, FILTER_SANITIZE_STRING,
				FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		if(empty($requestObject->password) ===true) {
			throw(new InvalidArgumentException("Must fill in password."));
		} else {
			$password = filter_var($requestObject->password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}
		$hash = hash_pbkdf2("sha512", "abc123", $this->$salt, 262144);
		$salt = bin2hex(random_bytes(32));
		$profileAccessToken = bin2hex(random_bytes(16));
		$profileActivationToken = bin2hex(random_bytes(16));
		$profile = new Flek\Profile(null, null, $profileAccessToken, $profileActivationToken, $profileName, $profileEmail, $profileLocation);
		$profile->insert($pdo);
		$messageSubject = "Flek Account Activation";

//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
//FIXME: make sure URL is /public_html/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 4);
		$urlglue = $basePath . "/activation/" . $activation;
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		$message = <<< EOF
<h2>Welcome to Flek!</h2>
<p>Please visit the following URL to set a new password and complete the sign-up process: </p>
EOF;

	}
}