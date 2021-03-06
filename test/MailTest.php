<?php

namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Mail, Profile
};
//grab the project test parameters
require_once ("FlekTest.php");

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
	/*protected $VALID_MAILDATE = null;*/
	/**
	 * mailgun id of the Message
	 * @var int $VALID_MAILGUNID
	 **/
	protected $VALID_MAILGUNID = 17286;
	/**
	 * mailgun id of the updated Message
	 * @var int $VALID_MAILGUNID2
	 **/
	protected $VALID_MAILGUNID2 = 18286;
	/**
	 * content of the Message subject
	 * @var string $VALID_MAILSUBJECT
	 **/
	protected $VALID_MAILSUBJECT = "PHPUnit message subject test successfull";
	/**
	 * Profile that created the Message, this is for foreign key relations
	 * @var Profile mailSenderId
	 **/
	protected $mailSenderId = null;
	/**
	 * this is the profile who viewed/received the message, this is for foreign key relations
	 * @var Profile mailReceiverId
	 */
	protected $mailReceiverId = null;
	// create dependent objects before running each test
	public final function setUp(){
	//run the default set up() method first
		parent::setUp();


		//supposedly this is the "manual" method of setting up two foreign keys

		// the attributes here need to match up to the class 1-1
		//create and insert a Profile to send the test Message

		$this->mailSenderId = new Profile(null, "j", "test@phpunit.de", "tibuktu", "I eat chickens, mmmmmkay", "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678","1234567890123456789012345678901234567890123456789012345678901234", "01234567890","01234567890123456789012345678901");
		$this->mailSenderId->insert($this->getPDO());
		//create and insert a Profile to receive the test Message
		$this->mailReceiverId = new Profile(null, "K", "tested@phpunit.de", "fiji","I play hopskotch", "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678", "1234567890123456789012345678901234567890123456789012345678901234", "01234567890", "01234567890123456789012345678901");
		$this->mailReceiverId->insert($this->getPDO());
		//calculate the date using the time the unit test was set up
		/*$this->VALID_MAILDATE = new \DateTime();*/
	}

	/**
	 * test by inserting a valid message and verify that the actual mySQL data matches
	 *
	 */
	public function testInsertValidMail(){
		//count the number of rows and verify that the actual mySQL data matches
		$numRows = $this->getConnection()->getRowCount("mail");
		//create a new message and insert it to mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMail = Mail::getMailByMailId($this->getPDO(), $mail->getMailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getMailReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT);
	}
	/**
	 * test inserting a message that already exists
	 *
	 *@expectedException PDOException
	 */
	public function testInsertInvalidMail(){
		//create a message with a non null id and watch it fail
		$mail = new Mail(FlekTest::INVALID_KEY, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());
	}
	/**
	 * test inserting a message, editing it, then updating it
	 *
	 *
	 */
	public function testUpdateValidMail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		//create new message and insert it to mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());

		//edit the message and update it in mySQL
		$mail->setMailContent($this->VALID_MAILCONTENT2);
		$mail->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMail = Mail::getMailByMailId($this->getPDO(), $mail->getMailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getMailReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT2);

	}
	/**
	 * test using a message that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidMail(){
		//create a message , try to update it without actually updating it and watch it fail
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->update($this->getPDO());
	}
	/**
	 * test creating a message and deleting it
	 *
	 *
	 */
	public function testDeleteValidMail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		//create new message and insert it to mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
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
	 *
	 * @expectedException PDOException
	 */

	public function testDeleteInvalidMail() {
		// create a message and try to delete it without actually inserting it
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->delete($this->getPDO());
	}

	/**
	 * test grabbing a message by mail subject
	 **/
	public function testGetValidMailByMailContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		// create a new message and insert to into mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);

		$mail->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Mail::getMailByMailContent($this->getPDO(), $mail->getMailContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Mail", $results);

		// grab the result from the array and validate it
		$pdoMail = $results[0];
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getMailReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT);
	}
	/**
	 * test grabbing a message by content that does not exist
	 **/
	public function testGetInvalidMailByMailContent() {
		// grab a message by searching for content that does not exist
		$mail = Mail::getMailByMailContent($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $mail);
	}
	/**
	 * test grabbing a Message by sent profile id
	 **/
	public function testGetValidMailByMailSenderId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		// create a new message and insert to into mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(), $this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);

		$mail->insert($this->getPDO());

		//grab the data from MySQL and enforce that the fields match our expectations
		$results = Mail::getMailByMailSenderId($this->getPDO(), $mail->getMailSenderId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Mail", $results);

		//grab the result from the array and validate it
		$pdoMail = $results[0];
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getMailReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT);
	}

	/**
	 * test grabbing a Message by receiver profile id
	 **/
	public function testGetValidMailByMailReceiverId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		// create a new message and insert to into mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(), $this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);

		$mail->insert($this->getPDO());
		//grab the data from MySQL and enforce that the fields match our expectations
		$results = Mail::getMailByMailReceiverId($this->getPDO(), $mail->getMailReceiverId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Mail", $results);

		//grab the result from the array and validate it
		$pdoMail = $results[0];
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getMailReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT);
	}

		/**
	 * test grabbing all messages
	 **/
	/*public function testGetAllMail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mail");

		// create a new message and insert to into mySQL
		$mail = new Mail(null, $this->VALID_MAILSUBJECT, $this->mailSenderId->getProfileId(),$this->mailReceiverId->getProfileId(), $this->VALID_MAILGUNID, $this->VALID_MAILCONTENT);
		$mail->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Mail::getAllMail($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mail"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Mail", $results);

		// grab the result from the array and validate it
		$pdoMail = $results[0];
		$this->assertEquals($pdoMail->getMailSubject(), $this->VALID_MAILSUBJECT);
		$this->assertEquals($pdoMail->getMailSenderId(), $this->mailSenderId->getProfileId());
		$this->assertEquals($pdoMail->getReceiverId(), $this->mailReceiverId->getProfileId());
		$this->assertEquals($pdoMail->getMailGunId(), $this->VALID_MAILGUNID);
		$this->assertEquals($pdoMail->getMailContent(), $this->VALID_MAILCONTENT);
	}*/
}
