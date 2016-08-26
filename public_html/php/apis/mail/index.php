<?php

/**
 * function for the mailGunner class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/

require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

$config = readConfig("/etc/apache2/capstone-mysql/flek.ini");
$mailgun = json_decode($config["mailgun"]);

// now $mailgun->domain and $mailgun->apiKey exist
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

//don't call mail
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
    /*
        // inform the user of the result
        if($result->http_response_code !== 200) {
            throw(new RuntimeException("unable to send email", $result->http_response_code));
        }
        $reply->message = "Thank you for reaching out. I'll be in contact shortly!";
        }  else {
            throw(new InvalidArgumentException("Invalid HTTP method request", 405));
        }

    */

    # Iterate through the results and echo the message IDs.
    $logItems = $result->http_response_body->items;
    foreach($logItems as $logItem){
        $mailMessageId = $logItem->message_id;
    }


    return $mailMessageId;
    //https://github.com/mailgun/mailgun-php

}



?>