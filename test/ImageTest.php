<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{Image, Profile};

// grab the class under scrutiny
require_once("FlekTest.php");

//grab the class
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/*
 * Full PHPUnit test for the Image class
 *
 * This is a complete PHPUnit test of the Image class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Image
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 */
class ImageTest extends FlekTest {

	protected $VALID_IMAGEPROFILEID = null;

	/*
	 * description of the uploaded image
	 * @var string $valid_imagedescription
	 */
	protected $VALID_IMAGEDESCRIPTION = "Image test is still passing!";
	/*
	 * secure url of the image
	 * @var string $VALID_IMAGESECUREURL
	 */
	protected $VALID_IMAGESECUREURL = "DKJFKFKJ34245435";

	/*
	 * public id for the image uploaded
	 * @var string $VALID_IMAGEPUBLICID
	 */
	protected $VALID_IMAGEPUBLICID = "DKJF23409340939404040";

	/*
	 * genre id for image uploaded
	 * @var int $VALID_IMAGEGENREID
	 */
	protected $VALID_IMAGEGENREID = "123456789000";

	/**
	 * profile that creates image; this is for the foreign key relations
	 * @var PROFILE profile
	 **/
	protected $profile = null;

	private $hash;

	private $salt;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		//run the default setUp() method first
		parent::setup();

		$this->VALID_PROFILEACCESSTOKEN = bin2hex(random_bytes(16));
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$password = "abc123";
		$this->salt = bin2hex(random_bytes(32));
		$this->hash = hash_pbkdf2("sha256", "abc123", $this->salt, 262144);

		$this->profile = new Profile(null, "csosa4", "foo@bar.com", "Rio, Rancho", "test is passing", $this->hash, $this->salt, "01234567890", "01234567890123456789012345678901");
		$this->profile->insert($this->getPDO());

/*		*$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $this->profile->getProfileId());*/

	}
/**
 * test inserting a valid Image and verify that the actual mySQL data matches
**/
	public function testInsertValidImage() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert to into mySQL
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL, $this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
		$image->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageSecureUrl(), $this->VALID_IMAGESECUREURL);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_IMAGEPUBLICID);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_IMAGEGENREID);
	}

	/*
	 * test inserting a image that already exists
	 *
	 * @expectedException PDOException
*/
	public function testInsertInvalidImage() {
	//create a image with a non null image id and watch it fail
		$image = Image(FlekTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION,
			$this->VALID_IMAGESECUREURL, $this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID, $this->hash, $this->salt);
		$image->insert($this->getPDO());

	}

	/*
	 * test inserting a image, editing it and then updating it
*/
	public function testUpdateValidImage() {
	//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");
		//create a new Image and insert to into mySQL
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION,
		$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGESECUREURL, $this->VALID_IMAGEGENREID);
		$image->insert($this->getPDO());
		//edit the Image and update it in mySQL
		$image->setImageDescription($this->VALID_IMAGEDESCRIPTION);
		$image->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getImageProfileId());
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageSecureUrl(), $this->VALID_IMAGESECUREURL);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_IMAGEPUBLICID);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_IMAGEGENREID);

}

/*
 * test updating a Image that already exists
 *
 * @expectedException PDOException
*/
	public function testUpdateInvalidImage() {
	//create a Image, try to update it without actually updating it and watch it fail
	$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL, $this
	->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
			$image->update($this->getPDO());
}

/*
 * test creating a Image and then deleting it
*/
public function testDeleteValidImage() {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("image");

	//create a new Image and insert to into mySQL
	$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL,
	$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
	$image->insert($this->getPDO());

	//delete the Image from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
	$image->delete($this->getPDO());

	//grab the data from mySQL and enforce the Tweet does not exist
	$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
	$this->assertNull($pdoImage);
	$this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));

}

/*
 * test deleting a Image that does not exist
 *
 * @expectedException PDOException
*/
public function testDeleteInvalidImage() {
 	//create a Image and try to delete it without actually inserting it
	$image = new Image(null, $this->profile->getProfileId, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL,
		$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
	$image->delete($this->getPDO());
}

/*
 * test inserting a Image and regrabbing it from mySQL
*/
public function testGetValidImageByImageId() {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("image");
	//create a new Image and insert to into mySQL
	$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEPROFILEID, $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL,
		$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID, null);
	$image->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields to match our expectations
	$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
	$this->assertEquals($pdoImage->getImageProfileId(),
		$this->profile->getImageId());
	$this->assertEquals($pdoImage->getImageDescription(),
		$this->VALID_IMAGEDESCRIPTION);
	$this->assertEquals($pdoImage->getImageSecureUrl(),
		$this->VALID_IMAGESECUREURL);
	$this->assertEquals($pdoImage->getImagePublicId(),
		$this->VALID_IMAGEPUBLICID);
	$this->assertEquals($pdoImage->getImageGenreId(),
		$this->VALID_IMAGEGENREID);
}

/*
 * test grabbing a Image that does not exist
*/
	public function testGetInvalidImageByImageId() {
		//grab a profile id that exceeds the maxiumum allowable image profile id
		$image = Image::getImageByImageId($this->getPDO(), FlekTest::INVALID_KEY);
		$this->assertNull($image);
}
	/*
	 * test grabbing a Image by Image description
*/
	public function testGetValidImageByImageContent() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new Image and insert to into mySQL
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEDESCRIPTION, $this->VALID_IMAGESECUREURL,
			$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
		$image->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Image::getImageByImageContent($this->getPDO(), $image->getImageDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Image", $results);

		/*
		 * grab the result from the array and validate it
*/
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageSecureUrl(), $this->VALID_IMAGESECUREURL);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_IMAGEPUBLICID);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_IMAGEGENREID);
	}

	/*
	 * test grabbing a Image by description that does not exist
*/
	public function testGetInvalidImageByImageDescription() {
		//grab a image by searching for content that does not exist
		$image = Image::getImageByImageDescription($this->getPDO(), "there will be nothing");
		$this->assertCount(0, $image);
	}

	/*
	 * test grabbing all Images
*/
	public function testGetAllValidImages() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new Image and insert to into mySQL
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGEPUBLICID, $this->VALID_IMAGESECUREURL,
		$this->VALID_IMAGEPUBLICID, $this->VALID_IMAGEGENREID);
		$image->insert($this->getPDO());

		//grab the data from myQL and enforced the field match our expectations
		$results = ImageTest::getAllImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Flek\\Test\\Image", $results);

		//grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_IMAGEDESCRIPTION);
		$this->assertEquals($pdoImage->getImageSecureUrl(), $this->VALID_IMAGESECUREURL);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_IMAGEPUBLICID);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_IMAGEGENREID);

		}
		}
