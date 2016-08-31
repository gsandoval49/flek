<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Flek\Mail;

//we added this. does this need to be here?
use Edu\Cnm\Flek\Profile;


//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//mailgun configuration that Dylan sent me. We're getting mailgun config
	$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
	$mailgun = json_decode($config["mailgun"]);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// handle GET request - just kick them out
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		// TODO
		// verfified signed in user and if signed in, can see messages you've sent/received. If not throw exception.
		// get primary key or give them everything for messages.

		// TODO
		// CHECK IDs - angular will give PKs. from profile class, you can do a database call.
		// grab 2 profiles angular will get for sender & receiver


	} else if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		// throw out blank fields
		if(empty($requestObject->subject) === true) {
			throw(new \InvalidArgumentException("subject is required", 400));
		}
		if(empty($requestObject->message) === true) {
			throw(new \InvalidArgumentException("message is required", 400));
		}

		// start the mailgun client
		$client = new \Http\Adapter\Guzzle6\Client();
		$mailGunslinger = new \Mailgun\Mailgun($mailgun->apiKey, $client);

		// send the message
		$result = $mailGunslinger->sendMessage($mailgun->domain, [
				// TODO change after profiles
				"from" => "$name <$email>",
				"to" => "foo@example.com",
				"subject" => $requestObject->subject,
				"text" => $requestObject->message
			]
		);

		// inform the user of the result
		if($result->http_response_code !== 200) {
			throw(new RuntimeException("unable to send email", $result->http_response_code));
		}
		$reply->message = "Your message has been sent.";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request", 405));
	}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);