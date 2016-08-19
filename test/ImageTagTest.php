<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Profile, Image, Tag, Genre, ImageTag
// why is it grey, moving on and if comes up later during in test we'll deal...
};

//grab the project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
require_once("FlekTest.php");

/**
 * Full PHPunit test for the image tag class
 *
 * @see \Edu\Cnm\Flek\ImageTag
 * @author Christina Sosa <csosa4@cnm.edu>, Rob Harding <rharding6@cnm.edu>, Giles Sandoval <gsandoval49@cnm.edu>
 *
 **/
class ImageTagTest extends FlekTest {
    /**
     * profile that posted the image;
     * @var int Profile profile
     **/
    protected $profile = null;
    /**
	 * image associated with image being reviewed
     * @var int Image image
	**/
	protected $image = null;
	/**
	 * tag that is linked to image
	 * @var string Tag tag
	 **/
	protected $tag = null;
    /**
     * genre that is linked to image
     * @var string Genre genre
     **/
    protected $genre = null;

	/**
	 * create dependent objects for each foreign key before running test
	 **/
	public final function setUp() {
		// run the default setUp method first
		parent::setUp();

        // create and insert a profile that owns the image
        // access and activation are included for test purposes; delete if we don't need.
        $this->profile = new Profile(null, $this->profile->getProfileId(), 130, "John", "foo@bar.com", "Albuquerque", "Hey I am John", $hash, $salt, "fds456", "12345678901234567890123456789012");

		//access and activation token & salt and hash generation
        $password = "madeup4";
		// $this->VALID_PROFILEACCESSTOKEN = bin2hex(random_bytes(16)); made a dumby above in profile
		// $this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16)); made a dumby above in profile
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha256", "abc123", $this->salt, 262144);

        // create and insert an image that owns the image tag
        // $this->imageTag = new ImageTag(null, "121", "540", "320", "painting", "www.foobar.com", "xyz345"); comment out because we don't need...i don't think
        // $this->imageTag->insert($this->getPDO()); "this is a son of a bitch, man" CSosa

		// create and insert a tag for an image
		$this->tag = new Tag(null, "951", "")




		//create and insert a Hashtag to own the test tag
		$this->new Tag(null, $this->);

		//create a tag to be linked with Image
		$this->tag = new ImageTag(null, "");
		$this->tag->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Tag and verifying that mySQL data matches
	 **/
	public function testInsertValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tagImageId, $this->tagHashtagId);
		$tag->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getTagByTagId($this->getPDO(), $tag->getTagImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCounts(1, $results);
		//grab the results from the array and validate them
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagImageId(), $this->image->getImageId());
		$this->assertEquals($pdoTag->getTagHashtagId(), $this->hashtag->getHashtagId());
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
		$pdoTag = Tag::getTagByTagIdAndHashTagId($this->getPDO(), $tag->getTagImageId(), $tag->getTagHashtagId());
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
		$tag = new Tag(null, $this->image->tagImageId, $this->hashtag->tagHashtagId);
		$tag->delete($this->getPDO());

		/**
		 * testing a tag by valid image id
		 **/
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");
		//create a new tag and insert it into mySQL
		$tag = new Tag($this->image->getImageId(), $this->hashtag->getHashtagId());
		$tag->insert($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$results = Tag::getImageByImageId($this->getPDO, tag->getImageId);
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Tag", $results);
	//grab the results from the array and validate them
	$pdoTag = $results[0];
	$this->assertEquals($pdoTag->getTagImageId(), $this->image->getImageId());
	$this->assertEquals($pdoTag->getHashtagId(), $this->hashtag->getHashtagId());
}

	/**
	 * testing get tag by valid
	 **/
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



