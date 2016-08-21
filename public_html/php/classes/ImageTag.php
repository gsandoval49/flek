<?php

namespace Edu\Cnm\Flek;
require_once("autoload.php");

/**
 * imageTag Class
 * @author Rob Harding
 * @ver 1.0.0
 **/

class ImageTag implements \JsonSerializable {
	/**
	 * image id for the image being linked with tags; this is a foreign key
	 * @var int $imageTagImageId
	 **/
	private $imageTagImageId;
	/**
	 * tag id for the tag being linked to the image; this is a foreign key
	 * @var int $imageTagImageId
	 **/
	private $imageTagTagId;

	/**
	 * @param int $newImageTagImageId
	 * @param int $newImageTagTagId
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/

	public function __construct(int $newImageTagImageId, int $newImageTagTagId) {
		try {
			$this->setImageTagImageId($newImageTagImageId);
			$this->setImageTagTagId($newImageTagTagId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for the imageTag imageId
	 *
	 * @return int value of imageTag image id
	 **/
	public function getImageTagImageId() {
		return ($this->imageTagImageId);
	}

	/**
	 * mutator method for the imageTag tagId
	 *
	 * @param int $newImageTagImageId
	 * @throws \RangeException if $newImageTagImageId is not positive
	 * @throws \TypeError if $newImageTagImageId is not an integer
	 **/
	public function setImageTagImageId(int $newImageTagImageId) {
		//verify the image tag id is positive
		if($newImageTagImageId < 0) {
			throw(new \RangeException ("tag id is not positive"));
		}
		//convert and store the image id*
		$this->imageTagImageId = $newImageTagImageId;
	}

	/**
	 * accessor method for imageTag Tagid
	 *
	 * @return int value of imageTag tag id
	**/
	public function getImageTagTagId(){
		return ($this->imageTagTagId);
	}

	/**
	 * mutator method for imageTag TagId
	 *
	 * @param int $newImageTagTagId
	 * @throws \RangeException if  $newImageTagTagId is not positive
	 * @throws \TypeError if $newImageTagTagId is not an integer
	**/
	public function setImageTagTagId(int $newImageTagTagId) {
		//verify id is positive
		if($newImageTagTagId < 0) {
			throw(new \RangeException("tag id is not positive"));
		}
		//convert adn store the tag id
		$this->imageTagTagId = $newImageTagTagId;
	}

	/**
	 * inserts this Tag into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//check tag exists before entering into SQL
		if($this->imageTagImageId === null || $this->imageTagTagId === null) {
			throw(new \PDOException("imageTag not valid"));
		}
		//create query template
		$query = "INSERT INTO imageTag(imageTagImageId, imageTagTagId) VALUES(:imageTagImageId, :imageTagTagId)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["imageTagImageId" => $this->imageTagImageId, "imageTagTagId" => $this->imageTagTagId];
		$statement->execute($parameters);
	}


	/**
	 * deletes this favorite from my SQL
	 *
	 * @param \PDO $pdo PDO connectin object
	 * @throws \PDOException when mySQL related erros occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		//check that tag exists before deleting it
		if($this->imageTagImageId === null || $this->imageTagTagId === null) {
			throw(new \PDOException("unable to delete a ImageTag that does not exist"));
		}
		//create a query template
		$query = "DELETE FROM imageTag WHERE (imageTagImageId = :imageTagImageid AND imageTagTagId = :imageTagTagId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["imageTagImageId" => $this->imageTagImageId, "imageTagTagId" => $this->imageTagTagId];
		$statement->execute($parameters);
	}

	/** gets the tag by tagImageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageTagImageId image id to search for
	 * @return tag|null tag found or null if not found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws |TypeError when variables are not the correct data type
	 **/
	public static function getImageTagByTagImageId(\PDO $pdo, int $imageTagImageId) {
		//sanitize the imageTag ImageId before searching
		if($imageTagImageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}
		// create query templatte
		$query = "SELECT imageTagImageId, imageTagTagId FROM imageTag WHERE imageTagImageId = :imageTagImageId";
		$statement = $pdo->prepare($query);

		//bind the variables to the place holder in teh template
		$parameters = ["imageTagImageId => $imageTagImageId"];
		$statement->execute($parameters);

		//build an arary of image tags
		$imageTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement ->fetch()) !==false) {
			try {
				$imageTag = new imageTag($row["imageTagImageId"], $row["imageTagTagId"]);
				$imageTags[$imageTags->key()] = $imageTag;
				$imageTags->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($imageTags);
	}

	/**
	 * gets the tag by ImageTagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageTagTagId tag id to search for
	 * @return tag|null tag found or null if not found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws |TypeError when variables are not the correct data type
	 **/
	public static function getImageTagByTagId(\PDO $pdo, int $imageTagTagId) {
		//sanitize the ImageTagtagId before searching
		if($imageTagTagId < 0) {
			throw(new \PDOException("Tag Id is not positive"));
		}
		// create query templatte
		$query = "SELECT imageTagImageId, imageTagTagId FROM imageTag WHERE imageTagTagId = :imageTagTagId";
		$statement = $pdo->prepare($query);

		//bind the ImageTagTag Id to theplace holder in teh template
		$parameters = ["imageTagTagId" => $imageTagTagId];
		$statement->execute($parameters);

		//build an array of imageTags tags
		$imageTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$imageTag = new imageTag($row["imageTagImageId"], $row["imageTagTagId"]);
				$imageTags[$imageTags->key()] = $imageTag;
				$imageTags->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($imageTags);
	}

	/**
	 * gets tag by image id and tag id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageTagImageId image id to search for
	 * @param int $imageTagTagId tag id to search for
	 * @return imageTag|null tag if found, null if not
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageTagByImageIdAndTagId(\PDO $pdo, int $imageTagImageId, int $imageTagTagId) {
		//sanitize the image id and the tag id before searching
		if($imageTagImageId < 0) {
			throw (new \PDOException("image id is not positive"));
		}
		if($imageTagTagId < 0) {
			throw (new \PDOException("tag id is not positive"));
		}
		//create a query template
		$query = "SELECT imageTagImageId, imageTagTagId FROM imageTag WHERE imageTagImageId = :imageTagImageId AND imageTagTagId = :imageTagTagId;";
		$statement = $pdo->prepare($query);
		//bind the variables to the placeholders in the template
		$parameters = ["imageTagImageId" => $imageTagImageId, "imageTagTagId" => $imageTagTagId];
		$statement->execute($parameters);
		//grab the image tag from mySQL
		try {
			$imageTag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$imageTag = new imageTag($row["imageTagImageId"], $row["imageTagTagId"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($imageTag);
	}

	/**
	 * formats state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
