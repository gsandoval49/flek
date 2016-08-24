<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Flek\Profile;

/**
 * api for signin
 *
 * @author Christina Sosa <csosa4@cnm.edu>
**/
//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

