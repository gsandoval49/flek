<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Profile, Favorite};

//grab the project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

//grab the class
require_once("FlekTest.php");

/*
 * Full PHPUnit test for the Favorite Class
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 */

class FavoriteTest extends FlekTest {
	protected $VALID_PROFILEACCESSTOKEN = null;
	protected $VALID_PROFILEACTIVATIONTOKEN = null;
	protected $salt = null;
	protected $hash = null;
	/*
	 * Profile that created Favoritee and Favoriter
	 *@var Profile profile for Favorite
	 */
	protected $favoriteeId = null;
	/*
	 * profile that created Favoriter
	 * @var Profile profile for Favorite
	 */
	protected $favoriterId = null;

	protected $profile = null;


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

		$this->profile = new Profile(null, "csosa4", "foo@bar.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		$this->profile->insert($this->getPDO());

		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $this->profile->getProfileId());

		$this->favoriteeId = new Profile(null, "csosa4", "foo@bar2.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		$this->favoriteeId->insert($this->getPDO());

		$this->favoriterId = new Profile(null, "csosa4", "bar@foo.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		$this->favoriterId->insert($this->getPDO());

	}

	/*
	 * test inserting a valid Favorite and verify that the actual mySQL data matches
	 */
	public function testInsertValidFavorite() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//no Dependent objects therefore no setup was setup

		$favorite = new Favorite($this->profile->getFavoriterByProfileId());
		$favorite->insert($this->getPDO());


		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteeId($this->getPDO(), $favorite->getFavoriteeId(),
			$favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->profile->getProfileId());

	}

	/*
	 * test inserting a Favorite  that already exists
	 * @expectedException PDOException
	 */
	public function testInsertInvalidFavorite() {
		//create a Favorite with a non null favorite id and watch is fail
		$favorite = new Favorite(FlekTest::INVALID_KEY);
		$favorite->insert($this->getPDO());
	}

	/*
	 * test inserting a Favorite, editing it and then updating it
	*/
	public function testUpdateValidFavorite() {
		//count the number of rows and savie it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());

		//edit the Favorite and update it in mySQL
		$favorite->setFavoriteeId($this->getFavoriteeId);
		$favorite->setFavoriterId($this->getFavoriterId);
		$favorite->update($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdByFavoriterId($this->getPDO(), $favorite->getFavoriteeId(),
			$favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->getFavoriteeId());
		$this->asertEquals($pdoFavorite->getFavoriterId(), $this->getFavoriterId());
	}

	/*
	 * test updating a Favorite that already exists
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidFavorite() {
		//create a Favorite, try to update it without actually updating it and watch it fail
		$favorite = new Favorite($this->getFavoriteeId(), $this->getFavoriterId());
		$favorite->update($this->getPDO());
	}

	/*
	 * test creating a Favorite and then deleting it
	 */
	public function testDeleteValidFavorite() {
		//count the number the rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		//create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->getFavoriteeId(), $this->getFavoriterId());
		$favorite->insert($this->getPDO());

		//delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		//grab the data from mySQL and enforce the Favorite does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteeId($this->getPDO(), $favorite->getFavoriteeId(),
			$favorite->getFavoriterId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/*
	 * test deleting a Favorite that does not exist
	 *
	 * @expectedEception PDOException
	 */
	public function testDeleteInvalidFavorite() {
		// create a Favorite and try to delete it without actually inserting it
		$favorite = new Favorite($this->getFavoritee(), $this->getFavoriter());
		$favorite->delete($this->getPDO());
	}

	/*
	 * test inserting a Favorite and regrabbing it from mySQL
	 */
	public function testGetValidFavoriteByFavoriteeIdByFavoriterId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->getFavoriteeId(), $this->getFavoriterId());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteeId($this->getPDO(), $favorite->getFavoriteeId(),
			$favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEqual($pdoFavorite->getFavoriteeId(), $pdoFavorite->getFavoriterId(),
			$this->getFavoriteeId(), $this->FavoriterId());
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $pdoFavorite->getFavoriterId());
	}

	/*
	 * test grabbing a Favorite that does not exist
	 */
	public function testGetInvalidFavoriteByFavoriteeIdByFavoriterId() {
		//grab a favorite id that exceeds the masimum allowable favorite id
		$favorite = Favorite::getFavoriteByFavoriteeId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertNull($favorite);
	}
}




