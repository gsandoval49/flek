<?php

/*require once here - double check if dirname(_DIR_) is needed*/
require_once dirname(__DIR__, 2) . "classes/autoload.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/flek-mysql/encrypted-config.php");

use Edu\Cnm\Flek;

/**
 * api for the tag class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/

// verify the session, start if not active
if(session_start() !== PHP_SESSION_ACTIVE) {
    session_start();
}



