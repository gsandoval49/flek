<?php


require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek;

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
	$favoriteeId = filter_input(INPUT_GET, "favoriteeId" ,FILTER_VALIDATE_INT);
	$favoriterId = filter_input(INPUT_GET, "favoriterId" ,FILTER_VALIDATE_INT);

	if($method === "GET" || $method === "DELETE") && (empty($favoriteeid) === true || $favoriteeid < 0) {
		throw(new InvalidArgumentException(("favoriteeid cannot be empty or negative", 405));
}

//----------------------------------GET--------------------------------


			// Handle all restful calls
	if($method === "GET") {
		// Set XSRF cookie
		setXsrfCookie("/");
	}
// Get a specific favorite or all favorites and update reply
		if(empty($favoriterid) === false) {
			$favorite = Edu\Cnm\Flek\Favorite::getFavoriteByFavoriterId($pdo, $favoriteeid);
			if($favoriterId !== null) {
				$reply->data = $favoriterId;
			} else {
				$profiles = Flek\Profile::getAllProfiles($pdo);
				if($profiles !== null) {
					$reply->data = $profiles;
				}
			}
		}	elseif($method === "POST") {

// Set XSRF cookie
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);
		}
		// Make sure profile is available
		if(empty($requestObject->profileId) === true) {
			throw(new InvalidArgumentException ("profile cannot be empty", 405));
		}

	//Get All profiles then update it
		 else {
			 $profiles = Flek\Profile::getAllProfiles($pdo);
			 if($profiles !== null) {
				 $reply->data = $profiles;
			 }
		 }

			//create new favorite Id and insert it into the database
			$favorite = new Flek\Favorite(null, $requestObject->profileId, $_SESSION["profile"]->getProfileId(), );
			$favorite->insert($pdo);
			$reply->message = "profile id has been created";


} else if($method === "DELETE") {
	verifyXsrf();
	// Retrieve the Favorite to be deleted
	$favorite = Flek\Favorite::getFavoriteByProfileId($pdo, $id);
	if($favorite === null) {
		throw(new RuntimeException("Favorite does not exist", 404));
	}
	// Delete favorite
	$favorite->delete($pdo);
	$deletedObject = new stdClass();
	// Update reply
	$reply->message = "Favorite deleted OK";
} else {
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
