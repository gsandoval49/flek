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
	 *
	 * @param int|null $newGenreId new value of genre id
	 * @throws \RangeException if $newGenreId is not positive
	 * @throws \TypeError if $newGenreId is not an integer
	**/
	public function setGenreId(int $newGenreId = null) {
		//base case: if the genre id is null, this is a new genre without a mySQL assigned id (yet)
		if($newGenreId === null) {
			$this->genreId = null;
			return;
		}

		//verify the genre id is positive
		if($newGenreId <= 0) {
			throw(new \RangeException("genre id is not positive"));
		}

		//convert and store the genre id
		$this->genreId = $newGenreId;
	}

	/**
	 * accessor method for genre name
	 *
	 * @return string value of genre name
	 **/
	public function getGenreName() {
		return($this->genreName);
	}

	/**
	 *mutator method for genre name
	 *
	 * @param string $newGenreName new value of genre name
	 * @throws \InvalidArgumentException if $newGenreName is not a string or insecure
	 * @throws \RangeException is $newGenreName is > 32 characters
	 * @throws \TypeError if $newGenreName is not a string
	**/
	public function setGenreName(string $newGenreName) {
		//verify the genre name is secure
		$newGenreName = trim($newGenreName);
		$newGenreName = filter_var($newGenreName, FILTER_SANITIZE_STRING);
		if(empty($newGenreName) === true) {
			throw(new \InvalidArgumentException("genre name is empty or insecure"));
		}
		//verify the genre name will fit into the database
		if(strlen($newGenreName) > 140) {
			throw(new \RangeException("genre name too large"));
		}
		//store the genre name
		$this->genreName = $newGenreName;
	}

	/**
	 * inserts this Genre into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo id not a PDO connection object
	**/
public function insert(\PDO $pdo) {
		//enforce the genreId is null (i.e., don't insert a genre that already exists)
		if($this->genreId !== null) {
			throw(new \PDOEXCEPTION("not a new genre"));
		}

		//create a query template
		$query = "INSERT INTO genre(genreId, genreName) VALUES(:genreId, :genreName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["genreId" => $this->genreId, "genreName" => $this->genreName];
		$statement->execute($parameters);

		//update the null genreId with what mySQL just gave us
		$this->genreId = intval($pdo->lastInsertId());
		}

/**
 * deletes this Genre from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
**/
public function delete(\PDO $pdo) {
	//enforce the genreId is not null (i.e., don't delete a genre that hasn't been inserted)
	if($this->genreId ===null) {
		throw(new \PDOException("unable to delete a genre that does not exist"));
	}

	//create query template
	$query = "DELETE FROM genre WHERE genreId = :genreId";
	$statement = $pdo->prepare($query);

	//bind the member variables to the place holder in the template
	$parameters = ["genreId" => $this->genreId];
	$statement->execute($parameters);
}

/**
 * updates this genre in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
**/
public function update(\PDO $pdo) {
	//enforce the genreId is not null (i.e., don't update a genre that hasn't been inserted)
	if($this->genreId ==== null) {
		throw(new \PDOException("unable to update a genre that does not exist"));
	}

	//create a query template
	$query = "UPDATE genre SET genreId = :genreId, genreName = :genreName";
	$statement = $pdo->prepare($query);

	//bind the number of variables to the place holders in the template
	$parameters = ["genreId" => $this->genreId, "genreName" => $this->genreName];

	$statement->execute($parameters);
}

/**
 * gets the genre by id
 *
 * @param \PDO $pdo PDO connection object
 * @param int $genreid genre id to search by
 * @return \SplFixedArray SplFixedArray of genre found
 * @throws \PDOException when mySQL realted errors occur
 * @throws \TypeError when variables are not the correct data type
**/
pubic static function getGenrebyGenreId(\Pdo $pdo, int $genreId) {
	//sanitize the genre id before searching
	if(genreId <= 0) {
		throw(new \RangeException("genre id must be positive"));
	}

	//create query template
	$query = "SELECT genreId, genreName FROM genre WHERE genreId = :genreId";
	$statement = $pdo->prepare($query);

	//bind the genre id ot the place holder in the template
	$parameters = ["genreId => $genreId"];
	$statement->execute($parameters);

	//build an array of genres
	$genres = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$genre = new Genre($row["genreId"], $row["genreName"]);
			$genres[$genres->key()] = $genre;
			$genres->next();
		} catch(\Exception $exception) {
			//if the row couldn't be converted rethrow it
			throw(new \PDOException($exceptoin->getMessage(), 0, $exception));
		}
	}
	return($genres);
}


} //last line


