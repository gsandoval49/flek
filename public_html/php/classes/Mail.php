<?php


namespace Edu\Cnm\Flek;


require_once("autoload.php");

class Mail implements \JsonSerializable {
	/*this is the primary id for the class*/
	private mailId;
	/*this is the subject for a specific message*/
	private mailSubject;
	/*this is the profileId of the user who sends the message*/
	private mailSenderId;
	/*this is the profileId of the user who reads the message*/
	private mailReceiverId;
	/*this is the Id created by mailgun*/
	private mailGunId;
	/*this is the actual content of the message*/
	private mailContent;


}