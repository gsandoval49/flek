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

	//make sure the id is valid for methods that require it
	if($method === "GET" || $method === "PUT") && (empty($id) === true || $id < 0) {
		throw(new InvalidArgumentException(("id cannot be empty or negative", 405));
	}

	//handle GET request - if id is present, that
}