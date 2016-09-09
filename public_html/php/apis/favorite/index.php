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

	// check if user is logged in
	//if(empty($_SESSION["profile"] === true)) {
	//throw (new \InvalidArgumentException("You must be logged in to favorite a profile"));


//session and object
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);
	//$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);
	//can i involve POST but cant expose the composite key ?

	if(($method === "DELETE") && (empty($favoriterId) || $favoriterId < 0)) {
		throw(new \InvalidArgumentException("favoriter id cannot be empty or negative", 405));
	} elseif($method === "DELETE" && ($method === "GET") && (empty($favoriteeId) || $favoriteeId < 0)) {
		throw(new \InvalidArgumentException("favoritee id cannot be null"));
	} elseif(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
		elseif($method === "PUT") {
		throw(new \InvalidArgumentException("This action is forbidden", 405));
	}
	if((empty($_SESSION["favorite"]) === false) && (($_SESSION["profile"]->getProfileId()) === $id)) {
	}
//----------------------------------GET--------------------------------

		// Handle all restful calls
		if($method === "GET") {
			// Set XSRF cookie
			setXsrfCookie("/");

			if(empty($id) === false) {
				$favorite = Edu\Cnm\Flek\Profile::getProfileByProfileId($pdo, $id);
				if($favorite !== null) {
					$reply->data = $favorite;
				}
			} //get favorite or all favorites and update reply
			elseif((!empty($favoriteeId)) && (!empty($favoriterId))) {
				$favorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($pdo, $favoriteeId, $favoriterId);
				if($favorite !== null) {
					$reply->data = $favorite;
				}
			} // Get a favorites from FavoriterId where favorites is the favoriteeId and update reply
			elseif(!empty($favoriterId)) {
				$favorites = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterId);
				if($favorites !== null) {
					$reply->data = $favorites;
				}
			}
			//else{
			//$favorites = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeIdAndFavoriterId($pdo, $profileId, $favoriteeId);
			//if($favoriterId !== null) {
			//$reply->data = $favorite;
			//}
		} //-------------------------POST------------------------------
		elseif($method === "POST") {
			// Set XSRF cookie
			verifyXsrf("/");

			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			// make sure the favorites are available
			if(empty($requestObject->favoriteeId) === true) {
				throw(new \InvalidArgumentException("no favoritee available", 405));
			}if(empty($requestObject->favoriterId) === true) {
			 throw(new \InvalidArgumentException("no favoriter available", 405));
			}

			// create new favorite and insert into the database
			$favorite = new Edu\Cnm\Flek\Favorite(null, $requestObject->getProfileId, $requestObject->favoriteeId, $requestObject->favoriterId);
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
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeId($pdo, $favoriteeId, $id);
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
