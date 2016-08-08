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
	 *
	 * @return
	 * */
	public function setMailId() {

	}
}