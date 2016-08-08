<?php


namespace Edu\Cnm\Flek;


require_once("autoload.php");

class Mail implements \JsonSerializable {
	/**
	 *  this is the primary key for the Mail class
	* @var int $mailId
	 * */
	private mailId;
	/**
	 * this is the subject of a message
	 * @var string $mailSubject
	 * */
	private mailSubject;
	/**
 * this is the profileId of the user who sends a message
 * @var int $mailSenderId
 * */
	private mailSenderId;
	/**
	 * this is the profileId of the user who reads the message
	 * @var int $mailReceiverId
	 * */
	private mailReceiverId;
	/**
	 * this is the Id created by mailgun
	 * @var int $mailGunId
	 * */
	private mailGunId;
	/**
	 * this is the actual message content
	 * @var string $mailContent
	 * */
	private mailContent;

	/**
	 * this is the accessor method for mail Id
	 * @return int|null value of mail Id
	 * */
	public function getMailId() {
		return($this->mailId);
	}
	/**
	 * this is the mutator method for mail Id
	 * @param int|null $newMailId new value of mail Id
	 * @throws \RangeException if $newMailId is not positive
	 * @return \ error if new id is not an integer
	 * */
	public function setMailId(int $newMailId = null) {

		if($newMailId === null) {
			$this->mailId = null;
			return;
		}
		/*verify the new Id is positive*/
		if($newMailId <= 0) {
			throw(new \RangeException("mail Id is not positive"));
		}
		/*create and store the new mail Id*/
		$this->mailId = $newMailId;
	}
	/**
	 * this is the accessor method for the mail Sender Id
	 *
	 * @return int|null 
	 * */
	public function getmailSenderId (){
		return($this->mailSenderId);
	}
	/**
	 * this is the mutator method for mail Sender Id
	 * @param int|null $newMailSenderId new value of mail Id for the sender
	 * @throws \RangeException if $newMailSenderId is not positive
	 * @return error if the new id is not positive
	 * */
	public function setmailSenderId(int $newmailSenderId){
		/*verify the profile Id is positive*/
		if($newmailSenderId <= 0) {
			throw(new \RangeException ("user profile id is not positive"));
		}
		/*convert and store the profile id*/
		$this->mailSenderId = $newmailSenderId;

	}
	/**
	 * this is the accessor method for the mail receiver Id
	 * idek,man
	 * @return int|null
	 * */
	public function getMailReceiverId(){
		return($this->mailReceiverId);
	}
	/**
	 * this is the mutator method for mail receiver Id
	 * @param int|null $newMailReceiverId new value of mail Id
	 * @throws \RangeException if $newMailId is not positive
	 * @return int|null
	 * */
	public function setMailReceiverId(int $newMailReceiverId){
		if($newMailReceiverId <= 0) {
			throw(new \RangeException("user profile Id is not positive"));
		}

		$this->mailReceiverId = $newMailReceiverId;

	}

}