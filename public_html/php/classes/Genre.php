<?php

namespace Edu\Cnm\Flek;

require_once("autoload.php");

/**
 * cross section of a genre
 *
 * This Genre can be considered a small example of classifying an image within out Flek application.
 *
 * @author Christina Sosa <csosa4@cnm.edu>
 * @version 1.0.0
**/
class Genre implements \JsonSerializable {

	/**
	 * id for the genre is the primary key
	 * @var int $genreId
	 **/
private $genreId;

	/**
	 * name of genre for this image
	 * @var string $genreName
	**/
private $genreName;

	/**
	 * constructor for this Genre
	 *
	 * @param int|null $newGenreId id of this genre or null if a new genre
	 * @param string $newGenreName string containing actual genre data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newGenreId = null, string $newGenreName) {
			try {
				$this->setGenreId($newGenreId);
				$this->genreName($newGenreName);
		} catch(\InvalidArgumentException $invalidArgument)
			{
				//rethrow the exception to the caller
				throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
			} catch(\RangeException $range) {
				//rethrow the exception to the caller
				throw(new \RangeException($range->getMessage(), 0, $range));
			} catch (\TypeError $typeError) {
				//rethrow the exception to the caller
				throw(new \TypeError($typeError->getMessage(), 0, $typeError));
			} catch(\Exception $exception) {
					//rethrow the exception to the caller
					throw(new \Exception($exception->getMessage(), 0, $exception));
				}
	}

	/**
	 * accessor method for genre id
	 *
	 * @return int|null value of genre id
	**/
	public function getGenreId() {
		return($this->genreId);
	}

	/**
	 * mutator method for genre id
	**/
}


