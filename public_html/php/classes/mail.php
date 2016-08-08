<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");

class mail implements \JsonSerializable {
	private mailId;
	private mailSenderId;
	private mailReceiverId;
	private mailGunId;
	public mailContent;
	public mailSubject;

}
