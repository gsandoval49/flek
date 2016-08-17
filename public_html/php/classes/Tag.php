<?php

namespace Edu\Cnm\Flek;


require_once("autoload.php");
/**
 *
 *
 * @author Rob Harding
 * @ver 1.0.0
 **/


class Tag implements \JsonSerializable {

	private $tagImageId;

	private $tagHashtagId;

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
		 * this is the accessor method for the tagImageId
		 **/
		public function getTagImageId() {
			return ($this->tagImageId);
		}

		/**
		 * this is the mutator method for the tagImageId
		 **/
		public
		function setTagImageId(int $newTagImageId) {
			if($newTagImageId <= 0) {
				throw(new \RangeException ("image id is not positive"));
			}
			/*convert and store the image id*/
			$this->tagImageId = $newTagImageId;
		}

		/*  this is the accessor method for tagHashtagId*/
		public
		function getTagHashtagId() {
			return ($this->tagHashtagId);
		}

		/*   this is the mutator method for tagHashtagId*/
		public
		function setTagHashtagId(int $newTagHashtagId) {
			if($newTagHashtagId <= 0) {
				throw(new \RangeException ("hashtag id is not positive"));
			}
			/*convert and store the hashtag id*/
			$this->tagHashtagId = $newTagHashtagId;
		}

		/*adds the tag to mySQL*/
		public
		function insert(\PDO $pdo) {
			//enforce the tagImageId is null
			if($this->tagImageId != null) {
				throw(new \PDOException("no new image given"));
			}
			//create query template
			$query = "INSERT INTO TAG(tagImageId, tagHashtagId) VALUES(:tagImageId, :tagHashtagId)";
			$statement = $pdo->prepare($query);
			//bind the member variables to the place holders in the template
			$parameters = ["tagHashtagId" => $this->tagHashtagId, "tagImageId" => $this->tagImageId];
			$statement->execute($parameters);

			// update the null tagHashtagId with what mySQL just gave us
			$this->tagHashtagId = intval($pdo->lastInsertId());
		}


		/*
		 * deletes this favorite from my SQL
		 * @param \PDO $pdo PDO connectin object
		 * @throws \PDOException when mySQL related erros occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public
		function delete(\PDO $pdo) {
			//enforce the tage Id is not null
			if($this->tagHashtagId === null) {
				throw(new \PDOException("unable to delete a hashtag that does not exist"));
			}
			//create a query template
			$query = "DELETE FROM Tag WHERE tagHashtagId = :tagHashtagId";
			$statement = $pdo->prepare($query);

			//bind the member variables to the place holder in the template
			$parameters = ["tagHashtagId" => $this->tagHashtagId];
			$statement->execute($parameters);
		}

		/*
		 * updates this tag in mySQL
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related erros occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public
		function update(\PDO $pdo) {
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
		}

		/*
		 * gets the tag by tagHashtagId
		 * @param \PDO $pdo PDO connection object
		 * @param int $tagHashtagId tagHashtag id to search for
		 * @return tag|null tag found or null if not found
		 * @throws \PDOException when mySQL related erros occur
		 * @throws |TypeError when variables are not the correct data type
		 */
		public
		static function getTagBytagHashtagId(\PDO $pdo, int $tagHashtagId) {
			//sanitize the tagHashtagId before searching
			if($tagHashtagId <= 0) {
				throw(new \PDOException("tagHashtag id is not positive"));
			}
			// create query templatte
			$query = "SELECT tagHashtagId, tagImageId FROM tag WHERE tagHashtagId = :tagHashtagId";
			$statement = $pdo->prepare($query);

			//bind the tagHashtag Id to theplace holder in teh template
			$parameters = ["tagHashtagId => $tagHashtagId"];
			$statement->execute($parameters);

			//grab the tag from mySQL
			try {
				$tag = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$tag = new Tag ($row["tagHashtagId"], $row["tagImageId"]);
				}
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($tag);
		}

		/* gets the tag by tagImageId
	  * @param \PDO $pdo PDO connection object
	  * @param int $tagImageId tagHashtag id to search for
			* @return tag|null tag found or null if not found
	  * @throws \PDOException when mySQL related erros occur
	  * @throws |TypeError when variables are not the correct data type
	  */
		public
		static function getTagByTagImageId(\PDO $pdo, int $tagImageId) {
			//sanitize the tagHashtagId before searching
			if($tagImageId <= 0) {
				throw(new \PDOException("tagHashtag id is not positive"));
			}
			// create query templatte
			$query = "SELECT tagHashtagId, tagImageId FROM tag WHERE tagImageId = :tagImageId";
			$statement = $pdo->prepare($query);

			//bind the tagHashtag Id to theplace holder in teh template
			$parameters = ["tagImageId => $tagImageId"];
			$statement->execute($parameters);

			//grab the tag from mySQL
			try {
				$tag = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$tag = new Tag ($row["tagHashtagId"], $row["tagImageId"]);
				}
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($tag);
		}

		/*
		 * gets all tags
		 * @param \SplFixedArray SplFixedArray of tags found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 */
		public
		static function getAllTags(\PDO $pdo) {
			//create query template
			$query = "SELECT tagHashtagId, tagImageId FROM tag";
			$statement = $pdo->prepare($query);
			$statement->execute();

			//build an array of tags
			$tags = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$tag = new Tag($row["tagId"], $row["tagId"]);
					$tags[$tag->key()] = $tag;
					$tags->next();
				} catch(\Exception $exception) {
					//if the row couldn't be converted rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($tags);
		}

		/**
		 * formats state variables for JSON serialization
		 *
		 *
		 * @return array resulting state variables to serialize
		 **/
		public
		function jsonSerialize() {
			$fields = get_object_vars($this);
			return ($fields);
		}
	}

