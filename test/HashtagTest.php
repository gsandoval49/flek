<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
    Hashtag, Tag
};
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
     * Hashtag content for the tag.
     * @var string $VALID_HASHTAG_CONTENT
     **/
    protected $VALID_HASHTAG_CONTENT = "This better work";
    /**
     * content of the updated hashtag
     * @var string $VALID_HASHTAG_CONTENT2
     **/
    protected $VALID_HASHTAG_CONTENT2 = "This part better work too!";
    /**
     * Test inserting a valid hashtag and verifying that mySQL data matches
     **/
    public function testInsertValidHashtag() {
         // NO DEPENDENT OBJECTS - didn't create dependent objects code aka setUp
         // count the number of rows and save it for later later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);
        $hashtag->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match

        $pdoHashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), $hashtag->getHashtagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagName($this->VALID_HASHTAG_CONTENT), $this->VALID_HASHTAG_CONTENT); //do i need valid hashtag content twice?
    }

    /**
     * test inserting a Hashtag that already exists
     *
     * @expectedException PDOException
     **/
    public function testInsertInvalidHashtag() {
        $hashtag = new Hashtag(FlekTest::INVALID_KEY, $this->VALID_HASHTAG_CONTENT);
        $hashtag->insert($this->getPDO());
    }

    /**
     * test inserting a Hashtag, editing it, and then updating it
     **/
    public function testUpdateValidHashtag() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);

        // edit the Hashtag and update it in mySQL
        $hashtag->setHashtagName($this->VALID_HASHTAG_CONTENT2);
        $hashtag->update($this->getPDO());

        // grab the data from mySQL and enforce the fields to match our expectations
        $pdoHashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), $hashtag->getHashtagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAG_CONTENT2);
    }

    /**
     * test updating a Hashtag and then deleting it
     **/
    public function testDeleteValidHashtag() {
        //count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);
        $hashtag->insert($this->getPDO());

        // delete the Hashtag from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $hashtag->delete($this->$this->getPDO());

        // grab the data from mySQL and enforce the Hashtag does not exist
        $pdoHashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), $hashtag->getHashtagId());
        $this->assertNull($pdoHashtag);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("hashtag"));
    }

    /**
     * test deleting a Hashtag that does NOT exist
     *
     * @expectedException PDOException
     **/
    public function testDeleteInvalidHashtag() {
        //create a Hashtag and try to delete it without actually inserting it
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);
        $hashtag->delete($this->getPDO());
    }

    /**
     * test grabbing a Hashtag by hashtag content
     **/
    public function testGetValidHashtagByHashtagContent() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert to into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);
        $hashtag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Hashtag::getHashtagByHashtagName($this->getPDO(), $hashtag->getHashtagName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoHashtag = $results[0];
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAG_CONTENT);
    }

    /**
     * test grabbing a Hashtag that does NOT exist
     **/
    public function testGetInvalidHashtagByHashtagId() {
        // grab a profile id that exceeds the maximum allowable profile id
        $hashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), FlekTest::INVALID_KEY);
        $this->assertNull($hashtag);
    }

    /**
     * test grabbing a Hashtag by content that does not exist, apparently Dylan didn't do this :)
     **/
    public function testGetInvalidHashtagByHashtagName() {
        // grab a hashtag by content that does NOT exist
        $hashtag = Hashtag::getHashtagByHashtagName($this->getPDO(), "nobody ever made this HASHTAG according to the other gsandoval");
        $this->assertCount(0, $hashtag);
    }

    /**
     * test grabbing all Hashtags
     **/
    public function testGetAllValidHashtags() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAG_CONTENT);
        $hashtag->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Hashtag::getAllHashtags($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoHashtag = $results[0];
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAG_CONTENT);
    }
}