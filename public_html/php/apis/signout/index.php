<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Profile;

/**
 * api for Signout
 *
 * @author Christina Sosa <csosa4@cnm.edu>
 **/
//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");
	//determine which HTTP method was used

}