<?php
namespace Edu\Cnm\Flek\Test;

use Edu\Cnm\Flek\{
	Hashtag, Tag, Genre
};

//grab the project test parameters
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");
require_once("FlekTest.php");

class TagTest extends FlekTest {

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
		$this->image = new Image(null, "filename", "image/jpg");
		$this->image->insert($this->getPDO());
	}


}
