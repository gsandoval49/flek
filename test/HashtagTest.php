<?php

/**
 * class will consist of hashtagId and hashtagName
 * Primary key will be hashtagId
 * No foreign keys
 *
 * Testing will be on insertHashtag (A profile creates hashtags when they link it to an image or describe an image), updateHashtag (A profile may change hashtags after listing), deleteHashtag (A profile may delete a listing), getHashtagByHashtagId (HashtagId is a foreign key on another class?) and getHashtagByHashtagName (a profile may search for an item by hashtag name)
 *
 * @see Hashtag
 * @author Giles Sandoval <gsandoval49@cnm.edu> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 **/

namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\Hashtag;
use PDOException;


// grab the project test parameters
require_once("HashtagTest.php");

// grab the class that's going through the x-ray and under the knife :)
require_once (dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Hashtag class
 *
 * Unit testing for Hashtag class
 **/
class HashtagTest extends FlekTest {
    /**
     * Name of the Hashtag
     * @var string $VALID_HASHTAGNAME
     **/
    protected $VALID_HASHTAGNAME = "Red Mural";
    /**
     * NAME of the updated hashtag
     * @var string $VALID_HASHTAGNAME2
     **/
    protected $VALID_HASHTAGNAME2 = "Street Art";
    /**
     * Test inserting a valid hashtag and verifying that mySQL data matches
     **/
    public function testInsertValidHashtag() {
         // NO DEPENDENT OBJECTS - didn't create dependent objects code aka setUp
         // count the number of rows and save it for later later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoHashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), $hashtag->getHashtagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagName($this->VALID_HASHTAGNAME), $this->VALID_HASHTAGNAME);
    }

    /**
     * test inserting a Hashtag that already exists
     *
     * @expectedException PDOException
     **/
    public function testInsertInvalidHashtag() {
        // create a Hashtag with a non null hashtag id and watch it fail
        $hashtag = new Hashtag(FlekTest::INVALID_KEY, $this->VALID_HASHTAGNAME);
        $hashtag->insert($this->getPDO());
    }

    /**
     * test inserting a Hashtag, editing it, and then updating it
     **/
    public function testUpdateValidHashtag() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->insert($this->getPDO());

        // edit the Hashtag and update it in mySQL
        $hashtag->setHashtagName($this->VALID_HASHTAGNAME2);
        $hashtag->update($this->getPDO());

        // grab the data from mySQL and enforce the fields to match our expectations
        $pdoHashtag = Hashtag::getHashtagByHashtagId($this->getPDO(), $hashtag->getHashtagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAGNAME2);
    }

    /**
     * test updating a Hashtag that already exists
     *
     * @expectedException PDOException
     **/
    public function testUpdateInvalidHashtag() {
        // create a hashtag with a non null hashtag id and watch it fail
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->update($this->getPDO());
    }

    /**
     * test updating a Hashtag and then deleting it
     **/
    public function testDeleteValidHashtag() {
        //count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
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
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->delete($this->getPDO());
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
     * test grabbing a Hashtag by hashtag NAME
     **/
    public function testGetValidHashtagByHashtagName() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert to into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoHashtag = Hashtag::getHashtagByHashtagName($this->getPDO(), $hashtag->getHashtagName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAGNAME);
    }



    /**
     * test grabbing a Hashtag by name that does not exist, apparently Dylan didn't do this :)
     **/
    public function testGetInvalidHashtagByHashtagName() {
        // grab a hashtag by name that does NOT exist
        $hashtag = Hashtag::getHashtagByHashtagName($this->getPDO(), "this hashtag does not exist");
        $this->assertNull($hashtag);
    }

    /**
     * test grabbing all Hashtags
     **/
    public function testGetAllValidHashtags() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("hashtag");

        // create a new Hashtag and insert into mySQL
        $hashtag = new Hashtag(null, $this->VALID_HASHTAGNAME);
        $hashtag->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Hashtag::getAllHashtags($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("hashtag"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoHashtag = $results[0];
        $this->assertEquals($pdoHashtag->getHashtagName(), $this->VALID_HASHTAGNAME);
    }
}