<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");

/**
 * @author Rob Harding
 * @ver 1.0.0
 **/


class Tag implements \JsonSerializable {
/**
 * id for image; this is a foreign key
 * @var int $tagImageId
**/
	private $tagImageId;
	/**
	 * id for hashtag; this is a foreign key
	 * @var int $tagHashtagId
	**/

	private $tagHashtagId;

	/**
	 * @param int|null $newTagImageId id of this image or null if a new image
	 * @param int|null $newTagHashtagId id of this hashtag or null if new image
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	**/

	public function __construct(int $newTagImageId = null, int $newTagHashtagId = null) {
		try {
			$this->setTagImageId($newTagImageId);
			$this->setTagHashtagId($newTagHashtagId);
		} catch(\InvalidArgumentException $InvalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($InvalidArgument->getMessage(), 0, $InvalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\ Exception $exception) {
			//rethrow the exception to the caller
			throw (new \Exception($exception->getMessage(), 0, $exception));
		}
	}

		/**
		 * accessor method for the tagImageId
		 *
		 * @return int|null value of tag image id
		 **/
		public function getTagImageId() {
			return ($this->tagImageId);
		}

		/**
		 * mutator method for the tagImageId
		 *
		 * @param int|null $newTagImageId new value of tag image id
		 * @throws \RangeException if $newTagImageId is not positive
		 * @throws \TypeError if $newTagImageId is not an integer
		 **/
		public function setTagImageId(int $newTagImageId) {
			//verify the tweet id is positive
			if($newTagImageId <= 0) {
				throw(new \RangeException ("image id is not positive"));
			}
			//convert and store the image id*
			$this->tagImageId = $newTagImageId;
		}

		/**
		 * accessor method for tagHashtagId
		 *
		 * @return int value of tag hashtag id
		 **/
		public function getTagHashtagId() {
			return ($this->tagHashtagId);
		}

		/**
		 * mutator method for tagHashtagId
		 *
		 * @param int $newTagHashtagId new value of tag hashtag id
		 * @throws \RangeException if $newTagHashtagId is not positive
		 * @throws \TypeError if $newTagHashtagId is not an integer
		 **/
		public function setTagHashtagId(int $newTagHashtagId) {
			//verify the porfile id is positive
			if($newTagHashtagId <= 0) {
				throw(new \RangeException ("hashtag id is not positive"));
			}
			//convert and store the hashtag id
			$this->tagHashtagId = $newTagHashtagId;
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
			if($this->tagImageId === null || $this->tagHashtagId === null) {
				throw(new \PDOException("not a valid tag"));
			}
			//create query template
			$query = "INSERT INTO Tag(tagImageId, tagHashtagId) VALUES(:tagImageId, :tagHashtagId)";
			$statement = $pdo->prepare($query);
			//bind the member variables to the place holders in the template
			$parameters = ["tagHashtagId" => $this->tagHashtagId, "tagImageId" => $this->tagImageId];
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
			if($this->tagImageId === null || $this->tagHashtagId === null) {
				throw(new \PDOException("unable to delete a hashtag that does not exist"));
			}
			//create a query template
			$query = "DELETE FROM Tag WHERE tagImageId = :tagImageId AND tagHashtagId = :tagHashtagId";
			$statement = $pdo->prepare($query);

			//bind the member variables to the place holder in the template
			$parameters = ["tagImageId" => $this->tagImageId, "tagHashtagId" => $this->tagHashtagId];
			$statement->execute($parameters);
		}

	/** gets the tag by tagImageId
	 * @param \PDO $pdo PDO connection object
	 * @param int $tagImageId tagHashtag id to search for
	 * @return tag|null tag found or null if not found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws |TypeError when variables are not the correct data type
	 **/
	public static function getTagByTagImageId(\PDO $pdo, int $tagImageId) {
		//sanitize the tagHashtagId before searching
		if($tagImageId <= 0) {
			throw(new \PDOException("tagHashtag id is not positive"));
		}
		// create query templatte
		$query = "SELECT tagImageId, tagHashtagId FROM tag WHERE tagImageId = :tagImageId";
		$statement = $pdo->prepare($query);

		//bind the tagHashtag Id to theplace holder in teh template
		$parameters = ["tagImageId => $tagImageId"];
		$statement->execute($parameters);

		//build an arary of tags
		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement ->fetch()) !==false) {
			try {
				$tag = new tag($row["tagImageId"], $row["tagHashtagId"]);
				$tags[$tags->key()] = $tag;
				$tags->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tags);
	}

	/**
	 * gets the tag by tagHashtagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tagHashtagId tagHashtag id to search for
	 * @return tag|null tag found or null if not found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws |TypeError when variables are not the correct data type
	 **/
	public static function getTagBytagHashtagId(\PDO $pdo, int $tagHashtagId) {
		//sanitize the tagHashtagId before searching
		if($tagHashtagId <= 0) {
			throw(new \PDOException("Tag Hashtag Id is not positive"));
		}
		// create query templatte
		$query = "SELECT tagImageId, tagHashtagId FROM tag WHERE tagHashtagId = :tagHashtagId";
		$statement = $pdo->prepare($query);

		//bind the tagHashtag Id to theplace holder in teh template
		$parameters = ["tagHashtagId" => $tagHashtagId];
		$statement->execute($parameters);

		//build an array of hashtag tags
		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tag = new tag($row["tagHashtagId"], $row["tagHashtagId"]);
				$tags[$tags->key()] = $tag;
				$tags->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tags);
	}

		/**
		 * updates this tag in mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related erros occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 **/
/*		public function update(\PDO $pdo) {
			//enforce the tagHashtagId is not null
			if($this->tagHashtagId === null) {
				throw(new \PDOException("unable to update a tag that does not exist"));
			}

			//create query template
			$query = "UPDATE tag SET tagHashtagId = :tagHashtagId, tagImageId = :tagImageId";
			$statement = $pdo->prepare($query);

			//bind the member variables to the place holders in the template
			$parameter = ["tagHashtagId" => $this->tagHashtagId, "tagImageId" => $this->tagImageId];
			$statement->execute($parameter);
		}*/

		/**
		 * gets tag by image id and hashtag id
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param int $tagImageId image id to search for
		 * @param int $tagHashtagId hashtag id to search for
		 * @return tag|null tag if found, null if not
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
		public static function getTagByImageIdAndHashtagId(\PDO $pdo, int $tagImageId, int $tagHashtagId) {
			//sanitize the image id and the hashtag id before searching
			if($tagImageId < 0) {
				throw (new \PDOException("beer id is not positive"));
			}
			if($tagHashtagId < 0) {
				throw (new \PDOException("tag id is not positive"));
			}
			//create a query template
			$query = "SELECT tagImageId, tagHashtagId FROM tag WHERE tagImageId = :tagImageId AND tagHashtagId = :tagHashtagId;";
			$statement = $pdo->prepare($query);
			//bind the variables to the placeholders in the template
			$parameters = ["tagImageId" => $tagImageId, "tagHashtagId" => $tagHashtagId];
			$statement->execute($parameters);
			//grab the beer tag from mySQL
			try {
				$tag = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$tag = new tag($row["tagHashtagId"], $row["tagHashtagId"]);
				}
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($tag);
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

