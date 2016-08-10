<?php

namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Mail};
//grab the project test parameters
require_once ("MailTest.php");

//grab the class under scrutiny

require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 *full PHP unit test for the Mail class
 *
 * @author Rob Harding
 * @ver 1.0.0
 */
class MailTest extends FlekTest {
	/**
	 * this is the Mail content
	 */
	protected $VALID_MAILCONTENT = "PHP unit test passing";
	/**
	 * this is the updated Mail content
	 */
	protected $VALID_MAILCONTENT2 = "PHP unit test still passing";
	/**
	 * this is the profile who created/sent the message, this is for foreign key relations
	 */
	protected $sender = null;
	/**
	 * this is the profile who viewed/received the message, this is for foreign key relations
	 */
	protected $receiver = null;
}