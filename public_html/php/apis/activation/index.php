<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Activation;

/**
 * api for Activation
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

try {
	//grab the mySQL connection
	$pdo =  connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//handle GET request - if id is present, that activation is returned, otherwise all activations are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
	//get the Sign up based on the given field

	}
}