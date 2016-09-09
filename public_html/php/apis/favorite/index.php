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
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId", FILTER_VALIDATE_INT);

	if($method === "DELETE" && (empty($favoriteeId) || $favoriteeId < 0)) {
		throw(new \InvalidArgumentException("favoritee id cannot be null"));
	}
		elseif($method === "PUT") {
		throw(new \InvalidArgumentException("This action is forbidden", 405));
	}
	if((empty($_SESSION["profile"]) === true)) {
		throw(new \InvalidArgumentException("You are not allowed to favorite without signing in"));
	}
//----------------------------------GET--------------------------------

		// Handle all restful calls
		if($method === "GET") {
			// Set XSRF cookie
			setXsrfCookie();

			 //get favorite or all favorites and update reply
			if((!empty($favoriteeId)) && (!empty($favoriterId))) {
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
			}elseif(!empty($favoriteeId)) {
				$favorites = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeId($pdo, $favoriteeId);
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
			if(empty($_SESSION["profile"]) === true) {
				setXsrfCookie("/");
				throw(new \RuntimeException("Not logged in. Please log-in or sign-up."));
			} else if(empty ($_SESSION["profile"]) !== true) {
				// Set XSRF cookie
				verifyXsrf();

				$requestContent = file_get_contents("php://input");
				$requestObject = json_decode($requestContent);

				//  make sure favoriteeId and favoriterId are available
				if(empty($requestObject->favoriteeId) === true || empty($_SESSION["profile"]) === true) {
					throw(new \InvalidArgumentException ("Favorite doesn't exist.", 405));
				}
				if(empty($_SESSION["profile"]->getProfileId()) === true) {
					throw(new \InvalidArgumentException("Favorite must be linked to profile", 405));
				}
				// create new favorite and insert into the database
				$reply->favoriterId=$_SESSION["profile"]->getProfileId();

				$favorite = new Edu\Cnm\Flek\Favorite($requestObject->favoriteeId, $_SESSION["profile"]->getProfileId());
				$favorite->insert($pdo);
				// update reply
				$reply->message = "Favorite created OK";

			}
			//but am i creating a new profile or FAVORITE ?
			//create new favorite Id and insert it into the database
			//$favorite = new Favorite(null, $requestObject->favoriterId, $_SESSION["favorite"]->getFavoriterId());
			//$favorite->insert($pdo);
		}
//-------------------------------DELETE--------------------------------
	else if($method === "DELETE") {
		verifyXsrf();
		// Retrieve the Favorite to be deleted
		$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriteeIdAndFavoriterId($pdo, $favoriteeId, $_SESSION["profile"]->getProfileId());
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
