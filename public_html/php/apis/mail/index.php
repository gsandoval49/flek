<?php

/**
 * function for the mailGunner class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/

require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Cnm\Edu\Flek;

$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
$mailgun = json_decode($config["mailgun"]);

// now $mailgun->domain and $mailgun->apiKey exist - locates key.
require_once(dirname(__DIR__, 6) . "/vendor/autoload.php");


/* old mailgunner code here replaced by documentation code - this code instantiates the client*/
$mgClient = new Mailgun('mailgun');
$domain = "YOUR_DOMAIN_NAME";

$mgClient = new Mailgun("mailgun");
$domain = "FLEKS_DOMAIN_NAME";

// Now, compose and send your message.
$mgClient->sendMessage($domain,
    array("from" => "Dwight Schrute <dwight@example.com>",
        "to" => "Michael Scott <michael@example.com>",
        "subject" => "The Printer Caught Fire",
        "text" => 'We have a problem."));


    // # Iterate through the results and echo the message IDs.
    $logItems = $result->http_response_body->items;
    foreach($logItems as $logItem){
        $mailMessageId = $logItem->message_id;
    }


    return $mailMessageId;
    //https://github.com/mailgun/mailgun-php

}



?>