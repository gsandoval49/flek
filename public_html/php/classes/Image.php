<?php
namespace Edu\Cnm\Flek;

require_once("autoload.php");
/**
 *
 * This image can be a small example when the images are stored in the Profile of the user.
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 * @version 1.0.0
 */
class Image implements \JsonSerializable {
	/**
	id for Image: this is the primary key
	* @var int $imageId
	 */
	private $imageId;
	/**
	 * id to identify the genre the image is assigned to
	 * @var int $imageGenreId
	 */
	private $imageGenreId;

	/**
	 * id of the profile that sent this Image;
	 * @var int $imageProfileId
	 */
	private $imageProfileId;
	/**
	 * textual description of the Image
	 * @var string $imageDescription
	 */
	private $imageDescription;
	/**
	 * url sent when image is uploaded
	 * @var string $imageSecureUrl
	 */
	private $imageSecureUrl;
	/**
	 * id sent to identify the image uploaded
	 * @var string $imagePublicId
	 */
	private $imagePublicId;


	/**
	 * constructor for the Image
	 * @param int|null $newImageId of this Image or null
	 * @param int|null $newImageProfileId of the profile that sent this Image
	 * @param string $newImageDescription string containing acutal profile data
	 * @param string $newImageSecureUrl string containing url of the image uploaded
	 * @param string $newImagePublicId string containing id of the image uploaded
	 * @param string int|null $newImageGenreId of the image genre or null
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of range
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newImageId = null,int $newImageGenreId = null, int $newImageProfileId, string $newImageDescription, string $newImageSecureUrl, string $newImagePublicId) {
		try {
			$this->setImageId($newImageId);
			$this->setImageGenreId($newImageGenreId);
			$this->setImageProfileId($newImageProfileId);
			$this->setImageDescription($newImageDescription);
			$this->setImageSecureUrl($newImageSecureUrl);
			$this->setImagePublicId($newImagePublicId);

		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException(
				$invalidArgument->$invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new\RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new\Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for image id
	 * @return int|null value of image id
	 */
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * mutator method for image id
	 * @param int|null $newImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 */
	public function setImageId(int $newImageId = null) {
//if image is null this a new image
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}
		//verify the image id is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		//convert and store the image id
		$this->imageId = $newImageId;
	}

	/**
	 * accessor method for imageProfileId
	 * @return int|null value of imageProfileId
	 */
	public function getImageProfileId() {
		return ($this->imageProfileId);
	}

	/**
	 * mutator method for image profile Id
	 * @param int $newImageProfileId new value of image profile id
	 * @throws \RangeException if @newImageProfileId is not positive
	 */
	public function setImageProfileId(int $newImageProfileId) {
		//verify the image profile id is positive
		if($newImageProfileId <= 0) {
			throw(new \RangeException("image profile id is not positive"));
		}
		//convert and store image profile id
		$this->imageProfileId = $newImageProfileId;
	}

	/**
	 * accessor method for imageDescription
	 * @return string value of image description
	 */
	public function getImageDescription() {
		return ($this->imageDescription);
	}

	/**
	 * mutator method for image Description
	 * @throw method for image Description
	 */
	public function setImageDescription(string $newImageDescription) {
		//verify the image description is secure
		$newImageDescription = trim($newImageDescription);
		$newImageDescription = filter_var($newImageDescription, FILTER_SANITIZE_STRING);
		if(empty($newImageDescription) === true) {
			throw(new \InvalidArgumentException("image description is empty or insecure"));
		}
		// verify the image content will fin in the database
		if(strlen($newImageDescription) > 128) {
			throw(new \RangeException("image description too large"));
		}
		// store the image content
		$this->imageDescription = $newImageDescription;
	}

	/**
	 * accessor method for image secure url
	 * #return string  value of image secure url
	*/
	public function getImageSecureUrl() {
		return ($this->imageSecureUrl);
	}

	/**
	 *
	 *mutator method for image secure url
	/*
	 * @param string $newImageSecureUrl
	 */
	public function setImageSecureUrl(string $newImageSecureUrl) {
		//verify the image content is secure
		$newImageSecureUrl = trim($newImageSecureUrl);
		$newImageSecureUrl = filter_var($newImageSecureUrl, FILTER_SANITIZE_STRING);
		if(empty($newImageSecureUrl) === true) {
			throw(new \InvalidArgumentException("image content is empty or insecure"));
		}
		if(strlen($newImageSecureUrl) > 140) {
			throw(new \RangeException("image content too large"));
		}
		//convert and store the image secure url
		$this->imageSecureUrl = $newImageSecureUrl;
	}

	/**
	 * accessor method for image public id
	 * @return string $newImagePublicId
	 */
	public function getImagePublicId() {
		return ($this->imagePublicId);
	}

	/**
	 * mutator method for image public id
	 * @param string imagePublicId
	  * @throw string is not positive and string too long
	 */
	public function setImagePublicId(string $newImagePublicId) {
		//verify the public id is positive/too long
		$newImagePublicId = trim($newImagePublicId);
		$newImagePublicId = filter_var($newImagePublicId, FILTER_SANITIZE_STRING);
		if(empty($newImagePublicId) === true) {
			throw(new \InvalidArgumentException("image content is empty or insecure"));
		} // verify the image public string will fit in the database
		if(strlen($newImagePublicId) > 128) {
			throw(new \RangeException("image description too large"));
			//convert and store the image public id
		}
			$this->imagePublicId = $newImagePublicId;
}
	/**
	 * accessor method for image genre id
	 * @return int|null imageGenreId
	 */
	public function getImageGenreId() {
		return ($this->imageGenreId);
	}

	/**
	 * mutator method for image genre id
	 * @param int $newImageGenreId
	 * @throws image genre id not positive
	 **/
	public function setImageGenreId(int $newImageGenreId = null) {
		if($newImageGenreId == null) {
			$this->imageGenreId = null;
			return;
		}
		$this->imageGenreId = $newImageGenreId;
	}

