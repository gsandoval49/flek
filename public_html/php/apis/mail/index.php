<?php

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 4) . "/vendor/autoload.php";

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

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/flek.ini");

	//mailgun configuration that Dylan sent me. We're getting mailgun config
	$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
	$mailgun = json_decode($config["mailgun"]);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$mailSenderId = filter_input(INPUT_GET, "mailSenderId", FILTER_VALIDATE_INT);
	$mailReceiverId = filter_input(INPUT_GET, "mailReceiverId", FILTER_VALIDATE_INT);

	// must be logged in to get messages
	if(empty($_SESSION["profile"]) === true) {
		throw(new \InvalidArgumentException("you must be logged in"));
	}
	// need to call on profiles and verify
	// handle GET request - just kick them out
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		// verfified signed in user and if signed in, can see messages you've sent/received. If not throw exception.
		// get primary key or give them everything for messages.
		if(empty($id) === false) {
			$mail = Mail::getMailByMailId($pdo, $id);
			if($_SESSION["profile"]->getProfileId() === $mail->getMailSenderId() || $_SESSION["profile"]->getProfileId() === $mail->getMailReceiverId()) {
				$reply->data = $mail;
			} else {
				throw(new \InvalidArgumentException("Invalid login to access messages"));
			}
		} else if(empty ($mailReceiverId) === false) {
			$mails = Mail::getMailByMailReceiverId($pdo, $mailReceiverId)->toArray();
			$toSend = [];
			foreach($mails as $mail) {
				if($_SESSION["profile"]->getProfileId() === $mail->getMailSenderId() || $_SESSION["profile"]->getProfileId() === $mail->getMailReceiverId()) {
					$toSend[] = $mail;
				} else {
					throw(new \InvalidArgumentException("Invalid login to access messages"));
				}
			}
			$reply->data = $toSend;
		} else if(empty ($mailSenderId) === false) {
			$mails = Mail::getMailByMailSenderId($pdo, $mailSenderId)->toArray();
			$toSend = [];
			foreach($mails as $mail) {
				if($_SESSION["profile"]->getProfileId() === $mail->getMailSenderId() || $_SESSION["profile"]->getProfileId() === $mail->getMailReceiverId()) {
					$toSend[] = $mail;
				} else {
					throw(new \InvalidArgumentException("Invalid login to access messages"));
				}
			}
			$reply->data = $toSend;
		} else {
			$reply->data; // do wel call data === "mails"
		}
	}
	// moved closed bracket here as part of GET code

	// TODO
	// CHECK IDs - angular will give PKs. from profile class, you can do a database call.
	// grab 2 profiles angular will get for sender & receiver


	/* SHOULD THIS BE AN "ELSE IF" OR "IF" */
	else if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// throw out blank fields
		if(empty($requestObject->senderName) === true) {
			throw(new \InvalidArgumentException("your name is required", 400));
		}
		if(empty($requestObject->senderEmail) === true) {
			throw(new \InvalidArgumentException("email is required", 400));
		}
		if(empty($requestObject->receiverName) === true) {
			throw(new \InvalidArgumentException("receiver name is required", 400));
		}
		if(empty($requestObject->receiverEmail) === true) {
			throw(new \InvalidArgumentException("receiver email is required", 400));
		}
		if(empty($requestObject->subject) === true) {
			throw(new \InvalidArgumentException("subject is required", 400));
		}
		if(empty($requestObject->message) === true) {
			throw(new \InvalidArgumentException("message is required", 400));
		}

		// for both sender AND receiver:
		// grab the profile by Email
		// if either are null, throw an exception
		if(Profile::getProfileByProfileEmail($pdo, $requestObject->senderEmail) === null) {
			throw(new \InvalidArgumentException("email is invalid"));
		}
		if(Profile::getProfileByProfileEmail($pdo, $requestObject->receiverEmail) === null) {
			throw(new \InvalidArgumentException("email is invalid"));
		}

		// start the mailgun client
		$client = new \Http\Adapter\Guzzle6\Client();
		$mailGunslinger = new \Mailgun\Mailgun($mailgun->apiKey, $client);

		// send the message
		$result = $mailGunslinger->sendMessage($mailgun->domain, [
				"from" => $requestObject->senderName . "<" . $requestObject->senderEmail . ">",
				"to" => $requestObject->receiverName . "<" . $requestObject->receiverEmail . ">",
				"subject" => $requestObject->subject,
				"text" => $requestObject->message
			]
		);


		// inform the user of the result
		/*if($result->http_response_code !== 200) {
			throw(new RuntimeException("unable to send email", $result->http_response_code));
		}
		$reply->message = "Your message has been sent.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request", 405));*/
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