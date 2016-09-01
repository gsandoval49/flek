<?php
require_once __DIR__ . "/vendor/autoload.php";
/*require_once __DIR__ . "/facebook-sdk-v5/autoload.php";*/
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Flek;

/**___________________________________

                    Light PHP wrapper for the OAuth 2.0
___________________________________


AUTHOR & CONTACT
================

Charron Pierrick
- pierrick@webstart.fr

Berejeb Anis
- anis.berejeb@gmail.com


DOCUMENTATION & DOWNLOAD
========================

Latest version is available on github at :
    - https://github.com/adoy/PHP-OAuth2

Documentation can be found on :
    - https://github.com/adoy/PHP-OAuth2


LICENSE
=======

This Code is released under the GNU LGPL

Please do not change the header of the file(s).

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published
by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
or FITNESS FOR A PARTICULAR PURPOSE.

See the GNU Lesser General Public License for more details.


How can I use it ?
==================**/

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;
try {
$pdo = connectToEncryptedMySQL("etc/apache2/capstone-mysql/flek.ini");
	$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");

	$oauth = json_decode($config["oauth"]);

const REDIRECT_URI = 'https://bootcamp-coders.cnm.edu/~csosa4/flek/public_html/php/apis/facebook-signup/';
const AUTHORIZATION_ENDPOINT = 'https://graph.facebook.com/oauth/authorize';
const TOKEN_ENDPOINT = 'https://graph.facebook.com/oauth/access_token';

$client = new \OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
	$auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
	header('Location: ' . $auth_url);
	die('Redirect');
}
else
{
	$params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
	$response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
	parse_str($response['result'], $info);
	$client->setAccessToken($info['access_token']);
	$response = $client->fetch('https://graph.facebook.com/me');
	var_dump($response, $response['result']);
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);






