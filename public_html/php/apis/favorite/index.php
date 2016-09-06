<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Favorite;

/**
 * Api for Favorite class
 *
 * #author Diane Peshlakai <dpeshlakai3@cnm.edu>
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);
	//can i involve POST but cant expose the composite key ?
	if(($method === "DELETE") && (empty($favoriterid) === true || $favoriterid < 0)) {
		throw(new \InvalidArgumentException("favoriterid cannot be empty or negative", 405));
	}
//----------------------------------GET--------------------------------

	// Handle all restful calls
	if($method === "GET") {
		// Set XSRF cookie
		setXsrfCookie("/");
	}
// Get a specific favorite or all favorites and update reply
	if(empty($favoriterid) === false) {
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterid);
		if($favoriterId !== null) {
			$reply->data = $favorite;
		} else {
			$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterId);
			if($favoriterId !== null) {
				$reply->data = $favorite;
			}
		}
		//-------------------------POST------------------------------
	} elseif($method === "POST") {
			// Set XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// make sure favoriteeId and favoriterId are available
		if(empty($requestObject->favoriterId) === true && empty($requestObject->favoriterId) === true) {
			throw(new InvalidArgumentException("no receive or write id", 405));
		}
			// create new favorite and insert into the database
			$favorite = new Edu\Cnm\Flek\Favorite($requestObject->favoriterId, $requestObject->favoriteeId);
			$favorite->insert($pdo);
			// update reply
			$reply->message = "Favorite created OK";


		}
		// put the two favorites and update to create new one
		//$favorite->setFavoriteeId($requestObject->favoriteeId);
		//$favorite->setFavoriterId($requestObject->favoriterId);

		//but am i creating a new profile or FAVORITE ?
		//create new favorite Id and insert it into the database
		//$favorite = new Favorite(null, $requestObject->favoriterId, $_SESSION["favorite"]->getFavoriterId());
		//$favorite->insert($pdo);

		//$reply->message = "favoriter has been created";
//-------------------------------DELETE--------------------------------
	else if($method === "DELETE")	{
	verifyXsrf();
	// Retrieve the Favorite to be deleted
	$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterId);
	if($favorite === null) {
		throw(new RuntimeException("the favorite given does not exist", 404));
	}

	// Delete favorite
	$favorite->delete($pdo);

	$deletedObject = new stdClass();
	// Update reply
	$reply->message = "Favorite deleted OK";

} else{
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}

	// Update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// Encode and return reply to front end caller
echo json_encode($reply);
