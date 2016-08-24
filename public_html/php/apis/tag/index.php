<?php

/*require once here - double check if dirname(_DIR_) is needed*/
require_once dirname(__DIR__, 2) . "autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once ("/etc/apache2/flek-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Tag;

/**
 * api for the tag class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/

// verify the session, start if not active
if(session_start() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

// huge try block and grabbing mySQL connection to .ini files
try {
    $pdo = connectToEncryptedMySQL("/etc/apache2/flek-mysql/tag.ini");
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

    // sanitize input
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    // TODO: check to see if I need $name here

    // ensuring the id is valid for methods that require it, no \ wack needed in InvalidArgumentException
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 405));
    }

    // handle GET request - if id is present, that Tag is returned
    if(method === "GET") {
        // set XSRF cookie
        setXsrfCookie();

        // get a specific tag or all tags and update reply
        if(empty($id) === false) {
            $tag = Tag::getTagByTagId($pdo, $id);
            if($tag !== null) {
                $reply->data = $tag;
            }
        } else {
            $tags = Tag::getsAllTags($pdo);
            if($tags !== null) {
                $reply->data = $tags;
            }
        }
    } else if($method === "PUT" || $method === "POST") {
        // give us Json string doesn't give us object yet, only json encode
        verifyXsrf();
        // "unpacking angular's Json
        $requestContent = file_get_contents("php://input");
        // get string, decode, and make into object
        $requestObject = json_decode($requestContent);

        // make sure the Tag name is available
        if(empty($requestObject->tagName) === true) {
            throw(new \InvalidArgumentException("No tag name.", 405));
        }

        // perform the actual put or post
        if($method = "PUT") {

            // retrieve the tag to update
            $tag = Tag::getTagByTagId($pdo, $id);
            if($tag === null) {
                throw(new RuntimeException("Tag does not exist", 404));
            }

            // update all attributes
            $tag->setTagName($requestObject->tagName);
            $tag->update($pdo);

            // update reply
            $reply->message = "Tag updated OK";
        } else if ($method === "POST") {

        }
    }
}

















