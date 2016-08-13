<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\(Favorite);

//grab the project test parametes
require_once("FlekTest.php");

//grab the class
require_once (dirname(__DIR__) . "/public_html/php/classes/autoload.php");

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
	/*
	 * Profile that created Favoritee and Favoriter
	 *@var profile profile for Favorite
	 */
	protected $favoritee = null;

	/*
	 * profile that created Favoriter
	 * @var profile for Favorite
	 */
	protected $favoriter = null;
	}

	/*
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the deafault setUp() method first
		parent::setUp();
		// create and insert a Favoritee to own the test Favorite
		$this->favoritee = new Favoritee(null, "It's going to rain today", "test@phpunit.de", "here in the land of enchantment
		its 77 degrees right now");
		$this->favoritee->insert($this->getPDO());

		//create and insert a Favoriter to own the test Favorite
		$this->favoriter = new Favoriter(null, "I cant wait to see the Star wars movie", "508 warehouse is doing an event today");
		$this->favoriter->insert($this->getPDO());
}
	/*
	 * test inerting a valid Favorite and verify that the actual mySQL data matches
	 */
		public function testInsertValidFavorite() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("Favorite");

		//create a new Favorite and insert to into mySQL
		$favorite = new Favorite(null, $this->favoritee->getFavoriteeId(), $this->getFavoriterId());
		$favorite->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoritebyFavoriteeIdByFavoriterId($this->getPDO(), $favorite->getFavoriteeId()),
		$favorite->getFavoriterId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteeId(), $this->favoritee->getFavoriteeId());
		$this->assertEquals($pdoFavorite->getFavoriterId(), $this->favoriter->getFavoriterId());
}

	/*
	 * test inserting a Favorite  that already exists
	 * @expectedException PDOException
	 */
		public function testInsertInvalidFavorite() {
			//create a Favorite with a non null favorite id and watch is fail
		$favorite = new Favorite(FlekTest::INVALID_KEY, $this->favoritee->getFavoriteeId(), $this->FavoriterId());
		$favorite->insert($this->getPDO());
		}
		/*
		 * test inserting a Favorite, editing it and then updating it
		*/
		public function testUpdateValidFavorite() {
			//count the number of rows and savie it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite(null, $this->favoritee->getFavoriteeId(), $this->favoriter->getFavoriterId);
		$favorite->insert($this->getPDO());

		//edit the Favorite and update it in mySQL
}