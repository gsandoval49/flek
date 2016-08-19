<?php
namespace Edu\Cnm\Flek;

require_once("autoload.php");
/**
 * This favorite can be considered a small example of what could be stored when profiles
 *
 * @author Diane Peshlakai <dpeshlakai3@cnm.edu>
 * @version 1.0.0
 **/
class Favorite implements \JsonSerializable {
	/**
	 *
	 * id for Favorite when profile can favorite the profile and identify the profile
	 *  this is the foreign key
	 * @var int $favoriteeId
	 **/
	private $favoriteeId;
	/**
	 * int $favoriterId
	 * id for the favorite the profile can favorite vice versa
	 * this is a foreign key
	 **/
	private $favoriterId;

	/**
	 * constructor for favorite
	 * @param int|null $newFavoriteeId
	 * @param int|null $newFavoriterId
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \Exception is some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 **/
	public function __construct(int $newFavoriteeId = null, int $newFavoriterId = null) {
		try {
			$this->setFavoriteeId($newFavoriteeId);
			$this->setFavoriterId($newFavoriterId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow exception to caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow exception to caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow regular exception to caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/*
	 * accessor method for favoritee id
	 * @return int|null value of favoritee id
	 */
	public function getFavoriteeId() {
		return ($this->favoriteeId);
	}

	/*
	 * mutator method for favoritee id
	 * @param int}null $newFavoriteeId new value of favoritee id
	 * @throws \RangeException if $newFavoriteeId is not positive
	 * @throws \Exception if $newFavoriteeId is not valid
	 */
	public function setFavoriteeId(int $newFavoriteeId = null) {
		//if the favoritee id is null this a new favoritee given by sender
		if($newFavoriteeId === null) {
			throw(new \InvalidArgumentException("favoritee cannot be null"));

		}
		//verify the favoritee id is positive
		if($newFavoriteeId <= 0) {
			throw(new \RangeException("favoritee Id is not positive"));
		}
		//convert and store the favoritee id
		$this->favoriteeId = $newFavoriteeId;
	}

	/*
	 * accessor method for favoriter id
	 * @return int|null value of favoriter id
	 */
	public
	function getFavoriterId() {
		return ($this->favoriterId);
	}

	/*
	 * mutator method for favoriter id
	 * @param int|null $newFavoriter new value of favoriter id
	 * @throws \InvalidArgument if $newFavoriter is not valid
	 */
	public
	function setFavoriterId(int $newFavoriterId = null) {
		//verify the favoriter id is true
		if($newFavoriterId === null) {
			throw(new \InvalidArgumentException("favoriter cannot be null"));

		}
		//verify the favoriter id is positive
		if($newFavoriterId <= 0) {
			throw(new \RangeException("favoriter is not positive"));

		}
		//convert and store the favoriter id
		$this->favoriterId = $newFavoriterId;
	}

	/*
	 * inserts this Favorite into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException wheny mySQL related errors
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public
	function insert(\PDO $pdo) {
		//enforce the favoriteeId is null
		if($this->favoriteeId !== null)
		{
			throw(new \PDOException("this is not a new favorite id"));
		}
		//create query template
		$query = "INSERT INTO favorite(favoriteeId, favoriterId) VALUES(:favoriteeId, :favoriterId)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["favoriteeId" => $this->favoriteeId, "favoriterId" => $this->favoriterId];
		$statement->execute($parameters);

		// update the null favoriteeId with what mySQL just gave us
		$this->favoriteeId = intval($pdo->lastInsertId());
	}
	//added another for favoriterId


	/*
	 * deletes this favorite from my SQL
	 * @param \PDO $pdo PDO connectin object
	 * @throws \PDOException when mySQL related erros occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public
	function delete(\PDO $pdo) {
		//enforce the favoritee Id is not null
		if($this->favoriteeId !== null) {
			throw(new \PDOException("unable to delete a favoritee that does not exist"));
		}
		//create a query template
		$query = "DELETE FROM favorite WHERE favoriteeId = :favoriteeId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["favoriteeId" => $this->favoriteeId];
		$statement->execute($parameters);
	}

	/*
	 * updates this Favorite in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related erros occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public
	function update(\PDO $pdo) {
		//enforce the favoriteeId is not null
		if($this->favoriteeId === null || $this->favoriterId === null) {
			throw(new \PDOException("unable to update a favorite that does not exist"));
		}

		//create query template
		$query = "UPDATE favorite SET favoriteeId = :favoriteeId, favoriterId = :favoriterId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameter = ["favoriteeId" => $this->favoriteeId, "favoriterId" => $this->favoriterId];
		$statement->execute($parameter);
	}

	/*
	 * gets the favorite by favoriteeId
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteeId favoritee id to search for
	 * @return favorite|null favorite found or null if not found
	 * @throws \PDOException when mySQL related erros occur
	 * @throws |TypeError when variables are not the correct data type
	 */
	public
	static function getFavoriteByFavoriteeId(\PDO $pdo, int $favoriteeId) {
		//sanitize the favoriteeId before searching
		if($favoriteeId <= 0) {
			throw(new \PDOException("favoritee id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteeId, favoriterId FROM favorite WHERE favoriteeId = :favoriteeId";
		$statement = $pdo->prepare($query);

		//bind the favoritee Id to the place holder in teh template
		$parameters = ["favoriteId => $favoriteeId"];
		$statement->execute($parameters);

		//grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite ($row["favoriteeId"], $row["favoriterId"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($favorite);
	}

	/* gets the favorite by favoriterId
  * @param \PDO $pdo PDO connection object
  * @param int $favoriterId favoritee id to search for
		* @return favorite|null favorite found or null if not found
  * @throws \PDOException when mySQL related erros occur
  * @throws |TypeError when variables are not the correct data type
  */
	public
	static function getFavoriteByFavoriterId(\PDO $pdo, int $favoriterId) {
		//sanitize the favoriteeId before searching
		if($favoriterId <= 0) {
			throw(new \PDOException("favoritee id is not positive"));
		}
		// create query templatte
		$query = "SELECT favoriteeId, favoriterId FROM favorite WHERE favoriterId = :favoriterId";
		$statement = $pdo->prepare($query);

		//bind the favoritee Id to theplace holder in teh template
		$parameters = array("favoriterId => $favoriterId");
		$statement->execute($parameters);

		//grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite ($row["favoriteeId"], $row["favoriterId"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($favorite);
	}


	 ///get Favoritee Id by Favoriter Id
	/**
	 * gets the reviewTag by both review id and tag id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoritee id to search for
	 * @param int $favoriter id to search for
	 * @return favoriteeId || favoriterId|null reviewTag if found or null if not
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not of the correct data type
	 * *//
	public static function getFavoriteByFavoriteeIdByFavoriterId(\PDO $pdo, int $favoriteeId, int $favoriterId) {
		//sanitize the profileId before searching
		if($favoriteeId < 0) {
			throw(new \PDOException("review id is not positive"));
		}
		if($favoriterId < 0) {
			throw(new \PDOException("tag is is not positive"));


			//create a query template
			$query = "SELECT favoriteeId, favoriterId FROM favorite WHERE favoriteeId = :favoriteeId AND favoriterId = :favoriterId";
			$statement = $pdo->prepare($query);

			//bind the profileId to the place holder in the template
			$parameters = array("favoriteeId" => $favoriteeId, "favoriterId" => $favoriterId);
			$statement->execute($parameters);

			//grab the reviewTag from mySQL
			try {
				$favorite = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$favorite = new Favorite($row["favoriteeId"], $row["favoriterId"]);
				}
			} catch(\Exception $exception) {
				//if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($favorite);

		}




	/*
	 * gets all Favorites
	 * @param \SplFixedArray SplFixedArray of Favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllFavorites(\PDO $pdo) {
		//create query template
		$query = "SELECT favoriteeId, favoriterId FROM favorite";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteeId"], $row["favoriterId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}

	/*
	 * formats the state variables for JSON serialization
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}

