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
	public function testInsertValidProfile() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile adn insert it into mySQL
		$profile = new Profile(null, $this->VALID_PROFILEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILEBIO, $this->hash, $this->salt);
		$profile->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfilebyProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->VALID_PROFILEID);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->hash);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->salt);
		$this->assertEquals($pdoProfile->getProfileAccessToken(), $this->VALID_PROFILEACCESSTOKEN);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	**/
	public function testUpdateValidProfile() {
		//create a Profile with a non null profile id and watch it fail
		$profile = new Profile(FLekTest::INVALID_KEY, $this->VALID_PROFILEID, $this->VALID_PROFILENAME,
			$this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILEBIO, $this->hash, $this->salt,
			$this->VALID_PROFILEACCESSTOKEN, $this->VALID_PROFILEACTIVATIONTOKEN);
		$profile->insert($this->getPDO());
		//edit the Profile and update it in mySQL
		$profile->setProfileName($this->VALID_PROFILENAME);
		$profile->setProfileEmail($this->VALID_PROFILEEMAIL);
		$profile->setProfileLocation($this->VALID_PROFILELOCATION);
		$profile->setProfileBio($this->VALID_PROFILEBIO);
		$profile->setProfileHash($this->hash);
		$profile->setProfileSalt($this->salt);
		$profile->getProfileAccessToken($this->VALID_PROFILEACCESSTOKEN);
		$profile->getProfileActivationToken($this->VALID_PROFILEACTIVATIONTOKEN);
		$profile->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->VALID_PROFILEID);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->hash);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->salt);
		$this->assertEquals($pdoProfile->getProfileAccessToken(), $this->VALID_PROFILEACCESSTOKEN);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
	}

	/**
	 * test updating a Profile that already exists
	 *
	 * @expectedException \PDOException
	**/
	public function testUpdateInvalidProfile() {
		//create a profile with a null profile id and watch it fail
		$profile = new Profile(null, $this->VALID_PROFILEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILEBIO, $this->hash, $this->hash, $this->VALID_PROFILEACCESSTOKEN, $this->VALID_PROFILEACTIVATIONTOKEN);
		$profile->update($this->getPDO());
	}
}