/**
 * inserts the Image into mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \TypeError if $pdo is not a PDO connection object
 */
		public function insert(\PDO $pdo) {
	//enforce the imageId is null
	if($this->imageId !== null) {
		throw(new \PDOException("not a new image"));
	}
	// create query template
	$query = "INSERT INTO image(imageGenreId, imageProfileId, imageDescription,imageSecureUrl, imagePublicId) VALUES( :imageGenreId, :imageProfileId, :imageDescription, :imageSecureUrl, :imagePublicId)";

			$statement = $pdo->prepare($query);
/*
			//change the format of the boolean imageGenreId
			if($this->imageGenreId === false) {
				$formatGenreId = 0;
			} else{
				$formatGenreId = $this->imageGenreId;
			}*/

	// bind the member variables to the place holders in the template
	$parameters = [ "imageGenreId" =>$this->imageGenreId, "imageProfileId" => $this->imageProfileId, "imageDescription" => $this->imageDescription,
		"imageSecureUrl" => $this->imageSecureUrl, "imagePublicId" => $this->imagePublicId /*$formatGenreId*/];

			$statement->execute($parameters);

	/**
	 * update the null imageId with what mySQL just gave us
	 */
	$this->imageId = intval($pdo->lastInsertId());
}

	/**
	 * updates this Image in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related erros
	 * @throws \TypeError if $pdo is not a PDO coection
	 */
	public function update(\PDO $pdo) {
		//enforce the imageId is not null
		if($this->imageId === null) {
			throw(new \PDOException("unable to update a image that does not exist"));
		}

		// create query template
		$query = "UPDATE image SET imageGenreId = :imageGenreId, imageProfileId = :imageProfileId, imageDescription = :imageDescription, imageSecureURl =
			:imageSecureUrl, imagePublicId = :imagePublicId";
		$statement = $pdo->prepare($query);
/*
		//change the format of the boolean Image Genre Id
		if($this->imageGenreId === false) {
			$formatGenreId = 0;
		}
		else{
			$formatGenreId = $this->imageGenreId;
		}*/
		//bind the member variables to the place holders in the template
		$parameters = ["imageGenreId" => $this->imageGenreId, "imageProfileId" => $this->imageProfileId, "imageDescription" => $this->imageDescription,
			"imageSecureUrl" => $this->imageSecureUrl, "imagePublicId" => $this->imagePublicId, ];

		$statement->execute($parameters);
	}

