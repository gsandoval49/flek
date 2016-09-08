<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\{
	Favorite, Profile
};

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

//session and object
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);
	//can i involve POST but cant expose the composite key ?
	if(($method === "DELETE") && (empty($profileId === null || $profileId < 0 || $id === null || $id < 0))) {
		throw(new \InvalidArgumentException("favoriterid cannot be empty or negative", 405));
	} elseif($method === "PUT") {
		throw(new \InvalidArgumentException("This action is forbidden", 405));
	}

//----------------------------------GET--------------------------------

	// Handle all restful calls
	if($method === "GET") {
		// Set XSRF cookie
		setXsrfCookie("/");

		//get favorite or all favorites and update reply
		if(empty($favoriteeId) === false && empty($favoriterId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($pdo, $favoriteeId, $favoriterId);
			if($favorite !== null) {
				$reply->data = $favorite;
			}
		} // Get a favorites from FavoriterId where favorites is the favoriteeId and update reply
		elseif(empty($favoriteeid) === false) {
			$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriteeid);
			if($favorite !== null) {
				$reply->data = $favorite;
			}
		}
		//else{
		//$favorites = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeIdAndFavoriterId($pdo, $favoriterId, $favoriteeId);
		//if($favoriterId !== null) {
		//$reply->data = $favorite;
		//}


		//-------------------------POST------------------------------
	} elseif($method === "POST") {
		// Set XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//make sure favorite profile is available
		//request object...whatever is on the angular form....

		// make sure profileId are available
		if(empty($requestObject->favoriteeId) === true) {
			throw(new InvalidArgumentException("no favorite available", 405));
		}
		//if(empty($requestObject->id) === true) {
		//throw(new InvalidArgumentException("no profile available", 405));
		//}
		//created new profile and insert into database
		//$profile = new Profile(null, $requestObject->profileEmail, $requestObject->profileLocation, $requestObject->profileBio, $hash, $salt, $profileAccessToken, $profileActivationToken);
		//$profile->insert($pdo);

		// create new favorite and insert into the database
		$favorite = new Edu\Cnm\Flek\Favorite(null, $requestObject->getProfileId, $requestObject->getId);
		$favorite->insert($pdo);
		// update reply
		$reply->message = "Favorite created OK";

	}
	//but am i creating a new profile or FAVORITE ?
	//create new favorite Id and insert it into the database
	//$favorite = new Favorite(null, $requestObject->favoriterId, $_SESSION["favorite"]->getFavoriterId());
	//$favorite->insert($pdo);

//-------------------------------DELETE--------------------------------
	else if($method === "DELETE") {
		verifyXsrf();
		// Retrieve the Favorite to be deleted
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeId($pdo, $profileId, $id);
		if($favorite === null) {
			throw(new RuntimeException("the favorite given does not exist", 404));
		}
		// delete favorite
		$favorite->delete($pdo);
		// update reply
		$reply->message = "Unfavorite OK";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request"));


	}
	// Delete favorite
	//$favorite->delete($pdo);

	//$deletedObject = new stdClass();
	// Update reply
	//$reply->message = "Favorite deleted OK";


	// Update reply with exception information
} catch
(Exception $exception) {
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
