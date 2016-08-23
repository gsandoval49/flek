<?php

/**
 * Created by PhpStorm.
 * User: robis_000
 * Date: 8/22/2016
 * Time: 9:14 PM
 */
require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/flek-mysql/encrypted-config.php");

use Edu\Cnm\Flek\(Image);


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

	$pdo = connectToEncryptedMySQL("/etc/apache2/flek-mysql/image.ini");


}


