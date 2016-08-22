<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Favorite, Profile};

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
	 *@var Profile $favoriteeId	 *
	 **/
	protected $favoriteeId = null;
	/**
	 * Profile that created Favoritee and Favoriter
	 *@var Profile $favoriterId	 *
	 **/
	protected $favoriterId = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the parent method first
		parent::setUp();
		//create and insert a Profile favoritee to be given
		$favoriteeId = new Profile(null,"csosa4", "foo@bar.com", "Rio, Rancho", "test is passing", "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678","1234567890123456789012345678901234567890123456789012345678901234", "01234567890","01234567890123456789012345678901");
		$favoriteeId->insert($this->getPDO());

		//create and insert a Profile favoriter to be given
		$favoriterId = new Profile(null,"csosa4", "bar@foo2.com", "Rio, Rancho", "test is passing", "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678","1234567890123456789012345678901234567890123456789012345678901234", "01234567890","01234567890123456789012345678901");
		$favoriterId->insert($this->getPDO());

	}

	/**
	 * test inserting a valid Favorite and verify that the actual mySQL data matches
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertValidFavorite() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//$profile = new Profile(null, "csosa4", "bar@foo.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		//$profile->insert($this->getPDO());

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		//$results = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		//$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		//$this->assertCount(1, $results);

		//$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Favorite\\Test", $results);


		//grab the results from the array and validate them

		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->favoriteeId->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->favoriterId->getProfileId());
	}

	/**
	 * test inserting an Favorite that already exists
	 *
	 * @expectedException /PDOException
	 **/
	public function testInsertInvalidFavorite() {
		//create an Favorite with a null composite key (favoriteeId and favoriterId) and watch it fail
		$favorite = new Favorite(FlekTest::INVALID_KEY,$this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());

	}

	/**
	 * test creating a Favorite and then deleting it
	 **/
	public function testDeleteValidFavorite() {
		//count the number the rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());

		//delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		//grab the data from mySQL and enforce the Favorite does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * test deleting a Favorite that does not exist
	 *
	 * @expected Exception PDOException
	 **/
	public function testDeleteInvalidFavorite() {
		// create a Favorite and try to delete it without actually inserting it
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->delete($this->getPDO());
	}

	/**
	 * test inserting a Favorite and regrabbing it from mySQL
	 **
	public function testGetValidFavoriteByFavoriteeIdAndFavoriterId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), $favorite->getFavoriteeId(), $favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->favoriteeId->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->favoriterId->getProfileId());

	}

	/**
	 * test grabbing a Favorite that does not exist
	 **
	public function testGetInvalidFavoriteByFavoriteeIdAndFavoriterId() {
		//grab a favorite id that exceeds the masimum allowable favorite id
		$favorite = Favorite::FavoriteByFavoriteeIdAndFavoriterId($this->getPDO(), FlekTest::INVALID_KEY, FlekTest::INVALID_KEY);
		$this->assertNull($favorite);
	*/




	/**
	 * test grabbing an Favorite by the FavoriteeIdProfileId
	 **/
	public function testGetValidFavoriteByFavoriteeId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		//create a new Favorite and insert it into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(),
			$this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteeId($this->getPDO(), $favorite->getFavoriteeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Favorite", $results);
		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->favoriteeId->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->favoriterId->getProfileId());

	}

	/**
	 * test grabbing an Favorite by FavoriteeIdProfileId that does not exist
	 **
	public
	function testGetInvalidFavoriteeId() {
		//grab an favorite by searching for content that does not exist
		$favorite = Favorite::getFavoriteeId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertCount(0, $favorite);
*/


	/**
	 * test grabbing a Favorite by person giving favorite profile id
	 **/
	public function testGetValidFavoriteByFavoriterId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new favorite and insert to into mySQL
		$favorite = new Favorite($this->favoriteeId->getProfileId(), $this->favoriterId->getProfileId());
		$favorite->insert($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$results = Favorite::getFavoriteByFavoriterId($this->getConnection()->getRowCount("favorite"));
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\Flek\\Favorite", $results);

		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->favoriteeId(), $this->favoriteeId->getProfileId());
		$this->assertEquals($pdoFavorite->favoriterId(), $this->favoriterId->getProfileId());
	}
	/**
	 *
	 * TEST GRABBING ALL FAVORITES
	 **
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
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->favoriteeId->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->favoriterId->getProfileId());

	}
*/
}