<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Hashtag, Tag
};

//grab the project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
require_once("FlekTest.php");

class TagTest extends FlekTest {

	//Id of the tag itself
	protected $tagId;
	//content of the Tag
	protected $VALID_TAGCONTENT;
	//Id from the image
	protected $tagImageId;
	//Id from the hashtag
	protected $tagHashtagId;


	public final function setUp() {
		// run the default setUp method first
		parent::setUp();
		// create and insert a Hashtag to own the test Tag
		$this->hashtag = new Hashtag(null, "booya", "content");
		$this->hashtag->insert($this->getPDO());
		// create and insert an Image to own the test Tag
		$this->image = new Image(null, "filename", "image");
		$this->image->insert($this->getPDO());
	}
	public function testInsertValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null,$this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName($this->tagImageId), $this->tagHashtagId);
	}
	/**
	 * test inserting a Tag that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testInsertInvalidTag() {
		// create a Tag with a non null tag id and watch it fail
		$tag = new Tag(FlekTest::INVALID_KEY, $this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
	}
	/**
	 * test inserting a Tag editing it and then updating it
	 **/
	public function testUpdateValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
		// edit the Tag and update it in mySQL
		$tag->setTagName($this->tagImageId, $this->tagHashtagId2);
		$tag->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->tagImageId, $this->tagHashtagId2);
	}
	/**
	 * test updating a Tag that does not exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidTag() {
		// create a Tag with a non null tag id and watch it fail
		$tag = new Tag(null,  $this->tagImageId, $this->tagHashtagId);
		$tag->update($this->getPDO());
	}
	/**
	 * test creating a Tag then deleting it
	 **/
	public function testDeleteValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
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
	 * test deleting a Tag that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidTag() {
		// create a Tag and try to delete it without actually inserting it
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
		$tag->delete($this->getPDO());
	}
	/**
	 * test grabbing a Tag by tag content
	 **/
	public function testGetValidTagByTagContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getTagByTagContent($this->getPDO(), $tag->getTagName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		// grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagName(), $this->tagImageId, $this->tagHashtagId);
	}
	/**
	 * test grabbing a Tag that does not exist
	 **/
	public function testGetInvalidTagByTagId() {

		$tag = Tag::getTagByTagId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertNull($tag);
	}
	/**
	 * test grabbing a Tag by content that does not exist- not in documentation
	 **/
	public function testGetInvalidTagByTagContent() {
		// grab a tag by content that does not exist
		$tag = Tag::getTagByTagContent($this->getPDO(), "this is not a valid Tag");
		$this->assertCount(0, $tag);
	}
	/**
	 * test grabbing all Tags
	 **/
	public function testGetAllValidTags() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getAllTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		// grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagName(), $this->tagImageId, $this->tagHashtagId);
	}

	}



