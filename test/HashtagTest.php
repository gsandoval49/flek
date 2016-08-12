<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Hashtag};
use PDOException;

//grab the project test parameters
require_once("HashtagTest.php");

// grab the class that's going through the x-ray and under the knife :)
require_once (dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Hashtag class
 *
 * This is a complete test of the Hashtag class. It is complete because ALL mySQL/PDO enabled methods are tested for both invalid and valid inputs
 *
 * @see Hashtag
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 **/
class HashtagTest extends FlekTest {
    /**
     * Hashtag name created by profile.
     * @var string $VALID_HASHTAG_LABEL
     **/
    protected $VALID_HASHTAG_LABEL = "This better work";
    /**
     * Test inserting a valid hashtag and verifying that mySQL data matches
     **/
    public function testInsertValidHashtag() {
        // Count the number of rows and save it for later later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // Create a new hashtag and insert it into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_LABEL);
        $hashtag->insert($this->getPDO());

        // Grab the data from mySQL and check the fields against our expectations
        $pdoHashtag = Hashtag::getHashtagByHashtagName($this->getPDO(), $hashtag->getHashtagName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagLabel(), $this->VALID_HASHTAG_LABEL);
    }


}