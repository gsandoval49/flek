<?php

require_once (dirname(__DIR__, 2) . "/classes/autoload.php");
require_once (dirname(__DIR__, 2) . "/lib/xsrf.php");
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
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);

	if(($method === "DELETE" || $method === "POST") && (empty($favoriterid) === true || $favoriterid < 0)) {
		throw(new InvalidArgumentException("favoriterid cannot be empty or negative", 405));
	} elseif($method = "PUT") {
		throw(new InvalidArgumentException ("This action is forbidden", 405));
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
			$favorite = Favorite::getFavoriteByFavoriterId($pdo);
			if($favorite !== null) {
				$reply->data = $favorite;
			}
		}
		//-------------------------POST------------------------------
	} elseif($method === "POST") {

// Set XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// Make sure profile is available
		if(empty($requestObject->favoriteeId) === true) {
			throw(new InvalidArgumentException ("favoritee cannot be empty", 405));
		}
		if(empty($requestObject->favoriterId) === true) {
			throw(new InvalidArgumentException("favoriter cannot be empty", 405));
		}
		// put the two favorites and update to create new one
		//$favorite->setFavoriteeId($requestObject->favoriteeId);
		//$favorite->setFavoriterId($requestObject->favoriterId);

		//but am i creating a new profile or FAVORITE ?
		//create new favorite Id and insert it into the database
		$favorite = new Favorite(null, $requestObject->favoriterId, $_SESSION["favorite"]->getFavoriterId());
		$favorite->insert($pdo);

		$reply->message = "favoriter has been created";
	}

//-------------------------------DELETE--------------------------------
	elseif($method === "DELETE")	{
	verifyXsrf();
	// Retrieve the Favorite to be deleted
	$favorite = Favorite::getFavoriteByFavoriterId($pdo, $favoriterId);
	if($favorite === null) {
		throw(new RuntimeException("the favorite given does not exist", 404));
	}

	// Delete favorite
	$favorite->delete($pdo);

	$deletedObject = new stdClass();
	// Update reply
	$reply->message = "Favorite deleted OK";

} else{
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

	// Update reply with exception information
} catch(Exception $exception) {
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

// Encode and return reply to front end caller
echo json_encode($reply);
