<?php

/* need to write method to create and insert genre to mySQL database*/

/*require once here - double check if dirname(_DIR_) is needed*/
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\Flek\Genre;


/**
 * api for Genre class
 *
 * @author Rob Harding
 **/


// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;


try {
	//grab the mySQL connection

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	$reply->method = $method;

	//sanitize the input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($method === "GET") && (empty($id) === true || $id < 0)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}

// handle GET request - if id is present, that genre is returned, otherwise all genres are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific genre or all genres and update reply
		if(empty($id) === false) {
			$genre = Genre::getGenreByGenreId($pdo, $id);
			if($genre !== null) {
				$reply->data = $genre;
			}
		} else if(empty($profileId) === false) {
			$genres = Genre::getGenreByGenreName($pdo, $name);
			if($genres !== null) {
				$reply->data = $genres;
			}

		}
	} else {
		$genres = Genre::getAllGenres($pdo);
		if($genres !== null) {
			$reply->data = $genres;
		}
	}  {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
}
		// update reply with exception information
	 catch(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	} catch(TypeError $typeError) {
		$reply->status = $typeError->getCode();
		$reply->message = $typeError->getMessage();
	}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);