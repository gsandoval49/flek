<?php

/**
 * Capstone project Image API utilizing Cloudinary
 * based on code authored by lbaca152 from scrum meetings with DeepDiveDylan, dbeets, and raul-villarreal
 ***/

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 4) . "/vendor/autoload.php";


/**
 * // * these are required for cloudinary
 * // * */
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

	// this is code from Dylan we got after we update our .ini file
	$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

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
		setXsrfCookie();

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
	}

	/*
			//this is a check to make sure only a profile type of ADMIN or OWNER can make changes
			//could also check for the reverse and throw an exception in that case
			//DO we need this?
		} elseif((empty($_SESSION["profile"]) === false) && (($_SESSION["profile"]->getProfileId()) === $id) && (($_SESSION["profile"]->getProfileType()) === "a") || (($_SESSION["profile"]->getProfileType())) === "o") {*/

	if($method === "POST") {
		verifyXsrf();
		$imageDescription = filter_input(INPUT_POST, "imageDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$imageGenreId = filter_input(INPUT_POST, "imageGenreId", FILTER_VALIDATE_INT);
		$imageSecureUrl = filter_input(INPUT_POST, "imageSecureUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$imagePublicId = filter_input(INPUT_POST, "imagePublicId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$tags = filter_input(INPUT_POST, "tags", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//make sure the image foreign key is available (required field)
		if($imageGenreId === null) {
			throw(new \InvalidArgumentException("The foreign key does not exist", 405));
		}

		//assigning variables to the user image name, MIME type, and image extension
		$tempUserFileName = $_FILES["userImage"]["tmp_name"]; //tmp_name is the actual name on the server that is uploaded, has nothing to do with user file name
		//file that lives in tmp_name will auto delete when this is all over
		$userFileType = $_FILES["userImage"]["type"];
		$userFileExtension = strtolower(strrchr($_FILES["userImage"]["name"], "."));
		var_dump($_FILES);

		// send the image to cloudinary NOW
		// this is an art site FFS!
		\Cloudinary\Uploader::upload($_FILES["file"]["tmp_name"]);
		/*echo cl_image_upload_tag("image_id",
			array(
				"callback" => $cors_location,
				"tags" => "directly_uploaded",
				"crop" => "limit", "width" => 1000, "height" => 1000,
				"eager" => array("crop" => "fill", "width" => 150, "height" => 100),
				"html" => array("style" => "margin-top: 30px")
			));*/


// after sending the image to cloudinary, get the URL and public ids
		// now, you can insert an image object

		//--unsure how to retrieve IMAGESECUREURL or IMAGEPUBLICID from cloudinary, checking to see if null(?)
		if(($imagePublicId !== null) && ($imageSecureUrl !== null)) {
			$image->insert($pdo);
		}

		$tags = explode(" ", $tags);
		foreach($tags as $tag) {
			// search for the tag in the database
			if(empty($tag) === true) {
				// create a new tag if none exists
				$tag->insert($pdo);
			}
			// finally, create an image tag

			$imageTag->insert($pdo);

		}


		$reply->message = "Image uploaded";

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

