<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Profile, Image, Tag, Genre, ImageTag
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
	protected $tag = "user created tag";
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
		$this->profile = new Profile(null, "j", "test@phpunit.de", "tibuktu", "I eat chickens, mmmmmkay", "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678", "1234567890123456789012345678901234567890123456789012345678901234", "01234567890", "01234567890123456789012345678901");
		$this->profile->insert($this->getPDO());

		//create and a genre to be linked to image
		$this->genre = new Genre(null, 4, "Painting");
		$this->genre->insert($this->getPDO());

		//create and insert an image that is owned by profile
		$this->image = new Image(null, $this->genre->getGenreId(), $this->profile->getProfileId(), "My 
	pretty image", "www.foobar.com", 2);
		$this->image->insert($this->getPDO());


		// create and insert a tag to be linked to image
		$this->tag = new Tag(null, "Bob");
		$this->tag->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ImageTag and verifying that mySQL data matches
	 **/
	public function testInsertValidImageTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageTag");

		// create a new Tag and insert to into mySQL
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoImageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), $imageTag->getImageTagImageId(), $imageTag->getImageTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageTag"));
		/*$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Image", $results);*/
		$this->assertEquals($pdoImageTag->getImageTagImageId(), $this->image->getImageId());
		$this->assertEquals($pdoImageTag->getImageTagTagId(), $this->tag->getTagId());


	}

	/**
	 * test inserting an imageTag that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidImageTag() {
		// create a imageTag with a non null tag id and watch it fail
		$imageTag = new ImageTag(FlekTest::INVALID_KEY, $this->tag->getTagId());
		$imageTag->insert($this->getPDO());
	}

	/**
	 * test creating a imageTag then deleting it
	 **/
	public function testDeleteValidImageTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		// create a new imageTag and insert to into mySQL
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->insert($this->getPDO());
		// delete the imageTag from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageTag"));
		$imageTag->delete($this->getPDO());
		// grab the data from mySQL and enforce that the imageTag does not exist
		$pdoImageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), $imageTag->getImageTagImageId(), $imageTag->getImageTagTagId());
		$this->assertNull($pdoImageTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("imageTag"));
	}

	/**
	 * test deleting a imageTag that does not exist
	 *
	 **/
	public function testDeleteInvalidImageTag() {
		// create a imageTag and try to delete it without actually inserting it
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->delete($this->getPDO());
	}

	/**
	 * testing a tag by valid image id
	 **/
	public function testGetValidImageTagByImageTagImageId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		//create a new imageTag and insert it into mySQL
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->insert($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$results = ImageTag::getImageTagByTagImageId($this->getPDO(), $imageTag->getImageTagImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\ImageTag", $results);
		//grab the results from the array and validate them
		$pdoImageTag = $results[0];
		$this->assertEquals($pdoImageTag->getImageTagImageId(), $this->image->getImageId());
		$this->assertEquals($pdoImageTag->getImageTagTagId(), $this->tag->getTagId());
	}

	/**
	 * testing an imageTag by invalid image id
	 **/

	public function testGetInavlidImageTagByImageTagImageId() {
		//grab an image id that exceeds max allowed
		$imageTag = ImageTag::getImageTagByTagImageId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertCount(0, $imageTag);
	}

	/**
	 * testing a tag by valid tag id
	 **/
	public function testGetValidImageTagByImageTagTagId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		//create a new imageTag and insert it into mySQL
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->insert($this->getPDO());
		//grab the data from mySQL and enforce that the fields match our expectations
		$results = ImageTag::getImageTagByTagId($this->getPDO(), $imageTag->getImageTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\ImageTag", $results);
		//grab the results from the array and validate them
		$pdoImageTag = $results[0];
		$this->assertEquals($pdoImageTag->getImageTagImageId(), $this->image->getImageId());
		$this->assertEquals($pdoImageTag->getImageTagTagId(), $this->tag->getTagId());
	}


	/**
	 * test get imageTag by valid image id and tag id
	 **/
	public function testGetValidImageTagByImageIdAndTagId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		// create a new Tag and insert to into mySQL
		$imageTag = new ImageTag($this->image->getImageId(), $this->tag->getTagId());
		$imageTag->insert($this->getPDO());

		// grab the data from mySQL and enforce that the fields match our expectations
		$pdoImageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), $imageTag->getImageTagImageId(), $imageTag->getImageTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("imageTag"));
		$this->assertEquals($pdoImageTag->getImageTagImageId(), $this->image->getImageId());
		$this->assertEquals($pdoImageTag->getImageTagTagId(), $this->tag->getTagId());
	}


	/**
	 * test get imageTag and invalid image id, tag id
	 **/
	public function testGetImageTagByImageIdAndTagId() {
		//grab an image id that exceeds maximum allowed
		$imageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), FlekTest::INVALID_KEY, FlekTest::INVALID_KEY);
		$this->assertNull($imageTag);
	}

}



