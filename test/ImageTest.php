<?php
namespace Edu\Cnm\Flek\DataDesign\Test;

use Edu\Cnm\Flek\DataDesign\Image;

// grab the class under scrutiny
require_once("ImageTest.php");

//grab the class
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/*
 * Full PHPUnit test for the Image class
 *
 * This is a complete PHPUnit test of the Image class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Image
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 */
class ImageTest extends DataDesignTest {
	/*
	 * content of the Image
	 * @var int $VALID_IMAGEPROFILEID
	 */
	protected $VALID_IMAGE = "Image uploaded is passing";

	/*
	 * description of the uploaded image
	 * @var string $VALID_IMAGEDESCRIPTION
	 */
	protected $VALID_CONTENT = "Image test is still passing!";
	/*
	 * secure url of the image
	 * @var string $VALID_IMAGESECUREURL
	 */
	protected $VALID_SECUREURL = "DKJFKFKJ34245435";

	/*
	 * public id for the image uploaded
	 * @var string $VALID_IMAGEPUBLICID
	 */
	protected $VALID_PUBLIC = "DKJF23409340939404040";

	/*
	 * genre id for image uploaded
	 * @var int $VALID_IMAGEGENREID
	 */
	protected $VALID_GENRE = "Graffiti Artists";

	/*
	 * valid name of image
	 * $imageProfileId
	 */

	protected $VALID_IMAGENAME = "My pieces of art";

	/*
 * profile that created the image; this is for the foreign key relations
 * @var imageProfileId
 */
	protected $image = null;

	/*
	 * profile that creates image; this is for the foreign key relations
	 * @var imageProfileId
	 */
	protected $profile = null;

	/*
	 * create dependent objects before running each test
	 */
	public final function setUp() {
	//run the default setUp() method first
		parent::setup();

		//create and insert a image to own the test
		$this->image = new Image(null, "pictures of art", "here in the Land of Enchantment", "100 degrees", "2848394850596505050505",
			"connectwithart.com");
		$this->image->insert($this->getPDO());

		//create a user that owns the image
		$this->user = new User(null, "Arlene", "so many type of art to see", "local artists in the state of new mexico", "
		art lovers are welcome");
		$this->user->insert($this->getPDO());

}

/*
 * test inserting a valid Image and verify that the actual mySQL data matches
 */
	public function testInsertValidImage() {
		//count the number of rows and svaid it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert to into mySQL
		$image = new Image(null, $this->VALID_CONTENT, $this->VALID_IMAGE, $this->VALID_SECUREURL, $this->VALID_PUBLIC,
			$this->VALID_IMAGENAME, $this->VALID_GENRE);
		$image->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(),
			$image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getImageProfileId());
		$this->assertEquals($pdoImage->getImageDecription(), $this->VALID_CONTENT);
		$this->assertEquals($pdoImage->getImageSecureURl(), $this->VALID_SECURE);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_PUBLIC);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_GENRE);
	}

	/*
	 * test inserting a image that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidImage() {
	//create a image with a non null image id and watch it fail
		$image = new Image(DataDesignTest::INVALID_KEY, $this->profile->getImageProfileId(), $this->VALID_CONTENT,
			$this->VALID_SECURE, $this->VALID_PUBLIC, $this->VALID_GENRE);
		$image->insert($this->getPDO());
	}

	/*
	 * test inserting a image, editing it and then updating it
	 */
	public function testUpdateValidImage() {
	//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");
		//create a new Image and insert to into mySQL
		$image = new Image(null, $this->profile->getImageProfileId(), $this->VALID_IMAGE, $this->VALID_CONTENT,
		$this->VALID_PUBLIC, $this->VALID_SECUREURL, $this->VALID_GENRE);
		$image->insert($this->getPDO());
		//edit the Image and update it in mySQL
		$image->setImageDescription($this->VALID_CONTENT);
		$image->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getImageProfileId());
		$this->assertEquals($pdoImage->getImageDescription(), $this->VALID_CONTENT);
		$this->assertEquals($pdoImage->getImageSecureUrl(), $this->VALID_SECUREURL);
		$this->assertEquals($pdoImage->getImagePublicId(), $this->VALID_PUBLIC);
		$this->assertEquals($pdoImage->getImageGenreId(), $this->VALID_GENRE);

}

/*
 * test updating a Image that already exists
 *
 * @expectedException PDOException
 */
	public function testUpdateInvalidImage() {
	//create a Image, try to update it without actually updating it and watch it fail
	$image = new Image(null, $this->profile->getImageProfileId(), $this->VALID_CONTENT, $this->VALID_SECUREURL, $this
	->VALID_PUBLIC, $this->VALID_GENRE);
			$image->update($this->getPDO());
}

/*
 * test creating a Image and then deleting it
 */
public function testDeleteValidImage() {
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("image");

	//creat a new Image and insert to into mySQL
	$image = new Image(null, $this->profile->getImageProfileId(), $this->VALID_CONTENT, $this->VALID_SECUREURL,
	$this->VALID_PUBLIC, $this->VALID_GENRE);
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
	$image = new Image(null, $this->profile->getImageProfileId, $this->VALID_CONTENT, $this->VALID_SECUREURL,
		$this->VALID_PUBLIC, $this->VALID_GENRE);
	$image->delete($this->getPDO());
}

/*
 * test inserting a Image and regrabbing it from mySQL
 */
public function testGetValidImageByImageId() {
	//count the number of rows and save it for later
}