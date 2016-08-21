<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Profile, Favorite};

//grab the project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

//grab the class
require_once("FlekTest.php");

/**
 * Full PHPUnit test for the Favorite Class
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 **/

class FavoriteTest extends FlekTest {
	/**
	 * Profile that created Favoritee and Favoriter
	 *@var Profile profile for Favorite
	 *
	 **/
	protected $profile = null;

	protected $activate;

	//protected $favoriteeId = null;
	/*
	 * profile that created Favoriter
	 * @var Profile profile for Favorite
	 */
	//protected $favoriterId = null;
	protected $favorite = null;


	private $hash;

	private $salt;

	protected $profileAccessToken = "01234567890";

	protected $profileActivationToken = "01234567890123456789012345678901";

	protected $profileActivationToken2 = "2 43647587688685764859687";
	/*
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the parent method first
		parent::setUp();

		$this->VALID_PROFILEACCESSTOKEN = bin2hex(random_bytes(16));
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$password = "abc123";
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha256", "abc123", $this->salt, 262144);

		$this->profile = new Profile(null,"csosa4", "foo@bar.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, $this->profileAccessToken, $this->profileActivationToken);
		$this->profile->insert($this->getPDO());

		//$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $this->profile->getProfileId());

	}

	/**
	 * test inserting a valid Favorite and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavorite() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		$profile = new Profile(null, "csosa4", "bar@foo.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		$profile->insert($this->getPDO());

		// create a new Favorite and insert to into mySQL
		$this->favorite = new Favorite($this->profile->getProfileId());
		$this->favorite->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $profile->getFavoriteeId(), $profile->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
$this->assertCount(1, $results);

		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Favorite\\Test", $results);


		//grab the results from the array and validate them
			$pdoFavorite = $results[0];
			$this->assertEquals($pdoFavorite->getFavoriteeId(),$this->profile->getProfileId());

		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getProfileActivationToken(), $this->profileActivationToken);
}

	/**
	 * test inserting an Favorite that already exists
	 * @expectedException /PDOException
	 **/
	public function testInsertInvalidFavorite() {
		//create an Favorite with a null composite key (favoriteeId and favoriterId) and watch it fail
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->insert($this->getPDO());

	}

	/*
	 * test creating a Favorite and then deleting it
	 */
	public function testDeleteValidFavorite() {
		//count the number the rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		//create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->insert($this->getPDO());

		//delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		//grab the data from mySQL and enforce the Favorite does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/*
	 * test deleting a Favorite that does not exist
	 *
	 * @expected Exception PDOException
	 */
	public function testDeleteInvalidFavorite() {
		// create a Favorite and try to delete it without actually inserting it
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->delete($this->getPDO());
	}

	/*
	 * test inserting a Favorite and regrabbing it from mySQL
	 */
	public function testGetValidFavoriteByFavoriteeIdAndFavoriterId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->profile->getProfileId());

	}

	/*
	 * test grabbing a Favorite that does not exist
	 */
	public function testGetInvalidFavoriteByFavoriteeIdAndFavoriterId() {
		//grab a favorite id that exceeds the masimum allowable favorite id
		$favorite = Favorite::FavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), FlekTest::INVALID_KEY, FlekTest::INVALID_KEY);
		$this->assertNull($favorite);
	}


	/**
	 * test grabbing an Favorite by the FavoriteeIdProfileId
	 **/
	public function testGetValidFavoriteByFavoriteeId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		//create a new Favorite and insert it into mySQL
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteeId($this->getPDO(), $favorite->getFavoriteeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Favorite", $results);
		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->profile->getProfileId());

	}

	/**
	 * test grabbing an Favorite by FavoriteeIdProfileId that does not exist
	 **/
	public
	function testGetInvalidFavoriteeId() {
		//grab an favorite by searching for content that does not exist
		$favorite = Favorite::getFavoriteeId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertCount(0, $favorite);

	}

	/**
	 *
	 * TEST GRABBING ALL FAVORITES
	 **/
	public function testGetAllValidFavorites() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		//create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId());
		$favorite->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getAllFavorites($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Test", $results);
		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->profile->getProfileId());

	}

}
