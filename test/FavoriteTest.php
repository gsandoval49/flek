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
		$favorite = new Favorit
}