/**
 * deletes this image from mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors
 * @throws \TypeError if $pdo is no a PDO connection object
 **/
		public function delete(\PDO $pdo) {
	//enforce the imageId is not null
	if($this->imageId === null) {
		throw(new \PDOException("unable to delete image that does not exist"));
	}
	/**
	 * create query template
	 */
	$query = "DELETE FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);

	/**
	 * bind the member variables to the place holder the template
	 */
	$parameters = ["imageId" => $this->imageId];
	$statement->execute($parameters);
}


	/**
	 * gets the Image by content
	 * @param /PDO $pdo PDO connection object
	 * @param string $imageDescription image description to search for
	 * @return \SplFixedArray SplFixedArray of Image found
	 * @throws \PDOException when mySQL related erros
	 * @throws \TypeError when variables are not to correct data type
	 */
		public static function getImagebyImageDescription(\PDO $pdo, string $imageDescription) {
			//sanitize the description before searching
		$imageDescription = trim($imageDescription);
		$imageDescription = filter_var($imageDescription, FILTER_SANITIZE_STRING);
			if(empty($imageDescription) === true) {
				throw(new \PDOException("image description is invalid"));
			}

		// create query template
		$query = "SELECT imageId, imageGenreId, imageProfileId, imageDescription, imageSecureUrl, imagePublicId 
		 	FROM image WHERE imageDescription LIKE :imageDescription";
		$statement = $pdo->prepare($query);

		//bind the image description to the place holder in the template
		$imageDescription = "%$imageDescription%";
		$parameters = ["imageDescription" => $imageDescription];
		$statement->execute($parameters);

		//build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
		try {
			$image = new Image($row["imageId"], $row["imageGenreId"], $row["imageProfileId"], $row["imageDescription"], $row["imageSecureUrl"],
				$row["imagePublicId"], $row["imageGenreId"], $row["imagePublicId"], $row["imageSecureUrl"], $row["imagePublicId"]
				 );
			$images[$images->key()] = $image;
			$images->next();
		} catch(\Exception $exception) {
			// if the row couldn;t be converted rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
		return($images);
}
	/**
	 * gets the image by imageId
	 * @param \PDO $pdo PDO cennection object
	 * @param int $imageId image id to search for
	 * @return image|null image found or null if not found
	 * @throws \PDOException when mySQL related errors
	 * @throws \TypeError when variables are not the correct data types
	 */

		public static function getImageByImageId(\PDO $pdo, int $imageId) {
	// sanitize the imageId before seraching
	if($imageId <= 0) {
		throw(new \PDOException("Image id is not positive"));
	}
	// create query template
	$query = "SELECT imageId, imageGenreId, imageProfileId, imageDescription, imageSecureUrl, imagePublicId FROM 
			image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);
	//bind the image id to the place holder in the template
	$parameter = ["imageId" => $imageId];
	$statement->execute($parameter);

	//grab the image from mySQL
	try {
		$image = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$image = new image($row["imageId"], $row["imageGenreId"], $row["imageProfileId"], $row["imageDescription"], $row["imageSecureUrl"],
				$row["imagePublicId"] );
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return ($image);
}

	/**
	 * get the image by profile id
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageProfileId image id to search by
	 * @return \SplFixedArray of images found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws \TypeError when variables are no the correct data types
	 */

	public static function getImageByImageProfileId(\PDO $pdo, int $imageProfileId) {
	// sanitize the profile id before searching
	if($imageProfileId <= 0) {
		throw(new \RangeException("image profile id must be positive"));
	}
	//create query template
	$query = "SELECT imageId, imageGenreId, imageProfileId, imageDescription, imageSecureUrl, imagePublicId  FROM image 
		WHERE imageProfileId = :imageProfileId";
	$statement = $pdo->prepare($query);
	//bind the image proile id to the place holder in the template

	$parameters = ["imageProfileId" => $imageProfileId];
	$statement->execute($parameters);

	//build an array of images
	$images = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$image = new Image($row["imageId"], $row["imageGenreId"], $row["imageProfileId"], $row["imageDescription"], $row["imageSecureUrl"],
				$row["imagePublicId"]);

			$images[$images->key()] = $image;
			$images->next();
		} catch(\Exception $exception) {
			//if the row couldnt' be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($images);
}
/**
 * get all images
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray of images found or null if not found
 * @throws \PDOException when mySQL related erros occur
 * @throews \TypeError when variables are no the correct data type
 */
	public static function getAllImages(\PDO $pdo) {
		//create query templates
		$query = "SELECT imageId,  imageGenreId, imageProfileId, imageDescription, imageSecureUrl, imagePublicId
		FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of images
		$images = new \SplFixedArray($statement->rowCount());

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				/*$image = new Image($row["imageId"], $row["imageGenreId"], $row["imageProfileId"], $row["imageDescription"], $row["imageSecureUrl"],
					$row["imagePublicId"] );*/

				$image = new Image($row["imageId"], $row["imageGenreId"], $row["imageProfileId"], $row["imageDescription"], $row["imageSecureUrl"],
					$row["imagePublicId"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
	return ($images);
}

/*
 * formats the state variables for JSON serialization
 * @return array resulting state variables to serialize
 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
}
}









