<?php

namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Mail, Profile
};
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
	// create dependent objects before running each test
	public final function setUp(){
	//run the default set up() method first
		parent::setUp();

		//create and insert Sender to own the test Mail
		$this->sender = new Profile(null, "@phpunit", "test@phpunit.de","+12125551212");
		$this->sender->insert($this->getPDO());
	}

	/**
	 * test by inserting a valid message and verify that the actual mySQL data matches
	 *
	 */
	public function testInsertValidMail(){
		//count the number of rows and verify that the actual mySQL data matches
		$numRows = $this->getConnection()->getRowCount("mail");

		//create a new message and insert it to mySQL
		$mail = new Mail(null, $this->sender->getProfileId(),$this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());
	}
	/**
	 * test inserting a message that already exists
	 *
	 */
	public function testInsertInvalidMail(){
		//create a message with a non null id and watch it fail
		$mail = new Mail(FlekTest::INVALID_KEY, $this->sender->getProfileId(), $this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO);
	}
	/**
	 * test inserting a message, editing it, then updating it
	 *
	 */
	public function testUpdateValidMail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		//create new message and insert it to mySQL
		$mail = new Mail(null, $this->sender->getProfileId(),$this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());

		//edit the message and update it in mySQL
		$mail->setMailContent($this->VALID_MAILCONTENT2);
		$mail->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMail = Mail::getMailByMailId($this->getPDO(), $mail->getMailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertEquals($pdoMail->getProfileId(), $this->sender->getProfileId());
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT2);

	}
	/**
	 * test using a message that does not exist
	 *
	 */
	public function testUpdateInvalidMail(){
		//create a message , try to update it without actually updating it and watch it fail
		$mail = new Mail(null, $this->sender->getProfileId(), $this->VALID_MAILCONTENT);
		$mail->update($this->getPDO());
	}
	/**
	 * test creating a message and deleting it
	 */
	public function testDeleteValidMail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		//create new message and insert it to mySQL
		$mail = new Mail(null, $this->sender->getProfileId(),$this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());

		//delete the message from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$mail->delete($this->getPDO());


		// grab the data from mySQL and enforce the message does not exist
		$pdoMail = Mail::getMailByMailId($this->getPDO(), $mail->getMailId());
		$this->assertNull($pdoMail);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("mail"));
	}
	/**
	 * test deleting a message that does not exist
	 */

	public function testDeleteInvalidMail() {
		// create a message and try to delete it without actually inserting it
		$mail = new Mail(null, $this->profile->getProfileId(), $this->VALID_MailCONTENT);
		$mail->delete($this->getPDO());
	}

	/**
	 * test grabbing a message by mail content
	 **/
	public function testGetValidMailByMailContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		// create a new message and insert to into mySQL
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT;

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getMailContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dmcdonald21\\DataDesign\\Mail", $results);

		// grab the result from the array and validate it
		$pdoMail = $results[0];
		$this->assertEquals($pdoMail->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MailCONTENT);
	}
	/**
	 * test grabbing a message by content that does not exist
	 **/
	public function testGetInvalidMailByMailContent() {
		// grab a message by searching for content that does not exist
		$mail = Mail::getMailByMailContent($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $mail);
	}

}