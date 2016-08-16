<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Genre};

//grab teh project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
require_once("FlekTest.php");

/**
 * Full PHPUnit test for the Genre class
 *
 * This is a complete PHPUnit test of the genre class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs.
 *
 * @see Genre
 * @author Christina Sosa <csosa4@cnm.edu>
 **/
class GenreTest extends FlekTest {
	/**
	 * content of the genre
	 * @var string $VALID_GENRENAME
	 **/
	protected $VALID_GENRENAME = "Drawing";
	/**
	 * content of the updated Genre
	 * @var string $VALID_GENRENAME2
	 **/
	protected $VALID_GENRENAME2 = "Painting";

	/**
	 * test inserting a valid Genre and verify that the actual mySQL data matches
	 **/
	public function testInsertValidGenre() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("genre");
		//create a new genre and insert into mySQL
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoGenre = Genre::getGenrebyGenreId($this->getPDO(), $genre->getGenreId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$this->assertEquals($pdoGenre->getGenreName(), $this->VALID_GENRENAME);
	}

	/**
	 * test inserting a Genre that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidGenre() {
		//create a Genre with a non null genre id and watch it fail
		$genre = new Genre(FlekTest::INVALID_KEY, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
	}

	/**
	 * test inserting a genre, editing it, and then updating it
	 **/
	public function testUpdateValidGenre() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("genre");
		//create a new Genre and insert into mySQL
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
		//edit the Genre and update it in mySQL
		$genre->setGenreName($this->VALID_GENRENAME2);
		$genre->update($this->getPDO());
		// grab the data from mySQL and enforce that the fields match our expectations
		$pdoGenre = Genre::getGenrebyGenreId($this->getPDO(), $genre->getGenreId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$this->assertEquals($pdoGenre->getGenreName(), $this->VALID_GENRENAME2);
	}

	/**
	 *test updating a Genre that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidGenre() {
		//create a Genre with a non null genre id and watch it fail
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->update($this->getPDO());
	}

	/**
	 *test creating a Genre and then deleting it
	 **/
	public function testDeleteValidGenre() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("genre");
		//create a new Genre and insert into mySQL
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
		//delete the Genre from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$genre->delete($this->getPDO());
		//grab the data from mySQL and enforce that the Genre does not exist
		$pdoGenre = Genre::getGenrebyGenreId($this->getPDO(), $genre->getGenreId());
		$this->assertNull($pdoGenre);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("genre"));
	}

	/**
	 *test deleting a genre that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidGenre() {
		//create a Genre and try to delete it without actually inserting it
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->delete($this->getPDO());
	}

	/**
	 *test grabbing a Genre that does not exist
	 **/
	public function testGetInvalidGenreByGenreId() {
		//grab a genre id that exceeds the max allowable genre id
		$genre = Genre::getGenrebyGenreId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertNull($genre);
	}

	/**
	 *test grabbing a Genre by genre name
	 **/
	public function testGetValidGenreByGenreName() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("genre");
		//create a new Genre and insert it into mySQL
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoGenre = Genre::getGenreByGenreName($this->getPDO(), $genre->getGenreName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$this->assertEquals($pdoGenre->getGenreName(), $this->VALID_GENRENAME); //error here
	}
	/**
	 *test grabbing a Genre by name that does not exist
	 **/
	public function testGetInvalidGenreByGenreName() {
		//grab a genre id that exceeds the maximum allowable genre id
		$genre = Genre::getGenreByGenreName($this->getPDO(), "this genre name never existed");
		$this->assertCount(0, $genre);
	}
	/**
	 *test grabbing all genres
	**/
	public function testGetAllValidGenres() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("genre");
		//create a new Genre and insert it into mySQL
		$genre = new Genre(null, $this->VALID_GENRENAME);
		$genre->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Genre::getsAllGenres($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Genre", $results);
		//grab the result from the array and validate it
		$pdoGenre = $results[0];
		$this->assertEquals($pdoGenre->getGenreName(), $this->VALID_GENRENAME);
	}
}
