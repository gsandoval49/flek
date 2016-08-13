<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Genre};

//grab teh project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
require_once ("FlekTest.php");

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
		$genre = new Genre(null, $this->VALLID_GENRENAME);
		$genre->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoGenre = Genre::getGenrebyGenreId($this->getPDO(), $genre->getGenreId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("genre"));
		$this->assertEquals($pdoGenre->getGenreName(), $this->VALID_GENRENAME);
	}
	/****/


}
