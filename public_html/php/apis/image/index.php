<?php

/**
 * Capstone project Image API utilizing Cloudinary
 * based on code authored by lbaca152 from scrum meetings with DeepDiveDylan, dbeets, and raul-villarreal
 **/

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//
///**
// * these are required for cloudinary
// * */
//require 'Cloudinary.php';
//require 'Uploader.php';
//require 'Api.php';

use Edu\Cnm\Flek\{
	Image, Profile, Tag, Genre
};


/**
 * api for Image class
 *
 * POST - use the files array to send image to cloudinary
 * GET - get the meta-data from cloudinary instead of the image itself
 * DELETE - delete image
 *
 * @author Rob Harding
 * @version 1.0.0
 **/


//verify the session, start one if not active

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}


//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

//begin try section

try {
	//grab mySQL connection

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP-METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$imageProfileId = filter_input(INPUT_GET, "imageProfileId", FILTER_VALIDATE_INT);
	$imageDescription = filter_input(INPUT_GET, "imageDescription", FILTER_SANITIZE_STRING);
	$imageSecureUrl = filter_input(INPUT_GET, "imageSecureUrl", FILTER_SANITIZE_STRING);
	/*this is a string(?)*/
	$imagePublicId = filter_input(INPUT_GET, "imagePublicId", FILTER_SANITIZE_STRING);

	//make sure the id is valid for methods that require it, the id is the primary key
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET request. if a imageId is present, that image is returned, otherwise all images are returned
	if($method === "GET") {
//		set XSRF cookie
		setXsrfCookie("/");

		//get a specific image or all images and update reply
		if(empty($id) === false) {
			$image = Image::getImageByImageId($pdo, $id);
			if($image !== null) {
				$reply->data = $image;
			}

		} elseif(empty($profile) === false) {
			$image = Image::getImageByImageProfileId($pdo, $imageProfileId);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif(empty($imageDescription) === false) {
			$image = Image::getImagebyImageDescription($pdo, $imageDescription);
			if($image !== null) {
				$reply->data = $image;
			}
		} //DO we need to include secure url and public id
		else {
			$images = Image::getAllImages($pdo);
			if($images !== null) {
				$reply->data = $images;
			}
		}

		/*
				//this is a check to make sure only a profile type of ADMIN or OWNER can make changes
				//could also check for the reverse and throw an exception in that case
				//DO we need this?
			} elseif((empty($_SESSION["profile"]) === false) && (($_SESSION["profile"]->getProfileId()) === $id) && (($_SESSION["profile"]->getProfileType()) === "a") || (($_SESSION["profile"]->getProfileType())) === "o") {*/

		if($method === "POST") {
			verifyXsrf();
			$imageDescription = filter_input(INPUT_POST, "imageDescription", FILTER_SANITIZE_STRING);
			$imageGenreId = filter_input(INPUT_POST, $imageGenreId, FILTER_SANITIZE_INT);
			$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING);
/*
			//make sure the image foreign key is available (required field)
			if((empty(($imageId)) === true) || (empty($imageGenreId)) === true) {
				throw(new \InvalidArgumentException("The foreign key does not exist", 405));
			}*/



				//assigning variables to the user image name, MIME type, and image extension
				$tempUserFileName = $_FILES["userImage"]["tmp_name"]; //tmp_name is the actual name on the server that is uploaded, has nothing to do with user file name
				//file that lives in tmp_name will auto delete when this is all over
				$userFileType = $_FILES["userImage"]["type"];
				$userFileExtension = strtolower(strrchr($_FILES["userImage"]["name"], "."));


				$tags = explode("tags",FILTER_SANITIZE_STRING);
				foreach($tags as $tag) {
					if(empty($tag) === true) {
						$tag->insert($pdo);
					}
				}


				$reply->message = "Image created";

		} elseif($method === "DELETE") {
			verifyXsrf();
			//get image to be deleted by the IDimage
			$image = Image::getImageByImageId($pdo, $id);

			//check if image is empty
			if($image === null) {
				throw(new RuntimeException("Image does not exist!"));
			}
			//we don't need to delete from the server because Cloudinary is on the cloud
			/*unlink($image->getImageFileName()); //this will delete from the server*/

			$image->delete($pdo);

			$reply->message = "Image deleted";


		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}

	}
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

// encode and return reply to front end caller
echo json_encode($reply);

