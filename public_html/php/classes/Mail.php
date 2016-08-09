<?php


namespace Edu\Cnm\Flek;


require_once("autoload.php");
/**
 *
 *
 * @author Rob Harding
 * @ver 1.0.0
 **/


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
	 * this is the accessor method for mail subject
	 *
	 * @return string
	 * */
	public function getMailSubject(){
		return($this->mailSubject);
	}
	/**
	 *this is the mutator method for mail subject
	 *
	 *
	 */
	public function setMailSubject (string $newMailSubject){
		
	}
	/**
	 * this is the accessor method for the mail Sender Id
	 * I am not 100% sure that any of this is quite right for the Sender and Receiver Ids, but I followed the examples as best as I could
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
	/**
	 * this is the accessor method for mail gun Id
	 *
	 * @return int|null
	 * */
	public function getMailGunId(){
		return($this->mailGunId);
	}
	/**
	 * this is the mutator method for mail gun Id
	 * @param int|null $newMailGunId new value of mail gun Id
	 * @throws \RangeException if $newMailGunId is not positive
	 * @return
	 * */
	public function setMailGunId(int $newMailGunId) {
		if($newMailGunId <= 0){
			throw(new \RangeException("mail gun Id is not positive"));
		}
	}
	/**
	 * this is the accessor method for mail content
	 *
	 * @return string
	 * */
	public function getMailContent(){
		return($this->mailContent);
	}
	/**
	 * this is the mutator method for mail content
	 * @param string $newMailContent new value of mail content
	 * @throws \InvalidArgumentException if new content is not a string or insecure
	 * @throws \RangeException if new content is more than 1000 characters
	 * @throws \TypeError if new content is not a string
	 *
	 * */
	public function setMailContent(string $newMailConent) {
		$newMailConent = trim($newMailConent);
		$newMailConent = filter_var($newMailConent, FILTER_SANITIZE_STRING);
		if(empty($newMailConent) === true) {
			throw(new \InvalidArgumentException("message content empty or insecure"));
		}
		if(strlen($newMailConent)>1000){
			throw(new \RangeException("message content too large"));
		}
		$this->mailContent = $newMailConent;
}
	


}