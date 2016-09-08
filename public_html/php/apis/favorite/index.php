<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\ {
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
	$profile = filter_input(INPUT_GET, "profile", FILTER_VALIDATE_INT);
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId", FILTER_VALIDATE_INT);
	//can i involve POST but cant expose the composite key ?
	if(($method === "DELETE") && (empty($favoriterid) === true || $favoriterid < 0)) {
		throw(new \InvalidArgumentException("favoriterid cannot be empty or negative", 405));
	}
	elseif(($method === "PUT")) {
		throw(new \InvalidArgumentException("This action is forbidden", 405));
	}
//----------------------------------GET--------------------------------

	// Handle all restful calls
	if($method === "GET") {
		// Set XSRF cookie
		setXsrfCookie("/");
	}
// Get a specific favorite or all favorites and update reply
	if(empty($favoriterid) === false) {
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterid, $profile);
		if($favorite !== null) {
			$reply->data = $favorite;
		} elseif((empty($profile)) === false) {
			$favorite = Edu\Cnm\Flek\Favorite::getProfileByProfileId($pdo, $profile);
			if($profile !== null) {
				$reply->data = $favorite;
			}
		}
		//-------------------------POST------------------------------
	} elseif($method === "POST") {
		// Set XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//make sure favorite profile is available
		//request object...whatever is on the angular form....
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("need to input profile email.", 405));
		}
		if(empty($requestObject->profileBio) === true) {
			throw(new \InvalidArgumentException("need to input profile biography.", 405));
		}
		if(empty($requestObject->profileLocation) === true) {
			throw(new \InvalidArgumentException("Need to insert profile location.", 405));
		}
		// make sure favoriteeId are available
		if(empty($requestObject->favoriterId) === true) {
			throw(new InvalidArgumentException("no receive or write id", 405));
		}
		//created new profile and insert into database
		$profile = new Profile(null, $requestObject->profileEmail, $requestObject->profileLocation, $requestObject->profileBio, $hash, $salt, $profileAccessToken, $profileActivationToken);
		$profile->insert($pdo);

		// create new favorite and insert into the database
		$favorite = new Edu\Cnm\Flek\Favorite($requestObject->favoriterId, $requestObject->getProfileId);
		$favorite->insert($pdo);
		// update reply
		$reply->message = "Favorite created OK";
	}

	//but am i creating a new profile or FAVORITE ?
	//create new favorite Id and insert it into the database
	//$favorite = new Favorite(null, $requestObject->favoriterId, $_SESSION["favorite"]->getFavoriterId());
	//$favorite->insert($pdo);

	//$reply->message = "favoriter has been created";
//-------------------------------DELETE--------------------------------
	else if($method === "DELETE") {
		verifyXsrf();
		// Retrieve the Favorite to be deleted
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriterId);
		if($favorite === null) {
			throw(new RuntimeException("the favorite given does not exist", 404));
		} elseif($method === "DELETE") {
			verifyXsrf();
			// retrieve the favorite to be deleted
			$favorite = Edu\Cnm\Flek\Favorite::getFavoriteeIdAndgetFavoriterId($pdo, $favoriteeId, $favoriterId);
			if($favorite === null) {
				throw(new RuntimeException("favorite does not exist", 404));
			}
			// delete favorite
			$favorite->delete($pdo);
			// update reply
			$reply->message = "Favorite deleted OK";
		} else {
			throw(new InvalidArgumentException("Invalid HTTP method request"));
		}


	}
		// Delete favorite
	//$favorite->delete($pdo);

	//$deletedObject = new stdClass();
	// Update reply
	//$reply->message = "Favorite deleted OK";


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
