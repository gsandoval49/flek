<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Profile};

//grab teh project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the profile class
 *
 * This is a complete PHPUnit test of the profile class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Christina Sosa <csosa4@cnm.edu>
**/
class ProfileTest extends FlekTest {

	/**
	 * id of the profile
	 * @var int $VALID_PROFILEID
	**/
	protected $VALID_PROFILEID = 21;

	/**
	 * name of profile
	 * @var string $VALID_PROFILENAME
	**/
	protected $VALID_PROFILENAME = "csosa4";

	/**
	 * email of profile
	 * @var string $VALID_PROFILEEMAIL
	 **/
	protected $VALID_PROFILEEMAIL = "foo@bar.com";

	/**
	 * location of the profile
	 * @var string $VALID_PROFILELOCATION
	**/
	protected $VALID_PROFILELOCATION = "Rio Rancho, NM";

	/**
	 * bio of the profile
	 * @var string $VALID_PROFILEBIO
	**/
	protected $VALID_PROFILEBIO = "I love art. Please enjoy the art I post.";

	/**
	 * hash for profile
	 * @var profile hash
	**/
	private $hash;

	/**
	 * salt for profile
	 * @var profile salt
	**/
	private $salt;

	/**
	 * access token for profile
	 * @var string $VALID_PROFILEAccessTOKEN
	 **/
	protected $VALID_PROFILEACCESSTOKEN =
		"01234567890abcdefghijklmnopqrstu";

	/**
	 * activation token for profile
	 * @var string $VALID_PROFILEACTIVATIONTOKEN
	**/
	protected $VALID_PROFILEACTIVATIONTOKEN = "01234567890abcdefghijklmnopqrstu";

	/**
	 * create dependent objects before running each test
	**/
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a Profile to own the account
		$this->VALID_PROFILEACCESSTOKEN = ;
		$this->VALID_PROFILEACTIVATIONTOKEN = ;
		$this->hash = ;
		$this->salt = ;
	}
	/**
	 * test inserting a valid profile and verify that the actual mySQL data matches
	**/
}