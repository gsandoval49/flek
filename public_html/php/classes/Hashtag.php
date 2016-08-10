<?php
/* find out if this namespace is correct*/
namespace Edu\Cnm\Flek;

require_once("autoload.php");

/**
 * Hashtag class
 *
 * @author Giles Sandoval <gsandoval49@cnm.edu>
 * @version 1.0.0
**/
class Hashtag implements \JsonSerializable {
    use validateDate; // do I need you here??
    /**
     * id of the Hashtag that is created by the tag that has the image
     * this is the primary key
     * @var int $hashtagId
     **/
    private $hashtagId;
    /**
     * name or label of the Hashtag that is attached to the hashtag Id
     * @var string $hashtagName
     **/
    private $hashtagName;

    /**
     * constructor for this Hashtag
     *
     * @param int|null $hashtagId id of this Hashtag or null if new Hashtag
     * @param string $hashtagName string containing data
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
    **/
    public function __construct(int $hashtagId = null, string $hashtagName) {
        try {
            $this->setHashtagId($newHashtagId);
            $this->setHashtagName($newHashtagName);
        } catch(\InvalidArgumentException $invalidArgument) {
            // rethrow the exception to the caller
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            // rethrow the exception to the caller
            throw(new \RangeException($range->getMessage(), 0, $range));
        } catch(\TypeError $typeError) {
            // rethrow the exception to the caller
            throw(new \TypeError($typeError->getMessage(), 0, $typeError));
        } catch(\Exception $exception) {
            // rethrow the exception to the caller
            throw(new \Exception($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for hashtag id
     *
     * @return int|null value of hashtag id
     **/
    public function getHashtagId() {
        return($this->hashtagId);
    }

    /**
     * mutator method for hashtag id
     *
     * @param int|null $newHashtagId
     * @throws \RangeException if $newHashtagId is not positive
     * @throws \TypeError if $newHashtagId is not an interger
    **/
    public function setHashtagId(int $newHashtagId = null) {
        // base case: if the hashtag id is null, this a new hashtag without a mySQL assigned id (yet)
        if($newHashtagId === null) {
            $this->hashtagId = null;
            return;
        }

        // verify the hashtag id is positive
        if($newHashtagId <= 0) {
            throw(new \RangeException("hashtag id is not positive"));
        }

        // convert and store the hashtag id
        $this->hashtagId = $newHashtagId;
    }

    /**
     * accessor method for hashtag name
     *
     * @return string value of hashtag name
     **/
    public function getHashtagName() {
        return($this->hashtagName);
    }

    /**
     * mutator method for hashtag name
     *
     * @param string $newHashtagName new value of hashtag name
     * @throws \InvalidArgumentException if $newHashtagName is not a string or insecure
     * @throws \RangeException if $newHashtagName is > 32 characters
     * @throws \TypeError if $newHashtagName is not a string
     **/
    public function setHashtagName(string $newHashtagName) {
        // verify the hashtag string is secure
        $newHashtagName = trim($newHashtagName);
        $newHashtagName = filter_var($newHashtagName, FILTER_SANITIZE_STRING);
        if(empty($newHashtagName) === true) {
            throw(new \InvalidArgumentException("hashtag name is empty or insecure"));
        }

        // verify the hashtag name will fit in the database
        if(strlen($newHashtagName) > 32) {
            throw(new \RangeException("hashtag name is too large"));
        }

        // store the hashtag name
        $this->hashtagName = $newHashtagName;
    }

    /**
     * inserts this Hashtag into mySQL
     *
     *@param \Pdo $pdo PDO connection object
     *@throws \PDOException when mySQL related errors occur
     *@throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) {
        // enforce the hashtagId is null (i.e., don't insert a Hashtag id that already exists)
        if($this->hashtagId !== null) {
            throw(new \PDOException("not a new hashtag"));
        }

        // create query template
        $query = "INSERT INTO hashtag(hashtagId, hashtagName) VALUES(:hashtagId, :hashtagName)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // CHECK TO SEE IF THIS CODE NEEDS TO BE IN HERE. AND ALSO DELETED TEH $formattedDate
        $parameters = ["hashtagId" => $this->hashtagId, "hashtagName" => $this->hashtagName];
        $statement->execute($parameters);

        // update the null hashtagId with what mySQL just gave us
        $this->hashtagId = intval($pdo->lastInsertId());
    }

    /**
     * deletes this Hashtag from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) {
        // enforce the hashtagId is not null (i.e., don't delete a hashtag that hasn't been inserted)
        if($this->hashtagId ===null) {
            throw(new \PDOException("unable to delete a hashtag that does not exist"));
        }

        // create query template
        $query = "DELETE FROM hashtag WHERE hashtagId = :hashtagId";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holder in the template
        $parameters = ["hashtagId" => $this->hashtagId];
        $statement->execute($parameters);
    }

    /**
     * updates this Hashtag in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) {
        // enforce the hashtagId is not null (i.e., don't update a hashtag that hasn't been inserted)
        if($this->hashtagId === null) {
            throw(new \PDOException("unable to update a hashtag that does not exist"));
        }

        // create query template
        $query = "UPDATE hashtag SET hashtagId = :hashtagId, hashtagName = :hashtagName";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        // deleted the formatted date from the example
        $parameters = ["hashtagId" => $this->hashtagId, "hashtagName" => $this->hashtagName];
        $statement->execute($parameters);
    }

    /**
     * gets the Hashtag by name
     *
     * @param \PDO $pdo PDO connection object
     * @param string $hashtagName hashtag name to search for
     * @return \SplFixedArray SplFixedArray of Hashtags found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getHashtagByHashtagName(\PDO $pdo, string $hashtagName){
        // sanitize the description before searching
        $hashtagName = trim($hashtagName);
        $hashtagName = filter_var($hashtagName, FILTER_SANITIZE_STRING);
        if(empty($hashtagName) === true) {
            throw(new \PDOException("hashtag name is invalid"));
        }

        // create query template
        $query = "SELECT hashtagId, hashtagName FROM hashtag WHERE hashtagName LIKE :hashtagName";
        $statement = $pdo->prepare($query);

        // bind the hashtag name to the place holder in the template
        $hashtagName = "%$hashtagName%";
        $parameters = ["hashtagName" => hashtagName];
        $statement->execute($parameters);

        // build an array of hashtags
        $hashtags = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $hashtag = new Hashtag($row["hashtagId"], $row["hashtagName"]);
                $hashtags[$hashtags->key()] = $hashtag;
                $hashtags->next();
            } catch(\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(),0, $exception));
            }
        }
        return($hashtags);
    }

    /**
     * gets the Hashtag by hashtagId
     *
     * @param \PDO $pdo PDO connection object
     * @param int $hashtagId hashtag id to search for
     * @return Hashtag|null Hashtag found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getHashtagByHashtagId(\PDO $pdo, int $hashtagId) {
        // sanitize the hashtagId before searching
        if($hashtagId <= 0) {
            throw(new \PDOException("hashtag id is not positive"));
        }

        // create query template
        $query = "SELECT hashtagId, hashtagName FROM hashtag WHERE hashtagId = :hashtagId";
        $statement = $pdo->prepare($query);

        // bind the hashtag id to the place holder in the template
        $parameters = ["hashtagId" => $hashtagId];
        $statement->execute($parameters);

        // grab the hashtag from mySQL
        try {
            $hashtag = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $hashtag = new Hashtag($row["hashtagId"], $row["hashtagName"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($hashtag);
    }

    /**
     * gets all Hashtags
     *
     * @param \PDO $pdo PDO connection object
     * @return \SplFixedArray SplFixedArray of Hashtags found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getAllHashtags(\PDO $pdo) {
        // create query template
        $query = "SELECT hashtagId, hashtagName FROM hashtag";
        $statement = $pdo->prepare($query);
        $statement->execute();

        // build an array of Hashtags
        $hashtags = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !==false) {
            try {
                $hashtag = new Hashtag($row["hashtagId"], $row["hashtagName"]);
                $hashtags[$hashtags->key()] = $hashtag;
                $hashtags->next();
            } catch(\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($hashtags);
    }

    /**
     * Specify data which should be serialized to JSON serialization
     *
     * @return array resulting state variable to serialize
     **/
    public function jsonSerialize() {
        $fields = get_object_vars($this);
        return($fields);
    }
}

?>