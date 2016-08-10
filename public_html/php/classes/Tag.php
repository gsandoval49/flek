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
		}
		catch
		(\InvalidArgumentException $invalidArgument)
		{
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
		catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}

/*this is the accessor method for the tagImageId*/
	public function getTagImageId() {
		return($this->tagImageId);
	}
/*this is the mutator method for the tagImageId*/
	public function setTagImageId(int $newTagImageId){
		if($newTagImageId <= 0) {
			throw(new \RangeException ("image id is not positive"));
		}
		/*convert and store the image id*/
		$this->tagImageId = $newTagImageId;
	}
/*  this is the accessor method for tagHashtagId*/
	public function getTagHashtagId(){
		return($this->tagHashtagId);
	}
/*   this is the mutator method for tagHashtagId*/
	public function setTagHashtagId(int $newTagHashtagId){
		if($newTagHashtagId <= 0) {
			throw(new \RangeException ("hashtag id is not positive"));
		}
		/*convert and store the hashtag id*/
		$this->tagHashtagId = $newTagHashtagId;
	}
		/*adds the tag to mySQL*/
		public function insert(\PDO $pdo) {
			//enforce the tagImageId is null
			if($this->tagImageIdId != null) {
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
	/**
	 * formats state variables for JSON serialization
	 *
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}

