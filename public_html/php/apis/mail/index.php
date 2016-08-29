<?php

/**
 * function for the mailGunner class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/

require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
$mailgun = json_decode($config["mailgun"]);

// now $mailgun->domain and $mailgun->apiKey exist - locates key.
require_once(dirname(__DIR__, 6) . "vendor/autoload.php");

//don't call mail, renamed mailGunner
function mailGunner ( $domain, $senderName, $senderMail, $receiverName, $receiverMail, $subject, $message) {


    // start the mailgun client
    $client = new \Http\Adapter\Guzzle6\Client();
    $mailGunner = new \Mailgun\Mailgun($mailgun->apiKey, $client);

    // send the message
    $result = $mailGunner->sendMessage($mailgun->domain, [
            "from" => "$senderName <$senderMail>",
            "to" => "$receiverName <$receiverMail>",
            "subject" => $subject,
            "text" => $message
        ]
    );

    // # Iterate through the results and echo the message IDs.
    $logItems = $result->http_response_body->items;
    foreach($logItems as $logItem){
        $mailMessageId = $logItem->message_id;
    }


    return $mailMessageId;
    //https://github.com/mailgun/mailgun-php

}



?>