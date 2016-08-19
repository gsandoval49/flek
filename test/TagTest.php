<?php

/**
 * class will consist of tagId and tagName
 * Primary key will be tagId
 * No foreign keys
 *
 *
 **/

namespace Edu\Cnm\Flek\Test;
use Edu\Cnm\Flek\{Tag};

// grab the class that's going through the x-ray and under the knife :)
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
// grab the project test parameters
require_once("FlekTest.php");


/**
 * Full PHPUnit test for the Tag class
 *
 * Unit testing for Tag class
 * @see Tag
 * @author Giles Sandoval <gsandoval49@cnm.edu> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class TagTest extends FlekTest {
    /**
     * Name of the Tag
     * @var string $VALID_TAGNAME
     **/
    protected $VALID_TAGNAME = "Mural";
    /**
     * NAME of the updated tag
     * @var string $VALID_TAGNAME2
     **/
    protected $VALID_TAGNAME2 = "Street";
    /**
     * Test inserting a valid tag and verifying that mySQL data matches
     **/
    public function testInsertValidTag() {
        // NO DEPENDENT OBJECTS - didn't create dependent objects code aka setUp
        // count the number of rows and save it for later later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert into mySQL
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertEquals($pdoTag->getTagName($this->VALID_TAGNAME), $this->VALID_TAGNAME);
    }

    /**
     * test inserting a Tag that already exists
     *
     * @expectedException PDOException
     **/
    public function testInsertInvalidTag() {
        // create a Tag with a non null tag id and watch it fail
        $tag = new Tag(FlekTest::INVALID_KEY, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());
    }

    /**
     * test inserting a Tag, editing it, and then updating it
     **/
    public function testUpdateValidTag() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert into mySQL
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());

        // edit the Tag and update it in mySQL
        $tag->setTagName($this->VALID_TAGNAME2);
        $tag->update($this->getPDO());

        // grab the data from mySQL and enforce the fields to match our expectations
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME2);
    }

    /**
     * test updating a Tag that already exists
     *
     * @expectedException PDOException
     **/
    public function testUpdateInvalidTag() {
        // create a tag with a non null tag id and watch it fail
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->update($this->getPDO());
    }

    /**
     * test updating a Tag and then deleting it
     **/
    public function testDeleteValidTag() {
        //count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert into mySQL
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());

        // delete the Tag from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $tag->delete($this->getPDO());

        // grab the data from mySQL and enforce the Tag does not exist
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertNull($pdoTag);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("tag"));
    }

    /**
     * test deleting a Tag that does NOT exist
     *
     * @expectedException PDOException
     **/
    public function testDeleteInvalidTag() {
        //create a Tag and try to delete it without actually inserting it
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->delete($this->getPDO());
    }

    /**
     * test grabbing a Tag that does NOT exist
     **/
    public function testGetInvalidTagByTagId() {
        // grab a profile id that exceeds the maximum allowable profile id
        $tag = Tag::getTagByTagId($this->getPDO(), FlekTest::INVALID_KEY);
        $this->assertNull($tag);
    }

    /**
     * test grabbing a Tag by tag NAME
     **/
    public function testGetValidTtagByTagName() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoTag = Tag::getTagByTagName($this->getPDO(), $tag->getTagName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
    }



    /**
     * test grabbing a Tag by name that does not exist, apparently Dylan didn't do this :)
     **/
    public function testGetInvalidTagByTagName() {
        // grab a tag by name that does NOT exist
        $tag = Tag::getTagByTagName($this->getPDO(), "this tag does not exist");
        $this->assertNull($tag);
    }

    /**
     * test grabbing all Tags
     **/
    public function testGetAllValidTags() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Ttag and insert into mySQL
        $tag = new Tag(null, $this->VALID_TAGNAME);
        $tag->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Tag::getsAllTags($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertCount(1, $results);

        // grab the result from the array and validate it
        $pdoTag = $results[0];
        $this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
    }
}